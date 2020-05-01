<?php
/*
Plugin Name: Analytics Codes
Plugin URI: http://iplay.codes/Analytics-Codes
Description: You can add statistical codes for your website, such as Google, CNZZ, Baidu,etc. You can also add HTML code you like.您可以为您的网站添加统计代码，例如Google，CNZZ，百度等。 您也可以添加自己喜欢的HTML代码。
Author: HJY
Version: 1.0.2
Author URI: http://hjy.me/
*/

/*  Copyright 2020  hjy (email : i@hjy.me)

    This program is free software; you can redistribute it and/or modify
    it under the terms of the GNU General Public License as published by
    the Free Software Foundation; either version 2 of the License, or
    (at your option) any later version.

    This program is distributed in the hope that it will be useful,
    but WITHOUT ANY WARRANTY; without even the implied warranty of
    MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
    GNU General Public License for more details.
*/


// create custom plugin settings menu
add_action('admin_menu', 'iplay_menu');

function iplay_menu() {
	
	global $my_admin_page;
	//create new top-level menu
	$my_admin_page = add_menu_page(
	'Analytics Codes Settings', 
	'Analytics Codes', 
	'manage_options', 
	'iplay-Analytics-Codes-settings-page', 
	'iplay_settings_page',
    'data:image/svg+xml;base64,PD94bWwgdmVyc2lvbj0iMS4wIiA/PjxzdmcgaWQ9IkxheWVyXzEiIHN0eWxlPSJlbmFibGUtYmFja2dyb3VuZDpuZXcgMCAwIDI1NiAyNTY7IiB2ZXJzaW9uPSIxLjEiIHZpZXdCb3g9IjAgMCAyNTYgMjU2IiB4bWw6c3BhY2U9InByZXNlcnZlIiB4bWxucz0iaHR0cDovL3d3dy53My5vcmcvMjAwMC9zdmciIHhtbG5zOnhsaW5rPSJodHRwOi8vd3d3LnczLm9yZy8xOTk5L3hsaW5rIj48Zz48cGF0aCBkPSJNMjM2LjYsOTVjMC0xMS4xLTkuMS0yMC4yLTIwLjItMjAuMmMtMTEuMSwwLTIwLjIsOS4xLTIwLjIsMjAuMmMwLDMuNywxLjEsNy4yLDIuOSwxMC4ybC0yNy4yLDI3LjIgICBjLTIuOC0xLjQtNS45LTIuMy05LjItMi4zYy00LjIsMC04LDEuMy0xMS4zLDMuNGwtMjcuMy0yNy4yYzIuMi0zLjIsMy41LTcuMSwzLjUtMTEuM2MwLTExLjEtOS4xLTIwLjItMjAuMi0yMC4yICAgYy0xMS4xLDAtMjAuMiw5LjEtMjAuMiwyMC4yYzAsMy4zLDAuOSw2LjQsMi4zLDkuMWwtMjguOSwyOC45Yy0zLTEuOC02LjUtMi45LTEwLjItMi45Yy0xMS4xLDAtMjAuMiw5LjEtMjAuMiwyMC4yICAgYzAsMTEuMSw5LjEsMjAuMiwyMC4yLDIwLjJzMjAuMi05LjEsMjAuMi0yMC4yYzAtMy43LTEuMS03LjItMi45LTEwLjJsMjguNC0yOC40YzMuMiwyLjIsNy4xLDMuNSwxMS4zLDMuNWMzLjMsMCw2LjQtMC45LDkuMS0yLjMgICBsMjguMiwyOC4yYy0xLjQsMi44LTIuMyw1LjktMi4zLDkuMmMwLDExLjEsOS4xLDIwLjIsMjAuMiwyMC4yYzExLjEsMCwyMC4yLTkuMSwyMC4yLTIwLjJjMC00LjItMS4zLTguMS0zLjQtMTEuM2wyNi43LTI2LjcgICBjMywxLjgsNi41LDIuOSwxMC4yLDIuOUMyMjcuNSwxMTUuMiwyMzYuNiwxMDYuMSwyMzYuNiw5NXogTTUwLjQsMTYwLjRjLTUuNiwwLTEwLjItNC42LTEwLjItMTAuMmMwLTUuNiw0LjYtMTAuMiwxMC4yLTEwLjIgICBjMi44LDAsNS4zLDEuMSw3LjIsM2MwLDAsMCwwLDAsMGMwLDAsMCwwLDAsMGMxLjgsMS44LDMsNC40LDMsNy4yQzYwLjYsMTU1LjksNTYsMTYwLjQsNTAuNCwxNjAuNHogTTEwNy40LDEwNS4xICAgYy01LjYsMC0xMC4yLTQuNi0xMC4yLTEwLjJjMC01LjYsNC42LTEwLjIsMTAuMi0xMC4yYzUuNiwwLDEwLjIsNC42LDEwLjIsMTAuMkMxMTcuNiwxMDAuNiwxMTMsMTA1LjEsMTA3LjQsMTA1LjF6IE0xNjIuNywxNjAuNCAgIGMtNS42LDAtMTAuMi00LjYtMTAuMi0xMC4yYzAtNS42LDQuNi0xMC4yLDEwLjItMTAuMmM1LjYsMCwxMC4yLDQuNiwxMC4yLDEwLjJDMTcyLjgsMTU1LjksMTY4LjMsMTYwLjQsMTYyLjcsMTYwLjR6IE0yMDkuMiwxMDIuMSAgIEMyMDkuMiwxMDIuMSwyMDkuMiwxMDIuMSwyMDkuMiwxMDIuMWMtMS44LTEuOC0zLTQuNC0zLTcuMmMwLTUuNiw0LjYtMTAuMiwxMC4yLTEwLjJzMTAuMiw0LjYsMTAuMiwxMC4yYzAsNS42LTQuNiwxMC4yLTEwLjIsMTAuMiAgIEMyMTMuNiwxMDUuMSwyMTEsMTA0LDIwOS4yLDEwMi4xTDIwOS4yLDEwMi4xeiIvPjxwYXRoIGQ9Ik05LjUsMjEyLjdjMywwLDUuNC0yLjQsNS40LTUuNFYyMi4xYzAtMy0yLjQtNS40LTUuNC01LjRzLTUuNCwyLjQtNS40LDUuNHYxODUuMkM0LjEsMjEwLjMsNi41LDIxMi43LDkuNSwyMTIuN3oiLz48cGF0aCBkPSJNMzcuNywyMjguNUg5LjVjLTMsMC01LjQsMi40LTUuNCw1LjRzMi40LDUuNCw1LjQsNS40aDI4LjNjMywwLDUuNC0yLjQsNS40LTUuNFM0MC43LDIyOC41LDM3LjcsMjI4LjV6Ii8+PHBhdGggZD0iTTg5LjksMjI4LjVINjEuN2MtMywwLTUuNCwyLjQtNS40LDUuNHMyLjQsNS40LDUuNCw1LjRoMjguM2MzLDAsNS40LTIuNCw1LjQtNS40UzkyLjksMjI4LjUsODkuOSwyMjguNXoiLz48cGF0aCBkPSJNMTQyLjEsMjI4LjVoLTI4LjNjLTMsMC01LjQsMi40LTUuNCw1LjRzMi40LDUuNCw1LjQsNS40aDI4LjNjMywwLDUuNC0yLjQsNS40LTUuNFMxNDUuMSwyMjguNSwxNDIuMSwyMjguNXoiLz48cGF0aCBkPSJNMTk0LjMsMjI4LjVoLTI4LjNjLTMsMC01LjQsMi40LTUuNCw1LjRzMi40LDUuNCw1LjQsNS40aDI4LjNjMywwLDUuNC0yLjQsNS40LTUuNFMxOTcuMywyMjguNSwxOTQuMywyMjguNXoiLz48cGF0aCBkPSJNMjQ2LjUsMjI4LjVoLTI4LjNjLTMsMC01LjQsMi40LTUuNCw1LjRzMi40LDUuNCw1LjQsNS40aDI4LjNjMywwLDUuNC0yLjQsNS40LTUuNFMyNDkuNSwyMjguNSwyNDYuNSwyMjguNXoiLz48L2c+PC9zdmc+'    // plugins_url('/images/icon.png', __FILE__)
	);

	//call register settings function
	add_action( 'admin_init', 'register_iplay_options' );
	
	// Adds my_help_tab when my_admin_page loads
    add_action('load-'.$my_admin_page, 'my_admin_add_help_tab');
}

