<?php

if ( ! defined( 'ABSPATH' ) ) {
    exit; // Exit if accessed directly.
}

global $wpdb;
$series = DoorsMainclass::getSeries();
?>

<form class="street-container" method="POST">

    <h2>Модель</h2>

    <label for="name">Название:</label>
    <input type="text" name="name" id="name" value="" required/>
    <br><br>
    <label for="show">Публикация:</label>
    <input type="checkbox" name="show" id="show" value="1"/>
    <br><br>
    <label for="series">Серия</label>
    <select class="" name="series_id" id="series">
        <option value="">Выберите серию</option>
        <?php
        if(is_array($series)) {
            foreach ($series as $ser) {
                $table_name = $wpdb->get_blog_prefix() . 'doors_category';
                $name_category = $wpdb->get_row( "SELECT * FROM {$table_name} WHERE id={$ser->category_id}")->name;
                echo '<option value="'.$ser->id.'">'.$ser->name.'-'.$name_category.'</option>';
            }
        }
        ?>
    </select>
    <input type="submit" value="Сохранить" class="blue-button-doors">
</form>