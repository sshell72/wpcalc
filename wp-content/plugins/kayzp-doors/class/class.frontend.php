<?php
if ( ! defined( 'ABSPATH' ) ) {
    exit; // Exit if accessed directly.
}

class DoorsFrontendclass{

    private static $initiated = false;

    public static function front_init() {
        if (!self::$initiated) {
            self::frontend_init_hooks();
        }
    }

    public static function frontend_init_hooks() {

        add_action('doors_frontend_get_series_street', [__CLASS__,'get_series_street'] );
        add_action('doors_frontend_get_series_apartment',[__CLASS__,'get_series_apartment']);
        add_action('doors_frontend_get_get_models_select',[__CLASS__,'get_models_select']);

        add_action('wp_ajax_submit_series',[__CLASS__,'submit_series']);
        add_action('wp_ajax_nopriv_submit_series',[__CLASS__,'submit_series']);

        add_action('wp_ajax_submit_model',[__CLASS__,'submit_model']);
        add_action('wp_ajax_nopriv_submit_model',[__CLASS__,'submit_model']);

        add_action('wp_ajax_email_me',[__CLASS__,'email_me']);
        add_action('wp_ajax_nopriv_email_me',[__CLASS__,'email_me']);

        add_action('wp_ajax_add_to_cart',[__CLASS__,'add_to_cart']);
        add_action('wp_ajax_nopriv_add_to_cart',[__CLASS__,'add_to_cart']);
		
        add_action('wp_ajax_new_base_price',[__CLASS__,'new_base_price']);
        add_action('wp_ajax_nopriv_new_base_price',[__CLASS__,'new_base_price']);

        add_action('wp_ajax_submit_decoration',[__CLASS__,'submit_decoration']);
        add_action('wp_ajax_nopriv_submit_decoration',[__CLASS__,'submit_decoration']);

    }


//    public function __construct()
//    {
//        add_action('doors_frontend_get_series',[$this,'get_series']);
//    }

    public static function get_query($query){
        global $wpdb;
        return $wpdb->get_results( $query );
    }


    public static function get_series_street(){
        $series =  self::get_query('SELECT * FROM wp_doors_series where visible = 1 and category_id = 1');
        ?>
        <div class="col-xs-12 col-sm-6 col-md-6 col-lg-4 col-lg-pull-4 collection">
            <span class="house">&nbsp;&nbsp;</span>
            <ul id="house" class="nav nav-pills" data-series="1">
                <?php
                    foreach($series as $key => $street):
                ?>
                        <li data-id="<?php echo $street->id?> "><a href="#"><?php echo $street->name ?></a></li>
                <?php endforeach; ?>

            </ul>
        </div>
        <?php
    }

    public static function get_series_apartment(){
        $series =  self::get_query('SELECT * FROM wp_doors_series where visible = 1 and category_id = 2');
        ?>
        <div class="col-xs-12 col-sm-6 col-md-6 col-lg-4 col-lg-pull-4 collection">
            <span class="skyline">&nbsp;&nbsp;</span>
            <ul id="skyline" class="nav nav-pills" data-series="2">
                <?php
                    foreach($series as $key => $apartment):

                ?>
                    <li data-id="<?php echo $apartment->id ?> "><a href="#"><?php echo $apartment->name ?></a></li>
                <?php endforeach; ?>

            </ul>
        </div>
        <?php
    }

    public static function get_models_select(){

        $models =  self::get_query('SELECT id,name FROM wp_doors_models where visible = 1');

        ?>
        <div class="row" id="doorselect" style="margin-left: 0px!important; margin-right: 0px!important">
            <div class="col-sm-12 col-md-12 col-lg-12">
                <span class="title">Выберите дверь</span>
                <select class="selectpicker" id="choose_models" data-size="5">
                    <?php foreach($models as $model): ?>
                        <option value="<?php echo $model->id ?>"><?php echo $model->name ?></option>
                    <?php endforeach; ?>
                </select>
            </div>
        </div>
        <?php
    }

