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
            gridSizeY: 25,
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
            cellSize: 0
        };

        this.domRef = React.createRef();

        this.eventPlaceTile = this.eventPlaceTile.bind(this);
        // this.handleOpenTileOptions = this.handleOpenTileOptions.bind(this);
    }

    _componentDidMount()
    {
        this.setGridConfig(this.gridSizeX, this.gridSizeY);
        this.setCellSize();

        Utils.subscribeToEvent('grid__place_tile', this.eventPlaceTile);
    }

    _componentWillUnmount()
    {
        Utils.unsubscribeFromEvent('grid__place_tile', this.eventPlaceTile);
    }

    eventPlaceTile(e)
    {
        const detail = e.detail;
        this.placeTile(detail.gridX, detail.gridY, detail.tileConfig);
    }

    handleOpenTileOptions(gridX, gridY)
    {
        // this.app.modalOpen(
        //     indexVars.translations.tileOptions.title, 
        //     <TileOptions app={this.app} gridX={gridX} gridY={gridY} />
        // );
        this.app.toolsBarOpen(
            <TileOptions app={this.app} gridX={gridX} gridY={gridY} />
        );
    }

    setGridConfig(sizeX, sizeY)
    {
        let gridConfig = [];

        for(let y=0; y < sizeY; y++){
            gridConfig[y] = [];
            for(let x=0; x < sizeX; x++){
                gridConfig[y][x] = Utils.cloneObject(this.cellInit);
            }
        }

        this._setState({
            gridConfig: gridConfig
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
        const tileElem = (tile instanceof Tile) ? tile : new Tile({
            ...tile,
            gridTile: true,
            cellSize: this.state.cellSize,
            grid: this,
            app: this.app
        });

        // Set tile grid coordinates
        tileElem._setProps({
            gridX: gridX,
            gridY: gridY
        });

        // Remove previous tile config from grid if exist
        this.removeTile(tileElem.id);

        // Update grid config
        const rotationConfig = tileElem.getTypeRotationConfig();

        const avail = this.isPlacementAvailable(gridX, gridY, tileElem);
        const gridConfig = Utils.cloneObject(this.state.gridConfig);

        if(avail && rotationConfig)
        {
            gridConfig[gridY][gridX].tileId = tileElem.id;
            gridConfig[gridY][gridX].tile = tileElem.getProps();

            rotationConfig.forEach((row, ri) => {
                row.forEach((cell, ci) => {
                    const _ri = gridY+ri;
                    const _ci = gridX+ci;

                    if(cell)
                    {
                        gridConfig[_ri][_ci].tileId = tileElem.id;
                        gridConfig[_ri][_ci].filled = true;
                    }
                });
            });
            
            this._setState({
                gridConfig: gridConfig
            });
        }
    }

    removeTile(tileId, detach=false)
    {
        let detachedTile = null;
        let removed = false;

        const gridConfig = Utils.cloneObject(this.state.gridConfig);

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

    isPlacementAvailable(gridX, gridY, tileType, tileRotation=0, skipTileId)
    {
        const tileElem = (typeof tileType === 'string') ? new Tile({ type: tileType, rotation: tileRotation }) : tileType;

        const rotationConfig = tileElem.getTypeRotationConfig();

        let avail = true;        

        if(rotationConfig)
        {
            rotationConfig.forEach((row, ri) => {
                row.forEach((cell, ci) => {
                    const _ri = gridY+ri;
                    const _ci = gridX+ci;

                    if(!cell)
                    {
                        return;
                    }

                    const gridCell = (typeof this.state.gridConfig[_ri] !== 'undefined' && typeof this.state.gridConfig[_ri][_ci]) ? this.state.gridConfig[_ri][_ci] : null;

                    // if(!(
                    //     typeof this.state.gridConfig[_ri] !== 'undefined' 
                    //     && typeof this.state.gridConfig[_ri][_ci] !== 'undefined' 
                    //     && !this.state.gridConfig[_ri][_ci].filled
                    // )){
                    if(gridCell && gridCell.filled)
                    {
                        avail = false;

                        if(typeof skipTileId !== 'undefined' && gridCell.tileId === skipTileId)
                        {
                            avail = true;
                        }
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
                                    tileElem = React.createElement(Tile, cell.tile);
                                    cellClasses.push("tile-root");
                                }
                                if(cell.filled)
                                {
                                    cellClasses.push("filled");
                                }

                                return (
                                    <div 
                                        key={`${y}-${x}`} 
                                        className={cellClasses.join(' ')} 
                                    >
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
