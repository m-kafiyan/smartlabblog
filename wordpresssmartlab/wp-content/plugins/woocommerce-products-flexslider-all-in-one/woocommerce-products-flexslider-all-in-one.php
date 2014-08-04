<?php
/*
Plugin Name: WooCommerce Products FlexSlider all in one
Plugin URI: http://www.teastudio.pl/produkt/woocommerce-products-flexslider-all-in-one/
Description: WooCommerce Products FlexSlider all in one is a widget to show new, featured or popular products in Flexslider
Version: 1.0.1
Author: Marcin Gierada
Author URI: http://www.teastudio.pl/
Author Email: m.gierada@teastudio.pl
License: GPLv2 or later
License URI: http://www.gnu.org/licenses/gpl-2.0.html

This program is free software; you can redistribute it and/or modify
it under the terms of the GNU General Public License version 2 as published by
the Free Software Foundation.

This program is distributed in the hope that it will be useful,
but WITHOUT ANY WARRANTY; without even the implied warranty of
MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
GNU General Public License for more details.
*/

/*
 * plugin
 */
add_action('init', 'ap_action_init');
function ap_action_init()
{
    load_plugin_textdomain('woocommerce-products-flexslider-all-in-one', false, dirname(plugin_basename( __FILE__ )) .  '/i18n/languages/');
}

/**
 * Check if WooCommerce is active
 **/
if (in_array('woocommerce/woocommerce.php', apply_filters('active_plugins', get_option('active_plugins')))) 
{
    ob_start();

    //include required files based on admin or site
    if (is_admin()) 
        add_action('init', 'woo_products_flexslider_all_in_one_button');	
    else 
        require_once("shortcode-decode.class.php");

    /*
     * ajax page for shortcode generator
     */
    add_action('wp_ajax_woo_products_flexslider_all_in_one_shortcode_generator', 'shortcodeGenerator');
    function shortcodeGenerator() {
        require_once("shortcode-generator.php");
        exit();
    }
    
    
    
    /*
     * defaults and generator
     */
    require_once("slider-generator.class.php");  

    //register scripts	
    add_action('wp_enqueue_scripts', 'woo_products_flexslider_all_in_one_register_scripts');
    add_action('wp_head', 'woo_products_flexslider_all_in_one_wp_head');
    add_action('admin_head', 'woo_products_flexslider_all_in_one_wp_head');

  
    /*
    * function woo_products_flexslider_all_in_one_wp_head - adds the plugin url in the head tag
    */
    function woo_products_flexslider_all_in_one_wp_head() {
        echo '<script>var woo_products_flexslider_all_in_one_url="'.plugin_dir_url(__FILE__).'";</script>';
    }

  
    /*
    * function woo_products_flexslider_all_in_one_register_scripts - registers the scripts and styles
    */
    function woo_products_flexslider_all_in_one_register_scripts() {
        wp_register_script('jquery-flexslider', plugin_dir_url(__FILE__).'FlexSlider/jquery.flexslider-min.js', 'jquery');	
        wp_register_style('flexslider-style', plugin_dir_url(__FILE__). 'FlexSlider/flexslider.css'); 
    }


    /*
    * function woo_products_flexslider_all_in_one_initialize - initializes the plugin
    */
    function woo_products_flexslider_all_in_one_button() {
	    // check user permissions
	    if ( !current_user_can( 'edit_posts' ) && !current_user_can( 'edit_pages' ) ) {
	        return;
	    }        
        
        //adds button to the visual editor
        //if ( 'true' == get_user_option( 'rich_editing' ) )  {  
            add_filter('mce_external_plugins', 'add_woo_products_flexslider_all_in_one_plugin');  
            add_filter('mce_buttons', 'register_add_woo_products_flexslider_all_in_one_button');  
        //}  
    }
    add_action('admin_head', 'woo_products_flexslider_all_in_one_button');


    /*
    * function add_woo_products_flexslider_all_in_one_plugin - callback function
    */
    function add_woo_products_flexslider_all_in_one_plugin($plugin_array) {        
        $blog_version = floatval(get_bloginfo('version'));
        
        if($blog_version < 3.9) {
            $version = "plugin-3.6.js";
        }else {
            $version = "plugin-3.9.js";
        }

        $plugin_array['woo_products_flexslider_all_in_one_button'] = plugin_dir_url(__FILE__).'js/'.$version;
        return $plugin_array;
    }    
    
    
    /* 
    * function register_add_woo_products_flexslider_all_in_one_button - callback function
    */
    function register_add_woo_products_flexslider_all_in_one_button($buttons) {
        array_push($buttons, "woo_products_flexslider_all_in_one_button");
        return $buttons;
    }

}else
    return;




