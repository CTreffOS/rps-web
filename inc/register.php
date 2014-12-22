<?php
  if(isset($_SESSION['code'])&& isset($_SESSION['voucher']))
  {
    if($_SESSION['voucher']==true)
    {
    $code = $_SESSION['code'];
    $errorhandler = false;
    if(isset($_POST['username'])) $username = $_POST['username'];
      else
      {
        $errorhandler = true;
        echo('For proceeding your code you have to enter a username. <a href="index.php?site=register">Return</a> to register form.');
      }
    if(isset($_POST['email'])) $email = $_POST['email'];
      else $email = NULL;

    if(isset($_POST['dect'])) $dect = $_POST['dect'];
      else $dect = NULL;
    if($errorhandler === false)
    {
    $_SESSION['username'] = $username;
    $db = new PDO('sqlite:web.db');
    $db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    $query = $db->prepare('UPDATE users SET username=:username, email=:email, dect=:dect WHERE code=:code');
    $query->bindParam(':username', $username, PDO::PARAM_STR);
    $query->bindParam(':email', $email, PDO::PARAM_STR);
    $query->bindParam(':dect', $dect, PDO::PARAM_INT);
    $query->bindParam(':code', $code, PDO::PARAM_INT);
    if($query->execute()) echo('Registration was successful. <br/>Choose your upload type:<ul><li><a href="index.php?site=docker">Provice Docker image on docker.io</a></li><li><a href="index.php?site=upload">Upload tar archive with code files</a></li></ul>') ;
    else echo('There was an error with the query, please try again.');

  }
  }
  else  echo('You are not authenticated. Click <a href="index.php">here</a> to get to authentication form.');
  }
  else
  {
    echo('You are not authenticated. Click <a href="index.php">here</a> to get to authentication form.');
  }
