<?php
/**
 * Created by PhpStorm.
 * User: User
 * Date: 2/19/2018
 * Time: 2:28 PM
 */


add_action( 'wp_enqueue_scripts', 'my_scripts_method' );
function my_scripts_method(){
	wp_enqueue_style( 'bootstrap', get_template_directory_uri() . '/assets/css/bootstrap.min.css' );
	wp_enqueue_style( 'bootstrap-select', get_template_directory_uri() . '/assets/css/bootstrap-select.min.css' );
    wp_enqueue_style( 'bootstrap-toggle', get_template_directory_uri() . '/assets/css/bootstrap-toggle.min.css' );
    wp_enqueue_style( 'bootstrap-scrollable', get_template_directory_uri() . '/assets/css/bootstrap-nav-tab-scrollable.css' );
    wp_enqueue_style( 'style-main', get_template_directory_uri() . '/assets/css/style.css' );

	wp_deregister_script( 'jquery' );
	wp_register_script( 'jquery', get_template_directory_uri() . '/assets/js/jquery-3.2.1.min.js');
	wp_enqueue_script( 'jquery' );

    wp_enqueue_script( 'bootstrap', get_template_directory_uri() . '/assets/js/bootstrap.min.js', ['jquery'], false, true );
    wp_enqueue_script( 'bootstrap-select', get_template_directory_uri() . '/assets/js/bootstrap-select.min.js', ['jquery'], false, true );
    wp_enqueue_script( 'bootstrap-toggle', get_template_directory_uri() . '/assets/js/bootstrap-toggle.min.js', ['jquery'], false, true );
    wp_enqueue_script( 'bootstrap-scrollable', get_template_directory_uri() . '/assets/js/bootstrap-nav-tab-scrollable.js', ['jquery'], false, true );
    wp_enqueue_script( 'bootstrap-typeahead', get_template_directory_uri() . '/assets/js/bootstrap-typeahead.min.js', ['jquery'], false, true );
    wp_enqueue_script( 'bootstrap-tooltip', get_template_directory_uri() . '/assets/js/bootstrap-tooltip.js', ['jquery'], false, true );
    wp_enqueue_script( 'calc', get_template_directory_uri() . '/assets/js/calc.js', ['jquery'], false, true );

//	wp_enqueue_script( 'frontend-js', get_template_directory_uri() . '/assets/scripts/frontend.js', array('jquery') );
//	wp_localize_script( 'frontend-js', 'MyAjax', array( 'ajaxurl' => admin_url( 'admin-ajax.php' ) ) );
}
//Register backend styles and scripts
add_action( 'admin_enqueue_scripts', 'my_enqueue' );
function my_enqueue() {
//    wp_enqueue_script( 'datetimepicker-js', get_template_directory_uri() . '/inc/datetimepicker/jquery.datetimepicker.full.min.js');
//	wp_enqueue_style( 'datetimepicker-css', get_stylesheet_directory_uri().'/inc/datetimepicker/jquery.datetimepicker.min.css' );
//	wp_enqueue_script( 'backend-js', get_template_directory_uri() . '/assets/scripts/backend.js');
//	wp_enqueue_style( 'backend-css', get_stylesheet_directory_uri().'/assets/styles/backend.css' );

}

add_filter('style_loader_tag', 'codeless_remove_type_attr', 10, 2);
add_filter('script_loader_tag', 'codeless_remove_type_attr', 10, 2);
function codeless_remove_type_attr($tag, $handle) {
	return preg_replace( "/type=['\"]text\/(javascript|css)['\"]/", '', $tag );
}