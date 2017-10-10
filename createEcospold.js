function createEcospold()
{

	window.location='empty.spold';

	return;

	//TODO empty spold now
	var xml="";

	//generate file and download
	var a=document.createElement('a');
	a.href="data:text/xml;charset=utf-8,"+xml;
	a.download="ecospold.xml";
	a.click();
}
