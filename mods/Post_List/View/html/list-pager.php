<?php if($view->pages_max <= 1) return; ?>

<div class="<?php echo $view->getHtmlClass(); ?>">

    <?php if($view->has_page_chunks()): ?>
    
    <ul class="page-list ns">
        <?php 
        foreach($view->get_page_chunks() as $ci => $chunk): 
        if(in_array($view->get_paged(), $chunk)): 
        
            $chunk_last = count($chunk)-1;
            $chunk_page_prev = $chunk[0]-1;
            $chunk_page_next = $chunk[$chunk_last]+1;
            ?>

            <?php if($view->get_paged() > 1): ?>
            <li class="page page-prev">
                <a href="<?php echo get_pagenum_link($view->get_page_prev()); ?>" class="<?php echo $view->get_btn_class(); ?> icon-only" data-page="<?php echo $view->get_page_prev(); ?>"><?php echo $view->get_btn_prev_icon_html(); ?></a>
            </li>
            <?php endif; ?>

            <?php if($ci > 0): ?>
            <li class="page group-prev">
                <a href="<?php echo get_pagenum_link($chunk_page_prev); ?>" class="<?php echo $view->get_btn_class(); ?>" data-page="<?php echo $chunk_page_prev; ?>">...</a>
            </li>
            <?php endif; ?>
        
            <?php foreach($chunk as $page): 
                $active_class = ($page === $view->get_paged()) ? ' active' : '';
                ?>
            <li class="page<?php echo $active_class; ?>">
                <a href="<?php echo get_pagenum_link($page); ?>" class="<?php echo $view->get_btn_class(); ?>" data-page="<?php echo $page; ?>"><?php echo $page; ?></a>
            </li>
            <?php endforeach; ?>

            <?php if($ci+1 < $view->get_page_chunks_num()): ?>
            <li class="page group-next">
                <a href="<?php echo get_pagenum_link($chunk_page_next); ?>" class="<?php echo $view->get_btn_class(); ?>" data-page="<?php echo $chunk_page_next; ?>">...</a>
            </li>
            <?php endif; ?>

            <?php if($view->get_paged() < $view->pages_max): ?>
            <li class="page page-next">
                <a href="<?php echo get_pagenum_link($view->get_page_next()); ?>" class="<?php echo $view->get_btn_class(); ?> icon-only" data-page="<?php echo $view->get_page_next(); ?>"><?php echo $view->get_btn_next_icon_html(); ?></a>
            </li>
            <?php endif; ?>

        <?php endif; ?>
        <?php endforeach; ?>
    </ul>
    
    <?php endif; ?>

</div>