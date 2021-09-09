### Arbuz site server

Установить Docker и Docker Compose:

Install Docker Engine

https://docs.docker.com/get-docker/

https://docs.docker.com/engine/install/ubuntu/

Install Docker Compose

https://docs.docker.com/compose/install/

Установить make:
`sudo apt install make`

Убедиться, что порт 36001 не занят другим сервисом, на этот порт будет проброшен mysql. Запустить для установки, инициализации проекта:

`make install`

Указать окружение yii framework (0 - Development), подтвердить применение миграций, задать для пользователя email, password и роль: root

Для обновления приложения после git pull:

`make`

------------------------------------------

Другие команды:

Применить миграции:

`make migrate`

Создать пользователя:

`make user`


Старт приложения:

`make up`

Остановка приложения: 

`make down`

Рестарт:

`make restart`

-----------------------------------------

Configure mysql Db connection in ./common/config/main-local.php

Начальные настройки, указанные ниже, вынесены в environments, и будут применены при инициализации приложения автоматически.

```
'db' => [

            'class' => 'yii\db\Connection',
            'dsn' => 'mysql:host=mysql;dbname=arbuz_site',
            'username' => 'arbuz_site',
            'password' => 'arbuz_site',
            'charset' => 'utf8',
        ],
```

--------------------------------
        
Установка зависимостей с помощью Composer, если не указывать пользователя и группу, то все действия в докере будут осуществляться от root

Run composer install as you user:group owner:

`make composer-install`

or

`docker-compose exec -u ${UID}:${UID} frontend composer install -n`

or as root:

`docker-compose exec frontend composer install -n`

or

`docker-compose exec -u 0 frontend composer install -n`

------------------------------------

Инициализация приложения

Init yii app:

`make frontend-init`

`docker-compose exec -u ${UID}:${UID} frontend php init`

После инициализации докер контейнеров, необходимо время (до 1 мин) для того чтобы Mysql был поднят, до этого буду возникать ошибки базы данных. Запуск миграций:

`make migrate`

or

`docker-compose exec frontend php yii migrate`

Миграции можно создавать через докер контейнер или напрямую через php-cli установленный в системе, но надо следить за версиями php
Для создания новой миграции с помощью make: 

`make migrate-create filename=create_users_table`

Или напрямую через docker-compose

`docker-compose exec -u ${UID}:${UID} frontend php yii migrate/create new_migration_filename`

По умолчанию, все действия в докере осуществляются от root, если необходимо, для изменения владельца файла выполнить:

`sudo chown user:group ./console/migrations/m210319_142146_new_migration_filename.php`

--------------------------------

Create user with root role:

`make user`

Или

`docker-compose exec frontend php yii user/create`

--------------------------------

Generate security keys:

`ssh-keygen -t rsa -b 4096 -m PEM -f ./core/api/storage/jwtRS256.key`

Don't add passphrase

`chmod 644 ./core/api/storage/jwtRS256.key`

`openssl rsa -in ./core/api/storage/jwtRS256.key -pubout -outform PEM -out ./core/api/storage/jwtRS256.key.pub`

-------------------------------

Typing `make up` or `docker-compose up -d` starts the containers in the background and leaves them running

Run api http://localhost:23080 in the browser

Running `docker-compose down` stops containers

-------------------------------

In the DBeaver adjust MySql driver:
allowPublicKeyRetrieval true
useSSL                  false
