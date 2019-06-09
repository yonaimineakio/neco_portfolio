<?php


   require_once("../database_config.php");


   session_save_path("/home/a_yonamine/session/");

   session_start();

   $login_name=$_SESSION["employee_name"];


   $login_user_manager_flg=$_SESSION["manager_flg"];


    //POST PARAMERTER

if(isset($_POST["request_status"])) {

 $request_status=$_POST["request_status"];
//申請日の古い、新しいに応じて条件分岐

 if($_POST["request_date"]=="2"){

  $new_or_old_order=$_POST["request_date"];

  $order="request_date asc";
 
  $new_order=str_replace("\"", "", $order);


 }else{

  $new_or_old_order=$_POST["request_date"];

  $order="request_date desc";

  $new_order=str_replace("\"", "", $order);


 }

}

 //GET PARAMETER


if(isset($_GET["filter"])) {

 $request_status=$_GET["filter"];

//申請日の古い、新しいに応じて条件分岐

 if($_GET["sort"]=="2"){

  $new_or_old_order=$_GET["sort"];

  $order="request_date asc";
 
  $new_order=str_replace("\"", "", $order);


 }else{

  $new_or_old_order=$_GET["sort"];

  $order="request_date desc";

  $new_order=str_replace("\"", "", $order);


 }

}



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

   
 
   //１ページあたりに表示したい申請データを取得
    $paging_query="select paging_number from paging_info";

    $result=mysqli_query($link, $paging_query);

     while($row=mysqli_fetch_assoc($result)) {

       $result_per_page=$row["paging_number"];
     }

  mysqli_free_result($result);

    //データベースに保存されている申請データーの数を取得
     
    if($request_status=="3") {

 
    
    $sql='select book_id, book_title, request_date, employee_name, request_status from employee_info join book_info on book_info.employee_number= employee_info.employee_number'; 

    }else{


    $sql='select book_id, book_title, request_date, employee_name, request_status from employee_info join book_info on book_info.employee_number= employee_info.employee_number where request_status='.$request_status.'';


   }


  $result=mysqli_query($link, $sql);

  $number_of_result=mysqli_num_rows($result);


  mysqli_free_result($result);

  //全ページ数を取得
  $number_of_page=ceil($number_of_result / $result_per_page);
 

  //何ページにユーザがいるのかを定義

  if(!isset($_GET['page'])){

     $page=1;

    }else{

     $page=$_GET['page'];

    }

 //offset用変数を定義

  $this_page_first_result=$result_per_page * ($page - 1);

//request_statusに応じて条件分岐


     if($request_status=="3") {



    $query='select book_id, book_title, request_date, employee_name, request_status from employee_info join book_info on book_info.employee_number= employee_info.employee_number order by '.$new_order.' limit '.$this_page_first_result.', '.$result_per_page.'';

    }else{


    $query='select book_id, book_title, request_date, employee_name, request_status from employee_info join book_info on book_info.employee_number= employee_info.employee_number where request_status='.$request_status.' order by '.$new_order.' limit '.$this_page_first_result.', '.$result_per_page.'';


   }


  // 後ほどhtmlファイルで置き換えするための変数の初期化
 $request_line="";

 if($result=mysqli_query($link, $query)){

  $i=0;

  while($row=mysqli_fetch_row($result)) {

  $book_id[$i]=$row[0];

  $book_title[$i]=$row[1];

  $request_date2[$i]=$row[2];

  $employee_name[$i]=$row[3];

  $request_status2[$i]=$row[4];


    // 一覧用の値をセット
 if($request_status2[$i]==="0"){

  $request_line.="<tr><td>".$book_title[$i]."</td><td>".$request_date2[$i]."</td><td>".$employee_name[$i]."</td><td>申請中</td><td><a href='./requestdetail.php?ei=".$book_id[$i]."'>詳細画面へ</a></td></tr>\n";


   }else if($request_status2[$i]==="1"){

  $request_line.="<tr><td>".$book_title[$i]."</td><td>".$request_date2[$i]."</td><td>".$employee_name[$i]."</td><td>承認</td><td><a href='./requestdetail.php?ei=".$book_id[$i]."'>詳細画面へ</a></td></tr>\n";


  }else{

   $request_line.="<tr><td>".$book_title[$i]."</td><td>".$request_date2[$i]."</td><td>".$employee_name[$i]."</td><td>否認</td><td><a href='./requestdetail.php?ei=".$book_id[$i]."'>詳細画面へ</a></td></tr>\n";

 }

 $i++;

}


 //SQLの実行結果を解放(多分無駄にメモリを占有しない為)

 mysqli_free_result($result);




 }

 mysqli_close($link);

