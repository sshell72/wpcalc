<?php

// All pages
$args_title_page = [
    'location_mb' => 'page',
    'name_mb' => 'Title страницы',
    'fields' => [
        [
            'field' => 'text',
            'post_meta'  => 'title_page',
            'label' => 'Title',
        ]
    ]
];
WL_create_meta_box($args_title_page);

// Contact page
$args_contact_info = [
    'location_mb' => 'templates/page-contact.php',
    'name_mb' => 'Основная информация',
    'fields' => [
        [
            'field' => 'text',
            'post_meta'  => 'contact_phone',
            'label' => 'Телефон',
        ],
        [
            'field' => 'text',
            'post_meta'  => 'contact_email',
            'label' => 'E-mail',
        ],
        [
            'field' => 'text',
            'post_meta'  => 'contact_address',
            'label' => 'Адрес',
        ]
    ]
];
WL_create_meta_box($args_contact_info);

$args_contact_list = [
    'location_mb' => 'templates/page-contact.php',
    'name_mb' => 'Контакты',
    'fields' => [
        [
            'field' => 'repeater',
            'post_meta_array'  => 'list_contacts',
            'slide_name' => 'Адрес',
            'button_add_name' => 'Добавить адрес',
            'slides' => [
                [
                    'field' => 'text',
                    'post_meta' => 'contact_name',
                    'label' => 'Заголовок'
                ],
                [
                    'field' => 'text',
                    'post_meta' => 'full_address',
                    'label' => 'Полный адрес'
                ],
                [
                    'field' => 'textarea',
                    'post_meta' => 'phones',
                    'label' => 'Телефоны'
                ],
                [
                    'field' => 'text',
                    'post_meta' => 'email',
                    'label' => 'Почта'
                ],
                [
                    'field' => 'text',
                    'post_meta' => 'time_working',
                    'label' => 'Часы работы'
                ],
                [
                    'field' => 'text',
                    'post_meta' => 'width',
                    'label' => 'Широта'
                ],
                [
                    'field' => 'text',
                    'post_meta' => 'length',
                    'label' => 'Долгота'
                ]
            ]
        ]
    ]
];
WL_create_meta_box($args_contact_list);

// About page
$args_about = [
    'location_mb' => 'templates/page-about.php',
    'name_mb' => 'Контент страницы',
    'fields' => [
        [
            'field' => 'label',
            'text'  => '<h3>Левая колонка</h3>'
        ],
        [
            'field' => 'wp_editor',
            'post_meta' => 'left_column'
        ],
        [
            'field' => 'label',
            'text'  => '<h3>Правая колонка</h3>'
        ],
        [
            'field' => 'wp_editor',
            'post_meta' => 'right_column'
        ]
    ]
];
WL_create_meta_box($args_about);

// Order page
$args_order = [
    'location_mb' => 'templates/page-order.php',
    'name_mb' => 'Адреса',
    'fields' => [
        [
            'field' => 'repeater',
            'post_meta_array'  => 'list_address',
            'slide_name' => 'Адрес',
            'button_add_name' => 'Добавить адрес',
            'slides' => [
                [
                    'field' => 'text',
                    'post_meta' => 'address',
                    'label' => 'Адрес'
                ],
                [
                    'field' => 'text',
                    'post_meta' => 'time_working',
                    'label' => 'Время работы'
                ]
            ]
        ]
    ]
];
WL_create_meta_box($args_order);

// Article single page
$args_single_article = [
    'location_mb' => 'ads_article',
    'name_mb' => 'Дополнительные опции',
    'fields' => [
        [
            'field' => 'text',
            'post_meta' => 'ads_phone',
            'label' => 'Телефон'
        ],
        [
            'field' => 'repeater',
            'post_meta_array' => 'article_content',
            'slide_name' => 'Поле',
            'button_add_name' => 'Добавить поле',
            'slides' => [
                [
                    'field' => 'wp_editor',
                    'post_meta' => 'content'
                ]
            ]
        ]
    ]
];
WL_create_meta_box($args_single_article);

