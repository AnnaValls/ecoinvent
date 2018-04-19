<!doctype html><html><head>
  <?php include'imports.php'?>
  <script src="https://cdn.rawgit.com/google/code-prettify/master/loader/run_prettify.js"></script>
  <style>
    pre.prettyprint { border:none; }
  </style>
  <script>
    var received_json = JSON.parse('<?php echo $_POST['input'] ?>');
    function genereate_ecospold(){
      //change this when other server
      post('ecospold/index.php', "python3 generate_untreated_ecospold.py '"+JSON.stringify(received_json)+"'");
    }
    function selectText(el) {
      var body = document.body, range, sel;
      if (document.createRange && window.getSelection) {
        range = document.createRange();
        sel = window.getSelection();
        sel.removeAllRanges();
        try {
          range.selectNodeContents(el);
          sel.addRange(range);
        } catch (e) {
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
  <title>ecoSpold generation</title>
</head><body><?php include'navbar.php'?>
<div id=root><h1>Generating ecoSpold file...</h1>
<div>
  <div>
    The following data is going to be saved as two new ecoSpold files (untreated emissions and treated emissions):
  </div>
  <!--continue btn-->
  <div>
    <button
      style="font-size:16px;padding:0.618em 1em"
      onclick="genereate_ecospold()"
    >CONTINUE</button>
    <button onclick=selectText(document.getElementById('received_json'))>select</button>
    and copy, then paste
    <a href="https://jsonformatter.curiousconcept.com/">here</a>.
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
