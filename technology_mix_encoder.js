var Tec_mix_encoder = {};

Tec_mix_encoder.encode=function(wwtp){
  tecs=[
    'Pri', //primary settler
    'BOD', //bod removal only
    'Nit', //nitrification
    'Des', //denitrification
    'BiP', //biological P removal
    'ChP', //chemical   P removal
  ];
  var bit_string="";
  tecs.forEach(tec=>{
    bit_string+=(wwtp["is_"+tec+"_active"]?"1":"0");
  });
  return bit_string;
};
