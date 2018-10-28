jQuery(document).ready( $ => {
    // Добавление изображения в поле
    $(document).on('click', 'button.WL-image-add', function() {
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

    // Удаление слайда
    $(document).on('click', '.delete-slide', function(){
        $(this).parents('.WL-slide').remove();
    });

    // Скрытие && Раскрытие слайда
    $(document).on('click','.show-slide',function(){
        $(this).toggleClass('active-rotate');
        $(this).parents(".WL-slide").find('.WL-content').slideToggle();
    });

    //Удаление картинки
    $(document).on('click', 'button.WL-image-delete', function(e) {
        e.preventDefault();
        $(this).parent().find('img').attr('src', '');
        $(this).parent().find('input[type=hidden]').val('');
    });

    // MetaBox Gallery

    // Добавление изображения в галерею
    $(document).on('click', 'button.WL-add-gallery-item', function() {
        let name = $(this).siblings('.WL-gallery-container').data('name'),
            send_attachment_bkp = wp.media.editor.send.attachment;
        wp.media.editor.send.attachment = function(props, attachment) {
            $('.WL-gallery-container').append(`<div class="WL-gallery-item">
                            <img src="${attachment.url}" alt="">
                            <svg class="WL-delete-gallery-item" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" x="0px" y="0px" viewBox="0 0 31.112 31.112" style="enable-background:new 0 0 31.112 31.112;" xml:space="preserve" width="20px" height="20px">
                                <polygon points="31.112,1.414 29.698,0 15.556,14.142 1.414,0 0,1.414 14.142,15.556 0,29.698 1.414,31.112 15.556,16.97   29.698,31.112 31.112,29.698 16.97,15.556 " fill="#175642"></polygon>
                            </svg>
                            <input type="hidden" name="${name}[]" value="${attachment.url}"/>
                    </div>`);

            wp.media.editor.send.attachment = send_attachment_bkp;
        };
        wp.media.editor.open($(this));
        return false;
    });

    // Появаление кнопки закрытия
    $(document).on('mouseover', '.WL-gallery-item',function () {
        $(this).find('svg').show();
    });

    // Скрытие кнопки закрытия
    $(document).on('mouseout', '.WL-gallery-item', function () {
        $(this).find('svg').hide();
    });

    // Удаление картинки с галереи
    $(document).on('click', '.WL-delete-gallery-item', function () {
        $(this).parent().remove();
    });

    $('.WL-color-picker').wpColorPicker();
});