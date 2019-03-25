<?php 
	include_once 'core/init.php';
	
	$user='peroždero';
	
	
	$db=DB::getInstance()->get('*', 'users', array('username', '=', $user));
	dump($db);