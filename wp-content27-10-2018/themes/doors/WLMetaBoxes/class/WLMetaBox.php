<?php
/**
 * Created by PhpStorm.
 * User: User
 * Date: 5/29/2018
 * Time: 7:05 PM
 */

class WLMetaBox
{
    // Location post, page, post_type, template.php
    public $location_mb;

    // Name MetaBox
    public $name_mb;

    // List arguments
    public $args;

    // Unique key
    public $unique_key;

    // Repeater array_name
    public $post_meta_array;

    public function __construct( $args )
    {
        $this->location_mb = isset($args['location_mb']) ? $args['location_mb'] : 'post';
        $this->name_mb = isset($args['name_mb']) ? $args['name_mb'] : 'MetaBox';
        $this->args = $args;
        $this->unique_key = uniqid();

        // Create MetaBox
        add_action('add_meta_boxes', [$this, 'WLMetaBox_add_custom_box']);

        // Save meta_key
        add_action( 'save_post', [$this, 'WL_save_post']);

        // if isset repeater
        $this->issetRepeater($args);
    }

    public function issetRepeater($args) {
        foreach ($args['fields'] as $field) {
            if($field['field'] == 'repeater'){
                $this->post_meta_array = $field['post_meta_array'];
                add_action( 'admin_footer-post.php', [ $this, 'createJSHandler' ]);
                add_action('wp_ajax_add_fields_' . $this->post_meta_array, [ $this, 'getAllFieldAjax']);
                return;
            }
        }
    }

    // Create Meta Box
    public function WLMetaBox_add_custom_box()
    {
        // Проверка на создание бокса в шаблоне
        if(is_string($this->location_mb) && strripos($this->location_mb, '.php') !== false)
        {
            $this->addBoxCustomTemplate($this->location_mb);
        }
        elseif (is_array($this->location_mb))
        {
            foreach ($this->location_mb as $item) {
                if(strripos($item, '.php') !== false)
                {
                    $this->addBoxCustomTemplate($item);
                }
                else {
                    add_meta_box('WLMetaBox_' . $this->unique_key,
                        $this->name_mb,
                        [$this, 'WLMetaBox_callback'],
                        $item);
                }
            }
        }
        else {
            add_meta_box('WLMetaBox_' . $this->unique_key,
                $this->name_mb,
                [$this, 'WLMetaBox_callback'],
                $this->location_mb);
        }
    }

    public function addBoxCustomTemplate($location) {
        $page_template = get_page_template_slug( get_queried_object_id() );

        if($page_template == $location){
            add_meta_box('WLMetaBox_' . uniqid(),
                $this->name_mb,
                [$this, 'WLMetaBox_callback'],
                'page');
        }
    }

    // Get callback MetaBox
    public function WLMetaBox_callback(){
        $post_id = get_the_ID();
        if(!is_array($this->args['fields'])){
            return false;
        }

        foreach ($this->args['fields'] as $key => $argument) {
            if(isset($argument['post_meta'])){
                $post_meta = get_post_meta($post_id, $argument['post_meta'], true);
            }
            elseif (isset($argument['post_meta_array'])){
                $post_meta = get_post_meta($post_id, $argument['post_meta_array'], true);
            }
            else {
                $post_meta = '';
            }


            if($argument['field'] == 'repeater'){
                $this->WLMetaBox_callback_repeater($post_meta, $argument);
            }
            elseif ($argument['field'] == 'gallery') {
                $this->WLMetaBox_callback_gallery($post_meta, $argument);
            }
            else {
                echo '<div class="WL-field">';
                echo $this->getField($argument, $post_meta, $key);
                echo '</div>';
            }
        }
    }

    public function WLMetaBox_callback_repeater($post_meta, $argument) {
        $post_meta_array = $argument['post_meta_array'];
        $slide_name = $argument['slide_name'];
        $button_add_name = $argument['button_add_name'];
        ?>
        <div class="WL-container" data-slide-name="<?php echo $slide_name; ?>">
            <?php if(!empty($post_meta)) {
                $i=0;
                foreach ($post_meta as $key => $item) { ?>

                    <div class="WL-slide">
                        <div class="WL-title">
                            <p class="title-slide-banner">
                                <?php echo $slide_name ?> № <?php echo $i+1; ?>
                            </p>
                            <svg class="show-slide" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" viewBox="0 0 129 129" enable-background="new 0 0 129 129" width="30px" height="30px">
                                <g>
                                    <path d="m121.3,34.6c-1.6-1.6-4.2-1.6-5.8,0l-51,51.1-51.1-51.1c-1.6-1.6-4.2-1.6-5.8,0-1.6,1.6-1.6,4.2 0,5.8l53.9,53.9c0.8,0.8 1.8,1.2 2.9,1.2 1,0 2.1-0.4 2.9-1.2l53.9-53.9c1.7-1.6 1.7-4.2 0.1-5.8z" fill="#FFFFFF"/>
                                </g>
                            </svg>
                            <svg class="delete-slide" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" x="0px" y="0px" viewBox="0 0 31.112 31.112" style="enable-background:new 0 0 31.112 31.112;" xml:space="preserve" width="22px" height="30px">
                                <polygon points="31.112,1.414 29.698,0 15.556,14.142 1.414,0 0,1.414 14.142,15.556 0,29.698 1.414,31.112 15.556,16.97   29.698,31.112 31.112,29.698 16.97,15.556 " fill="red"/>
                            </svg>
                        </div>
                        <div class="WL-content">
                            <?php
                            foreach ($argument['slides'] as $argument_item) {
                                echo '<div class="WL-list">';
                                echo  $this->getField($argument_item, $item, $key, true, $post_meta_array);
                                echo  '</div>';
                            }
                            ?>
                        </div>
                    </div>
                    <?php
                    $i++;
                }
            }
            ?>
        </div>
        <button class="WL-green-button WL-add-slide <?php echo $this->post_meta_array ?>"
                data-name-array="<?php echo $post_meta_array; ?>">
            <?php echo $button_add_name; ?>
        </button>
        <?php
    }

    public function WLMetaBox_callback_gallery($post_meta, $argument){

        echo '<div class="WL-gallery-container" data-name="'.$argument['post_meta_array'].'">';
        if($post_meta){
            foreach ($post_meta as $photo ) {
                echo '<div class="WL-gallery-item">
                            <img src="'.$photo.'" alt="">
                            <svg class="WL-delete-gallery-item" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" x="0px" y="0px" viewBox="0 0 31.112 31.112" style="enable-background:new 0 0 31.112 31.112;" xml:space="preserve" width="20px" height="20px">
                                    <polygon points="31.112,1.414 29.698,0 15.556,14.142 1.414,0 0,1.414 14.142,15.556 0,29.698 1.414,31.112 15.556,16.97   29.698,31.112 31.112,29.698 16.97,15.556 " fill="#175642"></polygon>
                                </svg>
                            <input type="hidden" name="'.$this->post_meta_array.'[]" value="'.$photo.'"/>
                    </div>';
            }
        }
        echo '</div>';
        echo '<button class="WL-green-button WL-add-gallery-item">Добавить изображение</button>';
    }

    public function getField($argument, $value = '', $key, $isRepeater = false, $post_meta_array = '', $ajax = false)
    {
        //Title Field
        $label = !empty($argument['label']) ? '<p>'.$argument['label'].'</p>' : '';

        // Meta key field
        if (!empty($post_meta_array)){
            $meta_key = $post_meta_array.'['.$key.']['.$argument['post_meta'].']';
        }
        elseif($isRepeater){
            $meta_key = $argument['post_meta_array'].'['.$key.']['.$argument['post_meta'].']';
        }
        else {
            $meta_key = !empty($argument['post_meta']) ? $argument['post_meta'] : '';
        }

        if(is_array($value)){
            if(array_key_exists($argument['post_meta'], $value)){
                $value = $value[$argument['post_meta']];
            }
        }

        switch ($argument['field']) {
            case 'text':
                return $label . '<input type="text" name="' . $meta_key . '" value="' . $value . '" />';

            case 'label':
                return $argument['text'];

            case 'checkbox':
                $checked = '';
                if (1 == $value) $checked = 'checked="checked"';
                return $label . '<input type="checkbox" name="' . $meta_key . '" value="1" ' . $checked . ' />';

            case 'color':
                return $label . '<input type="text" class="WL-color-picker" name="' . $meta_key . '" value="' . $value . '" />';

            case 'textarea':
                return $label . '<textarea name="' . $meta_key . '">' . $value . '</textarea>';

            case 'image':
                return '<div class="WL-image">' .
                    $label
                    . '<div class="WL-content-image">
                                <img src="' . $value . '" alt="">
                                <input type="hidden"
                                       value="' . $value . '"
                                       name="' . $meta_key . '"
                                       class="path-img field-admin-var">
                                <button class="WL-green-button WL-image-add">Выбрать(изменить) изображение</button>
                                <button class="WL-green-button WL-image-delete">Удалить</button>
                            </div>
                        </div>';

            case 'wp_editor':
                if(empty($value) && $ajax === true){
                    return '<p class="rewrite-to-wp_editor" data-name="'.$meta_key.'">'.$label.'</p>';
                }
                else {
                    echo $label;
                    wp_editor($value,
                        'wp_editor' . uniqid(),
                        ['textarea_name' => $meta_key]);
                    break;
                }
            default:
                return '<h4>Error: Неизвестный тип поля "' . $argument['field'] . '"</h4>';
        }
    }

    public function createJSHandler() { ?>

        <script>
            jQuery(document).ready( $ => {

                $(document).on('click', '.WL-add-slide.<?php echo $this->post_meta_array ?>', function(e) {
                    //Сброс кнопки, что бы форма не перезагружалась
                    e.preventDefault();
                    let numberKey = $(this).prev('.WL-container').find('.WL-slide').length, // Получим номер для полей attr=name
                        numberSlide = numberKey + 1, // Получим номер слайда для заголовка
                        nameSlide = $(this).prev('.WL-container').data('slideName'),
                        html,
                        postMetaArray = $(this).data('nameArray'),
                        data = {
                            action: 'add_fields_<?php echo $this->post_meta_array; ?>',
                            numberKey: numberKey,
                            post_meta_array: postMetaArray
                        };

                    console.log(postMetaArray);

                    html = `<div class="WL-slide WL-slide-active">
                                <div class="WL-title">
                                    <p class="WL-title-slide">${nameSlide} № ${numberSlide}</p>
                                    <svg class="show-slide" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" viewBox="0 0 129 129" enable-background="new 0 0 129 129" width="30px" height="30px">
                                        <g>
                                            <path d="m121.3,34.6c-1.6-1.6-4.2-1.6-5.8,0l-51,51.1-51.1-51.1c-1.6-1.6-4.2-1.6-5.8,0-1.6,1.6-1.6,4.2 0,5.8l53.9,53.9c0.8,0.8 1.8,1.2 2.9,1.2 1,0 2.1-0.4 2.9-1.2l53.9-53.9c1.7-1.6 1.7-4.2 0.1-5.8z" fill="#FFFFFF"/>
                                        </g>
                                    </svg>
                                    <svg class="delete-slide" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" x="0px" y="0px" viewBox="0 0 31.112 31.112" style="enable-background:new 0 0 31.112 31.112;" xml:space="preserve" width="22px" height="30px">
                                        <polygon points="31.112,1.414 29.698,0 15.556,14.142 1.414,0 0,1.414 14.142,15.556 0,29.698 1.414,31.112 15.556,16.97   29.698,31.112 31.112,29.698 16.97,15.556 " fill="red"/>
                                    </svg>
                                </div>
                                <div class="WL-content"></div>
                            </div>`;

                    html = $.parseHTML( html )[0];

                    jQuery.post( ajaxurl, data, response => {
                        $(html).find('.WL-content').append(response);
                        if($(html).find('p.rewrite-to-wp_editor').length > 0){

                            let textArea = document.createElement('textarea');
                            let nameTa = $(html).find('p.rewrite-to-wp_editor').data('name');
                            $(textArea).attr('name', nameTa);

                            $(html).find('p.rewrite-to-wp_editor').parent().append(textArea);

                            $(this).prev('.WL-container').append(html);

                            tinymce.init({
                                target: textArea
                            });
                            $(html).find('p.rewrite-to-wp_editor').remove();
                        }
                        else {
                            $(this).prev('.WL-container').append(html);
                        }
                        $('.WL-color-picker').wpColorPicker();
                    },'json');
                });
            });

        </script>
        <?php
    }

    public function getAllFieldAjax() {
        $html = '';

        $post_meta_array = $_POST['post_meta_array'];
        $numberKey = $_POST['numberKey'];


        foreach ($this->args['fields'] as $argument) {
            if($argument['post_meta_array'] == $post_meta_array){
                foreach ($argument['slides'] as $slide) {
                    $html .= '<div class="WL-list">';
                    $html .= $this->getField($slide, '', $numberKey, true, $post_meta_array, true);
                    $html .= '</div>';
                }
            }
        }

        exit(json_encode($html));
    }

    /**
     *  Save Meta Boxes
     */
    public function WL_save_post( $post_id ) {
        foreach ($this->args['fields'] as $field) {

            if( $field['field'] == 'repeater' || $field['field'] == 'gallery') {
                if(!empty($field['post_meta_array'])){
                    $value = !empty($_POST[$field['post_meta_array']]) ? $_POST[$field['post_meta_array']] : '';
                    update_post_meta( $post_id, $field['post_meta_array'], $value);
                }
            }
            else {
                if (isset($field['post_meta']) && isset($_POST[$field['post_meta']])) {

                    $value = $_POST[$field['post_meta']];

                    if ($field['field'] === 'checkbox') {
                        $value = !empty($_POST[$field['post_meta']]) ? $_POST[$field['post_meta']] : '';
                    }
                    update_post_meta($post_id, $field['post_meta'], $value);
                } else {
                    if ($field['field'] === 'checkbox') {
                        $value = !empty($_POST[$field['post_meta']]) ? $_POST[$field['post_meta']] : '';
                        update_post_meta($post_id, $field['post_meta'], $value);
                    }
                }
            }
        }
    }

}


// Created object class
function WL_create_meta_box( $args ) {
    if(empty($args['location_mb'])) return false;

    if(empty($args['name_mb'])) return false;

    return new WLMetaBox($args);
}

