<?php

if ( ! defined( 'ABSPATH' ) ) {
    exit; // Exit if accessed directly.
}
$series_street = DoorsMainclass::getSeries(1);
$series_house = DoorsMainclass::getSeries(2);

?>

<form class="street-container" method="POST">
    <input type="hidden" name="check" value="true">
    <h1>Серии</h1>
    <h2>Улица:</h2>
    <table>
        <thead>
            <tr>
                <th>Публикация</th>
                <th>Название</th>
                <th>Моделей</th>
                <th>Редактировать</th>
                <th>Удалить</th>
            </tr>
        </thead>
        <tbody>
            <?php if(is_array($series_street)) DoorsMainclass::showSeriesRow($series_street); ?>
        </tbody>
    </table>

    <div class="submit-container">
        <a href="admin.php?page=series_single&category_id=1" class="blue-button-doors">Добавить</a>
    </div>

    <h2>Квартира:</h2>
    <table>
        <thead>
        <tr>
            <th>Публикация</th>
            <th>Название</th>
            <th>Моделей</th>
            <th>Редактировать</th>
            <th>Удалить</th>
        </tr>
        </thead>
        <tbody>
            <?php DoorsMainclass::showSeriesRow($series_house); ?>
        </tbody>
    </table>
    <a href="admin.php?page=series_single&category_id=2" class="blue-button-doors">Добавить</a>
</form>

<div class="popup" id="redact_street">
    <form class="content_popup series-pop" action="#" method="post">
        <h2>Редактировать серию</h2>
        <span class="close_popup">&times</span>
        <p>Название:</p>
        <input type="text" name="name" required />
        <input type="hidden" name="id" />
        <input type="submit" value="Сохранить" class="blue-button-doors">
    </form>
</div>