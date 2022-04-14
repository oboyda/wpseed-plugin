import React, { Component } from 'react';
import Utils from '../Utils';
import View from './View';
import Tile from './Tile';
import TileOptions from './TileOptions';

class Grid extends View 
{
    constructor(props)
    {
        super(props, {
            app: null,
            gridSizeX: 25,
            gridSizeY: 25
        }, {
            // set_state: true
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

        this.eventAddTile = this.eventAddTile.bind(this);
        // this.handleOpenTileOptions = this.handleOpenTileOptions.bind(this);
    }

    _componentDidMount()
    {
        this.setGridSize(this.gridSizeX, this.gridSizeY);
        this.setCellSize();

        Utils.subscribeToEvent('grid__add_tile', this.eventAddTile);
    }

    _componentWillUnmount()
    {
        Utils.unsubscribeFromEvent('grid__add_tile', this.eventAddTile);
    }

    eventAddTile(e)
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
            sizeX: sizeX,
            sizeY: sizeY
        });
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
        const rotationConfig = tileView.getTypeRotationConfig();

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

    isPlacementAvailable(gridX, gridY, tile, tileRotation=0)
    {
        const tileView = (typeof tile === 'string') ? new Tile({ type: tile, rotation: tileRotation }) : tile;

        const rotationConfig = tileView.getTypeRotationConfig();

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

    render()
    {
        return (
            <div className='view grid' ref={this.domRef}>
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
                                        <span className="c">{`${x}:${y}`}</span>
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
