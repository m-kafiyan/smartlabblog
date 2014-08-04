<?php
/*
Author: Marcin Gierada
Author URI: http://www.teastudio.pl/
Author Email: m.gierada@teastudio.pl
License: GPLv2 or later
License URI: http://www.gnu.org/licenses/gpl-2.0.html
*/

class WooCommerceProductsSliderGenerator {
    
    public static function generateId()
    {
        return rand();
    }
    
    public static function getDefaults()
    {
        return array(
                    'id'                      =>  self::generateId(),
                    'template'                =>  'default.css',
                    'show'                    =>  'newest',
                    'ordering'                =>  'asc',
                    'categories'              =>  '',
                    'all_items'               =>  5,
                    'items_to_show'           =>  1,

                    'show_title'              =>  'true',
                    'show_price'              =>  'true',
                    'show_description'        =>  'true',
                    'show_more_button'        =>  'true',
                    'show_more_items_button'  =>  'true',         
                    'image_source'            =>  'thumbnail',            
                    'image_width'             =>  '100',
                    'image_height'            =>  '100',
                    'navigation'              =>  'true', 

                    'animation'               =>  'fade',
                    'animation_duration'      =>  600,
                    'slide_speed'             =>  4000,            
                    'auto_start'              =>  'false',
                    'slide_direction'         =>  'horizontal',			
                    
                    'animation_loop'          =>  'true',
                    'pause_on_hover'          =>  'true'
                   );        
    }
    
    
    public static function generate($atts)
    {
        global $obj;
        global $post;

        //default parameters
        $params = self::prepareSettings($atts);

        /*
         * generate jquery script for FlexSlider
         */
        $out = self::flexslider($params);

        /*
         * print styles
         */
        wp_print_scripts('jquery-flexslider');
        wp_print_styles('flexslider-style');

        wp_enqueue_style('woo_products_flexslider_all_in_one-flexslider-style-custom', plugin_dir_url( __FILE__ ).'templates/'.$params['template']);
        wp_print_styles('woo_products_flexslider_all_in_one-flexslider-style-custom');

        //vertical style    
        if($params['slide_direction'] == "vertical") 
            $direction = ' vertical';
        else
            $direction = null;

        //prepare html and loop
        $out .= '<div class="woocommerce-products-flexslider-'.$params['id']. ' flexslider' .$direction.' woocommerce-products-flexslider-all-in-one">';
        $out .= '<ul class="slides">';

        /*
         * prepare sql query
         */
        $sql_array = array('post_type'      =>  'product',                
                           'post_status'    =>  'publish',
                           'order'          =>  $params['ordering'],
                           'posts_per_page' =>  $params['all_items'],
                           'no_found_rows'  =>  1,
                           'meta_value' => 'yes', 
                           'post__not_in' =>  array($post->ID) //exclude current post
                           );

        if($params['categories'] != "")
        {
            $sql_array['tax_query'] = array(array('taxonomy'  =>  'product_cat',
                                                  'field'     =>  'id',
                                                  'terms'     =>  explode(',', $params['categories']),
                                                  'operator'  => 'IN'
                                                 ));
        }

        if($params['show'] == "popular")
        {
            $sql_array['meta_key'] = 'total_sales';
            $sql_array['orderby'] = 'meta_value_num';
        }
        else if($params['show'] == "featured")
        {
            $sql_array['meta_key'] = '_featured';
            $sql_array['orderby'] = 'date';
        }
        else
            $sql_array['orderby'] = 'date';    
        /*
         * end sql query
         */

        $loop = new WP_Query($sql_array);

        //products loop
        $index = 0;    

        while($loop->have_posts())
        {
            $loop->the_post();            
   
            //create product object
            $product_obj = get_product($post->ID);

            $title = '';
            $description = '';
            $price = '';
            $buttons = '';
            $class = "one-slide";

            $prod_url = esc_url( get_permalink(apply_filters('woocommerce_in_cart_product', $product_obj->id)) );
            $shop_url = esc_url( get_permalink(woocommerce_get_page_id('shop')));

            $featured_img = wp_get_attachment_image_src( get_post_thumbnail_id($product_obj->id),$params['image_source']);

            //if no featured image for the product
            if($featured_img[0] == '' || $featured_img[0] == '/')
                $featured_img[0] = plugin_dir_url( __FILE__ ).'images/placeholder.png';   

            //show price
            if($params['show_price'] == "true") 
            {
                if(get_option('woocommerce_display_cart_prices_excluding_tax')=='yes')        
                    $price = apply_filters('woocommerce_cart_item_price_html', woocommerce_price( $product_obj->get_price_excluding_tax() )); 
                else
                    $price = apply_filters('woocommerce_cart_item_price_html', woocommerce_price( $product_obj->get_price() ));         

                $price = '<span class="woocommerce-products-flexslider-all-in-one-prie">'.$price.'</span>';
                //if product variables
                if($product_obj->product_type == 'variable')
                    $price = '<span class="woocommerce-products-flexslider-all-in-one-amount">'.__('From', 'woocommerce-products-flexslider-all-in-one').'</span>'.$price;
            }

            //show title
            if($params['show_title'] == "true")
            {
                $title = '<h3 class="woocommerce-products-flexslider-all-in-one-title">';
                    $title .= '<a href="'.$prod_url.'">'.$product_obj->post->post_title.'</a>';
                $title .= '</h3>';                 
            }

            //show description
            if($params['show_description'] == "true") 
            {
                $description = '<div class="woocommerce-products-flexslider-all-in-one-desc">'.$product_obj->post->post_excerpt.'</div>';
            }      

            //show buttons
            if($params['show_more_button'] == "true" || $params['show_more_items_button'] == "true")
            {
                $buttons = '<p class="woocommerce-products-flexslider-all-in-one-buttons">';

                if($params['show_more_button'] == "true")
                {          
                    if($product_obj->is_downloadable())
                        $buttons .= '<a href="'.$prod_url.'" class="woocommerce-products-flexslider-all-in-one-more-button btn btn-primary" title="'.__('Download', 'woocommerce-products-flexslider-all-in-one').': '.$post->post->post_title.'">'.__('<i class="icon-download-alt icon-"></i> download', 'woocommerce-products-flexslider-all-in-one').'</a>';
                    else
                        $buttons .= '<a href="'.$prod_url.'" class="woocommerce-products-flexslider-all-in-one-more-button btn btn-primary" title="'.__('Show item', 'woocommerce-products-flexslider-all-in-one').': '.$post->post->post_title.'">'.__('show item', 'woocommerce-products-flexslider-all-in-one').'</a>';
                }

                if($params['show_more_items_button'] == "true")
                    $buttons .= '<a href="'.$shop_url.'" class="woocommerce-products-flexslider-all-in-one-more-items-button btn btn-default" title="'.__('Show more items', 'woocommerce-products-flexslider-all-in-one').'">'.__('show more items', 'woocommerce-products-flexslider-all-in-one').'</a>';

                $buttons .= '</p>';
            }          

            //list products
            if($index % $params['items_to_show'] == 0) 
              $out .= '<li>';    


            switch($params['items_to_show'])
            {
              case "1":
                $class = "one-slide";
                break;
              case "2":
                $class = "two-slides";
                break;
              case "3":
                $class = "three-slides";
                break;
              case "4":
                $class = "four-slides";
                break;
              case "5":
                $class = "five-slides";
                break;
              case "6":
                $class = "six-slides";
                break;          
            }       

            $out .= '<div class="woocommerce-products-flexslider-all-in-one-slide '.$class.'">';
                $out .= '<div class="woocommerce-products-flexslider-all-in-one-container">';

                    $out .= '<div class="woocommerce-products-flexslider-all-in-one-image">';
                        $out .= '<a href="'.$prod_url.'" title="'.__('Show item', 'woocommerce-products-flexslider-all-in-one').': '.$product_obj->post->post_title.'">';
                            $out .= '<img src="'.$featured_img[0].'" alt="'.$product_obj->post->post_title.'" style="max-width:'.$params['image_width'].'%;max-height:'.$params['image_height'].'%">';
                        $out .= '</a>';
                    $out .= '</div>';

                    $out .= '<div class="woocommerce-products-flexslider-all-in-one-details">';
                        $out .= $title;
                        $out .= $description;
                        $out .= $price;
                        $out .= $buttons;              
                    $out .= '</div>';

                $out .= '</div>';
            $out .= '</div>';

            $index++;

            if($index % $params['items_to_show'] == 0) 
                $out .='</li>';	
        }

        $out .= '</ul>';
        $out .= '</div>';

        echo $out;
    }
    
