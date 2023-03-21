import { AjaxForm } from "../../Form_Advanced/js/AjaxForm";

export class PostList 
{
    constructor(view, config={})
    {
        this.view = view;

        this.config = {
            listItemsAppend: false,
            ...config
        };

        this.setView(view);
        this.initFiltersForm();
        this.addEventListeners();
    }

    setView(view)
    {
        this.view = view;

        const filtersFormSelector = this.view.data("filters_form");
        const filtersForm = (typeof filtersFormSelector !== "undefined") ? jQuery(filtersFormSelector) : this.view.find("form.filters-form");

        this.setFiltersForm(filtersForm);
    }

    setFiltersForm(filtersForm)
    {
        this.filtersForm = filtersForm;
        this.filtersFormPagedInput = this.filtersForm.find("input[name='paged']");
    }

    setPaged(paged, triggerChange=true)
    {
        this.filtersFormPagedInput.val(paged);
        if(triggerChange){
            this.filtersFormPagedInput.change();
        }
    }

    submitFiltersForm()
    {
        // this.filtersFormPagedInput.change();
        this.filtersForm.submit();
    }

    initFiltersForm()
    {
        if(!this.filtersForm.hasClass("ajax-form"))
        {
            this.ajaxForm = new AjaxForm(this.filtersForm);
        }
    }

    addEventListeners()
    {
        const _this = this;

        this.filtersForm.on("change", ".change-submit", function(){
            if(jQuery(this).attr("name") !== "paged")
            {
                _this.setPaged(1, false);
            }
        });

        this.filtersForm.on("pboot_submit_ajax_form_before", function(){
            _this.view.addClass("loading");
        });

        this.filtersForm.on("pboot_submit_ajax_form_after", function(e, resp, data){
            if(
                resp.status && 
                typeof resp.values !== 'undefined' && 
                typeof resp.values.view_parts_html !== 'undefined' 
            ){
                if(
                    _this.config.listItemsAppend 
                    && typeof resp.values.view_parts_html.items_html !== "undefined" 
                    && parseInt(_this.filtersFormPagedInput.val()) > 1 
                ){
                    _this.view.find(".part-items_html").viewAppend(resp.values.view_parts_html.items_html);
                    delete resp.values.view_parts_html.items_html;
                }

                _this.view.viewUpdateParts(resp.values.view_parts_html, true);
            }

            _this.view.removeClass("loading");
        });

        this.view.on("click", ".view.list-pager.ajax-pager li.page a", function(e){
            e.preventDefault();

            const a = jQuery(this);
            const page = parseInt(a.data("page"));

            _this.setPaged(page);
        });
    }
}