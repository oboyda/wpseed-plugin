import React, { Component } from 'react';
import Utils from '../Utils';
import View from './View';
import ToolsBar from './ToolsBar';
// import ToolsBar from './ToolsBar';
import Grid from './Grid';
import Modal from './Modal';

class App extends View {

    constructor(props)
    {
        super(props);

        // this.state = {
        // };
    }

    _componentDidMount()
    {

    }

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

    toolsBarOpen(barContent)
    {
        Utils.dispatchEvent('toolsbar__set_state', {
            opened: true,
            barContent: barContent
        });
    }
    toolsBarClose()
    {
        Utils.dispatchEvent('toolsbar__set_state', {
            opened: false,
            barContent: null
        });
    }

    gridPlaceTile(tileType, gridX, gridY)
    {
        Utils.dispatchEvent('grid__add_tile', {
            tileConfig: {
                type: tileType,
                rotation: 0
            },
            gridX: gridX,
            gridY: gridY
        });
        // this.modalClose();
        this.toolsBarClose();
    }
    
    render() {
        return (
            <div className='view tilec-app'>
                <Modal app={this} />
                <div className='app-editor'>
                    <ToolsBar app={this} />
                    <Grid app={this} />
                </div>
                {/* <FeaturesBar app={this} /> */}
            </div>
        );
    }
}

export default App;