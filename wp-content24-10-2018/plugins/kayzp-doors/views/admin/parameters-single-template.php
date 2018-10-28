<?php
/**
 * Created by PhpStorm.
 * User: User
 * Date: 6/22/2018
 * Time: 12:39 AM
 */

if ( ! defined( 'ABSPATH' ) ) {
    exit; // Exit if accessed directly.
}

global $wpdb;

$table_params = $wpdb->get_blog_prefix() . 'doors_params';
$parameter = $wpdb->get_row("SELECT * FROM {$table_params} WHERE id={$_GET['param_id']}");

$table_value_p = $wpdb->get_blog_prefix() . 'doors_value_p';
$values = $wpdb->get_results("SELECT * FROM {$table_value_p} WHERE param_id={$_GET['param_id']}");

?>

<form class="street-container parameters-container-single" method="POST">
    <h1>Параметр: <?php echo $parameter->name; ?></h1>
    <table>
        <thead>
            <tr>
                <th>Название</th>
                <th>Цена</th>
                <th>Редактировать</th>
                <th>Удалить</th>
            </tr>
        </thead>
        <tbody>
            <?php
                if(!empty($values)){
                    foreach ($values as $value) { ?>
                        <tr data-id="<?php echo $value->id; ?>">
                            <td class="name-value"><?php echo $value->name; ?></td>
                            <td class="price-value"><?php echo $value->price; ?></td>
                            <td>
                                <span class="edit-value-param" data-popup="redact_street" >
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
                                </span>
                            </td>
                            <td>
                                <span class="delete_value_param">
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
                        </tr>
                    <?php }
                }
            ?>
        </tbody>
    </table>
    <input type="submit" value="Добавить" class="blue-button-doors save-param-value">
</form>

<div class="popup" id="redact_street">
    <form class="content_popup param-value-pop <?php echo $_GET['only_one'] ?>" action="#" method="post">
        <h2>Новое значение</h2>
        <p>Для указания цвета используйте формат: #color_code_rgb/Field name</p>
        <span class="close_popup">&times</span>
        <input type="text" name="name" placeholder="Название" required style="margin-bottom: 10px;" />
        <input type="number" name="price" placeholder="Стоимость параметра" required />
        <input type="hidden" name="param_id" value="<?php echo $_GET['param_id'] ?>"/>
        <input type="hidden" name="value_id" value="0"/>
        <input type="submit" value="Сохранить" class="blue-button-doors">
    </form>
</div>