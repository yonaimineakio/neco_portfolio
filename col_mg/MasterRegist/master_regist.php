<?php 


    
 require_once("../database_config.php");

  //セッションをセット
 session_save_path("/home/a_yonamine/session");

 
 session_start();
 //POST PARAMETER
 $master_name=$_POST["master_name"];

 $master_number=$_POST["master_number"];

 $submit_option=$_POST["submit_option"];

 
 //役職,部署変更の為の変数

 if(isset($_POST["master_id"])) {

  $master_id=$_POST["master_id"];

}
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


 
   var_dump($master_number);

   var_dump($submit_option);

   var_dump($master_id);
 // 新規申請

if($master_number=="1"){

  if($submit_option=="1") {


    $query="select max(department_id)+1 as department_id from department_info";

    $result=mysqli_query($link, $query);

    while($row=mysqli_fetch_assoc($result)) {

     $new_id=$row["department_id"];

     }

    $query='insert into department_info(department_id, department_name) VALUES('.$new_id.', "'.$master_name.'")';

//変更
  }else if($submit_option=="2") {

    $query='update department_info set department_name="'.$master_name.'" where department_id='.$master_id.'';

    $target_master_id=$master_id;

 //削除　
  }else {

   $_SESSION["master_number"]=$master_number;

   $query='delete from department_info where department_id='.$master_id.'';

   if($result=mysqli_query($link, $query)){

     header("location: ./master_regist_form.php");

     exit();
    }
 }

}

if($master_number=="2"){
 if($submit_option=="1"){
  
   $query="select max(position_id)+1 as position_id from position_info"; 

   $result=mysqli_query($link, $query);

   while($row=mysqli_fetch_assoc($result)){
 
    $new_id=$row["position_id"];

   }

   $query='insert into position_info(position_id, position_name) VALUES("'.$new_id.'", "'.$master_name.'")';

  }else if($submit_option=="2") {

   $query='update position_info set position_name="'.$master_name.'" where position_id='.$master_id.'';

    $target_master_id=$master_id;

  }else {

   $query='delete from position_info where position_id='.$master_id.'';

   if(mysqli_query($link, $query)) {

     $_SESSION["master_number"]=$master_number;

     header("location: ./master_regist_form.php");
     
     exit();
    }

  }
}

 //実行
 if($result=mysqli_query($link, $query) && ($submit_option=="1")){

   $_SESSION["master_number"]=$master_number;

   mysqli_free_result($result);

   mysqli_close($link);

   header('location: ./master_regist_form.php');

  }else if($result=mysqli_query($link, $query) && $submit_option=="2"){
   
   $_SESSION["master_id"]=$target_master_id;
   
   $_SESSION["master_number"]=$master_number;

   mysqli_free_result($result);

   mysqli_close($link);

   header("location: ./masterdetail.php");
  }


?>
