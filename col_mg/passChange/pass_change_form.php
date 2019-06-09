<html>
<head>
<title>パスワード変更</title>

<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>

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


.form{
  
  padding: 0 50px 50px 0;
 
 }
 

input{

  height: 10%;
  
  width: 30%;
  
  font-size: 100%;
  
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

 


 a {
 text-decoration: none;
  }

 a:hover{color:#005FFF;}

</style>

</style>
</head>
<body>
<?php
 session_save_path("/home/a_yonamine/session/");

 session_start();

 $login_name=$_SESSION["employee_name"];
 
 
 
 include_once("../header.php");

?>
<?php echo $header_list?>

 <div id="container">
  <div id="content" style="text-align:center">
     <div style="height:100px"><h1>パスワード変更</h1></div>
      <div style="padding-left:100px;float:left">ログイン名:<?php echo $login_name?></div>
        <div style="width:100%;clear:left"></div>
    <form method="post" action="./pass_change.php">

     <div class="form">現在のパスワード<input type="password" name="current_pas" required></div>   
     <div class="form">新しいパスワード<input type="password" name="new_pas" required></div>
     <div class="form">パスワード再確認<input type="password" name="pas_confirmation" required></div>
     <div class="button"><input id="button" type="submit"  value="変更"></div>
    
   </form>
   </div>
 </div>
</body>
</html>
