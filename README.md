## Atte

このアプリは勤怠管理アプリです。ユーザー作成、メール認証、ログインを経て勤怠登録画面に進むことができます。登録された勤怠データは日付ごと、ユーザーごとに管理画面から確認することができます。

<p align="center">
<img src="https://github.com/user-attachments/assets/9152740d-ab60-4f78-85dc-8a88bc2ed485">
</p>

## 作成した目的

模擬的な開発を通して実践に近い開発経験を積むため。

## アプリケーションURL

[デプロイのURL](http://www.mytestdomain8756.com)

このアプリはユーザー登録と、メールアドレスを用いた認証によって利用することができます。

### 他のリポジトリ

## 機能一覧

・会員登録・・・Laravel Breezeを使用

・ログイン・・・Laravel Breezeを使用

・ログアウト・・・Laravel Breezeを使用

・メール認証・・・Laravel Breezeを使用

・ユーザー情報取得

・ユーザー飲食店お気に入り一覧取得

・ユーザー飲食店予約情報取得

・飲食店一覧取得

・飲食店詳細取得

・飲食店お気に入り追加

・飲食店お気に入り削除

・飲食店予約情報追加

・飲食店予約情報削除

・エリアで検索する

・ジャンルで検索する

・店名で検索する

・予約変更機能

・評価機能

・メール送信

・QRコード照合

・決済機能

・リマインダー

・管理画面

## 使用技術（実行環境）

PHP 8.2.24

Laravel sail

Laravel Breeze

Laravel Framework 11.28.0

EC2(Amazon Linux2)

RDS(mysql 8.0.32)

S3(デプロイ環境のストレージ)

Mailpit v1.20.6（ローカル環境のみ）

phpmyadmin(ローカル環境のみ)

Stripe v16.1.1

SimpleSoftware.io/simple-qrcode v2.0.0

## テーブル設計

<p align="center">
<img src="https://github.com/user-attachments/assets/90addefe-e136-4671-868d-ea1e536b4ac9">
</p>

## ER図

<p align="center">
<img src="https://github.com/user-attachments/assets/ba709ad1-4e0c-41df-8827-70590de3db06">
</p>

## ローカル環境の構築手順

1.コマンドライン上で任意のパスに「git clone」を行う。

2.アプリディレクトリに移動し「sudo cp .env.example .env」を実行。

3.「docker run --rm \
    -u "$(id -u):$(id -g)" \
    -v $(pwd):/var/www/html \
    -w /var/www/html \
    laravelsail/php82-composer:latest \
    composer install --ignore-platform-reqs」を実行してcomposerをインストール。

4.「sudo chown -R {Linuxのユーザー名} atte-local」で所有者の変更。

4.「./vendor/bin/sail up -d」を実行し、アプリを立ち上げる。

5.「./vendor/bin/sail artisan key:generate」を実行し、キーを発行する。

6.「./vendor/bin/sail artisan migrate:fresh」を実行し、マイグレーションする。

7.「./vendor/bin/sail artisan db:seed」を実行し、テストユーザーを作成する。

    管理者ユーザー
        ユーザー名：test-administrator

        メールアドレス：admin@test.com

        パスワード：hogehoge

    店舗代表者ユーザー
        ユーザー名：test-owner

        メールアドレス：owner@test.com

        パスワード：hogehoge

8.ブラウザ上でlocalhostにアクセスして、テストユーザーでログイン、もしくはユーザー作成→メール認証→ログインを行う。

(ローカル環境では8025番ポートにおいてMailpitでの認証を行う)