    public function submit_series(){



        $models =  self::get_query('SELECT id,name FROM wp_doors_models where visible = 1 and series_id = '.$_POST['id']);
        $html = '';
        $html_select = '<option value="">Выберите дверь</option>';
            foreach($models as $key => $model):
                if(!$key){
                    $cur_model = $model->name;
                }
                $html .= '<li rel="0" class="model_li">
                               <a tabindex="0" class="" style="" data-id="'.$model->id.'">
                                    <span class="text">'.$model->name.'</span>
                                    <i class="glyphicon glyphicon-ok icon-ok check-mark"></i>
                               </a>
                          </li>';
                $html_select .= '<option value="'.$model->id.'" data-id="'.$model->id.'">'.$model->name.'</option>';
            endforeach;
        exit(json_encode(
                array(
                    'html' => $html,
                    'html_select' => $html_select,
                    'cur_model' => $cur_model,
                )
            )
        );
    }
    public function submit_model(){
        $query = '';
        if(isset($_POST['search'])){
            $query = 'and name LIKE "%'.$_POST['search'].'%"';
        }

        $decorations =  self::get_query('SELECT * FROM wp_doors_decoration where visible = 1 '.$query.' and  model_id = '.$_POST['model_id']);
        $html = '';
        foreach($decorations as $decoration) {
            $html .= '
			<div class="opati">
				
					<div role="presentation" data-id="'.$decoration->id.'" data-model_id="'.$decoration->model_id.'">
							<span class="btn zoom" data-toggle="modal" data-target="#modal"></span>
							<span class="title">'.$decoration->name.'</span>
							<a href="#image1" data-toggle="tab" data-toggle="tooltip" data-placement="top" data-trigger="hover click">
								<img src="'.$decoration->photo_front.'"/>
							</a>
					</div>
					<div role="presentation" data-id="'.$decoration->id.'" data-model_id="'.$decoration->model_id.'">
							<span class="btn zoom" data-toggle="modal" data-target="#modal"></span>
							<span class="title">'.$decoration->name.'</span>
							<a href="#image1" data-toggle="tab" data-toggle="tooltip" data-placement="top" data-trigger="hover click">
								<img src="'.$decoration->photo_back.'"/>
							</a>
					</div>
				
			</div>';
        }
        exit(json_encode($html));
    }


