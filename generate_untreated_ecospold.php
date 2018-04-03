<!doctype html><html><head>
  <?php include'imports.php'?>
  <title>Untreated WW ecospold</title>
  <script>
    var received_json = JSON.parse('<?php echo $_POST['input'] ?>');
  </script>
</head><body>
<?php include'navbar.php'?>
<div id=root>
<h1>Generating ecospold file...</h1>
<div>
  <b>The following data is going to be saved as a new ecospold file</b>
  <button
    style="font-size:18px;padding:0.5em 1em"
    onclick="genereate_untreated_ecospold()"
  >CONTINUE</button>
  <pre id=received_json style="border:1px solid #ccc"></pre>

  <script>
    function genereate_untreated_ecospold(){
      //detect OSname
      var OSName = "Unknown";
      if(window.navigator.userAgent.indexOf("Windows NT 10.0")!= -1) OSName="Windows 10";
      if(window.navigator.userAgent.indexOf("Windows NT 6.2") != -1) OSName="Windows 8";
      if(window.navigator.userAgent.indexOf("Windows NT 6.1") != -1) OSName="Windows 7";
      if(window.navigator.userAgent.indexOf("Windows NT 6.0") != -1) OSName="Windows Vista";
      if(window.navigator.userAgent.indexOf("Windows NT 5.1") != -1) OSName="Windows XP";
      if(window.navigator.userAgent.indexOf("Windows NT 5.0") != -1) OSName="Windows 2000";
      if(window.navigator.userAgent.indexOf("Mac")            != -1) OSName="Mac/iOS";
      if(window.navigator.userAgent.indexOf("X11")            != -1) OSName="UNIX";
      if(window.navigator.userAgent.indexOf("Linux")          != -1) OSName="Linux";

      //if windows...
      if(OSName.includes("Windows")){
        post('ecospold/index.php',"python generate_untreated_ecospold.py '"+JSON.stringify(received_json)+"'");
      }else{
        post('ecospold/index.php',     "./generate_untreated_ecospold.py '"+JSON.stringify(received_json)+"'");
      }
    }
  </script>
</div>

<script>
  (function(){
    document.getElementById('received_json').innerHTML=JSON.stringify(received_json,null,"  ");
  })();
</script>
