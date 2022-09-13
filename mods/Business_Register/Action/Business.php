<?php 

namespace PBOOT\Mod\Business_Register\Action;

// use PBOOT\Mod\Business_Register\Utils\Business as Utils_Business;

class Business extends \WPSEED\Action
{
    public function __construct()
    {
        parent::__construct();

        add_action('wp_ajax_nopriv_register_business', [$this, 'registerBusiness']);
    }

    public function registerBusiness()
    {
        //...

        $this->respond();
    }
}
