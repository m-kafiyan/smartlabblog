<?php
/*
Plugin Name: copyright
Plugin URI: http://www.freescript.ir/
Description: با استفاده از این افزونه کسی نمیتواند در سایت شما کلیک راست انجام دهد، انتشار از FreeScript.ir
Author: PARSA
Version: 1.0
Author URI: http://www.freescript.ir/
*/


add_action('admin_menu', 'copy_create_menu');

function copy_create_menu() {
	add_options_page( 'تنظیمات', 'کپی رایت', 'administrator', __FILE__, 'copy_settings_page');
	add_action( 'admin_init', 'register_mysettings' );

}
function register_mysettings() {
	register_setting( 'copyright-settings-group', 'copyright_mtn' );
}

function copy_settings_page() { ?>
	
<div class="wrap">
<h2>افزونه کپی رایت - نوشته شده توسط FreeScript.ir</h2>

<form method="post" action="options.php">
<?php settings_fields( 'copyright-settings-group' ); ?>
   <h3>تنظیمات</h3> 
    <table class="form-table">
        <tr valign="top">
        <th scope="row">متن کپی رایت برای نمایش</th>
        <td><input type="text" name="copyright_mtn" value="<?php echo get_option('copyright_mtn'); ?>" /></td>
        </tr>
         
       
    </table>
    
    <?php submit_button(); ?>

</form>
</div>
<?php }

$mtn = get_option('copyright_mtn');
if(!$mtn) $mtn = 'دسترسی به این قسمت محدود شده است';

function copyright(  ) {
	global $mtn;
	$content = '<script language="JavaScript"> 
var message="'. $mtn .'"; 

/////////////////////////////////// 
function clickIE4(){ 
if (event.button==2){ 
alert(message); 
return false; 
} 
} 

function clickNS4(e){ 
if (document.layers||document.getElementById&&!document.all){ 
if (e.which==2||e.which==3){ 
alert(message); 
return false; 
} 
} 
} 

if (document.layers){ 
document.captureEvents(Event.MOUSEDOWN); 
document.onmousedown=clickNS4; 
} 
else if (document.all&&!document.getElementById){ 
document.onmousedown=clickIE4; 
} 

document.oncontextmenu=new Function("alert(message);return false") 

// --> 
</script>';
	echo $content;
}
 ?>