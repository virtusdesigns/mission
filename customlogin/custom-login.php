<?php

function custom_login_screen() {
    echo '<link rel="stylesheet" id="custom-login-css"  href="'.get_bloginfo('stylesheet_directory').'/customlogin/custom-login.css" type="text/css" media="all" />';
}

add_action('login_head', 'custom_login_screen');

function loginpage_custom_link() {
	return get_bloginfo("wpurl");
}
add_filter('login_headerurl','loginpage_custom_link');

function change_title_on_logo() {
	return 'Return to Home';
}
add_filter('login_headertitle', 'change_title_on_logo');

?>