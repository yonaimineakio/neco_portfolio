<html>
<head>
<title>申請件数変更画面</title>

<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
//プルダウン機能
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

  button {

  height: 10%;

  width: 22%;

  border-radius:10px;

  font-size: 100%;

}

button:hover{

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


input{

   width:55%;

   height:10%;

   font-size: 100%;
   
}


a{
  text-decoration: none;
  
  }

 

 a:hover{color:#005FFF;}

</style>
</head>
<body>
<?php

  include_once("../database_config.php");

 session_save_path("/home/a_yonamine/session");

 session_start();

 $login_name=$_SESSION["employee_name"];

 $login_number=$_SESSION["employee_number"];

  //データベースに接続

 $link=mysqli_connect(DB_SERVER, DB_ACCOUNT_ID, DB_ACCOUNT_PW ,DB_NAME);

 if(!$link) {

      echo "Error: Unable to connect to MySQL." . PHP_EOL;

      echo "Debugging errno: " . mysqli_connect_errno() . PHP_EOL;

      echo "Debugging error: " . mysqli_connect_error() . PHP_EOL;

      exit;

 }

  mysqli_set_charset($link, "utf8");
 

  //Query
 $query="select paging_number from paging_info";

 if($result=mysqli_query($link, $query)){

    while($row=mysqli_fetch_assoc($result)){

     $paging_number=$row["paging_number"];

   }

   mysqli_free_result($result);

  }

 mysqli_close($link);

 include_once("../header.php");
  

?>
<?php echo $header_list; ?>
 <div id="container">
   <div id="content">
     <div style="text-align:center"><h1>申請件数変更画面</h1></div>
      <div style="padding-top:10px;padding-bottom:10px">ログイン者名:<?php echo $login_name; ?><div>
       <div style="padding-top:10px;padding-bottom:10px">現在の1ページ当たりに表示件数: <?php echo $paging_number ?></div>
        <form action="./paging_change.php" method="post" id="form">
          <div style="padding-top:10px;padding-bottom:10px"> 1ページあたりの表示件数:<input type="text" name="paging_number" required></div>
        </form>
　　　　<div style="text-align:center">
          <button type="submit" form="form">変更</button>
       </div>
　　　<div>
   </div>
 </div>

</body>
</html>

