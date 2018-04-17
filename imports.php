<!--imports.php-->

<!--meta-->
<meta charset="utf-8">
<meta name="viewport" content="width=device-width">
<meta name="description" content="ecoinvent">

<!--link-->
<link rel=stylesheet href="css.css">

<!--javascript main structures/functions-->
<script src="format.js"></script><!--utils for number formatting-->
<script src="utils.js"></script><!--metcalf figures and tables-->
<script src="post.js"></script><!--send data to other pages-->
<script src="estimations.js"></script><!--input estimations-->

<!--just descriptive objects-->
<script src="dataModel/terms.js"></script><!--units and descriptions-->

<!--metcalf technologies-->
<script src="dataModel/constants.js"></script>
<script src="techs/fractionation.js"></script>
<script src="techs/primary_settler.js"></script>
<script src="techs/bod_removal_only.js"></script>
<script src="techs/sst_sizing.js"></script>
<script src="techs/nitrification.js"></script>
<script src="techs/n_removal.js"></script>
<script src="techs/bio_P_removal.js"></script>
<script src="techs/chem_P_removal.js"></script>
<script src="techs/metals_doka.js"></script>
<script src="techs/cso_removal.js"></script>
<script src="techs/sludge_composition.js"></script>
<script src="techs/energy_consumption.js"></script>

<!--data model-->
<script src="dataModel/inputs.js"></script>
<script src="dataModel/variables.js"></script>
<script src="dataModel/outputs.js"></script>
<script src="dataModel/methods.js"></script>
<script src="dataModel/technologies.js"></script>
<script src="dataModel/geographies.js"></script>
<script src="dataModel/ecoinvent_ids/ecoinvent_ids.js"></script>

<!--"binary string" encoder for technology mixes-->
<script src="technology_mix_encoder.js"></script>

<!--css-->
<style>
	body {
    font-family:Charter,serif;
		margin:0 auto;
		max-width:80em;
		overflow-y:scroll;
		margin-bottom:50px;
	}
  th {
    background:#eee;
  }
	#root {
		margin-left:8px;
	}
  input[type=number], .number {
    text-align:right;
  }
	.flex {
		display:flex;
		flex-wrap:wrap;
	}
	.unit {
		font-size:smaller;
	}
  .help{
    cursor:default;
  }
</style>
<!--end imports.php-->
