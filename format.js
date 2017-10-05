/*
	functions to:
	deal with number formatting
	and getting inputs from user
	and displaying results
*/

/*return "3,999.4" instead of 3999.4*/
function format(number,digits){
	//default digits for decimals
	digits=digits||3;

	//less digits for big numbers
	if     (Math.abs(number)>10000){ digits=0; }
	else if(Math.abs(number)>1000 ){ digits=1; }
	else if(Math.abs(number)<0.01 ){ digits=6; }

	//format number
	var str=new Intl.NumberFormat('en-EN',{maximumFractionDigits:digits}).format(number);
	return str;
}

/*get a number value from input element*/
function getInput(id){
	var el=document.getElementById(id);
	try{
		return parseFloat(el.value);
	}catch(e){
		console.error("id: "+id);
		console.error(e);
	}
}

/*show a formatted number string into element*/
function showResult(id,value){
	var el=document.getElementById(id);
	try{
		el.innerHTML=format(value);
	}catch(e){
		console.error("id: "+id);
		console.error(e);
	}
}
