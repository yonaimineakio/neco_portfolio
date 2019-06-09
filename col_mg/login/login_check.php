<?php



   // 設定ファイルの読み込み

   require_once('../database_config.php');



   //Post Parameter

   $number=$_POST['number'];

   $password=$_POST['password'];





   //データベースに接続

   $link=mysqli_connect(DB_SERVER,DB_ACCOUNT_ID,DB_ACCOUNT_PW,DB_NAME);

   if (!$link) {

      echo "Error: Unable to connect to MySQL." . PHP_EOL;

      echo "Debugging errno: " . mysqli_connect_errno() . PHP_EOL;

      echo "Debugging error: " . mysqli_connect_error() . PHP_EOL;

      exit;

   }



   mysqli_set_charset($link,"utf8");



   //Query

   $query='select employee_number,employee_name, password, manager_flg from employee_info where employee_number= BINARY"'.$number.'" and password="'.$password.'"';





   //実行

   if ($result = mysqli_query($link, $query)) {

        // 一人以上のユーザーを特定したら、エラー(一人の名前、パスワードを入力して二人ログイン状態になったらおかしい)
        if(mysqli_num_rows($result)!=1) {

           move_login();

        }

        

        while ($row = mysqli_fetch_assoc($result)) {

           $employee_number=$row["employee_number"];

           $employee_name = $row["employee_name"];

           $password=$row["password"];

           $manager_flg=$row["manager_flg"];


        }

        /* 結果セットを開放します */

        mysqli_free_result($result);

   } else {

       //$result = mysqli_query($link、$querys）でエラーが出たら再度ログイン画面に遷移(つまりSQL文でエラーが出たらログイン画面に遷移)
       )

       move_login();

   }


   //ログインした状態を、各画面で共有する為に設定(誰がログインしたかを明確にする為)

   session_save_path('/home/a_yonamine/session/');

   session_start();

   // セッション開始する。

   $_SESSION = array();

   $_SESSION['employee_number'] = $employee_number;

   $_SESSION['employee_name'] = $employee_name;

   $_SESSION["password"]=$password;  

   $_SESSION["manager_flg"]=$manager_flg;



   mysqli_close($link);
   
if($manager_flg[0]==="1") {

   header('location: ../request/requestlist.php');

 }else {

  header('location: ../book/booklist.php');

 }

   exit;



   function move_login() {

       header('location: ./login.php?em=1');

       exit;

   }
?>
