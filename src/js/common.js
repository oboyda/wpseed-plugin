jQuery(function($){

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
});
