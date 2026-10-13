#!/usr/bin/env bash
set -euo pipefail
cp -R "$(dirname "${BASH_SOURCE[0]}")/project/." .
git init -q
git add -A
git -c user.name=eval -c user.email=eval@example.com commit -q -m fixture
