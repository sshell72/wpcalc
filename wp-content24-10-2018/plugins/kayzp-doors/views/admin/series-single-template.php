<?php

if ( ! defined( 'ABSPATH' ) ) {
    exit; // Exit if accessed directly.
}

global $wpdb;

if(isset($_GET['category_id'])){
    $table_name = $wpdb->get_blog_prefix() . 'doors_category';
    $category = $wpdb->get_row("SELECT * FROM {$table_name} WHERE id={$_GET['category_id']}");
}

$name = '';
$visible = '';
$parameters_content = '';
$series_id = 0;
if(isset($_GET['series_id'])){
    $series_id = $_GET['series_id'];
    $table_series = $wpdb->get_blog_prefix() . 'doors_series';
    $table_params = $wpdb->get_blog_prefix() . 'doors_params';
    $table_value_p = $wpdb->get_blog_prefix() . 'doors_value_p';
    $table_params_series = $wpdb->get_blog_prefix() . 'doors_params_series';
    $table_param_type = $wpdb->get_blog_prefix() . 'doors_type_params';
    $table_available_param_series = $wpdb->get_blog_prefix() . 'doors_available_param_series';

    $series = $wpdb->get_row("SELECT * FROM {$table_series} WHERE id={$series_id}");
    $name = $series->name;
    $visible = $series->visible;

    // Get parameters
    $parameters = $wpdb->get_results("SELECT * FROM {$table_params_series} WHERE series_id={$series_id}");
    if(!empty($parameters)) {

        foreach ($parameters as $parameter) {

            // Get values to parameter
            $values_parameters = '';
            $values = $wpdb->get_row("SELECT available_values FROM {$table_params_series} WHERE series_id={$series->id} AND param_id={$parameter->param_id}");
            if (!empty(json_decode($values->available_values))) {
                $values = json_decode($values->available_values);
                foreach ($values as $value) {
                    $parameter_field = $wpdb->get_row("SELECT * FROM {$table_value_p} WHERE param_id={$parameter->param_id} AND id={$value}");
                    $values_parameters .= '<span class="val-element" data-id="' . $parameter_field->id . '">' . $parameter_field->name . '</span>';
                }
            }

            // get type parameter
            $parameter_field = $wpdb->get_row("SELECT * FROM {$table_params} WHERE id={$parameter->param_id}");

            // Check type to list
            $parameter_type = $wpdb->get_row("SELECT * FROM {$table_param_type} WHERE id={$parameter_field->type_id}");
            $added_param = '';
            if (strripos($parameter_type->type, 'список')) {

                $added_param = $values_parameters . '<span class="change-pop-open" data-popup="redact_street" >
                    <svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" x="0px" y="0px"
                         width="15px" height="15px" viewBox="0 0 528.899 528.899" style="enable-background:new 0 0 528.899 528.899;"
                         xml:space="preserve">
                        <g>
                            <path d="M328.883,89.125l107.59,107.589l-272.34,272.34L56.604,361.465L328.883,89.125z M518.113,63.177l-47.981-47.981
                                c-18.543-18.543-48.653-18.543-67.259,0l-45.961,45.961l107.59,107.59l53.611-53.611
                                C532.495,100.753,532.495,77.559,518.113,63.177z M0.3,512.69c-1.958,8.812,5.998,16.708,14.811,14.565l119.891-29.069
                                L27.473,390.597L0.3,512.69z"/>
                        </g>
                    </svg>
                </span>';
            }

            $ids = array();
            $names = array();
            $parameters_values = $wpdb->get_results("SELECT * FROM wp_doors_value_p WHERE param_id=".$parameter->param_id);
            foreach ($parameters_values as $parameters_value) {
                $ids[] = $parameters_value->id;
                $names[] = $parameters_value->name;
            }
            $ids = implode(',', $ids);
            $names = implode(',', $names);
            $parameters_content .= '<tr data-id="' . $parameter->param_id . '" data-type="params_series" data-series_id="'.$parameter->series_id.'">
            <td>' . $parameter_field->name . '</td>
            <td>' . $parameter_type->type . '</td>
            <td class="list-values-param" data-ids="'.$ids.'" data-names="'.$names.'">' . $added_param . '</td>
            <td>
                <span class="delete_row">
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
            </td>
        </tr>';
        }
    }
}

?>

<form class="street-container" method="POST">

    <h2>
        Серии: 
        <?php 
            if (!empty($category->name)) {
                if ($category->name == 'house') {
                    echo "Квартира";
                }
                else{
                    echo "Улица";
                }
            }
        ?>: 
        <?php echo $name ?>
    </h2>

    <label for="name">Название:</label>
    <input type="text" name="name" id="name" value="<?php echo $name; ?>"/>
    <br><br>
    <label for="show">Публикация:</label>
    <input type="checkbox" name="show" id="show" value="1" <?php checked(1, $visible) ?>/>
    <br><br>
    <input type="hidden" name="series_id" value="<?php echo $series_id; ?>"/>
    <input type="hidden" name="category_id" value="<?php echo !empty($category->id) ? $category->id : '' ?>"/>

 <input type="submit" value="Сохранить" class="blue-button-doors">

    <?php if ($name) {?>
    <h3>Лимитирование параметров</h3>
    <table style="width: 100%;" class="limit-params">
        <thead>
            <tr>
                <th>Название</th>
                <th>Тип поля</th>
                <th style="width: 175px;">Набор доступных параметров (для выпадающих списков)</th>
                <th>Удалить</th>
            </tr>
        </thead>
        <tbody>
            <?php echo $parameters_content; ?>
        </tbody>
    </table>
    <button class="open-pop-params blue-button-doors">Добавить новый</button>
    <?php } ?>
</form>

<div class="popup" id="redact_street">
    <form class="content_popup series-single-pop" action="#" method="post" data-id="<?php echo !empty($series->id) ? $series->id : '' ?>">
        <h2>Добавить параметр</h2>
        <span class="close_popup">&times</span>
        <p>Выберите:</p>
        <select name="parameter"/>
            <?php
            $parameters = DoorsMainclass::getTableInfo('doors_params');
            foreach ($parameters as $param) {
                $ids = array();
                $names = array();
                $parameters_values = $wpdb->get_results("SELECT * FROM wp_doors_value_p WHERE param_id=".$param->id);
                foreach ($parameters_values as $parameters_value) {
                    $ids[] = $parameters_value->id;
                    $names[] = $parameters_value->name;
                }
                $ids = implode(',', $ids);
                $names = implode(',', $names);
                echo '<option  data-ids="'.$ids.'" data-names="'.$names.'" value="'.$param->id.'">'.$param->name.'</option>';
            }
            ?>
        </select>
        <input type="submit" value="Сохранить" class="blue-button-doors">
    </form>
</div>

<div class="popup" id="param-change" >
    <div style="width: 600px" class="content_popup params-pop">
        <h2>Редактировать доступные параметры</h2>
        <span class="close_popup">&times</span>
        <p>Название:</p>
        <div style="display: flex;width: 600px" class="row">
            <div style="width: 300px;" class="tags content-tags">
                <input type="text" class="tags" value="" placeholder="Input Tags" />
                <ul class="tags_available">
                </ul>
                <input type="hidden" class="tag-values"/>
            </div>
            <input type="hidden" name="id-param"/>
            <input style="position: relative;width: 150px;height: 50px; margin: 20px;" type="submit" value="Сохранить"  class="blue-button-doors">
        </div>

    </div>
</div>