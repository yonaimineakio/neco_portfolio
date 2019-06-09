<html>
<head>
<title>新規社員登録</title>
//プルダウン機能
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
・
<script>
$(function() {
var menu = $('.menu');
$('li', menu)
.mouseover(function(e) {
$('ul', this).stop().slideDown('fast');
})
.mouseout(function(e) {
$('ul', this).stop().slideUp('fast');
});
});
</script>


<link rel="stylesheet" type="text/css" href="../style.css">

<style type="text/css">
#container {

    width:900px;
    margin: 0 auto;

   }

   #content{

   width: 100%;

   margin: 100px auto;

   }

  #button {

  height: 10%;

  width: 22%;

  border-radius:10px;

  font-size: 100%;

 }

#button:hover{

  background-color:#005FFF;

}


   header {
   height:10%;

   width:100%;

   background-color: #000000;

   text-align:center;
  }

.header-component {
 
  display: inline-block;

  color: white;

}


 tr{width:100%;}

 .regist_form{
  width: 100%;

 }

 .regist_form td {

      border-top:solid 1px;

      border-top:solid 1px;

      line-height:18px;

   }

 .nessesary{
     
    width:8%;

   }  

.checkbox{ width: 10%;}

input{ width:70%;}

textarea{width:70%;}



a{
  text-decoration: none;

  }



 a:hover{color:#005FFF;}

</style>
</head>
<body>
<?php

 require_once("../database_config.php");

  session_save_path("/home/a_yonamine/session/");
  session_start();

  $login_name=$_SESSION["employee_name"];

  include_once("../header.php");

   $link=mysqli_connect(DB_SERVER,DB_ACCOUNT_ID,DB_ACCOUNT_PW,DB_NAME);

   if (!$link) {

      echo "Error: Unable to connect to MySQL." . PHP_EOL;

      echo "Debugging errno: " . mysqli_connect_errno() . PHP_EOL;

      echo "Debugging error: " . mysqli_connect_error() . PHP_EOL;

      exit;

   
}

   mysqli_set_charset($link, "utf8");

  $query="select department_id, department_name from department_info";  
   
 
   $department_line="";

   if($result = mysqli_query($link, $query)) {

      $i=0;
     while($row=mysqli_fetch_row($result)){
        
        $department_id[$i]=$row[0];

        $department_name[$i]=$row[1];


        $department_line.='<option value='.$department_id[$i].'>'.$department_name[$i].'</option>';

        $i++;
    }

   mysqli_free_result($result);
  }



  $query="select position_id, position_name from position_info";

  $position_line="";
 

   
   if($result=mysqli_query($link, $query)){
 
     $i=0;
   
     while($row=mysqli_fetch_row($result)){

       $position_id[$i]=$row[0];
 
       $position_name[$i]=$row[1];

       $position_line.='<option value='.$position_id[$i].'>'.$position_name[$i].'</option>';

       $i++;
    }

 mysqli_free_result($result);
   

   }
     
?>

<?php echo $header_list ?>
 <div id="container">
   <div id="content">
     <div style="text-align:center"><h1>社員新規登録</h1></div>
      <div> ログイン者名:<?php echo $login_name ?></div>
     <table class="regist_form">
       <form id="form" method="post" action="./emp_regist.php">
        <tr><td>社員番号<td class="nessesary"><span style="color:red">[必須]</td></span></td><td><input type="text" name="employee_number" required></td></tr>
        <tr><td>社員名<td><span style="color:red">[必須]</span></td></td><td><input type="text" name="employee_name" required></td></tr>
        <tr><td>社員名(カナ)<td><span style="color:red">[必須]</span></td></td><td><input type="text" name="employee_kana"></td></tr>
        <tr><td>パスワード<td><span style="color:red">[必須]</span></td></td><td><input type="password" name="password"  placeholder="パスワードを入力してください" required></td></tr>
        <tr><td>性別<td><span style="color:red">[必須]</span></td></td><td><input class="checkbox" type="radio" name="gender_flg[]" value="0">男<input type="radio" class="checkbox" name="gender_flg[]" value="1">女</td></tr>
        <tr><td>生年月日<td><span style="color:red">[必須]</td></span></td><td><input type="date" name="birthday" required></td></tr>
        <tr><td>管理者<td><span style="color:red">[必須]</span></td></td><td><input class="checkbox" type="checkbox" name="manager_flg[]" value="1"></tr>
        <tr><td>所属部署<td><span style="color:red">[必須]</span></td></td><td><select name="department_id"><?php echo $department_line ?></select></td></tr>
        <tr><td>役職<td><span style="color:red">[必須]</span></td></td><td><select name="position_id"><?php echo $position_line ?></select></td></tr>
        <tr><td>入社日<td><span style="color:red">[必須]</span></td></td><td><input type="date" name="hire_date"></td></tr>
        <tr><td>退社日</td><td></td><td><input type="date" name="leaving_date"></td></tr>
        <tr><td>備考</td><td></td><td><textarea name="note"></textarea></td></tr>
        <tr><td><input type="hidden" name="submit_option" value="2" checked="checked" /><td></tr>
       </form>
     </table>
      <div class="button" style="text-align:center;padding-top:20px"><input id="button"  type="submit" value="登録" form="form"></div>
   </div>
 </div>

</body>
</html>
