<?php
/**
 * Created by PhpStorm.
 * User: User
 * Date: 6/15/2018
 * Time: 11:13 AM
 */



get_header(); ?>

<div class="container">
            <div class="row">
                <div id="content" class="col-sm-12 col-md-8 col-lg-9">
                    <ul id="tabs" class="nav nav-tabs">
                        <li role="presentation" class="active"><a href="#standart">Стандартный комплект</a></li>
                        <li role="presentation"><a href="#individual">Индивидуальный комплект</a></li>
                    </ul>
                    <div class="tab-content">
                        <div class="tab-pane active" id="standart">
                            <div id="collection" class="row">
                                <div class="col-xs-12 col-sm-12 col-md-12 col-lg-4 col-lg-push-8">
                                    <form class="navbar-form navbar-right" role="search">
                                            <input type="text" class="form-control kayzp_search_field" placeholder="Быстрый поиск по модели" data-provide="typeahead">
                                            <button type="submit" class="btn btn-default"></button>
                                            <ul id="kayzp_search">
                                                <?php 
                                                    global $wpdb;
                                                    $models = $wpdb->get_results("SELECT * FROM wp_doors_models WHERE visible=1");
                                                    foreach ($models as $model) {
                                                        echo '<li data-id="'.$model->id.'" data-series-id="'.$model->series_id.'" class="'.$model->name.'"><a href="#">'.$model->name.'</a></li>';
                                                    }
                                                ?>
                                            </ul>
                                    </form>
                                </div>
                                <div class="col-xs-12 col-sm-6 col-md-6 col-lg-4 col-lg-pull-4 collection">
                                    <span class="house">&nbsp;&nbsp;</span>
                                    <ul id="house" class="nav nav-pills">
                                        <?php 
                                            global $wpdb;
                                            $house_series = $wpdb->get_results("SELECT * FROM wp_doors_series WHERE category_id=2 AND visible=1");
                                            foreach ($house_series as $house_seria) {
                                                echo '<li data-id="'.$house_seria->id.'" class="'.$house_seria->name.'"><a href="#">'.$house_seria->name.'</a></li>';
                                            }
                                        ?>
                                        <!-- <li class="70"><a href="#">70</a></li> -->
                                        <!-- <li class="80 active"><a href="#">80</a></li> -->
                                        <!-- <li class="90"><a href="#">90</a></li> -->
                                        <!-- <li class="100"><a href="#">100</a></li> -->
                                    </ul>
                                </div>
                                <div class="col-xs-12 col-sm-6 col-md-6 col-lg-4 col-lg-pull-4 collection">
                                    <span class="skyline">&nbsp;&nbsp;</span>
                                    <ul id="skyline" class="nav nav-pills">

                                        <?php 
                                            global $wpdb;
                                            $street_series = $wpdb->get_results("SELECT * FROM wp_doors_series WHERE category_id=1 AND visible=1");
                                            foreach ($street_series as $street_seria) {
                                                echo '<li data-id="'.$street_seria->id.'" class="'.$street_seria->name.'"><a href="#">'.$street_seria->name.'</a></li>';
                                            }
                                        ?>
                                        <!-- <li class="70"><a href="#">70</a></li> -->
                                        <!-- <li class="80"><a href="#">80</a></li> -->
                                        <!-- <li class="90"><a href="#">90</a></li> -->
                                        <!-- <li class="100"><a href="#">100</a></li> -->
                                    </ul>
                                </div>
                            </div>
                            <hr/>
                            
                            
                            
                                        <div class="row" id="doorselect" style="display: none; margin-left: 0px!important; margin-right: 0px!important">
                                    <div class="col-sm-12 col-md-12 col-lg-12">
                                    
                                    
                                        
                                        
                                          <span class="title">Выберите дверь</span>
                                
                                
                                <select class="selectpicker" data-size="5" id="choose_models" data-container="body">                                      
                                </select>
                                
                                
                                    </div>
                                    </div>
                            
                            
                            <div class="row" style="display: none;" id="show_decoration">
                                <div class="col-sm-12 col-md-12 col-lg-12">
                                    <div id="js_image_selection" class="horizontal-scrollable-tabs">
                                        <div class="scroller arrow-left"><i class="fa fa-arrow-left"></i></div>
                                        <div class="scroller arrow-right"><i class="fa fa-arrow-right"></i></div>
                                        <div class="horizontal-tabs">
                                            <div role="tablist" class="nav nav-tabs nav-tabs-horizontal">
                                               
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <form role="form" id="filter_parametrs">
                                <div class="row" >
                                   
                                    
                                    
                                    
                                    
                                    
                                    
                                    
                                    
                                    
                                    
                                    <div style="padding: 0!important; margin: 0 15px !important;" class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
                                        <div  style="padding: 0!important; margin: 0 !important;" class="panel panel-default">
                                            <div   style="padding: 0!important; margin: 0 !important;" class="panel-body">
                                           
                                                  <div class="col-xs-12 col-sm-5 col-md-5 col-lg-3">
										<div class="row">
											<div class="col-xs-6 col-sm-12">
												<div id="size" class="panel panel-default">
													<div class="panel-body">
														<!--<h4>Укажите размеры двери:</h4>
														<div class="form-group">
															<div class="input-group">
																<div class="input-group-addon">Ширина:</div>
																<input type="text" class="form-control" id="width">
																<div class="input-group-addon">мм</div>
															</div>
															<div class="input-group">
																<div class="input-group-addon">Высота:</div>
																<input type="text" class="form-control" id="height">
																<div class="input-group-addon">мм</div>
															</div>
														</div>-->
													</div>
												</div>
											</div>
										<div class="col-xs-6 col-sm-12">
												<div id="painting" class="panel panel-default">
													<div class="panel-body" style="overflow:hidden;">
													<!--	<h4>Окраска:</h4>
														<label>Решетки:</label>
														<select id="grid" class="selectpicker color" data-size="5" data-container="body">
															<option data-subtext="marsala">Марсала</option>
															<option data-subtext="oliva">Оливковый</option>
														</select>
														<label>Дверного блока:</label>
														<select id="door-block" class="selectpicker color" data-size="5" data-container="body">
															<option data-subtext="oliva">Оливковый</option>
															<option data-subtext="marsala">Марсала</option>
														</select>-->
													</div>
												</div>
											</div>
											<div class="col-xs-12">
												<div id="security" class="panel panel-default">
													<div class="panel-body">
													<!--	<h4>Безопасность:</h4>
														<input type="checkbox" checked data-toggle="toggle" data-style="ios">
														<label>Датчик сигнализации</label>-->
													</div>
												</div>
											</div>
										</div>
									</div>
                                                        
                                                        
                                                        
                                                       
                                                        
                                                <div class="row row-rec col-xs-12 col-sm-7 col-md-7 col-lg-9">
	                                                
	                                        
	                                                
	                                                
	                                                
	                                                
	                                                
	                                                
	                                                
	                                                
                                          
                                                </div>
                                                
                                                       
                                            </div>
                                        </div>
                                        <hr class="separator">
                                        
                                        
                                        
                                        
                                        
                                        
                                        
                                        
                                        
                                        
                                        
                                        
                                        
                                        
                                        
                                        <!--<div class="panel panel-default">
                                            <div class="panel-body">
                                                <div class="row">
                                                    <div class="col-sm-12 col-md-12 col-lg-4">
                                                        <h4>Наличники и пороги:</h4>
                                                    </div>
                                                    <div class="col-sm-12 col-md-12 col-lg-4 col-margin">
                                                        <ul class="nav nav-pills nav-justified">
                                                            <li role="presentation" class="active">
                                                                <a href="#select-type" data-toggle="tab" class="dis">Типовой</a>
                                                            </li>
                                                            <li role="presentation">
                                                                <a href="#select-type" data-toggle="tab">Нестандарт</a>
                                                            </li>
                                                        </ul>
                                                    </div>
                                                    <div class="tab-content tab-select-type">
                                                        <div id="select-type" class="col-sm-12 col-md-12 col-lg-4 col-margin tab-pane active disabled">
                                                            <select class="selectpicker select-type" disabled data-size="5" data-container="body">
                                                                <option>Тип наличника</option>
                                                                <option>Параметр2</option>
                                                                <option>Параметр3</option>
                                                                <option>Параметр4</option>
                                                                <option>Параметр5</option>
                                                                <option>Параметр6</option>
                                                            </select>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="row">
                                                    <div class="col-md-12 col-lg-8">
                                                        <div class="row">
                                                            <div class="col-sm-6 col-md-6 col-lg-6 col-margin">
                                                                <label class="right-icon">Правый</label>
                                                                <select class="selectpicker" data-size="5" data-container="body">
                                                                    <option>Параметр1</option>
                                                                    <option>Параметр2</option>
                                                                    <option>Параметр3</option>
                                                                    <option>Параметр4</option>
                                                                    <option>Параметр5</option>
                                                                    <option>Параметр6</option>
                                                                </select>
                                                            </div>
                                                            <div class="col-sm-6 col-md-6 col-lg-6 col-margin">
                                                                <label class="top-icon">Верхний</label>
                                                                <select class="selectpicker" data-size="5" data-container="body">
                                                                    <option>Параметр1</option>
                                                                    <option>Параметр2</option>
                                                                    <option>Параметр3</option>
                                                                    <option>Параметр4</option>
                                                                    <option>Параметр5</option>
                                                                    <option>Параметр6</option>
                                                                </select>
                                                            </div>
                                                        </div>
                                                        <div class="row">
                                                            <div class="col-sm-6 col-md-6 col-lg-6 col-margin">
                                                                <label class="left-icon">Левый</label>
                                                                <select class="selectpicker" data-size="5" data-container="body">
                                                                    <option>Параметр1</option>
                                                                    <option>Параметр2</option>
                                                                    <option>Параметр3</option>
                                                                    <option>Параметр4</option>
                                                                    <option>Параметр5</option>
                                                                    <option>Параметр6</option>
                                                                </select>
                                                            </div>
                                                            <div class="col-sm-6 col-md-6 col-lg-6 col-margin">
                                                                <label class="bottom-icon">Порог</label>
                                                                <select class="selectpicker" data-size="5" data-container="body">
                                                                    <option>Параметр1</option>
                                                                    <option>Параметр2</option>
                                                                    <option>Параметр3</option>
                                                                    <option>Параметр4</option>
                                                                    <option>Параметр5</option>
                                                                    <option>Параметр6</option>
                                                                </select>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="col-md-12 col-lg-4">
                                                        <div class="row">
                                                            <div class="col-sm-6 col-md-6 col-lg-12 col-margin">
                                                                <label>Портал</label>
                                                                <input type="checkbox" class="portal" checked data-toggle="toggle" data-style="ios">
                                                                <input type="text" class="form-control portal" placeholder="Выберите">
                                                            </div>
                                                            <div class="col-sm-6 col-md-6 col-lg-12 col-margin">
                                                                <label>Сторона</label>
                                                                <input type="checkbox" class="side" data-toggle="toggle" data-style="ios">
                                                                <input type="text" class="form-control side disabl" placeholder="Выберите">
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>-->
                                        
                                        
                                        
                                        
                                        
                                    </div>
                                </div>
                            </form>
                        </div>
                        <div class="tab-pane" id="individual">
                            <div class="row">
                                <div class="panel panel-default">
                                    <div class="panel-body">
                                        <div class="cols-xs-12">
                                            Формирование индивидуальных комплектов временно недоступно
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div id="sidebar" class="col-sm-12 col-md-4 col-lg-3">
                    <ul class="nav nav-tabs">
                        <li role="presentation">
                            <a href="#cart"></a>
                        </li>
                    </ul>               
                    <div class="tab-content">
                            <div class="tab-pane active" id="result">
                                <h4>Результат расчета:</h4>
                                <div class="calculate" style="display: none;">
                                    <div id="pr1" class="preview">
                                        <span class="btn zoom" data-toggle="modal" data-target="#modal"></span>
                                        <img src="">
                                    </div>
                                    <div id="pr2"  class="preview">
                                        <span class="btn zoom" data-toggle="modal" data-target="#modal"></span>
                                        <img src="">
                                    </div>
                                    <span class="title">Дверь &laquo;<span></span>&raquo;</span>
                                    <span class="descr"></span>
                                    <span class="info ">Стоимость комплектации:</span>
                                    <button type="button" class="btn btn-default info" data-toggle="tooltip" data-placement="top" data-trigger="manual" title="Не следует, однако забывать, что сложившаяся структура организации представляет собой интересный эксперимент проверки соответствующий условий активизации. С другой стороны реализация намеченных плановых заданий в значительной степени обуславливает создание существенных финансовых и административных условий. Задача организации, в особенности же рамки и место обучения кадров обеспечивает широкому кругу (специалистов) участие в формировании новых предложений. "></button>
                                    <span class="price"></span>
                                    <div class="haracteristics">
                                    </div>
                                </div>
                                <button type="button" class="btn btn-default add-to-cart">В корзину</button>
                                <button type="button" class="btn btn-primary send">Отправить заказ</button>
                            </div>
                            <div class="tab-pane" id="cart">
                                <h4>Корзина:</h4>
                                <button type="button" class="btn btn-default add-to-cart">В корзину</button>
                                <button type="button" class="btn btn-primary send">Отправить заказ</button>
                            </div>
                    </div>
                </div>
            </div>
        </div>
        <!-- Modal -->
        <div class="modal fade" id="modal" tabindex="-1" role="dialog" aria-labelledby="Подробнее" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true"></button>
                    <img src="">
                    <span></span>
                </div>
            </div>
        </div><!-- End Modal -->
    <?php
//    $test = new DoorsFrontendclass();

?>
<?php get_footer();