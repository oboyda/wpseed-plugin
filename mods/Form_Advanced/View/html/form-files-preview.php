<div class="<?php echo $view->getHtmlClass(); ?>" data-view="<?php echo $view->getName(); ?>">
    <div class="file-items">
        <?php 
        // if($view->has_items_html()):
        //     // echo $view->distributeCols($view->get_items_html());
        //     foreach($view->get_items_html() as $item_html):
        //         echo $item_html;
        //     endforeach;
        // endif;
        ?>

        <?php foreach($view->get_attachment_ids() as $i => $attachment_id): ?>
            <div class="file-item file-<?php echo $view->get_file_type(); ?>" data-id="<?php echo $attachment_id; ?>">
                <div class="item-inner">
                    <?php 
                    if($view->get_file_type() == 'image'):
                        echo $view->getImageHtml($attachment_id, ['size' => $view->get_preview_size(), 'rel_class' => $view->get_preview_rel_class()]);
                    endif;
                    ?>

                    <div class="action-inputs">
                        <?php 
                        $feat_selected = $view->get_feat_input_selected();
                        if($view->has_feat_input_name()):
                            $checked = ((!$i && empty($feat_selected)) || ($feat_selected === $attachment_id)) ? ' checked' : '';
                            ?>
                            <div class="action-input feat-input">
                                <input id="<?php echo $view->get_feat_input_name() . '_' . $i; ?>" type="radio" name="<?php echo $view->get_feat_input_name(); ?>" value="<?php echo $attachment_id; ?>"<?php echo $checked; ?> />
                                <label for="<?php echo $view->get_feat_input_name() . '_' . $i; ?>"><i class="bi bi-check-circle-fill"></i></label>
                            </div>
                        <?php endif; ?>

                        <?php if($view->has_del_input_name()): ?>
                            <div class="action-input del-input">
                                <input id="<?php echo $view->get_del_input_name() . '_' . $i; ?>" type="checkbox" name="<?php echo $view->get_del_input_name(); ?>[]" value="<?php echo $attachment_id; ?>" />
                                <label for="<?php echo $view->get_del_input_name() . '_' . $i; ?>"><i class="bi bi-trash-fill"></i></label>
                            </div>
                        <?php endif; ?>
                    </div>
                </div>
            </div>
        <?php endforeach; ?>
    </div>

    <?php if($view->isSortable()): ?>
    <input type="hidden" class="order-input" name="<?php echo $view->get_order_input_name(); ?>" value="<?php echo implode(',', $view->get_attachment_ids()); ?>" />
    <?php endif; ?>
</div>