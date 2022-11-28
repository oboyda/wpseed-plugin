<?php 

namespace PBOOT\Mod\Action_Email\Action;

use PBOOT\Mod\Action_Email\Utils\Email as Utils_Email;
use PBOOT\Mod\Action_Email\Type\Email as Type_Email;

class Email_Admin extends \WPSEED\Action 
{
    public function __construct()
    {
        parent::__construct();
        
        add_action('add_meta_boxes', [$this, 'registerMetaBoxes']);
        add_action('save_post_action_email', [$this, 'saveMetaboxEmailActionsData']);
    }

    public function registerMetaBoxes()
    {
        add_meta_box(
            'email-actions-metabox', 
            __('Email action', 'pboot'), 
            [$this, 'renderMetaboxEmailActions'], 
            'action_email',
            'side'
        );
    }

    public function saveMetaboxEmailActionsData($post_id)
    {
        $email_action = $this->getReq('pboot_email_action');
        
        if(isset($email_action))
        {
            if($email_action)
            {
                update_post_meta($post_id, '_email_action', $email_action);
            }
            else{
                delete_post_meta($post_id, '_email_action');
            }
        }

        $inc_header = (bool)filter_input(INPUT_POST, 'pboot_email_inc_default_header');

        if($inc_header)
        {
            update_post_meta($post_id, '_inc_default_header', 1);
        }
        else{
            delete_post_meta($post_id, '_inc_default_header');
        }

        $inc_footer = (bool)filter_input(INPUT_POST, 'pboot_email_inc_default_footer');

        if($inc_footer)
        {
            update_post_meta($post_id, '_inc_default_footer', 1);
        }
        else{
            delete_post_meta($post_id, '_inc_default_footer');
        }
    }

    public function renderMetaboxEmailActions($post)
    {
        $type_email = new Type_Email($post);
        ?>

        <p>
            <select name="pboot_email_action">
                <option value="">--</option>
                <?php foreach(Utils_Email::getEmailActions() as $h => $action_name): 
                    $selected = ($h == $type_email->getAction()) ? ' selected' : '';
                    ?>
                <option value="<?php echo $h; ?>"<?php echo $selected; ?>><?php echo $action_name; ?></option>
                <?php endforeach; ?>
            </select>
        </p>

        <!--<p>
            <label>
                <input type="checkbox" name="pboot_email_inc_default_header" value="1" <?php checked($type_email->hasDefaultHeader(), true); ?> />
                <?php _e('Include default header.', 'pboot'); ?>
            </label>
        </p>
        <p>
            <label>
                <input type="checkbox" name="pboot_email_inc_default_footer" value="1"<?php checked($type_email->hasDefaultFooter(), true); ?> />
                <?php _e('Include default footer.', 'pboot'); ?>
            </label>
        </p>-->
        <?php 
    }
}