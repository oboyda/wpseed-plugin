<div class="<?php echo $view->getHtmlClass(); ?>" data-view="<?php echo $view->getName(); ?>">

    <?php $view->openContainer(); ?>

        <?php if($view->has_list_title()): ?>
        <h2 class="list-title"><?php echo $view->get_list_title(); ?></h2>
        <?php endif; ?>

        <div class="list-filters part-filters_html">
            <?php echo $view->getChildPart('filters_html'); ?>
        </div>

        <div class="list-summary part-summary_html">
            <?php echo $view->getSummaryHtml(); ?>
        </div>

        <div class="list-items part-items_html">
            <?php echo $view->getChildPart('items_html'); ?>
        </div>

        <?php if($view->has_show_pager()): ?>
        <div class="list-pagination part-pager_html">
            <?php echo $view->getChildPart('pager_html'); ?>
        </div>
        <?php endif; ?>

    <?php $view->closeContainer(); ?>

</div>