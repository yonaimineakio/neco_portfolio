<?php

   require_once("../database_config.php");

   session_save_path('/home/a_yonamine/session');

   session_start();

   //セッションから変数をセット
   $login_name=$_SESSION["employee_name"];

   $master_id=(isset($_GET["ei"])) ? $_GET["ei"] : $_SESSION["master_id"];

   $master_number=(isset($_GET["filter"])) ? $_GET["filter"] : $_SESSION["master_number"];

    //データベース接続


   $link=mysqli_connect(DB_SERVER,DB_ACCOUNT_ID,DB_ACCOUNT_PW,DB_NAME);

   if (!$link) {

      echo "Error: Unable to connect to MySQL." . PHP_EOL;

      echo "Debugging errno: " . mysqli_connect_errno() . PHP_EOL;

      echo "Debugging error: " . mysqli_connect_error() . PHP_EOL;

      exit;

   }



   // 抽出する際のエンコードを設定

   mysqli_set_charset($link,"utf8");



 //Query

 if($master_number=="1") {
 

   $query='select * from department_info where department_id='.$master_id.'';
   

  }else{

   $query='select * from position_info where position_id='.$master_id.'';
  
  }


  //実行

  if($result=mysqli_query($link, $query)){

    $i=0;
     while($row=mysqli_fetch_row($result)){

     

      $master_name[$i]=$row[1];
       
      $i++;
  
     }


 
  mysqli_free_result($result);


 }

 mysqli_close($link);
 
 
 require_once("../header.php");

if(is_readable("./masterdetail.html")){


 $fp=fopen("./masterdetail.html", "r");


//読み込んでいるHTMLファイルが、上から読み込んで最終行になるまで処理を繰り返す。
  while(!feof($fp)) {


    $line=fgets($fp);

    $line1=str_replace("<###HEADER###>", $header_list, $line);

    $line2=str_replace("<###LOGINNAME###>", $login_name, $line1);

    $line3=($master_number=="1") ? str_replace("<###MASTER###>", "部署", $line2) : str_replace("<###MASTER###>",  "役職", $line2);

    $line4=str_replace("<###MASTERNAME###>", $master_name[0], $line3);

    $line5=str_replace("<###HIDEMASTERNUMBER###>", $master_number, $line4);

    $line6=str_replace("<###MASTERID###>", $master_id, $line5);

    echo $line6;


  }

  

  exit();
}


 ?>
