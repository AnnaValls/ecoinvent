<?php /* */ ?>
<!doctype html><html><head>
  <?php include'imports.php'?>
  <title>Marginal approach</title>
  <script>
    function init(){
      /*
       * call backend functions
       */
    }
  </script>
  <style>
    #root #inputs
  </style>
</head><body onload="init()">
<?php include'navbar.php'?>
<div id=root>
<h1>Marginal approach</h1>
<p>
  Here you can study the contribution of one influent to the effluent of the sum of two influents.
</p>
<p>
  status: under development
  <ul>
    <li>influent mixing already works
    <li>effluent comparison still not working
  </ul>
</p>

<hr>

<div class=flex>
  <!--1. Influents to mix-->
  <div>
    <p>1. Enter the two influents to be mixed:</p>
    <table id=inputs border=1>
      <tr>
        <th>Input
        <th>Influent 1
        <th>Influent 2
        <th>Influent 1+2
        <th>Unit
      <tr>
    </table>
  </div>
  <hr>
  <div>
    <div>
      <p>2. Activate removal technologies
      <table id=technologies border=1></table>
      <script>
        //populate technologies table
        (function(){
          //get table by id
          var t=document.getElementById('technologies');

          //new row
          var newRow=t.insertRow(-1);

          //create a imaginary state for technologies
          var Techs_selected={
            "BOD":true,
            "Nit":false,
            "Des":false,
            "BiP":false,
            "ChP":false,
          };

          //go over technologies
          for(var i in Technologies){
            var tec=Technologies[i];
            if(tec.notActivable)continue;
            var newRow=t.insertRow(-1);
            newRow.insertCell(-1).innerHTML=tec.Name;
            var checked = Techs_selected[i] ? "checked":"";
            newRow.insertCell(-1).innerHTML="<input type=checkbox "+checked+">";
          }
        })();
      </script>
    </div>
    <div>
      <p>3. Enter design parameters</p>
      <table id=design_parameters>
      </table>
      <script>
        //populate results table
        (function(){
          var t=document.querySelector('table#design_parameters');
          Inputs.filter(i=>{return i.isParameter}).forEach(i=>{
            var newRow=t.insertRow(-1);
            newRow.title=i.descr;
            //design parameter id
            newRow.insertCell(-1).innerHTML=i.id;
            //input element
            newRow.insertCell(-1).innerHTML="<input type=number value='"+i.value+"'>";
            //unit
            newRow.insertCell(-1).innerHTML="<small>"+i.unit.prettifyUnit()+"</small>";
          });
        })();
      </script>
    </div>
  </div>
  <hr>
  <div>
    <p>4. Results</p>
    <table id=results border=1>
      <tr><th colspan=4>Contribution of Influent 1 to the total effluent
      <tr><th>Compound<th>Water<th>Air<th>Sludge
    </table>
    <script>
      //populate results table
      (function(){
        var t=document.querySelector('table#results');
        for(var o in Outputs){
          var newRow=t.insertRow(-1);
          newRow.insertCell(-1).innerHTML=o;
          //water
          newRow.insertCell(-1).innerHTML="0%";
          //air
          newRow.insertCell(-1).innerHTML="0%";
          //sludge
          newRow.insertCell(-1).innerHTML="0%";
        }
      })();
    </script>
  </div>
</div><hr>

<p>
  <b>Note</b>:
  If the tool has been updated recently it may not work due to the browser keeping development files in a place called "the cache". 
  To make sure you flush the old files and have the latest ones, click here:<br>
  <button onclick="window.location.reload(true)">Clear cache</button>
</p>

<script>
  //total flow (inf1+inf2)
  var total_Q=0;

  //populate DOM
  (function(){
    var t=document.querySelector('table#inputs');
    Inputs.filter(i=>{return !i.isParameter}).forEach(i=>{
      var newRow=t.insertRow(-1);
      //row attrs
      newRow.id=i.id;
      newRow.title=i.descr;
      //col 1: input id
      newRow.insertCell(-1).innerHTML=i.id;
      //col 2: input1
      newRow.insertCell(-1).innerHTML="<input onchange=mix_influents() inf=1 type=number value='"+i.value+"'>";
      //col 3: input2
      newRow.insertCell(-1).innerHTML="<input onchange=mix_influents() inf=2 type=number value='"+i.value+"'>";
      //col 4: mixed influents
      newRow.insertCell(-1).outerHTML="<td style=text-align:right><span mixed>0</span></td>";
      //col 5: unit
      newRow.insertCell(-1).outerHTML="<td style=font-size:smaller>"+i.unit.prettifyUnit()+"</td>";
    });
    mix_influents();
  })();

  function mix_influents(){
    mix_input('Q');
    mix_input('T');
    mix_input('COD');

    Inputs.filter(i=>{return !i.isParameter}).forEach(i=>{
      mix_input(i.id);
    });

    function mix_input(id){
      var input1=document.querySelector('tr[id='+id+'] input[inf="1"]');
      var input2=document.querySelector('tr[id='+id+'] input[inf="2"]');
      var output=document.querySelector('tr[id='+id+'] span[mixed]');
      var value1=parseFloat(input1.value);
      var value2=parseFloat(input2.value);
      if(id=="Q"){
        total_Q=value1+value2;
        output.innerHTML=format(total_Q);
      }
      else{
        var Q1=parseFloat(document.querySelector('tr[id=Q] input[inf="1"]').value);
        var Q2=parseFloat(document.querySelector('tr[id=Q] input[inf="2"]').value);
        var mass1=Q1*value1; //g/d
        var mass2=Q2*value2; //g/d
        var conc=(mass1+mass2)/total_Q;
        output.innerHTML=format(conc);
      }
    }
  }
</script>
