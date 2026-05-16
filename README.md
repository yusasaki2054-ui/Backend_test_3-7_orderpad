# OrderPad v2

Laravel 学習用ミニ業務アプリです。
OOP／MVC／FormRequest／PRG／Eloquent／Breeze＋Policy を統合し、
検索・ソフトデリート・画像アップロードを実装しています。

## 技術スタック

- Laravel 13.x
- PHP 8.5
- MySQL 8.4
- Breeze（Blade）
- Vite

## 環境構築

### 1. リポジトリのクローン

git clone <repository-url>
cd orderpad

### 2. 環境変数の設定

cp .env.example .env

### 3. コンテナ起動

./vendor/bin/sail up -d

### 4. 依存パッケージのインストール

./vendor/bin/sail composer install
./vendor/bin/sail npm install

### 5. マイグレーション＆シード

./vendor/bin/sail artisan migrate:fresh --seed

### 6. ストレージリンク作成

./vendor/bin/sail artisan storage:link

### 7. フロントエンドビルド

./vendor/bin/sail npm run build

### 8. ユーザー登録・ログイン

http://localhost/register にアクセスしてユーザー登録

## 主な機能

### 認証（Breeze）
式：jpg, jpeg, png, webp
- 最大サイズ：2MB
- 保存先：storage/app/public/products/
- 更新ポリシー（C-1）：新規アップロード時に旧ファイルを自動削除

## 画面一覧

| URL | 説明 |
|-----|------|
| /products | 商品一覧 |
| /products/create | 商品作成 |
| /products/{id} | 商品詳細 |
| /products/{id}/edit | 商品編集 |
| /orders | 注文一覧（検索・絞り込み） |
| /orders/create | 注文作成 |
| /orders/{id} | 注文詳細 |
| /orders/{id}/edit | 注文編集 |
| /orders/trashed | ゴミ箱 |

## 設計のポイント

- FormRequest：バリデーションをコントローラから分離
- Policy：OrderPolicy で作成者のみ編集／削除可
- PRG：成功時は redirect()->route()->with('success') でリダイレクト
- Eager Loading：Order::with(['user','items.product']) で N+1回避
- SoftDeletes：deleted_at で論理削除
- Storage：publicディスクで画像管理
