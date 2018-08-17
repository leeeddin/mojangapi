<?php
class mojangapi{
	public static function getuuid($name){
		$data = json_encode($name);
		$url  ='https://api.mojang.com/profiles/minecraft';
		if( $que = static::postfetch($data,$url) ){
			return $que[0]->id;
		}
		die("用户名错误！");
	}
	public static function postfetch($data,$url){
		$ch = curl_init();
		curl_setopt($ch, CURLOPT_URL,$url);
		curl_setopt($ch, CURLOPT_POST, true);
		curl_setopt($ch, CURLOPT_POSTFIELDS, $data);
		curl_setopt($ch, CURLOPT_HTTPHEADER, array("Content-Type: application/json"));
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
		curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
		$response = curl_exec($ch);
		curl_close($ch);
		return static::decodejson($response);
	}
	public static function decodejson($json){
		//var_dump($json);
		if($json==="[]"){
			return false;
		}
		$obj = json_decode($json);
		return $obj;
		
	}
	public static function namehistory($uuid){
		$url='https://api.mojang.com/user/profiles/'.$uuid.'/names';
		$his = static::getfetch($url);
		return $his;
	}
	public static function getfetch($url){
		$ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, 5);
        curl_setopt($ch, CURLOPT_TIMEOUT, 5);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
        $output = curl_exec($ch);
        curl_close($ch);
       // var_dump(json_decode($output));
        return json_decode($output);
	}
	public static function getskin($uuid){
		$url='https://sessionserver.mojang.com/session/minecraft/profile/'.$uuid;
		$obj=static::getfetch($url);
		if(property_exists($obj, 'error')){
			die("<br>皮肤信息查询过于频繁！");
		}else{
			$obj2=json_decode(base64_decode($obj->properties[0]->value))->textures;
			if(!property_exists($obj2, 'SKIN')){die("<br>该用户皮肤为默认皮肤!");}
			return json_decode(base64_decode($obj->properties[0]->value))->textures->SKIN->url;
		}
		
		//var_dump($obj);
	
	}

}



?>