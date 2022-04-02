import React, { Component } from 'react';
import Utils from '../Utils';

class View extends Component 
{
    constructor(props, propsDefault, subscribedEvents)
    {
        super(props);
        this._props = {};
        this.setObjectProps(Utils.parseArgs(this.props, propsDefault));

        this.classname = this.constructor.name.toLowerCase();

        this.subscribedEvents = Utils.parseArgs(subscribedEvents, {
            set_state: false
        });

        this.state = {};

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
            this.setState(e.detail);
        }
    }

    setObjectProps(_props)
    {
        Object.keys(_props).forEach((p) => {
            this._props[p] = _props[p];
            this[p] = this._props[p];
        });
    }

    getProps()
    {
        return this._props;
    }
}

export default View;
