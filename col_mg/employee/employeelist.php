<?php 

 require_once("../database_config.php");

 session_save_path("/home/a_yonamine/session");

 session_start();

 $login_name=$_SESSION["employee_name"];


 //データベースに接続

 $link=mysqli_connect(DB_SERVER, DB_ACCOUNT_ID, DB_ACCOUNT_PW ,DB_NAME);

 if(!$link) {

      echo "Error: Unable to connect to MySQL." . PHP_EOL;

      echo "Debugging errno: " . mysqli_connect_errno() . PHP_EOL;

      echo "Debugging error: " . mysqli_connect_error() . PHP_EOL;

      exit;

 }


  //抽出するエンコードを設定

  mysqli_set_charset($link, "utf8");
 

 //Query
 

 //従業員リストを抽出
 $query="select employee_id, employee_number, employee_name, department_name, position_name, manager_flg from employee_info join position_info on position_info.position_id=employee_info.position_id join department_info on department_info.department_id=employee_info.department_id  order by employee_id";

 // 後ほどhtmlファイルで置き換えするための変数の初期化

 $employee_line="";

 if($result=mysqli_query($link, $query)){

  $i=0;

  while($row=mysqli_fetch_row($result)) {

  $employee_id[$i]=$row[0];

  $employee_number[$i]=$row[1];

  $employee_name[$i]=$row[2];

  $department_name[$i]=$row[3];

  $position_name[$i]=$row[4];

  $manager_flg=$row[5];
  
    // 一覧用の値をセット
 if($manager_flg==="1"){
         $employee_line.="<tr><td>".$employee_number[$i]."</td><td>".$employee_name[$i]."<span style='color:red'>[管理者]</span></td><td>".$department_name[$i]."</td><td>".$position_name[$i]."</td><td><a href='./employeedetail.php?ei=".$employee_id[$i]."'>詳細画面へ</a></td></tr>\n";

  }else{

    $employee_line.="<tr><td>".$employee_number[$i]."</td><td>".$employee_name[$i]."</td><td>".$department_name[$i]."</td><td>".$position_name[$i]."</td><td><a href='./employeedetail.php?ei=".$employee_id[$i]."'>詳細画面へ</a></td></tr>\n";

  }
           $i++;

 }

 //SQLの結果を解放(多分無駄にメモリを占有しない為)

 mysqli_free_result($result);


 

 }

 mysqli_close($link);

include("../header.php");


 

 //ファイル内容を変数に取り込む
 $fp=fopen("./employeelist.html","r");

 while(!feof($fp)){

  // 1行ずつファイルを読み込み変数にセット
  $line=fgets($fp);

  // データベースからセットする項目について置き換え（動的部分）

  $line1=str_replace("<###HEADER###>", $header_list, $line);

  $line2=str_replace("<###LOGINNAME###>", $login_name, $line1);

  $lines=str_replace("<###EMPLOYEELIST###>", $employee_line, $line2);

  echo $lines;

 }

  fclose($fp);

  exit();


?>
