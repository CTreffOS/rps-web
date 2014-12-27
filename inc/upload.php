<?php
# upload.php
# @author: Eric Lanfer (eric@brainfact.de)
# Upload .tar files to directory
if(isset($_SESSION['code'])&& $_SESSION['voucher']&& isset($_SESSION['username']))
{
  $username = $_SESSION['username'];
  $code = $_SESSION['code'];
  $db = new PDO('sqlite:web.db');
  $db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
  $query = $db->prepare('SELECT username, email, dect, code FROM users WHERE code = :code LIMIT 1');
  $query->bindParam(':code', $code, PDO::PARAM_INT);
  $query->execute();
  $result = $query->fetchALL();
  if(($username==$result[0]['username'])&&($code==$result[0]['code']))
  {
    if(file_exists($_FILES['file']['tmp_name']))
    {
      if(!isset($_FILES['file']['error'])||is_array($_FILES['file']['error']))
      {
        $error_handler = true;
      }
    $date=new DateTime();
    $dirname = $username.$date->getTimestamp();
    $target_dir = 'upload/'.$dirname.'/';
    mkdir('upload/'.$dirname.'', 0777);
    $target_file = $target_dir . basename($_FILES['file']['name']);
    $finfo = new finfo(FILEINFO_MIME_TYPE);
    $file_type = $finfo->file($_FILES['file']['tmp_name']);
    $error_handler = false;
    if($_FILES['file']['size'] > 50000000)
    {
      $error_handler = true;
    }
    if($file_type != 'application/x-gzip')
    {
      $error_handler = true;
    }
    if($error_handler === true)
    {
      echo('There was an error while uploading your file, please make sure that your filetype is .tar.gz and that it is not biggert than 50MB.');
    }
    if($error_handler === false)
    {
      if(move_uploaded_file($_FILES['file']['tmp_name'], $target_file))
      {
        echo('Your upload was successful!');
        require_once('inc/session_close.php');
        $sqlfile = fopen("upload/".$dirname."/insert.sql", "w") or die("Error while saving file!");
        $content = "insert into user (name, email, code, docker_image) values ('".$username."', '".$result[0]['email']."', '".$code."', 'rockpaperscissors/".code."');";
        fwrite($sqlfile, $content);
        fclose($sqlfile);
      }
      else
      {
        echo('There was an error while uploading your file, please try again if it does not work contact the CTreffOS Team');
      }
    }
    }
    else
    {
      echo('You need to select a file to upload');
    }
  }
  else echo('Oops, a wild error occurs...');
}
else echo('You are not authenticated. Click <a href="index.php">here</a> to get to authentication form.');
