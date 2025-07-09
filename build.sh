#!/usr/bin/env bash
set -euo pipefail

# Build and package the GN Custom Post Selector plugin.
# Ensure Node.js 14 is available using nvm if present.
if command -v nvm >/dev/null 2>&1; then
  nvm install 14 >/dev/null
  nvm use 14 >/dev/null
fi

npm install
npm run build
npm run zip

echo "Build complete. Output: gn-custom-post-selector.zip"

