$('#tabs a, #sidebar .nav-tabs a').click(function (e) {
	e.preventDefault();
	$(this).tab('show');									//Переключение между вкладками
});

$('#tabs a').click(function (e) {
	if ($('#tabs li:nth-child(1)').attr('class') == "active") check_active_door();
	else $('#js_image_selection li a').tooltip('hide');
});

/* $('.selectpicker').selectpicker({
	showSubtext: 'True',									//выводим подписи для пунктов списка
	size: 5
}); */

$('#js_image_selection').horizontalTabs();					//активируем вкладки дверей

// $('#js_image_selection li').hover(function() {
// 	if (($(this).offset().left >= $('#js_image_selection').offset().left) && (($(this).offset().left + $(this).width()) <= ($('#js_image_selection').offset().left) + $('#js_image_selection').width()+1))
// 		if ($(this).attr('class') != 'active')
// 			$(this).find('a').tooltip('show');
// }, function() {
// 	if ($(this).attr('class') != 'active')
// 		$(this).find('a').tooltip('hide');
// });
// $('#js_image_selection li a').click(function() {
// 	setTimeout(calculate, 100);
// 	$('#js_image_selection li.active a').tooltip('hide');
// 	setTimeout(check_active_door, 200);
// });
// $('#js_image_selection .scroller').click(function() {
// 	$('#js_image_selection li a').tooltip('hide');
// 	setTimeout(function() {check_active_door();}, 200);
// });
// function check_active_door() {
// 	console.clear();
// 	// console.log($('#js_image_selection li.active').offset().left);
// 	// console.log($('#js_image_selection').offset().left);
// 	// console.log(($('#js_image_selection li.active').offset().left + $('#js_image_selection li.active').width()));
// 	// console.log($('#js_image_selection').offset().left + $('#js_image_selection').width());
// 	// console.log($('#js_image_selection li.active').offset().left >= $('#js_image_selection').offset().left);
// 	// console.log(($('#js_image_selection li.active').offset().left + $('#js_image_selection li.active').width()) <= ($('#js_image_selection').offset().left + $('#js_image_selection').width())+1);
// 	$('#js_image_selection li').each(function() {
// 		if ($(this).attr('class') == "active")
// 			if (($(this).offset().left >= $('#js_image_selection').offset().left) && (($(this).offset().left + $(this).width()) <= ($('#js_image_selection').offset().left) + $('#js_image_selection').width()+1)) $(this).find('a').tooltip('show');
// 		else $(this).find('a').tooltip('hide');
// 	});
// }
// /******************************************/
// $('button.info').click(function() {
// 	$(this).tooltip('toggle');								//выводим подскузку при клике на кнопку стоимости комплектации
// 	$('.tooltip').addClass('info');							//добавляем класс .info для добавления стилей
// });
//
var $cart_count = 0;																												//объявляем переменную для подсчета товаров в корзине
$(document).ready(function() {
	$('#painting #grid + div button span:first-child').addClass($('#painting #grid + div li.selected small').text());				//добавляем класс выбраннной окраски для иконки кнопки
	var i = 1;																														//счетчик списка решетки
	$('#painting #grid + div li').each(function() {
		$(this).addClass($('#painting #grid + div li:nth-child(' + i + ') small').text());											//добавляем класс элементу списка из его подписи для вывода иконки окраски
		$('#painting #grid + div li:nth-child(' + i + ') small').text("");															//очищаем текст подписи
		i++;
	});
	$('#painting #door-block + div button span:first-child').addClass($('#painting #door-block + div li.selected small').text());	//добавляем класс выбраннной окраски для иконки кнопки
	i = 1;																															//счетчик списка дверного блока
	$('#painting #door-block + div li').each(function() {
		$(this).addClass($('#painting #door-block + div li:nth-child(' + i + ') small').text());									//добавляем класс элементу списка из его подписи для вывода иконки окраски
		$('#painting #door-block + div li:nth-child(' + i + ') small').text("");;													//очищаем текст подписи
		i++;
	});

	if ($('input[type="checkbox"].eye').attr('checked')) $('input[type="text"].eye').removeClass('disabled');						/*******************************/
	else $('input[type="text"].eye').addClass('disabled');																			/*							   */
	if ($('input[type="checkbox"].portal').attr('checked')) $('input[type="text"].portal').removeClass('disabled');					/*	проверяем переключатели и  */
	else $('input[type="text"].portal').addClass('disabled');																		/*	включаем/отключаем кнопки  */
	if ($('input[type="checkbox"].side').attr('checked')) $('input[type="text"].side').removeClass('disabled');						/*							   */
	else $('input[type="text"].side').addClass('disabled');																			/*******************************/

	$('#sidebar .nav-tabs a').html("Показать корзину: <span class=\"badge\">" + $cart_count + "</span>");							//выставляем количество товаров в корзине
});
//here
$('#painting #grid + div li').click(function() {
	$('#painting #grid + div button span:first-child').attr('class','filter-option pull-left');				//выставляем родные классы кнопки селекта
});
$('#painting #grid + div button span:first-child').bind("DOMSubtreeModified",function(){
	$(this).addClass($('#painting #grid + div button span:first-child small').text());						//добавляем класс выбранной окраски для иконки кнопки
});
$('#painting #door-block + div li').click(function() {
	$('#painting #door-block + div button span:first-child').attr('class','filter-option pull-left');		//выставляем родные классы кнопки селекта
})
$('#painting #door-block + div button span:first-child').bind("DOMSubtreeModified",function(){
    $(this).addClass($('#painting #door-block + div button span:first-child small').text());				//добавляем класс выбранной окраски для иконки кнопки
});
//
$(window).on('load resize', function() {
	if (($(this).width() < 768)&&($(this).width() > 579)) $('#size').height($('#painting').height());		//делаем панели одинаковой высоты при указанной ширине окна
	$('#sidebar .tab-content').height($('#content .tab-content').height());									//делаем панель результатов расчета одинаковый высоты с блоком параметров
});

