jQuery.fn.extend({

    initPostListView: function()
    {
        const view = this;

        const filtersFormSelector = view.data("filters_form");
        const filtersForm = (typeof filtersFormSelector !== "undefined") ? jQuery(filtersFormSelector) : view.find("form.filters-form");
        const pagedInput = filtersForm.find("input[name='paged']");

        filtersForm.on("pboot_submit_ajax_form_before", function(e, data){
            view.addClass("loading");

            // const reqArgs = filtersForm.serialize();
            // const reqUri = window.location.pathname + "?" + reqArgs;

            // window.history.pushState({
            //     additionalInformation: 'Updated the URL with JS'
            // }, document.title, reqUri);
        });

        filtersForm.on("pboot_submit_ajax_form_after", function(e, resp, data){
            if(
                resp.status && 
                typeof resp.values !== 'undefined' && 
                typeof resp.values.view_parts_html !== 'undefined' 
            ){
                view.viewUpdateParts(resp.values.view_parts_html, true);
            }
            view.removeClass("loading");
        });

        view.on("click", ".view.list-pager.ajax-pager li.page a", function(e){
            e.preventDefault();

            const a = jQuery(this);
            pagedInput.val(parseInt(a.data("page")));
            pagedInput.change();
        });

        filtersForm.ajaxFormInit();
    }
});

jQuery(function($){

    /*
    .view.post-list
    --------------------------------------------------
    */
    $(document.body).viewAddLoadedListener("view_loaded_post-list", function(e, view){
        view.initPostListView();
    });
});