function paging($limit, $page, $disp=5){

   global $link_line, $page, $request_status, $new_or_old_order;
   //dispはページ番号表示数
   $next=$page+1;
   $prev=$page-1;


   //ページ番号用リンク
   $start= ($page-floor($disp/2) > 0) ? ($page-floor($disp/2)) : 1;//終点
   $end= ($start > 1) ? ($page+floor($disp/2)) : $disp;//終点
   $start=($limit < $end)? $start-($end-$limit):$start;//始点再計算

  if($page !=1){


   $link_line.='<div style="display:inline-block;padding-right:10px;padding-left:10px"><a href="?page='.$prev.'&filter='.$request_status.'&sort='.$new_or_old_order.'">&laquo; 前へ</a></div>';

   }

  //最初のページへのリンク
  if($start >= floor($disp/2)){

   $link_line.='<div style="display:inline-block;padding-right:10px;padding-left:10px"><a href="?page=1&filter='.$request_status.'&sort='.$new_or_old_order.'">1</a></div>';
   if($start > floor($disp/2)){ $link_line.="...";} //ドットhyouzi

  }

 for($i=$start;$i<=$end;$i++){//ページンング用リンクループ

    $class=($page==$i) ? 'class="current"':"";//現在地を表すCSSクラス


   //1以上最大ページ数以下の場合
    if($i <= $limit && $i > 0){ $link_line.='<div style="display:inline-block;padding-right:10px;padding-left:10px"><a href="?page='.$i.'&filter='.$request_status.'&sort='.$new_or_old_order.''.$class.'">'.$i.'</a></div>';  }


 }

  //最後のページへのリンクを表示
  if($limit > $end){
     if($limit-1 > $end ) print "...";    //ドットの表示
    $link_line.='<div style="display:inline-block;padding-right:10px;padding-left:10px"><a href="?page='.$limit.'&filter='.$request_status.'&sort='.$new_or_old_order.'">'.$limit.'</a></div>';

  }

 if($page < $limit){

   $link_line.='<div style="display:inline-block;padding-right:10px;padding-left:10px"><a href="?page='.$next.'&filter='.$request_status.'&sort='.$new_or_old_order.'">次へ &raquo;</a></div>';

   }
 
}
 paging($number_of_page, $page);





 //申請ステータス毎にデフォルト値を設定
 

  if($request_status=="0"){

  $request_select='<div>申請ステータスに応じて表示<select name="request_status" onchange="submit(this.form)"><option value="3">指定なし</option><option value="0" selected>申請中</option><option value="1">承認</option><option value="2">否認</option></select></div>';

  }else if($request_status=="1"){

  $request_select='<div>申請ステータスに応じて表示<select name="request_status" onchange="submit(this.form)"><option value="3">指定なし</option><option value="0">申請中</option><option value="1" selected>承認</option><option value="2">否認</option></select></div>';

  }else if($request_status=="2"){

  $request_select='<div>申請ステータスに応じて表示<select name="request_status" onchange="submit(this.form)"><option value="3">指定なし</option><option value="0">申請中</option><option value="1">承認</option><option value="2" selected>否認</option></select></div>';


  }else{


  $request_select='<div>申請ステータスに応じて表示<select name="request_status" onchange="submit(this.form)"><option value="3">指定なし</option><option value="0">申請中</option><option value="1">承認</option><option value="2">否認</option></select></div>';




 }







//申請日の新しい、古い順にデーターを並び替え

 if($new_or_old_order=="2"){

  $order_select='<div>申請日の新しい、古い順に応じて並び替え<select name="request_date" onchange="submit(this.form)"><option value="1" >新しい</option><option value="2" selected>古い</option></select></div>';

 }else{

  $order_select='<div>申請日の新しい、古い順に応じて並び替え<select name="request_date" onchange="submit(this.form)"><option value="1" selected>新しい</option><option value="2">古い</option></select></div>';
  }

include_once("../header.php");

$fp=fopen('requestlist.html',"r");
                                                                 
 while(!feof($fp)){

  // 1行ずつファイルを読み込み変数にセット
  $line=fgets($fp);

  // データベースからセットする項目について置き換え（動的部分）

  $line1=str_replace("<###HEADER###>", $header_list, $line);

  $line2=str_replace("<###LOGINNAME###>", $login_name, $line1);

  $line3=str_replace("<###REQUESTSELECT###>", $request_select, $line2);

  $line4=str_replace("<###ORDERSELECT###>", $order_select, $line3);

  $line5=str_replace("<###REQUESTLIST###>", $request_line, $line4);

  $line6=str_replace("<###RESET###>", "<a href='./requestlist.php' class='reset'>並び替えをリセット</a>", $line5);

  $line7=str_replace("<###LINKS###>", $link_line, $line6);

  echo $line7;

 }

  fclose($fp);

  exit();


?>
