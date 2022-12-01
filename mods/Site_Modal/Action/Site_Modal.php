<?php 

namespace PBOOT\Mod\Site_Modal\Action;

class Site_Modal extends \WPSEED\Action 
{
    public function __construct()
    {
        parent::__construct();
        
        add_action('wp_footer', [$this, 'printModalView']);
    }

    public function printModalView()
    {
        pboot_print_view('Site_Modal/site-modal');
    }
}