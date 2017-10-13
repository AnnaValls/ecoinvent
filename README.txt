# ECOINVENT WEB TOOL for wastewater
Expected web tool finish: October 31 2017

## Tasks
### backend tasks
- [1][DOING] ecospold generation code in Javascript
  - [PROCESSED] Pascal + Lluis B. meeting 11/10/2017 notes:
		```
			- file spold2_writer_functions.py:
				- 1. create_empty_dataset()
					status: revised (added default fields to empty.spold file)

				- 2. recursive_rendering() ( inside 3. )
					status: revised (nothing done)

				- 3. generateEcospold2()
					status: revised (nothing done)

			- file spold2_writer_test.py
				- description: boiler plate for ecospold generation
				- status: [doing]
		```
	- [TO PROCESS] Pascal + Lluis B. meeting 12/10/2017 notes:
		```
			1. check for equivalent library in javascript as jinja2 for python
			2. check file "spold2_writer_test_batch_1"

			3. get master data dictionary: look at the existing master data files
				- MD is an object
				- keys: names of md files
				- each object is a table

			4. from web
			- ww type     <string>
			- technology  <string>
			- capacity    <number>
			- geographies (closed list)
			- time period (start and end) <string> yyy-mm-dd

			5. check ecospold function:

			toExcel: list of fields (check)
			
			6. check fields adjacent to activityDataSet
				<usedUserMasterData>
				</usedUserMasterData>

			7. future: code in javascript
				generate data set id    (automatically) TODO
				generate activity index (automatically) TODO
		```
- [2][DOING] implementation elementary flows (lcorominas equations)
- [2][DOING] implementation elementary flows (complete version)
	- [TO DO] Add variable descriptions
	- [TO DO] Calculate outputs
- [TO DO] implement Fe/P mole ratio from figure 6-13 (page 484), for chem P removal technology
- [ON HOLD] implement "simple treat" equations for other elementary flows factors

### frontend tasks
- [TO DO] Add descriptions in technology results
- [TO DO] save inputs and technologies chosen in cookies

### future (=cannot be done in parallel, or should be more discussed)
- [TO DO] energy and chemicals consumed for single plant 
- [TO DO] be able to calculate 'n' systems (= run 'n' models in parallel)
- [TO DO] master data should be in the web, it has options for the user
- [TO DO] add master data to web files or call from an ecoinvent dedicated repository

### non prioratary tasks
- [TO DO] substitute images for text in the example implementations

-----------------------------
vim: set filetype=markdown:
