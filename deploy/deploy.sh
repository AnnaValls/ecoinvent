#!/bin/bash

#automatic git pull in webapps icra
curl "http://84.89.61.64:8030/ecoinvent/ecospold/" \
  -H "Content-Type: application/x-www-form-urlencoded" \
  -d "input=git+pull+%26%26+cd+wastewater_treatment_tool+%26%26+git+pull"

#pull in ecoinvent server
ssh prqv_wastewater@prqv.ftp.infomaniak.com 'cd web/ecoinvent; git pull; cd ecospold/wastewater_treatment_tool; git pull'
