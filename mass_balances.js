/*
 * calculate the mass balances 
 * from the Outputs data structure
 *
 */
function do_mass_balances(){
  /*C,N,P,S balances*/
  var table=document.querySelector('table#mass_balances');

  //shorten "Outputs" to "O"
  var O = Outputs;

  /*Equations*/
  //1. COD balance
  var inf = O.COD.influent;
  var wat = O.COD.effluent.water;
  var air = O.COD.effluent.air;
  var slu = O.COD.effluent.sludge;
  setBalance('C',inf,wat,air,slu);

  //2. Nitrogen balance
  var inf = O.TKN.influent;
  var wat = O.TKN.effluent.water  + O.NOx.effluent.water;
  var air = O.N2.effluent.air     + O.N2O.effluent.air;
  var slu = O.TKN.effluent.sludge + O.NOx.effluent.sludge;
  setBalance('N',inf,wat,air,slu);

  //3. Phosphorus balance
  var inf = O.TP.influent;
  var wat = O.TP.effluent.water;
  var air = O.TP.effluent.air;
  var slu = O.TP.effluent.sludge;
  setBalance('P',inf,wat,air,slu);

  //4. Sulfur balance
  var inf = O.TS.influent;
  var wat = O.TS.effluent.water;
  var air = O.TS.effluent.air;
  var slu = O.TS.effluent.sludge;
  setBalance('S',inf,wat,air,slu);
  //end

  //utilities
  function setBalance(element,influent,water,air,sludge){
    [
      {phase:'influent',value:influent},
      {phase:'water',value:water},
      {phase:'air',value:air},
      {phase:'sludge',value:sludge},
    ].forEach(ob=>{
      var color = ob.value ? "":"#aaa";
      document.querySelector('#mass_balances #'+element+' td[phase='+ob.phase+']').innerHTML=format(ob.value/1000,false,color);
    });

    //actual balance: output/input should be aprox 1
    var percent = influent==0 ? 0 : Math.abs(100*(1-(water+air+sludge)/influent));
    var el=document.querySelector('#mass_balances #'+element+' td[phase=balance]')
    el.innerHTML = format(percent,2)+" %";
    //red warning if percent is greater than X %
    var X=5;
    if(percent>X){el.style.color='red'}else{el.style.color='green'}
  }
  //end do_mass_balances
};
