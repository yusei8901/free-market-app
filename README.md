# free-market-app

## Dockerビルド

・git clone git@github.com:yusei8901/free-market-app.git

・docker-compose up -d --build


## 環境構築

・docker-compose exec php bash

・composer install

・cp .env.example .env 環境変数を変更

※下記の「"環境変数の変更"について」を参照

・php artisan key:generate

・php artisan migrate

・php artisan db:seed

・php artisan storage:link


## "環境変数の変更"について

.env

DB_HOST = mysql

DB_DATABASE = laravel_db

DB_USERNAME = laravel_user

DB_PASSWORD = laravel_pass

MAIL_FROM_ADDRESS = no-reply@example.com

に変更

## 開発環境

・商品一覧：[http://localhost/](http://localhost/)

・ユーザー登録：[http://localhost/register](http://localhost/register)

・phpMyAdmin：[http://localhost:8080](http://localhost:8080)


## 使用技術

・PHP 8.1.33

・Laravel 8.83.29

・MySQL 8.0.26

・nginx 1.21.1

## ER図

![ER図](/freemarketapp.png)
