# サイト置き場

お気に入りウェブサイトを登録・管理できる Laravel製 アプリ。

## プロジェクトについて

このプロジェクトの目的：

- **Laravel の認証システム** 理解のため認証を（Breeze等使わず）スクラッチ開発
- **MVC モデル**の流れを実装しながら復習する
- セキュリティベストプラクティス学習

## 機能

- **ユーザー認証**：メールアドレスとパスワードでログイン
- **サイト管理**：Web サイトの登録・一覧表示
- **管理者機能**：全ユーザー情報の確認
- **管理者チェック機能**：新規ユーザー、ログインでTelegramに通知

## 技術スタック

- Laravel 12
- MySQL
- Blade
- Tailwind CSS
- daisyui
- Alpine.js

## ローカル設定

```bash
composer install
cp .env.example .env
./vendor/bin/sail up -d
./vendor/bin/sail artisan migrate
./vendor/bin/sail npm install
```

> **Note:** [Laravel Sail](https://laravel.com/docs/sail) 使用

### フロントエンド（Vite）

`npm` コマンドは **必ず Sail コンテナ内で実行する**：

```bash
./vendor/bin/sail npm install      # パッケージ追加・更新
./vendor/bin/sail npm run dev      # 開発サーバー（HMR、ポート5173）
./vendor/bin/sail npm run build    # 本番ビルド
```

> **Note:** `node_modules` はホスト(Mac)とコンテナ(Linux)で共有されている。Vite はネイティブバイナリ(rolldown)を使い1プラットフォーム分しか入らないため、ホスト側で `npm` を実行すると `Cannot find native binding` でコンテナ側が壊れる（逆も同様）。バイナリが壊れたら該当環境で `rm -rf node_modules package-lock.json && npm install` で入れ直す。

## 開発予定

- [ ] **定期更新**：一定期間ごとにスクリーンショットを自動更新
- [ ] **カテゴリー機能**：サイトをカテゴリー分類して管理
- [ ] **タグ機能**：サイトをタグ分類して管理
- [ ] **スクリーンショット保存**：登録したサイトのスクリーンショットを自動保存
- [ ] **プレビュー機能**：リスト画面からサイトの見た目を確認
- [ ] **通知機能**：公式ライン作製してそこから通知
- [ ] **SNSログイン機能**
- [ ] **非公開カテゴリ**：自分しか見えないサイトリストをカテゴリで分類できる

## 開発環境・自動化

GitHub Actions で以下を自動化予定：

- [x] **Deploy自動化**：Actionで自動ビルドしてHostingerにデプロイ

## ホスティング

本番環境：[Hostinger](https://www.hostinger.jp/) のレンタルサーバー

### 本番サーバーでのコマンド実行

Hostinger 上では `php` コマンドが直接使えない。artisan / composer を実行するときは
PHP のフルパスを指定する：

```bash
/opt/alt/php82/usr/bin/php artisan migrate --force
/opt/alt/php82/usr/bin/php artisan config:cache
```

> **Note:** `php artisan ...` だけでは動かない。必ず `/opt/alt/php82/usr/bin/php` を付ける。
