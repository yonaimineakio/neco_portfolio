<?php

//headerが全部共通なサイト構成にしたから、他のファイルからrequire_onceで読み込んでいる。

 $login_user_manager_flg=$_SESSION["manager_flg"];

 if($login_user_manager_flg==="1") {

   $header_list='<header>
<div style="display:inline-block;padding-right:20px;color:white">
<h1>図書申請システム</h1>
</div>
<div style="display:inline-block;padding-left:20px">
<ul class="menu">
<li>設定メニュー
<ul>
<li><a href="../employee/emp_regist_form.php">社員新規登録</a><li>
<li><a href="../request/req_regist_form.php">新規申請</a></li>
<li><a href="../MasterRegist/master_regist_form.php">マスタ登録</a></li>
<li><a href="../passChange/pass_change_form.php">パスワード変更</a></li>
<li><a href="../request/paging_change_form.php">申請件数変更画面</a></li>
<li><a href="../login/login.php">ログアウト</a></li>
</ul>
</li>
</ul>
</div>
<div style="display:inline-block;padding-left:20px">
<ul class="menu">
<li>各種一覧
<ul>
<li><a href="../employee/employeelist.php">社員一覧</a></li>
<li><a href="../request/requestlist.php">申請一覧</a></li>
<li><a href="../book/booklist.php">蔵書一覧</a></li>
</ul>
</li>
</ul>
</div>
</header>
';


}else{



$header_list='<header>
<div style="display:inline-block;color:white;padding-right:20px">
<h1>図書申請システム</h1>
</div>
<div style="display:inline-block;padding-left:20px">
<ul class="menu">
<li>設定メニュー
<ul>
<li><a href="../request/req_regist_form.php">新規申請</a></li>
<li><a href="../passChange/pass_change_form.php">パスワード変更</a></li>
<li><a href="../login/login.php">ログアウト</a></li>
<ul>
</li>
</ul>
</div>
<div style="display:inline-block;padding-left:20px">
<ul class="menu">
<li>各所一覧
<ul>
<li><a href="../request/requestlist.php">申請一覧</a></li>
<li><a href="../book/booklist.php">蔵書一覧</a></li>
</ul>
</li>
</ul>
</div>
</header>
';


 }



?>
