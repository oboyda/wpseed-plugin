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

    handlePlaceTile(rotationConfig)
    {
        this.app.gridPlaceTile(rotationConfig, this.gridX, this.gridY);
        this.app.toolsBarDisable();
    }

    groupTilesConfig(tilesConfig)
    {
        let groupedConfigs = {};

        Object.keys(tilesConfig).forEach((key) => {

            const tileConfig = tilesConfig[key];
            const g = 'w_' + tileConfig.tile_width;

            if(typeof groupedConfigs[g] === 'undefined')
            {
                groupedConfigs[g] = [];
            }
            groupedConfigs[g].push(tileConfig);
        });

        let groupedConfigsCols = [];

        const colsNum = 2;
        let colsCount = 0;

        Object.keys(groupedConfigs).forEach((key, i) => {

            if(typeof groupedConfigsCols[colsCount] === 'undefined')
            {
                groupedConfigsCols[colsCount] = {};
            }

            groupedConfigsCols[colsCount][key] = groupedConfigs[key];

            colsCount++;
            if(colsCount >= colsNum)
            {
                colsCount = 0;
            }
        });

        return groupedConfigsCols;
    }

    render()
    {
        const classEnabled = this.state.enabled ? ' enabled' : '';
        const tilesConfigCols = this.groupTilesConfig(this.tilesConfig);
        
        return (
            <div className={this.getViewClass(classEnabled)}>
                <h3 className='block-title'>{indexVars.strings.tileOptions.title}</h3>
                <div className='options-cols'>
                    {tilesConfigCols.map((tilesConfigCol, i) => {
                        return (
                            <div class={`options-col options-col-${i}`}>
                                {Object.keys(tilesConfigCol).map((key) => {
                                    const tilesConfig = tilesConfigCol[key];
                                    return (
                                        <div className={`w-group ${key}`}>
                                            {tilesConfig.map((tileConfig) => {
                                                return (
                                                    <div className='tile-option' onClick={() => { this.handlePlaceTile(tileConfig.tile_config); }}>
                                                        <div className='option-label'>
                                                            <span>{tileConfig.tile_size_formatted}</span>
                                                        </div>
                                                        <div className='option-btn'>
                                                            <Tile rotationConfig={tileConfig.tile_config} />
                                                            <div className='tile-tap'></div>
                                                        </div>
                                                    </div>
                                                );
                                            })}
                                        </div>
                                    );
                                })}
                            </div>
                        );                    
                    })}
                </div>
            </div>
        );
    }
}

export default TileOptions;