    public static function auto_choose($parameters,$post_query){
        $html = ' <div class="col-md-12 col-lg-8" id="parameters_change">
                    <div class="row">';

        $html .= '<input type="hidden" name="send_param" value="true">';
        $haractristic = '';
        $price_param = 0;
            $debug = [];
        for($i=0;$i<count($parameters);$i++){

            $param =  self::get_query('SELECT * FROM wp_doors_params where id = '.$parameters[$i]->param_id);
//            $param_values =  self::get_query('SELECT id_value FROM wp_doors_param_values where id_param = '.$parameters[$i]);

            if(!($i%3)){
                $html .= '<div class="col-sm-12 col-md-12 col-lg-6">
                            <div class="row">';
            }


            $aval_id = self::get_query('SELECT avail_val_id FROM wp_doors_available_param where decor_id = '.$parameters[$i]->param_id.' or is_def = 1');
            $query = '';
            foreach($aval_id as $key => $aval){
                if(!$key){
                    $query = ' where id = '.$aval->avail_val_id;
                }else{
                    $query .= ' or id = '.$aval->avail_val_id;
                }
            }

            $default = self::get_query('SELECT value_id FROM wp_doors_available_param_series '.$query);



            switch($param[0]->type_id){
                case 1:{

                    $param_values_p =  self::get_query('SELECT id,name,price FROM wp_doors_value_p where param_id = '.$parameters[$i]->param_id);


                    $html .= ' <div class="col-sm-6 col-md-6 col-lg-12 col-margin uniq_param" data-id="1">
                                 <label>'.$param[0]->name.'</label>';
                    if($post_query[$param[0]->name]){
                        $html .= '<input type="text" class="form-control" name="'.$param[0]->name.'" value="'.$post_query[$param[0]->name].'"  data-price="'.$param_values_p[0]->price.'">';
                    }else{
                        $html .='<input type = "text" class="form-control" name = "'.$param[0]->name.'" value = ""  data - price = "'.$param_values_p[0]->price.'" >';
                    }
                $html .='</div>';



                break;
                }
                case 2:{


                    $query = 'SELECT id,name,price FROM wp_doors_value_p where param_id = '.$parameters[$i]->param_id;
                    $param_values_p =  self::get_query($query);
                    $check_def = '';
//                    foreach($param_values_p as $check){
//                        $is_def = self::get_query('SELECT * FROM wp_doors_available_param where value_id = ' . $check->id);
//                    }


//                    foreach($param_values as $key =>  $value){
//                        if(!$key){
//                            $query .= 'where id = '.$value->id_value;
//                        }else{
//                            $query .= ' or id = '.$value->id_value;
//                        }
//                    }

                    $html .= '   
                            <div class="col-sm-6 col-md-6 col-lg-12 col-margin uniq_param" data-id="2">
                                <label>'.$param[0]->name.'</label>
                                  <select class="selectpicker parameter_class" name="'.$param[0]->name.'" data-size="5"  style="display: none;">';
                                    $html .= '<option value="Выберите параметр">Выберите параметр</option>';
                                        foreach($param_values_p as $value){
                                            $html .= '<option value="'.$value->name.'"';
                                            if($post_query[$param[0]->name]){
                                                if ($value->name == $post_query[$param[0]->name]) {
                                                    $html .= ' selected="selected"';
                                                    $har_default = $value->name;
                                                }
                                            }else {
                                                if ($value->id == $is_def[0]->value_id) {
                                                    $html .= ' selected="selected"';
                                                    $har_default = $value->name;
                                                }
                                            }
                                            $html.= ' data-new-id="'.$value->price.'" data-price="'.$value->price.'">'.$value->name.'</option>';
                                        }
                        $html .= ' 
                                </select>
                             </div>';
                    $debug[] = $param[0]->name;
                    if($har_default) {

                        $haractristic .= '<div  data-name="'.$param[0]->name.'">
                                <label>' . $param[0]->name . '</label><span>' . $har_default . '</span>
                            </div>';
                    }

                    break;
                }
                case 3:{
                    $param_values_p =  self::get_query('SELECT id,name,price FROM wp_doors_value_p where param_id = '.$parameters[$i]->param_id);

                    $check_def = '';
                    foreach($param_values_p as $check){
                        $is_def = self::get_query('SELECT * FROM wp_doors_available_param where value_id = ' . $check->id);
                    }

                    $html .='
                    <style>
                    .w'.$param_values_p[0]->id.' small { background: '.$param_values_p[0]->name.'; }
                    </style>';

                    $html .='
                    <div class="col-sm-6 col-md-6 col-lg-12 col-margin uniq_param" data-id="3">
                     <div id="painting" class="panel panel-default">
                        <div class="panel-body" style="overflow:hidden;">
                            <label>'.$param[0]->name.'</label>
                            <select id="grids" name="color_parametr1" name="'.$param[0]->name.'" class="selectpicker color" data-size="5"  data-container="body">';
                                $html .= '<option value="Выберите параметр">Выберите параметр</option>';

                                    foreach($param_values_p as $value){
                                        $html .= '<option value="'.$value->name.'"';
                                        if ( $value->id  == $is_def[0]->value_id ){
                                            $html .= ' selected="selected"';
                                            $har_default = $value->name;
                                        }
                                            $html .='data-subtext="w'.$param_values_p[0]->id;
                                    }
                               
                            $html .='</select>
                            </div>
                        </div>
                    </div>';
                    if($har_default) {
                        $haractristic .= '<div data-name="'.$param[0]->name.'">
                                <label>' . $param[0]->name . '</label><span>' . $param_values_p[0]->name . '</span>
                            </div>';
                    }

                break;
                }
                case 4:{
                    $param_values_p =  self::get_query('SELECT id,name,price FROM wp_doors_value_p where param_id = '.$parameters[$i]->param_id);

                  

                    $html .= '
                         <div class="col-sm-12 col-md-12 col-lg-12 col-margin uniq_param" data-id="4">
                           <div class="panel-body_check">
                                <h4>'.$param[0]->name.'</h4>
                                <input name="toggle_demo" name="'.$param[0]->name.'" data-on="Enabled" data-off="Disabled" id="toggle_demo" type="checkbox" data-price="'.$param_values_p[0]->price.'" checked data-toggle="toggle" data-style="ios" class="parameter_class">
                            </div>
                         </div>';
                    break;
                }
            }


            if(!($i%3)){
                $html.= '</div></div>';
            }


        }
        $html .='</div>
            </div>
            ';
        return array(
                    'html' => $html,
                    'haracter' => $haractristic
                );
    }