// Library single page
$args_single_library = [
    'location_mb' => 'library',
    'name_mb' => 'Дополнительные опции',
    'fields' => [
        [
            'field' => 'text',
            'post_meta'  => 'new_price',
            'label' => 'Новая цена',
        ],
        [
            'field' => 'text',
            'post_meta'  => 'lib_old_price',
            'label' => 'Старая цена',
        ],
        [
            'field' => 'text',
            'post_meta'  => 'lib_author',
            'label' => 'Автор',
        ],
        [
            'field' => 'checkbox',
            'post_meta'  => 'lib_author',
            'label' => 'Вам может быть интересно',
        ],
        [
            'field' => 'label',
            'text'  => '<h3>Нижний контент(для категории видео)</h3>'
        ],
        [
            'field' => 'wp_editor',
            'post_meta' => 'bottom_content'
        ],
        [
            'field' => 'label',
            'text'  => '<h3>Контент подписки</h3>'
        ],
        [
            'field' => 'wp_editor',
            'post_meta' => 'sub_content'
        ]
    ]
];
WL_create_meta_box($args_single_library);

add_action('add_meta_boxes', 'p_main_add_custom_box');
function p_main_add_custom_box(){
	$page_template = get_page_template_slug( get_queried_object_id() );
	add_meta_box( 'date_events', 'Дата события', 'events_meta_box_callback', 'events');
	add_meta_box( 'p_main_add_custom_box', 'Баннер', 'p_main_meta_box_callback', 'page');

	if( 'templates/page-payment.php' == $page_template ) {
		add_meta_box('metatest', 'Как оплатить заказ', 'metatest_showup', 'page');
		add_meta_box('lower_text_payment', 'Как оплатить заказ, текстовая часть', 'lower_text_payment_showup', 'page');
		add_meta_box('upper_text_cases', 'Онлайн-оплата', 'upper_text_cases_showup', 'page');
	}
	if( 'templates/page-receiving.php' == $page_template ) {
		add_meta_box('main', 'Cтоимость доставки', 'main_callback', 'page');
		add_meta_box('delivery_terms','Сроки доставки', 'delivery_callback','page');
	}
}

