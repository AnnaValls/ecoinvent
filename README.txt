# ECOINVENT WEB TOOL for wastewater

In development. Expected web application finish: October 31 2017

## Tasks
### backend tasks
- [1][doing] join ecospold generation code inside the web

  - pascal + lluis b. meeting 11/10/2017 notes
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
	
- [2][doing] implement elementary flows factors (lcorominas equations)
- [to do] implement Fe/P mole ratio from figure 6-13 (page 484), for chem P removal technology
- [on hold] implement "simple treat" equations for other elementary flows factors
- [done] calculate area from MLSS in reactor sizing
- [done] refactor technologies code for a reusable coding interface

### frontend tasks
- [to do] save inputs and technologies chosen in cookies

### future (=cannot be done in parallel, or should be more discussed)
- [to do] energy and chemicals consumed for single plant 
- [to do] be able to calculate 'n' systems (= run 'n' models in parallel)
- [to do] master data should be in the web, it has options for the user

### non prioratary tasks
- [to do] substitute images for text in the example implementations
- [done] create a summary of terms (BOD, sBOD, ...)
- [done] add references to metcalf pages in implementation code

-----------------------------
vim: set filetype=markdown:
