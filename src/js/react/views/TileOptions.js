// import React, { Component } from 'react';
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

        this.tilesConfig = (typeof indexVars.tiles_config !== 'undefined') ? indexVars.tiles_config : [];
    }

    handlePlaceTile(typeConfig)
    {
        this.app.gridPlaceTile(typeConfig, this.gridX, this.gridY);
    }

    render()
    {
        const classEnabled = this.state.enabled ? ' enabled' : '';
        
        return (
            <div className={this.getViewClass(classEnabled)}>
                {Object.keys(this.tilesConfig).map((key) => {
                    const tileConfig = this.tilesConfig[key];
                    return (
                        <div className='tile-option' onClick={() => { this.handlePlaceTile(tileConfig.tile_config); }}>
                            <div className='option-label'>
                                <strong>{tileConfig.tile_size_formatted}</strong>
                            </div>
                            <div className='option-btn'>
                                <Tile typeConfig={tileConfig.tile_config} />
                            </div>
                        </div>
                    );                    
                })}
            </div>
        );
    }
}

export default TileOptions;