function p_main_meta_box_callback(){
	wp_nonce_field( plugin_basename(__FILE__), 'p_main_noncename' );
	$post_id = get_the_ID();
	$content_banners = get_post_meta($post_id,'content_banners', true);
	$check_banner = get_post_meta($post_id,'check_banner', true);
	?>
	<div class = "check-banner">
		<label for="main_page_title">Отображать на странице</label>
		<input type="checkbox" name="check_banner" value="1"<?php checked($check_banner)?> />
	</div>
	<div class="ban-container">
		<?php if(!empty($content_banners)){
			$i=0;
			foreach ($content_banners as $key => $banner) { ?>

				<div class="ban-slide ban-active">
					<div class="ban-title">
						<p class="title-slide-banner">Баннер № <span class="number-slide"><?php echo $i+1; ?></span></p>
						<svg class="show_uslug" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" version="1.1" viewBox="0 0 129 129" enable-background="new 0 0 129 129" width="512px" height="512px">
							<g>
								<path d="m121.3,34.6c-1.6-1.6-4.2-1.6-5.8,0l-51,51.1-51.1-51.1c-1.6-1.6-4.2-1.6-5.8,0-1.6,1.6-1.6,4.2 0,5.8l53.9,53.9c0.8,0.8 1.8,1.2 2.9,1.2 1,0 2.1-0.4 2.9-1.2l53.9-53.9c1.7-1.6 1.7-4.2 0.1-5.8z" fill="#FFFFFF"/>
							</g>
						</svg>
						<svg class="delete_banner" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" version="1.1" id="Capa_1" x="0px" y="0px" viewBox="0 0 31.112 31.112" style="enable-background:new 0 0 31.112 31.112;" xml:space="preserve" width="512px" height="512px">
	                        <polygon points="31.112,1.414 29.698,0 15.556,14.142 1.414,0 0,1.414 14.142,15.556 0,29.698 1.414,31.112 15.556,16.97   29.698,31.112 31.112,29.698 16.97,15.556 " fill="red"/>
	                    </svg>
					</div>
					<div class="ban-content flex-banner">
						<div class="ban-list">
							<p>Изображение</p>
							<div class="ban-plus">
								<img src="<?php echo $banner['image_banner']; ?>" alt="" class="img-media">
								<input type="hidden"
								       value="<?php echo $banner['image_banner']?>"
								       name="content_banners[<?php echo $key?>][image_banner]"
								       class="path-img field-admin-var"
								       data-name="image_banner">
								<button class="wp_media">Выбрать(изменить) изображение</button>
								<button class="wp_media_delete">Удалить</button>
							</div>
						</div>
						<div class="ban-list">
							<p>Верхний заголовок</p>
							<input class="field-admin-var"
							       name="content_banners[<?php echo $key?>][top_title_banner]"
							       type="text"
							       value="<?php echo $banner['top_title_banner'] ?>"
							       data-name="top_title_banner">
						</div>
						<div class="ban-list">
							<p>Большой заголовок</p>
							<textarea class="field-admin-var"
							          name="content_banners[<?php echo $key?>][big_title_banner]"
							          data-name="big_title_banner"><?php echo $banner['big_title_banner']; ?></textarea>
						</div>
						<div class="ban-list">
							<p>Текст</p>
							<textarea class="field-admin-var"
							          name="content_banners[<?php echo $key?>][text_banner]"
							          data-name="text_banner"><?php echo $banner['text_banner']; ?></textarea>
						</div>
						<div class="ban-list">
							<p>Ссылка</p>
							<input class="field-admin-var"
							       name="content_banners[<?php echo $key?>][link_banner]"
							       type="text"
							       value="<?php echo $banner['link_banner'] ?>"
							       data-name="link_banner">
						</div>
					</div>
				</div>
				<?php
				$i++;
			}
		}
		else { ?>
			<div class="ban-slide ban-active">
				<div class="ban-title">
					<p class="title-slide-banner">Баннер №<span class="number-slide">1</p>
					<svg class="show_uslug" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" version="1.1" viewBox="0 0 129 129" enable-background="new 0 0 129 129" width="512px" height="512px">
						<g>
							<path d="m121.3,34.6c-1.6-1.6-4.2-1.6-5.8,0l-51,51.1-51.1-51.1c-1.6-1.6-4.2-1.6-5.8,0-1.6,1.6-1.6,4.2 0,5.8l53.9,53.9c0.8,0.8 1.8,1.2 2.9,1.2 1,0 2.1-0.4 2.9-1.2l53.9-53.9c1.7-1.6 1.7-4.2 0.1-5.8z" fill="#FFFFFF"/>
						</g>
					</svg>
					<svg class="delete_banner" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" version="1.1" id="Capa_1" x="0px" y="0px" viewBox="0 0 31.112 31.112" style="enable-background:new 0 0 31.112 31.112;" xml:space="preserve" width="512px" height="512px">
                        <polygon points="31.112,1.414 29.698,0 15.556,14.142 1.414,0 0,1.414 14.142,15.556 0,29.698 1.414,31.112 15.556,16.97   29.698,31.112 31.112,29.698 16.97,15.556 " fill="red"/>
                    </svg>
				</div>
				<div class="ban-content">
					<div class="ban-list">
						<p>Изображение</p>
						<div class="ban-plus">
							<img src="" alt="" class="img-media">
							<input type="hidden"
							       name="content_banners[0][image_banner]"
							       class="path-img field-admin-var"
							       data-name="image_banner">
							<button class="wp_media">Выбрать(изменить) изображение</button>
							<button class="wp_media_delete">Удалить</button>
						</div>
					</div>
					<div class="ban-list">
						<p>Верхний заголовок</p>
						<input class="field-admin-var"
						       name="content_banners[0][top_title_banner]"
						       type="text"
						       data-name="top_title_banner">
					</div>
					<div class="ban-list">
						<p>Большой заголовок</p>
						<textarea class="field-admin-var"
						          name="content_banners[0][big_title_banner]"
						          data-name="big_title_banner"></textarea>
					</div>
					<div class="ban-list">
						<p>Текст</p>
						<textarea class="field-admin-var"
						          name="content_banners[0][text_banner]"
						          data-name="text_banner"></textarea>
					</div>
					<div class="ban-list">
						<p>Ссылка</p>
						<input class="field-admin-var"
						       name="content_banners[0][link_banner]"
						       type="text"
						       data-name="link_banner">
					</div>
				</div>
			</div>
			<?php
		}
		?>
	</div>
	<button class="add_banner_style add_banner" data-name-Array="content_banners">Добавить банер</button>
	<?php
}

