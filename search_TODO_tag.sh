#!/bin/bash

# this is a "grep tags" mini tool
#   features:
#   search expressions (tags) with -e "expression"
#   recursively with ". -r"
#   excludes readme file

grep -e "TODO" -e "TO DO" . -r | grep -v "README.txt"
