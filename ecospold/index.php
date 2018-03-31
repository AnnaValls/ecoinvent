<?php
  $cmd=isset($_GET['cmd']) ? $_GET['cmd'] : 'python test.py a b c d';
  //$cmd=escapeshellcmd($cmd);
?>

<!--shell prompt-->
<form method=GET>
$ <input name=cmd id=cmd value="<?php echo $cmd?>" placeholder="write command here" style="width:50%">
</form>

<!--input-->
<?php echo "<h3><code>&gt; $cmd</code></h3>"?>

<!--output-->
<pre><code><?php
  //var_dump(shell_exec($cmd." 2>&1")); //debugging
  $result=shell_exec($cmd." 2>&1");
  echo $result;
?>
</code></pre>

<hr>

Ecospold files:
<ul>
<?php
  $folder="wastewater_treatment_tool/output";
  $ls=scandir($folder);
  //loop all files in $folder
  foreach($ls as $file){
    //omit folders
    if(is_dir($file))continue;
    //print the link to the json file
    echo "<li>
      <a href='$folder/$file' target=_blank>$file</a>
      |
      <a href='$folder/$file' download>download</a>
    ";
  }
?>
</ul>

<!--focus on cmd prompt-->
<script>document.querySelector('#cmd').select();</script>
