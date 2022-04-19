// import React, { Component } from 'react';
import View from './View';
import Utils from '../Utils';
import TileEdit from './TileEdit';

class Tile extends View 
{
    constructor(props)
    {
        super(props, {
            typeConfig: [],
            rotation: 0,
            color: 'c-1',
            cellSize: 0,
            gridTile: false,
            gridX: null,
            gridY: null,
            grid: null,
            app: null
        });

        this.rotations = [0, 90, 180, 270];
        this.moves = ['left', 'right', 'up', 'down'];
        this.colors = ['c-1', 'c-2', 'c-3'];

        this.rotationsConfig = this.generateRotationsConfig(this.typeConfig);

        this.state = {
            rotation: this.rotation,
            rotationConfig: this.getRotationConfig(0),
            cellSize: this.cellSize,
            color: this.color,
            gridX: this.gridX,
            gridY: this.gridY
        };

        this.handleOpenTileEdit = this.handleOpenTileEdit.bind(this);
    }

    _componentDidMount()
    {
        Utils.dispatchEvent('tile__mounted', { tile: this });
    }

    handleOpenTileEdit()
    {
        if(!this.gridTile)
        {
            return;
        }

        this.app.toolsBarOpen(
            <TileEdit app={this.app} grid={this.grid} tile={this} key={this.id} />
        );

        this.grid.setState({
            activeCell: null
        });
    }

    generateRotationsConfig(origRotation)
    {
        let typeRotations = {};

        this.rotations.forEach(r => {

            const rk = 'rotation_'+r;

            typeRotations[rk] = [];

            if(r === 0)
            {
                typeRotations[rk] = origRotation;
            }
            else if(r === 90){
                
                let _origRotation = Utils.cloneObject(origRotation);
                _origRotation.reverse();
                _origRotation.forEach((row, ri) => {
                    row.forEach((cell, ci) => {
                        if(typeof typeRotations[rk][ci] === 'undefined')
                        {
                            typeRotations[rk][ci] = [];
                        }
                        typeRotations[rk][ci][ri] = cell;
                    });
                });
            }
            else if(r === 180){
    
                let _origRotation = Utils.cloneObject(origRotation);
                _origRotation.reverse();
                _origRotation.forEach((row, ri) => {
                    let _row = Utils.cloneObject(row);
                    _row.reverse();
                    typeRotations[rk][ri] = _row;
                });
            }
            else if(r === 270){
                
                origRotation.forEach((row, ri) => {
                    let _row = Utils.cloneObject(row);
                    _row.reverse();
                    _row.forEach((cell, ci) => {
                        if(typeof typeRotations[rk][ci] === 'undefined')
                        {
                            typeRotations[rk][ci] = [];
                        }
                        typeRotations[rk][ci][ri] = cell;
                    });
                });
            }
        });

        return typeRotations;
    }

    getRotationConfig(r)
    {
        const _r = (typeof r !== 'undefined') ? r : this.rotation;
        const rk = 'rotation_' + _r;
        return (typeof this.rotationsConfig[rk] !== 'undefined') ? this.rotationsConfig[rk] : null;
    }

    getPrevRotation(r)
    {
        const _r = (typeof r !== 'undefined') ? r : this.rotation;
        const ri = this.rotations.indexOf(_r);
        const mi = this.rotations.length-1;
        const pri = (ri-1 > -1) ? ri-1 : mi;
        return this.rotations[pri];
    }
    getPrevRotationAvail()
    {
        let rAvail = 0;
        const rotations = Utils.cloneObject(this.rotations).reverse();
        rotations.every((r) => {
            if(r > this.rotation && this.grid.isPlacementAvailable(this.gridX, this.gridY, this, r))
            {
                rAvail = r;
                return false;
            }
            return true;
        });
        return rAvail;
    }

    getNextRotation(r)
    {
        const _r = (typeof r !== 'undefined') ? r : this.rotation;
        const ri = this.rotations.indexOf(_r);
        const mi = this.rotations.length-1;
        const nri = (ri+1 > mi) ? 0 : ri+1;
        return this.rotations[nri];
    }
    getNextRotationAvail()
    {
        let rAvail = 0;
        const rotations = this.rotations;
        rotations.every((r) => {
            if(r > this.rotation && this.grid.isPlacementAvailable(this.gridX, this.gridY, this, r))
            {
                rAvail = r;
                return false;
            }
            return true;
        });
        return rAvail;
    }

    rotate(r=0)
    {
        this._setProps({
            rotation: r
        });
        this._setState({
            rotationConfig: this.getRotationConfig(r)
        });
    }

    setColor(c)
    {
        this._setState({
            color: c
        });
    }

    render()
    {
        const rotationConfig = this.state.rotationConfig;

        if(rotationConfig === null)
        {
            return null;
        }

        return (
            <div 
                className={this.getViewClass(this.state.color + ' type-' + this.type)}
                onClick={this.handleOpenTileEdit}
                >
                {rotationConfig.map((row, ri) => {
                    return (
                        <div className='tile-row' key={ri}>
                            {row.map((cell, ci) => {
                                const filledClass = cell ? ' filled' : '';
                                const style = {};
                                if(this.gridTile)
                                {
                                    style.width = this.cellSize;
                                }
                                return (
                                    <div className={`tile-cell${filledClass}`} key={ci } style={style}></div>
                                );
                            })}
                        </div>
                    );
                })}
            </div>
        );
    }
}

export default Tile;
