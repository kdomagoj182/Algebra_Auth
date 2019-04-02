<?php

class Redirect
{
	private function __construct(){}
	
	public static function to($location=null)
	{
		if($location){
			if(is_numeric($location)){
				switch($location){
					case 404:
						header('HTTP/1.0 404 Not Found');
						exit();
						break;
				}
			}
			
			header('Location: '.$location.'.php');
			exit();
		}
		
		return false;
	}
}