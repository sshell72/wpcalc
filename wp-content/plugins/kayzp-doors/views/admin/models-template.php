<?php

if ( ! defined( 'ABSPATH' ) ) {
    exit; // Exit if accessed directly.
}

global $wpdb;

$models = DoorsMainclass::getTableInfo('doors_models');

?>

<form class="street-container" method="POST">
    <input type="hidden" name="check" value="true">
    <h1>Модели</h1>
    <table>
        <thead>
        <tr>
            <th>Публикация</th>
            <th>Название модели</th>
            <th>Серия</th>
            <th style="width: 40%;">Отделка</th>
            <th>Редактировать</th>
            <th>Удалить</th>
            <th>Дублировать</th>
        </tr>
        </thead>
        <tbody>
            <?php
            if(is_array($models)){
                foreach ($models as $model){
                    $table_series = $wpdb->get_blog_prefix() . 'doors_series';
                    $series_fields = $wpdb->get_row( "SELECT * FROM {$table_series} WHERE id={$model->series_id}" );
                    if (!$series_fields) {
                        continue;
                    }
                    $series_name = $series_fields->name;

                    $table_category = $wpdb->get_blog_prefix() . 'doors_category';
                    $series_fields = $wpdb->get_row( "SELECT * FROM {$table_category} WHERE id={$series_fields->category_id }" );
                    $category_name = $series_fields->name;

                    $table_decor = $wpdb->get_blog_prefix() . 'doors_decoration';
                    $decorations = $wpdb->get_results( "SELECT * FROM {$table_decor} WHERE model_id={$model->id}" );
                    $decoration_str = '';
                    if(is_array($decorations))
                    {
                        foreach ($decorations as $decoration) {
                            $decoration_str .= '<a href="admin.php?page=parameters_decor&model_id='.$model->id.'&decor_id='.$decoration->id.'">' . $decoration->name . '</a>
                                                <span class="delete_decor">
                                                    <svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" height="13px" width="13px" x="0px" y="0px"
                                                         viewBox="0 0 486.4 486.4" style="enable-background:new 0 0 486.4 486.4;" xml:space="preserve" fill="red">
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

												<a href="#" class="clone_decor" title="Клонировать отделку"  data-popup="clone_decor" data-model="'. $model->id .'" data-decor="'.$decoration->id.'">
													<i class="fa fa-files-o" aria-hidden="true"></i>
												</a>
												';
                        }
                    }
                    ?>
                    <tr data-id="<?php echo $model->id; ?>" data-type="models">
                        <td class="visible-series">
                            <input type="checkbox" name="visible" value="1" <?php checked(1, $model->visible); ?>>
                        </td>
                        <td class="name-series">
                            <?php echo $model->name; ?>
                        </td>
                        <td>
                            <?php echo $series_name; ?>, <?php echo $category_name ?>
                        </td>
                        <td>
                            <?php echo $decoration_str; ?>
							
                            <a href="admin.php?page=parameters_decor&model_id=<?php echo $model->id; ?>&id_model=<?php echo $model->id; ?>" class="add-decor">+добавить</a>
                        </td>
                        <td>
                            <span class="street_redact" data-popup="redact_street" >
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
                        <td>
                            <a href="#" class="clone_model" title="Клонировать модель"  data-popup="clone_model" data-model="<?php echo $model->id; ?>" >
								<i class="fa fa-files-o" aria-hidden="true"></i>
							</a>
                        </td>
                    </tr>
               <?php
               }
            }
            ?>
        </tbody>
    </table>

    <a href="admin.php?page=models_single" class="blue-button-doors">Добавить</a>

</form>

<div class="popup" id="redact_street">
    <form class="content_popup change_model_name" action="#" method="post">
        <h2>Редактировать модель</h2>
        <span class="close_popup">&times </span>
        <p>Название:</p>
        <input type="text" name="name" required />
        <input type="hidden" name="id" />
        <input type="submit" value="Сохранить" class="blue-button-doors">
    </form>
</div>

<div class="popup_decor" id="clone_decor">
    <form class="content_popup clone_decor_go" action="#" method="post">
        <h2>Клонировать отделку</h2>
        <span class="close_popup">&times </span>
        <p>Отделка будет копирована со всеми свойствами и помещена в ту же модель, что и оригинал</p>
        <p>Введите название новой отделки</p>
        <input type="text" name="name" autofocus required />
        <input type="hidden" name="id_decor" />
        <input type="submit" value="Клонировать" class="blue-button-doors">
    </form>
</div>

<div class="popup_model" id="clone_model">
    <form class="content_popup clone_model_go" action="#" method="post">
        <h2>Клонировать модель</h2>
        <span class="close_popup">&times </span>
        <p>Модель будет продублирована вместе со всеми отделками</p>
        <p>Введите название новой модели</p>
        <input type="text" name="name" autofocus required />
        <input type="hidden" name="id_model" />
        <input type="submit" value="Клонировать" class="blue-button-doors">
    </form>
</div>
