jQuery(function($){

    /*
    .view.tabs-content
    --------------------------------------------------
    */
    $(document.body).viewAddLoadedListener("view_loaded_tabs-content", function(e, view)
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