function my_admin_add_help_tab () {
    global $my_admin_page;
    $screen = get_current_screen();

    /*
     * Check if current screen is My Admin Page
     * Don't add help tab if it's not
     */
    if ( $screen->id != $my_admin_page )
        return;

    // Add my_help_tab if current screen is My Admin Page
    $screen->add_help_tab( 
	array(
        'id'	=> 'iplay_help_tab',
        'title'	=> __('Analytics Codes Help'),
        'content'	=> '<p>1. 你可以添加你喜欢的代码。理论上这里可以添加js和html。但请注意代码正确性。 </p>'  . 
        '</p><p>1.お気に入りのコードを追加できます。 理論的には、jsとhtmlをここに追加できます。 ただし、コードの正確さに注意してください。</p>'.
        '<p>2. 你可以选择添加头部或者底部。</p>'.
        '<p>2.頭または底を追加することを選択できます。</p>'
    ) 
	);
	
	    // Add my_help_tab if current screen is My Admin Page
    $screen->add_help_tab( 
	array(
        'id'	=> 'about_author',
        'title'	=> __('About'),
        'content'	=> '<p>' . __( 'Support site: <a href="http://iplay.codes">http://iplay.codes</a> ' ) . '</p><p>' . __( 'Author : Danny <br>WebSite: <a href="http://hjy.me">http://hjy.me/</a> ' ) . '</p>',
    ) 
	);
}


