import React, { Component } from 'react';
import Utils from '../Utils';
import View from './View';
import ToolsBar from './ToolsBar';
import NavBar from './NavBar';
import Grid from './Grid';
import Modal from './Modal';

class App extends View {

    constructor(props)
    {
        super(props);

        // this.state = {
        // };
    }

    // _componentDidMount()
    // {
    // }

    modalOpen(args)
    {
        args = Utils.parseArgs(args, {
            headerTitle: null,
            bodyContent: null
        });

        Utils.dispatchEvent('modal__set_state', {
            opened: true,
            headerTitle: args.headerTitle,
            bodyContent: args.bodyContent
        });
    }
    modalClose()
    {
        Utils.dispatchEvent('modal__set_state', {
            opened: false,
            headerTitle: null,
            bodyContent: null
        });
    }

    toolsBarOpen(barContent, enabled=true)
    {
        Utils.dispatchEvent('toolsbar__set_state', {
            enabled: enabled,
            barContent: barContent
        });
    }
    toolsBarClose()
    {
        Utils.dispatchEvent('toolsbar__set_state', {
            enabled: false,
            barContent: null
        });
    }

    toolsBarEnable()
    {
        Utils.dispatchEvent('toolsbar__set_state', {
            enabled: true
        });
    }
    toolsBarDisable()
    {
        Utils.dispatchEvent('toolsbar__set_state', {
            enabled: false
        });
    }

    gridPlaceTile(rotationConfig, gridX, gridY)
    {
        Utils.dispatchEvent('grid__add_tile', {
            tileConfig: {
                rotationConfig: rotationConfig,
                rotation: 0
            },
            gridX: gridX,
            gridY: gridY
        });
    }
    
    render() {
        return (
            <div className={this.getViewClass('tilec-app')}>
                <Modal app={this} />
                <div className='app-editor'>
                    <ToolsBar app={this} />
                    <Grid app={this} />
                </div>
                <NavBar app={this} />
            </div>
        );
    }
}

export default App;