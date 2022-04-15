// import React, { Component } from 'react';
import View from './View';

class Modal extends View 
{
    constructor(props)
    {
        super(props, {
            app: null
        }, {
            set_state: true
        });

        this.state = {
            opened: false,
            headerTitle: null,
            bodyContent: null
        };
        
        // this.eventOpenModal = this.eventOpenModal.bind(this);
        this.handleCloseModal = this.handleCloseModal.bind(this);
    }
    
    handleCloseModal()
    {
        this._setState({
            opened: false,
            headerTitle: null,
            bodyContent: null
        });
    }

    render()
    {
        const openedClass = this.state.opened ? 'opened' : '';

        return (
            <div className={`view modal ${openedClass}`}>
                <div className='modal-window'>
                    <div className='modal-header'>
                        <h3 className='modal-title'>{this.state.headerTitle}</h3>
                        <button type='button' className='btn-close' onClick={this.handleCloseModal}></button>
                    </div>
                    <div className='modal-body'>{this.state.bodyContent}</div>
                </div>
            </div>
        );
    }
}

export default Modal;
