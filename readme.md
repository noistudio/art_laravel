###### Библиотека ART для Laravel 6 . 

Библиотека создана в целях упрощения веб-разработки как таковой сведя всю основную рутину в утиль. 
Для этого доступен широкий арсенал средств и функционала. 

Библиотека разработана для Laravel 6 и тестировалась только на нем. Поддерживаемые БД mysql\mongodb

Автор https://noi.studio   

Библиотека включает в себя следующий функционал:

1.Отдельная админ.панель с настраиваемой ссылкой для доступа.
   Настраивается в /engine/.env 
     BACKEND_ACCESS=/artadmin

    BACKEND_ADMIN_LOGIN=admin

	BACKEND_ADMIN_PASSWORD=admin


2.Возможность для конфигурирования меню в автоматическом режиме через событие /adminmenu\events\EventAdminLink

3.Возможность ручной настройки ссылок  в админке через встроенный в админ.панель функционал управления меню

4.Система управления меню,которая включает в себя  также возможность вызова меню по шорткоду [menu]

5.Функционал управления админстраторами,в котором имеется возможность создавать админские правила,как в ручном режиме редактирования через админ.панель,
также и автоматически через событие \admins\events\EventAdminRule

6. Система блоков, которая включает в себя возможность создания  различных типов блоков. В данный момент в системе имеются
 следующие основные  типы блоков:

**html блок** - блок в котором вы можете вставить любой html код,и он выведется  в
 любом месте где вы его вставите,например через шорткод [block] или через редактор https://editorjs.io/

**динамический блок editor.js** -  блок в  котором вы создаете разметку 
с помощью обычного html и используете внутренний синтаксис,который показан на скриншоте 

![](https://i.imgur.com/vEK6WtP.png)

На скриншоте показан пример создания слайдера из трех изображений.
В редакторе это будет выглядеть следующим образом

![](https://i.imgur.com/cyLpPro.png)

**редактор  https://editorjs.io/** -  блок в котором вы можете комбинировать 
между собой элементы editorjs.io а также блоков созданных в системе

**показать форму** - блок в котором вы можете вызвать созданную форму,к созданной 
форме можно указать отдельный шаблон
![](https://i.imgur.com/tF6QqLs.png)

**показать раздел**  - показывает (таблицу или коллекцию) в зависимости от используемой
 базы данных (mysql\mongodb) в блоке можно настроить все основные параметры по которым должен фильтроваться контент

![](https://i.imgur.com/ZvPYCb0.png)

**показать меню** - созданное меню ,так же можно вывести с помощью блока,в блоке можно указать 
отдельный шаблон для меню

![](https://i.imgur.com/Xyd9WlO.png)

**показать документ**  - показывает выбранный документ из  (таблицы или коллекции) в 
зависимости от используемой базы данных (mysql\mongodb) в блоке можно настроить шаблон для блока.

![](https://i.imgur.com/4YDFqda.png)

**Все блоки расширяются с помощью события \blocks\events\BlockType**

7.Формы

![](https://i.imgur.com/5o6qKL7.png)

При создании формы выбираете поля нужных типов,а дальше уже вам все сгенерируется с помощью встроенных подсказок.

![](https://i.imgur.com/X4VK0Cc.png)

При успешной отправке,имеется возможность указывать шаблон ответа как в админке ,так и через файл 

![](https://i.imgur.com/zf8nQzd.png)

Помимо этого имеется возможность создания своей бизнес логики,внутри одной формы

![](https://i.imgur.com/BVfDCQg.png)

8.Контент

С  помощью админки можно создать таблицу( или коллекцию) с нужными типами полей и связать их с другой таблицей. Пример как это делается на картинке ниже
![](https://i.imgur.com/WMpIBhy.png)
Работает это с mysql\mongodb 

При создании таблицы,автоматически создается список для просмотра в админке данных из таблицы,возможность создать документ,обновить документ,удалить документ.

Имеется возможность изменить логику фильтра в списке  

mysql создать класс Table в директории /content/tables с наследованием от \content\tables\_DefaultTable.php

mongodb создать класс Table в директории /mg/collections с наследованием от mg\collections\_DefaultCollection.php

Вместо Table указывать название коллекции\таблицы которое название класса должно начинаться с большой буквы.
9.Файлы 

Для управления файлами,используются модуль https://github.com/barryvdh/laravel-elfinder
10.Логи

Модуль для создания параметров логирования  через админ.панель
![](https://i.imgur.com/CyFIciC.png)

Для просмотра файлов логов используется https://github.com/krishnakodoth/logEditor

11.Параметры 

Хранения динамических параметров которые определяются с админ.панели

Для хранения используются файловая БД https://github.com/Greg0/Lazer-Database

12.Настройки SEO 

Механизм с помощью которого можно настраивать SEO параметры для каждой отдельной страницы 

![](https://i.imgur.com/BHFUMTp.png)

Для вывода на фронте используется https://github.com/artesaos/seotools




## Часть 1 Как установить библиотеку

Для начала вам нужно установить git,php7.3+,mysql,imagick 


Дальше введите следующую комманду 

git clone https://noistudio@bitbucket.org/noistudio/laravel_better.git . 

cd engine 

composer create-project 

После этого у вас все должно установиться.

Откройте ваш проект по адресу http://localsite/install 

после установки ваша админка должна быть доступна по адресу

http://localsite/artadmin/index 

логин admin пароль admin


Параметры доступа в  админку можете поменять в /engine/.env

### Как установить версию mongodb 

Для того чтобы установить монгу  вам нужно подключить библиотеку https://github.com/jenssegers/laravel-mongodb

Скопировать папку /extra/mg в /engine/plugins/mg

После этого вам нужно раскоментировать все события связанные с /mg/ 

в файле /engine/Providers/EventServiceProvider.php


После этого в .env файле прописать данные для монги.

Если вам нужно сделать так чтобы все работало только на МонгоДБ
 в .env файле ,вам нужно поставить DB_CONNECTION=mongodb

После этого вам нужно закоментировать все события связанные с /content/ 
в файле /engine/Providers/EventServiceProvider.php
Для того чтобы закрыть /install для доступа создайте пустой файл /engine/storage/installed



В данном продукте используются следующие компоненты :

https://editorjs.io/ - сам редактор и его плагины

https://github.com/artesaos/seotools 

https://github.com/barryvdh/laravel-elfinder

https://packagist.org/packages/codex-team/editor.js

https://packagist.org/packages/froiden/laravel-installer

https://packagist.org/packages/greg0/lazer-database - без этого пакета ничего бы не было )

https://packagist.org/packages/krishnakodoth/log-editor

https://packagist.org/packages/laravelium/sitemap

https://github.com/pietrocinaglia/laraupdater

https://packagist.org/packages/silviolleite/laravelpwa

https://github.com/spatie/laravel-backup


# Сайт автора https://noi.studio



















