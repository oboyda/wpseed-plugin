import React, { Component } from 'react';
import Utils from '../Utils';

class View extends Component 
{
    constructor(props, propsDefault, subscribedEvents)
    {
        super(props);

        this._props = {};
        this.state = {};

        this._setProps(Utils.parseArgs(this.props, propsDefault));

        this.classname = this.constructor.name.toLowerCase();

        this.subscribedEvents = Utils.parseArgs(subscribedEvents, {
            set_state: false
        });

        this.eventSetState = this.eventSetState.bind(this);
    }

    componentDidMount()
    {
        if(typeof this._componentDidMount !== 'undefined')
        {
            this._componentDidMount();
        }

        Object.keys(this.subscribedEvents).forEach((e) => {
            if(this.subscribedEvents[e])
            {
                const name = 'tilec__' + this.classname + '__' + e;
                Utils.subscribeToEvent(name, this.eventSetState);
            }
        });
    }

    componentWillUnmount()
    {
        if(typeof this._componentWillUnmount !== 'undefined')
        {
            this._componentWillUnmount();
        }

        Object.keys(this.subscribedEvents).forEach((e) => {
            if(this.subscribedEvents[e])
            {
                const name = 'tilec__' + this.classname + '__' + e;
                Utils.unsubscribeFromEvent(name, this.eventSetState);
            }
        });
    }

    eventSetState(e)
    {
        if(typeof e.detail !== 'undefined')
        {
            this._setState(e.detail);
        }
    }

    _setState(state, syncProps=true)
    {
        this.setState(state);
        // if(this.classname === 'tile')
        // {
        //     console.log(state, this.state.color);
        // }

        let stateProps = {};
        Object.keys(state).forEach((s) => {
            if(typeof this._props[s] !== 'undefined')
            {
                stateProps[s] = state[s];
            }
        });

        // Sync props from state
        if(syncProps && Object.keys(stateProps).length)
        {
            this._setProps(stateProps, false);
        }
    }

    _setProps(_props, syncState=true)
    {
        let stateProps = {};

        Object.keys(_props).forEach((p) => {
            this._props[p] = _props[p];
            this[p] = this._props[p];

            if(typeof this.state[p] !== 'undefined')
            {
                stateProps[p] = this._props[p];
            }
        });

        // Sync state from props
        if(syncState && Object.keys(stateProps).length)
        {
            this._setState(stateProps, false);
        }
    }

    getProps()
    {
        return this._props;
    }
}

export default View;
