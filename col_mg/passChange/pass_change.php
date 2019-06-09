<?php
  
  require_once("../database_config.php");


 //POST PARAMERTER

 $current_pas=$_POST["current_pas"];
 
 $new_pas=$_POST["new_pas"];

 $pas_confirmation=$_POST["pas_confirmation"];


  session_save_path("/home/a_yonamine/session/");

  session_start();

  $login_name=$_SESSION["employee_name"];

  $login_user_manager_flg=$_SESSION["manager_flg"];



    // データベースに接続

   $link=mysqli_connect(DB_SERVER,DB_ACCOUNT_ID,DB_ACCOUNT_PW,DB_NAME);

   if (!$link) {

      echo "Error: Unable to connect to MySQL." . PHP_EOL;

      echo "Debugging errno: " . mysqli_connect_errno() . PHP_EOL;

      echo "Debugging error: " . mysqli_connect_error() . PHP_EOL;

      exit;

   }



   // 抽出する際のエンコードを設定

   mysqli_set_charset($link,"utf8");
   
  //現在のパスワードを取得
$query='select password from employee_info where password="'.$current_pas.'"';
 

 if($result=mysqli_query($link, $query)){

   while($row=mysqli_fetch_assoc($result)) {

    $login_pas=$row["password"];

  }
  mysqli_free_result($result);
}

if(isset($login_pas) && ($current_pas===$login_pas)){
   
  

  }else{


  echo "エラー：現在のパスワードが一致しません";
  

  

  exit;
 
  }


 if($new_pas===$pas_confirmation){

  //Query

    $query='UPDATE employee_info SET password="'.$new_pas.'" where employee_name="'.$login_name.'"';
    

   //実行

     if($result=mysqli_query($link, $query)){

         mysqli_free_result($result);

         mysqli_close($link);


      ($login_user_manager_flg=="0") ? header("location: ../book/booklist.php") : header("location: ../request/requestlist.php");
         /*
          上記コードは以下と同じ意味
          if ($login_user_manager_flg=="0") {
                header("location: ../book/booklist.php")
          }else{
          
                header("location: ../request/requestlist.php");
          
          }
          
          
          */

     }else{

          echo "エラー：パスワード変更に失敗しました";

          exit;
  
     }
 

   }else{


   echo "エラー：新しいパスワードが一致しません";
   
   exit;  
   

   }





?>
