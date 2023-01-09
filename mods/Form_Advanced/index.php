<?php 

add_action('after_setup_theme', function(){
    global $pboot_setup;

    if(!isset($pboot_setup))
    {
        return;
    }

    $pboot_setup->scripts->addScriptDep([
        'build_index_front' => ['jquery-ui-datepicker']
    ]);
    
});