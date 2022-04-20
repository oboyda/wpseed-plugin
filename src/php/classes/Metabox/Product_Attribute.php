<?php 

namespace TILEC\Metabox;

use TILEC\Utils_Product;
use WPSEED\Req;

class Product_Attribute 
{
    public function __construct()
    {
        add_action('init', __CLASS__ . '::addColorHexField');
    }

    static function addColorHexField()
    {
        $color_tax = Utils_Product::getColorTaxonomy();
        if($color_tax)
        {
            add_action($color_tax . '_add_form_fields', __CLASS__ . '::addColorHexFieldNewForm');
            add_action($color_tax . '_edit_form_fields', __CLASS__ . '::addColorHexFieldEditForm', 10, 2);

            add_action('created_' . $color_tax, __CLASS__ . '::saveColorHexField');
            add_action('edited_' . $color_tax, __CLASS__ . '::saveColorHexField');
        }
    }

    static function addColorHexFieldNewForm($taxonomy)
    {
        ?>
        <div class="form-field">
            <label for="color_hex"><?php _e('Color hex code', 'tilec'); ?></label>
            <input type="text" name="color_hex" id="color_hex" />
        </div>
        <?php
    }

    static function addColorHexFieldEditForm($term, $taxonomy)
    {
        $value = get_term_meta($term->term_id, 'color_hex', true);
        ?>
        <tr class="form-field">
            <th>
                <label for="misha-text"><?php _e('Color hex code', 'tilec'); ?></label>
            </th>
            <td>
            <input type="text" name="color_hex" id="color_hex" value="<?php echo esc_attr($value); ?>" />
            </td>
        </tr>
        <?php 
    }

    static function saveColorHexField($term_id)
    {
        $req = new Req();
        $value = $req->get('color_hex', 'text');

        if($value)
        {
            update_term_meta($term_id, 'color_hex', $value);
        }else{
            delete_term_meta($term_id, 'color_hex');
        }
    }
}