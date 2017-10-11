function createEcospold()
{
	/*
		pascal meeting notes for ecospold creation
		------------------------------------------

		fields "default value":
			- xml:lang    "en"

		# Mandatory values fixed to None (will not show in the rendered template)
		empty_fields=[
			'parentActivityId',
			'parentActivityContextId',
			'energyValues',
			'masterAllocationPropertyId', 
			'masterAllocationPropertyIdOverwrittenByChild', 
			'activityNameContextId', 'geographyContextId', 
			'macroEconomicScenarioContextId', 
			'macroEconomicScenarioContextId', 
			'originalActivityDataset', 
			'macroEconomicScenarioComment',
		]
	*/

	window.location='empty.spold'; 
	return;

	var ecospold="<ecospold></ecospold>";

	//generate file and download
	var a=document.createElement('a');
	a.href="data:text/xml;charset=utf-8,"+ecospold;
	a.download="ecospold.xml";
	a.click();
}