/*
 * widget
 */
class WooCommerceProductsFlexsliderAllInOneWidget extends WP_Widget 
{

    function wooCommerceProductsFlexsliderAllInOneWidget() {
        $widget_ops = array('classname' => 'widget_woo_products_flexslider_all_in_one','description' => __('Show new, featured or popular products in FlexSlider', 'woocommerce-products-flexslider-all-in-one'));
        $this->WP_Widget('woo_products_flexslider_all_in_one', __('WooCommerce Products FlexSlider All In One', 'woocommerce-products-flexslider-all-in-one'), $widget_ops);
    }

    function widget( $args, $instance ) {
        extract( $args );

        $title = apply_filters('widget_title', $instance['title']);

        echo $before_widget;

        if ( $title )
            echo $before_title . $title . $after_title;

        echo WooCommerceProductsSliderGenerator::generate($instance);
        echo $after_widget;
     }

    function update ($new_instance, $old_instance) {
        return $new_instance;
    }
  
/**
 * The configuration form.
 */
function form($instance) {
    /*
     * load defaults if new
     */
    if(empty($instance))
    {
        $instance = WooCommerceProductsSliderGenerator::getDefaults();
    }      
?>
<script type="text/javascript">
jQuery(function() {
  jQuery(".animationType").bind("change", function() {
    var item = jQuery(this).parents(".widget-content");

    if(jQuery(this).val() == "slide")
    {
      if(!jQuery(".stf", item).is(":visible"))
        jQuery(".stf").slideDown();
    }else
      jQuery(".stf").slideUp();    
  });
})        
</script>
    <p>
        <label for="<?php echo $this->get_field_id("title"); ?>"><?php _e('Title'); ?>:</label>        
        <input class="widefat" id="<?php echo $this->get_field_id("title"); ?>" name="<?php echo $this->get_field_name("title"); ?>" type="text" value="<?php echo esc_attr($instance["title"]); ?>" />
    </p>

    <p>
        <strong>--- <?php _e('Show', 'woocommerce-products-flexslider-all-in-one') ?> ---</strong>
    </p>
    <p>
        <label for="<?php echo $this->get_field_id("template"); ?>"><?php _e('Template', 'woocommerce-products-flexslider-all-in-one'); ?>:</label>
        <br />
        <select name="<?php echo $this->get_field_name("template"); ?>" id="<?php echo $this->get_field_id("template"); ?>" class="select">
            <?php            
              $files_list = scandir(plugin_dir_path(__FILE__)."templates/");
              unset($files_list[0]);
              unset($files_list[1]);
              foreach($files_list as $list) {
                echo "<option value=\"".$list."\" ". (esc_attr($instance["template"]) == $list ? 'selected=\"selected\"' : null) .">".$list."</option>";
              }
            ?>
        </select>
    </p>

    <p>
        <label for="<?php echo $this->get_field_id("show_only"); ?>"><?php _e('Show only', 'woocommerce-products-flexslider-all-in-one'); ?>:</label>
        <br />
        <select name="<?php echo $this->get_field_name("show_only"); ?>" id="<?php echo $this->get_field_id("show_only"); ?>" class="select">
          <?php            
            $show_list = array('newest' => __("Newset", 'woocommerce-products-flexslider-all-in-one'),
                               'popular' => __("Popular", 'woocommerce-products-flexslider-all-in-one'),
                               'featured' => __("Featured", 'woocommerce-products-flexslider-all-in-one')
                              );
            foreach($show_list as $key => $list) {
              echo "<option value=\"".$key."\" ". (esc_attr($instance["show_only"]) == $key ? 'selected="selected"' : null) .">".$list."</option>";
            }
          ?>
        </select>
    </p>

    <p>
        <label for="<?php echo $this->get_field_id("ordering"); ?>"><?php _e('Ordering', 'woocommerce-products-flexslider-all-in-one'); ?>:</label>
        <br />
        <select name="<?php echo $this->get_field_name("ordering"); ?>" id="<?php echo $this->get_field_id("ordering"); ?>" class="select">
          <?php            
            $ordering_list = array('asc' => __("Ascending", 'woocommerce-products-flexslider-all-in-one'),
                                   'desc' => __("Descending", 'woocommerce-products-flexslider-all-in-one')
                                  );
            foreach($ordering_list as $key => $list) {
              echo "<option value=\"".$key."\" ". (esc_attr($instance["ordering"]) == $key ? 'selected="selected"' : null) .">".$list."</option>";
            }
          ?>
        </select>
    </p>
    
    <p>
        <label for="<?php echo $this->get_field_id("categories"); ?>"><?php _e('Category IDs', 'woocommerce-products-flexslider-all-in-one'); ?>:</label>
        <input class="widefat" id="<?php echo $this->get_field_id("categories"); ?>" name="<?php echo $this->get_field_name("categories"); ?>" type="text" value="<?php echo esc_attr($instance["categories"]); ?>" />
        <br />
        <small><?php _e('Please enter Category IDs with comma seperated', 'woocommerce-products-flexslider-all-in-one') ?></small>
    </p>
    
    <p>
        <label for="<?php echo $this->get_field_id("all_items"); ?>"><?php _e('All items', 'woocommerce-products-flexslider-all-in-one'); ?>:</label>
        <input size="5" id="<?php echo $this->get_field_id("all_items"); ?>" name="<?php echo $this->get_field_name("all_items"); ?>" type="text" value="<?php echo esc_attr($instance["all_items"]); ?>" />
    </p>  
    
    <p>
        <label for="<?php echo $this->get_field_id("items_to_show"); ?>"><?php _e('Items to show', 'woocommerce-products-flexslider-all-in-one'); ?>:</label>
        <select name="<?php echo $this->get_field_name("items_to_show"); ?>" id="<?php echo $this->get_field_id("items_to_show"); ?>" class="select">
            <?php            
            $show_list = array('1' => __("1"),
                               '2' => __("2"),
                               '3' => __("3"),
                               '4' => __("4"),
                               '5' => __("5"),
                               '6' => __("6"),
                               );
            foreach($show_list as $key => $list) {
                echo "<option value=\"".$key."\" ". (esc_attr($instance["items_to_show"]) == $key ? 'selected="selected"' : null) .">".$list."</option>";
            }
            ?>
        </select>        
    </p>   
    
    <p>
        <strong>--- <?php _e('Diplay options', 'woocommerce-products-flexslider-all-in-one') ?> ---</strong>
    </p>  
    <p>  
        <input type="checkbox" class="checkbox" id="<?php echo $this->get_field_id("show_title"); ?>" name="<?php echo $this->get_field_name("show_title"); ?>" <?php checked( (bool) $instance["show_title"], true ); ?> value="1" />
        <label for="<?php echo $this->get_field_id("show_title"); ?>"><?php _e('Show title', 'woocommerce-products-flexslider-all-in-one'); ?></label>
    </p>
    <p>
        <input type="checkbox" class="checkbox" id="<?php echo $this->get_field_id("show_price"); ?>" name="<?php echo $this->get_field_name("show_price"); ?>" <?php checked( (bool) $instance["show_price"], true ); ?> value="1" />
        <label for="<?php echo $this->get_field_id("show_price"); ?>"><?php _e('Show price', 'woocommerce-products-flexslider-all-in-one'); ?></label>
    </p>    
    <p>
        <input type="checkbox" class="checkbox" id="<?php echo $this->get_field_id("show_description"); ?>" name="<?php echo $this->get_field_name("show_description"); ?>" <?php checked( (bool) $instance["show_description"], true ); ?> value="1" />
        <label for="<?php echo $this->get_field_id("show_description"); ?>"><?php _e('Show description', 'woocommerce-products-flexslider-all-in-one'); ?></label>
    </p>    
    <p>
        <input type="checkbox" class="checkbox" id="<?php echo $this->get_field_id("show_more_button"); ?>" name="<?php echo $this->get_field_name("show_more_button"); ?>" <?php checked( (bool) $instance["show_more_button"], true ); ?> value="1" />
        <label for="<?php echo $this->get_field_id("show_more_button"); ?>"><?php _e('Show more button', 'woocommerce-products-flexslider-all-in-one'); ?></label>
    </p> 
    <p>
        <input type="checkbox" class="checkbox" id="<?php echo $this->get_field_id("show_more_items_button"); ?>" name="<?php echo $this->get_field_name("show_more_items_button"); ?>" <?php checked( (bool) $instance["show_more_items_button"], true ); ?> value="1" />
        <label for="<?php echo $this->get_field_id("show_more_items_button"); ?>"><?php _e('Show more items button', 'woocommerce-products-flexslider-all-in-one'); ?></label>
    </p>     
    <p>
        <label for="<?php echo $this->get_field_id("image_source"); ?>"><?php echo _e('Image source', 'woocommerce-products-flexslider-all-in-one'); ?>:</label>
        <br />
        <select name="<?php echo $this->get_field_name("image_source"); ?>" id="<?php echo $this->get_field_id("image_source"); ?>" class="select">
            <?php            
              $source_list = array('thumbnail'  => __("Thumbnail"),
                                   'medium'     => __("Medium"),
                                   'large'      => __("Large"),
                                   'full'       => __("Full"),                  
                                  );
              foreach($source_list as $key => $list) {
                echo "<option value=\"".$key."\" ". (esc_attr($instance["image_source"]) == $key ? 'selected="selected"' : null) .">".$list."</option>";
              }
            ?>
        </select>
    </p>      
    <p>
        <label for="<?php echo $this->get_field_id("image_height"); ?>"><?php _e('Image height', 'woocommerce-products-flexslider-all-in-one'); ?>:</label>
        <br />
        <input size="10" id="<?php echo $this->get_field_id("image_height"); ?>" name="<?php echo $this->get_field_name("image_height"); ?>" type="text" value="<?php echo esc_attr($instance["image_height"]); ?>" />%
    </p>
    <p>
        <label for="<?php echo $this->get_field_id("image_width"); ?>"><?php _e('Image width', 'woocommerce-products-flexslider-all-in-one'); ?>:</label>
        <br />
        <input size="10" id="<?php echo $this->get_field_id("image_width"); ?>" name="<?php echo $this->get_field_name("image_width"); ?>" type="text" value="<?php echo esc_attr($instance["image_width"]); ?>" />%
    </p>      
    <p>
        <input type="checkbox" class="checkbox" id="<?php echo $this->get_field_id("navigation"); ?>" name="<?php echo $this->get_field_name("navigation"); ?>" <?php checked( (bool) $instance["navigation"], true ); ?> value="1" />
        <label for="<?php echo $this->get_field_id("navigation"); ?>"><?php _e('Arrows navigation', 'woocommerce-products-flexslider-all-in-one'); ?></label>
    </p>  
  
    
    <p>
        <strong>--- <?php _e('Animation options', 'woocommerce-products-flexslider-all-in-one') ?> ---</strong>
    </p>      
    <p>
        <input type="checkbox" class="checkbox" id="<?php echo $this->get_field_id("auto_start"); ?>" name="<?php echo $this->get_field_name("auto_start"); ?>" <?php checked( (bool) $instance["auto_start"], true ); ?> value="1" />
        <label for="<?php echo $this->get_field_id("auto_start"); ?>"><?php _e('Auto start', 'woocommerce-products-flexslider-all-in-one'); ?></label>
    </p>   
    <p>
        <input type="checkbox" class="checkbox" id="<?php echo $this->get_field_id("animation_loop"); ?>" name="<?php echo $this->get_field_name("animation_loop"); ?>" <?php checked( (bool) $instance["animation_loop"], true ); ?> value="1"/>
        <label for="<?php echo $this->get_field_id("animation_loop"); ?>"><?php _e('Animation loop', 'woocommerce-products-flexslider-all-in-one'); ?></label>
    </p> 
    <p>
        <input type="checkbox" class="checkbox" id="<?php echo $this->get_field_id("pause_on_hover"); ?>" name="<?php echo $this->get_field_name("pause_on_hover"); ?>" <?php checked( (bool) $instance["pause_on_hover"], true ); ?> value="1"/>
        <label for="<?php echo $this->get_field_id("pause_on_hover"); ?>"><?php _e('Animation pause on hover', 'woocommerce-products-flexslider-all-in-one'); ?></label>
    </p>       
    <p>
        <label for="<?php echo $this->get_field_id("animation"); ?>"><?php _e('Animation', 'woocommerce-products-flexslider-all-in-one'); ?>:</label>
        <br />
        <select name="<?php echo $this->get_field_name("animation"); ?>" id="<?php echo $this->get_field_id("animation"); ?>" class="select animationType">
            <?php            
              $animation_list = array('fade'  => __("Fade", 'woocommerce-products-flexslider-all-in-one'),
                                      'slide' => __("Slide", 'woocommerce-products-flexslider-all-in-one'),                 
                                     );
              foreach($animation_list as $key => $list) {
                echo "<option value=\"".$key."\" ". (esc_attr($instance["animation"]) == $key ? 'selected="selected"' : null) .">".$list."</option>";
              }
            ?>
        </select>
    </p> 
    <p>
        <label for="<?php echo $this->get_field_id("animation_duration"); ?>"><?php _e('Animation duration', 'woocommerce-products-flexslider-all-in-one'); ?>:</label>
        <br />
        <input size="10" id="<?php echo $this->get_field_id("animation_duration"); ?>" name="<?php echo $this->get_field_name("animation_duration"); ?>" type="text" value="<?php echo esc_attr($instance["animation_duration"]); ?>" />[ms]
    </p>     
   
    <div class="widget stf" style="width:90%;border-left:3px solid #6EA832;padding:5px 5px 0 5px;<?php echo (esc_attr(array_key_exists('animation', $instance)) && esc_attr($instance["animation"]) == "slide") ? null : ' display:none;' ?>">
        <p>
            <label for="<?php echo $this->get_field_id("slide_speed"); ?>"><?php _e('Slide speed', 'woocommerce-products-flexslider-all-in-one'); ?>:</label>
            <br />
            <input size="10" id="<?php echo $this->get_field_id("slide_speed"); ?>" name="<?php echo $this->get_field_name("slide_speed"); ?>" type="text" value="<?php echo esc_attr($instance["slide_speed"]); ?>" />[ms]
        </p>   
        <p>
            <label for="<?php echo $this->get_field_id("slide_direction"); ?>"><?php _e('Animation', 'woocommerce-products-flexslider-all-in-one'); ?>:</label>
            <br />
            <select name="<?php echo $this->get_field_name("slide_direction"); ?>" id="<?php echo $this->get_field_id("slide_direction"); ?>" class="select">
                <?php            
                  $direction_list = array('horizontal' => __("Horizontal", 'woocommerce-products-flexslider-all-in-one'),
                                          'vertical' => __("Vertical", 'woocommerce-products-flexslider-all-in-one'),                 
                                         );
                  foreach($direction_list as $key => $list) {
                    echo "<option value=\"".$key."\" ". (esc_attr($instance["slide_direction"]) == $key ? 'selected="selected"' : null) .">".$list."</option>";
                  }
                ?>
            </select>
        </p>       
     </div>
<?php
    }
}
add_action('widgets_init', create_function('', 'return register_widget("WooCommerceProductsFlexsliderAllInOneWidget");'));
?>