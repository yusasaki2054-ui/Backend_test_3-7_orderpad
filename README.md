# OrderPad v1

Laravel 学習用ミニ業務アプリです。
OOP／MVC／FormRequest／PRG／Eloquent／Breeze＋Policy を統合しています。

## 技術スタック

- Laravel 13.x
- PHP 8.5
- MySQL 8.4
- Breeze（Blade）
- Vite

## 環境構築

### 1. リポジトリのクローン

```bash
git clone <repository-url>
cd orderpad
```

### 2. 環境変数の設定

```bash
cp .env.example .env
```

### 3. コンテナ起動

```bash
./vendor/bin/sail up -d
```

### 4. 依存パッケージのインストール

```bash
./vendor/bin/sail composer install
./vendor/bin/sail npm install
```

### 5. マイグレーション＆シード

```bash
./vendor/bin/sail artisan migrate:fresh --seed
```

### 6. フロントエンドビルド

```bash
./vendor/bin/sail npm run build
# 開発時は
./vendor/bin/sail npm run dev
```

### 7. ユーザー登録・ログイン

ブラウザで http://localhost/register にアクセスしてユーザー登録。

## 主な機能

- 認証（Breeze）：登録・ログt | 注文編集 |

## 設計のポイント

- FormRequest：StoreOrderRequest / UpdateOrderRequest でバリデーション
- Policy：OrderPolicy で作成者のみ編集／削除可
- PRG：成功時は redirect()->route()->with('success') でリダイレクト
- Eager Loading：Order::with(['user','items.product']) で N+1回避
- 合計計算：items->sum(fn($i) => $i->qty * $i->unit_price)