// Сохраняем данные, когда пост сохраняется
add_action( 'save_post', 'p_main_ban_save_postdata' );
function p_main_ban_save_postdata( $post_id ) {
	if ( ! isset( $_POST['content_banners'],
		$_POST['check_banner']) )
		return;

	$content_banners = $_POST['content_banners'];
	$check_banner = $_POST['check_banner'];
    
	update_post_meta( $post_id, 'content_banners', $content_banners );
	update_post_meta( $post_id, 'check_banner', $check_banner );
}

// HTML код блока
function events_meta_box_callback(){
	wp_nonce_field( plugin_basename(__FILE__), 'myplugin_noncename' );

	$date = get_post_meta(get_the_ID(),'date',true);
	?>
	<label>Дата</label>
	<input type="text" id="datetimepicker" name="date" value="<?php echo $date ?>">
	<?php
}

add_action( 'save_post', 'save_date_ev' );
function save_date_ev( $post_id ) {
	if ( ! isset( $_POST['date']) )
		return;

	if ( ! wp_verify_nonce( $_POST['myplugin_noncename'], plugin_basename(__FILE__) ) )
		return;
	$date = $_POST['date'] ;
	update_post_meta( $post_id, 'date', $date );
}

function metatest_showup(){
	wp_nonce_field( plugin_basename(__FILE__), 'myplugin_noncename' );

	$post_id = get_the_ID();
	$payment_array = get_post_meta($post_id,'payment',true);
	?>
	<div class="ban-container">
		<?php if(!empty($payment_array)){
			$i=0;
			foreach ($payment_array as $key => $payment) { ?>

				<div class="ban-slide ban-active">
					<div class="ban-title">
						<p class="title-slide-banner">Баннер № <span class="number-slide"><?php echo $i+1; ?></span></p>
						<svg class="show_uslug" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" version="1.1" viewBox="0 0 129 129" enable-background="new 0 0 129 129" width="512px" height="512px">
							<g>
								<path d="m121.3,34.6c-1.6-1.6-4.2-1.6-5.8,0l-51,51.1-51.1-51.1c-1.6-1.6-4.2-1.6-5.8,0-1.6,1.6-1.6,4.2 0,5.8l53.9,53.9c0.8,0.8 1.8,1.2 2.9,1.2 1,0 2.1-0.4 2.9-1.2l53.9-53.9c1.7-1.6 1.7-4.2 0.1-5.8z" fill="#FFFFFF"/>
							</g>
						</svg>
						<svg class="delete_banner" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" version="1.1" id="Capa_1" x="0px" y="0px" viewBox="0 0 31.112 31.112" style="enable-background:new 0 0 31.112 31.112;" xml:space="preserve" width="512px" height="512px">
	                        <polygon points="31.112,1.414 29.698,0 15.556,14.142 1.414,0 0,1.414 14.142,15.556 0,29.698 1.414,31.112 15.556,16.97   29.698,31.112 31.112,29.698 16.97,15.556 " fill="red"/>
	                    </svg>
					</div>
					<div class="ban-content flex-banner">
						<div class="ban-list">
							<p>Изображение</p>
							<div class="ban-plus">
								<img src="<?php echo $payment['image']; ?>" alt="" class="img-media">
								<input type="hidden"
								       value="<?php echo $payment['image']?>"
								       name="payment[<?php echo $key?>][image]"
								       class="path-img field-admin-var"
								       data-name="image">
								<button class="wp_media">Выбрать(изменить) изображение</button>
								<button class="wp_media_delete">Удалить</button>
							</div>
						</div>
						<div class="ban-list">
							<p>Текст</p>
							<textarea class="field-admin-var"
							          name="payment[<?php echo $key?>][text]"
							          data-name="text"><?php echo $payment['text']; ?></textarea>
						</div>
					</div>
				</div>
				<?php
				$i++;
			}
		}
		else { ?>
			<div class="ban-slide ban-active">
				<div class="ban-title">
					<p class="title-slide-banner">Баннер №<span class="number-slide">1</p>
					<svg class="show_uslug" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" version="1.1" viewBox="0 0 129 129" enable-background="new 0 0 129 129" width="512px" height="512px">
						<g>
							<path d="m121.3,34.6c-1.6-1.6-4.2-1.6-5.8,0l-51,51.1-51.1-51.1c-1.6-1.6-4.2-1.6-5.8,0-1.6,1.6-1.6,4.2 0,5.8l53.9,53.9c0.8,0.8 1.8,1.2 2.9,1.2 1,0 2.1-0.4 2.9-1.2l53.9-53.9c1.7-1.6 1.7-4.2 0.1-5.8z" fill="#FFFFFF"/>
						</g>
					</svg>
					<svg class="delete_banner" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" version="1.1" id="Capa_1" x="0px" y="0px" viewBox="0 0 31.112 31.112" style="enable-background:new 0 0 31.112 31.112;" xml:space="preserve" width="512px" height="512px">
                        <polygon points="31.112,1.414 29.698,0 15.556,14.142 1.414,0 0,1.414 14.142,15.556 0,29.698 1.414,31.112 15.556,16.97   29.698,31.112 31.112,29.698 16.97,15.556 " fill="red"/>
                    </svg>
				</div>
				<div class="ban-content">
					<div class="ban-list">
						<p>Изображение</p>
						<div class="ban-plus">
							<img src="" alt="" class="img-media">
							<input type="hidden"
							       name="payment[0][image]"
							       class="path-img field-admin-var"
							       data-name="image">
							<button class="wp_media">Выбрать(изменить) изображение</button>
							<button class="wp_media_delete">Удалить</button>
						</div>
					</div>
					<div class="ban-list">
						<p>Текст</p>
						<textarea class="field-admin-var"
						          name="payment[0][text]"
						          data-name="text"></textarea>
					</div>
				</div>
			</div>
			<?php
		}
		?>
	</div>
	<button class="add_banner_style add_banner" data-name-Array="payment">Добавить банер</button>
<?php }

