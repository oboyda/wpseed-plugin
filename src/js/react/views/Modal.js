// import React, { Component } from 'react';
import View from './View';
import Utils from '../Utils';

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
            headerTitle: '',
            bodyContent: ''
        };
        
        // this.eventOpenModal = this.eventOpenModal.bind(this);
        this.handleCloseModal = this.handleCloseModal.bind(this);
    }
    
    // _componentDidMount()
    // {
    //     document.body.addEventListener('tilec__modal__open', this.eventOpenModal, false);
    //     document.body.addEventListener('tilec__modal__close', this.closeModal, false);
    // }

    // _componentWillUnmount()
    // {
    //     document.body.removeEventListener('tilec__modal__open', this.eventOpenModal);
    //     document.body.removeEventListener('tilec__modal__close', this.closeModal);
    // }

    // eventOpenModal(e)
    // {
    //     const detail = Utils.parseArgs(e.detail, {
    //         headerTitle: '',
    //         bodyContent: ''
    //     });
    //     this.modalOpen(detail.headerTitle, detail.bodyContent);
    // }

    // openModal(headerTitle, bodyContent)
    // {
    //     this.setState({
    //         opened: true,
    //         headerTitle: headerTitle,
    //         bodyContent: bodyContent
    //     });
    // }

    handleCloseModal()
    {
        this.setState({
            opened: false,
            headerTitle: '',
            bodyContent: ''
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
