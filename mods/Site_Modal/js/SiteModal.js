import { View } from '../../../vendor/oboyda/wp-seed-e/src/js/mods/View';
import { Modal } from 'bootstrap';

export class SiteModal extends View 
{
    constructor(view)
    {
        super(view);

        this.setConfigElems({
            modal: ".modal",
            modalDialog: ".modal .modal-dialog",
            modalTitle: this.view.find(".modal .modal-header .modal-title"),
            modalContent: this.view.find(".modal .modal-body .body-content"),
            modalCloseBtn: this.view.find(".modal button.close")
        });

        this.setConfigsDefault({
            modal: {
                class: this.elems.modal.attr("class")
            },
            modalTitle: {
                text: ""
            },
            modalContent: {
                html: ""
            },
            modalDialog: {
                class: this.elems.modalDialog.attr("class")
            }
        });

        this._initBootstrapModal();
        this._addEventHandlers();
    }

    _initBootstrapModal()
    {
        if(this.elems.modal.length)
        {
            this.bootstrapModal = new Modal(this.elems.modal.get(0));
        }
    }

    _addEventHandlers()
    {
        const _this = this;
        this.elems.modalCloseBtn.on("click", function(){
            _this.close();
        });
        this.elems.modal.on("hide.bs.modal", function(){
            _this.resetConfigs();
        });
    }

    open(args)
    {
        const _args = {
            modalTitle: "",
            modalContent: "",
            modalSize: "",
            modalSizeLarge: false,
            ...args
        };
        if(_args.modalSizeLarge)
        {
            _args.modalSize = "modal-lg";
        }

        this.setConfig("modalTitle.text", _args.modalTitle, true);
        this.setConfig("modalContent.html", _args.modalContent, true);
        if(_args.modalSize)
        {
            this.setConfig("modalDialog.addClass", _args.modalSize, true);
        }

        this.bootstrapModal.show();
    }

    openLoadView(args)
    {
        const _args = {
            modalTitle: "",
            modalSize: "",
            modalSizeLarge: false,
            viewName: "",
            viewArgs: {},
            viewArgsCast: {},
            viewArgsS: {},
            loadedCallback: null,
            ...args
        };
        if(_args.modalSizeLarge)
        {
            _args.modalSize = "modal-lg";
        }

        this.setConfig("modal.addClass", "loading", true);

        this.open({
            modalTitle: _args.modalTitle,
            modalSize: _args.modalSize,
            modalSizeLarge: _args.modalSizeLarge
        });

        const _this = this;

        this.elems.modalContent.viewAjaxLoad("pboot_load_view", _args.viewName, {

            viewArgs: _args.viewArgs,
            viewArgsCast: _args.viewArgsCast,
            viewArgsS: _args.viewArgsS

        }, function(resp){

            _this.setConfig("modal.removeClass", "loading", true);

            if(typeof _args.loadedCallback === "function")
            {
                _args.loadedCallback(this.bootstrapModal, this.elems.modal, resp);
            }
        });
    }

    close()
    {
        this.bootstrapModal.hide();

        this.elems.modalContent.find(".view").viewRemoveRegistry();

        this.resetConfigs(true);
    }
}