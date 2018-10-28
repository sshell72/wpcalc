<?php
/*
Plugin Name: Cost of doors plugin
Description: Cost of doors.                                                                                           
Version: 1.0
Author: Oleksandr Kiiashko
*/

if ( ! defined( 'ABSPATH' ) ) {
    exit; // Exit if accessed directly.
}

define('DOC_PLUGIN_URL', plugin_dir_url(__FILE__ ));

define('DOC_DOWNLOADER_CLASS', plugin_dir_path(__FILE__).'class/');
define('DOC_PLUGIN_DIR', plugin_dir_path(__FILE__ ));


register_activation_hook(__FILE__, array('DoorsMainclass', 'doc_install'));

register_uninstall_hook(__FILE__, array('DoorsMainclass', 'doc_uninstall'));

require_once(DOC_DOWNLOADER_CLASS . 'class.main.php');
require_once(DOC_DOWNLOADER_CLASS . 'class.frontend.php');
require_once(DOC_DOWNLOADER_CLASS . 'class.backend.php');


add_action('init', array( 'DoorsMainclass', 'doc_init'));
add_action('init', array( 'DoorsFrontendclass', 'front_init'));
add_action('init', array( 'DoorsBackendclass', 'back_init'));