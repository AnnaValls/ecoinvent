<!doctype html><html><head>
  <?php include'imports.php'?>
  <script src="https://cdn.rawgit.com/google/code-prettify/master/loader/run_prettify.js"></script>
  <style>
    pre.prettyprint { border:none; }
  </style>
  <script>
    var received_json = JSON.parse('<?php echo $_POST['input'] ?>');
    function generate_ecospold(){
      post('ecospold/index.php', "python3 generate_ecospolds.py '"+JSON.stringify(received_json)+"'",false);
    }
  </script>
  <title>3/4 Results dataset</title>
</head><body><?php include'navbar.php'?>
<div id=root>
<h1>
  3. Results dataset
  <small>(step 3 of 4)</small>
</h1>

<div>
  <!--continue btn-->
  <div style=text-align:right>
    <div>
      Next step:
      <button
        style="background:yellow"
        onclick="generate_ecospold()"
      >Generate ecoSpold files</button>
    </div>
    <!--debug
      <div>
        <button onclick=selectText(document.getElementById('received_json'))>select</button>
        and copy, then paste
        <a href="https://jsonformatter.curiousconcept.com/">here</a>.
        <script>
          function selectText(el) {
            var body = document.body, range, sel;
            if (document.createRange && window.getSelection) {
              range = document.createRange();
              sel = window.getSelection();
              sel.removeAllRanges();
              try {
                range.selectNodeContents(el);
                sel.addRange(range);
              }catch(e){
                range.selectNode(el);
                sel.addRange(range);
              }
            } else if (body.createTextRange) {
              range = body.createTextRange();
              range.moveToElementText(el);
              range.select();
            }
          }
        </script>
      </div>
    -->
  </div><hr>

  <div style=font-size:smaller>
    The following data will be saved as two new ecoSpold files:
  </div>

  <!--received json-->
  <pre id=received_json class=prettyprint style="border:1px solid #ccc"></pre>
</div>

<script>
  (function(){
    //show stringified input json at start
    document.getElementById('received_json').innerHTML=JSON.stringify(received_json,null,"  ");
  })();
</script>
