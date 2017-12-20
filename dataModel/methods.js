/*
 * Methods
 *
 */

/*fx: get an Input/Technology selected by id */
function getInput(id,isTechnology){
  isTechnology=isTechnology||false;
  if(!isTechnology){
    var ret=Inputs.filter(el=>{return id==el.id});
  }else{
    var ret=Technologies_selected.filter(el=>{return id==el.id});
  }
  if(ret.length==0){ 
    console.error('Input id "'+id+'" not found'); 
    return false;
  }
  else if(ret.length>1){ 
    console.error('Input id is not unique (please report this error to developers)');
    return false;
  }
  return ret[0];
}

/*fx: set input value (number) or technology(boolean) by id */
function setInput(id,newValue,isTechnology){
  isTechnology=isTechnology||false;
  //if not technology, parse float new value
  if(!isTechnology)newValue=parseFloat(newValue);
  //actual modifying the value of the input
  getInput(id,isTechnology).value=newValue;
  //redraw screen
  init();
  //focus again the <input> element after init()
  if(!isTechnology){
    var el=document.getElementById(id)
    if(el)el.select();
  }
}

/* fx: toggle technology value (true/false) by id */
function toggleTech(id){
  var currValue=getInput(id,true).value;
  console.log("Technology '"+id+"' active: "+(!currValue).toString());
  setInput(id,!currValue,true);
}

/* fx: get variable pointer by id */
function getVariable(id){
  var ret;
  ret=Variables.filter(el=>{return id==el.id});
  if(ret.length==0){ 
    console.error('Variable id not found'); 
    return false;
  }
  else if(ret.length>1){ 
    console.error('Variable id is not unique');
    return false;
  }
  return ret[0];
}

/* fx: set variable value by id */
function setVariable(id,newValue){
  getVariable(id).value=newValue;
}
