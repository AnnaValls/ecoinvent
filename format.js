/*
	functions to:
	deal with number formatting
	and getting inputs from user
	and displaying results
*/

/*return "3,999.4" instead of 3999.4*/
function format(number,digits,color){
	//if not specified, less digits for big numbers
	if(!digits){
		if     (Math.abs(number)> 10000){ digits=0 }
		else if(Math.abs(number)> 100  ){ digits=1 }
		else if(Math.abs(number)> 10   ){ digits=2 }
		else if(Math.abs(number)> 0.1  ){ digits=3 }
		else if(Math.abs(number)> 0.01 ){ digits=4 }
		else if(Math.abs(number)> 0.001){ digits=5 }
		else if(Math.abs(number)<=0.001){ digits=6 }
	}
	//format number
	var str=new Intl.NumberFormat('en-EN',{maximumFractionDigits:digits}).format(number);

	//color
	if(color){ str = "<span style='color:"+color+"'>"+str+"</span>"; }

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

String.prototype.prettifyUnit=function(){
	return this
		.replace('m3','m<sup>3</sup>')
		.replace('m2','m<sup>2</sup>')
		.replace(/_/g,' ')
		.replace('O3','O<sub>3</sub>')
		.replace('O2','O<sub>2</sub>')
		.replace('N2','N<sub>2</sub>')
		.replace('CH4','CH<sub>4</sub>')
		.replace('NOx','NO<sub>x</sub>');
}

//string to color
var str2color = function(str) {
	var hash = 0;
	for (var i = 0; i < str.length; i++) {
		hash = str.charCodeAt(i) + ((hash << 5) - hash);
	}
	var colour = '#';
	for (var i = 0; i<3; i++) {
		var value = (hash >> (i * 8)) & 0xFF;
		colour += ('00' + value.toString(16)).substr(-2);
	}
	return colour;
}

