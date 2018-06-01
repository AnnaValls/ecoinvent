<!doctype html><html><head>
  <?php include'imports.php'?>
  <!--css styles are at the end-->
  <title>Ecoinvent</title>
</head><body>
<?php include'navbar.php'?>
<div id=root>
<h1>Home page</h1><hr>

<p class=wip>
  Note: yellow background means "under development"
</p>

<!--content-->
<p style=max-width:50em>
  <!--introduction text-->
  <div class=wip><p>
    Introductory text.
    <div>
      Steps:
      <ol>
        <li>Step 1
        <li>Step 2
        <li>...
      </ol>
    </div>
  <p></div><hr>

  <!--access button-->
  <div>
    <button
      id=btn_access
      style="font-size:28px"
      onclick="window.location='simplified_data_entry.php'">
      Access the tool
    </button>
    <style>
      #btn_access {
        background-color: #5cb85c;
        border: 1px solid transparent;
        border-color: #ccc;
        color: #fff;
        cursor: pointer;
        font-size: 14px;
        font-weight: 400;
        line-height: 1.42857143;
        outline:none;
        padding: 6px 12px;
        text-align: center;
        user-select: none;
        vertical-align: middle;
        white-space: nowrap;
      }
      #btn_access:hover {
        background-color: #449d44;
        border-color: #398439;
        box-shadow: 0 8px 16px 0 rgba(0,0,0,0.05);
      }
      #btn_access:active {
        box-shadow:inset 0 0 10px #000;
      }
    </style>
  </div><hr>

  <!--other info-->
  <div>
    <ul>
      <li><a href="#" class=wip>Methodological report</a>
      <li><a href="additional_info.php">Additional info</a>
    </ul>
  </div>
</p>
