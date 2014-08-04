(function() {
    tinymce.create('tinymce.plugins.woo_products_flexslider_all_in_one_button', {
        init : function(ed, url) {            
            ed.addButton('woo_products_flexslider_all_in_one_button', {
                title : 'WooCommerce Products FlexSlider All In One',
                image : url+'/../images/shortcode-icon.png',
                onclick : function() {
                    var width = jQuery(window).width(), H = jQuery(window).height(), W = ( 720 < width ) ? 720 : width;
                    W = W - 80;
                    H = 300;                       
                    tb_show('WooCommerce Products FlexSlider All In One','admin-ajax.php?action=woo_products_flexslider_all_in_one_shortcode_generator&width=' + W + '&height=' + H );
               }
            });
        },
        createControl : function(n, cm) {
            return null;
        },
    });
    tinymce.PluginManager.add('woo_products_flexslider_all_in_one_button', tinymce.plugins.woo_products_flexslider_all_in_one_button);
})();