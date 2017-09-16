/** return 3.999,4 instead of 3999.4*/
function format(number,digits){
	digits=digits||3;

	//less digits for big numbers
	if     (number>10000){ digits=0; }
	else if(number>1000 ){ digits=1; }
	else if(number<0.01 ){ digits=6; }

	//format number
	var str=new Intl.NumberFormat('en-EN',{maximumFractionDigits:digits}).format(number);
	return str;
}

//set a formatted number string into an html element
function showResult(id,value){
	document.getElementById(id).innerHTML=format(value);
}

//get a number from a input id html element
function getInput(id){
	return parseFloat(document.getElementById(id).value);
}
