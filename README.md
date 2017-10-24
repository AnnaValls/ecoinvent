# ECOINVENT WEB TOOL for wastewater
Expected web tool finish: October 31 2017

## Tasks
### backend tasks
- [1][DOING] _ECOSPOLD_ generation code in Javascript
	1. check for equivalent library in javascript as jinja2 for python
		- [DONE]: angular.js is an equivalent
	2. check file *spold2_writer_test_batch_1*
	3. get master data dictionary: waiting for ecoinvent answer to serve the files online
		- MD is an object
		- keys: names of md files
		- each object is a table
	4. inputs required from this tool
		- technology  <string>
		- capacity    <number>
		- geographies (closed list)
		- time period (start and end) <string> yyy-mm-dd
	5. check ecospold function toExcel: list of fields (check)
	6. check fields adjacent to activityDataSet
		<usedUserMasterData>
		</usedUserMasterData>
	7. future: code in javascript
		generate data set id    (automatically) TODO
		generate activity index (automatically) TODO
- [2][DOING] implementation elementary flows
	- see its own task list there
- [TO DO] constants without description in code (file dataModel/constants.js)

### frontend tasks
- [TO DO] save inputs and technologies chosen in cookies

### lcorominas requests

### future (=cannot be done in parallel, or should be more discussed to understand it completely)
- [TO DO] energy and chemicals consumed for single plant 
- [TO DO] master data should be in the web, it has options for the user
- [TO DO] add master data to web files or call from an ecoinvent dedicated repository
- [TO DO] be able to calculate 'n' systems (= run 'n' models in parallel)

### non prioratary tasks
- [TO DO] substitute images for text in the example implementations


-----------------------------
vim: set filetype=markdown:
