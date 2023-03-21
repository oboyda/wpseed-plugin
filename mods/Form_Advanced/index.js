import { AjaxForm } from "./js/AjaxForm";

jQuery(function($)
{
    /*
    init .ajax-form
    --------------------------------------------------
    */
    $(".view.pboot form.ajax-form, form.ajax-form.pboot").each(function(){
        const ajaxForm = new AjaxForm($(this));
    });
    // $(document.body).on("view_loaded", function(e, view){
    $(document.body).viewAddLoadedListener("view_loaded", function(e, view){
        if(view.hasClass("pboot")){
            view.find("form.ajax-form").each(function(){
                const ajaxForm = new AjaxForm($(this));
            });
        }
    });

    /*
    .view.form-files-drop
    --------------------------------------------------
    */
    $(document.body).viewAddLoadedListener("pboot.form-advanced.form-files-drop", function(e, view){

        const dropArea = view.find(".drop-area");
        const dropSummary = view.find(".drop-summary");
        const fileInput = view.find("input[type='file']");
        const fileInputElem = fileInput.get(0);
        const fileClear = view.find(".clear-file .clear-btn");

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

            if((fileInputElem.multiple && filesArr.length > 0) || (!fileInputElem.multiple && filesArr.length === 1))
            {
                fileInputElem.files = _e.dataTransfer.files;
                fileInput.trigger("change");
            }
        });
        fileInput.on("change", function(){
            if(fileInputElem.files.length){
                view.addClass("has-files");
            }else{
                view.removeClass("has-files");
            }
            dropSummary.html(_this.getFileSummary(fileInputElem.files));
        });
        fileClear.on("click", function(){
            _this.resetFileInput(fileInput);
        });
    });

    /*
    .view.form-input-dates
    --------------------------------------------------
    */
    $(document.body).viewAddLoadedListener("pboot.form-advanced.form-input-dates", function(e, view){

        const dateFromFieldDisplay = view.find(".date-from input.date-from-display");
        const dateFromFieldAlt = view.find(".date-from input.date-from");
        const datepickerFromElem = view.find(".date-from .datepicker");

        const dateTillFieldDisplay = view.find(".date-till input.date-till-display");
        const dateTillFieldAlt = view.find(".date-till input.date-till");
        const datepickerTillElem = view.find(".date-till .datepicker");

        function openDatepicker(datepickerElem){
            datepickerElem.removeClass("d-none");
        }
        function closeDatepicker(datepickerElem, timeout=false){
            if(timeout)
            {
                setTimeout(function(){
                    datepickerElem.addClass("d-none");
                }, 500);
            }
            else{
                datepickerElem.addClass("d-none");
            }
        }
        
        if(
            datepickerFromElem.length && 
            !datepickerFromElem.hasClass("hasDatepicker") && 
            typeof jQuery.fn.datepicker !== "undefined"
        ){
            datepickerFromElem.datepicker({
                dateFormat: "dd/mm/yy",
                altField: dateFromFieldAlt,
                altFormat: "yy-mm-dd",
                minDate: new Date(),
                onSelect: function(dateText, datePicker){
                    dateFromFieldDisplay.val(dateText);
                    dateFromFieldAlt.change();

                    closeDatepicker(datepickerFromElem, false);
                }
            });
            if(datepickerTillElem.length)
            {
                dateFromFieldAlt.on("change", function(){
                    const minDate = new Date(this.value);
                    datepickerTillElem.datepicker("option", "minDate", minDate);
                });
            }
        }
        dateFromFieldDisplay.on("focus", function(){
            openDatepicker(datepickerFromElem);
        });
        // dateFromFieldDisplay.on("blur", function(){
        //     closeDatepicker(datepickerFromElem, true);
        // });

        if(
            datepickerTillElem.length && 
            !datepickerTillElem.hasClass("hasDatepicker") && 
            typeof jQuery.fn.datepicker !== "undefined"
        ){
            datepickerTillElem.datepicker({
                dateFormat: "dd/mm/yy",
                altField: dateTillFieldAlt,
                altFormat: "yy-mm-dd",
                minDate: new Date(),
                onSelect: function(dateText, datePicker){
                    dateTillFieldDisplay.val(dateText);
                    dateTillFieldAlt.change();

                    closeDatepicker(datepickerTillElem, false);
                }
            });
            if(datepickerFromElem.length)
            {
                dateTillFieldAlt.on("change", function(){
                    const maxDate = new Date(this.value);
                    datepickerFromElem.datepicker("option", "maxDate", maxDate);
                });
            }
        }
        dateTillFieldDisplay.on("focus", function(){
            openDatepicker(datepickerTillElem);
        });
        // dateTillFieldDisplay.on("blur", function(){
        //     closeDatepicker(datepickerTillElem, true);
        // });
    });

    /*
    .view.form-nice-dropdown
    --------------------------------------------------
    */
    $(document.body).viewAddLoadedListener("pboot.form-advanced.form-nice-dropdown", function(e, view){

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
            inputs.filter(".user-input").first().trigger("change");
        }

        function toggle()
        {
            if(!view.hasClass("disabled") && !view.hasClass("readonly"))
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
    .view.form-time-picker
    --------------------------------------------------
    */
    $(document.body).viewAddLoadedListener("pboot.form-advanced.form-time-picker", function(e, view){

        const optElems = view.find(".t-opts .t-opt");
        const optBtns = view.find(".t-opts .t-opt button.opt-btn");
        const rangeBtns = view.find(".t-opts .t-opt button.range-btn");
        const input = view.find("input.val-input");

        function getInputVal(parsed=false)
        {
            const inputVal = input.val();
            return parsed ? inputVal.split(",") : inputVal;
        }
        function setInputVal(val)
        {
            const _val = Array.isArray(val) ? val.join(",") : val;
            input.val(_val);
            input.trigger("change");
        }

        function toggleOpts()
        {
            const inputVals = getInputVal(true);

            optBtns.each(function(i){

                const optBtn = $(this);
                const optVal = optBtn.data("opt");

                if(inputVals.indexOf(optVal) > -1){
                    optBtn.addClass("active");
                    rangeBtns.eq(i).addClass("active");
                    optElems.eq(i).addClass("active");
                }else{
                    optBtn.removeClass("active");
                    rangeBtns.eq(i).removeClass("active");
                    optElems.eq(i).removeClass("active");
                }
            });
        }

        function addVal(v, vStart=null){

            let _inputVals = [];

            const inputVals = getInputVal(true);

            let isRange = false;

            // Loop through optBtns to set values in the correct order
            optBtns.each(function(){

                const btn = $(this);
                const ov = btn.data("opt");

                if(
                    inputVals.indexOf(ov) > -1 || 
                    v === ov || 
                    vStart === ov || 
                    isRange
                ){
                    _inputVals.push(ov);

                    if(vStart === ov && vStart !== v)
                    {
                        isRange = true;
                    }
                    else if(isRange && v === ov){

                        isRange = false;
                        rangeValStart = null;
                    }
                }
            });

            setInputVal(_inputVals);
        }

        function delVal(v, vStart=null){

            let _inputVals = [];
            let _delVals = [];

            const inputVals = getInputVal(true);

            let isRange = false;

            // Loop through optBtns to set values in the correct order
            optBtns.each(function(){

                const btn = $(this);
                const ov = btn.data("opt");

                if(
                    v === ov || 
                    vStart === ov || 
                    isRange
                ){
                    _delVals.push(ov);

                    if(vStart === ov && vStart !== v)
                    {
                        isRange = true;
                    }
                    else if(isRange && v === ov){

                        isRange = false;
                        rangeValStart = null;
                    }
                }
            });

            inputVals.forEach((v) => {
                if(_delVals.indexOf(v) < 0)
                {
                    _inputVals.push(v);
                }
            });

            setInputVal(_inputVals);
        }

        let rangeValStart = null;

        toggleOpts();
        input.on("change", function(){
            toggleOpts();
        });
        optBtns.on("click", function(){

            const btn = $(this);
            const optVal = btn.data("opt");

            if(btn.hasClass("active")){
                delVal(optVal, rangeValStart);
            }else{
                addVal(optVal, rangeValStart);
            }
        });
        rangeBtns.on("click", function(){

            const btn = $(this);
            const optVal = btn.data("opt");
            const optI = parseInt(btn.data("i"));

            // const optBtn = optBtns.eq(optI);

            if(btn.hasClass("active")){
                btn.removeClass("active");
                // optBtn.removeClass("active");
                // rangeValStart = null;
            }else{
                btn.addClass("active");
                // optBtn.addClass("active");
                // rangeValStart = optVal;
            }

            // Select/Deselect range buttons if neccesary
            optBtns.each(function(i){

                if(i === optI)
                {
                    return;
                }

                const optBtn = $(this);
                const rangeBtn = rangeBtns.eq(i);

                if(optBtn.hasClass("active") && !rangeBtn.hasClass("active"))
                {
                    rangeBtn.addClass("active");
                }
                if(!optBtn.hasClass("active") && rangeBtn.hasClass("active"))
                {
                    rangeBtn.removeClass("active");
                    rangeValStart = null;
                }
            });

            rangeValStart = rangeValStart ? null : optVal;
        });
    });

    /*
    .view.form-input-location
    --------------------------------------------------
    */
    $(document.body).viewAddLoadedListener("pboot.form-advanced.form-input-location", function(e, view)
    {
        function initFormInputLocation(){

            const inputDisplay = view.find("input.input-display");
            const inputDisplayDom = inputDisplay.get(0);

            const inputSys = view.find("input.input-sys");
            // const inputAltDom = inputSys.get(0);

            const autocomplete = new google.maps.places.Autocomplete(inputDisplayDom, {
                componentRestrictions: { 
                    country: ["es"] 
                },
                fields: [
                    "address_components"
                    // "geometry"
                ],
                types: [
                    "locality"
                    // "address"
                ]
            });

            function updateSysInput()
            {
                const place = autocomplete.getPlace();
                let sysVal = [];
                place.address_components.forEach(function(component){
                    if(typeof component.short_name !== 'undefined')
                    {
                        sysVal.push(component.short_name);
                    }
                });
                inputSys.val(sysVal.join("-", sysVal));
            }

            autocomplete.addListener("place_changed", updateSysInput);
        };

        if(window.isGoogleMapsLoaded()){
            initFormInputLocation();
        }else{
            $(document.body).on("googlemaps-loaded", function(){
                initFormInputLocation();
            });
        }
    });

    /*
    .view.form-files-preview
    --------------------------------------------------
    */
    $(document.body).viewAddLoadedListener("pboot.form-advanced.form-files-preview", function(e, view){

        const itemsOrderIput = view.find(".order-input");
        const isSortable = view.hasClass("is-sortable");

        function setItemsOrder()
        {
            if(!isSortable)
            {
                return;
            }

            let orderIds = [];
            const fileItems = view.find(".file-item");
            fileItems.each(function(){
                orderIds.push($(this).data("id"));
            });

            itemsOrderIput.val(orderIds.join(","));
            itemsOrderIput.trigger("change");
        }

        if(view.hasClass("is-sortable") && typeof $.fn.sortable !== "undefined")
        {
            view.find(".file-items").sortable({
                // containment: "parent"
                stop: function(e, ui){
                    setItemsOrder();
                }
            });
        }
    });
});