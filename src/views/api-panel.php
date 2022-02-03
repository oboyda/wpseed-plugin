
<div class="<?php echo $view->getHtmlClass(); ?>">

    <h1><?php _e('Properties API Import', 'hsp'); ?></h1>

    <p>&nbsp;</p>

    <?php if($view->has_branches()): ?>
    <div class="branches">
        <?php foreach($view->get_branches() as $branch): ?>
        <div class="branch branch-<?php $branch['id']; ?>">
            <h4><?php printf(__('Branch: %s'), $branch['name']); ?></h4>

            <div class="import-summary"></div>

            <div class="api-actions">
                <button class="button button-secondary btn-import" data-branch_id="<?php echo $branch['id']; ?>" data-branch_name="<?php echo $branch['name']; ?>"><?php _e('Import properties', 'hsp'); ?></button>
            </div>
        </div>
        <?php endforeach; ?>
    </div>
    <?php endif; ?>

    <script type="text/javascript">
        jQuery(function($){

            const viewName = ".view.<?php echo $view->getName(); ?>";

            const importProperties = function(btn, branchId, page=1, sessionId='')
            {
                btn.prop("disabled", true);

                $.post(ajaxurl, {
                    action: "hsp_api_import",
                    branch_id: branchId,
                    page: page,
                    session_id: sessionId
                }, function(resp){

                    console.log(resp);

                    if(typeof resp.summary_html !== 'undefined' && typeof btn !== 'undefined')
                    {
                        const branchCont = btn.closest(".branch");
                        const summaryCont = branchCont.find(".import-summary");
                        summaryCont.html(resp.summary_html);
                    }

                    if(typeof resp.page_max !== 'undefined' && page < resp.page_max)
                    {
                        page++;
                        const sessionId = (typeof resp.session_id !== 'undefined') ? resp.session_id : '';
                        if(page <= 2)
                        {
                            importProperties(btn, branchId, page, sessionId);
                        }
                    }
                    else{
                        btn.prop("disabled", false);
                    }
                }, 'json');
            }

            $(viewName + " .api-actions .btn-import").on("click", function(){

                const btn = $(this);
                const confirmText = "<?php _e('Start importing properties for the Branch: ', 'hsp'); ?>" + btn.data("branch_name") + "?";
                
                if(confirm(confirmText))
                {
                    importProperties(btn, parseInt(btn.data("branch_id")));
                }
            });
        });
    </script>
</div>