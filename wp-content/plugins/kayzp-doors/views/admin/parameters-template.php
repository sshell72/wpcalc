<?php

if ( ! defined( 'ABSPATH' ) ) {
    exit; // Exit if accessed directly.
}
$parameters = DoorsMainclass::getTableInfo('doors_params');

?>

<form class="street-container parameters-container" method="POST">
    <input type="hidden" name="check" value="true">
    <h1>Параметры</h1>

    <table>
        <thead>
            <tr>
                <th>Название</th>
                <th>Тип поля</th>
                <th>Наборы значений</th>
                <th>Удалить</th>
            </tr>
        </thead>
        <tbody>
            <?php if(is_array($parameters)) DoorsMainclass::showParameterRow($parameters); ?>
        </tbody>
    </table>

    <a href="№" class="open-popup blue-button-doors">Добавить</a>
</form>

<div class="popup" id="redact_street">
    <form class="content_popup param-pop" action="#" method="post">
        <h2>Добавить параметр</h2>
        <span class="close_popup">&times</span>
        <input type="text" name="name" placeholder="Название" required  style="margin-bottom: 20px;" />
        <select name="type-parameters">
            <option value="0">Выберите тип параметра</option>
            <?php
            $parameters_type = DoorsMainclass::getTableInfo('doors_type_params');
            foreach ($parameters_type as $param) { ?>
                <option value="<?php echo $param->id; ?>">
                    <?php echo $param->type; ?>
                </option>
            <?php } ?>
        </select>
        <select name="block-parameters">
            <option value="0">Выберите блок параметра</option>
            <?php
            $parameters_block = DoorsMainclass::getTableInfo('doors_block_params');
			
            foreach ($parameters_block as $param) { ?>
                <option value="<?php echo $param->id; ?>">
                    <?php echo $param->block; ?>
                </option>
            <?php } ?>
        </select>
        <input type="hidden" name="id" />
        <input type="submit" value="Сохранить" class="blue-button-doors">
    </form>
</div>