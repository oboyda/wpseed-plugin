<?php

namespace PBOOT\Mod\User_Login\View;

class Resetpass_Status extends \PBOOT\View\View 
{
    public function __construct($args)
    {
        parent::__construct($args, [

            'status' => false,
            'email' => '',
            'success_message' => __('Password has been reset successfully! New password has been sent to %s.', 'pboot'),
            'error_message' => __('Failed to reset password! Please try again later.', 'pboot'),
            'back_url' => home_url(),
            'back_label' => __('Close', 'pboot')
        ]);

        $this->setArgs();
    }

    protected function setArgs()
    {
        if($this->has_email())
        {
            $this->args['success_message'] = sprintf($this->args['success_message'], $this->get_email());
        }
    }
}
