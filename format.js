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
		if     (Math.abs(number)> 1000 ){ digits=0 }
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
    .replace('NH4','NH<sub>4</sub>')
    .replace('PO4','PO<sub>4</sub>')
    .replace('NOx','NO<sub>x</sub>')
    .replace('Na2','Na<sub>2</sub>')
    .replace('H2O','H<sub>2</sub>O');
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

//remove duplicate elements in arrays
function uniq(arr){return Array.from(new Set(arr));}

//get arguments
function getParamNames(func) {
  var STRIP_COMMENTS = /((\/\/.*$)|(\/\*[\s\S]*?\*\/))/mg;
  var ARGUMENT_NAMES = /([^\s,]+)/g;
  var fnStr = func.toString().replace(STRIP_COMMENTS, '');
  var result = fnStr.slice(fnStr.indexOf('(')+1, fnStr.indexOf(')')).match(ARGUMENT_NAMES);
  if(result === null) result = [];
  return result;
}

//frontend buttons for folding/unfolding sections of div#summary
function toggleView(btn,selector){
  var el=document.querySelector('#'+selector);
  if(el){ el.style.display = el.style.display=='none' ? '':'none' }
  if(btn){ btn.innerHTML= btn.innerHTML=='↓' ? '&rarr;':'&darr;' }
}

//frontend buttons for folding/unfolding sections of div#summary
function toggleViewVars(btn,tec){
  if(btn){ btn.innerHTML= btn.innerHTML=='↓' ? '&rarr;':'&darr;' }

  if(Options.hiddenTechs.indexOf(tec)==-1){
    Options.hiddenTechs.push(tec);
    var newDisplay="none";
  }else{
    Options.hiddenTechs=Options.hiddenTechs.filter(t=>{return t!=tec});
    var newDisplay="";
  }

  var els=document.querySelectorAll('#variables tr[tech='+tec+']');
  for(var i=0;i<els.length;i++){
    els[i].style.display=newDisplay;
  }
}
