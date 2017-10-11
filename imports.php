<!--imports.php-->
<!--meta-->
<meta charset="utf-8">
<meta name="viewport" content="width=device-width">
<meta name="description" content="ecoinvent">

<!--link-->
<link rel="icon" href="img/favicon.ico" type="image/x-icon">

<!--javascript-->
<script src="utils.js"></script> <!--metcalf figures and tables-->
<script src="format.js"></script> <!--real utils-->
<script src="dataModel/constants.js"></script>
<script src="dataModel/inputs.js"></script>
<script src="dataModel/technologies.js"></script>
<script src="dataModel/combinations.js"></script>
<script src="dataModel/outputs.js"></script>

<!--metcalf technologies-->
<script src="techs/bod_removal_only.js"></script>
<script src="techs/sst_sizing.js"></script>
<script src="techs/nitrification.js"></script>
<script src="techs/n_removal.js"></script>
<script src="techs/bio_P_removal.js"></script>
<script src="techs/chem_P_removal.js"></script>

<!--TODO decide if eliminate-->
<script src="dataModel/variables.js"></script>

<!--css-->
<style>
	body {
		font-family:Charter,serif;
		margin:0 auto;
		max-width:80em;
		overflow-y:scroll;
	}
	#root {
		margin-left:8px;
	}
	.number {
		text-align:right;
	}
	.flex {
		display:flex;
		flex-wrap:wrap;
	}
	.unit {
		font-size:11px;
	}
	.help {
		cursor:help;
	}
</style>


<!--end imports.php-->
