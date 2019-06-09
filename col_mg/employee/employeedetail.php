
<?php

 require_once("../database_config.php");

 session_save_path("/home/a_yonamine/session/");

 session_start();

 $login_name=$_SESSION["employee_name"];

 $target_user_id=(isset($_GET["ei"])) ? $_GET["ei"] : $_SESSION["user_id"];

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

   // Query

   // 従業員情報を抽出
   
  $query='select employee_number, employee_name, employee_kana, password, gender_flg, birthday, manager_flg, department_info.department_id, department_name, position_info.position_id, position_name ,hire_date, leaving_date, note from employee_info join department_info on department_info.department_id=employee_info.department_id left join position_info on employee_info.position_id=position_info.position_id  where employee_id="'.$target_user_id.'"';

 //実行
 if($result=mysqli_query($link, $query)){
    
    //  レコード数が１でなければエラー
 if(mysqli_num_rows($result)!=1) {

     echo "Error: Can't specify person";

           exit;

 }

    //SQLの実行結果を変数に代入している。
 while($row=mysqli_fetch_assoc($result)) {
 
  $employee_number=$row["employee_number"];

  $employee_name=$row["employee_name"];

  $employee_kana=$row["employee_kana"];

  $password=$row["password"];

  $gender_flg=$row["gender_flg"];

  $birthday=$row["birthday"];

  $manager_flg=$row["manager_flg"];

  $department_id=$row["department_id"];
  
  $department_name=$row["department_name"];

  $position_id=$row["position_id"];
  
  $position_name=$row["position_name"];

  $hire_date=$row["hire_date"];

  $leaving_date=$row["leaving_date"];

  $note=$row["note"];


}
 //SQLの実行結果を解放(多分無駄にメモリを占有しない為)
 mysqli_free_result($result);


}

  //生年月日から年齢を自動計算
  $now=date("Ymd");

  $new_birthday=str_replace("-", "", $birthday);

  $age=floor(($now - $new_birthday)/10000);
  
include_once("../header.php");

  //所属部署プルダウンをセット
  $query="select department_id, department_name from department_info";

 $department_line="";  

  if($result=mysqli_query($link, $query)) {
     
    $i=0;
    while($row=mysqli_fetch_row($result)){

     $department_ids[$i]=$row[0];

     $department_names[$i]=$row[1];

     if($department_id===$department_ids[$i]){


        $department_line.='<option value='.$department_ids[$i].' selected>'.$department_names[$i].'</option>';


     }else{

       $department_line.='<option value='.$department_ids[$i].'>'.$department_names[$i].'</option>';

     }

    $i++;
    
    }

 mysqli_free_result($result);
  }

  //役職プルダウンをセット
  $query="select position_id, position_name from position_info";

 
  $position_line="";

     

  if($result=mysqli_query($link, $query)){

    $i=0;
    while($row=mysqli_fetch_row($result)){

     $position_ids[$i]=$row[0];

     $position_names[$i]=$row[1];

     if($position_ids[$i]===$position_id){

       $position_line.='<option value='.$position_ids[$i].' selected>'.$position_names[$i].'</option>';

     }else{

       $position_line.='<option value='.$position_ids[$i].'>'.$position_names[$i].'</option>';

     }

    $i++;

    }

  mysqli_free_result($result);

  }

mysqli_close($link);

  


//設定ファイルの読み込み
 $fp=fopen("employeedetail.html", "r");

  
 //ファイルの最後まで処理を行う
 while(!feof($fp)){

    //1行ずつファイルに読み込み変数をセット
    $line=fgets($fp);

         // データベースからセットする項目について置き換え（動的部分）

    $line1=str_replace("<###LOGINNAME###>", $login_name, $line);

    $line2=str_replace("<###EMPLOYEENUMBER###>", $employee_number, $line1);

    $line3=str_replace("<###EMPLOYEENAME###>", $employee_name, $line2);

    $line4=str_replace("<###EMPLOYEEKANA###>", $employee_kana, $line3);

    $line5=str_replace("<###PASSWORD###>", $password, $line4);

    if($gender_flg[0]==="0"){

      
     $line6=str_replace("<###GENDER###>",'<input class="checkbox" type="radio" name="gender_flg[]" value="0" checked="checked">男<input class="checkbox" type="radio" name="gender_flg[]" value="1">女', $line5);

     }else if ($gender_flg[0]==="1"){
      
     $line6=str_replace("<###GENDER###>",'<input class="checkbox" type="radio" name="gender_flg[]" value="0">男<input class="checkbox" type="radio" name="gender_flg[]" value="1" checked="checked">女', $line5 );

     }

    $line7=str_replace("<###BIRTHDAY###>", '<input type="date" name="birthday" value="'.$birthday.'" required>', $line6);
    
    $line8=str_replace("<###AGE###>", $age, $line7);
 
    if($manager_flg[0]==="1"){
       
      $line9=str_replace("<###MANAGER###>", '<input type="checkbox" name="manager_flg[]" value="1" checked="checked">', $line8);

     }else {

      $line9=str_replace("<###MANAGER###>", '<input type="checkbox" name="manager_flg[]" value="1">', $line8);


     }

   $line10=str_replace("<###DEPARTMENT###>", $department_line, $line9);

   $line11=str_replace("<###POSITION###>",$position_line, $line10);

   $line12=str_replace("<###HIREDATE###>", '<input type="date" name="hire_date" value="'.$hire_date.'" required>', $line11);

   $line13=str_replace("<###LEAVINGDATE###>", '<input type="date" name="leaving_date" value="'.$leaving_date.'">', $line12);


   $line14=str_replace("<###NOTE###>", $note, $line13);

   $line15=str_replace("<###EMPLOYEEID###>",$target_user_id, $line14);

   $line16=str_replace("<###HEADER###>", $header_list, $line15);

   echo $line16;
  }

  fclose($fp);

  exit();


?>
