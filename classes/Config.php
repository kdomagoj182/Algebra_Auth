<?php

class Config  # pomoćna klasa
{
	private function __construct(){}
	
	public static function get($file='')
	{
		if($file){
			$arr=require 'config/'.$file.'.php';
			return $arr;
		}
		
		return false;
	}
}

