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
}
/* 
add_action( 'wp_enqueue_scripts', 'enqueue_load_fa' );
function enqueue_load_fa() {
  
    wp_enqueue_style( 'load-fa', 'https://maxcdn.bootstrapcdn.com/font-awesome/4.6.3/css/font-awesome.min.css' );
}
 */
function wph_add_css_file_admin() {
    //$themeurl = get_bloginfo('stylesheet_directory');
    echo '<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/font-awesome/4.6.3/css/font-awesome.min.css" />';
}
add_action('admin_head', 'wph_add_css_file_admin');
