<?php
/**
 * Created by PhpStorm.
 * User: User
 * Date: 5/29/2018
 * Time: 7:07 PM
 */

add_action( 'admin_enqueue_scripts', 'WL_include' );
function WL_include() {
    // Include Color-picker
    wp_enqueue_script( 'wp-color-picker' );
    wp_enqueue_style( 'wp-color-picker' );

    // Include Main Style
    wp_enqueue_style( 'WL-styles', get_template_directory_uri().'/WLMetaBoxes/assets/styles/WL-styles.css' );
    // Include Main JS
    wp_enqueue_script('WL-script', get_template_directory_uri().'/WLMetaBoxes/assets/scripts/WL-scripts.js' );


}

