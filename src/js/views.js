import { Modal } from 'bootstrap';

jQuery(function($)
{
    /*
    Helpers
    --------------------------------------------------
    */
    function getWindowHeight(subElems)
    {
        let sh = 0;
        if(typeof subElems !== 'undefined')
        {
            subElems.each(function(){
                sh += $(this).outerHeight();
            });
        }
        return $(window).height() - sh;
    };

    function isMobile()
    {
        return ($(window).width() < 992);
    };

    function showFormStatus(form, resp)
    {
        if(typeof resp.error_fields !== "undefined")
        {
            resp.error_fields.map((errorField) => {
                const errorInput = form.find("[name='"+errorField+"']");
                errorInput.addClass("error");
                errorInput.on("change", function(){
                    $(this).removeClass("error");
                });
            });
        }
        const messagesCont = form.find(".messages-cont");
        if(typeof resp.messages !== "undefined" && messagesCont.length)
        {
            messagesCont.html(resp.messages);
        }
    }

    function loadView(parentView, viewName, viewArgs={}, viewArgsCast={}, cbk)
    {
        if(typeof pbootIndexVars.ajaxurl !== 'undefined')
        {
            $.post(pbootIndexVars.ajaxurl, {
                action: "pboot_load_view",
                view_name: viewName,
                view_args: viewArgs,
                view_args_cast: viewArgsCast
            }, function(resp){

                if(resp.status && typeof resp.values.view_html !== 'undefined')
                {
                    parentView.html(resp.values.view_html);
                    parentView.viewTriggerLoaded(true);

                    if(typeof cbk === 'function')
                    {
                        cbk(resp);
                    }
                }
            });
        }
    }

    function initEntityListView(view)
    {
        const listFiltersElem = view.find(".list-filters");
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
                if(typeof resp.values.filters_html !== "undefined")
                {
                    listFiltersElem.html(resp.values.filters_html);
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

            pagedInput.val(parseInt($(this).data("page")));
            pagedInput.change();
        });
    };

    /*
    .ajax-form-std
    --------------------------------------------------
    */
    
    $("form.ajax-form-std").each(function(){

        const form = $(this);

        form.on("submit", function(e){
            e.preventDefault();

            const btnSubmit = form.find("button[type='submit']");
            btnSubmit.prop("disabled", true);

            const data = new FormData(form.get(0));

            form.triggerHandler("pboot_submit_ajax_form_std_before", [data]);

            $.ajax({
                url: form.attr("action") ? form.attr("action") : pbootIndexVars.ajaxurl,
                type: "POST",
                enctype: form.attr("enctype") ? form.attr("enctype") : "application/x-www-form-urlencoded",
                data: data,
                processData: false,
                contentType: false,
                cache: false,
                // timeout: 800000
            })
            .done(function(resp){
                if(resp.status)
                {
                    if(resp.redirect)
                    {
                        location.assign(resp.redirect);
                    }
                    else if(resp.reload)
                    {
                        location.reload();
                    }
    
                    form.get(0).reset();
                }

                btnSubmit.prop("disabled", false);

                showFormStatus(form, resp);

                form.triggerHandler("pboot_submit_ajax_form_std_success", [resp, data]);
            })
            .fail(function(error)
            {
                console.log("ERROR : ", error);
            })
            .always(function(resp)
            {
                form.triggerHandler("pboot_submit_ajax_form_std_after", [resp, data]);
            })
        });

        form.find(".change-submit").on("change", function(){
            form.submit();
        });

        /*
        .view.form-files-drop
        -------------------------
        */

        const getFileSummary = function(files){
            let summ = [];
            const filesArr = Array.isArray(files) ? files : Array.from(files);
            filesArr.forEach((file) => {
                if(typeof file.name !== 'undefined')
                {
                    summ.push(file.name);
                }
            });
            return summ.join(', ');
        }

        form.find(".view.form-files-drop").each(function(){

            const filesDropView = $(this);

            const dropArea = filesDropView.find(".drop-area");
            const dropSummary = filesDropView.find(".drop-summary");
            const fileInput = filesDropView.find("input[type='file']");
            const fileInputElem = fileInput.get(0);

            if(dropArea.length && fileInput.length)
            {
                dropArea.on("dragenter", function(e){
                    dropArea.addClass("file-over");
                });
                dropArea.on("dragleave", function(e){
                    dropArea.removeClass("file-over");
                });
                dropArea.on("dragover", function(e){
                    e.preventDefault();
                });
                dropArea.on("drop", function(e){
                    e.preventDefault();
                    const _e = e.originalEvent;

                    const filesArr = Array.from(_e.dataTransfer.files);

                    // Attach files to the input
                    if((fileInputElem.multiple && filesArr.length > 0) || (!fileInputElem.multiple && filesArr.length === 1))
                    {
                        fileInputElem.files = _e.dataTransfer.files;
                        fileInput.triggerHandler("change");
                    }
                });

                fileInput.on("change", function(){
                    if(fileInputElem.files.length){
                        filesDropView.addClass("has-files");
                    }else{
                        filesDropView.removeClass("has-files");
                    }
                    dropSummary.html(getFileSummary(fileInputElem.files));
                });
            }
        });

        /*
        .view.form-input-dates
        -------------------------
        */

        form.find(".view.form-input-dates").each(function(){

            const datesRangeView = $(this);

            const dateFromFieldDisplay = datesRangeView.find(".date-from input.date-from-display");
            const dateFromFieldAlt = datesRangeView.find(".date-from input.date-from");
            const datepickerFromElem = datesRangeView.find(".date-from .datepicker");

            const dateTillFieldDisplay = datesRangeView.find(".date-till input.date-till-display");
            const dateTillFieldAlt = datesRangeView.find(".date-till input.date-till");
            const datepickerTillElem = datesRangeView.find(".date-till .datepicker");

            if(
                datepickerFromElem.length && 
                !datepickerFromElem.hasClass("hasDatepicker") && 
                // dateFromFieldDisplay.length && 
                // !dateFromFieldDisplay.hasClass("hasDatepicker") && 
                typeof $.fn.datepicker !== "undefined"
            ){
                datepickerFromElem.datepicker({
                // dateFromFieldDisplay.datepicker({
                    dateFormat: "dd/mm/yy",
                    altField: dateFromFieldAlt,
                    altFormat: "yy-mm-dd",
                    minDate: new Date(),
                    // defaultDate: dateFromFieldDisplay.val() ? dateFromFieldDisplay.val() : null,
                    onSelect: function(dateText, datePicker){
                        dateFromFieldDisplay.val(dateText);
                        dateFromFieldAlt.change();
                    }
                });
                if(datepickerTillElem.length)
                // if(dateTillFieldDisplay.length)
                {
                    dateFromFieldAlt.on("change", function(){
                        const minDate = new Date(this.value);
                        datepickerTillElem.datepicker("option", "minDate", minDate);
                        // dateTillFieldDisplay.datepicker("option", "minDate", minDate);
                    });
                }
            }
            dateFromFieldDisplay.on("focus", function(){
                datepickerFromElem.removeClass("d-none");
            });
            dateFromFieldDisplay.on("blur", function(){
                setTimeout(function(){
                    datepickerFromElem.addClass("d-none");
                }, 1000);
            });

            if(
                datepickerTillElem.length && 
                !datepickerTillElem.hasClass("hasDatepicker") && 
                // dateTillFieldDisplay.length && 
                // !dateTillFieldDisplay.hasClass("hasDatepicker") && 
                typeof $.fn.datepicker !== "undefined"
            ){
                datepickerTillElem.datepicker({
                // dateTillFieldDisplay.datepicker({
                    dateFormat: "dd/mm/yy",
                    altField: dateTillFieldAlt,
                    altFormat: "yy-mm-dd",
                    minDate: new Date(),
                    // defaultDate: dateTillFieldDisplay.val() ? dateTillFieldDisplay.val() : null,
                    onSelect: function(dateText, datePicker){
                        dateTillFieldDisplay.val(dateText);
                        dateTillFieldAlt.change();
                    }
                });
                if(datepickerFromElem.length)
                // if(dateFromFieldDisplay.length)
                {
                    dateTillFieldAlt.on("change", function(){
                        const maxDate = new Date(this.value);
                        datepickerFromElem.datepicker("option", "maxDate", maxDate);
                        // dateFromFieldDisplay.datepicker("option", "maxDate", maxDate);
                    });
                }
            }
            dateTillFieldDisplay.on("focus", function(){
                datepickerTillElem.removeClass("d-none");
            });
            dateTillFieldDisplay.on("blur", function(){
                setTimeout(function(){
                    datepickerTillElem.addClass("d-none");
                }, 500);
            });

        });
    });

    /*
    .switch-contents
    --------------------------------------------------
    */
    $(document.body).on("click", ".switch-content-btn", function(e){
        e.preventDefault();

        const btn = $(this);
        const contentName = btn.data("content_name");
        const switchContents = btn.closest(".switch-contents").find(".switch-content");
        
        if(typeof contentName !== 'undefined')
        {
            switchContents.removeClass("active");
            switchContents.filter(".switch-content." + contentName).addClass("active");
        }
    });

    /*
    .open-login
    --------------------------------------------------
    */
    $(".open-login").on("click", function(e){
        e.preventDefault();

        $(document.body).triggerHandler("pboot_open_site_modal_load", {
            viewName: "login-form"
        });
    });

    /*
    .view.form-nice-dropdown
    --------------------------------------------------
    */
    $(document.body).on("view_loaded_form-nice-dropdown", function(e, view){

        const selectedLabel = view.find(".selected-label");
        const labelText = selectedLabel.find(".label-text");
        const dropdownArea = view.find(".dropdown-area");
        const dropdownOptions = view.find(".dropdown-options");
        const inputName = view.data("input_name");
        const inputs = view.find("input");
        const form = view.closest("form");
        
        function updateLabelText()
        {
            if(!selectedLabel.hasClass("update-label"))
            {
                return;
            }

            let text = labelText.data("orig");
            let hasSelected = false;

            // if(dropdownOptions.find("input.user-input:checked").length)
            if(inputs.filter(".user-input:checked").length)
            {
                // const inputsChecked = dropdownOptions.find("input.user-input:checked");
                const inputsChecked = inputs.filter(".user-input:checked");

                text  = inputsChecked.first().siblings("label").data("text");
                if(inputsChecked.length > 1)
                {
                    text += ' +' + (inputsChecked.length-1).toString();
                }

                hasSelected = true;
            }
            else if(dropdownOptions.find("ul li.type-link.active").length)
            {
                const linksActive = dropdownOptions.find("ul li.type-link.active");
                text = linksActive.first().find("label").data("text");

                hasSelected = true;
            }

            labelText.text(text);

            if(hasSelected)
            {
                view.addClass("has-selected");
            }else{
                view.removeClass("has-selected");
            }
        }
        
        function updateSelected(input)
        {
            const li = input.closest("li");

            if(li.hasClass("type-radio"))
            {
                view.removeClass("opened");
            }

            updateLabelText();
        }

        function clearSelected()
        {
            // dropdownOptions.find("input.user-input:checked").prop("checked", false);
            inputs.filter(".user-input:checked").prop("checked", false);
            updateLabelText();
            // dropdownOptions.find("input.user-input").first().triggerHandler("change");
            inputs.filter(".user-input").first().triggerHandler("change");
        }

        function toggle()
        {
            if(!view.hasClass("disabled"))
            {
                view.toggleClass("opened");
            }
        }

        function enable()
        {
            view.removeClass("disabled");
            // view.find("input:not(.disabled-always)").prop("disabled", false);
            inputs.filter(":not(.disabled-always)").prop("disabled", false);
        }

        function disable()
        {
            view.addClass("disabled");
            // view.find("input:not(.disabled-always)").prop("disabled", true);
            view.filter(":not(.disabled-always)").prop("disabled", true);
        }

        selectedLabel.on("click", ".label-text, .label-toggle", function()
        {
            toggle();
        });

        selectedLabel.on("click", ".label-clear", function()
        {
            if(view.hasClass("has-selected"))
            {
                clearSelected();
            }
            // else{
            //     toggle();
            // }
        });

        dropdownArea.on("click", function()
        {
            toggle();
        });

        // dropdownOptions.find("input.user-input").on("change", function()
        inputs.filter(".user-input").on("change", function()
        {
            updateSelected($(this));
        });

        view.on("nice_dropdown_enable", function(e, _inputName){
            if(typeof inputName !== 'undefined' && _inputName === inputName)
            {
                enable();
            }
        });
        view.on("nice_dropdown_disable", function(e, _inputName){
            if(typeof inputName !== 'undefined' && _inputName === inputName)
            {
                disable();
            }
        });

        // Clear on form reset
        form.on("reset", function(){
            clearSelected();
        });

        updateLabelText();
    });

    /*
    .view.header
    --------------------------------------------------
    */
    $(document.body).on("view_loaded_header", function(e, view) 
    {
        function setSticky()
        {
            const scrollTop = $(window).scrollTop();
            if(scrollTop > view.height())
            {
                if(!view.hasClass("sticky"))
                {
                    view.addClass("sticky");
                    setTimeout(function(){
                        view.addClass("sticky-d");
                    }, 500);

                    $(document.body).css("padding-top", view.outerHeight()+"px");
                }
            }
            else if(scrollTop === 0 && view.hasClass("sticky"))
            {
                view.removeClass("sticky");
                view.removeClass("sticky-d");
                $(document.body).css("padding-top", 0);
            }
        }
        setSticky();
        
        $(window).on("scroll", function(event){
            setSticky();
        });
        $(window).on("resize", function(event){
            setSticky();
        });

        view.find(".nav-toggle-btn").on("click", function(){
            view.toggleClass("nav-opened");
        });
        view.find(".navs-mob-cont .nav-close-area").on("click", function(){
            view.removeClass("nav-opened");
        });

        view.find(".navs-mob-cont li.menu-item-has-children").on("click", function(){
            $(this).toggleClass("submenu-opened");
        });
        view.find(".navs-mob-cont li.menu-item-has-children > a").on("click", function(ev){
            ev.preventDefault();
        });
    });

    /*
    .view.site-modal
    --------------------------------------------------
    */
    $(document.body).on("view_loaded_site-modal", function(e, view){

        const modalElem = view.find(".modal");
        const modalTitleElem = modalElem.find(".modal-header .modal-title");
        const modalBodyElem = modalElem.find(".modal-body .body-content");

        const btModal = new Modal(modalElem.get(0));

        $(document.body).on("pboot_open_site_modal", function(e, _args={}){

            const args = {
                modalTitle: "",
                modalElement: "",
                modalSizeLarge: false,
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
        });

        $(document.body).on("pboot_open_site_modal_load", function(e, _args={}){

            const args = {
                modalTitle: "",
                modalSizeLarge: false,
                viewName: "",
                viewArgs: {},
                viewArgsCast: {},
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
            loadView(modalBodyElem, args.viewName, args.viewArgs, args.viewArgsCast, function(resp){
                modalElem.removeClass("loading");
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

    /*
    .view.tabs-content
    --------------------------------------------------
    */
    $(document.body).on("view_loaded_tabs-content", function(e, view)
    {
        const tabTitles = view.find(".tab-titles .tab-title");
        const tabContents = view.find(".tab-contents .tab-content");

        function switchTab(tabIndex)
        {
            tabTitles.eq(tabIndex).addClass("active");
            tabTitles.not(":eq("+tabIndex+")").removeClass("active");

            tabContents.eq(tabIndex).addClass("active");
            tabContents.not(":eq("+tabIndex+")").removeClass("active");
        }

        tabTitles.on("click", function(){
            const tabTitle = $(this);
            switchTab($(this).index());
        });
    });
});
