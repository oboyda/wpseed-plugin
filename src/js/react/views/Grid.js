import React, { Component } from 'react';
import Utils from '../Utils';
import View from './View';
import Tile from './Tile';
import TileOptions from './TileOptions';
import GridSetup from './GridSetup';

class Grid extends View 
{
    constructor(props)
    {
        super(props, {
            app: null,
            gridSizeX: 0,
            gridSizeY: 0
        }, {
            set_state: true
        });

        this.cellInit = {
            tileId: null,
            tile: null,
            filled: false
        };

        this.state = {
            gridConfig: [],
            cellSize: 0,
            gridSizeX: 0,
            gridSizeY: 0
        };

        this.domRef = React.createRef();

        this.handleAddTile = this.handleAddTile.bind(this);
        this.handleOpenGridSetup = this.handleOpenGridSetup.bind(this);
    }

    _componentDidMount()
    {
        this.initGridSetup();

        Utils.subscribeToEvent('grid__add_tile', this.handleAddTile);
        Utils.subscribeToEvent('grid__open_grid_setup', this.handleOpenGridSetup);
    }

    _componentWillUnmount()
    {
        Utils.unsubscribeFromEvent('grid__add_tile', this.handleAddTile);
        Utils.unsubscribeFromEvent('grid__open_grid_setup', this.handleOpenGridSetup);
    }

    /*
    * Event handlers
    * ------------------------------
    */

    handleAddTile(e)
    {
        const detail = e.detail;
        this.placeTile(detail.gridX, detail.gridY, detail.tileConfig);
    }

    handleOpenTileOptions(gridX, gridY)
    {
        this.app.toolsBarOpen(
            <TileOptions app={this.app} gridX={gridX} gridY={gridY} />
        );
    }

    handleOpenGridSetup()
    {
        this.openGridSetup();
    }

    /*
    * Setters
    * ------------------------------
    */

    initGridSetup()
    {
        if(!(this.gridSizeX && this.gridSizeY))
        {
            this.openGridSetup();
        }

        this.setGridSize(this.getSizeMinX(), this.getSizeMinY());
    }

    setGridSize(sizeX, sizeY)
    {
        let gridConfig = [];

        for(let y=0; y < sizeY; y++){
            gridConfig[y] = [];
            for(let x=0; x < sizeX; x++){
                gridConfig[y][x] = Utils.cloneObject(this.cellInit);
            }
        }

        this._setState({
            gridConfig: gridConfig,
            gridSizeX: sizeX,
            gridSizeY: sizeY
        });

        this.setCellSize();
    }

    setCellSize()
    {
        const cellSize = Math.round(this.domRef.current.offsetWidth / this.gridSizeX);
        this._setState({
            cellSize: cellSize
        });
    }

    placeTile(gridX, gridY, tile)
    {
        const tileView = (tile instanceof Tile) ? tile : new Tile({
            ...tile,
            gridTile: true,
            cellSize: this.state.cellSize,
            grid: this,
            app: this.app
        });

        // Set tile grid coordinates
        tileView._setProps({
            gridX: gridX,
            gridY: gridY
        });

        // Update gridConfig
        const rotationConfig = tileView.getRotationConfig();

        const avail = this.isPlacementAvailable(gridX, gridY, tileView);
        const gridConfig = this.state.gridConfig;

        if(avail && rotationConfig)
        {
            // Remove previous tile config from grid if exist
            this.removeTile(tileView.id);

            // Save new tile data
            gridConfig[gridY][gridX].tileId = tileView.id;
            gridConfig[gridY][gridX].tile = tileView._props;

            rotationConfig.forEach((row, ri) => {
                row.forEach((cell, ci) => {
                    const _ri = gridY+ri;
                    const _ci = gridX+ci;

                    if(cell)
                    {
                        gridConfig[_ri][_ci].tileId = tileView.id;
                        gridConfig[_ri][_ci].filled = true;
                    }
                });
            });

            this.setState({
                gridConfig: gridConfig
            }, () => {
                Utils.dispatchEvent('grid__updated', { tile: tileView });
            });
        }
    }

