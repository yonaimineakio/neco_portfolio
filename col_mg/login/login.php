<?php


 require_once('./errorlist.php');



//エラー文を設定
 if(isset($_GET["em"])) {

  $error_no=$_GET["em"];

  }else {

  $error_no=0;

  }


  //ファイルを読み込む
  $fp=fopen('./login.html', "r");


 //ファイルの最後まで処理を行う

 while(!feof($fp)) {


  //1行ずつファイルを読み込み変数にセット
  $line=fgets($fp);
 //置き換え
  $lines=str_replace("<###ERROR###>", $error_msg[$error_no], $line);



  echo $lines;

 }

 fclose($fp)

?>