add_action('save_post', 'metatest_save');
function metatest_save($post_id){
	if ( ! isset( $_POST['payment']) )
		return;

	if ( ! wp_verify_nonce( $_POST['myplugin_noncename'], plugin_basename(__FILE__) ) )
		return;

	$payment = $_POST['payment'];
	$payment_new_arr = [];
	foreach ($payment as $key => $item) {
		$item = array_filter($item);
		if(!empty($item)){
			$payment_new_arr[] = array_filter($item);
		}
	}

	update_post_meta($post_id,'payment',$payment_new_arr);
}


function lower_text_payment_showup(){
	wp_nonce_field( plugin_basename(__FILE__), 'myplugin_noncename' );

	$post_id = get_the_ID();
	$lower_text = get_post_meta($post_id,'lower_text',true);
	?><div style="display:flex">
	<div>
		<div class="ban-list">
			<p>Для вашего удобства...</p>
			<textarea class="field-admin-var" name="lower_text" data-name="text_banner"><?php echo $lower_text ?></textarea>
		</div>
	</div>
	</div><?php
}

add_action('save_post', 'lower_text_payment_save');
function lower_text_payment_save($post_id){
	if ( ! isset( $_POST['lower_text']) )
		return;

	$lower_text = $_POST['lower_text'];

	update_post_meta($post_id,'lower_text',$lower_text);
}

/* Метaбокс "Онлайн-оплата"  */