function register_iplay_options() {
	//register our settings
	register_setting( 'iplay-settings-group', 'iplay_analytics_codes_header_code' );
	register_setting( 'iplay-settings-group', 'iplay_analytics_codes_footer_code' );
}

function iplay_settings_page() {
	if ( !current_user_can( 'manage_options' ) )  {
		wp_die( __( 'You do not have sufficient permissions to access this page.' ) );
	}
?>
<div class="wrap">
<?php screen_icon('options-general'); ?>
<h2>iPlay Analytics Codes</h2>
<p>You can add statistical codes for your website, such as Google, CNZZ, Baidu,etc. You can also add HTML code you like.</p>
<p><strong>REMIND:</strong>Adding it to the head may slow down the web page loading speed.</p>

<form method="post" action="options.php">
    <?php settings_fields( 'iplay-settings-group' ); ?>
    <?php do_settings_sections( 'iplay-settings-group' ); ?>
    <table class="form-table">
         
        <tr valign="top">
        <th scope="row">Input your customize Codes<br>(At page of header):</th>
        <td><textarea type="textarea" name="iplay_analytics_codes_header_code" cols="65" rows="5" ><?php echo get_option('iplay_analytics_codes_header_code'); ?></textarea></td>
        </tr>
        
        <tr valign="top">
        <th scope="row">Input your customize Codes<br>(At page of footer):</th>
        <td><textarea type="textarea" name="iplay_analytics_codes_footer_code" cols="65" rows="5" ><?php echo get_option('iplay_analytics_codes_footer_code'); ?></textarea></td>
        </tr>
    </table>
    
    <?php submit_button(); ?>

</form>
</div>
<?php } 

add_action( 'wp_head', 'iplay_analytics_codes_header_code_callback' ); 
//Callback at header
function iplay_analytics_codes_header_code_callback(){
		echo '<!-- START #iplay-Analytics-Codes-header-code -->';
        echo get_option('iplay_analytics_codes_header_code');
		echo '<!-- END #iplay-Analytics-Codes-header-code -->';
}

add_action( 'wp_footer', 'iplay_analytics_codes_fooer_code_callback' ); 
// Callback at footer
function iplay_analytics_codes_fooer_code_callback(){
		echo '<!-- START #iplay-Analytics-Codes-footer-code -->';
        echo get_option('iplay_analytics_codes_footer_code');
		echo '<!-- END #iplay-Analytics-Codes-footer-code -->';
}


?>