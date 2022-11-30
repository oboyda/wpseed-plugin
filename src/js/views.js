jQuery(function($){
    
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
