<?php
  if(!isset($_SESSION['voucher'])||$_SESSION['voucher']==false)
  {
    session_start();
    $db = new PDO('sqlite:web.db');
    $code = $_POST['code'];
    $query = $db->prepare('SELECT code FROM codes');
    $query->execute();
    $dbcodes = $query->fetchALL(PDO::FETCH_COLUMN, 0);
    if(in_array($code, $dbcodes))
    {
     echo('Erfolgreich');
     $_SESSION['voucher'] = true;
     $query->prepare('DELETE FROM codes WHERE code='.$code.'');
     $query->execute();
     $query->perpare('INSERT INTO users (code) VALUES ('.$code.')');
     $query->execute();
    }
    else
    {
      echo('Authentication failed, please try again');
    }
  }
  else if($_SESSION['voucher']==true)
  {
    echo('NAme und co');
  }

?>  
