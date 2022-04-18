<?php 

namespace TILEC\Metabox;

use TILEC\Type\Product;
use TILEC\Utils_Settings;
use WPSEED\Req;

class Product_Tile 
{
    const METABOX_ID = 'tilec_product_tile';

    public function __construct()
    {
        add_action('add_meta_boxes', __CLASS__ . '::registerMetaBox');
        add_action('save_post', __CLASS__ . '::saveMetaBox', 10, 2);
    }

    static function registerMetaBox()
    {
        add_meta_box(
            self::METABOX_ID, 
            __('Tile Config', 'tilec'), 
            __CLASS__ . '::displayMetaBox', 
            'product'
        );
    }

    static function displayMetaBox($post)
    {
        $product = new Product($post);
        ?>
        <div class="metabox-fields">
            <p class="metabox-field">
                <label for="tile_width"><?php _e('Tile width', 'tilec'); ?></label><br />
                <input type="number" id="tile_width" name="tile_width" step="<?php echo Utils_Settings::getTileSize(); ?>" min="0" class="regular-text" value="<?php echo $product->getTileWidth(); ?>" />
            </p>
            <p class="metabox-field">
                <label for="tile_height"><?php _e('Tile height', 'tilec'); ?></label><br />
                <input type="number" id="tile_height" name="tile_height" step="<?php echo Utils_Settings::getTileSize(); ?>" min="0" class="regular-text" value="<?php echo $product->getTileHeight(); ?>" />
            </p>
        </div>
        <?php 
    }

    static function saveMetaBox($post_id, $post)
    {
        if($post->post_type === 'product')
        {
            $req = new Req();
            foreach(Product::_get_props_config() as $key => $prop_config)
            {
                if(isset($prop_config['metabox_id']) && $prop_config['metabox_id'] === self::METABOX_ID)
                {
                    $sanitize = isset($prop_config['input_sanitize']) ? $prop_config['input_sanitize'] : 'text';
                    $value = $req->get($key, $sanitize);
                    if($value)
                    {
                        update_post_meta($post_id, $key, $value);
                    }else{
                        delete_post_meta($post_id, $key);
                    }
                }
            }
        }
    }
}