function upper_text_cases_showup(){
	wp_nonce_field( plugin_basename(__FILE__), 'myplugin_noncename' );

	$post_id = get_the_ID();
	$upper_text = get_post_meta($post_id,'upper_text',true);
	$online_text = get_post_meta($post_id,'online_text',true);
	$online_upper = get_post_meta($post_id,'online_upper',true);
	$online_upper_first = get_post_meta($post_id,'online_upper_first',true);
	$online_upper_three = get_post_meta($post_id,'online_upper_three',true);
	?>
	<div>
	<div class="ban-list">
		<h1>Онлайн-оплата</h1>
		<input type="text" name="online_text" value="<?php echo $online_text ?>">
		<p>Вы оплачиваете заказ онлайн...</p>
		<textarea class="field-admin-var" name="upper_text[main]" data-name="text_banner"><?php echo !empty($upper_text['main']) ?  $upper_text['main'] : '' ?></textarea>
		<p>Принимаются к оплате...</p>
		<textarea class="field-admin-var" name="upper_text[two]" data-name="text_banner"><?php  echo !empty($upper_text['two']) ?  $upper_text['two'] : '' ?></textarea>
	</div>
	<h1>Картинки "Онлайн-оплаты" часть 1</h1>
	<div class="gallery-container" data-type="online_upper_first"> <?php
		echo '<div class="container-gallery">';
		if(!$online_upper_first){

		}else{
			foreach ($online_upper_first as $key => $online_gallery_first ) {
				echo '<div class="item-gallery">
                                    <img src="'.$online_gallery_first.'" alt="">
                                    <svg class="delete_image_g" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" version="1.1" id="Capa_1" x="0px" y="0px" viewBox="0 0 31.112 31.112" style="enable-background:new 0 0 31.112 31.112;" xml:space="preserve" width="512px" height="512px">
                                            <polygon points="31.112,1.414 29.698,0 15.556,14.142 1.414,0 0,1.414 14.142,15.556 0,29.698 1.414,31.112 15.556,16.97   29.698,31.112 31.112,29.698 16.97,15.556 " fill="#175642"></polygon>
                                        </svg>
                                    <input type="hidden" name="online_upper_first[]" value="'.$online_gallery_first.'"/>
                            </div>';
			}
		}
		echo '</div>';
		echo '<button class="add_banner_style add_image">Добавить изображение</button>';
		?>
	</div>
	<p>Текст после первой части картинок</p>
	<textarea class="field-admin-var" name="upper_text[image_txt_one]" data-name="text_banner"><?php  echo !empty($upper_text['image_txt_one']) ?  $upper_text['image_txt_one'] : '' ?></textarea>
	<h1>Картинки "Онлайн-оплаты" часть 2</h1>
	<div class="gallery-container" data-type="online_upper"> <?php
		echo '<div class="container-gallery">';
		if(!$online_upper){

		}else{
			foreach ($online_upper as $key => $online_gallery ) {
				echo '<div class="item-gallery">
                                <img src="'.$online_gallery.'" alt="">
                                <svg class="delete_image_g" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" version="1.1" id="Capa_1" x="0px" y="0px" viewBox="0 0 31.112 31.112" style="enable-background:new 0 0 31.112 31.112;" xml:space="preserve" width="512px" height="512px">
                                        <polygon points="31.112,1.414 29.698,0 15.556,14.142 1.414,0 0,1.414 14.142,15.556 0,29.698 1.414,31.112 15.556,16.97   29.698,31.112 31.112,29.698 16.97,15.556 " fill="#175642"></polygon>
                                    </svg>
                                <input type="hidden" name="online_upper[]" value="'.$online_gallery.'"/>
                        </div>';
			}
		}
		echo '</div>';
		echo '<button class="add_banner_style add_image">Добавить изображение</button>';
		?>
	</div>
	<p>Текст после второй части картинок</p>
	<textarea class="field-admin-var" name="upper_text[image_txt_two]" data-name="text_banner"><?php  echo !empty($upper_text['image_txt_two']) ?  $upper_text['image_txt_two'] : '' ?></textarea>
	<h1>Картинки "Онлайн-оплаты" часть 3</h1>
	<div class="gallery-container" data-type="online_upper_three"> <?php
		echo '<div class="container-gallery">';
		if(!$online_upper_three){

		}else{
			foreach ($online_upper_three as $key => $online_gallery_three ) {
				echo '<div class="item-gallery">
                                    <img src="'.$online_gallery_three.'" alt="">
                                    <svg class="delete_image_g" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" version="1.1" id="Capa_1" x="0px" y="0px" viewBox="0 0 31.112 31.112" style="enable-background:new 0 0 31.112 31.112;" xml:space="preserve" width="512px" height="512px">
                                            <polygon points="31.112,1.414 29.698,0 15.556,14.142 1.414,0 0,1.414 14.142,15.556 0,29.698 1.414,31.112 15.556,16.97   29.698,31.112 31.112,29.698 16.97,15.556 " fill="#175642"></polygon>
                                        </svg>
                                    <input type="hidden" name="online_upper_three[]" value="'.$online_gallery_three.'"/>
                            </div>';
			}
		}
		echo '</div>';
		echo '<button class="add_banner_style add_image">Добавить изображение</button>';
		?>
	</div>
	<div> <?php
		echo "<h3>Нижний текст</h3>";
		isset($upper_text['editor']) ? $upper_text['editor'] : $upper_text['editor'] = '';
		wp_editor($upper_text['editor'], 'editor', array(
			'wpautop'       => 1,
			'media_buttons' => 1,
			'textarea_name' => 'upper_text[editor]',
			'textarea_rows' => 20,
			'tabindex'      => null,
			'editor_css'    => '',
			'editor_class'  => '',
			'teeny'         => 0,
			'dfw'           => 0,
			'tinymce'       => 1,
			'quicktags'     => 1,
			'drag_drop_upload' => false
		) ); ?>
	</div>
	</div><?php
}


