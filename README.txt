# ECOINVENT WEB TOOL for wastewater
Expected web tool finish: October 31 2017

## Tasks
### backend tasks
- [1][DOING] ecospold generation code in Javascript
	- [TO PROCESS] Pascal + Lluis B. meeting 12/10/2017 notes:
		```
			1. check for equivalent library in javascript as jinja2 for python
				jinja is a template engine for python
				angular.js would be an equivalent

			2. check file "spold2_writer_test_batch_1"

			3. get master data dictionary: waiting for ecoinvent answer to serve the files online
				- MD is an object
				- keys: names of md files
				- each object is a table

			4. inputs required from this tool
				- ww type     <string>
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
		```
- [2][DOING] implementation elementary flows (lcorominas equations)
- [2][DOING] implementation elementary flows (complete version)
	- [TO DO] Finish adding variable descriptions to each technology
	- [TO DO] Calculate outputs
- [TO DO] implement Fe/P mole ratio from figure 6-13 (page 484), for chem P removal technology
- [TO DO] some constants in constants.js are design choices, like *C_L*. Check them.
- [TO DO] use Qe (Q-Qwas) in equations ("elementary.php")
- [ON HOLD] implement "simple treat" equations for other elementary flows factors
- [TO DO] create a comand line tool for searching "TODO" tags inside the code

### frontend tasks
- [TO DO] Add equations in a "profile page" for each 
  - there is a link to each implementation for now
- [DOING] Add descriptions in technology results
- [TO DO] save inputs and technologies chosen in cookies

### Lluís Corominas requests
- [TO DO] transparency in equations (See code)
- [TO DO] meeting notes
	1. Color code the inputs; what needs to be entered or not, and give some instructions; 
		--> això t'ho hauré de donar jo amb l'ajuda dels modellers
	2. a les taules elementary flows, afegir button que et permeti veure els valors de la taula també expressats en m3 en comptes de per dia
	3. Mass balances under 1% error! Ask modelers to confirm
	4. We will give them pdf with equations, access to the code; some explanation on the tool; 

### future (=cannot be done in parallel, or should be more discussed)
- [TO DO] energy and chemicals consumed for single plant 
- [TO DO] master data should be in the web, it has options for the user
- [TO DO] add master data to web files or call from an ecoinvent dedicated repository
- [TO DO] be able to calculate 'n' systems (= run 'n' models in parallel)

### non prioratary tasks
- [TO DO] substitute images for text in the example implementations


-----------------------------
vim: set filetype=markdown:
