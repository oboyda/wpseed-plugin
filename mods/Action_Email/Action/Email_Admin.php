<?php 

namespace PBOOT\Mod\Action_Email\Action;

use PBOOT\Mod\Action_Email\Type\Email as Type_Email;
use PBOOT\Mod\Action_Email\Utils\Email as Utils_Email;

class Email_Admin extends \WPSEED\Action 
{
    protected $meta_box_updated;

    public function __construct()
    {
        parent::__construct();
        
        add_action('add_meta_boxes', [$this, 'addMetaBox']);
        add_action('save_post_pboot_action_email', [$this, 'saveMetaBoxData']);
    }

    public function addMetaBox()
    {
        add_meta_box(
            'email-actions-metabox', 
            __('Email details', 'pboot'), 
            [$this, 'renderMetaboxEmailActions'], 
            'pboot_action_email',
            // 'side'
        );
    }

    public function saveMetaBoxData($post_id)
    {
        if(!empty($this->meta_box_updated))
        {
            return;
        }

        $email_action = $this->getReq('pboot_email_action__action', 'text', '');
        $email_subject = $this->getReq('pboot_email_action__subject', 'text', '');
        $inc_default_header = (bool)$this->getReq('pboot_email_action__inc_default_header');
        $inc_default_footer = (bool)$this->getReq('pboot_email_action__inc_default_footer');

        $type_email = new Type_Email($post_id);

        $type_email->set_prop('email_action', $email_action);
        $type_email->set_prop('email_subject', $email_subject);
        $type_email->set_prop('inc_default_header', $inc_default_header);
        $type_email->set_prop('inc_default_footer', $inc_default_footer);

        $this->meta_box_updated = true;

        $type_email->persist();
    }

    public function renderMetaboxEmailActions($post)
    {
        $type_email = new Type_Email($post);
        ?>

        <table class="form-table">
            <tbody>
            <tr>
                <th><label><?php _e('Email action', 'pboot'); ?></label></th>
                <td>
                    <select name="pboot_email_action__action">
                        <option value="">--</option>
                        <?php 
                        foreach(Utils_Email::getEmailActions() as $h => $action_name): 
                            $selected = ($h == $type_email->get_email_action()) ? ' selected' : '';
                            ?>
                        <option value="<?php echo $h; ?>"<?php echo $selected; ?>><?php echo $action_name; ?></option>
                        <?php endforeach; ?>
                    </select>
                </td>
            </tr>

            <?php if(!in_array($type_email->get_email_action(), ['default_header', 'default_footer'])): ?>
            <tr>
                <th><label><?php _e('Email subject', 'pboot'); ?></label></th>
                <td>
                    <input type="text" class="regular-text" name="pboot_email_action__subject" value="<?php echo $type_email->get_email_subject(); ?>" />
                </td>
            </tr>
            <?php endif; ?>

            <?php if(!in_array($type_email->get_email_action(), ['default_header', 'default_footer'])): ?>
            <tr>
                <th><label><?php _e('Include default header.', 'pboot'); ?></label></th>
                <td>
                    <input type="checkbox" name="pboot_email_action__inc_default_header" value="1" <?php checked($type_email->has_inc_default_header(), true); ?> />
                </td>
            </tr>
            <?php endif; ?>

            <?php if(!in_array($type_email->get_email_action(), ['default_header', 'default_footer'])): ?>
            <tr>
                <th><label><?php _e('Include default footer.', 'pboot'); ?></label></th>
                <td>
                    <input type="checkbox" name="pboot_email_action__inc_default_footer" value="1"<?php checked($type_email->has_inc_default_footer(), true); ?> />
                </td>
            </tr>
            <?php endif; ?>

            </tbody>
        </table>
        <?php 
    }
}