jQuery(document).ready(function($){
 var rem = [];
 var crem = [];

    $('#collection .nav-pills li').on('click',function () {
        $('#collection .nav-pills li').removeClass('active');
        $(this).addClass('active');

        let type_series = $(this).parent().attr('data-series');

        $.ajax({
            type: 'post',
            dataType: 'json',
            url: MyAjax.ajaxurl,
            data: {
                action: 'submit_series',
                type_series: type_series,
                id: $(this).attr('data-id')
            },
            success: function(data) {
                $('.serdiv').remove();
                $('#collection').append(data['series_html']);
                $('#choose_models').html(data['html_select']);
                $('#choose_models').selectpicker('refresh');

                $('#show_decoration, #filter_parametrs').hide();
                $('#doorselect').show();
                $('#result').parent().height($('#standart').parent().height());

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
        var htmh = $('.haracteristics').html(),
        htmp = $('.calculate .price').text()+htmh,
        htm = $('.calculate .title').text()+'<br>Цена: '+htmp,
		texts = '';
        console.log(htm);
		var htmh = $('.haracteristics').find('.item').each(function(index, el) {
			var name = $(this).find('label').text(),
			nametr = translit(name),
			value = $(this).find('span').text();
			texts = texts+"'"+nametr+"' => $request->"+value+";";
		});
		texts = texts.slice(0, -1)

		var arrtexts = texts.split(';');
		var arrtextsJSON = JSON.stringify(arrtexts);
		console.log(arrtextsJSON);
		$.ajax({
            type: 'post',
            dataType: 'json',
            url: 'https://steeline-vds.ru/SENDCALC/handler.php',
            data: {
                name: $('.calculate .title').text(),
                description: htm,
				property_values: arrtextsJSON
            },
            success: function(data) {
                console.log('data');
                alert('Заказ на сайт отправлен отправлен!')
            },
            error: function (jqXHR, textStatus, errorThrown) {
                alert('Error! При отправке на сайт https://steeline-vds.ru/SENDCALC/handler.php возникла ошибка.');
                console.log(jqXHR.responseText + '. ERRORS: ' + errorThrown);
            }
        });
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
        $('.kayzp_search_field+button').attr('data-seria', $(this).attr('data-series-id'));
        $('.kayzp_search_field+button').attr('data-model', $(this).attr('data-id'));
		$('.kayzp_search_field+button').trigger('click');
    })

    $('.kayzp_search_field+button').on('click', function(e){
        e.preventDefault();

        if ($('.kayzp_search_field').val() != '') {
			 var ser = $('#kayzp_search li[style*="display: list-item"]').attr('data-series-id');
			var mod = $('#kayzp_search li[style*="display: list-item"]').attr('data-id');
			$('.kayzp_search_field+button').attr('data-seria', ser);
        $('.kayzp_search_field+button').attr('data-model', mod);
           
			$('#kayzp_search, #kayzp_search li').hide();
            $('ul.nav.nav-pills li[data-id='+ser+']').trigger('click');
			
			
            setTimeout(function(){
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
		var opt = $(this).parent().find('.input-group-addon').text().slice(0, -1);
		if(opt == 'Ширина' || opt == 'Высота' || opt == 'Площадь'){
			
			Square();
			
			SizeOption();
			
			Haracteristics();
			
		}
    })


    $(document).on('change', '#filter_parametrs input[type=checkbox]', function(){
        if ($('.haracteristics .item[data-id='+$(this).attr('name')+']').length > 0) {
            if ($(this).prop('checked')) {
                $('.haracteristics .item[data-id='+$(this).attr('name')+'] span').text("Да");
            }
            else{
                $('.haracteristics .item[data-id='+$(this).attr('name')+']').remove();
				$('.calculate .price').text(parseInt($('.calculate .price').text())- parseInt($(this).attr('data-price')) );
            }
        }
        else{
            if ($(this).prop('checked')) {
                $('.haracteristics').append('<div class="item" data-id="'+$(this).attr('name')+'"><label>'+$(this).parent().parent().find('label').text()+'</label><span>Да</span></div>');
				$('.calculate .price').text(parseInt($('.calculate .price').text())+ parseInt($(this).attr('data-price')) );
            }
        }
		var blocked = $(this).attr('data-blocked');
		Blocked($(this));
    })
    
	
	$(document).on('change', '#filter_parametrs .selectpicker', function(){

	var blocked = $(this).find('option:selected').attr('data-blocked');

		Blocked($(this),blocked);

	
	var	prev = $(this).attr('data-prev');
	if(prev != '' && !!prev){
		//если data-prev в select есть, то обнуляем по ее данным 	
		$(this).find('option').each(function(){
			if(prev == $(this).val()){
				coefficient = $(this).attr('data-coefficient');
				coefficient_data = $(this).attr('data-coefficient_data');
				Coefficient(coefficient,coefficient_data,prev);
			}
		});
	}	
	
	var coefficient = $(this).find('option:selected').attr('data-coefficient'),
		coefficient_data = $(this).find('option:selected').attr('data-coefficient_data'),
	    prev_new = $(this).find('option:selected').val();
		
	$(this).attr('data-prev',prev_new);
	
	Coefficient(coefficient,coefficient_data);

	Haracteristics();
        
    })


	
    $(document).on('click', '.nav-tabs-horizontal a', function(e){
        e.preventDefault();
        e.stopPropagation();
		
		$('.calculate .price').attr('data-prev-price','');
		$('.calculate .price').attr('data-size-coefficient','');
		$('.calculate .price').attr('data-params-coefficient','');
		$(".btn-group.bootstrap-select.color").remove()
        var model_id = $(this).parents('div').attr('data-model_id'),
            decoration_id = $(this).parents('div').attr('data-id');
			
			$('#filter_parametrs').attr('decor_id',decoration_id);
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
						$('.bl').addClass("col-xs-12 col-sm-5 col-md-5 col-lg-3")
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
				
				
			
				var series_coeff = data.series_coeff;
				
                $('#filter_parametrs .selectpicker').selectpicker('render');

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
                $('.calculate .price').attr('data-orig-price', data.dec_price);
                $('.calculate .price').attr('data-series-coeff', series_coeff);
                $('.calculate').css('display', 'block');
                $('.haracteristics').html('<h5>Характеристики:</h5>');
                $('.haracteristics').append('<div class="item"><label>Cерия:</label><span>'+$('#collection ul li.active').text()+'</span></div>');
                $('.haracteristics').append('<div class="item"><label>Отделка:</label><span>'+data.dec_name+'</span></div>');
				
				Square();
				
				SizeOption();
				
				
				Haracteristics();
				/* var i = 0;
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
						
						if ($(this).find('option:selected').attr('data-price')) {
							$('.calculate .price').text(parseInt($('.calculate .price').text())+ parseInt($(this).find('option:selected').attr('data-price')) );
						}
                    }
                }) */

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


	function Blocked(th,blocked){
		var nm = $(this).attr('name');
	if(blocked != '' && !!blocked){
		var blockeds = blocked.toString().split(',');
		$.each(blockeds,function(index,value){
		  var id_block = value.toString();
		  var parent_id = id_block;//$('#'+id_block).parents('div').attr('id').toString();
		  var block_html = $('#'+id_block)[0].outerHTML;
		   
		  if(!!rem[nm]) {
			  if(rem[nm].has(parent_id)){
					block_html = rem[nm].get(parent_id)+block_html;
			  }	 
			  rem[nm].set( parent_id, block_html);
		  }else{
			rem[nm] = new Map([
			  [ parent_id, block_html]
			]);
		  }
		  if($("[name='field-"+id_block+"']")[0].tagName == "SELECT"){
			  $("select[name='field-"+id_block+"']").eq(0).prop('selected',true);
			  $("select[name='field-"+id_block+"']").val('Выберите значение');
			  $("select[name='field-"+id_block+"']").next('div').css('display', 'none');
			  $("select[name='field-"+id_block+"']").after('<div id="555" class="btn-group bootstrap-select" >    <button type="button" class="btn dropdown-toggle selectpicker btn-default" data-toggle="dropdown" aria-expanded="false">        <span class="filter-option pull-left">Блокирован</span>&nbsp;        <span class="caret"></span>    </button>    </div>');
		  }
		  $("input[name='field-"+id_block+"']").val('');
		  $('.haracteristics .item[data-id="field-'+id_block+'"]').remove();
		  if ($("input[name='field-"+id_block+"']").is(':checked')){
			$("input[name='field-"+id_block+"']").prop('checked',false);
			$("input[name='field-"+id_block+"']").trigger('click');
		  }
		  $('#'+id_block).fadeTo(500, 0.3);
		  $("input[name='field-"+id_block+"']").attr('disabled', true);
		});
	}else{
		if(!!rem[nm]) {
			rem[nm].forEach(function(value,index){
			  var block_html = value.toString();
			  var parent_id = index.toString();
			  //$('#'+parent_id).prepend(block_html);
			  $("input[name='field-"+parent_id+"']").attr('disabled', false);
			  $('#'+parent_id).fadeTo(500, 1);
			  $("select[name='field-"+parent_id+"']").next('div').remove();
			  $("select[name='field-"+parent_id+"']").next('div').css('display', 'block');
			  $("select[name='field-"+parent_id+"']").next('div').find('span:first').html('Выберите значение');
			  $("select[name='field-"+parent_id+"']").next('div').find('small').css('display', 'none')
			 
			  rem[nm].delete(parent_id);
			});
		}
	}
	}

	
	function Coefficient(coefficient,coefficient_data,prev=''){
		
		if(coefficient != '' && !!coefficient){
			
			var coefficient_arr = coefficient.split(';');
			var coefficient_data_arr = coefficient_data.split(';');
			
			var array = coefficient_arr.map( function (obj, index) {
				 var coeff = coefficient_data_arr[index];
				 var params = obj.split(',');
				 $.each(params,function(key,val) {
					if($("[name='field-"+val+"']")[0].tagName == "SELECT"){
						$.each($("select[name='field-"+val+"'] option"),function(index,value) {
							if(!!value.dataset['price']){
								var val_price = value.dataset['price'];
								//если ранее были применены коэф, то вычитаем их
								if(prev =='') var vval = parseInt(value.dataset['price'])*coeff; else var vval = parseInt(value.dataset['price'])/coeff;
								$("select[name='field-"+val+"'] option[data-price='"+val_price+"']").attr('data-price',vval);
							} 
							var v= value;
						});
					}
					if($("[name='field-"+val+"']")[0].tagName == "INPUT"){
						if(prev =='') var vval = parseInt($("[name='field-"+val+"']").attr('data-price'))*coeff; else var vval = parseInt($("[name='field-"+val+"']").attr('data-price'))/coeff;
						$("[name='field-"+val+"']").attr('data-price',vval);
					}
				});
			});
		}else{
			
		}
	}
	
	function Square(){
		var width_val ='';
		var height_val ='';
		$('#filter_parametrs input[type=text]').each(function (i) {
			if($(this).parent('div').children('.input-group-addon').text()=='Ширина:') width_val = $(this).val();
			if($(this).parent('div').children('.input-group-addon').text()=='Высота:') {
				height_val = $(this).val();
				height_id = $(this).parent('div').attr('id');
			}
			if(!!width_val && !!height_val && width_val != '' && height_val != '') {
				var square_val = width_val*height_val;
				var square = '<div id="300" class="bl input-group "><div class="input-group-addon">Площадь:</div> <input type="text" name="field-300" class="form-control" id="Площадь" value="'+square_val+'" />  </div>';
				$('#'+height_id).next('#300').remove()
				$('#'+height_id).after(square);
				width_val ='';
				height_val ='';
			}
			
		})
	}
	
	function CoefficientSize(coefficient, params, prev=''){
		//коэффициент параметров
		$.each(params,function(key,val) {
			if($("[name='field-"+val+"']")[0].tagName == "SELECT"){
				$.each($("select[name='field-"+val+"'] option"),function(index,value) {
					if(!!value.dataset['price']){
						var val_price = value.dataset['price'];
						if(prev =='') 
							var vval = parseInt(value.dataset['price'])*coefficient; 
						else 
							var vval = parseInt(value.dataset['price'])/coefficient;
						$(this).attr('data-price',vval);
					} 
					var v= value;
				});
			}
			if($("[name='field-"+val+"']")[0].tagName == "INPUT"){
				if(prev =='') 
					var vval = parseInt($("[name='field-"+val+"']").attr('data-price'))*coefficient; 
				else 
					var vval = parseInt($("[name='field-"+val+"']").attr('data-price'))/coefficient;
				$("[name='field-"+val+"']").attr('data-price',vval);
			}
		});
	}
	
	
	
	function SizeOption(){
		var opt_name = $('input[name=opt_name]').val();
		
		if(!!opt_name){
			var opt_size = $('input[id='+opt_name+']').val();
			if(!!opt_size){
			
				var decor_id = $('#filter_parametrs').attr('decor_id');
				//ищем нову цену в таблице wp_doors_base
				$.ajax({
					type: 'post',
					dataType: 'json',
					url: MyAjax.ajaxurl,
					data: {
						action: 'new_base_price',
						opt: opt_name,
						opt_size: opt_size,
						decor_id: decor_id
					},
					success: function(data) {
					  //var json = $.parseJSON(data);
					  if(!!data[0]){
						var price = data[0].price,
							params = $.parseJSON(data[0].params),
							params_text = params.join(';'),
							coefficient = data[0].coefficient;
							//Вычитаем из цены базовую цену
							$('.calculate .price').text(parseInt($('.calculate .price').text())- parseInt($('.calculate .price').attr('data-prev-price')) );
							if(!!$('.calculate .price').attr('data-size-coefficient')){
							var coefficient_old = $('.calculate .price').attr('data-size-coefficient'),
								params_old = $('.calculate .price').attr('data-params-coefficient').split(';'),
								prev_old = $('.calculate .price').attr('data-prev-price');
								CoefficientSize(coefficient_old,params_old,prev_old);
							}
							//прибавляем новую цену
							$('.calculate .price').text(parseInt($('.calculate .price').text())+ parseInt(price) );
							$('.calculate .price').attr('data-prev-price',price);
							$('.calculate .price').attr('data-size-coefficient',coefficient);
							$('.calculate .price').attr('data-params-coefficient',params_text);
							
							CoefficientSize(coefficient,params);
							
					  }else{
						  var price = $('.calculate .price').attr('data-orig-price');
						  $('.calculate .price').text(parseInt($('.calculate .price').text())- parseInt($('.calculate .price').attr('data-orig-price')) );
						  if(!!$('.calculate .price').attr('data-size-coefficient')){
							var coefficient_old = $('.calculate .price').attr('data-size-coefficient'),
								params_old = $('.calculate .price').attr('data-params-coefficient').split(';'),
								prev_old = $('.calculate .price').attr('data-prev-price');
								CoefficientSize(coefficient_old,params_old,prev_old);
						  }
							//прибавляем старую цену
							$('.calculate .price').text(parseInt($('.calculate .price').text())+ parseInt(price) );
							$('.calculate .price').attr('data-prev-price',price);
							$('.calculate .price').attr('data-size-coefficient','');
							$('.calculate .price').attr('data-params-coefficient','');
							
					  }
					  
							
					},
					error: function (jqXHR, textStatus, errorThrown) {
						alert('Error! 2.');
						console.log(jqXHR.responseText + '. ERRORS: ' + errorThrown);
					}
				});
			}
		}
	}	

//заполняем характеристики
	function Haracteristics() {
        $('.haracteristics .item.s').remove();
        var cal_price = $('.calculate .price').text($('.calculate .price').attr('data-prev-price'));
        $('#filter_parametrs .selectpicker5').each(function(){
			var znarr = $(this).val(),
				atrrname = $(this).attr('name'),
				title =$(this).prev().text();
			
			$(znarr).each(function(a,b){
			
				var zn = b;
				if (zn != '') {

					$('.haracteristics').append('<div class="s item" data-id="'+atrrname+'"><label>'+title+'</label><span>'+zn+'</span></div>');
					var price = $("#filter_parametrs .selectpicker5 option[value='"+zn+"']").attr('data-price');
					if (price) {
						$('.calculate .price').text(parseInt($('.calculate .price').text())+ parseInt(price) );
					}
					
				}
			});
		});
		var i=0;
        $('#filter_parametrs .selectpicker').each(function(){
						
			var zn = $(this).val();
			if($.isArray(zn)){
				atrrname = $(this).attr('name'),
				title =$(this).prev().text();
			
			$(zn).each(function(a,b){

				if (b != '') {

					$('.haracteristics').append('<div class="s item" data-id="'+atrrname+'"><label>'+title+'</label><span>'+b+'</span></div>');
					var price = $("#filter_parametrs .selectpicker option[value='"+b+"']").attr('data-price');
					if (price) {
						$('.calculate .price').text(parseInt($('.calculate .price').text())+ parseInt(price) );
					}
					
				}
			});
			}else{
				if (zn != 'Выберите значение' && zn != '') {
					if ($('.haracteristics .item[data-id='+$(this).attr('name')+']').length != 0) {
						$('.haracteristics').append('<div class="s item" data-id="'+$(this).attr('name')+'"><label>'+$(this).prev().text()+'</label><span>'+zn+'</span></div>');
					}
					else{

						var city_slug = $(this).find('option:selected').attr('data-city')
						
						if(city_slug == 'price_minsk' || city_slug == 'price_regions'){
							if(i == 0)
							$('.haracteristics').append('<div class="s item"><span class="hr"><hr></span></div>');
							i++;
							$('.'+city_slug).show();
							$('.prep').hide();
							if(city_slug == 'price_minsk') $('.price_regions').hide();
							if(city_slug == 'price_regions') $('.price_minsk').hide();
							
						}
				
				
				
						var colornum = zn.lastIndexOf("#");
						var back = '';
						if(colornum == 0){
							var substring = zn.split("/");
							back = 'style="background:'+substring[0]+'"';
							var sm = '<small '+back+' class="muted text-muted"></small>';
							var vall = substring[1];
							$(this).next().find('small').remove();
							$(this).next().find('.filter-option').after(sm);
						}else{
							var vall = zn;
						}	
						$('.haracteristics').append('<div class="s item" data-id="'+$(this).attr('name')+'"><label>'+$(this).prev().text()+'</label><span>'+vall+'</span></div>');
						//$('.haracteristics .item[data-id='+$(this).attr('name')+'] span').text(zn);
					}
					var cat = $(this).find('option:selected').attr('data-cat');
					if(vall !== 'За городом' && cat !== 'Поднятие на этаж'){
						if ($(this).find('option:selected').attr('data-price')) {
							$('.calculate .price').text(parseInt($('.calculate .price').text())+ parseInt($(this).find('option:selected').attr('data-price')) );
						}
					}else{
						var kilometer = $('#kilometer').val();
						if(vall == 'За городом' && $('#kilometer').val() != 'Выберите значение'){
							var kfn = $('#kilometer').find('option:selected').attr('data-km');
							var pr = $(this).find('option:selected').attr('data-price')*kfn;
							$('.calculate .price').text(parseInt($('.calculate .price').text())+ pr );
						}
						if($(this).find('option:selected').attr('data-cat') == 'Поднятие на этаж' && $('#level').val() != 'Выберите значение'){
							var kfn = $('#level').find('option:selected').val();
							var pr = $(this).find('option:selected').attr('data-price')*kfn;
							$('.calculate .price').text(parseInt($('.calculate .price').text())+ pr );
						}
					}
								
				}
			}
        })
		if ($('#filter_parametrs .eye').is(':checked')) {
			$('.calculate .price').text(parseInt($('.calculate .price').text())+ parseInt($('#filter_parametrs .eye').attr('data-price')) );
		}
		var price_total = parseInt($('.calculate .price').text())* $('.calculate .price').attr('data-series-coeff'),
			price_total_mini = price_total.toFixed(2);
			
		$('.calculate .price').text(price_total_mini );
	}	
	
	function translit(str) {
	str = str.toLowerCase().replace(/<.+>/, ' ').replace(/\s+/, ' ');
	var c = {
		'а':'a', 'б':'b', 'в':'v', 'г':'g', 'д':'d', 'е':'e', 'ё':'jo', 'ж':'zh', 'з':'z', 'и':'i', 'й':'j', 'к':'k', 'л':'l', 'м':'m', 'н':'n', 'о':'o', 'п':'p', 'р':'r', 'с':'s', 'т':'t', 'у':'u', 'ф':'f', 'х':'h', 'ц':'c', 'ч':'ch', 'ш':'sh', 'щ':'shch', 'ъ':'', 'ы':'y', 'ь':'', 'э':'e', 'ю':'ju', 'я':'ja', ' ':'-', ';':'', ':':'', ',':'', '—':'-', '–':'-', '.':'', '«':'', '»':'', '"':'', "'":'', '@':''
	}
	var newStr = new String();
	for (var i = 0; i < str.length; i++) {
		ch = str.charAt(i);
		newStr += ch in c ? c[ch] : ch;
	}
	return newStr;
}

});
	
