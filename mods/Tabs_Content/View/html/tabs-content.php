<div class="<?php echo $view->getHtmlClass(); ?>" data-view="<?php echo $view->getName(); ?>">
    <?php if($view->has_top_level()): ?>
    <div class="container">
        <div class="container-narrow">
    <?php endif; ?>

    <?php if($view->has_items()): ?>
    
        <?php if($view->get_tabs_pos() === 'left'): ?>
        <div class="row">
            <div class="col-md-4 col-lg-3">
        <?php endif; ?>
        
                <div class="tab-titles">
                    <?php foreach($view->get_items() as $i => $item): ?>
                    <div class="tab-title switch-content-btn<?php if(!$i) echo ' active'; ?>">
                        <span class="title-text"><?php echo $item['tab_title']; ?></span>
                    </div>
                    <?php endforeach; ?>
                </div>

        <?php if($view->get_tabs_pos() === 'left'): ?>
            </div>
            <div class="col-md-8 col-lg-9">
        <?php endif; ?>

                <div class="tab-contents">
                    <?php foreach($view->get_items() as $i => $item): ?>
                    <div class="tab-content<?php if(!$i) echo ' active'; ?>">
                        <?php echo $item['tab_content']; ?>
                    </div>
                    <?php endforeach; ?>
                </div>

        <?php if($view->get_tabs_pos() === 'left'): ?>
            </div>
        </div>
        <?php endif; ?>

    <?php endif; ?>

    <?php if($view->has_top_level()): ?>
        </div>
    </div>
    <?php endif; ?>
</div>