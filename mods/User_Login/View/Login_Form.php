<?php 

namespace PBOOT\Mod\User_Login\View;

class Login_Form extends \PBOOT\View\View 
{
    const MOD_NAME = 'User_Login';

    protected $req;

    public function __construct($args, $args_default=[])
    {
        parent::__construct($args, wp_parse_args($args_default, [
            
            'redirect' => 1, #1 to admin_url() or other value
            'show_remember' => false
        ]));

        $this->req = new \WPSEED\Req();
    }

    public function getReq($name, $type='text', $default='')
    {
        return $this->req->get($name, $type, $default);
    }

    public function hasReq($name)
    {
        $r = $this->getReq($name);
        return !empty($r);
    }

    public function isFormActive($name)
    {
        $form_active = 'login';

        if($this->hasReq('resetpasshash'))
        {
            $form_active = 'resetpass';
        }

        return ($form_active == $name);
    }
}