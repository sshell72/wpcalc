<?php

if ( ! defined( 'ABSPATH' ) ) {
    exit; // Exit if accessed directly.
}

$id_model = isset($_GET['model_id']) ? $_GET['model_id'] : 0;

global $wpdb;
$table_models = $wpdb->get_blog_prefix() . 'doors_models';
$model = $wpdb->get_row("SELECT * FROM {$table_models} WHERE id={$id_model}");

$name = '';
$price = '';
$visible = 0;
$photo_front = '';
$photo_back = '';
$parameters_content = '';
$decor_id = 0;

if(isset($_GET['decor_id'])){
    $decor_id = $_GET['decor_id'];

    $table_visible_param = $wpdb->get_blog_prefix() . 'doors_visible_param';
    $table_name = $wpdb->get_blog_prefix() . 'doors_decoration';
    $table_value_p = $wpdb->get_blog_prefix() . 'doors_value_p';
    $table_param_type = $wpdb->get_blog_prefix() . 'doors_type_params';
    $table_available_param = $wpdb->get_blog_prefix() . 'doors_available_param';

    $decoration = $wpdb->get_row("SELECT * FROM {$table_name} WHERE id={$decor_id}");
    $name = $decoration->name;
    $price = $decoration->price;
    $visible = $decoration->visible;
    $photo_front = $decoration->photo_front;
    $photo_back = $decoration->photo_back;

    // Get parameters
    $table_models = $wpdb->get_blog_prefix() . 'doors_models';
    $model_field = $wpdb->get_row("SELECT * FROM {$table_models} WHERE id={$decoration->model_id}"); // get model
    
    $table_params = $wpdb->get_blog_prefix() . 'doors_params_series';
    $table_params_all = $wpdb->get_blog_prefix() . 'doors_params';
    $parameters = $wpdb->get_results("SELECT * FROM {$table_params} WHERE series_id={$model_field->series_id}");
    $parameters_decor = $wpdb->get_results("
SELECT p.id, p.name FROM wp_doors_params p JOIN wp_doors_visible_param v JOIN `wp_doors_value_p` d ON p.id=v.param_id and decor_id={$decor_id} and d.param_id=p.id GROUP BY p.id");

}


?>

<form class="street-container" method="POST" enctype="multipart/form-data">

    <h1>Отделка: <?php echo $name; ?></h1>
    <h3>Дверь: <?php echo $model->name; ?></h3>

    <label for="name">Название:</label>
    <input type="text" name="name" id="name" value="<?php echo $name; ?>"/>
    <br><br>

    <label for="price">Базовая цена:</label>
    <input type="text" name="price" id="price" value="<?php echo $price; ?>"/>
    <br><br>
	

    <div class="container-base" data-decor-id="<?php echo $decor_id; ?>">
        <?php 
            $base_params = $wpdb->get_results("SELECT * FROM wp_doors_base WHERE decor_id={$decor_id}");
            foreach ($base_params as $base_param): 
        ?>
            <div class="item-base" style="margin-bottom: 20px;" data-locked-id="<?php echo $base_param->id ?>" data-decor-id="<?php echo $decor_id; ?>">
            <span>Если</span>
            "
            <?php 
                echo $base_param->opt;
            ?>"
            <span>от</span>
"
            <?php 
                    echo $base_param->val1;
            ?>
"
            <span>до</span>
"
            <?php 
                    echo $base_param->val2;
            ?>
"
            <span>, то базовая цена равна</span>"
            <?php 
                echo $base_param->price;
            ?>"
            <span>и цена параметров </span>"
			<select disabled id="params_vis" name="params_vis[]" multiple>             
					<?php
						foreach ($parameters_decor as $parameter_decor) {
							?>
							<option  value="<?php echo $parameter_decor->id.'" '; 
							$params = json_decode($base_param->params);
							foreach($params as $param){
								if($parameter_decor->id == $param) echo 'selected';
							}
							?>>
								<?php 
									echo $parameter_decor->name; 
								?>
							</option>
						<?php
						}
					?>
				</select>
            <?php 
                //echo $base_param->params;
            ?>"
			
            <span>увеличивается на коэффициент</span>"
            <?php 
                echo $base_param->coefficient;
            ?>"
			
            <span class="delete_row delete_r ka_del" style="margin: 0 15px;">
                <svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" height="15px" width="15px" x="0px" y="0px"
                     viewBox="0 0 486.4 486.4" style="enable-background:new 0 0 486.4 486.4;" xml:space="preserve">
                    <g>
                        <g>
                            <path d="M446,70H344.8V53.5c0-29.5-24-53.5-53.5-53.5h-96.2c-29.5,0-53.5,24-53.5,53.5V70H40.4c-7.5,0-13.5,6-13.5,13.5
                                S32.9,97,40.4,97h24.4v317.2c0,39.8,32.4,72.2,72.2,72.2h212.4c39.8,0,72.2-32.4,72.2-72.2V97H446c7.5,0,13.5-6,13.5-13.5
                                S453.5,70,446,70z M168.6,53.5c0-14.6,11.9-26.5,26.5-26.5h96.2c14.6,0,26.5,11.9,26.5,26.5V70H168.6V53.5z M394.6,414.2
                                c0,24.9-20.3,45.2-45.2,45.2H137c-24.9,0-45.2-20.3-45.2-45.2V97h302.9v317.2H394.6z"/>
                            <path d="M243.2,411c7.5,0,13.5-6,13.5-13.5V158.9c0-7.5-6-13.5-13.5-13.5s-13.5,6-13.5,13.5v238.5
                                C229.7,404.9,235.7,411,243.2,411z"/>
                            <path d="M155.1,396.1c7.5,0,13.5-6,13.5-13.5V173.7c0-7.5-6-13.5-13.5-13.5s-13.5,6-13.5,13.5v208.9
                                C141.6,390.1,147.7,396.1,155.1,396.1z"/>
                            <path d="M331.3,396.1c7.5,0,13.5-6,13.5-13.5V173.7c0-7.5-6-13.5-13.5-13.5s-13.5,6-13.5,13.5v208.9
                                C317.8,390.1,323.8,396.1,331.3,396.1z"/>
                        </g>
                    </g>
                </svg>
            </span>
        </div>
        <?php endforeach; ?>
        <div class="item-base" data-locked-id="" data-decor-id="<?php echo $decor_id; ?>">
            <span>Если</span>

            <select  name="choose-base-param" data-decor-id="<?php echo $decor_id; ?>">
                <option value="">Выберите параметр</option>
                <option value="Ширина" selected>Ширина</option>
                <option value="Высота">Высота</option>
                <option value="Площадь">Площадь</option>             
            </select>
            <span>от</span>
				<input type="text" name="val1" id="val1" value="190"/>
			<span>до</span>
				<input type="text" name="val2" id="val2" value="210"/>
            <span>, то базовая цена</span>
				<input type="text" name="price_new" id="price_new" value="555"/>
            <span>и цена параметров</span>
				<select id="params" name="params[]" multiple>             
					<?php
						foreach ($parameters_decor as $parameter_decor) {
							?>
							<option  value="<?php echo $parameter_decor->id; ?>">
								<?php 
									echo $parameter_decor->name; 
								?>
							</option>
						<?php
						}
					?>
				</select>
			<span>увеличивается на коэффициент</span>
				<input type="text" name="coefficient" id="coefficient" value="1.9"/>
				<input type="hidden" name="decor_id" id="decor_id" value="<?php echo $decor_id; ?>"/>
				<!--<select  multiple  id="multiple" name="params">
				  <option value="">&nbsp;</option>
				  <option value="1" data-subtitle="The first option" data-left="1.png" data-right="1" selected>One</option>
				  <option value="2" data-subtitle="The second option" data-left="2.png" data-right="2">Two</option>
				  <option value="3" data-subtitle="The third option" data-left="3.png" data-right="3">Three</option>
				  ...
				</select>-->
				
            <button class="add_rule">Сохранить</button>
        </div>

    </div>

    <label for="show">Публикация:</label>
    <input type="checkbox" name="show" id="show" value="1" <?php checked(1, $visible) ?>/>
    <br><br>

    <p>Загрузка фото</p>
    <div class="photo-container">
        <div class="single-photo">
            <img src="<?php echo $photo_front; ?>" alt="">
            <button class="wp_media blue-button-doors">Добавить/изменить фотографию</button>
            <input type="hidden" name="front-side" value="<?php echo $photo_front; ?>">
        </div>
        <div class="single-photo">
            <img src="<?php echo $photo_back; ?>" alt="">
            <button class="wp_media blue-button-doors">Добавить/изменить фотографию</button>
            <input type="hidden" name="back-side" value="<?php echo $photo_back; ?>">
        </div>
    </div>

    <input type="hidden" name="decor_id" value="<?php echo $decor_id; ?>">
    <input type="hidden" name="id-model" value="<?php echo $id_model; ?>">

    <h3>Параметры</h3>
    <table style="width: 100%;" class="limit-params dec">
        <thead>
        <tr>
            <th>Название</th>
            <th>Тип поля</th>
            <th>Доступность</th>
            <th>Значение по умолчанию</th>
            <th>Доступные значения</th>
        </tr>
        </thead>
        <tbody data-decor-id="<?php echo $decor_id; ?>">
            <?php
            if(!empty($parameters)){
                foreach ($parameters as $parameter) {
                    $param = $wpdb->get_row("SELECT * FROM {$table_params_all} WHERE id={$parameter->param_id}");
                    $parameter_type = $wpdb->get_row("SELECT * FROM {$table_param_type} WHERE id={$param->type_id}");

                    $parameter_in_decor_table = $wpdb->get_row("SELECT * FROM {$table_available_param} WHERE param_id={$parameter->param_id} AND decor_id={$decor_id}");

                    $visible = '';
                    if (!empty($parameter_in_decor_table)) {
                        $visible = $parameter_in_decor_table->visible;
                    }


                    // $param_visible = $wpdb->get_row("SELECT * FROM {$table_visible_param} WHERE param_id={$parameter->id} AND decor_id={$decor_id}");

                    // if(!empty($param_visible)) $visible = $param_visible->visible;

                    // // get all values for select
                    // $values = $wpdb->get_results("SELECT * FROM {$table_value_p} WHERE param_id={$parameter->id}");

                    // // get available values
                    $values_available_all = $wpdb->get_results("SELECT available_decor_values FROM {$table_available_param} WHERE decor_id={$decor_id} AND param_id={$parameter->param_id}");

                    ?>
                        <tr data-id="<?php echo $param->id; ?>" data-dec-id="<?php echo $decor_id; ?>">
                            <td>
                                <?php echo $param->name; ?>
                            </td>
                            <td>
                                <?php echo $parameter_type->type; ?>
                            </td>
                            <td>
                                <input type="checkbox" class="visible-param" name="visible" <?php checked('1', $visible) ?>>
                            </td>
                            <td>
                                <?php if(strripos($parameter_type->type, 'список') !== false) : ?>
                                    <select name="default-param" id="">
                                        <option value="">Выберите значение по умолчанию</option>
                                        <?php
                                        if(!empty($values_available_all)){
                                            $values_available_all = json_decode($values_available_all[0]->available_decor_values);

                                            foreach ($values_available_all as $values_available) {

                                                $selected = '';
                                                $item = $wpdb->get_row("SELECT * FROM {$table_value_p} WHERE id={$values_available} AND param_id={$param->id}");


                                                if(empty($item)) continue;

                                                $item_def = $wpdb->get_row("SELECT * FROM {$table_available_param} WHERE param_id={$param->id} AND decor_id={$decor_id}");
                                                if($item_def->def_value == $item->id){
                                                    $selected = 'selected="selected"';
                                                }

                                                print_r("SELECT * FROM {$table_available_param} WHERE param_id={$item->id} AND decor_id={$decor_id}");

                                                ?>
                                                <option value="<?php echo $item->id; ?>" <?php echo $selected; ?>>
                                                    <?php echo $item->name; ?>
                                                </option>
                                                <?php
                                            }
                                        }
                                        ?>
                                    </select>
                                <?php endif; ?>
                            </td>
                            <td>
                                <?php
                                if (strripos($parameter_type->type, 'список') !== false) : ?>
                                <?php
                                    if(false){
                                    foreach ($values_available_all as $values_available) {

                                        $item = $wpdb->get_row("SELECT * FROM {$table_value_p} WHERE id={$values_available->value_id} AND param_id={$parameter->id}");

                                        if(empty($item)) continue;

                                        echo '<span data-id="'.$item->id.'">'.$item->name.'</span>
                                                <span class="delete_value">
                                                    <svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" height="13px" width="13px" x="0px" y="0px" viewBox="0 0 486.4 486.4" style="enable-background:new 0 0 486.4 486.4;" xml:space="preserve" fill="red">
                                                        <g>
                                                            <g>
                                                                <path d="M446,70H344.8V53.5c0-29.5-24-53.5-53.5-53.5h-96.2c-29.5,0-53.5,24-53.5,53.5V70H40.4c-7.5,0-13.5,6-13.5,13.5
                                                                    S32.9,97,40.4,97h24.4v317.2c0,39.8,32.4,72.2,72.2,72.2h212.4c39.8,0,72.2-32.4,72.2-72.2V97H446c7.5,0,13.5-6,13.5-13.5
                                                                    S453.5,70,446,70z M168.6,53.5c0-14.6,11.9-26.5,26.5-26.5h96.2c14.6,0,26.5,11.9,26.5,26.5V70H168.6V53.5z M394.6,414.2
                                                                    c0,24.9-20.3,45.2-45.2,45.2H137c-24.9,0-45.2-20.3-45.2-45.2V97h302.9v317.2H394.6z"></path>
                                                                <path d="M243.2,411c7.5,0,13.5-6,13.5-13.5V158.9c0-7.5-6-13.5-13.5-13.5s-13.5,6-13.5,13.5v238.5
                                                                    C229.7,404.9,235.7,411,243.2,411z"></path>
                                                                <path d="M155.1,396.1c7.5,0,13.5-6,13.5-13.5V173.7c0-7.5-6-13.5-13.5-13.5s-13.5,6-13.5,13.5v208.9
                                                                    C141.6,390.1,147.7,396.1,155.1,396.1z"></path>
                                                                <path d="M331.3,396.1c7.5,0,13.5-6,13.5-13.5V173.7c0-7.5-6-13.5-13.5-13.5s-13.5,6-13.5,13.5v208.9
                                                                    C317.8,390.1,323.8,396.1,331.3,396.1z"></path>
                                                            </g>
                                                        </g>
                                                    </svg>
                                                </span>';
                                    }

                                }
                                ?>
								<span value="">Выберите доступные параметры</span>
                                <select name="available-param[]" multiple>
                                    
                                    <?php
                                    if(!empty($parameter->available_values)){
                                        $values = json_decode($parameter->available_values);
                                        foreach ($values as $value) {
                                            $checked = '';
                                            if(!empty($values_available_all)){
                                                foreach ($values_available_all as $values_available) {
                                                    if ($value == $values_available) {
                                                        $checked = 'selected';
                                                    }
                                                }
                                            }

                                            ?>
                                            <option <?php echo $checked; ?> value="<?php echo $value; ?>">
                                                <?php 
                                                $item = $wpdb->get_row("SELECT * FROM {$table_value_p} WHERE id={$value} AND param_id={$param->id}");

                                                    echo $item->name; 
                                                ?>
                                            </option>
                                        <?php
                                        }
                                    }
                                    ?>
                                </select>
                                <?php endif; ?>
                            </td>
                        </tr>
                    <?php
                }
            }
            ?>
        </tbody>
    </table>

    <h3>Зависимости блокировки</h3>
    <div class="container-block" data-decor-id="<?php echo $decor_id; ?>">
        <?php 
            $blocked_params = $wpdb->get_results("SELECT * FROM wp_doors_blocked WHERE decor_id={$decor_id}");
            foreach ($blocked_params as $blocked_param): 
        ?>
            <div class="item-block" style="margin-bottom: 20px;" data-locked-id="<?php echo $blocked_param->id ?>" data-decor-id="<?php echo $decor_id; ?>">
            <span>Если параметр</span>
            "
            <?php 
                $param= $wpdb->get_row("SELECT * FROM wp_doors_params WHERE id={$blocked_param->param_id}");
                if ($param) {
                    echo $param->name;
                }
            ?>"
            <span>имеет значение</span>
"
            <?php 
                $param= $wpdb->get_row("SELECT * FROM wp_doors_value_p WHERE id={$blocked_param->value_id}");
                if ($param) {
                    echo $param->name;
                }
            ?>
"
            <span>, то заблокировать поле</span>"
            <?php 
                $param= $wpdb->get_row("SELECT * FROM wp_doors_params WHERE id={$blocked_param->param_block_id}");
                if ($param) {
                    echo $param->name;
                }
            ?>"
            <span class="delete_row kayzp_del" style="margin: 0 15px;">
                <svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" height="15px" width="15px" x="0px" y="0px"
                     viewBox="0 0 486.4 486.4" style="enable-background:new 0 0 486.4 486.4;" xml:space="preserve">
                    <g>
                        <g>
                            <path d="M446,70H344.8V53.5c0-29.5-24-53.5-53.5-53.5h-96.2c-29.5,0-53.5,24-53.5,53.5V70H40.4c-7.5,0-13.5,6-13.5,13.5
                                S32.9,97,40.4,97h24.4v317.2c0,39.8,32.4,72.2,72.2,72.2h212.4c39.8,0,72.2-32.4,72.2-72.2V97H446c7.5,0,13.5-6,13.5-13.5
                                S453.5,70,446,70z M168.6,53.5c0-14.6,11.9-26.5,26.5-26.5h96.2c14.6,0,26.5,11.9,26.5,26.5V70H168.6V53.5z M394.6,414.2
                                c0,24.9-20.3,45.2-45.2,45.2H137c-24.9,0-45.2-20.3-45.2-45.2V97h302.9v317.2H394.6z"/>
                            <path d="M243.2,411c7.5,0,13.5-6,13.5-13.5V158.9c0-7.5-6-13.5-13.5-13.5s-13.5,6-13.5,13.5v238.5
                                C229.7,404.9,235.7,411,243.2,411z"/>
                            <path d="M155.1,396.1c7.5,0,13.5-6,13.5-13.5V173.7c0-7.5-6-13.5-13.5-13.5s-13.5,6-13.5,13.5v208.9
                                C141.6,390.1,147.7,396.1,155.1,396.1z"/>
                            <path d="M331.3,396.1c7.5,0,13.5-6,13.5-13.5V173.7c0-7.5-6-13.5-13.5-13.5s-13.5,6-13.5,13.5v208.9
                                C317.8,390.1,323.8,396.1,331.3,396.1z"/>
                        </g>
                    </g>
                </svg>
            </span>
        </div>
        <?php endforeach; ?>
        <div class="item-block" data-locked-id="" data-decor-id="<?php echo $decor_id; ?>">
            <span>Если параметр</span>

            <select name="choose-bloc-param" data-decor-id="<?php echo $decor_id; ?>">
                <option value="">Выберите параметр</option>
                <?php
                if(!empty($parameters)) {
                    foreach ($parameters as $parameter) {
                        $param = $wpdb->get_row("SELECT * FROM {$table_params_all} WHERE id={$parameter->param_id}");

                        if($param->type_id != 2 && $param->type_id != 3) continue;
                        ?>

                        <option value="<?php echo $param->id; ?>">
                            <?php echo $param->name; ?>
                        </option>
                    <?php
                    }
                }
                ?>
            </select>
            <span>имеет значение</span>

            <select name="values-block" data-series_id="<?php echo $model_field->series_id; ?>">
                <option value="">Выберите значение</option>
            </select>

            <span>, то заблокировать поле</span>
            <select name="blocked-param" data-decor-id="<?php echo $decor_id; ?>">
                <option value="0
">Выберите поле</option>
                <?php
                if(!empty($parameters)) {
                    foreach ($parameters as $parameter) {
                        if($parameter->type_id != 2 && $parameter->type_id != 3) continue;
                        ?>

                        <option value="<?php echo $parameter->id; ?>">
                            <?php echo $parameter->name; ?>
                        </option>
                        <?php
                    }
                }
                ?>
            </select>
            
            <button class="add_rule">Сохранить</button>
        </div>

    </div>
	
<!-- 	
    <h3>Зависимости цен</h3>
    <div class="container-block" data-decor-id="<?php echo $decor_id; ?>">
        <?php 
            $blocked_params = $wpdb->get_results("SELECT * FROM wp_doors_blocked WHERE decor_id={$decor_id}");
            foreach ($blocked_params as $blocked_param): 
        ?>
            <div class="item-block" style="margin-bottom: 20px;" data-locked-id="<?php echo $blocked_param->id ?>" data-decor-id="<?php echo $decor_id; ?>">
            <span>Если параметр</span>
            "
            <?php 
                $param= $wpdb->get_row("SELECT * FROM wp_doors_params WHERE id={$blocked_param->param_id}");
                if ($param) {
                    echo $param->name;
                }
            ?>"
            <span>имеет значение</span>
"
            <?php 
                $param= $wpdb->get_row("SELECT * FROM wp_doors_value_p WHERE id={$blocked_param->value_id}");
                if ($param) {
                    echo $param->name;
                }
            ?>
"
            <span>, то заблокировать поле</span>"
            <?php 
                $param= $wpdb->get_row("SELECT * FROM wp_doors_params WHERE id={$blocked_param->param_block_id}");
                if ($param) {
                    echo $param->name;
                }
            ?>"
            <span class="delete_row kayzp_del" style="margin: 0 15px;">
                <svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" height="15px" width="15px" x="0px" y="0px"
                     viewBox="0 0 486.4 486.4" style="enable-background:new 0 0 486.4 486.4;" xml:space="preserve">
                    <g>
                        <g>
                            <path d="M446,70H344.8V53.5c0-29.5-24-53.5-53.5-53.5h-96.2c-29.5,0-53.5,24-53.5,53.5V70H40.4c-7.5,0-13.5,6-13.5,13.5
                                S32.9,97,40.4,97h24.4v317.2c0,39.8,32.4,72.2,72.2,72.2h212.4c39.8,0,72.2-32.4,72.2-72.2V97H446c7.5,0,13.5-6,13.5-13.5
                                S453.5,70,446,70z M168.6,53.5c0-14.6,11.9-26.5,26.5-26.5h96.2c14.6,0,26.5,11.9,26.5,26.5V70H168.6V53.5z M394.6,414.2
                                c0,24.9-20.3,45.2-45.2,45.2H137c-24.9,0-45.2-20.3-45.2-45.2V97h302.9v317.2H394.6z"/>
                            <path d="M243.2,411c7.5,0,13.5-6,13.5-13.5V158.9c0-7.5-6-13.5-13.5-13.5s-13.5,6-13.5,13.5v238.5
                                C229.7,404.9,235.7,411,243.2,411z"/>
                            <path d="M155.1,396.1c7.5,0,13.5-6,13.5-13.5V173.7c0-7.5-6-13.5-13.5-13.5s-13.5,6-13.5,13.5v208.9
                                C141.6,390.1,147.7,396.1,155.1,396.1z"/>
                            <path d="M331.3,396.1c7.5,0,13.5-6,13.5-13.5V173.7c0-7.5-6-13.5-13.5-13.5s-13.5,6-13.5,13.5v208.9
                                C317.8,390.1,323.8,396.1,331.3,396.1z"/>
                        </g>
                    </g>
                </svg>
            </span>
        </div>
        <?php endforeach; ?>
        <div class="item-block" data-locked-id="" data-decor-id="<?php echo $decor_id; ?>">
            <span>Если параметр</span>

            <select name="choose-bloc-param" data-decor-id="<?php echo $decor_id; ?>">
                <option value="">Выберите параметр</option>
                <?php
                if(!empty($parameters)) {
                    foreach ($parameters as $parameter) {
                        $param = $wpdb->get_row("SELECT * FROM {$table_params_all} WHERE id={$parameter->param_id}");

                        if($param->type_id != 2 && $param->type_id != 3) continue;
                        ?>

                        <option value="<?php echo $param->id; ?>">
                            <?php echo $param->name; ?>
                        </option>
                    <?php
                    }
                }
                ?>
            </select>
            <span>имеет значение</span>

            <select name="values-block" data-series_id="<?php echo $model_field->series_id; ?>">
                <option value="">Выберите значение</option>
            </select>

            <span>, то заблокировать поле</span>
            <select name="blocked-param" data-decor-id="<?php echo $decor_id; ?>">
                <option value="0
">Выберите поле</option>
                <?php
                if(!empty($parameters)) {
                    foreach ($parameters as $parameter) {
                        if($parameter->type_id != 2 && $parameter->type_id != 3) continue;
                        ?>

                        <option value="<?php echo $parameter->id; ?>">
                            <?php echo $parameter->name; ?>
                        </option>
                        <?php
                    }
                }
                ?>
            </select>
            
            <button class="add_rule">Сохранить</button>
        </div>

    </div>
-->

    <input type="submit" value="Сохранить" class="blue-button-doors">
</form>