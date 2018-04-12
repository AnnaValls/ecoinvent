/**
  * ENERGY CONSUMPTION
  *
  */

function energy_consumption(Q, Qwas, RAS, OTRf, mixing_power, IR, P_X_TSS, influent_H, is_Pri_active){
  //1. AERATION power
  var SAE            = 4;            //kgO2/kWh (taken from Oliver Schraa's aeration book)
  var aeration_power = OTRf/SAE ||0; //kW

  //2. MIXING power (anoxic, denitrification)

  //3. PUMPING power
  var PE_Qr   = 0.008; //kWh/m3 -- external recirculation factor
  var PE_Qint = 0.004; //kWh/m3 -- internal recirculation (anoxic, denitri) factor
  var PE_Qw   = 0.050; //kWh/m3 -- wastage factor
  var Pumping = {
    external: Q*RAS*PE_Qr,  //kWh/d
    internal: Q*IR*PE_Qint, //kWh/d
    wastage : Qwas*PE_Qw,   //kWh/d
    influent:function(){
      var rho = 1000;       //kg/m3 (density)
      var H   = influent_H; //m     (head)
      return rho*g*Q*H/1000/(24*3600); //kW -- divided by 1000 to have kW (from W) and m3/d converted to m3/s
      /*
        Influent pumping power P = rho.g.Q.H where (P in in Watts)
        rho is density of water = 1000 kg/m^3
        g = gravitation constant = 9.81 m/s^2
        Q is flow in m^3/s
        H is water lift height and friction head in m.
        You can use a standard lift height of 10 m.
        User can change it if they have a better height.
        With Archimedian screw pumps I think the friction head
        is probably about 10% of the static head.
        P excludes losses in gear box and electrical
        inefficiency. So for electrical power consumption
        these losses increase the power consumption.
        Archimedian screw pumps draw power proportional to the flux of water
        lifted, i.e draw low power at low flow and high power at high flow. This means
        you can use the average dry wearther flow as the kWh/d because the power
        balanaces out over a 24h day.
      */
    },//kW
  };
  var pumping_power_influent = Pumping.influent();  //kW
  var pumping_power_external = Pumping.external/24; //kW
  var pumping_power_internal = Pumping.internal/24; //kW
  var pumping_power_wastage  = Pumping.wastage/24;  //kW
  var pumping_power = pumping_power_influent + pumping_power_external + pumping_power_internal + pumping_power_wastage;

  //4. DEWATERING power
  var dewatering_factor = 20;                                //kWh/tDM (tone dry matter)
  var dewatering_power  = P_X_TSS/1000*dewatering_factor/24; //kW

  //5. OTHER power: regression equations from lcorominas
  var other_power = (function(){
    if(is_Pri_active){
      return 0.0124*Q + 337.77; //kWh/d
    }else{
      return 0.0165*Q + 337.59; //kWh/d
    }
  })()/24; //converted to kW dividing by 24

  //6. TOTAL power
  var total_power = aeration_power + mixing_power + pumping_power + dewatering_power + other_power;

  var rv={
    'SAE':                     {value:SAE,                     unit:"kg_O2/kWh",  descr:"kg O2 that can be aerated with 1 kWh of energy"},
    'aeration_power':          {value:aeration_power,          unit:"kW",         descr:"Power needed for aeration (=OTRf/SAE)"},
    'mixing_power':            {value:mixing_power,            unit:"kW",         descr:"Power needed for anoxic mixing"},
    'pumping_power_influent':  {value:pumping_power_influent,  unit:"kW",         descr:"Power needed for pumping influent"},
    'pumping_power_external':  {value:pumping_power_external,  unit:"kW",         descr:"Power needed for pumping (external recirculation)"},
    'pumping_power_internal':  {value:pumping_power_internal,  unit:"kW",         descr:"Power needed for pumping (internal recirculation)"},
    'pumping_power_wastage':   {value:pumping_power_wastage,   unit:"kW",         descr:"Power needed for pumping (wastage recirculation)"},
    'pumping_power':           {value:pumping_power,           unit:"kW",         descr:"Power needed for pumping (ext+int+was)"},
    'dewatering_power':        {value:dewatering_power,        unit:"kW",         descr:"Power needed for dewatering"},
    'other_power':             {value:other_power,             unit:"kW",         descr:"Power needed for 'other' (20% of total)"},
    'total_power':             {value:total_power,             unit:"kW",         descr:"Total power needed"},
    'total_daily_energy':      {value:total_power*24,          unit:"kWh/d",      descr:"Total daily energy needed"},
    'total_energy_per_m3':     {value:total_power*24/Q||0,     unit:"kWh/m3",     descr:"Total energy needed per m3"},
  };
  return rv
}

//test
//energy_consumption(22700, 169.5, 0.6, 170.7, 5.617, 2.082, 1219, 10, true);
