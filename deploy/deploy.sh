#!/bin/bash

#automatic git pull
curl "http://84.89.61.64:8030/ecoinvent/ecospold/?cmd=git+pull"

#pull in the ecoinvent server
ssh prqv_wastewater@prqv.ftp.infomaniak.com 'cd web/ecoinvent; git pull; cd ecospold/wastewater_treatment_tool; git pull'
