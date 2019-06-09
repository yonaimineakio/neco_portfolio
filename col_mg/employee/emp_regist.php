<?php 
 //設定ファイル読み込み
 require_once("../database_config.php");

 //セッション処理
 session_save_path("/home/a_yonamine/session/");
 

 session_start();

 $login_name=$_SESSION["employee_name"];


 // POST PARAMETER
if(isset($_POST["employee_id"])) {

  $employee_id=$_POST["employee_id"];

}

 $employee_number=$_POST["employee_number"];
 
 $employee_name=$_POST["employee_name"];

 $employee_kana=$_POST["employee_kana"];

 $password=$_POST["password"];

 $gender_flg=$_POST["gender_flg"];

 $birthday=$_POST["birthday"];


 if(isset($_POST["manager_flg"])){

  $manager_flg=$_POST["manager_flg"];


 }else {

  $manager_flg[0]="0";
  }

 $department_id=$_POST["department_id"];

 $position_id=$_POST["position_id"];

 $hire_date=$_POST["hire_date"];

 $leaving_date=$_POST["leaving_date"];

 $note=$_POST["note"];

 $submit_option=$_POST["submit_option"];
 


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

     //  情報変更

     if ($submit_option==="1") {


      $query='update employee_info set employee_number = "'.$employee_number.'", employee_name="'.$employee_name.'", employee_kana="'.$employee_kana.'", password="'.$password.'", gender_flg="'.$gender_flg[0].'", birthday="'.$birthday.'", manager_flg="'.$manager_flg[0].'", department_id="'.$department_id.'", position_id="'.$position_id.'", hire_date="'.$hire_date.'", leaving_date="'.$leaving_date.'", note="'.$note.'" where employee_id="'.$employee_id.'"';

   $target_user_id=$employee_id;

  //新規登録
     }else if($submit_option==="2") {


      $query_select="select max(employee_id)+1 as employee_id from employee_info";

      $result=mysqli_query($link, $query_select);

      while($row=mysqli_fetch_assoc($result)){

       $new_id=$row["employee_id"];


       }

      $query='insert into employee_info(employee_id, employee_number, employee_name, employee_kana, password, gender_flg, birthday, manager_flg, department_id, position_id, hire_date, leaving_date, note) values("'.$new_id.'", "'.$employee_number.'", "'.$employee_name.'", "'.$employee_kana.'", "'.$password.'", "'.$gender_flg[0].'", "'.$birthday.'", "'.$manager_flg[0].'", "'.$department_id.'", "'.$position_id.'", "'.$hire_date.'", "'.$leaving_date.'", "'.$note.'") ';

      $target_user_id=$new_id;

     }else{
       //削除
      $query='delete from employee_info where employee_id="'.$employee_id.'"';

      if($result=mysqli_query($link, $query)){
        
        mysqli_close($link);

        header("location: ./employeelist.php");

        exit();

      }

     }


    //セッション用employee_idをセット
    $_SESSION["user_id"] = $target_user_id;


    //実行

   if($result=mysqli_query($link, $query)){

        header("location: ./employeedetail.php");


   }else {

     echo "Error: Update or Insert";

           exit;
  }

?>
