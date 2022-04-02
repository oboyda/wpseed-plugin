// import React, { Component } from 'react';
import View from './View';
// import Utils from '../Utils';

class TileEdit extends View 
{
    constructor(props)
    {
        super(props, {
            app: null,
            tile: null
        });

        // this.state = {
        // };
    }

    handleToolRotate(r)
    {
        const tile = this.tile;
        const grid = tile.grid;

        if(grid.isPlacementAvailable(tile.gridX, tile.gridY, tile, r, tile.id))
        {
            grid.removeTile(tile.id);
            tile.rotate(r);
            grid.placeTile(tile.gridX, tile.gridY, tile);
            this.app.modalClose();
        }
    }

    handleToolMove(m)
    {
        const tile = this.tile;
        const grid = tile.grid;

        let gridX = tile.gridX;
        let gridY = tile.gridY;

        switch(m)
        {
            case 'left':
                gridX -= 1;
                break;
            case 'right':
                gridX += 1;
                break;
            case 'up':
                gridY -= 1;
                break;
            case 'down':
                gridY += 1;
                break;
        }

        if(grid.isPlacementAvailable(gridX, gridY, tile, tile.rotation, tile.id))
        {
            grid.removeTile(tile.id);
            grid.placeTile(gridX, gridY, tile);
            this.app.modalClose();
        }
    }

    handleToolSetColor(c)
    {
        this.tile.setColor(c);
        this.app.modalClose();
    }

    handleToolRemove()
    {
        this.tile.grid.removeTile(this.tile.id);
        this.app.modalClose();
    }

    render()
    {
        const prevRotation = this.tile.getPrevRotationAvail();
        const nextRotation = this.tile.getNextRotationAvail();

        return (
            <div className='view tile-edit'>
                <div className='edit-tools rotation'>
                    <div className='tools-label'>
                        <strong>{indexVars.translations.tileEdit.tools.rotateToolsLabel}</strong>
                    </div>
                    <div className='tools-inner'>
                        <button 
                            className={`tool-btn rotate rotate-left rotate-${prevRotation}`}
                            onClick={() => { this.handleToolRotate(prevRotation); }}
                        >
                            {indexVars.translations.tileEdit.tools.rotateLeftLabel}
                        </button>
                        <button 
                            className={`tool-btn rotate rotate-right rotate-${nextRotation}`}
                            onClick={() => { this.handleToolRotate(nextRotation); }}
                        >
                            {indexVars.translations.tileEdit.tools.rotateRightLabel}
                        </button>
                    </div>
                </div>
                <div className='edit-tools move'>
                    <div className='tools-label'>
                        <strong>{indexVars.translations.tileEdit.tools.moveToolsLabel}</strong>
                    </div>
                    <div className='tools-inner'>
                        {this.tile.moves.map((m, i) => {
                            return (
                                <button 
                                    key={i}
                                    className={`tool-btn move move-${m}`}
                                    onClick={() => { this.handleToolMove(m); }}
                                >
                                    {m}
                                </button>
                            );
                        })}
                    </div>
                </div>
                <div className='edit-tools colors'>
                    <div className='tools-label'>
                        <strong>{indexVars.translations.tileEdit.tools.colorToolsLabel}</strong>
                    </div>
                    <div className='tools-inner'>
                        {this.tile.colors.map((c, i) => {
                            return (
                                <button 
                                    key={i} 
                                    className='tool-btn color'
                                    onClick={() => { this.handleToolSetColor(c); }}
                                >
                                    {c}
                                </button>
                            );
                        })}
                    </div>
                </div>
                <div className='edit-tools misc'>
                    <div className='tools-label'>
                        <strong>{indexVars.translations.tileEdit.tools.miscToolsLabel}</strong>
                    </div>
                    <div className='tools-inner'>
                        <button 
                            className='tool-btn remove'
                            onClick={() => { this.handleToolRemove(); }}
                        >
                            {indexVars.translations.tileEdit.tools.removeLabel}
                        </button>
                    </div>
                </div>
            </div>
        );
    }
}

export default TileEdit;
