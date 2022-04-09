// import React, { Component } from 'react';
import Utils from '../Utils';
import View from './View';
import Tile from './Tile';

class TileOptions extends View 
{
    constructor(props)
    {
        super(props, {
            app: null,
            gridX: 0,
            gridY: 0
        }, {
            set_state: true
        });

        this.state = {
            gridX: this.gridX,
            gridY: this.gridY,
            enabled: false
        };
    }

    handlePlaceTile(tileType)
    {
        this.app.gridPlaceTile(tileType, this.gridX, this.gridY);
    }

    render()
    {
        const classEnabled = this.state.enabled ? ' enabled' : '';
        const tileElem = new Tile();
        
        return (
            <div className={`view tile-options${classEnabled}`}>
                {Object.keys(tileElem.types).map(typeKey => {
                    return (
                        <div className='tile-option' key={typeKey} onClick={() => { this.handlePlaceTile(typeKey); }}>
                            <div className='option-label'>
                                <strong>{typeKey}</strong>
                            </div>
                            <div className='option-btn'>
                                <Tile type={typeKey} />
                            </div>
                        </div>
                    );                    
                })}
            </div>
        );
    }
}

export default TileOptions;
