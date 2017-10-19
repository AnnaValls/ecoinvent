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
	- [TO DO] Bio P + Chem P simulatenous, how to deal with inputs and outputs?
- [TO DO] constants without description
- [WAIT] check Qe (Q-Qwas) in equations ("elementary.php") (task for lcorominas)

### frontend tasks
- [TO DO] Add equations in a "profile page" for each 
- [TO DO] save inputs and technologies chosen in cookies

### lcorominas requests
1. Color code the inputs; what needs to be entered or not, and give some instructions; 
	--> això t'ho hauré de donar jo amb l'ajuda dels modellers
2. a les taules elementary flows, afegir button que et permeti veure els valors de la taula també expressats en m3 en comptes de per dia
3. Mass balances under 1% error! Ask modelers to confirm
4. We will give them pdf with equations, access to the code; some explanation on the tool; 

	```
	Per energy consumption:
	Un cop tens calculats els KgO2, pots aplicar aquest factor per passar de Kg O2 a kWh. 
	Aquest factor és diferent per cada tipus de difusor. Per difusors del tipus "fine bubble systems" el factor està entre 3.6 i 4.8. Pots agafar un valor de 4.
	Fine bubble systems have SAE ranges of between 3.6 and 4.8 kgO2/kWh.
	```

### future (=cannot be done in parallel, or should be more discussed to understand it completely)
- [TO DO] energy and chemicals consumed for single plant 
- [TO DO] master data should be in the web, it has options for the user
- [TO DO] add master data to web files or call from an ecoinvent dedicated repository
- [TO DO] be able to calculate 'n' systems (= run 'n' models in parallel)

### non prioratary tasks
- [TO DO] substitute images for text in the example implementations


-----------------------------
vim: set filetype=markdown:
