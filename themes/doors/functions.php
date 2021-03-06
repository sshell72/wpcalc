<?php

require_once 'inc/included-files.php';

add_action( 'admin_menu', 'remove_menus' );
function remove_menus(){
    remove_menu_page( 'index.php' );                  // Консоль
    remove_menu_page( 'edit.php' );                   // Записи
    remove_menu_page( 'edit-comments.php' );          // Комментарии
}

//Register backend styles and scripts
add_action( 'admin_enqueue_scripts', 'my_enqueue_back' );
function my_enqueue_back() {
    wp_enqueue_script( 'backend-js', get_template_directory_uri() . '/assets/js/backend.js');
    wp_enqueue_script( 'tether-js',  'https://cdnjs.cloudflare.com/ajax/libs/tether/1.2.0/js/tether.min.js');
    wp_enqueue_script( 'bootstrap-js', 'https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0-alpha.4/js/bootstrap.min.js');
    wp_enqueue_script( 'bootstrap-select-js',  get_template_directory_uri() . '/assets/js/bootstrap-select.min.js');
    //wp_enqueue_script( 'selectator-js', get_template_directory_uri() . '/assets/js/fm.selectator.jquery.js');
}
 
add_action( 'wp_enqueue_scripts', 'enqueue_load_fa' );
function enqueue_load_fa() {
  
    wp_enqueue_style( 'load-fa', 'https://maxcdn.bootstrapcdn.com/font-awesome/4.6.3/css/font-awesome.min.css' );
}

function wph_add_css_file_admin() {
    $themeurl = get_bloginfo('stylesheet_directory');
    echo '<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/font-awesome/4.6.3/css/font-awesome.min.css" />';
    echo '<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0-alpha.4/css/bootstrap.min.css" />';
    echo '<link rel="stylesheet" href="'.$themeurl.'/assets/css/addstyle.css" />';
    echo '<link rel="stylesheet" href="'.$themeurl.'/assets/css/bootstrap-select.min.css" />';
	//echo '<link href="'.$themeurl.'/assets/css/fm.selectator.jquery.css" rel="stylesheet">';

}
add_action('admin_head', 'wph_add_css_file_admin');
