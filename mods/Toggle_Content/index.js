jQuery(function($){

    /*
    .toggle-content
    --------------------------------------------------
    */
    $(document.body).on("pboot_toggle_content", function(e, contentName, toggleContents, cbkBefore, cbkAfter){

        if(typeof cbkBefore == "function"){
            const cb = cbkBefore(contentName, toggleContents);
            if(cb === false){
                return;
            }
        }

        let activeContent = null;

        if(typeof contentName !== "undefined" && toggleContents.length)
        {
            toggleContents.children(".toggle-content.active").removeClass("active");
            
            activeContent = toggleContents.children(".toggle-content." + contentName);
            activeContent.addClass("active");
        }

        if(typeof cbkAfter == "function"){
            cbkAfter(contentName, activeContent, toggleContents);
        }
    });
    $(document.body).on("click", ".toggle-content-btn", function(e){
        e.preventDefault();
        const btn = $(this);
        const contentName = btn.data("content_name");
        const toggleContents = btn.closest(".toggle-contents");
        $(document.body).trigger("pboot_toggle_content", [contentName, toggleContents]);
    });

});