jQuery(function($)
{
    /*
    * Helpers
    * --------------------------------------------------
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

    /*
    * Standard ajax form
    * --------------------------------------------------
    */
    $(document.body).on("submit", "form.ajax-form-std", function(e)
    {
        e.preventDefault();

        const form = $(this);
        const btnSubmit = form.find("button[type='submit']");

        btnSubmit.prop("disabled", true);

        $.post(tbootIndexVars.ajaxurl, form.serialize(), function(resp){
            // console.log(resp);
            if(resp.status)
            {
                if(resp.redirect)
                {
                    location.assign(resp.redirect);
                }
                else if(resp.reload){
                    location.reload();
                }

                form.get(0).reset();
            }
            btnSubmit.prop("disabled", false);

            showFormStatus(form, resp);
        });
    });

    /*
    * .view.header
    * --------------------------------------------------
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
});
