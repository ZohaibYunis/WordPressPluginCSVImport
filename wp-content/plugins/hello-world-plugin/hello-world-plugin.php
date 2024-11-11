<?php
/**
 * @package Hello_World_First_Plugin
 * @version 1.7.2
 */
/*
Plugin Name: Hello World - First PLugin
Plugin URI: http://aspiranthawks.com/
Description: Admin dashboard and information wiget
Author: Muhammad Zohaib
Version: 1.0.0
Author URI: https://xcyzx.com/
Author URI: https://xcyzx.com/
*/


// Admin notices
// Admin Widgets



//add_action('admin_notices','hw_show_message');
//add_action('admin_notices','hw_show_error_message');
//add_action('admin_notices','hw_show_info_message');
add_action('admin_notices','hw_show_warning_message');

function hw_show_success_message(){
    echo '<div class="notice notice-success is-disimissible"><p>Success , msg</p> </div>';
}
function hw_show_error_message(){
    echo '<div class="notice notice-success is-disimissible"><p>Error , msg</p> </div>';
}


function hw_show_info_message(){
    echo '<div class="notice notice-info is-disimissible"><p>Info , msg</p> </div>';
}

function hw_show_warning_message(){
    echo '<div class="notice warning-success is-disimissible"><p>Warning , msg</p> </div>';
}



//wp_dashboard_setup  :  used for adding widget in the wordpress
add_action('wp_dashboard_setup','hw_hello_world_dashboard_widget');


function hw_hello_world_dashboard_widget(){

    //wp_add_dashboard_widget( string $widget_id, string $widget_name, callable $callback, callable $control_callback = null, array $callback_args = null, string $context = ‘normal’, string $priority = ‘core’ )
    wp_add_dashboard_widget(
            'hw_hello_world','Hw Hello World',  'hw_custom_admin_widget' );
}

function hw_custom_admin_widget(){
    //echo '<div class="notice notice-success is-disimissible"><p>Succes Manfgo adsads , msg</p> </div>';
    echo 'Rcoksksksk';
}