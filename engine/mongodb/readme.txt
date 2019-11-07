Собственно здесь инструкция как безболезненно подключить mongodb ,так чтобы ничего не наебнулось.
Этап 1.
Как известно для того чтобы mongodb заработала,нужно несколько условий.
Установленная mongodb . Туториал для установки под ubuntu находится здесь https://docs.mongodb.com/manual/tutorial/install-mongodb-on-ubuntu/ 
Установленное расширение для php mongodb.so https://pecl.php.net/package/mongodb
Если все сделано окей,то дальше вам нужно прописать следующие команды
cd frame 
composer  require --prefer-dist yiisoft/yii2-mongodb
Дальше нужно прописать в файл /frame/config/web.php  в раздел components добавить следующее 
       'mongodb' => [
            'class' => '\yii\mongodb\Connection',
            'dsn' => 'mongodb://localhost:27017/cms_test',       ],
Этап 2 
Дальше просто копируем папку /frame/mongodb/mg/ в папку /frame/plugins/mg  
Ну а дальше все работает и все прекрасно


Этап не обязательный. По умолчанию система требует наличия mysql ,в случае если вы хотите полностью отказаться от mysql.

вам необходимо скопировать файлы из /frame/mongodb/db/ в папку /frame/db с заменой. 

После этого  все хранение полностью перейдет на Mongodb.

Кстати не забудьте убрать данные для подключения из /frame/config/web.php
Не забудьте в /config.php в ключ массива backend добавить значение 'ismongodb'=>true


Команды с помощью которых можно делать импорт\экспорт БД

mongodump -d technoistudio -o dump Для импорта используйте mongorestore --db dbname pathtodb/ --username login_db --password password_db

