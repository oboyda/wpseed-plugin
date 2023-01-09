import { Modal } from 'bootstrap';

jQuery(function($){

    /*
    .view.site-modal
    --------------------------------------------------
    */
    $(document.body).viewAddLoadedListener("view_loaded_site-modal", function(e, view){

        const modalElem = view.find(".modal");
        const modalTitleElem = modalElem.find(".modal-header .modal-title");
        const modalBodyElem = modalElem.find(".modal-body .body-content");

        const btModal = new Modal(modalElem.get(0));

        $(document.body).on("pboot_open_site_modal", function(e, _args={}){

            const args = {
                modalTitle: "",
                modalElement: "",
                modalSizeLarge: false,
                closeOnAjaxFormSuccess: false,
                ..._args
            };

            modalTitleElem.html(args.modalTitle);
            modalBodyElem.html(args.modalElement);

            if(args.modalSizeLarge){
                modalElem.find(".modal-dialog").addClass("modal-lg");
            }else{
                modalElem.find(".modal-dialog").removeClass("modal-lg");
            }

            // Show modal
            btModal.show();

            // Close modal on pboot_submit_ajax_form_success event
            if(args.closeOnAjaxFormSuccess)
            {
                modalBodyElem.find("form.ajax-form").on("pboot_submit_ajax_form_success", function(){
                    btModal.hide();
                });
            }
        });

        $(document.body).on("pboot_open_site_modal_load", function(e, _args={}){

            const args = {
                modalTitle: "",
                modalSizeLarge: false,
                viewName: "",
                viewArgs: {},
                viewArgsCast: {},
                viewArgsS: {},
                loadedCallback: null,
                closeOnAjaxFormSuccess: false,
                ..._args
            };

            modalBodyElem.html("");
            modalTitleElem.html(args.modalTitle);
            modalElem.addClass("loading");

            if(args.modalSizeLarge){
                modalElem.find(".modal-dialog").addClass("modal-lg");
            }else{
                modalElem.find(".modal-dialog").removeClass("modal-lg");
            }
            
            // Show modal
            btModal.show();

            // Load view in modal body
            modalBodyElem.viewAjaxLoad("pboot_load_view", args.viewName, {
                viewArgs: args.viewArgs,
                viewArgsCast: args.viewArgsCast,
                viewArgsS: args.viewArgsS
            }, function(resp){
                modalElem.removeClass("loading");

                // Close modal on pboot_submit_ajax_form_success event
                if(args.closeOnAjaxFormSuccess)
                {
                    modalBodyElem.find("form.ajax-form").on("pboot_submit_ajax_form_success", function(){
                        btModal.hide();
                    });
                }

                //Callback function
                if(typeof args.loadedCallback === "function")
                {
                    args.loadedCallback(btModal, modalElem, resp);
                }
            });
        });

        view.find(".modal button.close").on("click", function(){
            btModal.hide();
        });

        modalElem.on("hide.bs.modal", function(){
            modalTitleElem.html("");
            modalBodyElem.html("");
            modalElem.removeClass("loading");
        });
    });
});