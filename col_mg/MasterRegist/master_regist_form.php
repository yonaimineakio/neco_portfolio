<?php 

  require_once("../database_config.php");

  session_save_path("/home/a_yonamine/session");

  session_start();

  $login_name= $_SESSION["employee_name"];

  
   //POST PARAMETER
  
   if(isset($_POST["master_number"])){

    $master_number=$_POST["master_number"];

    }else if(isset($_SESSION["master_number"])){

    $master_number=$_SESSION["master_number"];

   }else{

    $master_number="1";

   }

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



 //Query

 if($master_number==="1") {

  $query="select * from department_info";

 }else {

  $query="select * from position_info";

 }

 //html要素を代入する変数の初期化
 $master_list="";

 //実行

 if($result=mysqli_query($link, $query)){

   $i=0;

    while($row=mysqli_fetch_row($result)){
     
       $master_id[$i]=$row[0];

       $master_name[$i]=$row[1];

       $master_list.='<tr><td>'.$master_id[$i].'</td><td>'.$master_name[$i].'</td><td><a href=masterdetail.php?ei='.$master_id[$i].'&filter='.$master_number.'>詳細へ</a></td></tr>';

       $i++;
    }

  mysqli_free_result($result);

 }


 //master_numberに応じて,セレクトボックスの初期値を指定

   if($master_number=="2"){

    $master_select='<option value="1">部署</option><option value="2" selected>役職</option>';

   }else{

    $master_select='<option value="1" selected>部署</option><option value="2">役職</option>';

   }


 


 mysqli_close($link);

 include_once("../header.php");

 // HTMLファイルがあり、読み込める状態か確認 
 
  if(is_readable("./master_regist_form.html")) {


    $fp=fopen("./master_regist_form.html", "r");

    while(!feof($fp)) {


    $line=fgets($fp);
 
    $line1=str_replace("<###HEADER###>", $header_list, $line);

    $line2=str_replace("<###LOGINNAME###>", $login_name, $line1);

    $line3=str_replace("<###MASTERSELECT###>", $master_select, $line2);
  
   if($master_number==="1"){

    $line4=str_replace("<###MASTER###>", "部署",$line3);
   
    }else{

    $line4=str_replace("<###MASTER###>", "役職", $line3);

    }

    $line5=str_replace("<###MASTERLIST###>", $master_list, $line4);
   
    $line6=str_replace("<###HIDEMASTERNUMBER###>",'<input type="hidden" name="master_number" value='.$master_number.'>', $line5);

    

    echo $line6;

 }

 fclose($fp);

 exit();

}


?>
