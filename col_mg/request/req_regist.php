<?php

 require_once("../database_config.php");

 session_save_path("/home/a_yonamine/session/");

 session_start();

 $login_name=$_SESSION["employee_name"];



  // POST PARAMETER
   
  if(isset($_POST["book_id"])){

   $book_id=$_POST["book_id"];

  }

  $book_title=$_POST["book_title"];

  $book_kana=$_POST["book_kana"];

  $book_author=$_POST["book_author"];
  
  $book_publisher=$_POST["book_publisher"];

  $publish_date=$_POST["publish_date"];

  $book_price=$_POST["book_price"];
  
  $request_date=$_POST["request_date"];


  $book_content=$_POST["book_content"];

  $book_relation=$_POST["book_relation"];

  $manager_comment= (isset($_POST["manager_comment"])) ? $_POST["manager_comment"] : null;

  $book_location= (isset($_POST["book_location"])) ? $_POST["book_location"] : null;

  $submit_option=$_POST["submit_option"];
 
  $request_status=$_POST["request_status"];

  $employee_number=$_POST["employee_number"];

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
 



if($submit_option==="1") {
   

    
　//変更
  $query='update book_info SET book_title="'.$book_title.'", book_kana="'.$book_kana.'", book_author="'.$book_author.'", book_publisher="'.$book_publisher.'", publish_date="'.$publish_date.'", book_price="'.$book_price.'", request_date="'.$request_date.'", book_content="'.$book_content.'", employee_number="'.$employee_number.'" , book_relation= "'.$book_relation.'", manager_comment= "'.$manager_comment.'", book_location="'.$book_location.'", request_status="'.$request_status[0].'" where book_id="'.$book_id.'"';


  $target_book_id= $book_id;


}

  //新規申請
 else if($submit_option==="2") {
 
  $query_fetch_new_id="select max(book_id)+1 as book_id from book_info";

  $result=mysqli_query($link, $query_fetch_new_id);

  while($row=mysqli_fetch_assoc($result)) {

   $new_id=$row["book_id"];

  }

  $query='insert into book_info(book_id, book_title, book_kana ,book_author , book_publisher, publish_date, book_price, book_content,  request_status, request_date, book_relation,  manager_comment, book_location, employee_number) values("'.$new_id.'", "'.$book_title.'", "'.$book_kana.'", "'.$book_author.'", "'.$book_publisher.'", "'.$publish_date.'", "'.$book_price.'", "'.$book_content.'", "'.$request_status[0].'", "'.$request_date.'" , "'.$book_relation.'", "'.$manager_comment.'", "'.null.'", "'.$employee_number.'")';

  $target_book_id=$new_id;

  }else {
　//削除
    
  $query='delete from book_info where book_id="'.$book_id.'"';

 if($result=mysqli_query($link, $query)){

   mysqli_close($link);
        
  header('location: ./requestlist.php');
             
  exit; 


 }


}

  //セッション用book_idをセット
 
  $_SESSION["book_id"]=$target_book_id;

  //実行

   if ($result = mysqli_query($link, $query)) {

      header("location: ./requestdetail.php");

   } else {
           var_dump($query); 
           echo "Error: Update or Insert";
           exit;

   
}


?>
