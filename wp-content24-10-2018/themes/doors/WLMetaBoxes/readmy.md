**WLMetaBoxes**

WLMetaBoxes - это библиотека позволяющая реализовать удобную систему боксов за короткое время.

Текущая версия Version 1.2

Изменена структура аргементов передаваемых в фунцию.
P.S: Перепишите структура под новые стандарты

**Установка**

1. Скачайте или склонируйте библиотеку в свою папку с темой.
2. Подключите файл WLMetaBoxes.php в файле function.php.
Пример: require_once 'WLMetaBoxes/WLMetaBoxes.php';

**Использование**

WL_create_meta_box($args)

Создает MetaBox по указанным критериям.

**Шаблон использования**

    $args = [
        'location_mb' => 'post',
        'name_mb' => 'Дополнительная инфа',
        'fields' => [
            [
                'field' => 'gallery',
                'post_meta_array'  => 'gallery',
                'button_add_name' => 'Добавить изображение',
            ],
            [
                'field' => 'label',
                'text'  => '<h3>Мега заголовок</h3>'
            ],
            [
                'field' => 'repeater',
                'post_meta_array'  => 'slides_one',
                'slide_name' => 'Слайд2',
                'button_add_name' => 'Добавить слайд',
                'slides' => [
                    [
                        'field' => 'color',
                        'post_meta' => 'color'
                    ],
                    [
                        'field' => 'text',
                        'post_meta' => 'contact',
                        'label' => 'Контакты'
                    ]
                ]
            ],
            [
                'field' => 'repeater',
                'post_meta_array'  => 'slides_oner',
                'slide_name' => 'Слайд1',
                'button_add_name' => 'Добавить слайд1',
                'slides' => [
                    [
                        'field' => 'checkbox',
                        'post_meta' => 'checkbox',
                        'label' => 'Цве123123т'
                    ],
                    [
                        'field' => 'text',
                        'post_meta' => 'contact',
                        'label' => 'Контак1231231ты'
                    ]
                ]
            ],
            [
                'field' => 'color',
                'post_meta' => 'color',
                'label' => 'Цвет'
            ]
        ]
    ];

WL_create_meta_box($args);

**Аргументы параметра $args**

location_mb _(строка/массив)_
    Место где будет находится блок:
   
    1. post
    2. page
    3. post_type (кастомный пост)
    4. example_template.php (Шаблон страницы)

name_mb _(строка)_
    Заголовок/название блока
        
fields _(массив)_ 
    Поля для блока:
    
    field _(строка)_
        Какой тип поля или блока нужно вывести:
        
        Поля:
        
         1. label - обычный или форматированный текст)
         1. text - тег input c типом text;
         2. checkbox - тег input c типом checkbox;
         3. textarea - тег textarea;
         4. wp_editor - блок для вставки редактируемого текста.
         5. image - блок для добавления картинки.
         6. color - поле для выбора цвета
         
         Блоки:
         1. repeater - вывод неограниченого количество слайдов(Включает в сбея поля, описсанные выше)
         2. gallery - вывод блока галереи
    
    post_meta _(строка)_ (Для полей)
        Ключ мета поля
    
    text _(строка)_ (Для поля label)
        Текст поля
        
    label _(строка)_
        Заголовок поля

    post_meta_array _(строка)_ (Только для блоков)
        Ключ мета поля массива
    
    slide_name _(строка)_ (Только для блака repeater)
        Заголовок для слайда
    
    button_add_name _(строка)_ (Только для блоков)
        Заголовок для кнопки добавления слайда
    
    

**Примеры**

coming soon

**Обновления**

Version 1.2
-Изменен параметр location_mb

Version 1.1
-Глобально изменена структура
-Добавлено новое поле label

Version 1.03
-Исправлена ошибка блока repeater.

Version 1.02 
-Добавлен новый тип бокса Gallery.

Version 1.02 
-Добавлено новое поле Color-picker.

Version 1.01 
-Добавлена поддержка шаблонов для блоков.

Version 1.00 - Релиз