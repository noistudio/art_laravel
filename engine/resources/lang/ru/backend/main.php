<?php

return [
    'adminmenu' => 'Админ меню',
    'colors' => 'Настройки',
    'access_rules' => 'Права доступа',
    'change_password' => 'Изменить пароль',
    'exit' => 'Выход',
    'home' => 'Главная',
    'language' => 'Язык',
    'logout' => 'Выход',
    'title' => 'Административная панель',
    'setup_title' => 'Основные настройки',
    'setup_copyright' => 'Копирайты',
    'setup_css' => 'Внешний вид',
    'setup_link' => 'URL разработчика',
    'setup_save' => 'Сохранить',
    'backups_link' => 'Бекапы',
    'backups' => 'Список бекапов',
    'backup_name' => 'Имя',
    'backup_date' => 'Дата',
    'backup_size' => 'Размер',
    'backup_delete' => 'Удалить',
    'backup_download' => 'Скачать',
    'backup_create' => 'Создать бекап',
    'full_backup' => 'Полный бекап',
    'only_db' => 'Только База данных',
    'backup_faq1' => ' Как создать бекап в mongodb',
    'backup_faq2' => '  С помощью команды 
                        mongodump -d ИМЯБАЗЫДАННЫх -o dump ',
    'backup_faq3' => 'Как импортировать  бекап в БД',
    'backup_faq4' => '<p>В случае если вам нужно выполнить импорт из файла в формате .archive ,выполните следующую команду:</p>
                        <p>mongorestore --archive=название_файла_в_формате.archive --db ИМЯБАзыДАнных</p>
                        <p>В случае если дамп находится в папке,то </p>
                        <p>mongorestore --db dbname pathtodb/ --username login_db --password password_db</p>',
    'debug_mode' => 'Режим дебаг',
    'enable' => 'Включен',
    'disable' => 'Выключен',
    'status_site' => 'Статус сайта',
    'disable_message' => 'Сообщение когда выключен',
    'about' => 'О продукте',
    'seo_title_page' => 'SEO Теги Главной страницы',
    'default_lang' => 'По умолчанию',
    'incorrect_l_p' => 'Вы ввели некорректный login или пароль',
];

