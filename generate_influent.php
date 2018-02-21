<?php /*
  * description
  *   generate influent file
*/?>
<!doctype html><html><head>
  <?php include'imports.php'?>
  <title>Generate influent file</title>
  <script>
    function init(){
      //
    }

    //frontend: populate table "t" with input "i"
    function process_input(t,i){
      var newRow=t.insertRow(-1);
      newRow.title=i.descr;
      newRow.insertCell(-1).outerHTML="<th>"+i.id;
      newRow.insertCell(-1).innerHTML="<input type=number value='"+i.value+"'>";
      newRow.insertCell(-1).innerHTML="<small>"+i.unit.prettifyUnit()+"</small>";
    }
  </script>
  <style>
    #root table {
      font-size:smaller;
      border-collapse:collapse;
    }
    #root table th {
      text-align:left;
      cursor:help;
    }
  </style>
</head><body onload="init()">
<?php include'navbar.php'?>

<div id=root>

<div>
  <h1>Generate influent file</h1>
  <p>Generate a downloadable and portable influent file in plain text.</p>
  <small>Note: mouse over the variables to see a description.</small>
</div><hr>

<!--1. Inputs-->
<div class=flex>
  <!--technologies-->
  <div>
    <p>1. Activate technologies</p>
    <table id=technologies border=1></table>
    <script>
      //fill technologies
      (function(){
        var t=document.querySelector('#technologies');
        for(var tec in Technologies){
          var tech=Technologies[tec];
          if(tech.notActivable){continue;}
          var newRow=t.insertRow(-1);
          newRow.title=tech.Name;
          newRow.insertCell(-1).outerHTML="<th>"+tech.Name;
          newRow.insertCell(-1).innerHTML="<input type=checkbox "+(tech.value?"checked":"")+">";
        }
      })();
    </script>
  </div><hr>

  <!--normal inputs-->
  <div>
    <p>2. Influent characteristics</p>
    <table id=inputs border=1></table>
    <script>
      //fill normal inputs
      (function(){
        var t=document.querySelector('#inputs');
        Inputs.filter(i=>{return !i.isParameter && !i.isMetal}).forEach(i=>{
          process_input(t,i);
        });
      })();
    </script>
  </div><hr>

  <!--metals-->
  <div>
    <p>3. Influent Metals</p>
    <table id=metals border=1></table>
    <script>
      //fill normal inputs
      (function(){
        var t=document.querySelector('#metals');
        Inputs.filter(i=>{return i.isMetal}).forEach(i=>{
          process_input(t,i);
        });
      })();
    </script>
  </div><hr>

  <!--design parameters-->
  <div>
    <p>4. Design parameters</p>
    <table id=design_parameters border=1></table>
    <script>
      //fill normal inputs
      (function(){
        var t=document.querySelector('#design_parameters');
        Inputs.filter(i=>{return i.isParameter}).forEach(i=>{
          process_input(t,i);
        });
      })();
    </script>
  </div><hr>

  <!--btn generate-->
  <div>
    <p>5. Generate file</p>
    <button style="display:block;margin:auto;font-size:20px">Generate influent file (JSON)</button>
  </div>
</div>
