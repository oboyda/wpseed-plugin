import { PostList } from "./js/PostList";

jQuery(function($){

    /*
    .view.post-list
    --------------------------------------------------
    */
    $(document.body).viewAddLoadedListener("pboot.post-list.post-list", function(e, view, viewRegistry){

        viewRegistry.interface = new PostList(view);
    });
});