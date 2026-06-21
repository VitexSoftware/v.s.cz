#!/bin/bash
# Fetch GitHub metadata for all repos used in index.php.
# Requires 'gh' CLI authenticated with a GitHub account.
# Usage: bash src/data/fetch_github.sh > src/data/github_repos.php

REPOS=(
  Spoje-NET/ipex-b2b Spoje-NET/php-flexibee Spoje-NET/PHP-Realpad-Takeout
  Spoje-NET/php-subreg Spoje-NET/PohodaSQL
  VitexSoftware/abraflexi-backup VitexSoftware/abraflexi-cli VitexSoftware/abraflexi-config
  VitexSoftware/abraflexi-confirmation-sender VitexSoftware/AbraFlexi-Contractor
  VitexSoftware/abraflexi-isds VitexSoftware/abraflexi-reminder
  VitexSoftware/AbraFlexi-Report-Tools VitexSoftware/AbraFlexi-Revolut
  VitexSoftware/abraflexi-webhook-acceptor VitexSoftware/abraflexi-zabbix
  VitexSoftware/debs2deb VitexSoftware/ease-core VitexSoftware/ease-html
  VitexSoftware/ease-twbootstrap VitexSoftware/ease-twbootstrap4
  VitexSoftware/Flexplorer VitexSoftware/jaspercompiler
  VitexSoftware/Kimai2AbraFlexi VitexSoftware/mbank VitexSoftware/MultiFlexi
  VitexSoftware/multiflexi-cli VitexSoftware/multiflexi-scheduler
  VitexSoftware/multiflexi-server VitexSoftware/multiflexi-tui
  VitexSoftware/php-abraflexi-bricks VitexSoftware/php-ease-bricks
  VitexSoftware/php-ease-fluentpdo VitexSoftware/php-ease-twbootstrap4-widgets
  VitexSoftware/php-ease-twbootstrap4-widgets-flexibee VitexSoftware/php-ease-twbootstrap5
  VitexSoftware/php-ease-twbootstrap-widgets VitexSoftware/php-ease-twbootstrap-widgets-flexibee
  VitexSoftware/php-flexibee-bricks VitexSoftware/php-flexibee-datatables
  VitexSoftware/PHP-Pohoda-Connector VitexSoftware/php-primaERP
  VitexSoftware/php-vitexsoftware-multiflexi-core VitexSoftware/php-vitexsoftware-rbczpremiumapi
  VitexSoftware/python-abraflexi VitexSoftware/python-multiflexi
  VitexSoftware/Toggl-to-AbraFlexi VitexSoftware/Wakatime2AbraFlexi VitexSoftware/xls2abraflexi
)

echo "<?php"
echo "// Auto-generated — do not edit manually."
echo "// Regenerate: bash src/data/fetch_github.sh > src/data/github_repos.php"
echo "return ["

for repo in "${REPOS[@]}"; do
  data=$(gh api "repos/$repo" --jq '{description: .description, topics: .topics, language: .language, stars: .stargazers_count, forks: .forks_count}' 2>/dev/null)
  if [ -z "$data" ]; then
    echo "  // FAILED: $repo" >&2
    continue
  fi
  desc=$(echo "$data"   | python3 -c "import sys,json; d=json.load(sys.stdin); print(d.get('description','') or '')")
  topics=$(echo "$data" | python3 -c "import sys,json; d=json.load(sys.stdin); print(','.join(d.get('topics',[])))")
  lang=$(echo "$data"   | python3 -c "import sys,json; d=json.load(sys.stdin); print(d.get('language','') or '')")
  stars=$(echo "$data"  | python3 -c "import sys,json; d=json.load(sys.stdin); print(d.get('stars',0))")
  forks=$(echo "$data"  | python3 -c "import sys,json; d=json.load(sys.stdin); print(d.get('forks',0))")
  # Build topics array
  if [ -n "$topics" ]; then
    topic_php="'$(echo "$topics" | sed "s/,/', '/g")'"
  else
    topic_php=""
  fi
  echo "  '$repo' => ["
  echo "    'description' => $(php -r "echo var_export('$desc', true);"),"
  echo "    'topics'      => [$topic_php],"
  echo "    'language'    => $(php -r "echo var_export('$lang', true);"),"
  echo "    'stars'       => $stars,"
  echo "    'forks'       => $forks,"
  echo "  ],"
done

echo "];"
