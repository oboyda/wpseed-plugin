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

    // _componentDidMount()
    // {
    //     document.body.addEventListener('tilec__tile_options__enable', this.enableOptions, false);
    //     document.body.addEventListener('tilec__tile_options__disable', this.disableOptions, false);
    // }

    // _componentWillUnmount()
    // {
    //     document.body.removeEventListener('tilec__tile_options__enable', this.enableOptions);
    //     document.body.removeEventListener('tilec__tile_options__disable', this.disableOptions);
    // }

    // enableOptions(e)
    // {
    //     const detail = e.detail;
    //     this.setState({
    //         gridX: detail.gridX,
    //         gridY: detail.gridY,
    //         enabled: true
    //     });
    // }

    // disableOptions(e)
    // {
    //     this.setState({
    //         enabled: false
    //     });
    // }

    handlePlaceTile(tileType)
    {
        // Utils.dispatchEvent('grid__place_tile', {
        //     tileConfig: {
        //         type: tileType,
        //         rotation: 0
        //     },
        //     gridX: this.gridX,
        //     gridY: this.gridY
        // });
        // this.app.modalClose();

        this.app.gridPlaceTile(tileType, this.gridX, this.gridY);
    }

    render()
    {
        // if(!this.state.enabled)
        // {
        //     return null;
        // }

        const classEnabled = this.state.enabled ? ' enabled' : '';
        const tileElem = new Tile();
        
        return (
            <div className={`view tile-options${classEnabled}`}>
                {Object.keys(tileElem.types).map(typeKey => {
                    return (
                        <div className='tile-option' key={typeKey} onClick={() => { this.handlePlaceTile(typeKey); }}>
                            <div className='option-inner'>
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
