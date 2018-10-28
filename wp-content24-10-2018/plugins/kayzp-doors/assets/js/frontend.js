jQuery(document).ready(function($){
 
    $('#collection .nav-pills li').on('click',function () {
        $('#collection .nav-pills li').removeClass('active');
        $(this).addClass('active');

        let type_series = $(this).parent().data('series');

        $.ajax({
            type: 'post',
            dataType: 'json',
            url: MyAjax.ajaxurl,
            data: {
                action: 'submit_series',
                type_series: type_series,
                id: $(this).data('id')
            },
            success: function(data) {
    //          let cur_model = data['cur_model'];
    //          if(!data['cur_model']){
    //                 cur_model = 'Модели отсутсвуют';
                // }
                $('#choose_models').html(data['html_select']);
                $('#choose_models').selectpicker('refresh');

                // $('#choose_models').next().find('.filter-option').text(cur_model);
                // $('#choose_models').next().find('.dropdown-menu.open ul li').remove();
                // $('#choose_models').next().find('.dropdown-menu.open ul').append(data['html']);
                $('#show_decoration, #filter_parametrs').hide();
                $('#doorselect').show();
                $('#result').parent().height($('#standart').parent().height());
                // $('#result').removeClass('active');
                // $('#cart').addClass('active');

            },
            error: function (jqXHR, textStatus, errorThrown) {
                alert('Error! Refresh the page and try again1.');
                console.log(jqXHR.responseText + '. ERRORS: ' + errorThrown);
            }
        });

    })
    $(document).on('change','#choose_models',function () {
        model_id = $('#choose_models').val();
        $.ajax({
            type: 'post',
            dataType: 'json',
            url: MyAjax.ajaxurl,
            data: {
                action: 'submit_model',
                model_id: model_id,
            },
            success: function(data) {
                $('.horizontal-tabs  .nav-tabs-horizontal .opati').remove();
                $('.horizontal-tabs .nav-tabs-horizontal').append(data);

                $('#show_decoration').show();
                $('#result').parent().height('370px');

            },
            error: function (jqXHR, textStatus, errorThrown) {
                alert('Error! Refresh the page and try again2.');
                console.log(jqXHR.responseText + '. ERRORS: ' + errorThrown);
            }
        });
    })
    $(document).on('click','#result button.send',function () {
        var htm = $('.haracteristics').html();
        htm = $('.calculate .price').text()+htm;
        htm = $('.calculate .title').text()+'<br>Цена: '+htm;
        console.log(htm);
        $.ajax({
            type: 'post',
            dataType: 'json',
            url: MyAjax.ajaxurl,
            data: {
                action: 'email_me',
                html: htm,
            },
            success: function(data) {
                console.log('data');
                alert('Заказ отправлен!')
            },
            error: function (jqXHR, textStatus, errorThrown) {
                alert('Error! Refresh the page and try again3.');
                console.log(jqXHR.responseText + '. ERRORS: ' + errorThrown);
            }
        });
    })
        $(document).on('click','#cart button.send',function () {

            var htm = '';
            $(this).siblings('.item').each(function(index, el) {
                var ht = $(this).find('.haracteristics').html();
                 console.log(ht);
                
               
                ht = '<br>Цена: ' + $(this).find('.price').text()   +ht;
                 console.log(ht);
                 ht = $(this).find('.title').text() + ht;
                  console.log(ht);
                htm += ht + '<br><br>';
            });
        // var htm = $('.haracteristics').html();
        // var htm = $('.haracteristics').html();
        // htm = $('.calculate .price').text()+htm;
        // htm = $('.calculate .title').text()+'<br>Цена: '+htm;
        console.log(htm);
        $.ajax({
            type: 'post',
            dataType: 'json',
            url: MyAjax.ajaxurl,
            data: {
                action: 'email_me',
                html: htm,
            },
            success: function(data) {
                console.log('data');
                alert('Заказ отправлен!')
            },
            error: function (jqXHR, textStatus, errorThrown) {
                alert('Error! Refresh the page and try again4.');
                console.log(jqXHR.responseText + '. ERRORS: ' + errorThrown);
            }
        });
    })

    $('.kayzp_search_field').on('input', function(){
        $('#kayzp_search, #kayzp_search li').hide();
        if ($(this).val() != '') {
            $('#kayzp_search li').each(function(){
				var textis = $(this).text().toLowerCase();
				var textin = $('.kayzp_search_field').val().toLowerCase();
                if (textis.indexOf(textin) > -1) {
                    $('#kayzp_search').show();
                    $(this).show();
                }
            })
        }
    })

    $('#kayzp_search li').on('click', function(){
        $('.kayzp_search_field').val($(this).text());
        $('.kayzp_search_field').trigger('input');
        $('.kayzp_search_field+button').attr('data-seria', $(this).data('series-id'));
        $('.kayzp_search_field+button').attr('data-model', $(this).data('id'));
		$('.kayzp_search_field+button').trigger('click');
    })

    $('.kayzp_search_field+button').on('click', function(e){
        e.preventDefault();

        if ($('.kayzp_search_field').val() != '') {
			 var ser = $('#kayzp_search li[style*="display: list-item"]').data('series-id');
			var mod = $('#kayzp_search li[style*="display: list-item"]').data('id');
			$('.kayzp_search_field+button').attr('data-seria', ser);
        $('.kayzp_search_field+button').attr('data-model', mod);
           
			$('#kayzp_search, #kayzp_search li').hide();
            $('ul.nav.nav-pills li[data-id='+ser+']').trigger('click');
			
			
            setTimeout(function(){
				//$('ul.nav.nav-pills li.'+$(this).data('series-id')).trigger('click');
                $('#choose_models').val(mod).trigger('change');
            }, 3000)
			$('#kayzp_search, #kayzp_search li').hide();
			$('#sidebar .calculate').hide();
			
				$('.kayzp_search_field').attr('value', ''); 
 
        }

    })


    $(document).on('change', '#filter_parametrs input[type=text]', function(){
        if ($('.haracteristics .item[data-id='+$(this).attr('name')+']').length > 0) {
            $('.haracteristics .item[data-id='+$(this).attr('name')+'] span').text($(this).val());
        }
        else{
            $('.haracteristics').append('<div class="item" data-id="'+$(this).attr('name')+'"><label>'+$(this).parent().find('.input-group-addon').text()+'</label><span>'+$(this).val()+'</span></div>');
        }
    })


    $(document).on('change', '#filter_parametrs input[type=checkbox]', function(){
        if ($('.haracteristics .item[data-id='+$(this).attr('name')+']').length > 0) {
            if ($(this).prop('checked')) {
                $('.haracteristics .item[data-id='+$(this).attr('name')+'] span').text("Да");
            }
            else{
                $('.haracteristics .item[data-id='+$(this).attr('name')+']').remove();
				$('.calculate .price').text(parseInt($('.calculate .price').text())- parseInt($(this).data('price')) );
            }
        }
        else{
            if ($(this).prop('checked')) {
                $('.haracteristics').append('<div class="item" data-id="'+$(this).attr('name')+'"><label>'+$(this).parent().parent().find('label').text()+'</label><span>Да</span></div>');
				$('.calculate .price').text(parseInt($('.calculate .price').text())+ parseInt($(this).data('price')) );
            }
        }
    })
    $(document).on('change', '#filter_parametrs .selectpicker', function(){
        
        $('.haracteristics .item.s').remove();
        $('.calculate .price').text($('.calculate .price').attr('data-prev-price'));
        $('#filter_parametrs .selectpicker').each(function(){
			var zn = $(this).val();
            if ($(this).val() != 'Выберите значение' && $(this).val() != '') {
                if ($('.haracteristics .item[data-id='+$(this).attr('name')+']').length != 0) {
                    $('.haracteristics').append('<div class="s item" data-id="'+$(this).attr('name')+'"><label>'+$(this).prev().text()+'</label><span>'+$(this).val()+'</span></div>');
                }
                else{

	var dval = $(this).val();
	var city_slug = $(this).find('option:selected').data('city')
	
	if(city_slug == 'price_minsk' || city_slug == 'price_regions'){
		$('.'+city_slug).show();
		$('.prep').hide();
		if(city_slug == 'price_minsk') $('.price_regions').hide();
		if(city_slug == 'price_regions') $('.price_minsk').hide();
		
	}
	
	
	
var colornum = dval.lastIndexOf("#");
var back = '';
if(colornum == 0){
	var substring = dval.split("/");
	back = 'style="background:'+substring[0]+'"';
	var sm = '<small '+back+' class="muted text-muted"></small>';
	var vall = substring[1];
	$(this).next().find('small').remove();
	$(this).next().find('.filter-option').after(sm);
}else{
	var vall = dval;
}	
					$('.haracteristics').append('<div class="s item" data-id="'+$(this).attr('name')+'"><label>'+$(this).prev().text()+'</label><span>'+vall+'</span></div>');
                    //$('.haracteristics .item[data-id='+$(this).attr('name')+'] span').text($(this).val());
                }
				var cat = $(this).find('option:selected').data('cat');
				if(vall !== 'За городом' && cat !== 'Поднятие на этаж'){
					if ($(this).find('option:selected').data('price')) {
						$('.calculate .price').text(parseInt($('.calculate .price').text())+ parseInt($(this).find('option:selected').data('price')) );
					}
				}else{
					var kilometer = $('#kilometer').val();
					if(vall == 'За городом' && $('#kilometer').val() != 'Выберите значение'){
						var kfn = $('#kilometer').find('option:selected').data('km');
						var pr = $(this).find('option:selected').data('price')*kfn;
						$('.calculate .price').text(parseInt($('.calculate .price').text())+ pr );
					}
					if($(this).find('option:selected').data('cat') == 'Поднятие на этаж' && $('#level').val() != 'Выберите значение'){
						var kfn = $('#level').find('option:selected').val();
						var pr = $(this).find('option:selected').data('price')*kfn;
						$('.calculate .price').text(parseInt($('.calculate .price').text())+ pr );
					}
				}
							
            }
        })
		if ($('#filter_parametrs .eye').is(':checked')) {
			$('.calculate .price').text(parseInt($('.calculate .price').text())+ parseInt($('#filter_parametrs .eye').data('price')) );
		}
    })


	
    $(document).on('click', '.nav-tabs-horizontal a', function(e){
        e.preventDefault();
        e.stopPropagation();
		
$(".btn-group.bootstrap-select.color").remove()
        var model_id = $(this).parents('div').data('model_id'),
            decoration_id = $(this).parents('div').data('id');
			$('.nav-tabs-horizontal').find('a').fadeTo(0, 0.25);
			$(this).parent('div').parent('div').find('a').fadeTo(0, 1);
			$('.opati').attr('status','')
			$(this).parent('div').parent('div').attr('status','clicked');
        $.ajax({
            type: 'post',
            dataType: 'json',
            url: MyAjax.ajaxurl,
            data: {
                action: 'submit_decoration',
                model_id: model_id,
                decoration_id: decoration_id
            },
            success: function(data) {
                console.log(data);
                $('#filter_parametrs>.row, #filter_parametrs').show()
                $('#filter_parametrs .panel.panel-default .panel-body>.row').html('');
                $('#size .panel-body').html('');
                $('#painting .panel-body').html('');
                $('#security .panel-body').html('');
				if (typeof data.fields_html != "undefined") {
					for (var i = 0; i < data.fields_html.length; i++) {
						$('#filter_parametrs .panel.panel-default .panel-body>.row').append(data.fields_html[i])
					}
				}
				if (typeof data.fields_blue != "undefined") {
					for (var i = 0; i < data.fields_blue.length; i++) {
						$('#size .panel-body').append(data.fields_blue[i])
					}
				}
				if (typeof data.fields_green != "undefined") {
					for (var i = 0; i < data.fields_green.length; i++) {
						$('#painting .panel-body').append(data.fields_green[i])
					}
				}
				if (typeof data.fields_pink != "undefined") {
					for (var i = 0; i < data.fields_pink.length; i++) {
						$('#security .panel-body').append(data.fields_pink[i])
					}
				}
                $('#filter_parametrs .selectpicker').selectpicker('render');
                
/* 				$('li a span.text').each(function(){
					
					var nameval = $(this).val();
					var nameattr = $(this).data('bacol');
					if($(this).data('bacol')!=''){
						$(this).append('<small style="background:'+nameattr+'" class="muted text-muted">');
					}
				}); */
				
				

                $('#filter_parametrs input[type=checkbox]').each(function (i) {
                    $(this).bootstrapToggle({
                        on: 'Enabled',
                        off: 'Disabled'
                    });
                })
                $('.calculate .title span').text(data.dec_name);
                $('.calculate  #pr1  img').attr('src', data.image);
                $('.calculate #pr2 img').attr('src', data.back_image);
                $('.calculate .price').text(data.dec_price);
                $('.calculate .price').attr('data-prev-price', data.dec_price);
                $('.calculate').css('display', 'block');
                $('.haracteristics').html('<h5>Характеристики:</h5>');
                $('.haracteristics').append('<div class="item"><label>Cерия:</label><span>'+$('#collection ul li.active').text()+'</span></div>');
                $('.haracteristics').append('<div class="item"><label>Отделка:</label><span>'+data.dec_name+'</span></div>');
var i = 0;
                $('#filter_parametrs .selectpicker').each(function(){

                    if ($(this).val() != 'Выберите значение' && $(this).val() != '') {

	var dval = $(this).val();
var colornum = dval.lastIndexOf("#");
var back = '';
if(colornum == 0){
	var substring = dval.split("/");
	back = 'style="background:'+substring[0]+'"';
	var sm = '<small '+back+' class="muted text-muted"></small>';
	var vall = substring[1];
	$(this).next().find('.filter-option small').remove();
	$(this).next().find('.filter-option').after(sm);
}else{
	var vall = $(this).val();
}	
                        $('.haracteristics').append('<div class="item s" data-id="'+$(this).attr('name')+'"><label>'+$(this).prev().text()+'</label><span>'+vall+'</span></div>');
						i++;
						if ($(this).find('option:selected').data('price')) {
							$('.calculate .price').text(parseInt($('.calculate .price').text())+ parseInt($(this).find('option:selected').data('price')) );
						}
                    }
                })

                $('#result').parent().height($('#standart').parent().height());

            },
            error: function (jqXHR, textStatus, errorThrown) {
                alert('Error! Refresh the page and try again5.');
                console.log(jqXHR.responseText + '. ERRORS: ' + errorThrown);
            }
        });
		
		$('.opati').unbind("mouseleave");
    })



    $(document).on('click','.zoom',function (e) {
        e.preventDefault();
        $('.modal-content').find('img').attr('src',$(this).parent().find('img').attr('src'));
        $('.modal-content').find('span').text($(this).parent().find('.title').text());
    });

  
/* $('.selectpicker').selectpicker({
	showSubtext: 'True',									//выводим подписи для пунктов списка
	size: 5
}); */

$('.nav-tabs-horizontal').on({
 mouseenter: function () {

	$(this).find('a').fadeTo(0, 1);
	/* $(this).children('div .zoom').css('display', 'block'); */
	
}
}, '.opati'); 
 $('.nav-tabs-horizontal').on({
	  
	 mouseleave: function () {
		if($(this).attr('status') != 'clicked'){
		$(this).find('a').fadeTo(0, 0.25);
		/* $('div .btn.zoom').css('display', 'none'); */
			
		}
	}
}, '.opati'); 
});
	
