// import React, { Component } from 'react';
import Utils from '../Utils';
import View from './View';

class GridSetup extends View 
{
    constructor(props)
    {
        super(props, {
            app: null,
            grid: null
        });

        this.state = {
            controlSizeX: this.grid.getSizeX(false) ? this.grid.getSizeX(false) : this.grid.getSizeMinX(false),
            controlSizeY: this.grid.getSizeY(false) ? this.grid.getSizeY(false) : this.grid.getSizeMinY(false)
        };

        this.handleSaveSetup = this.handleSaveSetup.bind(this);
    }

    handleSaveSetup()
    {
        if(this.state.controlSizeX && this.state.controlSizeY)
        {
            const tilesX = this.state.controlSizeX / this.grid.getTileSize();
            const tilesY = this.state.controlSizeY / this.grid.getTileSize();

            this.grid.setGridSize(tilesX, tilesY);
            this.app.modalClose();
        }
    }

    render()
    {
        return (
            <div className={this.getViewClass()}>
                <div className='controls-group size'>
                    <div className='control'>
                        <label for='grid_size_x'>{indexVars.strings.gridSetup.grid_size.size_x_control_label}</label>
                        <input 
                            type='number' 
                            name='grid_size_x' 
                            className='form-control' 
                            min={this.grid.getSizeMinX(false)} 
                            max={this.grid.getSizeMaxX(false)} 
                            step={indexVars.grid_size.tile_size} 
                            onInput={(e) => { 
                                this.setState({ controlSizeX: parseInt(e.target.value) });
                            }} 
                            value={this.state.controlSizeX}
                        />
                    </div>
                    <div className='control'>
                        <label for='grid_size_y'>{indexVars.strings.gridSetup.grid_size.size_y_control_label}</label>
                        <input 
                            type='number' 
                            name='grid_size_y' 
                            className='form-control' 
                            min={this.grid.getSizeMinY(false)} 
                            max={this.grid.getSizeMaxY(false)} 
                            step={indexVars.grid_size.tile_size} 
                            onInput={(e) => { 
                                this.setState({ controlSizeY: parseInt(e.target.value) });
                            }} 
                            value={this.state.controlSizeY}
                        />
                    </div>
                </div>
                <div className='controls-group update'>
                    <div className='control'>
                        <button className='app-btn btn-1' onClick={this.handleSaveSetup}>{indexVars.strings.gridSetup.btn_save_label}</button>
                    </div>
                </div>
            </div>
        );
    }
}

export default GridSetup;
