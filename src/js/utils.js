jQuery.fn.extend({

    initEntityListView: function()
    {
        const view = this;

        const listTitleElem = view.find(".list-title");
        const listFiltersElem = view.find(".list-filters");
        const listSummaryElem = view.find(".list-summary");
        const listItemsElem = view.find(".list-items");
        const listPaginationElem = view.find(".list-pagination");

        const filtersForm = listFiltersElem.find("form.filters-form");
        const pagedInput = filtersForm.find("input[name='paged']");

        filtersForm.on("pboot_submit_ajax_form_std_before", function(e, data){
            view.addClass("loading");

            // const reqArgs = filtersForm.serialize();
            // const reqUri = window.location.pathname + "?" + reqArgs;

            // window.history.pushState({
            //     additionalInformation: 'Updated the URL with JS'
            // }, document.title, reqUri);
        });

        filtersForm.on("pboot_submit_ajax_form_std_after", function(e, resp, data){
            
            if(resp.status && typeof resp.values !== 'undefined')
            {
                if(typeof resp.values.title_html !== "undefined")
                {
                    listTitleElem.html(resp.values.title_html);
                }
                if(typeof resp.values.filters_html !== "undefined")
                {
                    listFiltersElem.html(resp.values.filters_html);
                }
                if(typeof resp.values.summary_html !== "undefined")
                {
                    listSummaryElem.html(resp.values.summary_html);
                }
                if(typeof resp.values.list_html !== "undefined")
                {
                    listItemsElem.html(resp.values.list_html);
                }
                if(typeof resp.values.pager_html !== "undefined")
                {
                    listPaginationElem.html(resp.values.pager_html);
                }
            }
            view.removeClass("loading");
        });

        listPaginationElem.on("click", ".view.list-pager.ajax-pager li.page a", function(e){
            e.preventDefault();

            pagedInput.val(parseInt(jQuery(this).data("page")));
            pagedInput.change();
        });
    }
});

// export const Utils = {

// };