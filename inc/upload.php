<?php
# upload.php
# @author: Eric Lanfer (eric@brainfact.de)
# Upload .tar files to directory
if(isset($_FILES['file']))
{
if(!isset($_FILES['file']['error'])||is_array($_FILES['file']['error']))
{
  $error_handler = true;
}
$target_dir = 'rps/';
$target_file = $target_dir . basename($_FILES['file']['name']);
$finfo = new finfo(FILEINFO_MIME_TYPE);
$file_type = $finfo->file($_FILES['file']['tmp_name']);
$error_handler = false;
if(file_exists($target_file))
{
  $date=new DateTime();
  $target_file = $target_dir.$date->getTimestamp().basename($_FILES['file']['name']);
}
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
