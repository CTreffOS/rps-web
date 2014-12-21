<?php
session_start();
function sw($name)
{
  switch($name) 
  {
    case 'upload':
      return 'html/upload.html';
      break;
    case 'register':
      return 'html/register.html';
      break;
    case 'authp':
      return 'inc/auth.php';
      break;
    case 'sclose':
      return 'inc/session_close.php';
      break;
    default:
      return 'html/auth.html';
  }
}
?>
<html>
  <head>
    <title>CTreffOS RPS Competition</title>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <meta http-equiv="content-encoding" content="gzip"  />
    <link rel="stylesheet" type="text/css" href="res/global.css" />
  </head>
  <body>
    <div id="head">
      <center><img src="res/img/normal.png" alt="Chaostreff Osnabrück"/>
      <h1>RPS Coding Competition</h1></center>
    </div>
    <div id="content">
      <?php 
        if(!isset($_GET['site']))
        {
          $site= 'none';
        }
        else $site = $_GET['site'];
        require_once(sw($site));?>
    </div>
    <div id="footer">
     <?php if(isset($_SESSION['voucher'])) if($_SESSION['voucher']==true)echo('<a href="index.php?site=sclose">New Upload</a>'); ?>
    </div>
  </body>
</html>
