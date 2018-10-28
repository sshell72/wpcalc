jQuery(document).ready(function($){
	
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
});