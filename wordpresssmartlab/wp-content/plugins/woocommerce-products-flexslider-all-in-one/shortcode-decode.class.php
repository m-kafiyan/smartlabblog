<?php
/*
Author: Marcin Gierada
Author URI: http://www.teastudio.pl/
Author Email: m.gierada@teastudio.pl
License: GPLv2 or later
License URI: http://www.gnu.org/licenses/gpl-2.0.html
*/

class WooCommerceProductsFlexsliderAllInOneShortcodeDecode 
{	
    public function initialize($atts, $content = null, $code = "") 
    {		
        WooCommerceProductsSliderGenerator::generate($atts);
    }
}
add_shortcode("woo_products_flexslider_all_in_one", array("WooCommerceProductsFlexsliderAllInOneShortcodeDecode", "initialize"));
?>