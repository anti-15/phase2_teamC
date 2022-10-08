# laratter

## 開発環境

-   Laravel Sail（ララベル セイル）

## 使い方

コンテナ起動 laravel([localhost](http://localhost/)) phpmyadmin([localhost:8080](http://localhost:8080))

```
./vendor/bin/sail up -d
```

コンテナ停止

```
./vendor/bin/sail down
```

## 環境構築

Laravel Breeze のインストール

```
./vendor/bin/sail composer require laravel/breeze --dev
./vendor/bin/sail php artisan breeze:install
```

その他必要なパッケージをインストールしてビルド

```
./vendor/bin/sail npm install
./vendor/bin/sail npm run build
```

マイグレート

```
./vendor/bin/sail php artisan migrate
```

テストユーザを作成

```
./vendor/bin/sail php artisan db:seed
```

## マイグレーションによるテーブル作成

Model `Tweet`を作成。`-m` をつけることでマイグレーションファイルも同時に作成できる。

```
./vendor/bin/sail php artisan make:model Tweet -m
```

database/migrations/ の下にあるマイグレーションファイルを編集。

マイグレーション実行。

```
./vendor/bin/sail php artisan migrate
```

エラーになる場合は以下を実行する。

```
./vendor/bin/sail php artisan migrate:fresh
```

## ルーティングとコントローラ

コントローラ `TweetController`を作成。--resource をつけることで、よく使用する処理（代表的な CRUD 処理）を一括して作成することができる。

```
./vendor/bin/sail php artisan make:controller TweetController --resource
```

routes/web.php を編集。

ルーティングの一覧表示。

```
./vendor/bin/sail php artisan route:list
```

コントローラの実装
コントローラは`app/Http/Controllers`以下に配置される。

## 共通画面の作成

ビューファイルは `resources/views` ディレクトリ以下に配置する。  
入力値が不正な場合などはエラー画面を表示して対応する。

```
mkdir resources/views/common
touch resources/views/common/errors.blade.php
```

## tweet 作成画面の作成

```
# フォルダ作成
$ mkdir resources/views/tweet

# ファイル作成
$ touch resources/views/tweet/create.blade.php
$ touch resources/views/tweet/edit.blade.php
$ touch resources/views/tweet/index.blade.php
$ touch resources/views/tweet/show.blade.php
```

CSS が効いていない気がする．．という場合は下記コマンドを実行して再度動作確認する．

```
./vendor/bin/sail npm run build
```

## tweet 作成処理の実装

-   app/Http/Controllers/TweetController.php の store()を編集
-   app/Models/Tweet.php に関数を作成
-   app/Http/Controllers/TweetController.php の index()を編集

## オススメサイト

-   [VSCode を Laravel 超特化型にする 最高の拡張機能 10 選まとめ](https://yurupro.cloud/2132/)
-   [Laravel Sail](https://readouble.com/laravel/8.x/ja/sail.html#:~:text=Laravel%20Sail%E3%81%AF%E3%80%81Laravel%E3%81%AE,%E7%82%B9%E3%82%92%E6%8F%90%E4%BE%9B%E3%81%97%E3%81%BE%E3%81%99%E3%80%82)
-   [Laravel 公式の Laravel sail で「Laravel」+「phpMyAdmin」をサクッと環境構築](https://qiita.com/Naaaa/items/9b9b6b05a93b8b8f3cec)
-   [phpmyadmin とは](https://ja.wikipedia.org/wiki/PhpMyAdmin)
-   [laravel Validator によるバリデーション](https://qiita.com/gone0021/items/c613ef7e006b6f5d47ce)
-   [PHP Laravel の blade テンプレートを理解する。](https://qiita.com/shizen-shin/items/24d22265db47d7fb3c3d)
