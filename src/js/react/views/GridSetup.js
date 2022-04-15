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
            controlSizeX: 0,
            controlSizeY: 0
        };

        this.handleSaveSetup = this.handleSaveSetup.bind(this);
    }

    handleSaveSetup()
    {
        if(this.state.controlSizeX && this.state.controlSizeY)
        {
            this.grid.setGridSize(this.state.controlSizeX, this.state.controlSizeY);
            this.app.modalClose();
        }
    }

    render()
    {
        return (
            <div className='view grid-setup'>
                <div className='controls-group size'>
                    <div className='control'>
                        <label for='grid_size_x'>{indexVars.strings.gridSetup.grid_size.size_x_control_label}</label>
                        <input 
                            type='number' 
                            name='grid_size_x' 
                            className='form-control' 
                            min={0} 
                            max={this.grid.getSizeMaxX()} 
                            onInput={(e) => { 
                                this.setState({ controlSizeX: parseInt(e.target.value) });
                            }} 
                        />
                    </div>
                    <div className='control'>
                        <label for='grid_size_y'>{indexVars.strings.gridSetup.grid_size.size_y_control_label}</label>
                        <input 
                            type='number' 
                            name='grid_size_y' 
                            className='form-control' 
                            min={0} 
                            max={this.grid.getSizeMaxY()} 
                            onInput={(e) => { 
                                this.setState({ controlSizeY: parseInt(e.target.value) });
                            }} 
                        />
                    </div>
                </div>
                <div className='controls-group update'>
                    <div className='control'>
                        <button className='btn btn-primary' onClick={this.handleSaveSetup}>{indexVars.strings.gridSetup.btn_save_label}</button>
                    </div>
                </div>
            </div>
        );
    }
}

export default GridSetup;
