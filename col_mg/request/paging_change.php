<?php

  include_once('../database_config.php');

  //POST PARAMETER

  $paging_number=$_POST["paging_number"];


  //データベースに接続

 $link=mysqli_connect(DB_SERVER, DB_ACCOUNT_ID, DB_ACCOUNT_PW ,DB_NAME);

 if(!$link) {

      echo "Error: Unable to connect to MySQL." . PHP_EOL;

      echo "Debugging errno: " . mysqli_connect_errno() . PHP_EOL;

      echo "Debugging error: " . mysqli_connect_error() . PHP_EOL;

      exit;

 }

  mysqli_set_charset($link, "utf8");
 

  //paging_numberを変更
 $query='update paging_info set paging_number='.$paging_number.'';

 if($result=mysqli_query($link, $query)){

    header('location: ./paging_change_form.php');

  }
  

?>

