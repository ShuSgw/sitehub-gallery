#!/usr/bin/env bash
# migration の事故を防ぐチェック
#   1. up() の中身が空（//だけ）の migration を禁止する
#   2. すでにコミット済みの migration の書き換えを禁止する
# 使い方: bash scripts/check-migrations.sh [比較元のコミット(省略時 origin/main)]

# grep -P は、環境のロケール設定によってはエラーになるため、UTF-8 に固定する
export LC_ALL=C.UTF-8

base="${1:-origin/main}"
dir="database/migrations"
failed=0

# 1. 空の migration を探す
#    - up() が丸ごと空、または // だけ
#    - up() が Schema::table(...) だけで、その中が // だけ
empty=$(grep -Pzl 'function up\(\): void\s*\{\s*(//\s*|Schema::table\([^{]*\{\s*//\s*\}\);\s*)?\}' $dir/*.php 2>/dev/null)
if [ -n "$empty" ]; then
  echo "NG: up() の中身が空の migration があります。書いてからコミットしてください:"
  echo "$empty"
  failed=1
fi

# 2. 既存ファイルの書き換え（M）を探す。比較元が無いときはスキップ
if git rev-parse --verify --quiet "$base^{commit}" > /dev/null; then
  changed=$(git diff --name-only --diff-filter=M "$base" HEAD -- "$dir")
  if [ -n "$changed" ]; then
    echo "NG: すでにある migration が書き換えられています。新しい migration を足してください:"
    echo "$changed"
    failed=1
  fi
else
  echo "比較元($base)が見つからないため、書き換えチェックはスキップします"
fi

if [ "$failed" -eq 0 ]; then
  echo "OK: migration のチェックを通過しました"
fi
exit "$failed"
