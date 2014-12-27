<?php
  if(!isset($_POST['code']))
  {
	  $code = false;
     echo('Authentication failed, get <a href="index.php">back</a> and try again. If you have any trouble contact CTreffOS Member.');
  }
  else
  {
	  $code = $_POST['code'];
  if(!isset($_SESSION['voucher'])||$_SESSION['voucher']==false)
  {
    $db = new PDO('sqlite:/var/www/html/rps-web/db/web.db');
    $db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    $query = $db->prepare('SELECT code FROM codes');
    $query->execute();
    $dbcodes = $query->fetchALL(PDO::FETCH_COLUMN, 0);
    if(in_array($code, $dbcodes))
    {
     $_SESSION['voucher'] = true;
     $_SESSION['code']= $code;
     $query= $db->prepare('DELETE FROM codes WHERE code=:code');
     $query->bindParam(':code', $code, PDO::PARAM_INT);
     $query->execute();
     $query= $db->prepare('INSERT INTO users (code) VALUES (:code)');
     $query->bindParam(':code', $code, PDO::PARAM_INT);
	  if($query->execute())
	  {
		  $db = NULL;
		  echo('Code check was successful, please click <a href="index.php?site=register">here</a> to get to registration form.');
	  }
     else
	  {
		  $db = NULL;
		  echo('Authentication failed, get <a href="index.php">back</a> and try again. If you have any trouble contact CTreffOS Member.');
	  }
   }
    else
	 {
		 $db = NULL;
     echo('Authentication failed, get <a href="index.php">back</a> and try again. If you have any trouble contact CTreffOS Member.');
    }
  }
  else
  {
	  $db = NULL;
     echo('Code check was successful, please click <a href="index.php?site=register">here</a> to get to registration form.');
  }
  }

?>
