<?php  
if ( ! defined( 'ABSPATH' ) ) {
    exit; // Exit if accessed directly.
}
class DoorsMainclass{
	private static $initiated = false;

    public static function doc_init() {
        if (!self::$initiated) {
            self::doc_init_hooks();
        }
    }

   //  Active plugin
    public static function doc_install(){
        global $wpdb;
        require_once( ABSPATH . 'wp-admin/includes/upgrade.php' );

        $database_prefix = $wpdb->get_blog_prefix();

        $table_category = $database_prefix . 'doors_category';
        $table_series = $database_prefix . 'doors_series';
        $table_models = $database_prefix . 'doors_models';

        $table_params = $database_prefix . 'doors_params';
        $table_params_series = $database_prefix . 'doors_params_series';
        $table_type_params = $database_prefix . 'doors_type_params';
        $table_value_p = $database_prefix . 'doors_value_p';
        $table_visible_param = $database_prefix . 'doors_visible_param';
        $table_available_param = $database_prefix . 'doors_available_param';
        $table_available_param_series = $database_prefix . 'doors_available_param_series';
        $table_blocked = $database_prefix . 'doors_blocked';

        $table_decoration =  $database_prefix . 'doors_decoration';
        $charset_collate = "DEFAULT CHARACTER SET {$wpdb->charset} COLLATE {$wpdb->collate}";


        $sql = "DROP TABLE IF EXISTS $table_category ";
        $wpdb->query($sql);

        $sql_category = "CREATE TABLE {$table_category} (
                                  id int(11) NOT NULL auto_increment,
                                  name varchar(255) NOT NULL,
                                  PRIMARY KEY  (id)
                                  )
                                  {$charset_collate};";
        dbDelta($sql_category);

        $wpdb->insert(
            $table_category,
            [ 'name' => 'street'],
            [ '%s', '%d' ]
        );
        $wpdb->insert(
            $table_category,
            [ 'name' => 'house'],
            [ '%s', '%d' ]
        );

