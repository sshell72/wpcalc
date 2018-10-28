<?php
if ( ! defined( 'ABSPATH' ) ) {
    exit; // Exit if accessed directly.
}

class DoorsBackendclass{

    private static $initiated = false;

    public static function back_init() {
        if (!self::$initiated) {
            self::backend_init_hooks();
        }
    }

    public static function backend_init_hooks() {

        add_action('wp_ajax_clone_copy_decor',[__CLASS__,'clone_copy_decor']);
        add_action('wp_ajax_clone_copy_model',[__CLASS__,'clone_copy_model']);
        add_action('wp_ajax_edit_price',[__CLASS__,'edit_price']);

    }
	
	 public static function get_query($query){
        global $wpdb;
        return $wpdb->get_results( $query );
    }
	
    public function clone_copy_decor(){
        global $wpdb;
		$name = $_POST['name'];
		$id_decor = $_POST['id_decor'];
		
		 $doors_decoration =  $wpdb->query('INSERT INTO `wp_doors_decoration` (`name`, `price`,`visible`,`model_id`,`photo_front`,`photo_back`) SELECT "'.$name.'",`price`,`visible`,`model_id`,`photo_front`,`photo_back` FROM `wp_doors_decoration` WHERE id='.$id_decor); 
		$id_decor_new =  $wpdb->get_var('SELECT * FROM `wp_doors_decoration` ORDER BY id DESC LIMIT 1');
		 
		 $doors_available_param =  $wpdb->query('INSERT INTO `wp_doors_available_param` (`param_id`,`decor_id`,`visible`,`def_value`,`available_decor_values`) SELECT `param_id`,"'.$id_decor_new.'",`visible`,`def_value`,`available_decor_values` FROM `wp_doors_available_param` WHERE `decor_id`= '.$id_decor);  
		 
		 $doors_blocked =  $wpdb->query('INSERT INTO `wp_doors_blocked` (`param_id`,`value_id`,`param_block_id`,`decor_id`) SELECT `param_id`,`value_id`,`param_block_id`,"'.$id_decor_new.'" FROM `wp_doors_blocked` WHERE decor_id='.$id_decor); 
		 
		 $doors_visible_param =  $wpdb->query('INSERT INTO `wp_doors_visible_param` (`param_id`,`decor_id`,`visible`) SELECT `param_id`,"'.$id_decor_new.'",`visible` FROM `wp_doors_visible_param` WHERE decor_id='.$id_decor); 


		/* echo 'INSERT INTO `wp_doors_decoration` (`name`, `price`,`visible`,`model_id`,`photo_front`,`photo_back`) SELECT "'.$name.'",`price`,`visible`,`model_id`,`photo_front`,`photo_back` FROM `wp_doors_decoration` WHERE id='.$id_decor; */
		
		exit;
	}	
	
    public function clone_copy_model(){
        global $wpdb;
		$name = $_POST['name'];
		$id_model = $_POST['id_model'];
		
		 $doors_models =  $wpdb->query('INSERT INTO `wp_doors_models` (`name`,`visible`,`series_id`) SELECT "'.$name.'",`visible`,`series_id` FROM `wp_doors_models` WHERE id='.$id_model); 
		 $id_model_new =  $wpdb->get_var('SELECT * FROM `wp_doors_models` ORDER BY id DESC LIMIT 1');
		 
		$doors_decoration =  $wpdb->get_results('SELECT id, name FROM `wp_doors_decoration` WHERE model_id='.$id_model); 
	
		foreach($doors_decoration as $door_decor){
			//echo $door_decor->id;
			$id_decor = $door_decor->id;
			$name_decor = $door_decor->name;
			//clone_decor($name,$id_decor,$id_model_new);
			 $doors_decoration =  $wpdb->query('INSERT INTO `wp_doors_decoration` (`name`, `price`,`visible`,`model_id`,`photo_front`,`photo_back`) SELECT "'.$name_decor.'",`price`,`visible`,"'.$id_model_new.'",`photo_front`,`photo_back` FROM `wp_doors_decoration` WHERE id='.$id_decor); 
		$id_decor_new =  $wpdb->get_var('SELECT * FROM `wp_doors_decoration` ORDER BY id DESC LIMIT 1');
		 
		 $doors_available_param =  $wpdb->query('INSERT INTO `wp_doors_available_param` (`param_id`,`decor_id`,`visible`,`def_value`,`available_decor_values`) SELECT `param_id`,"'.$id_decor_new.'",`visible`,`def_value`,`available_decor_values` FROM `wp_doors_available_param` WHERE `decor_id`= '.$id_decor);  
		 
		 $doors_blocked =  $wpdb->query('INSERT INTO `wp_doors_blocked` (`param_id`,`value_id`,`param_block_id`,`decor_id`) SELECT `param_id`,`value_id`,`param_block_id`,"'.$id_decor_new.'" FROM `wp_doors_blocked` WHERE decor_id='.$id_decor); 
		 
		 $doors_visible_param =  $wpdb->query('INSERT INTO `wp_doors_visible_param` (`param_id`,`decor_id`,`visible`) SELECT `param_id`,"'.$id_decor_new.'",`visible` FROM `wp_doors_visible_param` WHERE decor_id='.$id_decor);
			
		}
		
		exit;
	}	
	
    public function edit_price(){
        global $wpdb;
		$price_regions = $_POST['price_regions'];
		$id_service = $_POST['id_service'];
		$price = $_POST['price'];
		
		$table_series = $wpdb->get_blog_prefix() . 'doors_service';

		$result = $wpdb->update(
			$table_series,
			[ $price_regions => $price ],
			[ 'id' => $id_service ]
		);
		
		exit;
	}
	
}
function clone_decor($name,$id_decor,$id_model_new){
		global $wpdb;
		
		 $doors_decoration =  $wpdb->query('INSERT INTO `wp_doors_decoration` (`name`, `price`,`visible`,`model_id`,`photo_front`,`photo_back`) SELECT "'.$name.'",`price`,`visible`,"'.$id_model_new.'",`photo_front`,`photo_back` FROM `wp_doors_decoration` WHERE id='.$id_decor); 
		$id_decor_new =  $wpdb->get_var('SELECT * FROM `wp_doors_decoration` ORDER BY id DESC LIMIT 1');
		 
		 $doors_available_param =  $wpdb->query('INSERT INTO `wp_doors_available_param` (`param_id`,`decor_id`,`visible`,`def_value`,`available_decor_values`) SELECT `param_id`,"'.$id_decor_new.'",`visible`,`def_value`,`available_decor_values` FROM `wp_doors_available_param` WHERE `decor_id`= '.$id_decor);  
		 
		 $doors_blocked =  $wpdb->query('INSERT INTO `wp_doors_blocked` (`param_id`,`value_id`,`param_block_id`,`decor_id`) SELECT `param_id`,`value_id`,`param_block_id`,"'.$id_decor_new.'" FROM `wp_doors_blocked` WHERE decor_id='.$id_decor); 
		 
		 $doors_visible_param =  $wpdb->query('INSERT INTO `wp_doors_visible_param` (`param_id`,`decor_id`,`visible`) SELECT `param_id`,"'.$id_decor_new.'",`visible` FROM `wp_doors_visible_param` WHERE decor_id='.$id_decor);
	}