    static function flexslider($params = array()) 
    { 
        if(empty($params))
            return false;

        $out = '<script type="text/javascript">
        /* <![CDATA[ */
            jQuery(document).ready(function() {
                jQuery(window).load(function() {
                    jQuery(".woocommerce-products-flexslider-'.$params['id'].'").flexslider({
                        animation: "'.$params['animation'].'",
                        controlsContainer: ".flex-container",
                        slideshow: '.$params['auto_start'].',
                        slideDirection: "'.$params['slide_direction'].'",
                        slideshowSpeed: '.$params['slide_speed'].',
                        animationDuration: '.$params['animation_duration'].',
                        directionNav: '.$params['navigation'].',
                        controlNav: false,
                        animationLoop: '.$params['animation_loop'].',
                        pauseOnAction: true,
                        pauseOnHover: '.$params['pause_on_hover'].',				  
                        mousewheel: false,		
                        prevText: "'.__('Previous', 'woocommerce-products-flexslider-all-in-one').'",
                        nextText: "'.__('Next', 'woocommerce-products-flexslider-all-in-one').'",
                        pauseText: "'.__('Pause', 'woocommerce-products-flexslider-all-in-one').'",
                        playText: "'.__('Play', 'woocommerce-products-flexslider-all-in-one').'"
                    });
                });
            });
        /* ]]> */
        </script>';

        echo $out;
    }    
    
    
    public static function prepareSettings($settings)
    {
        $checkboxes = array(
                            'show_title',
                            'show_price',
                            'show_description',
                            'show_more_button',
                            'show_more_items_button',      
                            'navigation',         
                            'auto_start',
                            'pause_play',
                            'animation_loop',
                            'pause_on_hover'
                             );
        
        foreach($checkboxes as $v)
        {
            if(!array_key_exists($v, $settings))
                $settings[$v] = 'false';
            else
                $settings[$v] = ($settings[$v] == 1 || $settings[$v] == "true") ? "true" : "false";
        }
        
        $settings['id'] = self::generateId();
        
        return $settings;
    }
}