        $sql_series = "CREATE TABLE {$table_series} (
                                id int(11) NOT NULL auto_increment,
                                name varchar(255) NOT NULL default '',
                                visible BOOL DEFAULT 0 NOT NULL,
                                category_id int(11) NOT NULL default 1,
                                PRIMARY KEY  (id)
                                )
                                {$charset_collate};";
        dbDelta($sql_series);

        $sql_models = "CREATE TABLE {$table_models} (
                            id int(11) NOT NULL auto_increment,
                            name varchar(255) NOT NULL default '',
                            visible BOOL DEFAULT 0 NOT NULL,
                            series_id int(11) NOT NULL default 0,
                            PRIMARY KEY  (id)
                            )
                            {$charset_collate};";
        dbDelta($sql_models);

        $sql_decoration = "CREATE TABLE {$table_decoration} (
            id int(11) NOT NULL auto_increment,
            name varchar(255) NOT NULL default '',
            price BIGINT(20) NOT NULL default 0,
            visible BOOL DEFAULT 0 NOT NULL,
            model_id int(11) NOT NULL,
            photo_front varchar(255) NOT NULL default '',
            photo_back varchar(255) NOT NULL default '',              
            PRIMARY KEY (id)
            )
            {$charset_collate};";
        dbDelta($sql_decoration);

        $sql_params = "CREATE TABLE {$table_params} (
                        id int(11) NOT NULL auto_increment,
                        name varchar(255) NOT NULL default '',
                        type_id int(11) NOT NULL default 0,,
                        block_id int(11) NOT NULL default 0,
                        PRIMARY KEY  (id)
                        )
                        {$charset_collate};";
        dbDelta($sql_params);

        $sql_params_series = "CREATE TABLE {$table_params_series} (
                        param_id int(11) NOT NULL default 0,
                        series_id int(11) NOT NULL default 0,
                        available_values text NOT NULL default ''
                        )
                        {$charset_collate};";
        dbDelta($sql_params_series);

        $sql = "DROP TABLE IF EXISTS $table_type_params ";
        $wpdb->query($sql);

        $sql_type_params = "CREATE TABLE {$table_type_params} (
                    id int(11) NOT NULL auto_increment,
                    type varchar(255) NOT NULL default '',
                    PRIMARY KEY  (id)
                    )
                    {$charset_collate};";
        dbDelta($sql_type_params);


        $wpdb->insert(
            $table_type_params,
            [ 'type' => 'Текстовое поле'],
            [ '%s', '%d' ]
        );
        $wpdb->insert(
            $table_type_params,
            [ 'type' => 'Выпадающий список'],
            [ '%s', '%d' ]
        );
        $wpdb->insert(
            $table_type_params,
            [ 'type' => 'Выпадающий список (цвета)'],
            [ '%s', '%d' ]
        );
        $wpdb->insert(
            $table_type_params,
            [ 'type' => 'Радио-кнопка (Да/Нет)'],
            [ '%s', '%d' ]
        );

        $sql_value_p = "CREATE TABLE {$table_value_p} (
            id int(11) NOT NULL auto_increment,
            name varchar(255) not null default '',
            price double not NULL default 0,
            param_id int(11) NOT NULL default 0,
            PRIMARY KEY  (id)
            )
            {$charset_collate};";
        dbDelta($sql_value_p);

        $sql_visible_param = "CREATE TABLE {$table_visible_param} (
            param_id int(11) NOT NULL default 0,
            decor_id int(11) NOT NULL default 0,
            visible BOOL DEFAULT 0 NOT NULL
            )
            {$charset_collate};";
        dbDelta($sql_visible_param);

        $sql_available_param_series = "CREATE TABLE {$table_available_param_series} (
            id int(11) NOT NULL auto_increment,
            value_id int(11) NOT NULL default 0,
            series_id int(11) NOT NULL default 0,
            PRIMARY KEY  (id)
            )
            {$charset_collate};";
        dbDelta($sql_available_param_series);

        $sql_available_param = "CREATE TABLE {$table_available_param} (
            param_id int(11) NOT NULL default 0,
            visible int(11) NOT NULL default 0,
            id int(11) NOT NULL auto_increment,
            decor_id int(11) NOT NULL default 0,
            def_value text NOT NULL default '',
            available_decor_values text NOT NULL default '',
            PRIMARY KEY  (id)
            )
            {$charset_collate};";
        dbDelta($sql_available_param);

        $sql_blocked = "CREATE TABLE {$table_blocked} (
            id int(11) NOT NULL auto_increment,
            param_id int(11) NOT NULL default 0,
            value_id int(11) NOT NULL default 0,
            param_block_id int(11) NOT NULL default 0,
            decor_id int(11) NOT NULL default 0,
            PRIMARY KEY  (id)
            )
            {$charset_collate};";
        dbDelta($sql_blocked);

    }


    //  Uninstall plugin
    public static function doc_uninstall () {
       global $wpdb;
       

        $database_prefix = $wpdb->get_blog_prefix();

        $table_category = $database_prefix . 'doors_category';
        $table_series = $database_prefix . 'doors_series';
        $table_models = $database_prefix . 'doors_models';

        $table_params = $database_prefix . 'doors_params';
        $table_params_series = $database_prefix . 'doors_params_series';
        $table_type_params = $database_prefix . 'doors_type_params';
        $table_value_p = $database_prefix . 'doors_value_p';
        $table_visible_param = $database_prefix . 'doors_visible_param';
        $table_available_param = $database_prefix . 'doors_available_param';
        $table_available_param_series = $database_prefix . 'doors_available_param_series';
        $table_blocked = $database_prefix . 'doors_blocked';

        $table_decoration =  $database_prefix . 'doors_decoration';

        $sql = "DROP TABLE IF EXISTS $table_category ";
        $wpdb->query($sql);
       
        $sql = "DROP TABLE IF EXISTS $table_series ";
        $wpdb->query($sql);
       
        $sql = "DROP TABLE IF EXISTS $table_models ";
        $wpdb->query($sql);
       
        $sql = "DROP TABLE IF EXISTS $table_params ";
        $wpdb->query($sql);
       
        $sql = "DROP TABLE IF EXISTS $table_params_series ";
        $wpdb->query($sql);
       
        $sql = "DROP TABLE IF EXISTS $table_type_params ";
        $wpdb->query($sql);
       
        $sql = "DROP TABLE IF EXISTS $table_value_p ";
        $wpdb->query($sql);
       
        $sql = "DROP TABLE IF EXISTS $table_visible_param ";
        $wpdb->query($sql);
       
        $sql = "DROP TABLE IF EXISTS $table_available_param_series ";
        $wpdb->query($sql);
       
        $sql = "DROP TABLE IF EXISTS $table_blocked ";
        $wpdb->query($sql);
    }

	  //  Initializes WordPress hooks.
    public static function doc_init_hooks() {
        add_action('admin_menu', array(__CLASS__, 'doors_create_menu'));

        wp_enqueue_style('blocks-style', DOC_PLUGIN_URL . 'assets/css/wp.css', array());

        wp_enqueue_style( 'frontend-css', DOC_PLUGIN_URL . '/assets/css/frontend.css' );

        wp_enqueue_script( 'frontend-js', DOC_PLUGIN_URL . '/assets/js/frontend.js', array('jquery') );
        wp_enqueue_script( 'backendadm-js', DOC_PLUGIN_URL . 'assets/js/backend.js', array('jquery') );
        wp_localize_script( 'frontend-js', 'MyAjax', array( 'ajaxurl' => admin_url( 'admin-ajax.php' ) ) );
		

        add_action( 'admin_enqueue_scripts', [__CLASS__, 'arthur_load_scripts_admin' ]);

        add_action('admin_print_footer_scripts', [__CLASS__, 'handlersSeries'], 99);
        add_action( 'wp_ajax_delete_row', [__CLASS__, 'delete_row'] );
        add_action( 'wp_ajax_delete_rule', [__CLASS__, 'delete_rule'] );
        add_action( 'wp_ajax_update_decoration', [__CLASS__, 'update_decoration'] );
        add_action( 'wp_ajax_get_values_for_blocking', [__CLASS__, 'get_values_for_blocking'] );
        add_action( 'wp_ajax_get_fields_for_blocking', [__CLASS__, 'get_fields_for_blocking'] );
        add_action( 'wp_ajax_update_name_series', [__CLASS__, 'update_name_series'] );
        add_action( 'wp_ajax_update_name_models', [__CLASS__, 'update_name_models'] );
        add_action( 'wp_ajax_update_visible', [__CLASS__, 'update_visible'] );
        add_action( 'wp_ajax_create_parameters', [__CLASS__, 'create_parameters'] );
        add_action( 'wp_ajax_add_param_to_series', [__CLASS__, 'add_param_to_series'] );
        add_action( 'wp_ajax_add_param_elements', [__CLASS__, 'add_param_elements'] );
        add_action( 'wp_ajax_remove_param_elements', [__CLASS__, 'remove_param_elements'] );
        add_action( 'wp_ajax_add_param_to_decor', [__CLASS__, 'add_param_to_decor'] );
        add_action( 'wp_ajax_add_available_value', [__CLASS__, 'add_available_value'] );
        add_action( 'wp_ajax_delete_value_to_decor', [__CLASS__, 'delete_value_to_decor'] );
        add_action( 'wp_ajax_add_default_available_value', [__CLASS__, 'add_default_available_value'] );
        add_action( 'wp_ajax_get_values_from_block_param', [__CLASS__, 'get_values_from_block_param'] );
        add_action( 'wp_ajax_add_block_param', [__CLASS__, 'add_block_param'] );
        add_action( 'wp_ajax_add_value_to_param', [__CLASS__, 'add_value_to_param'] );
        add_action( 'wp_ajax_remove_value_to_param', [__CLASS__, 'remove_value_to_param'] );
        add_action( 'wp_ajax_remove_parameters', [__CLASS__, 'remove_parameters'] );
        add_action('admin_menu', 'remove_admin_menu');
        function remove_admin_menu() {
            remove_menu_page('tools.php'); // Инструменты
            remove_menu_page('edit.php'); // Посты блога
            remove_menu_page('edit.php?post_type=page'); // Страницы
            remove_menu_page('edit-comments.php'); // Комментарии   
            remove_menu_page('link-manager.php'); // Ссылки
        }
    }

    public static function arthur_load_scripts_admin() {
        // WordPress library
        wp_enqueue_media();
    }

    // Create Doors menu in admin page
    public static function doors_create_menu() {
        add_menu_page( 'Серии', 'Серии', 'manage_options', 'door_series', [__CLASS__, 'door_series_show'], '
dashicons-admin-home' );
        add_submenu_page('options.php',
            'Одиночная страница серии',
            'Одиночная страница серии',
            'manage_options',
            'series_single',
            [__CLASS__, 'door_series_single_show']
	    );
        add_menu_page( 'Модели', 'Модели', 'manage_options', 'door_models', [__CLASS__, 'door_models_show'], 'dashicons-admin-appearance' );
        add_submenu_page('options.php',
            'Одиночная страница модели',
            'Одиночная страница модели',
            'manage_options',
            'models_single',
            [__CLASS__, 'door_models_single_show']
        );
        add_menu_page( 'Параметры', 'Параметры', 'manage_options', 'door_parameters', [__CLASS__, 'door_parameters_show'], 'dashicons-editor-spellcheck' );
        add_submenu_page('options.php',
            'Одиночная страница параметра',
            'Одиночная страница параметра',
            'manage_options',
            'parameters_single',
            [__CLASS__, 'door_parameters_single_show']
        );
        add_submenu_page('options.php',
            'Одиночная страница отделки',
            'Одиночная страница отделки',
            'manage_options',
            'parameters_decor',
            [__CLASS__, 'door_decoration_show']
        );
    }

    //  Show Series
    public static function door_series_show() {
        self::doc_view('admin/series');
    }

    //  Show and save Series single
    public static function door_series_single_show() {
        global $wpdb;
        $table_series = $wpdb->get_blog_prefix() . 'doors_series';

        if(isset($_POST['series_id']) && $_POST['series_id'] != 0){

            $show = isset($_POST['show']) ? $_POST['show'] : 0;

            $result = $wpdb->update(
                $table_series,
                [ 'name' => wp_unslash( $_POST['name']), 'visible' => $show ],
                [ 'id' => $_POST['series_id'] ]
            );
            echo (!empty($result)) ? '<p class="success-db">Серия успешно обновлена</p>' : '<p class="error-db">Ошибка сохранения</p>';
        }
        elseif (isset($_POST['category_id'])) {

            $show = isset($_POST['show']) ? $_POST['show'] : 0;
            $category_id = $_POST['category_id'];

            $result = $wpdb->insert(
                $table_series,
                [ 'name' => wp_unslash($_POST['name']), 'visible' => $show, 'category_id' => $category_id ],
                [ '%s', '%d' ]
            );

            echo (!empty($result)) ? '<p class="success-db">Серия успешно сохранена</p>' : '<p class="error-db">Ошибка сохранения</p>';

        }

        self::doc_view('admin/series-single');
    }

    //  Show Models
    public static function door_models_show() {
        self::doc_view('admin/models');
    }

    //  Show and save Models single
    public static function door_models_single_show() {
        if (isset($_POST['series_id'])) {

            global $wpdb;

            $name = wp_unslash($_POST['name']);
            $show = isset($_POST['show']) ? $_POST['show'] : 0;
            $series_id = $_POST['series_id'];

            $table_series = $wpdb->get_blog_prefix() . 'doors_models';

            $result = $wpdb->insert(
                $table_series,
                [ 'name' => $name, 'series_id' => $series_id, 'visible' => $show ],
                [ '%s', '%d' ]
            );

            echo (!empty($result)) ? '<p class="success-db">Модель успешно сохранена</p>' : '<p class="error-db">Ошибка сохранения</p>';

        }

        self::doc_view('admin/models-single');
    }

    //  Show and save Decoration single
    public static function door_decoration_show() {
        global $wpdb;
        $table_decor = $wpdb->get_blog_prefix() . 'doors_decoration';

        if(isset($_POST['decor_id']) && $_POST['decor_id'] != 0){
            $show = isset($_POST['show']) ? $_POST['show'] : 0;

            $result = $wpdb->update(
                $table_decor,
                [
                    'name' => wp_unslash($_POST['name']),
                    'price' => $_POST['price'],
                    'visible' => $show,
                    'photo_front' => $_POST['front-side'],
                    'photo_back' => $_POST['back-side']
                ],
                [ 'id' => $_POST['decor_id'] ]
            );

            echo '<p class="success-db">Отделка успешно обновлена</p>';
        }
        elseif (isset($_POST['id-model'])) {
            
            $name =wp_unslash( $_POST['name']);
            $id_model = $_POST['id-model'];
            $price = $_POST['price'];
            $show = isset($_POST['show']) ? $_POST['show'] : 0;

            $result = $wpdb->insert(
                $table_decor,
                [
                    'name' => $name,
                    'visible' => $show,
                    'price' => $price,
                    'model_id' => $id_model,
                    'photo_front' => $_POST['front-side'],
                    'photo_back' => $_POST['back-side']
                ],
                [ '%s', '%d' ]
            );


            echo (!empty($result)) ? '<p class="success-db">Отделка успешно сохранена</p>' : '<p class="error-db">Ошибка сохранения</p>';

        }

        self::doc_view('admin/decoration-single');
    }

    //  Show Parameters
    public static function door_parameters_show() {
        self::doc_view('admin/parameters');
    }

    //  Show and save Models single
    public static function door_parameters_single_show() {
        if (isset($_POST['category_id'])) {

            global $wpdb;

            $name = wp_unslash($_POST['name']);
            $show = isset($_POST['show']) ? $_POST['show'] : 0;
            $category_id = $_POST['category_id'];

            $table_series = $wpdb->get_blog_prefix() . 'doors_series';

            $result = $wpdb->insert(
                $table_series,
                [ 'name' => $name, 'visible' => $show, 'category_id' => $category_id ],
                [ '%s', '%d' ]
            );

            echo (!empty($result)) ? '<p class="success-db">Серия успешно сохранена</p>' : '<p class="error-db">Ошибка сохранения</p>';

        }

        self::doc_view('admin/parameters-single');
    }

    //  Show content settings
    public static function doc_show_content () {
            
        if (isset($_POST['check'])) {

            if ($_POST['check'] == true) {
                global $wpdb;

                $title = $_POST['title'];
                $content = $_POST['content'];
                $placeholder = $_POST['placeholder'];
                $button_name = $_POST['button_name'];
                $popup_ok = $_POST['popup_ok'];
                $popup_error = $_POST['popup_error'];
                $subject = $_POST['subject'];
                $message = $_POST['message'];

                $table_name = $wpdb->get_blog_prefix() . 'doc_form_table';


                $result = $wpdb->update( $table_name,
                    array( 'title' => $title, 'content' => $content,'placeholder' => $placeholder,'button_name' => $button_name,
                'popup_ok'=>$popup_ok,'popup_error'=>$popup_error,'subject' => $subject,'message' => $message), 
                    array( 'id' => 1 ),
                    array( '%s', '%s', '%s', '%s','%s','%s','%s','%s'),
                    array( '%d' )
                );
			     
             
                echo (!empty($result)) ? '<p class="success-db">Settings have been saved</p>' : '<p class="error-db">Error</p>';
    
            }
        }
        self::doc_view('admin/admin');
    }

    // Get template for admin page
    public static function doc_view ( $name) {
        $path = DOC_PLUGIN_DIR . 'views/'. $name . '-template.php';
        include( $path );
    }

    // Ger Series
    public static function getSeries($category_id = '') {
        global $wpdb;
        $table_name = $wpdb->get_blog_prefix() . 'doors_series';
        if($category_id != ''){
            $result = $wpdb->get_results( "SELECT * FROM {$table_name} WHERE category_id={$category_id}" );
        }
        else {
            $result = $wpdb->get_results( "SELECT * FROM {$table_name}" );
        }
        return $result;
    }

    public static function showSeriesRow($series) {
        foreach ($series as $street) {
            global $wpdb;
            $table_models = $wpdb->get_blog_prefix() . 'doors_models';
            $count_models = intval($wpdb->get_var("SELECT COUNT(id) FROM {$table_models} WHERE series_Id={$street->id}"));
            ?>

            <tr data-id="<?php echo $street->id; ?>" data-type="series">
                <td class="visible-series">
                    <input type="checkbox" name="visible" value="1" <?php checked(1, $street->visible); ?>>
                </td>
                <td class="name-series">
                    <a href="admin.php?page=series_single&category_id=<?php echo $street->category_id; ?>&series_id=<?php echo $street->id; ?>">
                        <?php echo $street->name; ?>
                    </a>
                </td>
                <td>
                    <?php echo $count_models; ?>
                </td>
                <td>
                    <span class="street_redact" data-popup="redact_street" >
                        <svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" x="0px" y="0px"
                             width="15px" height="15px" viewBox="0 0 528.899 528.899" style="enable-background:new 0 0 528.899 528.899;"
                             xml:space="preserve">
                            <g>
                                <path d="M328.883,89.125l107.59,107.589l-272.34,272.34L56.604,361.465L328.883,89.125z M518.113,63.177l-47.981-47.981
                                    c-18.543-18.543-48.653-18.543-67.259,0l-45.961,45.961l107.59,107.59l53.611-53.611
                                    C532.495,100.753,532.495,77.559,518.113,63.177z M0.3,512.69c-1.958,8.812,5.998,16.708,14.811,14.565l119.891-29.069
                                    L27.473,390.597L0.3,512.69z"/>
                            </g>
                        </svg>
                    </span>
                </td>
                <td>
                    <span class="delete_row">
                        <svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" height="15px" width="15px" x="0px" y="0px"
                             viewBox="0 0 486.4 486.4" style="enable-background:new 0 0 486.4 486.4;" xml:space="preserve">
                            <g>
                                <g>
                                    <path d="M446,70H344.8V53.5c0-29.5-24-53.5-53.5-53.5h-96.2c-29.5,0-53.5,24-53.5,53.5V70H40.4c-7.5,0-13.5,6-13.5,13.5
                                        S32.9,97,40.4,97h24.4v317.2c0,39.8,32.4,72.2,72.2,72.2h212.4c39.8,0,72.2-32.4,72.2-72.2V97H446c7.5,0,13.5-6,13.5-13.5
                                        S453.5,70,446,70z M168.6,53.5c0-14.6,11.9-26.5,26.5-26.5h96.2c14.6,0,26.5,11.9,26.5,26.5V70H168.6V53.5z M394.6,414.2
                                        c0,24.9-20.3,45.2-45.2,45.2H137c-24.9,0-45.2-20.3-45.2-45.2V97h302.9v317.2H394.6z"/>
                                    <path d="M243.2,411c7.5,0,13.5-6,13.5-13.5V158.9c0-7.5-6-13.5-13.5-13.5s-13.5,6-13.5,13.5v238.5
                                        C229.7,404.9,235.7,411,243.2,411z"/>
                                    <path d="M155.1,396.1c7.5,0,13.5-6,13.5-13.5V173.7c0-7.5-6-13.5-13.5-13.5s-13.5,6-13.5,13.5v208.9
                                        C141.6,390.1,147.7,396.1,155.1,396.1z"/>
                                    <path d="M331.3,396.1c7.5,0,13.5-6,13.5-13.5V173.7c0-7.5-6-13.5-13.5-13.5s-13.5,6-13.5,13.5v208.9
                                        C317.8,390.1,323.8,396.1,331.3,396.1z"/>
                                </g>
                            </g>
                        </svg>
                    </span>
                </td>
            </tr>
        <?php }
    }


    // JS Handlers
    public static function handlersSeries() {
        ?>
        <script>
            jQuery(document).ready(function($) {

                $('.limit-params.dec tr input, .limit-params.dec tr select').on('change', function(){
                    var name = $(this).attr('name'),
                        value = $(this).val(),
                        param = $(this).parents('tr').data('id'),
                        decor_id = $(this).parents('tr').data('dec-id');

                    if (name == 'visible' && $(this).is(":checked"))
                    {
                        value = 'on';
                    }
                    else{
                        value = '';
                    }

                    if (name == 'default-param')
                    {
                        value = $(this).find('option:selected').val();
                    }

                    if (name == 'available-param[]')
                    {
                        value = [];
                        $(this).find('option:selected').each(function(){
                            value.push($(this).val());
                        })
                        // value = $(this).find('option:selected').val();
                    }


                    var data = {
                            action: 'update_decoration',
                            param_id: param,
                            decor_id: decor_id,
                            name: name,
                            value: value
                        };

                    jQuery.post( ajaxurl, data, response =>{
                        console.log('response', response);
                    });

                })


                $('select[name=values-block]').on('change', function(){
                    var value = $(this).val(),
                        elem = $(this).parent().find('select[name=blocked-param]')
                        series_id = $(this).data('series_id');

                    var data = {
                            action: 'get_fields_for_blocking',
                            series_id: series_id,
                            value: value
                        };


                    jQuery.post( ajaxurl, data, response =>{
                        $(elem).html(JSON.parse(response));
                    });

                })

                // $('.add_rule').on('click', function(){
                //     error = false;
                //     $('.item-block select').each(function(){
                //         if ($(this).val() == '') {
                //             error = true
                //         }
                //     })
                //     if (error) {
                //         alert('Вы не заполнили всех полей правила! ')
                //         return false;
                //     }
                //     else{
                //         var param = $(this).parents('.item-block').find('select[name=choose-bloc-param]').val(),
                //             param_value = $(this).parents('.item-block').find('select[name=values-block]').val(),
                //             param_blocked = $(this).parents('.item-block').find('select[name=blocked-param]').val(),
                //             locked_id = (this).parents('.item-block').data('locked-id'),
                //             decor_id = (this).parents('.item-block').data('decor-id');

                //         var data = {
                //             action: 'lock_field',
                //             locked_id: locked_id,
                //             decor_id: decor_id,
                //             param: param,
                //             param_value: param_value,
                //             param_blocked: param_blocked
                //         };

                //         jQuery.post( ajaxurl, data, response =>{
                //             console.log(response);
                //         });
                //     }
                // })


                $('select[name=choose-bloc-param]').on('change', function(){
                    var value = $(this).val(),
                        elem = $(this).parent().find('select[name=values-block]')
                        decor_id = $(this).data('decor-id');

                    var data = {
                            action: 'get_values_for_blocking',
                            decor_id: decor_id,
                            value: value
                        };


                    jQuery.post( ajaxurl, data, response =>{
                        $(elem).html(JSON.parse(response));
                        console.log('response', response);
                    });

                })

                // Delete row
                $('.delete_row:not(.kayzp_del)').on('click', function () {
                    if(confirm('Удалить?')){
                        let id = $(this).parents('tr').data('id'),
                            type = $(this).parents('tr').data('type'),
                            series_id = $(this).parents('tr').data('series_id'),
                            data = {
                                action: 'delete_row',
                                id: id,
                                type: type,
                                series_id : series_id
                            };

                        jQuery.post( ajaxurl, data, response =>{
                            $(this).parents('tr').remove();
                        });
                    }
                });

                $('.delete_row.kayzp_del').on('click', function () {
                    if(confirm('Удалить?')){
                        let id = $(this).parents('.item-block').data('locked-id'),
                            elem = $(this).parents('.item-block'),
                            data = {
                                action: 'delete_rule',
                                id: id
                            };

                        jQuery.post( ajaxurl, data, response =>{
                            $(elem).remove();
                        });
                    }
                });

                // Update name series
                $('.series-pop').on('submit', function (e) {
                    e.preventDefault();

                    let name = $(this).find('input[name=name]').val(),
                        id_series = $(this).find('input[name=id]').val(),
                        data = {
                            action: 'update_name_series',
                            id_series: id_series,
                            name: name
                        };

                    jQuery.post( ajaxurl, data, response =>{

                        $(`tr[data-id=${id_series}]`).find('.name-series a').text(name);
                        $(this).parent().hide();
                    });
                });

                // Update name model
                $('.change_model_name').on('submit', function (e) {
                    e.preventDefault();

                    let name = $(this).find('input[name=name]').val(),
                        id_models = $(this).find('input[name=id]').val(),
                        data = {
                            action: 'update_name_models',
                            id_models: id_models,
                            name: name
                        };

                    jQuery.post( ajaxurl, data, response =>{

                        $(`tr[data-id=${id_models}]`).find('.name-series').text(name);
                        $(this).parent().hide();
                    });
                });

                // Update visible
                $('.visible-series input').on('click', function () {

                    let visible = +$(this).prop("checked"),
                        id = $(this).parents('tr').data('id'),
                        type = $(this).parents('tr').data('type'),
                        data = {
                            action: 'update_visible',
                            id: id,
                            type: type,
                            visible: visible
                        };

                    jQuery.post( ajaxurl, data, response =>{

                    });
                });

                // Create new parameters
                $('.param-pop').on('submit', function (e) {
                    e.preventDefault();

                    let name = $(this).find('input[name=name]').val(),
                        typeParameters = $(this).find('select[name=type-parameters]').val(),
                        blockParameters = $(this).find('select[name=block-parameters]').val(),
                        nameParameters = $(this).find('option:selected').text(),
                        data = {
                            action: 'create_parameters',
                            name: name,
                            typeParameters: typeParameters,
                            blockParameters: blockParameters
                        };

                    if(typeParameters == 0){
                        alert('Не выбран тип параметра!');
                        return;
                    }
                    if(blockParameters == 0){
                        alert('Не выбран блок параметра!');
                        return;
                    }

                    jQuery.post( ajaxurl, data, response =>{
                        if(response == true){
                            alert('Поле успешно добавлено!');
                            location.reload();
                        }
                        else{
                            alert('Ошибка добавления поля! Попробуйте позже')
                        }
                    });
                });

                // Add parameter to series
                $('.series-single-pop').on('submit', function (e) {
                    e.preventDefault();

                    error = false;


                    let id_param = $(this).find('select').val(),
                        nameParameters = $(this).find('option:selected').text(),
                        ids = $(this).find('option:selected').attr('data-ids'),
                        names = $(this).find('option:selected').attr('data-names'),
                        id_series = $(this).data('id'),
                        data = {
                            action: 'add_param_to_series',
                            id_param: id_param,
                            id_series: id_series
                        };

                    $('.limit-params tr td:first-child').each(function(){
                        if($(this).text() == nameParameters){
                            alert('Это поле уже добавлено!');
                            error = true;
                        }
                    })

                    if (!error) {
                        jQuery.post(
                            ajaxurl,
                            data,
                            response =>{
                                if(response != false){
                                    alert('Параметр добавлен!');
                                    location.reload();
                                }
                                else{
                                    alert('Ошибка добавления! Попробуйте позже')
                                }

                            },'json');
                        
                    }
                });

                // Add tags to parameter
                $('.params-pop input[type=submit]').on('click',function (e) {
                    e.preventDefault();
                    let tags = [];

                    $('.content-tags .tag').each(function () {
                        let elements = {},
                            id = $(this).data('id');

                        if(typeof id == "undefined"){
                            id = 0;
                        }

                        tags.push(id);
                    });

                    let id_param = $('input[name=id-param]').val(),
                        data = {
                            action: 'add_param_elements',
                            id_param: id_param,
                            tags: tags,
                            series_id: $('input[name=series_id]').val()
                        };

                    jQuery.post(
                        ajaxurl,
                        data,
                        response =>{
                            if (response != false) {
                                alert('Сохранено');
                                location.reload();
                            }
                            else{
                                alert('Ошибка добавления! Попробуйте позже.')
                            }
                        });

                });


                // Delete tag to parameter
                $('.content-tags').on('click','.tag',function(){
                    $(this).remove();
                });

                // Visible param in decor
                $('.visible-param').on('click', function () {
                    let id_param = $(this).parents('tr').data('id'),
                        id_decor = $(this).parents('tbody').data('decorId'),
                        status = +$(this).prop("checked"),
                        data = {
                            action: 'add_param_to_decor',
                            id_param: id_param,
                            status: status,
                            id_decor: id_decor
                        };

                    jQuery.post(
                        ajaxurl,
                        data,
                        response =>{
                            console.log(response);
                        },'json');
                });

                // add available value
                $('select[name=available-param]').on('change', function () {
                    let id_value = $(this).val(),
                        id_decor = $(this).parents('tbody').data('decorId'),
                        nameParameters = $(this).parent().find('option:selected').text(),
                        data = {
                            action: 'add_available_value',
                            id_value: id_value,
                            id_decor: id_decor
                        };

                    jQuery.post(
                        ajaxurl,
                        data,
                        response =>{
                            $(this).before(`
                                <span>${nameParameters}</span>
                                <span class="delete_value">
                                    <svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" height="13px" width="13px" x="0px" y="0px" viewBox="0 0 486.4 486.4" style="enable-background:new 0 0 486.4 486.4;" xml:space="preserve" fill="red">
                                        <g>
                                            <g>
                                                <path d="M446,70H344.8V53.5c0-29.5-24-53.5-53.5-53.5h-96.2c-29.5,0-53.5,24-53.5,53.5V70H40.4c-7.5,0-13.5,6-13.5,13.5
                                                    S32.9,97,40.4,97h24.4v317.2c0,39.8,32.4,72.2,72.2,72.2h212.4c39.8,0,72.2-32.4,72.2-72.2V97H446c7.5,0,13.5-6,13.5-13.5
                                                    S453.5,70,446,70z M168.6,53.5c0-14.6,11.9-26.5,26.5-26.5h96.2c14.6,0,26.5,11.9,26.5,26.5V70H168.6V53.5z M394.6,414.2
                                                    c0,24.9-20.3,45.2-45.2,45.2H137c-24.9,0-45.2-20.3-45.2-45.2V97h302.9v317.2H394.6z"></path>
                                                <path d="M243.2,411c7.5,0,13.5-6,13.5-13.5V158.9c0-7.5-6-13.5-13.5-13.5s-13.5,6-13.5,13.5v238.5
                                                    C229.7,404.9,235.7,411,243.2,411z"></path>
                                                <path d="M155.1,396.1c7.5,0,13.5-6,13.5-13.5V173.7c0-7.5-6-13.5-13.5-13.5s-13.5,6-13.5,13.5v208.9
                                                    C141.6,390.1,147.7,396.1,155.1,396.1z"></path>
                                                <path d="M331.3,396.1c7.5,0,13.5-6,13.5-13.5V173.7c0-7.5-6-13.5-13.5-13.5s-13.5,6-13.5,13.5v208.9
                                                    C317.8,390.1,323.8,396.1,331.3,396.1z"></path>
                                            </g>
                                        </g>
                                    </svg>
                                </span>`);
                            console.log(response);
                        },'json');
                });

                // remove available value
                $(document).on('click', '.delete_value', function () {
                   let decor_id = $(this).parents('tbody').data('decorId'),
                       value_id =$(this).prev().data('id'),
                       data = {
                           action: 'delete_value_to_decor',
                           decor_id: decor_id,
                           value_id: value_id
                       };

                   jQuery.post(
                        ajaxurl,
                        data,
                        response =>{
                            $(this).prev().remove();
                            $(this).remove();
                            console.log(response);
                        },'json');
                });

                // add available value
                $('select[name=default-param]').on('change', function () {
                    let id_value = $(this).val(),
                        id_param = $(this).parents('tr').data('id'),
                        id_decor = $(this).parents('tbody').data('decorId'),
                        data = {
                            action: 'add_default_available_value',
                            id_value: id_value,
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

                // Selected block param
                $(document).on('change', 'select[name=choose-bloc-param]', function () {
                    let id_param = $(this).val(),
                        id_decor = $(this).parents('.container-block').data('decorId'),
                        data = {
                            action: 'get_values_from_block_param',
                            id_param: id_param,
                            id_decor: id_decor
                        };

                    jQuery.post(
                        ajaxurl,
                        data,
                        response =>{
                            $('select[name=values-block]').empty();
                            for (item of response) {
                                $('select[name=values-block]').append(`
                                    <option value="${item['id']}" selected>
                                        ${item['name']}
                                    </option>
                                `);
                            }
                        },'json');
                });

                // Add new block param
                $(document).on('click', '.item-block button', function (e) {
                    e.preventDefault();

                    let id_param       = $('select[name=choose-bloc-param]').val(),
                        id_value       = $('select[name=values-block]').val(),
                        id_param_block = $('select[name=blocked-param]').val(),
                        id_decor       = $(this).parents('.container-block').data('decorId'),
                        data = {
                            action: 'add_block_param',
                            id_param: id_param,
                            id_value: id_value,
                            id_param_block: id_param_block,
                            id_decor: id_decor,
                        };

                    if((id_param == 0 || id_param == '') ||
                        (id_value == 0 || id_value == '') ||
                        (id_param_block == 0 || id_param_block == '')) {
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

                // Add new Value to parameter
                $('.param-value-pop').on('submit', function (e) {
                    e.preventDefault();
                    var update = document.fieldUpdateFlag;
                    document.fieldUpdateFlag = 0;
                    if(!update)
                    if ($(this).hasClass('yes') && $('table tbody tr').length > 0) {
                        alert('Нельзя добавить больше значений для данного параметра!');
                        return;
                    }

                    let id_param = $('input[name=param_id]').val(),
                        id_value = $('input[name=value_id]').val(),
                        name     = $('input[name=name]').val(),
                        price    = $('input[name=price]').val(),
                        data = {
                            action: 'add_value_to_param',
                            id_param: id_param,
                            id_value: id_value,
                            name: name,
                            price: price
                        };

                    jQuery.post(
                        ajaxurl,
                        data,
                        response =>{
                            if(response != false){
                                alert('Сохранено!');
                                location.reload();
                            }
                            else{
                                alert('Ошибка сохранения! Попробуйте позже')
                            }
                        },'json');

                });

                // remove value from parameter
                $('.delete_value_param').on('click', function () {

                    let id_value = $(this).parents('tr').data('id'),
                        data = {
                            action: 'remove_value_to_param',
                            id_value: id_value
                        };

                    jQuery.post(
                        ajaxurl,
                        data,
                        response =>{
                            alert('Удалено!');
                            $(this).parents('tr').remove();
                        },'json');
                });

                $('.remove_parameters').on('click', function () {

                    let id_value = $(this).parents('tr').data('id'),
                        data = {
                            action: 'remove_parameters',
                            id_value: id_value
                        };
                        console.log(id_value);
                    jQuery.post(
                        ajaxurl,
                        data,
                        response =>{
                            alert('Удалено!');
                            $(this).parents('tr').remove();
                        },'json');
                });
            });
        </script>
        <?php
    }

    // remove value
    public static function remove_value_to_param() {
        $id_value = $_POST['id_value'];

        global $wpdb;

        $table_value_p = $wpdb->get_blog_prefix() . 'doors_value_p';
        $result = $wpdb->delete(
            $table_value_p,
            [ 'id' => $id_value ]
        );

        exit(json_encode($result));
    }

    //remove parameters
    public static function remove_parameters() {

      global $wpdb;
      $id_value = $_POST['id_value'];
      $table_params_series = $wpdb->get_blog_prefix() . 'doors_params_series';
        $result = $wpdb->delete(
          $table_params_series,
          [ 'param_id' => $id_value ]
        );

      $id_value = $_POST['id_value'];
      $table_value_p = $wpdb->get_blog_prefix() . 'doors_value_p';
        $result = $wpdb->delete(
          $table_value_p,
          [ 'param_id' => $id_value ]
        );
      
      
      $table_params = $wpdb->get_blog_prefix() . 'doors_params';
      $result = $wpdb->delete(
          $table_params,
          [ 'id' => $id_value ]
      );

      exit(json_encode($result));
    }


    // add value
    public static function add_value_to_param() {
        $id_param = $_POST['id_param'];
        $name = wp_unslash($_POST['name']);
        $price = $_POST['price'];
        $id_value = $_POST['id_value'];

        global $wpdb;
        $table_value_p = $wpdb->get_blog_prefix() . 'doors_value_p';

        if($id_value == 0) {
            $result = $wpdb->insert(
                $table_value_p,
                [ 'name' => $name, 'price' => $price, 'param_id' => $id_param ],
                [ '%s', '%d' ]
            );
        }
        else {
            $result = $wpdb->update(
                $table_value_p,
                [ 'name' => $name, 'price' => $price ],
                [ 'id' => $id_value ]
            );
        }
        exit(json_encode($result));
    }
    public static function update_decoration() {
        $name = wp_unslash($_POST['name']);
        $value = $_POST['value'];
        $param = $_POST['param_id'];
        $decor_id = $_POST['decor_id'];


        global $wpdb;
        $item = $wpdb->get_row("SELECT * FROM wp_doors_available_param WHERE decor_id={$decor_id} AND param_id={$param}");

        // $table_value_p = $wpdb->get_blog_prefix() . 'doors_value_p';

        if(is_null($item)) {
            $result = $wpdb->insert(
                'wp_doors_available_param',
                [ 'decor_id' => $decor_id, 'param_id' => $param, 'visible' => 0, 'def_value'=> '', 'available_decor_values' => '' ],
                [ '%d', '%d', '%d', '%s', '%s']
            );
        }
        $visible = 0;
        if($name == 'visible' ){
            if ($value == 'on') {
                $visible = 1;
            }
            $result = $wpdb->update(
                'wp_doors_available_param',
                [ 'visible' => $visible ],
                [ 'decor_id' => $decor_id, 'param_id' => $param ]
            );
        }
        $def_value = '';
        if ($name == 'default-param') {
            $def_value = $value;
            $result = $wpdb->update(
                'wp_doors_available_param',
                [ 'def_value'=> $def_value ],
                [ 'decor_id' => $decor_id, 'param_id' => $param ]
            );
        }
        $available_decor_values = '';
        if ($name == "available-param[]") {
            $available_decor_values = json_encode($value);
            $result = $wpdb->update(
                'wp_doors_available_param',
                [ 'available_decor_values' => $available_decor_values ],
                [ 'decor_id' => $decor_id, 'param_id' => $param ]
            );
        }




        exit(json_encode($result));
    }

    public static function add_block_param() {
        $id_param = $_POST['id_param'];
        $id_value = $_POST['id_value'];
        $id_param_block = $_POST['id_param_block'];
        $id_decor = $_POST['id_decor'];

        global $wpdb;

        $table_blocked = $wpdb->get_blog_prefix() . 'doors_blocked';
        $wpdb->insert(
            $table_blocked,
            [ 'param_id' => $id_param, 'value_id' => $id_value, 'param_block_id' => $id_param_block, 'decor_id' => $id_decor ],
            [ '%s', '%d' ]
        );
        exit(json_encode('Сохранено!'));
    }

    public static function get_values_from_block_param() {

        $id_decor = $_POST['id_decor'];
        $id_param = $_POST['id_param'];


        global $wpdb;
        $values = [];
        // get available values
        $table_available_param = $wpdb->get_blog_prefix() . 'doors_available_param';
        $table_value_p = $wpdb->get_blog_prefix() . 'doors_value_p';

        $values_available_all = $wpdb->get_results("SELECT * FROM {$table_value_p} WHERE param_id={$id_param}");
        foreach ($values_available_all as $key => $values_available) {

            $value = $wpdb->get_row("SELECT * FROM {$table_available_param} WHERE value_id={$values_available->id} AND decor_id={$id_decor}");

            if(empty($value)) continue;

            $values[$key] = [
                    'id' => $value->value_id,
                    'name' => $values_available->name
            ];
        }
        exit(json_encode($values));
    }

    // add default available value to decor
    public static function add_default_available_value() {
        $id_value = $_POST['id_value'];
        $id_decor = $_POST['id_decor'];
        $id_param = $_POST['id_param'];

        global $wpdb;
        $result = [];

        // get available values
        $table_available_param = $wpdb->get_blog_prefix() . 'doors_available_param';
        $table_value_p = $wpdb->get_blog_prefix() . 'doors_value_p';

        $values_available_all = $wpdb->get_results("SELECT * FROM {$table_value_p} WHERE param_id={$id_param}");
        foreach ($values_available_all as $values_available) {

            $item = $wpdb->get_row("SELECT * FROM {$table_available_param} WHERE value_id={$values_available->id} AND decor_id={$id_decor}");

            $result[] = $wpdb->update(
                $table_available_param,
                [ 'is_def' => 0 ],
                [ 'value_id' => $item->value_id , 'decor_id' => $id_decor ]
            );
        }

        $wpdb->update(
            $table_available_param,
            [ 'is_def' => 1 ],
            [ 'value_id' => $id_value , 'decor_id' => $id_decor ]
        );


        exit(json_encode($result));
    }

    // add available value to decor
    public static function add_available_value() {
        $id_value = $_POST['id_value'];
        $id_decor = $_POST['id_decor'];

        global $wpdb;

        $table_available_param = $wpdb->get_blog_prefix() . 'doors_available_param';
        $result = $wpdb->insert(
            $table_available_param,
            [ 'value_id' => $id_value, 'decor_id' => $id_decor ],
            [ '%s', '%d' ]
        );

        exit(json_encode($result));
    }

    // Delete available value
    public static function delete_value_to_decor(){
        $decor_id = $_POST['decor_id'];
        $value_id = $_POST['value_id'];

        global $wpdb;

        $table_available_param = $wpdb->get_blog_prefix() . 'doors_available_param';
        $result = $wpdb->delete(
            $table_available_param,
            [ 'value_id' => $value_id, 'decor_id' => $decor_id ]
        );

        exit(json_encode($result));

    }

    // Add param to decor
    public static function add_param_to_decor() {
        $id_param = $_POST['id_param'];
        $id_decor = $_POST['id_decor'];
        $status   = $_POST['status'];
        global $wpdb;

        $table_visible_param = $wpdb->get_blog_prefix() . 'doors_visible_param';

        // check field available
        $param_visible = $wpdb->get_row("SELECT * FROM {$table_visible_param} WHERE param_id={$id_param} AND decor_id={$id_decor}");

        if(!empty($param_visible)){
            $result = $wpdb->update(
                $table_visible_param,
                [ 'visible' => $status ],
                [ 'param_id' => $id_param , 'decor_id' => $id_decor]
            );
        }
        else {
            $result = $wpdb->insert(
                $table_visible_param,
                [ 'param_id' => $id_param, 'decor_id' => $id_decor, 'visible' => $status ],
                [ '%s', '%d' ]
            );
        }
        exit(json_encode($result));
    }

    public static function remove_param_elements() {
        global $wpdb;
        $id_param = $_POST['id_param'];
        $id_value = $_POST['id_value'];

        if($id_value == 0) {
            exit();
        }
        $table_value_p = $wpdb->get_blog_prefix() . 'doors_value_p';
        $table_param_value = $wpdb->get_blog_prefix() . 'doors_param_values';

        $wpdb->delete( $table_value_p, [ 'id' => $id_value ] );
        $wpdb->delete( $table_param_value, [ 'id_value' => $id_value, 'id_param' => $id_param ] );
        exit();
    }

    // Add elements to parameters
    public static function add_param_elements() {
        global $wpdb;
        $tags = $_POST['tags'];
        $id_param = $_POST['id_param'];
        $series_id = $_POST['series_id'];
        $table_value_p = $wpdb->get_blog_prefix() . 'doors_params_series';

        // foreach ($tags as $tag) {
        $res = $wpdb->update(
            $table_value_p,
            [ 'available_values' => json_encode($tags) ],
            ['param_id' => $id_param, 'series_id' => $series_id],
            [ '%s' ],
            [ '%d', '%d' ]
        );
        exit(json_encode($res));
    }

    // Create new parameter
    public static function create_parameters() {
        global $wpdb;

        $name = wp_unslash(  $_POST['name']);
        $type_param = $_POST['typeParameters'];
        $block_param = $_POST['blockParameters'];

        $table_name = $wpdb->get_blog_prefix() . 'doors_params';
        $result = $wpdb->insert(
            $table_name,
            [ 'name' => $name, 'type_id' => $type_param, 'block_id' => $block_param ],
            [ '%s', '%d' ]
        );

        exit(json_encode($result));
    }

    // Delete row in table
    public static function delete_row() {
        global $wpdb;

        $id = $_POST['id'];
        $type = $_POST['type'];
        $series_id = $_POST['series_id'];

        $table_name = $wpdb->get_blog_prefix() . 'doors_' . $type;

        if ($type == 'params_series') {
            $result = $wpdb->delete( $table_name, ['param_id' => $id, 'series_id'=>$series_id] );
        }
        else{
            $result = $wpdb->delete( $table_name, ['id' => $id] );
        }


        exit(json_encode($result));
    }

    public static function delete_rule() {
        global $wpdb;

        $id = $_POST['id'];

        $table_name = $wpdb->get_blog_prefix() . 'doors_blocked';

        $result = $wpdb->delete( $table_name, ['id' => $id] );


        exit(json_encode($result));
    }

    public static function update_name_series() {
        global $wpdb;

        $series_id = $_POST['id_series'];
        $name = wp_unslash($_POST['name']);

        $table_name = $wpdb->get_blog_prefix() . 'doors_series';
        $result = $wpdb->update( $table_name,
            [ 'name' => $name ],
            [ 'id' => $series_id ]
        );

        exit(json_encode($result));
    }

    public static function get_values_for_blocking() {
        global $wpdb;

        $decor_id = $_POST['decor_id'];
        $value = $_POST['value'];

        $param = $wpdb->get_row("SELECT * FROM wp_doors_available_param WHERE param_id={$value} AND decor_id={$decor_id}");


        $result = '<option value="">Выберите значение</option>';
        if ($param) {
            $available_decor_values = json_decode($param->available_decor_values);
            foreach ($available_decor_values as $available_decor_value) {
                $parametr = $wpdb->get_row("SELECT * FROM wp_doors_value_p WHERE id={$available_decor_value}");
                if ($parametr) {
                    $result .= '<option value="'.$parametr->id.'">'.$parametr->name.'</option>';
                }
            }
        }
        exit(json_encode($result, JSON_UNESCAPED_UNICODE));

    }

    public static function get_fields_for_blocking() {
        global $wpdb;

        $series_id = $_POST['series_id'];
        $value = $_POST['value'];

        $params = $wpdb->get_results("SELECT * FROM wp_doors_params_series WHERE series_id={$series_id}");


        $result = '<option value="">Выберите поле</option>';
        if ($params) {
            foreach ($params as $param) {
                $parametr = $wpdb->get_row("SELECT * FROM wp_doors_params WHERE id={$param->param_id}");
                if ($parametr) {
                    $result .= '<option value="'.$parametr->id.'">'.$parametr->name.'</option>';
                }
            }
        }
        exit(json_encode($result, JSON_UNESCAPED_UNICODE));

    }

    public static function lock_field() {
        global $wpdb;

        $locked_id = $_POST['locked_id'];
        $decor_id = $_POST['decor_id'];
        $param = $_POST['param'];
        $param_value = $_POST['param_value'];
        $param_blocked = $_POST['param_blocked'];

        if ($locked_id != '') {
            $result = $wpdb->update( $table_name,
                [ 'name' => $name ],
                [ 'id' => $id_models ]
            );
        }
        else{

        }


        $params = $wpdb->get_results("SELECT * FROM wp_doors_params_series WHERE series_id={$series_id}");


        $result = '<option value="">Выберите поле</option>';
        if ($params) {
            foreach ($params as $param) {
                $parametr = $wpdb->get_row("SELECT * FROM wp_doors_params WHERE id={$param->param_id}");
                if ($parametr) {
                    $result .= '<option value="'.$parametr->id.'">'.$parametr->name.'</option>';
                }
            }
        }
        exit(json_encode($result, JSON_UNESCAPED_UNICODE));

    }

    public static function update_name_models() {
        global $wpdb;

        $id_models = $_POST['id_models'];
        $name = wp_unslash($_POST['name']);

        $table_name = $wpdb->get_blog_prefix() . 'doors_models';
        $result = $wpdb->update( $table_name,
            [ 'name' => $name ],
            [ 'id' => $id_models ]
        );

        exit(json_encode($result));
    }

    // Update checkbox visible
    public static function update_visible() {
        global $wpdb;

        $id =  $_POST['id'];
        $visible = $_POST['visible'];
        $type = $_POST['type'];

        $table_name = $wpdb->get_blog_prefix() . 'doors_' . $type;
        $result = $wpdb->update( $table_name,
            [ 'visible' => $visible ],
            [ 'id' => $id ]
        );

        exit(json_encode($result));
    }

    public static function showParameterRow($parameters) {
        global $wpdb;
        foreach ($parameters as $param) {
            $table_name = $wpdb->get_blog_prefix() . 'doors_type_params';
            $name_type_param = $wpdb->get_row( "SELECT type FROM {$table_name} WHERE id={$param->type_id}" )->type;
            ?>
            <tr data-id="<?php echo $param->id ?>">
                <td>
                    <?php echo $param->name; ?>
                </td>
                <td class="name-series">
                    <?php echo $name_type_param; ?>
                </td>
                <td>
                    <?php if($param->type_id == 2 || $param->type_id == 3) : ?>
                        <a href="admin.php?page=parameters_single&param_id=<?php echo $param->id; ?>">Редактировать</a>
                    <?php elseif($param->type_id == 4) : ?>
                        <a href="admin.php?page=parameters_single&only_one=yes&param_id=<?php echo $param->id; ?>">Редактировать</a>
                    <?php endif; ?>
                </td>
                <td>
                <span class="remove_parameters">
                    <svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" height="15px" width="15px" x="0px" y="0px"
                         viewBox="0 0 486.4 486.4" style="enable-background:new 0 0 486.4 486.4;" xml:space="preserve">
                        <g>
                            <g>
                                <path d="M446,70H344.8V53.5c0-29.5-24-53.5-53.5-53.5h-96.2c-29.5,0-53.5,24-53.5,53.5V70H40.4c-7.5,0-13.5,6-13.5,13.5
                                    S32.9,97,40.4,97h24.4v317.2c0,39.8,32.4,72.2,72.2,72.2h212.4c39.8,0,72.2-32.4,72.2-72.2V97H446c7.5,0,13.5-6,13.5-13.5
                                    S453.5,70,446,70z M168.6,53.5c0-14.6,11.9-26.5,26.5-26.5h96.2c14.6,0,26.5,11.9,26.5,26.5V70H168.6V53.5z M394.6,414.2
                                    c0,24.9-20.3,45.2-45.2,45.2H137c-24.9,0-45.2-20.3-45.2-45.2V97h302.9v317.2H394.6z"/>
                                <path d="M243.2,411c7.5,0,13.5-6,13.5-13.5V158.9c0-7.5-6-13.5-13.5-13.5s-13.5,6-13.5,13.5v238.5
                                    C229.7,404.9,235.7,411,243.2,411z"/>
                                <path d="M155.1,396.1c7.5,0,13.5-6,13.5-13.5V173.7c0-7.5-6-13.5-13.5-13.5s-13.5,6-13.5,13.5v208.9
                                    C141.6,390.1,147.7,396.1,155.1,396.1z"/>
                                <path d="M331.3,396.1c7.5,0,13.5-6,13.5-13.5V173.7c0-7.5-6-13.5-13.5-13.5s-13.5,6-13.5,13.5v208.9
                                    C317.8,390.1,323.8,396.1,331.3,396.1z"/>
                            </g>
                        </g>
                    </svg>
                </span>
                </td>
            </tr>
        <?php }
    }

    // Get Table Info
    public static function getTableInfo($table) {
        global $wpdb;
        $table_name = $wpdb->get_blog_prefix() . $table;
        $result = $wpdb->get_results( "SELECT * FROM {$table_name}" );
        return $result;
    }

    // Add field parameter to Series
    public static function add_param_to_series(){
        $id_param = $_POST['id_param'];
        $id_series = $_POST['id_series'];

        global $wpdb;

        $table_params_series = $wpdb->get_blog_prefix() . 'doors_params_series';
        $res = $wpdb->insert(
            $table_params_series,
            [ 'param_id' => $id_param, 'series_id' => $id_series ],
            [ '%s', '%d' ]
        );

        $table_param = $wpdb->get_blog_prefix() . 'doors_params';
        $parameter = $wpdb->get_row("SELECT * FROM {$table_param} WHERE id={$id_param}");

        // Get name type parameter
        $table_params_type = $wpdb->get_blog_prefix() . 'doors_type_params';
        $type_param = $wpdb->get_row("SELECT * FROM {$table_params_type} WHERE id={$parameter->type_id}");
        $type_param_name = $type_param->type;

        exit(json_encode( $res));
    }

}


