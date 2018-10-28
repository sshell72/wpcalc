<?php

if ( ! defined( 'ABSPATH' ) ) {
    exit; // Exit if accessed directly.
}

global $wpdb;

$services = DoorsMainclass::getTableInfo('doors_service');

?>

<form class="" method="POST">
    <input type="hidden" name="check" value="true">
    <h1>Сервис</h1>
    <table  class="table table-bordered  table-hover">
        <thead class="thead-inverse">
        <tr>
            <th>Цена на услуги</th>
            <th>Минск</th>
            <th>Регионы</th>
        </tr>
        </thead>
        <tbody>
            <?php
            if(is_array($services)){
				$cat = '';
                foreach ($services as $service){
                   
					 if($cat != $service->cat) echo '<tr class="table-success"><td colspan="3">'.$service->cat.'</td></tr>';
					 $cat = $service->cat;
                    ?>
                    <tr>
                        <td  class="position">
                            <?php echo $service->position;?>
							
                        </td>
                        <td>
                            <?php echo $service->price_minsk; ?>
							<a href="#" class="price_edit" title="Редактировать цену"  data-popup="price_edit" data-service="<?php echo $service->id;?>" data-reg="price_minsk">
								<i class="fa fa-pencil" aria-hidden="true"></i>
							</a>
                        </td>
                        <td>
                            <?php echo $service->price_regions; ?>
							<a href="#" class="price_edit" title="Редактировать цену"  data-popup="price_edit" data-service="<?php echo $service->id;?>" data-reg="price_regions">
								<i class="fa fa-pencil" aria-hidden="true"></i>
							</a>
						</td>
                    </tr>
               <?php
               }
            }
            ?>
        </tbody>
    </table>
</form>
<div class="popup_price" id="price_edit">
    <form class="content_popup clone_price_go" action="#" method="post">
        <h2>Изменить цену</h2>
        <span class="close_popup">&times </span>
        <input type="text" name="price" autofocus required />
        <input type="hidden" name="price_regions"/>
        <input type="hidden" name="id_service" />
        <input type="submit" value="Изменить" class="blue-button-doors">
    </form>
</div>