    removeTile(tileId, detach=false)
    {
        let detachedTile = null;
        let removed = false;

        const gridConfig = this.state.gridConfig;

        gridConfig.forEach((row, ri) => {
            row.forEach((cell, ci) => {
                if(cell.tileId === tileId)
                {
                    if(detach)
                    {
                        detachedTile = cell.tile;
                    }

                    gridConfig[ri][ci] = Utils.cloneObject(this.cellInit);
                }
            });
        });

        this._setState({
            gridConfig: gridConfig
        });

        return detach ? detachedTile : removed;
    }

    detachTile(tileId)
    {
        return this.removeTile(tileId, true);
    }

    /*
    * Getters and helpers
    * ------------------------------
    */

    openGridSetup()
    {
        this.app.modalOpen({
            headerTitle: indexVars.strings.gridSetup.grid_size.group_title,
            bodyContent: <GridSetup app={this.app} grid={this} />
        });
    }

    isPlacementAvailable(gridX, gridY, tile, tileRotation=0)
    {
        const tileView = (typeof tile === 'string') ? new Tile({ type: tile, rotation: tileRotation }) : tile;

        const rotationConfig = tileView.getRotationConfig();

        let avail = true;

        if(rotationConfig)
        {
            rotationConfig.forEach((row, ri) => {

                if(!avail)
                {
                    return;
                }

                row.forEach((cell, ci) => {

                    if(!avail || !cell)
                    {
                        return;
                    }

                    const _ri = gridY+ri;
                    const _ci = gridX+ci;

                    const gridCell = (typeof this.state.gridConfig[_ri] !== 'undefined' && typeof this.state.gridConfig[_ri][_ci] !== 'undefined') ? this.state.gridConfig[_ri][_ci] : null;

                    if(
                        !gridCell
                        || (gridCell.filled && gridCell.tileId !== tileView.id)
                    ){
                        avail = false;
                    }
                });
            });
        }

        return avail;
    }

    getTileSize()
    {
        return indexVars.grid_size.tile_size;
    }

    getSizeMinX(tiles=true)
    {
        return tiles ? indexVars.grid_size.tiles_min_x: (indexVars.grid_size.tiles_min_x * this.getTileSize());
    }

    getSizeMinY(tiles=true)
    {
        return tiles ? indexVars.grid_size.tiles_min_y : (indexVars.grid_size.tiles_min_y * this.getTileSize());
    }

    getSizeMaxX(tiles=true)
    {
        return tiles ? indexVars.grid_size.tiles_max_x : (indexVars.grid_size.tiles_max_x * this.getTileSize());
    }

    getSizeMaxY(tiles=true)
    {
        return tiles ? indexVars.grid_size.tiles_max_y : (indexVars.grid_size.tiles_max_y * this.getTileSize());
    }

    getSizeX(tiles=true)
    {
        return tiles ? this.state.gridSizeX : (this.state.gridSizeX * this.getTileSize());
    }

    getSizeY(tiles=true)
    {
        return tiles ? this.state.gridSizeY : (this.state.gridSizeY * this.getTileSize());
    }

    render()
    {
        return (
            <div className={this.getViewClass()} ref={this.domRef}>
                {this.state.gridConfig.map((row, y) => {
                    return (
                        <div className={`grid-row row-${y}`} key={`${y}`}>
                            {row.map((cell, x) => {

                                let cellClasses = ['grid-cell', 'cell-' + y + '-' + x];
                                let tileElem = null;

                                if(cell.tileId)
                                {
                                    cellClasses.push(cell.tileId);
                                }
                                if(cell.tile)
                                {
                                    tileElem = React.createElement(Tile, {
                                        ...cell.tile,
                                        key: cell.tile.id
                                    });
                                    cellClasses.push("tile-root");
                                }
                                if(cell.filled)
                                {
                                    cellClasses.push("filled");
                                }

                                return (
                                    <div 
                                        key={`${x}-${y}`} 
                                        className={cellClasses.join(' ')} 
                                    >
                                        {/* <span className="c">{`${x}:${y}`}</span> */}
                                        {tileElem}
                                        <span className="h" onClick={() => { this.handleOpenTileOptions(x, y); }}></span>
                                    </div>
                                );
                            })}
                        </div>
                    )
                })}
            </div>
        );
    }
}

export default Grid;