add_action('save_post', 'upper_text_cases_save');
function upper_text_cases_save($post_id){
	if ( ! isset( $_POST['online_text'],$_POST['upper_text'],
		$_POST['online_upper'],$_POST['online_upper_first'],$_POST['online_upper_three'] ) )
		return;

	$online_text = $_POST['online_text'];
	$upper_text = $_POST['upper_text'];
	$online_upper = $_POST['online_upper'];
	$online_upper_first = $_POST['online_upper_first'];
	$online_upper_three = $_POST['online_upper_three'];

	update_post_meta($post_id,'upper_text',$upper_text);
	update_post_meta($post_id,'online_text',$online_text);
	update_post_meta($post_id,'online_upper',$online_upper);
	update_post_meta($post_id,'online_upper_first',$online_upper_first);
	update_post_meta($post_id,'online_upper_three',$online_upper_three);
}

/*                Метабокс первой таблицы                   */

function main_callback(){
	$post_id = get_the_ID();
	$upper_table = get_post_meta($post_id,'upper_table',true);
	empty($upper_table) ? $upper_table = [] : $upper_table;
	echo "<h3>Первый блок</h3>";
	isset($upper_table['first']) ? $upper_table['first'] : $upper_table['first'] = '';
	wp_editor($upper_table['first'], 'first', array(
		'wpautop'       => 1,
		'media_buttons' => 1,
		'textarea_name' => 'upper_table[first]',
		'textarea_rows' => 20,
		'tabindex'      => null,
		'editor_css'    => '',
		'editor_class'  => '',
		'teeny'         => 0,
		'dfw'           => 0,
		'tinymce'       => 1,
		'quicktags'     => 1,
		'drag_drop_upload' => false
	) );

	echo "<h3>Второй блок</h3>";
	isset($upper_table['second']) ? $upper_table['second'] : $upper_table['second'] = '';
	wp_editor($upper_table['second'], 'second', array(
		'wpautop'       => 1,
		'media_buttons' => 1,
		'textarea_name' => 'upper_table[second]',
		'textarea_rows' => 20,
		'tabindex'      => null,
		'editor_css'    => '',
		'editor_class'  => '',
		'teeny'         => 0,
		'dfw'           => 0,
		'tinymce'       => 1,
		'quicktags'     => 1,
		'drag_drop_upload' => false
	) );

	echo "<h3>Третий блок</h3>";
	isset($upper_table['third']) ? $upper_table['third'] : $upper_table['third'] = '';
	wp_editor($upper_table['third'], 'third', array(
		'wpautop'       => 1,
		'media_buttons' => 1,
		'textarea_name' => 'upper_table[third]',
		'textarea_rows' => 20,
		'tabindex'      => null,
		'editor_css'    => '',
		'editor_class'  => '',
		'teeny'         => 0,
		'dfw'           => 0,
		'tinymce'       => 1,
		'quicktags'     => 1,
		'drag_drop_upload' => false
	) );

	echo "<h3>Четвертый блок</h3>";
	isset($upper_table['four']) ? $upper_table['four'] : $upper_table['four'] = '';
	wp_editor($upper_table['four'], 'four', array(
		'wpautop'       => 1,
		'media_buttons' => 1,
		'textarea_name' => 'upper_table[four]',
		'textarea_rows' => 20,
		'tabindex'      => null,
		'editor_css'    => '',
		'editor_class'  => '',
		'teeny'         => 0,
		'dfw'           => 0,
		'tinymce'       => 1,
		'quicktags'     => 1,
		'drag_drop_upload' => false
	) );

}

add_action('save_post', 'main_receiving_save');
function main_receiving_save($post_id){
	if ( ! isset( $_POST['upper_table'] ) )
		return;

	$upper_table = $_POST['upper_table'];

	update_post_meta($post_id,'upper_table',$upper_table);
}

