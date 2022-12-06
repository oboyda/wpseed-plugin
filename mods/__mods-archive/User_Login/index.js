jQuery(function($){
    /*
    .open-login
    --------------------------------------------------
    */
    $(document.body).on("click", ".open-login", function(e){
        e.preventDefault();

        $(document.body).triggerHandler("pboot_open_site_modal_load", {
            viewName: "User_Login/login-form"
        });
    });

    /*
    Resend user verification email
    --------------------------------------------------
    */
    $(document.body).on("click", "a.resend-email-verif:not(.disabled)", function(e){
        e.preventDefault();

        if(typeof pbootIndexVars.ajaxurl == 'undefined')
        {
            return;
        }

        const btn = $(this);
        const form = btn.closest("form");

        btn.addClass("disabled");

        $.post(pbootIndexVars.ajaxurl, {

            action: "resend_verif_email",
            user: btn.data("user_email")
        }, function(resp){

            btn.removeClass("disabled", false);

            form.trigger("pboot_show_form_status", [resp]);

        }, "json");
    });

});