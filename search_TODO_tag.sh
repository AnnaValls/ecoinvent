#!/bin/bash

# this is a "grep tags" mini tool
#   features:
#   search expressions (tags) with -e "expression"
#   recursively with ". -r"
#   excludes some files and folders

echo "Searching 'TBD', 'TO DO' and 'TODO' tags..."
grep -e "TBD" -e "TODO" -e "TO DO" . -r \
  --exclude-dir ".git" \
  --exclude-dir "docs" \
  --exclude-dir "wastewater_treatment_tool" \
  --exclude     "tags" \
  --exclude     "navbar.php" \
  --exclude "$0" \
  --exclude "README.txt" \
  --exclude "css.css" \
  | grep -v "base64" \
  | less
