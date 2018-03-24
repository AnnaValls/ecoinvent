<?php /*
*/?>
<!doctype html><html><head>
  <?php include'imports.php'?>
  <title>Multiple WWTPs</title>

  <script>
    var WWTPs=[
      {name:'plant 1'},
      {name:'plant 2'},
    ];

    function add_wwtp(){
      WWTPs.push({name:'plant '+(1+WWTPs.length)});
      redisplay_wwtps();
    }

    function redisplay_wwtps(){
      //populate table wwtps
      (function(){
        var table=document.querySelector('table#wwtps');
        table.innerHTML="";

        //add wttp names
        (function(){
          var newRow=table.insertRow(-1);
          newRow.insertCell(-1).outerHTML="<th>WWTP name";
          //add a <td> for each WWTP
          WWTPs.forEach((wwtp,i)=>{
            var newCell=newRow.insertCell(-1)
            newCell.innerHTML="<input type=text value='"+wwtp.name+"'>";
            //remove wwtp button
            newCell.appendChild((function(){
              var btn=document.createElement('button');
              btn.innerHTML='&#9003;';
              btn.addEventListener('click',function(){
                WWTPs.splice(i,1);
                redisplay_wwtps();
              });
              return btn;
            })());
          });
        })();

        //fold technologies button
        (function(){
          var newRow=table.insertRow(-1);
          var newCell=document.createElement('th');
          newRow.appendChild(newCell);
          newCell.colSpan=1+WWTPs.length;
          newCell.style.textAlign='left';
          //add <button>+/-</button> Metals
          newCell.appendChild((function(){
            var btn=document.createElement('button');
            btn.innerHTML='↓';
            btn.addEventListener('click',function(){
              this.innerHTML=(this.innerHTML=='→')?'↓':'→';
              Technologies_selected
                .filter(tec=>{return !tec.notActivable})
                .forEach(i=>{
                var h=document.querySelector('#wwtps #'+i.id);
                h.style.display=h.style.display=='none'?'':'none';
              });
            });
            return btn;
          })());
          newCell.appendChild((function(){
            var span=document.createElement('span');
            span.innerHTML=' Technologies';
            return span;
          })());
        })();

        //add technologies
        (function(){
          //only technologies activable by user
          Technologies_selected
            .filter(tec=>{return !tec.notActivable})
            .forEach(tec=>{
              var newRow=table.insertRow(-1);
              newRow.id=tec.id;
              //add tec name
              newRow.insertCell(-1).innerHTML=tec.descr;
              //add a checkbox for each tec
              WWTPs.forEach(wwtp=>{
                var checked = getInput(tec.id,true).value ? "checked" : "";
                newRow.insertCell(-1).outerHTML="<td style=text-align:center>"+
                  "<input type=checkbox "+checked+" onchange=\"toggleTech('"+tec.id+"')\" tech='"+tec.id+"'>";
              });
          });
        })();

        //fold design parameters button
        (function(){
          var newRow=table.insertRow(-1);
          var newCell=document.createElement('th');
          newRow.appendChild(newCell);
          newCell.colSpan=1+WWTPs.length;
          newCell.style.textAlign='left';
          //add <button>+/-</button> Metals
          newCell.appendChild((function(){
            var btn=document.createElement('button');
            btn.innerHTML='↓';
            btn.addEventListener('click',function(){
              this.innerHTML=(this.innerHTML=='→')?'↓':'→';
              Inputs.filter(i=>{return i.isParameter}).forEach(i=>{
                var h=document.querySelector('#wwtps #'+i.id);
                h.style.display=h.style.display=='none'?'':'none';
              });
            });
            return btn;
          })());
          newCell.appendChild((function(){
            var span=document.createElement('span');
            span.innerHTML=' Design parameters';
            return span;
          })());
        })();

        //add design parameters
        Inputs.filter(i=>{return i.isParameter}).forEach(i=>{
          var newRow=table.insertRow(-1);
          newRow.id=i.id;

          //insert cells
          newRow.title=i.descr;
          newRow.insertCell(-1).outerHTML="<td class=help>"+i.id;

          //add a <input> for each WWTP
          WWTPs.forEach(wwtp=>{
            var newCell=newRow.insertCell(-1)
            newCell.innerHTML="<input value='"+i.value+"' type=number step=any onchange=setInput('"+i.id+"',this.value) min=0>"
          });

          newRow.insertCell(-1).outerHTML="<td class=unit>"+i.unit.prettifyUnit();
        });
      })();
    }
  </script>

  <!--load backend: elementary flows and mass balances-->
  <script src="elementary.js"></script>

  <!--init-->
  <script>
    function init(){
      redisplay_wwtps();
    }
  </script>

  <!--CSS-->
  <style>
    #wwtps {
      font-size:smaller;
    }
    #wwtps input[type=number],
    #wwtps input[type=text] {
      width:60px;
    }
  </style>
</head><body onload="init()">
<?php include'navbar.php'?>

<div id=root>
<!--title div--><div>
  <h1>Multiple plants (averaging)</h1>
</div>
<em>user interface draft</em>
<ul>
  <li>should the ww composition be visible here?
  <li>what would be the results like?
  <li><issue class=under_dev></issue>
</ul>
<hr>

<!--top buttons-->
<div>
  <div id=top_btns>
    <div class=flex>
      <button onclick="alert('under development')">Load</button>
      <button onclick="alert('under development')">Save</button>
      <button onclick="add_wwtp()" style=background:lightgreen>Add plant</button>
    </div>
    <style>
      #top_btns button{
        padding:0.5em 1em;
        margin:5px 5px 5px 0;
        display:block;
      }
    </style>
  </div>
</div><hr>

<!--main-->
<div class=flex style='justify-content:space-between'>
  <!--wwtps-->
  <table id=wwtps></table>

  <!--results-->
  <div>
    Results
    <issue class=under_dev></issue>
    <issue class=help_wanted></issue>
  </div>
</div><hr>

<!--btn reset cache--><p><small><?php include'btn_reset_cache.php'?></small></p>
