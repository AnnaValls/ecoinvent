#!/bin/bash

#important: the shell user must have permissions to write a file to the folder
cd wastewater_treatment_tool/implementation_tests/
echo "[+] creating ecospold file..."
/usr/local/bin/python3 direct_discharge_ecospold_test.py
