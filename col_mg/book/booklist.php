<?php 


   session_save_path("/home/a_yonamine/session/");

   session_start();

   $login_name=$_SESSION["employee_name"];
  
   //設定ファイル読み込み
   require_once("../database_config.php");


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
  $query="select  book_title, book_author, book_publisher, publish_date, book_location from book_info where request_status= 1 order by book_kana asc";
   

   // 後ほどhtmlファイルで置き換えするための変数の初期化
   $book_line="";
  

  //実行
  if($result=mysqli_query($link, $query)){


   $i=0;

   while($row=mysqli_fetch_row($result)){

     $book_title[$i]=$row[0];

     $book_author[$i]=$row[1];

     $book_publisher[$i]=$row[2];
     
     $publish_date[$i]=$row[3];

     $book_location[$i]=$row[4];
     
      // 一覧用の値をセット
    $book_line.='<tr><td>'.$book_title[$i].'</td><td>'.$book_author[$i].'</td><td>'.$book_publisher[$i].'</td><td>'.$publish_date[$i].'</td><td>'.$book_location[$i].'</td></tr>'; 
     
     $i++;


  }
  //SQLの実行結果を解放(多分無駄にメモリを占有しない為)
  mysqli_free_result($result);
 }

 
  mysqli_close($link); 

  include_once("./../header.php");

  //ファイルな内容を変数に取り込む
  $fp=fopen("./booklist.html", "r");

 // ファイルの最後まで処理を行う
  while(!feof($fp)) {

       // 1行ずつファイルを読み込み変数にセット
       $line=fgets($fp);

         // データベースからセットする項目について置き換え（動的部分）

       $line1=str_replace("<###HEADER###>", $header_list, $line);

       $line2=str_replace("<###LOGINNAME###>", $login_name, $line1);

       $line3=str_replace("<###BOOKLIST###>", $book_line, $line2);

       $lines=$line3;

       
       echo $lines;


  }

   fclose($fp);

   exit();

?>
