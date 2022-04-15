// import React, { Component } from 'react';
import View from './View';
import Modal from 'react-bootstrap/Modal';
import Button from 'react-bootstrap/Button';

class AppModal extends View 
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
        return (
            <Modal show={this.state.opened} centered>
                <Modal.Header closeButton>
                    <Modal.Title>{this.state.headerTitle}</Modal.Title>
                </Modal.Header>
                <Modal.Body>{this.state.bodyContent}</Modal.Body>
                <Modal.Footer>
                    {/* <Button variant="secondary">Close</Button> */}
                    <Button variant="primary" onClick={this.handleCloseModal}>{indexVars.strings.gridSetup.btn_save_label}</Button>
                </Modal.Footer>
            </Modal>
        );
    }
}

export default AppModal;
