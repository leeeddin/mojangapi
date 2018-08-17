<?php

require('api.php');
$user=$_GET['user'];
$uuid = mojangapi::getuuid($user);
echo "用户 $user 的uuid为：".$uuid.'<br><br>';

$history = mojangapi::namehistory($uuid);
foreach ($history as $key=>$value) {
		if($key==0)
		{echo "起始名:".$value->name."<br>";}
		else{echo $value->name." 修改于：";
		echo @date("Y-m-d H:i:m",substr($value->changedToAt, 0,-3))."<br>";}	
}
echo "<br>用户 $user 的皮肤为：".mojangapi::getskin($uuid);
?>