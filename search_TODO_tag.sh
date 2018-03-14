#!/bin/bash

# this is a "grep tags" mini tool
#   features:
#   search expressions (tags) with -e "expression"
#   recursively with ". -r"
#   excludes readme file
#   excludes .git folder
#   excludes docs folder
#   excludes this file
#   excludes README.txt file
#   excludes images in base64 encoding

echo "Searching 'TBD', 'TO DO' and 'TODO' tags..."
echo ''

grep -e "TBD" -e "TODO" -e "TO DO" . -r \
	--exclude-dir ".git" \
	--exclude-dir "docs" \
	--exclude "$0" \
	--exclude "README.txt" \
  --exclude "css.css" \
  | grep -v "base64" \
  | less
