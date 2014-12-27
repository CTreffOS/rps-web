<?php
error_reporting(E_ALL);
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
    case 'registerp':
      return 'inc/register.php';
      break;
    case 'uploadp':
      return 'inc/upload.php';
      break;
    case 'docker':
      return 'html/docker.html';
      break;
    case 'dockerp':
      return 'inc/docker.php';
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
     <?php if(isset($_SESSION['voucher'])) if($_SESSION['voucher']==true)echo('<a href="index.php?site=sclose">End session</a>'); ?>
    </div>
  </body>
</html>
