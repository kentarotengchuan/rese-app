## Atte

このアプリは飲食店予約サービスアプリです。ユーザー作成、メール認証、ログインを経てショップ一覧画面に進むことができます。食事の予約・決済とレビュー、店舗情報やユーザー情報の管理を行うことができます。

<p align="center">
<img src="https://github.com/user-attachments/assets/9152740d-ab60-4f78-85dc-8a88bc2ed485">
</p>

## 作成した目的

ライブラリを用いた個人開発を通して実践に近い開発経験を積むため。

## アプリケーションURL

[デプロイのURL](http://www.mytestdomain8756.com)
↑現在サーバー停止中

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

・飲食店作成・・・店舗代表者ユーザの権限。ここで入力した地域とジャンルは各々対応するテーブルに作成される。

・エリアで検索する

・ジャンルで検索する

・店名で検索する・・・店舗名と詳細情報を対象に検索が行われる。

・予約変更機能

・評価機能・・・★１～５での評価とレビューが可能。評価内容は店舗詳細画面にて一覧表示される。

・メール送信・・・管理者ユーザの権限。送信先は全ての店舗代表者と利用者。

・QRコード照合・・・simple－qrcodeを使用。

・決済機能・・・Stripeを使用。(模擬案件の為、テストモードで実装)

・リマインダー・・・crontabを使用。ローカル環境においては「./vendor/bin/sail artisan schedule:run」によってテスト可能。

・管理画面・・・管理者は店舗代表者の作成・メールの一斉送信が可能。店舗代表者は店舗情報の作成、編集が可能。

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

4.一つ前のディレクトリに戻って「sudo chown -R {Linuxのユーザー名} rese-app」で所有者の変更。

5.再び、rese-appのディレクトリに戻って「./vendor/bin/sail up -d」を実行し、アプリを立ち上げる。

6.「./vendor/bin/sail artisan key:generate」を実行し、キーを発行する。

7.「./vendor/bin/sail artisan migrate:fresh」を実行し、マイグレーションする。

8.「./vendor/bin/sail artisan db:seed」を実行し、テストユーザーを作成する。

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