<?php
/**
 * @package Hello_World_First_Plugin
 * @version 1.7.2
 */
/*
Plugin Name: csv data uploader
Plugin URI: http://aspiranthawks.com/
Description: Admin dashboard and information wiget
Author: Muhammad Zohaib
Version: 1.0.0
Author URI: https://xcyzx.com/
Author URI: https://xcyzx.com/
*/


// Admin notices
// Admin Widgets

define( 'CDU_PLUGIN_DIR_PATH'  ,  plugin_dir_path( __FILE__ ) ); ;

add_shortcode('csv-data-uploader','cdu_display_uploader_form');

function cdu_display_uploader_form(){
    // start php buffer
    ob_start();
    include_once CDU_PLUGIN_DIR_PATH.'/template/cdu_form.php';

    $template = ob_get_contents();
    // clean php buffer
    ob_end_clean();

    return  $template;
}

// DB Table create on plugin activation
register_activation_hook(__FILE__, "cdu_create_table");
function cdu_create_table(){
    global $wpdb;
    $table_prefix  = $wpdb->prefix;
    $table_name    = $table_prefix . "students_data";
    $table_collate = $wpdb->get_charset_collate();

    $sql_command = " CREATE TABLE `$table_name` (
            `id` int(11) NOT NULL AUTO_INCREMENT,
            `name` varchar(50) DEFAULT NULL,
            `email` varchar(50) DEFAULT NULL,
            `age` int(5) DEFAULT NULL,
            `phone` varchar(130) DEFAULT NULL,
            `photo` varchar(120) DEFAULT NULL,
            PRIMARY KEY (`id`)
        ) $table_collate
        ";

    require_once (ABSPATH . 'wp-admin/includes/upgrade.php');
    dbDelta($sql_command);

}

// to add the script file
add_action('wp_enqueue_scripts' , 'cdu_add_script_file' );
function cdu_add_script_file(){
    wp_enqueue_script('cdu-script-js' , plugin_dir_url(__FILE__) . 'assets/script.js', array('jquery')  , '');
    wp_localize_script('cdu-script-js','cdu_object' , array(
        'ajax_url' => admin_url('admin-ajax.php')
    ));
}
// capture the ajax request
add_action('wp_ajax_cdu_submit_form_data', 'cdu_ajax_handler');// when user logined in
add_action('wp_ajax_nopriv_cdu_submit_form_data', 'cdu_ajax_handler');  // when user mot loged in
function cdu_ajax_handler(){

    if($_FILES['csv_data_file']){
        $csvFile = $_FILES['csv_data_file']['tmp_name'] ;
        $handle  = fopen($csvFile , 'r');

        global $wpdb;
        $table_prefix  = $wpdb->prefix;
        $table_name    = $table_prefix . "students_data";


        if($handle){
            $row = 0 ;
            while( ($data = fgetcsv($handle, 1000, ',')) !== FALSE){
                if($row == 0) {
                    $row++;
                    continue;
                }
                // insert the data
                $wpdb->insert($table_name , array (
                    'name'  => $data[1],
                    'email' => $data[2],
                    'age'   => $data[3],
                    'phone' => $data[4],
                    'photo' => $data[5],
                ));


            }
            fclose($handle);
            echo json_encode(array(
                'status' => 1,
                'message' => 'Data uploaded',
            ));
            exit;
        }

    }else{
        echo json_encode(array(
            'status' => 0,
            'success' => 'No CSV uploaded',
        ));
    }

    exit;
}