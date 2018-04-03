#!/usr/local/bin/python3

import json
import sys
import os
import pprint
#from {folder}.{folder} import {file}
from wastewater_treatment_tool.pycode import DirectDischarge_ecoSpold
from wastewater_treatment_tool.pycode.placeholders import *
from wastewater_treatment_tool.pycode.defaults import *

#print python version
print("Python",sys.version.split(' ')[0],'\n')

#go to tests folder
os.chdir(r'wastewater_treatment_tool/implementation_tests/')

'''
  Receive a json string from stdin
'''
#debug: print input string
#print('input string: ',sys.argv[1].encode('ascii','ignore').decode('ascii'))

#parse json
received_json = json.loads(sys.argv[1])
#print('parsed JSON object: ',json.dumps(received_json, indent=4, sort_keys=True))

'''
  Untreated fraction dataset creation
'''
temp_untreated_fraction = received_json['untreated_fraction']
temp_CSO_particulate    = {'f65558fb-61a1-4e48-b4f2-60d62f14b085': received_json['CSO_particulate']['value']/100}
temp_CSO_dissolved      = {'f65558fb-61a1-4e48-b4f2-60d62f14b085': received_json['CSO_soluble']['value']/100}
temp_geography          = received_json['geography']
temp_PV                 = received_json['PV']['value']

temp_CSO_amounts = { }
for i in received_json['CSO_amounts']:
  if 'ecoinvent_id' in i:
    temp_CSO_amounts.update({ i['ecoinvent_id'] : i['value'] })

temp_WWTP_influent_properties = { }
for i in received_json['WW_properties']:
  if 'ecoinvent_id' in i:
    temp_WWTP_influent_properties.update({ i['ecoinvent_id'] : i['value'] })

'''missing items TODO discuss with pascal'''
temp_tool_use_type      = 'average'
temp_WW_type            = 'average'
temp_PV_comment         = 'Some PV comment'
temp_technologies_averaged = {
  0: {
      'fraction':0.4,
      'technology_str': "The auto_generated string representing tech 0",
      'capacity': "Class 1 (over 100,000 per-capita equivalents)",
      'location': 'Spain',
    },
  1: {
      'fraction':0.6,
      'technology_str': "The auto_generated string representing tech 1",
      'capacity': "Class 2 (50,000 to 100,000 per-capita equivalents)",
      'location': 'Spain',
    },
}
temp_WW_properties        = { }
temp_WWTP_emissions_water = { }
temp_WWTP_emissions_air   = { }
temp_sludge_amount        = 0
temp_sludge_properties    = { }

test_inputs_average = {
  "tool_use_type":             temp_tool_use_type,
  "untreated_fraction":        temp_untreated_fraction,
  "CSO_particulate":           temp_CSO_particulate,
  "CSO_amounts":               temp_CSO_amounts,
  "CSO_dissolved":             temp_CSO_dissolved,
  "WW_type":                   temp_WW_type,
  "geography":                 temp_geography,
  "PV":                        temp_PV,
  "WW_properties":             temp_WW_properties,
  "WWTP_influent_properties":  temp_WWTP_influent_properties,
  "WWTP_emissions_water":      temp_WWTP_emissions_water,
  "WWTP_emissions_air":        temp_WWTP_emissions_water,
  "sludge_amount":             temp_sludge_amount,
  "sludge_properties":         temp_sludge_properties,
  "technologies_averaged":     temp_technologies_averaged
}

'''
pretty printer (debug)
'''
pp=pprint.PrettyPrinter(indent=2)
pp.pprint(test_inputs_average)

direct_discharge_test = DirectDischarge_ecoSpold(**test_inputs_average)
