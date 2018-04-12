<!doctype html><html><head>
  <?php include'imports.php'?>
  <title>Technologies</title>
  <!--css at the end-->
</head><body>
<?php include'navbar.php'?>
<div id=root>

<!--technologies table-->
<h1>
  All Technologies
  (<span id=number_of_technologies></span>)
  <script>
    document.querySelector('#number_of_technologies').innerHTML=Object.keys(Technologies).length;
  </script>
</h1>

<div>
  <table id=technologies border=1>
    <tr><th>id<th>Technology<th>Activable<th>Implemented in<th><a href=inputs.php>Inputs</a> required
  </table>
  <script>
    //fill technologies table
    (function(){
      var t=document.querySelector('#technologies');
      for(var tec in Technologies) {
        var el=Technologies[tec];
        var newRow=t.insertRow(-1);
        newRow.insertCell(-1).innerHTML=tec;
        newRow.insertCell(-1).innerHTML=el.Name;
        newRow.insertCell(-1).innerHTML=el.notActivable ? "no":"yes";
        newRow.insertCell(-1).innerHTML="<a href='see.php?path=techs&file="+el.File+"'>"+el.File+"</a>";
        newRow.insertCell(-1).innerHTML=( ()=>{
          var str=[]
          el.Inputs.forEach(key=>{
            if(Inputs.map(i=>{return i.id}).indexOf(key)+1){
              str.push("<span class=help title='"+getInputById(key).descr+"'>"+key+"</span>")
            }
          });
          return str.join(', ');
        })();
      }
    })();
  </script>
</div>
