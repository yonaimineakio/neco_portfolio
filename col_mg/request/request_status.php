<?php


 if($request_status==="0"){


   $request_list='<input type="radio" class="checkbox" name="request_status" value="0" checked="checked">申請中<input type="radio"  class="checkbox" name="request_status" value="1">承認<input type="radio"  class="checkbox"  name="request_status" value="2">申請拒否';
  }else if($request_status==="1") {


   $request_list='<input type="radio" class="checkbox"  name="request_status" value="0">申請中<input type="radio" class="checkbox" name="request_status "checked="checked" value="1" >承認<input type="radio" class="checkbox" name="request_status" value="2">申請拒否';

 }else {
   
   $request_list='<input type="radio"  class="checkbox"  name="request_status" value="0">申請中<input type="radio"  class="checkbox" name="request_status"  value="1" >承認<input type="radio" class="checkbox" name="request_status" value="2" checked="checked">申請拒否';
}


?>

