// import React, { Component } from 'react';
import View from './View';
import Utils from '../Utils';

class TileEdit extends View 
{
    constructor(props)
    {
        super(props, {
            app: null,
            grid: null,
            tile: null
        }, {
            // set_state: true
        });

        this.state = {
            // tile: this.props.tile
        };

        this.handleUpdateTile = this.handleUpdateTile.bind(this);
        // this.handleToolRotate = this.handleToolRotate.bind(this);
        this.handleToolRotateLeft = this.handleToolRotateLeft.bind(this);
        this.handleToolRotateRight = this.handleToolRotateRight.bind(this);
        this.handleToolMove = this.handleToolMove.bind(this);
        this.handleToolSetColor = this.handleToolSetColor.bind(this);
        this.handleToolRemove = this.handleToolRemove.bind(this);
    }

    _componentDidMount()
    {
        Utils.subscribeToEvent('tile__mounted', this.handleUpdateTile);
    }

    _componentWillUnmount()
    {
        Utils.unsubscribeFromEvent('tile__mounted', this.handleUpdateTile);
    }

    handleUpdateTile(e)
    {
        if(e.detail.tile.id === this.tile.id)
        {
            this.tile = e.detail.tile;
        }
    }

    // handleToolRotate(r)
    // {
    //     const tile = this.tile;
    //     const grid = tile.grid;

    //     if(grid.isPlacementAvailable(tile.gridX, tile.gridY, tile, r))
    //     {
    //         tile.rotate(r);
    //         grid.placeTile(tile.gridX, tile.gridY, tile);
    //     }
    // }

    handleToolRotateLeft()
    {
        const tile = this.tile;
        const grid = tile.grid;

        const rn = tile.getPrevRotation();

        if(grid.isPlacementAvailable(tile.gridX, tile.gridY, tile, rn))
        {
            tile.rotate(rn);
            grid.placeTile(tile.gridX, tile.gridY, tile);
        }
    }

    handleToolRotateRight()
    {
        const tile = this.tile;
        const grid = tile.grid;

        const rn = tile.getNextRotation();

        if(grid.isPlacementAvailable(tile.gridX, tile.gridY, tile, rn))
        {
            tile.rotate(rn);
            grid.placeTile(tile.gridX, tile.gridY, tile);
        }
    }

    handleToolMove(m)
    {
        const tile = this.tile;
        const grid = tile.grid;

        let _gridX = tile.gridX;
        let _gridY = tile.gridY;

        switch(m)
        {
            case 'left':
                _gridX -= 1;
                break;
            case 'right':
                _gridX += 1;
                break;
            case 'up':
                _gridY -= 1;
                break;
            case 'down':
                _gridY += 1;
                break;
        }

        if(grid.isPlacementAvailable(_gridX, _gridY, tile, tile.rotation))
        {
            grid.placeTile(_gridX, _gridY, tile);
        }
    }

    handleToolSetColor(c)
    {
        this.tile.setColor(c);
    }

    handleToolRemove()
    {
        this.tile.grid.removeTile(this.tile.id);
        this.app.toolsBarClose();
    }

    render()
    {
        // const prevRotation = this.tile.getPrevRotationAvail();
        // const nextRotation = this.tile.getNextRotationAvail();

        return (
            <div className={this.getViewClass()}>
                {/* <div><span>{this.tile.id}</span></div> */}
                <div className='edit-tools rotation'>
                    <div className='tools-label'>
                        <strong>{indexVars.strings.tileEdit.tools.rotateToolsLabel}</strong>
                    </div>
                    <div className='tools-controls'>
                        <button 
                            className='tool-btn icon-btn rotate left rotate-left'
                            onClick={() => { this.handleToolRotateLeft(); }}
                            title={indexVars.strings.tileEdit.tools.rotateLeftLabel}
                        ></button>
                        <button 
                            className='tool-btn icon-btn rotate right rotate-right'
                            onClick={() => { this.handleToolRotateRight(); }}
                            title={indexVars.strings.tileEdit.tools.rotateRightLabel}
                        ></button>
                    </div>
                </div>
                <div className='edit-tools move'>
                    <div className='tools-label'>
                        <strong>{indexVars.strings.tileEdit.tools.moveToolsLabel}</strong>
                    </div>
                    <div className='tools-controls'>
                        {this.tile.moves.map((m, i) => {
                            return (
                                <button 
                                    key={i}
                                    className={`tool-btn icon-btn move ${m}`}
                                    onClick={() => { this.handleToolMove(m); }}
                                    title={m}
                                ></button>
                            );
                        })}
                    </div>
                </div>
                <div className='edit-tools colors'>
                    <div className='tools-label'>
                        <strong>{indexVars.strings.tileEdit.tools.colorToolsLabel}</strong>
                    </div>
                    <div className='tools-controls'>
                        {this.tile.colors.map((c, i) => {
                            return (
                                <button 
                                    key={i} 
                                    className={`tool-btn color ${c}`}
                                    onClick={() => { this.handleToolSetColor(c); }}
                                    title={c}
                                >&nbsp;</button>
                            );
                        })}
                    </div>
                </div>
                <div className='edit-tools misc'>
                    <div className='tools-label'>
                        <strong>{indexVars.strings.tileEdit.tools.miscToolsLabel}</strong>
                    </div>
                    <div className='tools-controls'>
                        <button 
                            className='tool-btn icon-btn remove'
                            onClick={() => { this.handleToolRemove(); }}
                            title={indexVars.strings.tileEdit.tools.removeLabel}
                        ></button>
                    </div>
                </div>
            </div>
        );
    }
}

export default TileEdit;