    public function submit_decoration(){
        global $wpdb;
        $result = array();
        $result['image'] = '';
        $result['back_image'] = '';
        $result['dec_name'] = '';
        $result['dec_price'] = 0;
        $result['fields'] = array();
		$decoration_id = $_POST['decoration_id'];
		$blockeds = $wpdb->get_results("SELECT * FROM wp_doors_blocked where decor_id=".$_POST['decoration_id']);
        $q = $wpdb->get_row("SELECT * FROM wp_doors_decoration where id=".$_POST['decoration_id']);
        if ($q) {
            $result['image'] = $q->photo_front;
            $result['back_image'] = $q->photo_back;
            $result['dec_name'] = $q->name;
            $result['dec_price'] = $q->price;
            $q = $wpdb->get_results("SELECT * FROM wp_doors_available_param where visible=1 AND decor_id=".$_POST['decoration_id']);
            foreach ($q as $a_param) {
                $param = $wpdb->get_row("SELECT * FROM wp_doors_params where id=".$a_param->param_id);
                if ($param) {
                    $type = $wpdb->get_row("SELECT * FROM wp_doors_type_params where id=".$param->type_id);

                    $fields_values = array();
                    if ($type->id == 2 || $type->id == 3) {
                        foreach (json_decode($a_param->available_decor_values)  as $param_val_id) {
                            $val = $wpdb->get_row("SELECT * FROM wp_doors_value_p where id=".$param_val_id);

                             if ($val) {
                                $fields_values[] = array(
                                    'id' => $val->id,
                                    'name' => $val->name,
                                    'price' => $val->price
                                );
                            } 
                        }
                    }
                    $result['fields'][] = array(
                        'name' => $param->name,
                        'def' => $a_param->def_value,
                        'type' => $type->type,
                        'values' => $fields_values
                    );

                    $field_html = '';
					
					 				
                    switch ($type->id) {
                        case '1':
							$col = ($param->block_id == 1) ? 'input-6' : '';
                            $field = '
                                <div id="'.$param->id.'" class="bl input-group '.$col.'">
                                    <div class="input-group-addon">'.$param->name.':</div>
                                    <input type="text" name="field-'.$param->id.'" class="form-control" id="width"/>
                                </div>
                            '; 
							//$result['fields_pink'][] = $param->block;
							switch ($param->block_id) {
								case '1':
								$result['fields_html'][] = $field;
								break;
								case '2':
								$result['fields_blue'][] = $field;
								break;
								case '3':
								$result['fields_green'][] = $field;
								break;
								case '4':
								$result['fields_pink'][] = $field;
								break;
							}
                            break;
                        case '2':
							$col = ($param->block_id == 1) ? 'col-margin' : '';
                            $field = '
                                <div id="'.$param->id.'" class="bl '.$col.'">
                                    <label>'.$param->name.'</label>
                                    <select class="selectpicker" name="field-'.$param->id.'" data-size="5" data-container="body">
                                        <option>Выберите значение</option>';

                            foreach ($fields_values as $option) {
                                $selected = '';
                                if ($option['id'] == $a_param->def_value) {
                                   $selected = 'selected';
                                }
								$block = '';
								foreach ($blockeds as $blocked) {
									if($blocked->value_id == $option['id']) $block .= $blocked->param_block_id.',';
								}
								$block = rtrim ($block , ",");
                                $field .= '<option '.$selected.' value="'.$option['name'].'" data-blocked="'.$block.'" data-price="'.$option['price'].'">'.$option['name'].'</option>';
                            }
                            
                            $field .= '
                                    </select>
                                </div>
                            ';
							switch ($param->block_id) {
								case '1':
								$result['fields_html'][] = $field;
								break;
								case '2':
								$result['fields_blue'][] = $field;
								break;
								case '3':
								$result['fields_green'][] = $field;
								break;
								case '4':
								$result['fields_pink'][] = $field;
								break;
							}

                            break;
                       case '3':
							$col = ($param->block_id == 1) ? 'col-margin' : '';
                            $field = '
							<div id="'.$param->id.'" class="bl '.$col.'">
                                <label>'.$param->name.':</label>
                                <select id="gridn" name="field-'.$param->id.'" class="selectpicker color" data-size="5" data-container="body">
                                    <option>Выберите значение</option>';
                                    ob_start();
                                    //var_dump($fields_values);
                                    $eee = ob_get_clean();
                                    $field .= $eee;
                            foreach ($fields_values as $option) {

                                $selected = '';
                                if ($option['id'] == $a_param->def_value) {
                                   $selected = 'selected';
                                }
                                $name = explode('/', $option['name']);
								$block = '';
								foreach ($blockeds as $blocked) {
									if($blocked->value_id == $option['id']) $block .= $blocked->param_block_id.',';
								}
								$block = rtrim ($block , ",");
                                $field .= '<option '.$selected.' value="'.$option['name'].'" data-blocked="'.$block.'" data-subtext="'.$name[0].'" data-price="'.$option['price'].'">'.$name[1].'</option>';
                            }
                            $field .= '    </select>
							</div>
                            ';
							switch ($param->block_id) {
								case '1':
								$result['fields_html'][] = $field;
								break;
								case '2':
								$result['fields_blue'][] = $field;
								break;
								case '3':
								$result['fields_green'][] = $field;
								break;
								case '4':
								$result['fields_pink'][] = $field;
								break;
							}

                            break;
                        case '4':
							$col = ($param->block_id == 1) ? 'col-margin' : '';
							$param_values_p =  self::get_query('SELECT id,name,price FROM wp_doors_value_p where param_id = '.$param->id);
                            $field = '
                                <div id="'.$param->id.'" class="bl '.$col.'">
                                    <label>'.$param->name.'</label>
                                    <input type="checkbox" name="field-'.$param->id.'" data-price="'.$param_values_p[0]->price.'" class="eye" data-toggle="toggle" data-style="ios">
                                </div>
                            ';
							switch ($param->block_id) {
								case '1':
								$result['fields_html'][] = $field;
								break;
								case '2':
								$result['fields_blue'][] = $field;
								break;
								case '3':
								$result['fields_green'][] = $field;
								break;
								case '4':
								$result['fields_pink'][] = $field;
								break;
							}

                            break;
                        
                        default:
                            break;
                    }

                }
            }

			$citys = $wpdb->get_results("SELECT * FROM `wp_doors_city` WHERE 1");
			$cit_tag = '';
            foreach ($citys as $city) {
				$cit = $city->name;
				$cit_slug = $city->slug;
				$cit_tag .= '<option data-city="'.$cit_slug.'" value="'.$cit.'">'.$cit.'</option>';
			}
			
			$services = $wpdb->get_results("SELECT * FROM `wp_doors_service` WHERE 1");
			$deliverys = '';
			$lift = '';
			$demounting = '';
			$montage = '';
			$prep = '';
			$i = 1;
            foreach ($services as $service) {
				if($service->cat == "Доставка") $delivery .= '<option class="price_minsk" data-cat="'.$service->cat.'" data-price="'.$service->price_minsk.'" value="'.$service->position.'">'.$service->position.'</option><option class="price_regions" data-price="'.$service->price_regions.'" value="'.$service->position.'">'.$service->position.'</option>';
				
				if($service->cat == "Поднятие на этаж") $lift .= '<option class="price_minsk" data-cat="'.$service->cat.'" data-price="'.$service->price_minsk.'" value="'.$service->position.'">'.$service->position.'</option><option class="price_regions" data-price="'.$service->price_regions.'" value="'.$service->position.'">'.$service->position.'</option>';
				
				if($service->cat == "Демонтаж") $demounting .= '<option class="price_minsk" data-cat="'.$service->cat.'" data-price="'.$service->price_minsk.'" value="'.$service->position.'">'.$service->position.'</option><option class="price_regions" data-price="'.$service->price_regions.'" value="'.$service->position.'">'.$service->position.'</option>';
				
				if($service->cat == "Монтаж") $montage .= '<option class="price_minsk" data-cat="'.$service->cat.'" data-price="'.$service->price_minsk.'" value="'.$service->position.'">'.$service->position.'</option><option class="price_regions" data-price="'.$service->price_regions.'" value="'.$service->position.'">'.$service->position.'</option>';
				
				if($service->cat == "Подготовка проема") $prep .= '
				<div class="col-xs-12 col-sm-5 col-md-5 col-lg-3 col-margin price_minsk">
					<label>'.$service->position.'</label>
					<input type="checkbox" name="field-u-7'.$i.'" class="eye" data-price="'.$service->price_minsk.'" data-toggle="toggle" data-style="ios">
				</div>
				<div class="col-xs-12 col-sm-5 col-md-5 col-lg-3 col-margin price_regions">
					<label>'.$service->position.'</label>
					<input type="checkbox" name="field-u-7'.$i.'" class="eye" data-price="'.$service->price_regions.'" data-toggle="toggle" data-style="ios">
				</div>';
				
				$i++;
			}
			
            $result['fields_html'][] = '
                <p>
                    <a class="btn btn-primary" data-toggle="collapse" href="#collapseExample" role="button" aria-expanded="false" aria-controls="collapseExample">
                        Показать/скрыть расчет стоимости услуг
                    </a>
                </p>
                <div class="collapse" id="collapseExample">
                    <div class="card card-body">
                
                        <div class="col-xs-12 col-sm-5 col-md-5 col-lg-3 col-margin">
                            <label>Город</label>
                            <select class="selectpicker" name="field-u-1" data-size="5" data-container="body">
                                <option>Выберите значение</option>
                                '.$cit_tag.'
                            </select>
                        </div>
                
                        <div class="col-xs-12 col-sm-5 col-md-5 col-lg-3 col-margin">
                            <label>Доставка</label>
                            <select class="selectpicker" name="field-u-2" data-size="5" data-container="body">
								<option>Выберите значение</option>
                                '.$delivery.'
                            </select>
                        </div>
                
                        <div class="col-xs-12 col-sm-5 col-md-5 col-lg-3 col-margin">
                            <label>Километраж</label>
                            <select id="kilometer" class="selectpicker" name="field-u-3" data-size="5" data-container="body">
                                <option>Выберите значение</option>
                                <option data-km="5" value="5км">5км</option>
                                <option data-km="10" value="10км">10км</option>
                                <option data-km="15" value="15км">15км</option>
                                <option data-km="25" value="25км">25км</option>
                                <option data-km="35" value="35км">35км</option>
                                <option data-km="45" value="45км">45км</option>
                                <option data-km="55" value="55км">55км</option>
                            </select>
                        </div>
                
                        <div class="col-xs-12 col-sm-5 col-md-5 col-lg-3 col-margin">
                            <label>Поднятие на этаж</label>
                            <select class="selectpicker" name="field-u-4" data-size="5" data-container="body">
                                <option>Выберите значение</option>
                                '.$lift.'
                            </select>
                        </div>
						
						<div class="col-xs-12 col-sm-5 col-md-5 col-lg-3 col-margin">
                            <label>Этаж</label>
                            <select id="level" class="selectpicker" name="field-u-41" data-size="5" data-container="body">
                                <option>Выберите значение</option>
                                <option value="1">1</option>
                                <option value="2">2</option>
                                <option value="3">3</option>
                                <option value="4">4</option>
                                <option value="5">5</option>
                                <option value="6">6</option>
                                <option value="7">7</option>
                                <option value="8">8</option>
                                <option value="9">9</option>
                                <option value="10">10</option>
                                <option value="11">11</option>
                                <option value="12">12</option>
                                <option value="13">13</option>
                                <option value="14">14</option>
                            </select>
                        </div>
						
                        <div class="col-xs-12 col-sm-5 col-md-5 col-lg-3 col-margin">
                            <label>Демонтаж</label>
                            <select class="selectpicker" name="field-u-5" data-size="5" data-container="body">
                                <option>Выберите значение</option>
                                '.$demounting.'
                            </select>
                        </div>
                
                        <div class="col-xs-12 col-sm-5 col-md-5 col-lg-3 col-margin">
                            <label>Монтаж</label>
                            <select class="selectpicker" name="field-u-6" data-size="5" data-container="body">
                                <option>Выберите значение</option>
                                '.$montage.'
                            </select>
                        </div>
						<div class="prep">
							<div class="col-xs-12 col-sm-5 col-md-5 col-lg-3 col-margin">
								<label>Резка наличника</label>
								<input type="checkbox" name="field-u-7" class="eye" data-toggle="toggle" data-style="ios">
							</div>

							<div class="col-xs-12 col-sm-5 col-md-5 col-lg-3 col-margin">
								<label>Ликвидация штукатурки и резка плитки</label>
								<input type="checkbox" name="field-u-8" class="eye" data-toggle="toggle" data-style="ios">
							</div>

							<div class="col-xs-12 col-sm-5 col-md-5 col-lg-3 col-margin">
								<label>Расширение проема, если стена < 20см.</label>
								<input type="checkbox" name="field-u-9" class="eye" data-toggle="toggle" data-style="ios">
							</div>

							<div class="col-xs-12 col-sm-5 col-md-5 col-lg-3 col-margin">
								<label>Расширение проема, если стена > 20см.</label>
								<input type="checkbox" name="field-u-10" class="eye" data-toggle="toggle" data-style="ios">
							</div>

							<div class="col-xs-12 col-sm-5 col-md-5 col-lg-3 col-margin">
								<label>Расширение проема(сбивка четверти)</label>
								<input type="checkbox" name="field-u-11" class="eye" data-toggle="toggle" data-style="ios">
							</div>
						</div>
						'.$prep.'
                    </div>
                </div>';


        }


        exit(json_encode($result));
    }

