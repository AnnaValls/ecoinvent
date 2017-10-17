#!/bin/bash

# this is a "grep tags" mini tool
#   features:
#   search expressions (tags) with -e "expression"
#   recursively with ". -r"
#   excludes readme file
#   excludes .git folder
#   excludes README.txt file
#   excludes this file

echo "Searching 'TBD', 'TO DO' and 'TODO' tags..."

grep -e "TBD" -e "TODO" -e "TO DO" . -r \
	--exclude-dir ".git" \
	--exclude-dir "docs" \
	--exclude "$0" \
	--exclude "README.txt" | grep -v "base64"