$('#js_image_selection .zoom').click(function() {
	$('#modal img').attr('src', $(this).siblings('a').children('img').attr('src'));							//передаем ссылку выбранного изображения в popup
	$('#modal span').text($(this).siblings('span').text());													//передаем название выбранной двери в popup
});

$('.preview .zoom').click(function() {
	$('#modal img').attr('src', $('#result img').attr('src'));												//передаем ссылку выбранного изображения в popup
	$('#modal span').text($('#result .title span').text());													//передаем название выбранной двери в popup
});
//
$('.nav-justified a').click(function() {
	if ($(this).attr('class') == 'dis') {																	//действия при клике на вкладку типового наличника
		$('#select-type, #select-type *').addClass('disabled');												//добавляем всем элементам класс disabled
		$('#select-type select').attr('disabled','disabled');												//делаем селект неактивным
		$('.select-type li').removeClass('selected');														/*	убираем класс selected у всех элементов списка	*/
		$('.select-type li:nth-child(1)').addClass('selected');												/*	и добавляем его первому элементу				*/
		$('#select-type button span.filter-option').text($('.select-type li.selected').text());				//передаем текст первого элемента списка в кнопку
	}
	else {																									//действия при клике на вкладку нестандартного наличника
		$('#select-type, #select-type *').removeClass('disabled');											//убираем класс disabled у всех элементов
		$('#select-type select').removeAttr('disabled');													//делаем активным список выбора
	}
});

$('input[data-style="ios"]').change(function() {
	if ($(this).prop('checked') == true) $('input[type="text"].'+ $(this).attr('class')).removeClass('disabled');
	else $('input[type="text"].'+ $(this).attr('class')).addClass('disabled');
});
/******************************************/
$(document).ready(function() {
	calculate();
//setTimeout(check_active_door(), 100);
	$('#js_image_selection li').each(function() {
		$(this).find('a').attr('data-original-title', $(this).find('span.title').text());
	});
});
// /****************************************/
$('#sidebar .nav-tabs a').click(function() {
	if ($(this).attr('href') == '#result') {
		$(this).attr('href','#cart');
		$(this).html("Показать корзину <span class=\"badge\">" + $cart_count + "</span>");
		$('.send').html("Отправить заказ");
	} else {
		$(this).attr('href','#result');
		$(this).html('Результаты расчета');
		$('.send').html("Отправить заказ <span class=\"badge\">(" + $cart_count + ")</span>");
		if ($cart_count == 0) $('#cart > h4').text("Корзина пуста");
		else $('#cart > h4').text("Корзина:");
	}
	$(this).parent('li').removeClass('active');
});
/******************************************/
function calculate() {
	$('#result .preview img').attr('src', $('#js_image_selection li.active a img').attr('src'));
	$('#result .title span').text($('#js_image_selection li.active .title').text());
	$('#result .descr').text('Нажав на кнопку «Написать реферат», вы лично создаете уникальный текст, авторские права на реферат принадлежат только вам.');
	$('#result .price').text('890');
}
/******************************************/
$('.add-to-cart').click(function() {
	$cart_count++;
	$('#sidebar .nav-tabs a').html("Показать корзину: <span class=\"badge\">" + $cart_count + "</span>");
	$('#cart').append("<div class=\"item item-" + $cart_count + " panel panel-default\"><div class=\"panel-body\">");
	$('#cart .item-' + $cart_count + ' .panel-body').append($('#result .calculate').html());
	$('#cart .item-' + $cart_count + ' .panel-body').append("<button type=\"button\" class=\"close\" onclick=\"remove_item($(this).parent('div'));\"></button>");
	$('#cart .item-' + $cart_count + ' .panel-body').append("<button type=\"button\" class=\"show-panel\" onclick=\"open_panel($(this));\"></button>");
});

function remove_item(current_item) {
	$cart_count--;
	current_item.parent('div.item').remove();
	$('.send').html("Отправить заказ <span class=\"badge\">(" + $cart_count + ")</span>");
	if ($cart_count == 0) $('#cart > h4').text("Корзина пуста");
}

function open_panel(current_item) {
	var el = current_item.parent('div'), curHeight = el.height(), autoHeight = el.css('height', 'auto').height()+20;
	el.height(curHeight).animate({height: autoHeight}, 250);
	el.find('.show-panel').css('transform','rotate(180deg)');
	current_item.attr('onclick','hide_panel($(this));');
}

function hide_panel(current_item) {
	var el = current_item.parent('div'), curHeight = el.height(), setHeight = el.css('height', '215px').height()+20;
	el.height(curHeight).animate({height: setHeight}, 250);
	el.find('.show-panel').css('transform','none');
	current_item.attr('onclick','open_panel($(this));');
}