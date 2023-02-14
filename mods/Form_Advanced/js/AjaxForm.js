export class AjaxForm 
{
    constructor(form)
    {
        this.setForm(form);
        this.initForm();
    }

    setForm(form)
    {
        this.form = form;
        this.submitBtn = this.form.find("button[type='submit'], input[type='submit']");
        this.messagesCont = this.form.find(".messages, .messages-cont");
    }

    /* ------------------------- */

    initForm()
    {
        if(
            !(this.form.hasClass("ajax-form") || this.form.hasClass("ajax-form-std")) 
            || this.form.hasClass("ajax-form-init")
        ){
            return;
        }

        this.addEventListeners();

        this.form.addClass("ajax-form-init");
        this.form.trigger("ajax_form_loaded", [this.form]);
    }

    addEventListeners()
    {
        this.form.on("submit", this.handleFormSubmit.bind(this));
        this.form.on("change", ".change-submit", this.handleInputChange.bind(this));

        this.form.addClass("ajax-form-init");
        this.form.trigger("ajax_form_loaded", [this.form]);
    }

    /* ------------------------- */

    handleFormSubmit(e)
    {
        e.preventDefault();
        this.submitForm();
    }

    handleInputChange(e)
    {
        // e.preventDefault();
        this.submitForm();
    }

    /* ------------------------- */

    submitForm(cbk)
    {
        const _this = this;

        const encType = this.form.attr("enctype") ? this.form.attr("enctype") : (this.form.find("input[type='file']").length ? "multipart/form-data" : "application/x-www-form-urlencoded");

        const formData = encType === "multipart/form-data" ? new FormData(this.form.get(0)) : this.form.serialize();
        
        this.form.trigger("pboot_submit_ajax_form_before", [formData]);

        let reqArgs = {
            url: this.form.attr("action") ? this.form.attr("action") : ((typeof pbootIndexVars !== "undefined") ? pbootIndexVars.ajaxurl : "/wp-admin/admin-ajax.php"),
            type: "POST",
            enctype: encType,
            data: formData
        };
        if(encType == "multipart/form-data")
        {
            reqArgs.processData = false;
            reqArgs.contentType = false;
            reqArgs.cache = false;
        }

        this.submitBtn.prop("disabled", true);

        jQuery.ajax(reqArgs)
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

                if(_this.form.hasClass("submit-reset"))
                {
                    _this.form.get(0).reset();
                }
            }

            _this.submitBtn.prop("disabled", false);

            _this.showFormStatus(resp);

            // _this.form.trigger("pboot_submit_ajax_form_success", [resp, formData]);
            _this.form.trigger("pboot_submit_ajax_form_after", [resp, formData]);

            if(typeof cbk === "function")
            {
                cbk(resp);
            }
        })
        .fail(function(error){
            // console.log("ERROR : ", error);
            _this.form.trigger("pboot_submit_ajax_form_after", [{ status: false }, formData, error]);
        });
        // .always(function(resp){
        //     console.log(resp);
        //     _this.form.trigger("pboot_submit_ajax_form_after", [resp, formData]);
        // });
    }

    /* ------------------------- */

    getFileSummary(files)
    {
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

    resetFileInput(fileInput)
    {
        // fileInput.get(0).files = new FileList;
        fileInput.val("");
        fileInput.trigger("change");
    }

    showFormStatus(resp)
    {
        if(typeof resp.error_fields !== "undefined")
        {
            resp.error_fields.forEach((field) => {
                const errorInput = this.form.find("[name='"+field+"']");
                errorInput.addClass("error-field");
                errorInput.on("change", function(){
                    jQuery(this).removeClass("error-field");
                });
            });
        }
        if(typeof resp.messages !== "undefined" && this.messagesCont.length)
        {
            this.messagesCont.html(resp.messages);
        }
    }
}