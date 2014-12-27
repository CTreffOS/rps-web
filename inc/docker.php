<?php
# docker.php
# @author: Eric Lanfer (eric@brainfact.de)
# Upload .tar files to directory
if(isset($_SESSION['code'])&& $_SESSION['voucher']&& isset($_SESSION['username']))
{
  if(isset($_POST['docker']))
  {
  $docker = $_POST['docker'];
  $username = $_SESSION['username'];
  $code = $_SESSION['code'];
  $db = new PDO('sqlite:/var/www/html/rps-web/db/web.db');
  $db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
  $query = $db->prepare('SELECT username, email, dect, code FROM users WHERE code = :code LIMIT 1');
  $query->bindParam(':code', $code, PDO::PARAM_INT);
  $query->execute();
  $result = $query->fetchALL();
  if(($username==$result[0]['username'])&&($code==$result[0]['code']))
  {
	date_default_timezone_set('Europe/Berlin');
    $date=new DateTime();
    $dirname = strtolower($username.$date->getTimestamp());
    $target_dir = 'upload/'.$dirname.'/';
    mkdir('upload/'.$dirname.'', 0777);
        echo('Your upload was successful!');
        require_once('inc/session_close.php');
        $sqlfile = fopen("upload/".$dirname."/insert.sql", "w") or die("Error while saving file!");
        $content = "insert into user (name, email, code, docker_image) values ('".$username."', '".$result[0]['email']."', '".$code."', '".$docker."');";
        fwrite($sqlfile, $content);
        fclose($sqlfile);
      }
    else
    {
      echo('Authetication Error');
    }
  }
  else echo('Oops, a wild error occurs...');
}
else echo('You are not authenticated. Click <a href="index.php">here</a> to get to authentication form.');