    public function email_me(){

        $pagetitle = "Новая заявка";
        $recepient = 'oleksandrkiiashko@gmail.com';
        $recepient = 'ongrod2@gmail.com';
        $recepient = 'ongrod2@gmail.com';
        $recepient = 'fokin91anatoli@gmail.com';
        $recepient = 'niclokitor@gmail.com';
        
        $headers = 'From: My Name <myname@mydomain.com>' . "\r\n";

        // $attachments = array(WP_CONTENT_DIR . '/uploads/attach.zip');
        $headers = 'From: My Name <myname@mydomain.com>' . "\r\n";


       wp_mail( get_bloginfo( 'admin_email' ), $pagetitle, $_POST['html'], 'Content-type: text/html');

        // echo $result;
        exit(json_encode(true));
    }

    public function add_to_cart(){
//        exit(json_encode($_POST));
        $parameters =  self::get_query('SELECT price FROM wp_doors_decoration where id = '.$_POST['decoration_id'])[0];
//        exit(json_encode('test'));
//        $param_id = explode(',',$parameters->param_id);

        $param =  self::get_query('SELECT * FROM wp_doors_visible_param where decor_id = '.$_POST['decoration_id']);

            $data_html = self::auto_choose($param,$_POST);
            $html['parameters'] = $data_html['html'];


//        


        $html['cart'] = '<div class="calculate">
                    <div class="preview">
                        <span class="btn zoom" data-toggle="modal" data-target="#modal"></span>
                        <img src="'.$_POST['img'].'">
                    </div>
                    <span class="title">Дверь «<span>'.$_POST['decor_name'].'</span>»</span>
                    <span class="descr"></span>
                    <span class="info ">Стоимость комплектации:</span>
                    <button type="button" class="btn btn-default info" data-toggle="tooltip" data-placement="top" data-trigger="manual" title="Не следует, однако забывать, что сложившаяся структура организации представляет собой интересный эксперимент проверки соответствующий условий активизации. С другой стороны реализация намеченных плановых заданий в значительной степени обуславливает создание существенных финансовых и административных условий. Задача организации, в особенности же рамки и место обучения кадров обеспечивает широкому кругу (специалистов) участие в формировании новых предложений. "></button>
                    <span class="price">'.$parameters->price.'</span>
                    <h5>Характеристики:</h5>
                    <div class="characteristics">';
                        $html['cart'] .='
                            <div class="type-door">
                                <label>Тип:</label><span>M80M</span>
                            </div>
                            <div class="complect">
                                <label>Комплектация:</label><span>Дверь + Коробка</span>
                            </div>';
                            if($_POST['width_parametr'] != '' || $_POST['height_parametr'] != '') {
                                $html['cart'] .= '
                                    <div class="size">
                                        <label>Размеры:</label><span>'.$_POST['width_parametr'].'x'.$_POST['height_parametr'].' мм</span>
                                    </div>';
                            }
                            if($_POST['color_parametr1'] != '') {
                                $html['cart'] .= '
                                <div class="color-grid">
                                    <label>Окраска решетки:</label><span>'.$_POST['color_parametr1'].'</span>
                                </div>';
                            }
                            if($_POST['color_parametr2'] != '') {
                                $html['cart'] .= '
                                <div class="color-door-block">
                                    <label>Окраска дверного блока:</label><span>'.$_POST['color_parametr2'].'</span>
                                </div>';
                            }
                            if(isset($_POST['check_signal'])){
                                $html['cart'] .='
                                <div class="security">
                                    <label>Датчик сигнализации:</label><span>Да</span>
                                </div>';
                            }
                            $html['cart'] .='
                            <div class="type-door">
                                <label>Глазок:</label><span>Да</span>
                            </div>';
                            $html['cart'] .=$data_html['haracter'];

                    $html['cart'] .='</div>
                </div>';
        exit(json_encode(array('html'=>$html,'post'=> $_POST)));
    }
	
    public function new_base_price(){
		
		$opt = $_POST['opt'];
		$opt_size = $_POST['opt_size'];
		$decor_id = $_POST['decor_id'];
		
		
		$new_base =  self::get_query('SELECT * FROM `wp_doors_base` WHERE `decor_id`= '.$decor_id.' and `opt`= "'.$opt.'" and `val1`<= '.$opt_size.' and `val2`=> '.$opt_size);
		
		//echo 'SELECT * FROM `wp_doors_base` WHERE `decor_id`= '.$decor_id.' and `opt`= "'.$opt.'" and `val1`<= '.$opt_size.' and `val2`> '.$opt_size;
        exit( json_encode($new_base) );
    }

}