/*                     Метабокс второй таблицы               */
function delivery_callback(){
	wp_nonce_field( plugin_basename(__FILE__), 'myplugin_noncename' );

	$post_id = get_the_ID();
	$lower_table = get_post_meta($post_id,'lower_table',true);
	empty($lower_table) ? $lower_table = [] : $lower_table; ?>
	<h3>Первые две ячейки</h3>
	<div>
		<div>
			<h3>Первая ячейка</h3>
			<textarea class="field-admin-var" name="lower_table[work]" data-name="text_banner"><?php echo !empty($lower_table['work']) ?  $lower_table['work'] : '' ?></textarea>
		</div>
		<div>
			<h3>Вторая ячейка</h3>
			<textarea class="field-admin-var" name="lower_table[time]" data-name="text_banner"><?php echo !empty($lower_table['time']) ?  $lower_table['time'] : '' ?></textarea>
		</div>

	</div>
	<?php
	echo "<h3>Первый блок</h3>";
	isset($lower_table['first']) ? $lower_table['first'] : $lower_table['first'] = '';
	wp_editor($lower_table['first'], 'first_delivery', array(
		'wpautop'       => 1,
		'media_buttons' => 1,
		'textarea_name' => 'lower_table[first]',
		'textarea_rows' => 20,
		'tabindex'      => null,
		'editor_css'    => '',
		'editor_class'  => '',
		'teeny'         => 0,
		'dfw'           => 0,
		'tinymce'       => 1,
		'quicktags'     => 1,
		'drag_drop_upload' => false
	) );

	echo "<h3>Второй блок</h3>";
	isset($lower_table['second']) ? $lower_table['second'] : $lower_table['second'] = '';
	wp_editor($lower_table['second'], 'second_delivery', array(
		'wpautop'       => 1,
		'media_buttons' => 1,
		'textarea_name' => 'lower_table[second]',
		'textarea_rows' => 20,
		'tabindex'      => null,
		'editor_css'    => '',
		'editor_class'  => '',
		'teeny'         => 0,
		'dfw'           => 0,
		'tinymce'       => 1,
		'quicktags'     => 1,
		'drag_drop_upload' => false
	) );

	echo "<h3>Третий блок</h3>";
	isset($lower_table['third']) ? $lower_table['third'] : $lower_table['third'] = '';
	wp_editor($lower_table['third'], 'third_delivery', array(
		'wpautop'       => 1,
		'media_buttons' => 1,
		'textarea_name' => 'lower_table[third]',
		'textarea_rows' => 20,
		'tabindex'      => null,
		'editor_css'    => '',
		'editor_class'  => '',
		'teeny'         => 0,
		'dfw'           => 0,
		'tinymce'       => 1,
		'quicktags'     => 1,
		'drag_drop_upload' => false
	) );

	echo "<h3>Четвертый блок</h3>";
	isset($lower_table['four']) ? $lower_table['four'] : $lower_table['four'] = '';
	wp_editor($lower_table['four'], 'four_delivery', array(
		'wpautop'       => 1,
		'media_buttons' => 1,
		'textarea_name' => 'lower_table[four]',
		'textarea_rows' => 20,
		'tabindex'      => null,
		'editor_css'    => '',
		'editor_class'  => '',
		'teeny'         => 0,
		'dfw'           => 0,
		'tinymce'       => 1,
		'quicktags'     => 1,
		'drag_drop_upload' => false
	) );

	echo "<h3>Самовывоз</h3>";
	isset($lower_table['pickup']) ? $lower_table['pickup'] : $lower_table['pickup'] = '';
	wp_editor($lower_table['pickup'], 'pickup_delivery', array(
		'wpautop'       => 1,
		'media_buttons' => 1,
		'textarea_name' => 'lower_table[pickup]',
		'textarea_rows' => 20,
		'tabindex'      => null,
		'editor_css'    => '',
		'editor_class'  => '',
		'teeny'         => 0,
		'dfw'           => 0,
		'tinymce'       => 1,
		'quicktags'     => 1,
		'drag_drop_upload' => false
	) );
}

add_action('save_post', 'delivery_terms_save');
function delivery_terms_save($post_id){
	if ( ! isset( $_POST['lower_table'] ) )
		return;

	$lower_table = $_POST['lower_table'];

	update_post_meta($post_id,'lower_table',$lower_table);
}
