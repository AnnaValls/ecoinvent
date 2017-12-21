/*
 * Calculate the mass balances 
 * from the Outputs data structure
 *
 */
function do_mass_balances(){

  //effluent compounds used for the balances
  var COD = Outputs.COD;
  var CO2 = Outputs.CO2;
  var CH4 = Outputs.CH4;
  var NOx = Outputs.NOx;
  var N2  = Outputs.N2;
  var N2O = Outputs.N2O;
  var TKN = Outputs.TKN;
  var TP  = Outputs.TP;
  var TS  = Outputs.TS;

  /*EQUATIONS*/
  //1. COD BALANCE
  var inf = COD.influent;
  var wat = COD.effluent.water;
  var air = COD.effluent.air     + CO2.effluent.air; //TBD (try OTRf in CO2.air)
  var slu = COD.effluent.sludge;
  setBalance('C',inf,wat,air,slu);

  //2. NITROGEN BALANCE
  var inf = TKN.influent;
  var wat = TKN.effluent.water  + NOx.effluent.water  + N2.effluent.water  + N2O.effluent.water;
  var air = TKN.effluent.air    + NOx.effluent.air    + N2.effluent.air    + N2O.effluent.air;
  var slu = TKN.effluent.sludge + NOx.effluent.sludge + N2.effluent.sludge + N2O.effluent.sludge;
  setBalance('N',inf,wat,air,slu);

  //3. PHOSPHORUS BALANCE
  var inf = TP.influent;
  var wat = TP.effluent.water;
  var air = TP.effluent.air;
  var slu = TP.effluent.sludge;
  setBalance('P',inf,wat,air,slu);

  //4. SULFUR BALANCE
  var inf = TS.influent;
  var wat = TS.effluent.water;
  var air = TS.effluent.air;
  var slu = TS.effluent.sludge;
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
