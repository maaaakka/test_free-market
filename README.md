# test_free-market

## 環境構築
**Dockerビルド**
1. 作業ディレクトリの作成
test_contact-form
├── docker
│   ├── nginx
│   │   └── default.conf
│   └── php
│       ├── Dockerfile
│       └── php.ini
├── docker-compose.yml
└── src
    └── index.php
`cd test_contact-form`
`mkdir docker`
`mkdir docker/nginx`
`mkdir docker/php`
`touch docker/nginx/default.conf`
`touch docker/php/Dockerfile`
`touch docker/php/php.ini`
`mkdir src`
`touch src/index.php`
`touch docker-compose.yml`

2. 設定ファイルの作成
・docker-compose.yml
version: '3.8'

services:
    nginx:
        image: nginx:1.21.1
        ports:
            - "80:80"
        volumes:
            - ./docker/nginx/default.conf:/etc/nginx/conf.d/default.conf
            - ./src:/var/www/
        depends_on:
            - php

    php:
        build: ./docker/php
        volumes:
            - ./src:/var/www/

    mysql:
        image: mysql:8.0.26
        environment:
            MYSQL_ROOT_PASSWORD: root
            MYSQL_DATABASE: laravel_db
            MYSQL_USER: laravel_user
            MYSQL_PASSWORD: laravel_pass
        command:
            mysqld --default-authentication-plugin=mysql_native_password
        volumes:
            - ./docker/mysql/data:/var/lib/mysql
            - ./docker/mysql/my.cnf:/etc/mysql/conf.d/my.cnf

    phpmyadmin:
        image: phpmyadmin/phpmyadmin
        environment:
            - PMA_ARBITRARY=1
            - PMA_HOST=mysql
            - PMA_USER=laravel_user
            - PMA_PASSWORD=laravel_pass
        depends_on:
            - mysql
        ports:
            - 8080:80

・/docker/nginx/default.conf
server {
    listen 80;
    index index.php index.html;
    server_name localhost;

    root /var/www/public;

    location / {
        try_files $uri $uri/ /index.php$is_args$args;
    }

    location ~ \.php$ {
        fastcgi_split_path_info ^(.+\.php)(/.+)$;
        fastcgi_pass php:9000;
        fastcgi_index index.php;
        include fastcgi_params;
        fastcgi_param SCRIPT_FILENAME $document_root$fastcgi_script_name;
        fastcgi_param PATH_INFO $fastcgi_path_info;
    }
}

・docker/php/Dockerfile
FROM php:8.1-fpm

COPY php.ini /usr/local/etc/php/

RUN apt update \
  && apt install -y default-mysql-client zlib1g-dev libzip-dev unzip \
  && docker-php-ext-install pdo_mysql zip

RUN curl -sS https://getcomposer.org/installer | php \
  && mv composer.phar /usr/local/bin/composer \
  && composer self-update

WORKDIR /var/www

・docker/php/php.ini
date.timezone = "Asia/Tokyo"

[mbstring]
default_charset = "UTF-8"
mbstring.language = "Japanese"

3. `docker-compose up -d --build`


**Laravel環境構築**
1. DockerDesktopアプリを立ち上げる
2. `docker-compose exec php bash`
3. `composer -v`
4. `composer create-project "laravel/laravel=8.*" . --prefer-dist`
5. `ls`
6. http://localhost/
アクセスしてLaravelのウェルカムページに行けるか確認

7. 時間編集config/app.php70行目あたりの
'timezone' => 'UTC',　があるか確認。
8. `php artisan tinker`
9. `echo Carbon\Carbon::now();`で時間確認
10. 時間などズレていたら6の部分を
'timezone' => 'Asia/Tokyo',　に変更
11. `exit`で一度抜けてもう一度`docker-compose exec php bash`
12. 7,8を再度行い、正しい時間になればOK
> *それでも時間が合わない場合`php artisan config:clear`を実行すると設定が反映される

13. `docker-compose exec mysql bash`でMySQLへアクセス
14. `mysql -u root -p`でrootユーザで入るパスワードを入力
15. `show databases;`
+--------------------+
| Database           |
+--------------------+
| information_schema |
| laravel_db         |
+--------------------+
2 rows in set (0.21 sec)
このような形でMYSQL_DATABASEで設定したlarravel_dbが作成されているか確認
16. .envの編集
```text
DB_CONNECTION=mysql
DB_HOST=mysql
DB_PORT=3306
DB_DATABASE=laravel_db
DB_USERNAME=laravel_user
DB_PASSWORD=laravel_pass
```

17. `exit`で抜けて`docker-compose exec php bash`でphpコンテナへ入る

18. `php artisan migrate`テーブル作成のためマイグレーション

19. `php artisan storage:link`シンボリックリンク作成

20. `php artisan db:seed`シーディングの実行

21. `php artisan key:generate`アプリケーションキーの作成


**新規リポジトリ作成**
1. 新しく作成したらSSHが選択されていることを確認

2. `git init`
   `git add .`
   `git commit -m "コミットメッセージ"`
   `git remote add <gitのremoteURL>`
   `git push origin main`

3. `git stats`
   `git add .`


## 使用技術(実行環境)
- PHP8.3.0
- Laravel8.83.27
- MySQL8.0.26

## ER図
![alt]

## URL
- 開発環境：http://localhost/
- phpMyAdmin：http://localhost:8080/
