<?php
/**
 * @package shortcode
 * @version 1.7.2
 */
/*
Plugin Name: Short Code Plugin
Plugin URI: http://aspiranthawks.com/
Description: ShortCode wordPress pluign
Author: Muhammad Zohaib
Version: 1.0.0
Plugin URI: https://xcyzx.com/
Author URI: https://xcyzx.com/
*/

/*
// basic  short code
add_shortcode('message','sp_show_static_message');
function sp_show_static_message(){
    return 'Rock Star';
}


add_shortcode('student','sp_handle_student_data');


// simple short code with params
function sp_handle_student_data($attributes){
    $attributes = shortcode_atts(array(
        'name'  => "Default anme",
        'email' => "Default Emnail"
    ), $attributes, 'student');

    //return "<h3>Student data  {$attributes['name'] }  ,  Email - {$attributes['email']} </h3>";
    return "<h3>Student data   ".$attributes['name'] ."  ,  Email - {$attributes['email']} </h3>";
}

// short code with dynamic values / db operation
add_shortcode('list-posts','sp_handle_lists_posts');
*/

add_shortcode('list-posts','sp_handle_list_posts_wp_query_class');
// via query
function sp_handle_list_posts_wp_query_class($attributes){
    $attributes = shortcode_atts(array(
        'number' => 5
    )   ,$attributes,'list-posts') ;

    $query = new WP_Query(  array(
        'posts_per_page'    => $attributes['number'],
        'post_status'       => 'publish'
    ));


    if($query->have_posts()){
        $outputhtml  = '<ul>';
        while($query->have_posts() ) {
            $query->the_post();

            $outputhtml .= '<li>'.get_the_title() .'fg fg fgf  hf</li>';
        }
        wp_reset_postdata();
        $outputhtml  .= '</ul>';

        return $outputhtml;
    }
    return 'No Output';

}






















