/** return 3.999,4 instead of 3999.4*/
function format(number,digits){
	digits=digits||2;
	var str=new Intl.NumberFormat('en-EN',{maximumFractionDigits:digits}).format(number);
	return str;
}
