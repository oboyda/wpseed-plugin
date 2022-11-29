jQuery(function($){
    
    const _Wpseede = Wpseede.init({
        contextName: 'eun'
    });
    
    /*
    init ajax forms
    --------------------------------------------------
    */

    _Wpseede.initAjaxForms($("form.ajax-form-std"));

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
    Load views
    --------------------------------------------------
    */
    $(".view.pboot").viewTriggerLoaded();
});
