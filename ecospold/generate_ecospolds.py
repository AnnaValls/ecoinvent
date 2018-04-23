#!/usr/bin/env python3
import json
import os
import pprint
import sys

#print python version before local imports
print("Running Python",sys.version.split(' ')[0])

#folder with python packages
sys.path.append("../../../opt/python3/")
sys.path.append("wastewater_treatment_tool")
import xlrd

#from {folder}.{folder} import {file}
from wastewater_treatment_tool.pycode import DirectDischarge_ecoSpold, WWT_ecoSpold
from wastewater_treatment_tool.pycode.placeholders import *
from wastewater_treatment_tool.pycode.defaults import *

#go to tests folder
os.chdir(r'wastewater_treatment_tool/')
root_dir = os.getcwd()
#print("Root dir is",root_dir)

'''Receive a json string from stdin'''
#debug: print input string
#parse json
received_string = sys.argv[1].encode('ascii','ignore').decode('ascii')
received_json = json.loads(received_string)
#print('parsed JSON object: ',json.dumps(received_json, indent=4, sort_keys=True))

'''pretty printer (debug)'''
pp=pprint.PrettyPrinter(indent=2)
#pp.pprint(received_json)

args = {k: v for d in received_json.values() for k, v in d.items()}
result = {}

if args['untreated_fraction'] == 0:
  result['untreated'] = False;
else:
  untreated = DirectDischarge_ecoSpold(root_dir, **args)
  result['untreated'] = untreated.generate_ecoSpold2()

if args['untreated_fraction'] == 1:
  result['treated'] = False;
else:
  treated = WWT_ecoSpold(root_dir, **args)
  result['treated'] = treated.generate_ecoSpold2()

#pp.pprint(result)
#show html links
print("<hr><b style=color:green>Success!</b>")
if result['untreated']:
  print('<a target=_blank href="wastewater_treatment_tool/output/'+result['untreated'][1]+'">Click here to download',result['untreated'][1])
if result['treated']:
  print('<a target=_blank href="wastewater_treatment_tool/output/'+result['treated'][1]+'">Click here to download',result['treated'][1])
