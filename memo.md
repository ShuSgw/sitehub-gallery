# メール認証 デプロイ前メモ

## 現状（ローカル）

- 登録 → 自動ログイン → 案内画面（`verification.notice`）→ メール内リンクで認証、まで動作確認済み
- ローカルのメールテストは Mailpit（`scoop install mailpit` → `mailpit`、SMTP 1025 / 画面 http://localhost:8025）
- ダッシュボード等を `verified` で制限する **Step 4-6 は未実装**
- 認証メールの再送ボタン（`verification.send`）は未実装
- メール本文の日本語化・文言調整は未実施（`lang/ja.json` に翻訳あり。`APP_LOCALE=ja` で日本語化できる可能性）

## 今デプロイすると起きること

本番 `.env` は rsync の対象外（サーバー側の設定のまま）。
メール設定が本番にないと、登録時に `event(new Registered($user))` でメール送信に失敗し、
**ユーザーだけ保存された状態で 500 エラー**になる。

## デプロイ前チェックリスト

- [ ] **本番 `.env` のメール設定**
  - `MAIL_MAILER=smtp`
  - `MAIL_HOST` / `MAIL_PORT` / `MAIL_USERNAME` / `MAIL_PASSWORD`（Hostinger の SMTP 情報）
  - Hostinger の確認場所: hPanel → メール → 接続情報（Configure email client）
- [ ] `MAIL_FROM_ADDRESS` を Hostinger で作成したメールアドレスに合わせる（不一致だと弾かれることがある）
- [ ] `APP_URL` を本番の URL にする（認証リンクの URL に使われる）
- [ ] `APP_NAME` をサービス名にする（メールの署名に表示される。現状 `Laravel`）
- [ ] **既存ユーザーを認証済みにする**（Step 4-6 の `verified` 制限を入れる前に必須）
  ```php
  App\Models\User::whereNull('email_verified_at')->update(['email_verified_at' => now()]);
  ```
  → 本番の既存ユーザーは `email_verified_at` が `null` なので、制限後は全員ログインできなくなる

## 進める順番

1. Step 4-6（`verified` で制限）をローカルで実装
2. Hostinger の SMTP 情報を調べ、本番の `.env` に設定
3. 本番へデプロイ（`main` への push で `deploy.yml` が動く）
4. 本番の既存ユーザーを認証済みに更新
5. 本番で新規登録 → メール受信 → 認証、を確認

## 補足

- 本番サーバーの `.env` はデプロイで上書きされない（rsync で `--exclude='.env'`）
- `og_image_url` のカラム追加（`feature/site-og-image`）など、他ブランチの変更が `main` に入っているかも確認する
- 登録処理は「ユーザー保存 → メール送信」の途中で失敗すると中途半端になる。再送ボタンを付けておくと復旧しやすい
