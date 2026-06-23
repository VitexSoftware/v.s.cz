#!/bin/bash
# Fetch GitHub metadata for all repos used on the site.
# Requires 'gh' CLI authenticated with a GitHub account.
# Usage: bash src/data/fetch_github.sh > src/data/github_repos.php

# Curated Spoje-NET repos shown on the homepage
SPOJE_REPOS=(
  Spoje-NET/ipex-b2b Spoje-NET/php-flexibee Spoje-NET/PHP-Realpad-Takeout
  Spoje-NET/php-subreg Spoje-NET/PohodaSQL
)

# All non-fork, non-archived VitexSoftware repos (fetched dynamically)
mapfile -t VS_REPOS < <(
  gh repo list VitexSoftware --source --no-archived --json name --jq '.[].name' --limit 300 \
  | sed 's/^/VitexSoftware\//'
)

REPOS=("${SPOJE_REPOS[@]}" "${VS_REPOS[@]}")

PYCONV=$(cat <<'PYEOF'
import sys, json

repo = sys.argv[1]
raw = sys.stdin.read()
if not raw.strip():
    sys.exit(1)
d = json.loads(raw)

def php_str(s):
    s = (s or '').replace('\\', '\\\\').replace("'", "\\'")
    return f"'{s}'"

topics_php = ', '.join(php_str(t) for t in (d.get('topics') or []))
print(f"  {php_str(repo)} => [")
print(f"    'description' => {php_str(d.get('description') or '')},")
print(f"    'topics'      => [{topics_php}],")
print(f"    'language'    => {php_str(d.get('language') or '')},")
print(f"    'stars'       => {int(d.get('stars') or 0)},")
print(f"    'forks'       => {int(d.get('forks') or 0)},")
pushed = (d.get('pushedAt') or '')[:10]
print(f"    'pushedAt'    => {php_str(pushed)},")
print(f"  ],")
PYEOF
)

echo "<?php"
echo "// Auto-generated — do not edit manually."
echo "// Regenerate: bash src/data/fetch_github.sh > src/data/github_repos.php"
echo "return ["

for repo in "${REPOS[@]}"; do
  data=$(gh api "repos/$repo" --jq '{description: .description, topics: .topics, language: .language, stars: .stargazers_count, forks: .forks_count, pushedAt: .pushed_at}' 2>/dev/null)
  if [ -z "$data" ]; then
    echo "  // FAILED: $repo" >&2
    continue
  fi
  echo "$data" | python3 -c "$PYCONV" "$repo" || echo "  // PYTHON FAILED: $repo" >&2
done

echo "];"
