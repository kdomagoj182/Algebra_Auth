<?php

	include_once 'core/init.php';
	
	$user=new User();  
	
	if(!$user->check()){
		Redirect::to('index');
	}
	
	Helper::getHeader('header', 'Dashboard');
	
	include_once 'includes/notifications.php';
?>
	<h1>Dashboard</h1>
	<a href="logout.php">Logout</a>
<?php 
	Helper::getFooter('footer');
?>