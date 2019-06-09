<?php

 require_once("../database_config.php");




    session_save_path("/home/a_yonamine/session/");   

    session_start();

    $login_name=$_SESSION['employee_name'];

    $login_id=$_SESSION['employee_number'];
    
    $login_manager_flg=$_SESSION["manager_flg"];

    $target_book_id= (isset($_GET["ei"])) ? $_GET["ei"] : $_SESSION["book_id"];

 



    

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

    //申請詳細の抽出
    $query='select book_id, book_title, book_kana, book_author, book_publisher, publish_date, book_price, request_date, employee_name, book_content, book_relation, manager_comment, book_location, request_status, book_info.employee_number from book_info join employee_info on book_info.employee_number=employee_info.employee_number where book_id="'.$target_book_id.'"';

    //実行
    if($result=mysqli_query($link, $query)) {


       if(mysqli_num_rows($result) != 1) {

           echo "Error: Can't specify person";

           exit;

        }

        while($row=mysqli_fetch_assoc($result)){

           $book_id=$row["book_id"];
      
           $book_title=$row["book_title"];

           $book_kana=$row["book_kana"];

           $book_author=$row["book_author"];

           $book_publisher=$row["book_publisher"];

           $publish_date=$row["publish_date"];

           $book_price=$row["book_price"];

           $request_date=$row["request_date"];

           $employee_name=$row["employee_name"];

           $book_content=$row["book_content"];

           $book_relation=$row["book_relation"];
          
           $manager_comment= (isset($row["manager_comment"])) ? $row["manager_comment"] : null; 
           
           $book_location= (isset($row["book_location"])) ? $row["book_location"] : null;          

           $request_status=$row["request_status"];

           $employee_number=$row["employee_number"];
       

        }

       //SQLの実行結果を解放(多分無駄にメモリを占有しない為)

       mysqli_free_result($result);

      include_once("../header.php");
    }

   mysqli_close($link);


//申請ステータスに応じてデフォルト値を設定 
if($login_manager_flg=="1") {
  
 if($request_status==="0"){


   $request_list='<input type="radio" class="checkbox" name="request_status[]" value="0" checked="checked">申請中<input type="radio"  class="checkbox" name="request_status[]" value="1">承認<input type="radio"  class="checkbox"  name="request_status[]" value="2">否認';
  }else if($request_status==="1") {

   $request_list='<input type="radio" class="checkbox"  name="request_status[]" value="0">申請中<input type="radio" class="checkbox" name="request_status[]"checked="checked" value="1" >承認<input type="radio" class="checkbox" name="request_status[]" value="2">否認';

 }else {

   $request_list='<input type="radio"  class="checkbox"  name="request_status[]" value="0">申請中<input type="radio"  class="checkbox" name="request_status[]"  value="1" >承認<input type="radio" class="checkbox" name="request_status[]" value="2" checked="checked">否認';
   }

 }else{

  if($request_status==="0"){


   $request_list='<input type="radio" class="checkbox" name="request_status[]" value="0" checked="checked" disabled="disabled">申請中<input type="radio"  class="checkbox" name="request_status[]" value="1"  disabled="disabled">承認<input type="radio"  class="checkbox"  name="request_status[]" value="2"  disabled="disabled">否認';

  }else if($request_status==="1") {

   $request_list='<input type="radio" class="checkbox"  name="request_status[]" value="0"  disabled="disabled">申請中<input type="radio" class="checkbox" name="request_status[]"checked="checked" value="1" disabled="disabled" >承認<input type="radio" class="checkbox" name="request_status[]" value="2"  disabled="disabled">否認';


 }else {

   $request_list='<input type="radio"  class="checkbox"  name="request_status[]" value="0"  disabled="disabled">申請中<input type="radio"  class="checkbox" name="request_status[]"  value="1" disabled="disabled" >承認<input type="radio" class="checkbox" name="request_status[]" value="2" checked="checked"  disabled="disabled">否認';

 

   }



     
      }
 
  //一般社員の場合は申請ステータスが"否認"の場合、申請データを削除、更新できないようにする

 if($login_manager_flg=="0") {

     if($request_status=="2" || $request_status=="1"){

	$radio_select='<input class="checkbox" type="radio" name="submit_option" value="1"/>変更<input class="checkbox" type="radio" name="submit_option" value="3"/>削除';
        
        $submit_button='<input id="button" type="submit" value="登録" disabled="disabled">';

        $manager_line='<textarea name="manager_comment" readonly>'.$manager_comment.'</textarea>';

      }else{

        $radio_select='<input  class="checkbox" type="radio" name="submit_option" value="1" checked="checked"/>変更<input class="checkbox" type="radio" name="submit_option" value="3"/>削除';

        $submit_button='<input id="button" type="submit" value="登録" form="form">';

        $manager_line='<textarea name="manager_comment" readonly>'.$manager_comment.'</textarea>';
     }

  }else {


       $radio_select='<input class="checkbox" type="radio" name="submit_option" value="1" checked="checked"/>変更<input class="checkbox" type="radio" name="submit_option" value="3"/>削除';

       $submit_button='<input id="button" type="submit" value="登録" form="form">'; 

       $manager_line='<textarea name="manager_comment">'.$manager_comment.'</textarea>';
   }



  



   //ファイルを変更する

    $fp=fopen('./requestdetail.html','r');    

     
    while(!feof($fp)) {

        // 1行ずつファイルを読み込み変数にセット

       $line=fgets($fp);

       // データベースからセットする項目について置き換え（動的部分）

       // ログイン名

       $line1=str_replace("<###LOGINNAME###>",$login_name,$line);
       
       $line2=str_replace("<###BOOKTITLE###>", $book_title,  $line1);

       $line3=str_replace("<###BOOKKANA###>", $book_kana, $line2);
        
       $line4=str_replace("<###BOOKAUTHOR###>", $book_author, $line3);
     
       $line5=str_replace("<###BOOKPUBLISHER###>", $book_publisher, $line4);

       $line6=str_replace("<###PUBLISHDATE###>", $publish_date, $line5);
       
       $line7=str_replace("<###BOOKPRICE###>", $book_price, $line6);
        
       $line8=str_replace("<###REQUESTDATE###>", $request_date, $line7);
 
       $line8=str_replace("<###EMPLOYEENAME###>", $employee_name, $line8);
    
       $line9=str_replace('<###REQUESTSTATUS###>', $request_list , $line8);
       

       $line10=str_replace("<###BOOKCONTENT###>",'<input type="text" name="book_content" value="'.$book_content.'" required>' , $line9);

       $line11=str_replace("<###BOOKRELATION###>", $book_relation, $line10);

       $line12= (isset($manager_comment)) ? str_replace("<###MANAGERCOMMENT###>", $manager_line, $line11) : str_replace("<###MANAGERCOMMENT###>", null, $line11);
     
       $line13= (isset($book_location)) ? str_replace("<###BOOKLOCATION###>", $book_location, $line12) : str_replace("<###BOOKLOCATION###>", null, $line12);
       
       $line14=str_replace("<###BOOKID###>", $book_id, $line13);

       $line15=str_replace("<###BORROWERID###>", $employee_number, $line14); 
    
       $line16=str_replace("<###HEADER###>", $header_list, $line15); 

       $line17=str_replace("<###RADIOBUTTON###>", $radio_select, $line16);

       $line18=str_replace("<###SUBMITBUTTON###>", $submit_button, $line17);
 

      echo $line18;
 }


      fclose($fp);

      exit();


?>
