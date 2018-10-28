jQuery(document).ready(function($){
	$('#basic').selectator();
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
	 $(document).on('click', '.container-base .item-base button', function (e) {
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
});