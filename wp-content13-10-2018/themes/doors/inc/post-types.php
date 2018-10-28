<?php
add_action('init', 'my_custom_init');
function my_custom_init(){
	register_post_type('events', array(
		'labels'             => array(
			'name'               => 'События',
			'singular_name'      => 'События',
			'add_new'            => 'Добавить событие',
			'add_new_item'       => 'Добавить событие',
			'edit_item'          => 'Редактировать событие',
			'new_item'           => 'Новое событие',
			'view_item'          => 'Посмотреть событие',
			'search_items'       => 'Найти событие',
			'not_found'          => 'Событий не найдено',
			'not_found_in_trash' => 'В корзине событий не найдено',
			'parent_item_colon'  => '',
			'menu_name'          => 'События'
		),
		'public'             => true,
		'publicly_queryable' => true,
		'show_ui'            => true,
		'show_in_menu'       => true,
		'query_var'          => true,
		'rewrite'            => true,
		'capability_type'    => 'post',
		'has_archive'        => true,
		'hierarchical'       => false,
		'menu_position'      => null,
		'supports'           => array('title','editor', 'thumbnail','excerpt'),
        'taxonomies'          => array( )
	) );

	register_post_type('products', array(
		'labels'             => array(
			'name'               => 'Приборы',
			'singular_name'      => 'Приборы',
			'add_new'            => 'Добавить прибор',
			'add_new_item'       => 'Добавить прибор',
			'edit_item'          => 'Редактировать прибор',
			'new_item'           => 'Новый прибор',
			'view_item'          => 'Посмотреть прибор',
			'search_items'       => 'Найти прибор',
			'not_found'          => 'Приборов не найдено',
			'not_found_in_trash' => 'В корзине приборов не найдено',
			'parent_item_colon'  => '',
			'menu_name'          => 'Приборы'
		),
		'public'             => true,
		'publicly_queryable' => true,
		'show_ui'            => true,
		'show_in_menu'       => true,
		'query_var'          => true,
		'rewrite'            => true,
		'capability_type'    => 'post',
		'has_archive'        => true,
		'hierarchical'       => false,
		'menu_position'      => null,
		'supports'           => array('title','editor', 'thumbnail')
	) );

	register_post_type('applyings', array(
		'labels'             => array(
			'name'               => 'Применения',
			'singular_name'      => 'Применения',
			'add_new'            => 'Добавить применение',
			'add_new_item'       => 'Добавить применение',
			'edit_item'          => 'Редактировать применение',
			'new_item'           => 'Новое применение',
			'view_item'          => 'Посмотреть применение',
			'search_items'       => 'Найти применение',
			'not_found'          => 'Применений не найдено',
			'not_found_in_trash' => 'В корзине применений не найдено',
			'parent_item_colon'  => '',
			'menu_name'          => 'Применения'
		),
		'public'             => true,
		'publicly_queryable' => true,
		'show_ui'            => true,
		'show_in_menu'       => true,
		'query_var'          => true,
		'rewrite'            => true,
		'capability_type'    => 'post',
		'has_archive'        => true,
		'hierarchical'       => false,
		'menu_position'      => null,
		'supports'           => array('title','editor','thumbnail','excerpt','comments')
	) );

	register_post_type('ads_article', array(
		'labels'             => array(
			'name'               => 'Объявления',
			'singular_name'      => 'Объявления',
			'add_new'            => 'Добавить объявление',
			'add_new_item'       => 'Добавить объявление',
			'edit_item'          => 'Редактировать объявление',
			'new_item'           => 'Новое объявление',
			'view_item'          => 'Посмотреть объявление',
			'search_items'       => 'Найти объявление',
			'not_found'          => 'Объявлений не найдено',
			'not_found_in_trash' => 'В корзине объявлений не найдено',
			'parent_item_colon'  => '',
			'menu_name'          => 'Объявления'
		),
		'public'             => true,
		'publicly_queryable' => true,
		'show_ui'            => true,
		'show_in_menu'       => true,
		'query_var'          => true,
		'rewrite'            => true,
		'capability_type'    => 'post',
		'has_archive'        => true,
		'hierarchical'       => false,
		'menu_position'      => null,
		'supports'           => array('title','editor','thumbnail','excerpt')
	) );

	register_post_type('library', array(
		'labels'             => array(
			'name'               => 'Библиотека',
			'singular_name'      => 'Библиотека',
			'add_new'            => 'Добавить статью',
			'add_new_item'       => 'Добавить статью',
			'edit_item'          => 'Редактировать статью',
			'new_item'           => 'Новая статья',
			'view_item'          => 'Посмотреть статью',
			'search_items'       => 'Найти статью',
			'not_found'          => 'Статей не найдено',
			'not_found_in_trash' => 'В корзине статей не найдено',
			'parent_item_colon'  => '',
			'menu_name'          => 'Библиотека'
		),
		'public'             => true,
		'publicly_queryable' => true,
		'show_ui'            => true,
		'show_in_menu'       => true,
		'query_var'          => true,
		'rewrite'            => true,
		'capability_type'    => 'post',
		'has_archive'        => true,
		'hierarchical'       => false,
		'menu_position'      => null,
		'supports'           => array('title','editor','thumbnail','excerpt', 'author')
	) );

	register_post_type('orders', array(
		'labels'             => array(
			'name'               => 'Заказы',
			'singular_name'      => 'Заказы',
			'add_new'            => 'Добавить заказ',
			'add_new_item'       => 'Добавить заказ',
			'edit_item'          => 'Редактировать заказ',
			'new_item'           => 'Новый заказ',
			'view_item'          => 'Посмотреть заказ',
			'search_items'       => 'Найти заказ',
			'not_found'          => 'Заказов не найдено',
			'not_found_in_trash' => 'В корзине заказов не найдено',
			'parent_item_colon'  => '',
			'menu_name'          => 'Заказы'
		),
		'public'             => true,
		'publicly_queryable' => true,
		'show_ui'            => true,
		'show_in_menu'       => true,
		'query_var'          => true,
		'rewrite'            => true,
		'capability_type'    => 'post',
		'has_archive'        => true,
		'hierarchical'       => false,
		'menu_position'      => null,
		'supports'           => array('title')
	) );

    register_post_type('subscription', [
        'labels'             => [
            'name'               => 'Подписки',
            'singular_name'      => 'Подписки',
            'add_new'            => 'Добавить подписку',
            'add_new_item'       => 'Добавить подписку',
            'edit_item'          => 'Редактировать подписку',
            'new_item'           => 'Новая подписка',
            'view_item'          => 'Посмотреть подписку',
            'search_items'       => 'Найти подписку',
            'not_found'          => 'Подписок не найдено',
            'not_found_in_trash' => 'В корзине подписок не найдено',
            'parent_item_colon'  => '',
            'menu_name'          => 'Подписки'
        ],
        'public'             => true,
        'publicly_queryable' => true,
        'show_ui'            => true,
        'show_in_menu'       => true,
        'query_var'          => true,
        'rewrite'            => true,
        'capability_type'    => 'post',
        'has_archive'        => true,
        'hierarchical'       => false,
        'menu_position'      => null,
        'supports'           => ['title']
    ] );
}

add_action( 'init', 'create_event_taxonomies' );
function create_event_taxonomies(){
	$category_library = array(
		'name' => 'Категории',
		'singular_name' => 'Категория',
		'search_items' =>  'Поиск категорий',
		'all_items' => 'Все категории',
		'parent_item' => 'Родительская категория',
		'parent_item_colon' => 'Родительская категория:',
		'edit_item' => 'Редактировать категорию',
		'update_item' => 'Обновить категоию',
		'add_new_item' => 'Добавить новую категорию',
		'new_item_name' => 'Имя новой категории',
		'menu_name' => 'Категории',
	);

	register_taxonomy('category_library', array('library'), array(
		'hierarchical' => true,
		'labels' => $category_library,
		'show_ui' => true,
		'query_var' => true,
		'rewrite' => array( 'slug' => 'category_library' ),
	));

	register_taxonomy('events_category', array('events'), array(
		'hierarchical' => true,
		'labels' => $category_library,
		'show_ui' => true,
		'query_var' => true,
		'rewrite' => array( 'slug' => 'events_category' ),
	));
}
