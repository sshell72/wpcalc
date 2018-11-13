jQuery(document).ready(function($){
	//$('#basic').selectator();
	 $('.clone_decor_go').on('submit',function (e) {
		e.preventDefault();
		let name = $(this).find('input[name=name]').val(),
		id_decor = $(this).find('input[name=id_decor]').val();
		$.ajax({
            type: 'post',
            //dataType: 'json',
            url: ajaxurl,
            data: {
                action: 'clone_copy_decor',
                name: name,
                id_decor: id_decor
            },
            success: function(data) {
				location.reload();
			},
            error: function (jqXHR, textStatus, errorThrown) {
                alert('Error! 1.');
                console.log(jqXHR.responseText + '. ERRORS: ' + errorThrown);
            }
		});
	}); 
	
	$('.copy_go').on('submit',function (e) {
		e.preventDefault();
		let id_decor_parent = $(this).find('select[name=id_decor_parent]').val(),
		id_decor_childe = $(this).find('#childe-copy').val();
		$.ajax({
            type: 'post',
            //dataType: 'json',
            url: ajaxurl,
            data: {
                action: 'copy_decors',
                id_decor_parent: id_decor_parent,
                id_decor_childe: id_decor_childe
            },
            success: function(data) {
				alert('Обновление параметров прошло успешно!')
				location.reload();
			},
            error: function (jqXHR, textStatus, errorThrown) {
                alert('Error! Обновление параметров не завершено.');
                console.log(jqXHR.responseText + '. ERRORS: ' + errorThrown);
            }
		});
	}); 	 
	
	$('.inherit_go').on('submit',function (e) {
		e.preventDefault();
		let name = $(this).find('input[name=name]').val(),
		price = $(this).find('input[name=price]').val(),
		model_id = getUrlParameter('model_id'),
		id_decor = $(this).find('select[name=id_decor]').val();
		$.ajax({
            type: 'post',
            //dataType: 'json',
            url: ajaxurl,
            data: {
                action: 'inherit_copy',
                name: name,
                price: price,
				model_id: model_id,
                id_decor: id_decor
            },
            success: function(data) {
				var decor_id = data,
					model_id = getUrlParameter('model_id');
				var href = location.href;
					href = href.slice(0,-1);
					href = href+'&decor_id='+decor_id;
				location.assign(href);
			},
            error: function (jqXHR, textStatus, errorThrown) {
                alert('Error! 1.');
                console.log(jqXHR.responseText + '. ERRORS: ' + errorThrown);
            }
		});
	}); 
	
	$('.copy_go').on('submit',function (e) {
		e.preventDefault();
		let name = $(this).find('input[name=name]').val(),
		price = $(this).find('input[name=price]').val(),
		model_id = getUrlParameter('model_id'),
		id_decor = $(this).find('select[name=id_decor]').val();
		$.ajax({
            type: 'post',
            //dataType: 'json',
            url: ajaxurl,
            data: {
                action: 'copy_copy',
                name: name,
                price: price,
				model_id: model_id,
                id_decor: id_decor
            },
            success: function(data) {
				var decor_id = data,
					model_id = getUrlParameter('model_id');
				var href = location.href;
					href = href.slice(0,-1);
					href = href+'&decor_id='+decor_id;
				location.assign(href);
			},
            error: function (jqXHR, textStatus, errorThrown) {
                alert('Error! 1.');
                console.log(jqXHR.responseText + '. ERRORS: ' + errorThrown);
            }
		});
	}); 
	
	 $('.clone_model_go').on('submit',function (e) {
		e.preventDefault();
		let name = $(this).find('input[name=name]').val(),
		id_model = $(this).find('input[name=id_model]').val();
		$.ajax({
            type: 'post',
            //dataType: 'json',
            url: ajaxurl,
            data: {
                action: 'clone_copy_model',
                name: name,
                id_model: id_model
            },
            success: function(data) {
				location.reload();
			},
            error: function (jqXHR, textStatus, errorThrown) {
                alert('Error! 2.');
                console.log(jqXHR.responseText + '. ERRORS: ' + errorThrown);
            }
		});
	}); 
	
	 $('.clone_price_go').on('submit',function (e) {
		e.preventDefault();
		let price_regions = $(this).find('input[name=price_regions]').val(),
		price = $(this).find('input[name=price]').val(),
		id_service = $(this).find('input[name=id_service]').val();
		$.ajax({
            type: 'post',
            //dataType: 'json',
            url: ajaxurl,
            data: {
                action: 'edit_price',
                price_regions: price_regions,
                price: price,
                id_service: id_service
            },
            success: function(data) {
				location.reload();
			},
            error: function (jqXHR, textStatus, errorThrown) {
                alert('Error! 3.');
                console.log(jqXHR.responseText + '. ERRORS: ' + errorThrown);
            }
		});
	}); 
	
	 // Add new base
	 $(document).on('click', '.container-base .item-base button.click', function (e) {
		e.preventDefault();

		let opt        = $('select[name=choose-base-param]').val(),
			decor_id       = $('input[name=decor_id]').val(),
			id_value1       = $('input[name=val1]').val(),
			id_value2       = $('input[name=val2]').val(),
			price 			= $('input[name=price_new]').val(),
			coefficient     = $('input[name=coefficient]').val(),
			params 			= $('#params').val();
			/* $('#params').find('option:selected').each(function(){
				params.push($('#params').val());
			}) */
			data = {
				action: 'add_base_param',
				opt: opt,
				decor_id: decor_id,
				id_value1: id_value1,
				id_value2: id_value2,
				price: price,
				params: params,
				coefficient: coefficient
			};

		if((opt == 0 || opt == '') ||
			(id_value1 == 0 || id_value1 == '') ||
			(id_value2 == 0 || id_value2 == '') ||
			(price == 0 || price == '') ||
			(params == 0 || params == '' || !params) ||
			(coefficient == 0 || coefficient == '')) {
			alert('Введите все поля!');
			return;
		}

		$.ajax({
            type: 'post',
            //dataType: 'json',
            url: ajaxurl,
            data: data,
            success: function(data) {
				alert(data);
				location.reload();
			},
            error: function (jqXHR, textStatus, errorThrown) {
                alert('Error! ');
                console.log(jqXHR.responseText + '. ERRORS: ' + errorThrown);
            }
		});

	});
	
	
	$('.delete_r.ka_del').on('click', function () {
		if(confirm('Удалить?')){
			let id = $(this).parents('.item-base').data('locked-id'),
				elem = $(this).parents('.item-base'),
				data = {
					action: 'delete_base',
					id: id
				};

			jQuery.post( ajaxurl, data, response =>{
				$(elem).remove();
			});
		}
	});
	
	$('.delete_decor').on('click', function () {
		if(confirm('Удалить?')){
			let model_id = $(this).data('model'),
				decor_id = $(this).data('decor')
				data = {
					action: 'delete_decor',
					model_id: model_id,
					decor_id: decor_id
				};

			jQuery.post( ajaxurl, data, response =>{
				$(this).parents('.'+decor_id).remove();
			});
		}
	});
	
	$('.default-text').on('change', function () {
		let def_text = $(this).val(),
			id_param = $(this).parents('tr').data('id'),
			id_decor = $(this).parents('tbody').data('decorId'),
			data = {
				action: 'add_def_text',
				def_text: def_text,
				id_param: id_param,
				id_decor: id_decor
			};

		jQuery.post(
			ajaxurl,
			data,
			response =>{

				console.log(response);
			},'json');
	});
	
	// Add new coefficient
	$(document).on('click', '.item-coefficient button.click', function (e) {
		e.preventDefault();

		let id_param       = $('select[name=choose-coefficient-param]').val(),
			id_value       = $('select[name=values-coefficient]').val(),
			id_param_coefficient = $('#coefficient-param').val(),
			coefficient = $('input[name=coefficient_price]').val(),
			id_decor       = $(this).parents('.container-coefficient').data('decorId'),
			data = {
				action: 'add_coefficient_param',
				id_param: id_param,
				id_value: id_value,
				id_param_coefficient: id_param_coefficient,
				coefficient: coefficient,
				id_decor: id_decor,
			};

		if((id_param == 0 || id_param == '') ||
			(id_value == 0 || id_value == '') ||
			(id_param_coefficient == 0 || id_param_coefficient == '')) {
			alert('Введите все поля!');
			return;
		}

		jQuery.post(
			ajaxurl,
			data,
			response =>{
				alert('Сохранено');
				location.reload();
			},'json');

	});
	

	$('select[name=id_decor_parent]').on('change', function(){
		var value = $(this).val(),
			series_id = $(this).find('option:selected').data('series');

		var data = {
				action: 'decor_parent',
				series_id: series_id,
				value: value
			};


		jQuery.post( ajaxurl, data, response =>{
			//$(elem).html(JSON.parse(response));
			$('#childe-copy').find('option').remove();
			$('#childe-copy').append(response);
			console.log('response', response);
		});

	})
	
	$('select[name=choose-coefficient-param]').on('change', function(){
		var value = $(this).val(),
			elem = $(this).parent().find('select[name=values-coefficient]')
			decor_id = $(this).data('decor-id');

		var data = {
				action: 'get_values_for_coefficienting',
				decor_id: decor_id,
				value: value
			};


		jQuery.post( ajaxurl, data, response =>{
			$(elem).html(JSON.parse(response));
			console.log('response', response);
		});

	})
	
	
	$('.delete_row.kayzp_del_price').on('click', function () {
		if(confirm('Удалить?')){
			let id = $(this).parents('.item-coefficient').data('locked-id'),
				elem = $(this).parents('.item-coefficient'),
				data = {
					action: 'delete_rule_coefficient',
					id: id
				};

			jQuery.post( ajaxurl, data, response =>{
				$(elem).remove();
			});
		}
	});
	
	
	$('.popup_redact .close_popup').on('click', function () {
		$(this).closest('.popup_redact').hide();
	});
	
	$('.popup_inherit .close_popup').on('click', function () {
		$(this).closest('.popup_inherit').hide();
	});

	$('.inherit').on('click', function () {
		let id = $(this).data('popup'),
			name = $('.street-container').find('input[name=name]').val(),
			price = $('.street-container').find('input[name=price]').val();
			$('#'+id).show();
		$('#inherit').find('input[name=name]').val(name);
		$('#inherit').find('input[name=price]').val(price);
		
	});

	
	$('.popup_copy .close_popup').on('click', function () {
		$(this).closest('.popup_copy').hide();
	});

	$('.copy').on('click', function () {
		let id = $(this).data('popup'),
			name = $('.street-container').find('input[name=name]').val(),
			price = $('.street-container').find('input[name=price]').val();
			$('#'+id).show();
		$('#copy').find('input[name=name]').val(name);
		$('#copy').find('input[name=price]').val(price);
		
	});

	$('.open-redact').on('click', function (e) {
        e.preventDefault();
		var param_id = $(this).parent('td').parent('tr').attr('data-id'),
			type_parameters_id = $(this).parent('td').parent('tr').find('.type-param').attr('data-type-param'),
			block_parameters_id = $(this).parent('td').parent('tr').find('.block-param').attr('data-block-param'),
			name_param = $(this).parent('td').parent('tr').find('.name-param-text').text();
		
		$('#name-param').val(name_param);
		$(this).parent('.type-parameters option[value='+type_parameters_id+']').prop('selected',true);
		$(this).parent('.block-parameters option[value='+block_parameters_id+']').prop('selected',true);
		$('.type-parameters').val(type_parameters_id);
		$('.block-parameters').val(block_parameters_id);
		$('#id-param').val(param_id);
        $('#redact_street_redact').show();
    });
});

var getUrlParameter = function getUrlParameter(sParam) {
		var sPageURL = decodeURIComponent(window.location.search.substring(1)),
			sURLVariables = sPageURL.split('&'),
			sParameterName,
			i;
		for (i = 0; i < sURLVariables.length; i++) {
			sParameterName = sURLVariables[i].split('=');
			if (sParameterName[0] === sParam) {
				return sParameterName[1] === undefined ? true : sParameterName[1];
			}
		}
	};