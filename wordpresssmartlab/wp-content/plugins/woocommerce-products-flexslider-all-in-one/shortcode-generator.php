<?php
/*
Author: Marcin Gierada
Author URI: http://www.teastudio.pl/
Author Email: m.gierada@teastudio.pl
License: GPLv2 or later
License URI: http://www.gnu.org/licenses/gpl-2.0.html
*/

?>
		
    <style type="text/css">
      table {font-size:12px;}
      .stf {display:none;border-left:3px solid #6EA832;padding:0;}
    </style>
    <script type="text/javascript">
    function insert_shortcode() {
      var shortcode = '[woo_products_flexslider_all_in_one';
      
      /*
       * show
       */
      shortcode += ' template="'+jQuery('#template').val()+'"';
      shortcode += ' ordering="'+jQuery('#ordering').val()+'"';
      
      if(jQuery('#categories').val() != "")
        shortcode += ' categories="'+jQuery('#categories').val()+'"';
      
      shortcode += ' all_items="'+jQuery('#all_items').val()+'"';
      shortcode += ' items_to_show="'+jQuery('#items_to_show').val()+'"';
      
      /*
       * display options
       */
      
      //show title
      if(jQuery('#show_title').is(':checked'))
        shortcode +=' show_title="true"';
      else
        shortcode +=' show_title="false"';       
      
      //show price
      if(jQuery('#show_price').is(':checked'))
        shortcode +=' show_price="true"';
      else
        shortcode +=' show_price="false"';  
      
      if(jQuery('#show_description').is(':checked'))
        shortcode +=' show_description="true"';
      else
        shortcode +=' show_description="false"';         
      
      if(jQuery('#show_more_button').is(':checked'))
        shortcode +=' show_more_button="true"';
      else
        shortcode +=' show_more_button="false"';    
      
      if(jQuery('#show_more_items_button').is(':checked'))
        shortcode +=' show_more_items_button="true"';
      else
        shortcode +=' show_more_items_button="false"'; 
      
      
      //image source
      shortcode += ' image_source="'+jQuery('#image_source').val()+'"';

      //image width
      if(jQuery('#image_width').val() != "")
        shortcode +=' image_width="'+jQuery('#image_width').val()+'"';

      //image height
      if(jQuery('#image_height').val() != "")
        shortcode +=' image_height="'+jQuery('#image_height').val()+'"';      

      //navigation
      if(jQuery('#navigation').is(':checked'))
        shortcode +=' navigation="true"';   
      else
        shortcode +=' navigation="false"'; 
      
      /*
       * animation options
       */      
      
      //animation
      shortcode += ' animation="'+jQuery('#animation').val()+'"';

      //animation_loop
      if(jQuery('#animation_loop').is(':checked'))
        shortcode +=' animation_loop="true"';   
      else
        shortcode +=' animation_loop="false"';  
    
      //pause_on_hover
      if(jQuery('#pause_on_hover').is(':checked'))
        shortcode +=' pause_on_hover="true"';   
      else
        shortcode +=' pause_on_hover="false"'; 
      
      //autostart
      if(jQuery('#auto_start').is(':checked'))
        shortcode +=' auto_start="true"';
      else
        shortcode +=' auto_start="false"';          
      
      //animation speed
      shortcode +=' animation_duration="'+jQuery('#animation_duration').val()+'"';

      //slide animation parameters
      if(jQuery('#animation').val() == "slide") 
      {
        //slide speed
        if(jQuery('#slide_speed').val() != "")
          shortcode +=' slide_speed="'+jQuery('#slide_speed').val()+'"';        

        //slide direction
        shortcode +=' slide_direction="'+jQuery('#slide_direction').val()+'"';        
      }

      shortcode +=']';

      tinyMCE.activeEditor.execCommand('mceInsertContent', 0, shortcode);
      tb_remove();
    }

    //animation parameters for "slide" type
    jQuery('.animationType').change(function() {
      if(jQuery(this).val() == "fade")
        jQuery('.stf').css('display','none');
      else
        jQuery('.stf').css('display','block');      
    });
    </script>

        <div class="widget">
            <table cellspacing="5" cellpadding="5">
                <tr>
                    <td colspan="2" align="left"><strong>---<?php _e('Show', 'woocommerce-products-flexslider-all-in-one') ?>---</strong></td>
                </tr>
                <tr>
                    <td align="left"><?php _e('Template', 'woocommerce-products-flexslider-all-in-one'); ?>:</td>
                    <td>
                        <select name="template" id="template" class="select">
                            <?php
                                $files_list = scandir(plugin_dir_path(__FILE__).'templates');
                                unset($files_list[0]);
                                unset($files_list[1]);
                                foreach($files_list as $filename) {
                                    echo "<option value=\"".$filename."\">".$filename."</option>";
                                }
                            ?>
                        </select>	
                    </td>
                </tr>  

                <tr>
                    <td align="left"><?php _e('Ordering', 'woocommerce-products-flexslider-all-in-one'); ?>:</td>
                    <td>
                        <select name="ordering" id="ordering" class="select">
                            <option value="asc"><?php _e("Ascending", 'woocommerce-products-flexslider-all-in-one') ?></option>
                            <option value="desc"><?php _e("Descending", 'woocommerce-products-flexslider-all-in-one') ?></option>              
                        </select>	
                    </td>
                </tr>   
                <tr>
                    <td align="left"><?php _e('Category IDs', 'woocommerce-products-flexslider-all-in-one'); ?>:</td>
                    <td>
                        <input type="text" name="categories" id="categories" value="" size="30">
                        <br />
                        <small><?php _e('Please enter Category IDs with comma seperated', 'woocommerce-products-flexslider-all-in-one') ?></small>
                    </td>
                </tr>     
                <tr>
                    <td align="left"><?php _e('All items', 'woocommerce-products-flexslider-all-in-one'); ?>:</td>
                    <td>
                        <input type="text" name="all_items" id="all_items" value="5" size="5">
                    </td>
                </tr> 
                <tr>
                    <td align="left"><?php _e('Items to show', 'woocommerce-products-flexslider-all-in-one'); ?>:</td>
                    <td>
                        <select name="items_to_show" id="items_to_show" class="select">
                            <option value="1"><?php _e("1") ?></option>
                            <option value="2"><?php _e("2") ?></option>
                            <option value="3"><?php _e("3") ?></option>
                            <option value="4"><?php _e("4") ?></option>
                            <option value="5"><?php _e("5") ?></option>
                            <option value="6"><?php _e("6") ?></option>
                        </select>
                    </td>
                </tr>   


                <tr>
                    <td colspan="2" align="left">
                        <br />
                        <strong>---<?php _e('Diplay options', 'woocommerce-products-flexslider-all-in-one') ?>---</strong>
                    </td>
                </tr>  
                <tr>
                    <td align="left"><?php _e('Show title', 'woocommerce-products-flexslider-all-in-one'); ?>:</td>
                    <td>
                        <input type="checkbox" value="1" name="show_title" id="show_title" checked="checked">
                    </td>
                </tr>	
               <tr>
                    <td align="left"><?php _e('Show price', 'woocommerce-products-flexslider-all-in-one'); ?>:</td>
                    <td>
                        <input type="checkbox" value="1" name="show_price" id="show_title" checked="checked">
                    </td>
                </tr>
                <tr>
                    <td><?php _e('Show description', 'woocommerce-products-flexslider-all-in-one'); ?>:</td>
                    <td>
                        <input type="checkbox" value="1" name="show_description" id="show_description" checked="checked">
                    </td>
                </tr>
                <tr>
                    <td><?php _e('Show more button', 'woocommerce-products-flexslider-all-in-one'); ?>:</td>
                    <td>
                        <input type="checkbox" value="1" name="show_more_button" id="show_more_button" checked="checked">
                    </td>
                </tr>
                <tr>
                    <td><?php _e('Show more items button', 'woocommerce-products-flexslider-all-in-one'); ?>:</td>
                    <td>
                        <input type="checkbox" value="1" name="show_more_items_button" id="show_more_items_button" checked="checked">
                    </td>
                </tr>        


                <tr>
                    <td align="left"><?php echo _e('Image source', 'woocommerce-products-flexslider-all-in-one'); ?>:</td>
                    <td>
                        <select name="image_source" id="image_source" class="select">
                            <option value="thumbnail"><?php _e("Thumbnail") ?></option>
                            <option value="medium"><?php _e("Medium") ?></option>
                            <option value="large"><?php _e("Large") ?></option>
                            <option value="full"><?php _e("Full") ?></option>
                        </select>
                    </td>
                </tr>	
                <tr>
                    <td align="left"><?php _e('Image height', 'woocommerce-products-flexslider-all-in-one'); ?>:</td>
                    <td>
                        <input type="text" name="image_height" id="image_height" value="100" size="5">%
                    </td>
                </tr>
                <tr>
                    <td align="left"><?php _e('Image width', 'woocommerce-products-flexslider-all-in-one'); ?>:</td>
                    <td>
                        <input type="text" name="image_width" id="image_width" value="100" size="5">%
                    </td>
                </tr>	
                <tr>
                    <td align="left"><?php _e('Arrows navigation', 'woocommerce-products-flexslider-all-in-one'); ?>:</td>
                    <td>
                        <input type="checkbox" value="1" name="navigation" id="navigation" checked="checked">
                    </td>
                </tr>	


                <tr>
                    <td colspan="2" align="left">
                        <br />
                        <strong>---<?php _e('Animation options', 'woocommerce-products-flexslider-all-in-one') ?>---</strong>
                    </td>
                </tr>  
                <tr>
                    <td align="left"><?php _e('Auto start', 'woocommerce-products-flexslider-all-in-one'); ?>:</td>
                    <td>
                        <input type="checkbox" value="1" name="auto_start" id="auto_start">
                    </td>
                </tr>	   
                <tr>
                    <td align="left"><?php _e('Animation loop', 'woocommerce-products-flexslider-all-in-one'); ?>:</td>
                    <td>
                        <input type="checkbox" value="1" name="animation_loop" id="animation_loop">
                    </td>
                </tr>	 
                <tr>
                    <td align="left"><?php _e('Animation pause on hover', 'woocommerce-products-flexslider-all-in-one'); ?>:</td>
                    <td>
                        <input type="checkbox" value="1" name="pause_on_hover" id="pause_on_hover">
                    </td>
                </tr>                
                <tr>
                    <td align="left"><?php _e('Animation', 'woocommerce-products-flexslider-all-in-one'); ?>:</td>
                    <td>    
                        <select name="animation" id="animation" class="select animationType">
                            <option value="fade"><?php _e("Fade", 'woocommerce-products-flexslider-all-in-one') ?></option>
                            <option value="slide"><?php _e("Slide", 'woocommerce-products-flexslider-all-in-one') ?></option>
                        </select>
                    </td>
                </tr>
                <tr>
                    <td align="left"><?php _e('Animation duration', 'woocommerce-products-flexslider-all-in-one'); ?>:</td>
                    <td>
                        <input type="text" name="animation_duration" id="animation_duration" value="600" size="5">[ms]
                    </td>
                </tr>		
                <tr>
                    <td colspan="2">
                        <div class="stf">
                            <table cellspacing="5" cellpadding="5" border="0" width="100%" class="widget">
                                <tr>
                                    <td width="150" align="left"><?php _e('Slide speed', 'woocommerce-products-flexslider-all-in-one'); ?>:</td>
                                    <td>
                                        <input type="text" name="slide_speed" id="slide_speed" value="4000" size="5">[ms]
                                    </td>
                                </tr>					
                                <tr>
                                    <td width="150" align="left"><?php _e('Orientation', 'woocommerce-products-flexslider-all-in-one'); ?>:</td>
                                    <td>
                                        <select name="slide_direction" id="slide_direction" class="select">
                                            <option value="horizontal"><?php _e("Horizontal", 'woocommerce-products-flexslider-all-in-one') ?></option>
                                            <option value="vertical"><?php _e("Vertical", 'woocommerce-products-flexslider-all-in-one') ?></option>
                                        </select>
                                    </td>
                                </tr>	
                            </table>
                        </div>
                    </td>
                </tr>	

                <tr>
                    <td colspan="2">
                        <input type="button" class="button button-primary button-large" value="<?php _e('Insert Shortcode', 'woocommerce-products-flexslider-all-in-one') ?>" onClick="insert_shortcode();">
                    </td>
                </tr>
            </table>
        </div>
