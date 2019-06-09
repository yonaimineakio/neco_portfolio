<html>
<head>
<title>新規申請登録</title>

<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>

<script>
//プルダウン機能
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

.nessesary {

  width:8%;

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

.checkbox{ width: 10%;}

input{width:70%;}


a{
  text-decoration: none;
  
  }

 

 a:hover{color:#005FFF;}

</style>
</head>
<body>
<?php

 session_save_path("/home/a_yonamine/session");

 session_start();

 $login_name=$_SESSION["employee_name"];

 $login_number=$_SESSION["employee_number"];

 include_once("../header.php");

$now= date("Y-m-d");
  
?>
<?php echo $header_list; ?>
 <div id="container">
   <div id="content">
     <div style="text-align:center"><h1>申請新規登録</h1></div>
      <div>ログイン者名:<?php echo $login_name; ?><div>
     <table class="regist_form">
       <form id="form" method="post" action="./req_regist.php">
        <tr><td>図書名<td class="nessesary"><span style="color:red">[必須]</span></td></td><td><input type="text" name="book_title"required></td></tr>
        <tr><td>図書名(カナ)<td class="nessesary"><span style="color:red">[必須]</span></td></td><td><input type="text" name="book_kana" required></td></tr>
        <tr><td>著者<td class="nessesary"><span style="color:red">[必須]</span></td></td><td><input type="text" name="book_author" required></td></tr>
        <tr><td>出版社<td class="nessesary"><span style="color:red">[必須]</span></td></td><td><input type="text" name="book_publisher" required></td></tr>
        <tr><td>出版日<td class="nessesary"><span style="color:red">[必須]</span></td></td></td><td><input type="date" name="publish_date" required></td></tr>
        <tr><td>価格<td class="nessesary"><span style="color:red">[必須]</span></td></td><td><input type="text" name="book_price" required></td></tr> 
        <tr><td>図書内容<td class="nessesary"><span style="color:red">[必須]</span></td></td><td><input type="text" name="book_content" required></td></tr>
        <tr><td>現在の仕事との関係性<td class="nessesary"><span style="color:red">[必須]</span></td></td><td><input type="text"  name="book_relation" required></td></tr>
        <tr><td><input type="hidden" name="submit_option" value="2" checked="checked"><input type="hidden" name="employee_number" value="<?php echo $login_number;?>"><input type="hidden" name="request_status" value="0"></td></tr>
       </form>
     </table>
        <div  style="text-align:center;padding-top:20px"><input id="button" type="submit" value="申請" form="form"><div>
        <div><input type="hidden" name="request_date" value="<?php echo $now;?>" form="form"></div>           
   </div>
 </div>

</body>
</html>

