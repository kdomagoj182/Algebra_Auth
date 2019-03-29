<?php 
	include_once 'core/init.php';
	
	Helper::getHeader('header', 'Home');
?>


	<div class="row">
		<div class="col-md-8 offset-md-2">
			<div class="jumbotron">
				<h1 class="display-4">Algebra Auth</h1>
				<p class="lead">This is a simple hero unit, a simple jumbotron-style component for calling extra attention to featured content or information.</p>
				<hr class="my-4">
				<p>It uses utility classes for typography and spacing to space content out within the larger container.</p>
				<a class="btn btn-primary btn-lg" href="login.php" role="button">Sign in</a>
				or
				<a class="btn btn-primary btn-lg" href="register.php" role="button">Create an account</a>
			</div>
		</div>
	</div>
	

 <?php 
	Helper::getFooter('footer');
?>
	