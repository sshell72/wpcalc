jQuery(document).ready(function ($) {

    $(document).on('click', 'button.wp_media', function() {
        let input = $(this).parent().find('input'),
            img = $(this).parent().find('img'),
            send_attachment_bkp = wp.media.editor.send.attachment;
        wp.media.editor.send.attachment = function(props, attachment) {
            $(input).val(attachment.url);
            $(img).attr("src",attachment.url);
            wp.media.editor.send.attachment = send_attachment_bkp;
        };
        wp.media.editor.open($(this));
        return false;
    });

	
$('.popup_model .close_popup').on('click', function () {
	$(this).closest('.popup_model').hide();
});

$('.clone_model').on('click', function () {
	let id = $(this).data('popup'),
		id_model = $(this).data('model');
		$('#'+id).show();
	$('#clone_model').find('input[name=id_model]').val(id_model);
	
});

$('.open-popup').on('click', function (e) {
	e.preventDefault();
	$('#clone_model').show();
});


	
$('.popup_price .close_popup').on('click', function () {
	$(this).closest('.popup_price').hide();
});

$('.price_edit').on('click', function () {
	let id = $(this).data('popup'),
		id_service = $(this).data('service'),
		price_regions = $(this).data('reg');
		$('#'+id).show();
	$('#price_edit').find('input[name=price_regions]').val(price_regions);
	$('#price_edit').find('input[name=id_service]').val(id_service);
	
});

$('.open-popup').on('click', function (e) {
	e.preventDefault();
	$('#price_edit').show();
});	


$('.popup_decor .close_popup').on('click', function () {
	$(this).closest('.popup_decor').hide();
});

$('.clone_decor').on('click', function () {
	let id = $(this).data('popup'),
		id_decor = $(this).data('decor');
		$('#'+id).show();
	$('#clone_decor').find('input[name=id_decor]').val(id_decor);
	
});

$('.open-popup').on('click', function (e) {
	e.preventDefault();
	$('#clone_decor').show();
});
	
	
    $('.popup .close_popup').on('click', function () {
        $(this).closest('.popup').hide();
    });

    $('.street_redact').on('click', function () {
        let id = $(this).data('popup'),
            id_series = $(this).parents('tr').data('id'),
            name = $(this).parents('tr').find('.name-series a').text().trim();
            if (name == '') {
                name = $(this).parents('tr').find('.name-series').text().trim();
            }
        $('#'+id).show();
        $('#redact_street').find('input[name=id]').val(id_series);
        $('#redact_street').find('input[name=name]').val(name);
    });

    $('.open-popup').on('click', function (e) {
        e.preventDefault();
        $('#redact_street').show();
    });

    $('.open-pop-params').on('click', function (e) {
        e.preventDefault();
        $('#redact_street').show();
    });

    let ids_arr = [];
    let names_arr = [];

    $(document).on('click', '.change-pop-open', function () {
        let id = $(this).parents('tr').data('id'),
            ids = $(this).parent().attr('data-ids'),
            names = $(this).parent().attr('data-names');

        ids_arr = ids.split(',');
        names_arr = names.split(',');

        $('#param-change input[name=id-param]').val(id);

        // get values parameters
        let values = [];
        $('.content-tags .tag').remove();
        $(this).siblings('.val-element').each(function () {
            let id = $(this).data('id'),
                value = $(this).text();
            value = `<span class="tag" data-id="${id}">${value}</span>`;
            values.push(value);
        });
        $('.content-tags').prepend(values);

        $('#param-change').show();
    });

    $('input.tags').on('focus', function(){
        $('.tags_available li').remove();
        let val = $(this).val(),
            names_res = [],
            ids_res = [];

        for (var i = 0; i < names_arr.length; i++) {
            if (names_arr[i].toLowerCase().indexOf(val.toLowerCase()) != -1) {
                names_res.push(names_arr[i]);
                ids_res.push(ids_arr[i]);
                $('.tags_available').append('<li data-id="'+ids_res[i]+'">'+names_arr[i]+'</li>')
            }
        }

        if ($('.tags_available li').length>0) {
            $('.tags_available').show();
        }

    })


    $(document).on('click', '.tags_available li', function(){
        let txt = $(this).text();
        $('.tags input.tags').val(txt);
        let repeat = false;
        $('span.tag').each(function(){
            if ($(this).text() == txt) {
                repeat = true;
            }
        })
        if(txt && !repeat) {
            $('.tags input.tags').before('<span class="tag" data-id="'+$(this).data('id')+'">'+ txt.toLowerCase() +'</span>');
        }
        $('.tags input.tags').val('');
        $('.tags_available').hide();
    })

    $('.save-param-value').on('click', function (e) {
        e.preventDefault();

        $('input[name=value_id]').val(0);
        $('input[name=name]').val('');
        $('input[name=price]').val('');

        $('#redact_street').show();
    });

    $('.edit-value-param').on('click', function () {
        document.fieldUpdateFlag = 1;
        let id = $(this).parents('tr').data('id'),
            name = $(this).parents('tr').find('.name-value').text(),
            price = +$(this).parents('tr').find('.price-value').text();

        $('input[name=value_id]').val(id);
        $('input[name=name]').val(name);
        $('input[name=price]').val(price);

        $('#redact_street').show();
    });



});