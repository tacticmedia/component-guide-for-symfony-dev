#!/usr/bin/env bash
set -euo pipefail
mkdir -p src
printf '{\n  "name": "search-ui",\n  "type": "module",\n  "dependencies": {}\n}\n' > package.json
printf "export function search(term) {\n  return fetch('/api/search?q=' + encodeURIComponent(term));\n}\n" > src/search.js
