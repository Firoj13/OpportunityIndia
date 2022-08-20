<?php

namespace App\Helpers;

class UserHelper  {

	static function maskPhoneNumber($number){		
		$mask_number =  str_repeat("*", strlen($number)-4) . substr($number, -4);
		return $mask_number;
	}

	static function maskEmail($email)
	{
		$em   = explode("@",$email);
		$name = implode('@', array_slice($em, 0, count($em)-1));
		$len  = floor(strlen($name));
		return str_repeat('*', $len) . "@" . end($em);   
	}
}