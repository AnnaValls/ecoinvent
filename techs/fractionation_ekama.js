/** 
  * Technology: Fractionation of the influent (G. Ekama version)
  * status: under development
  *
  * COD =     
  *   BS + US = sCOD
  *   -+-+-+- 
  *   BP + UP = pCOD
  *   "    "
  *   bCOD uCOD
  *
*/

function fractionation_ekama(COD,sCOD,fSus,fSup){
  /**
    * | Inputs | example values |
    * |--------+----------------|
    * | COD    | 750 g/m3       |
    * | sCOD   | 199 g/m3       |
    * | fSus   |   7 %          |
    * | fSup   |  15 %          |
    *
  */

  /*SOLUTION*/
  var pCOD = COD - sCOD; //551 g/m3
  var US   = fSus*COD;   // 53 g/m3
  var BS   = sCOD - US;  //146 g/m3
  var UP   = fSup*COD;   //113 g/m3
  var BP   = pCOD - UP;  //438 g/m3

  //return results object
  return {
    pCOD:{value:pCOD, unit:"g/m3", descr:"Particulate COD"},
    US  :{value:US,   unit:"g/m3", descr:"Soluble     & Unbiodegradable COD"},
    BS  :{value:BS,   unit:"g/m3", descr:"Soluble     & Biodegradable   COD"},
    UP  :{value:UP,   unit:"g/m3", descr:"Particulate & Unbiodegradable COD"},
    BP  :{value:BP,   unit:"g/m3", descr:"Particulate & Biodegradable   COD"},
  };
};

/*test*/
(function(){
  var debug=false;
  if(debug==false)return;
  var COD  = 750;
  var sCOD = 199;
  var fSus = 0.07;
  var fSup = 0.15;
  console.log(
    fractionation_ekama(COD,sCOD,fSus,fSup)
  );
})();
