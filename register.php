<?php
    include_once 'core/init.php';
	
	Helper::getHeader('header', 'User Registration');
	
	$validation=new Validation();  # objekt za validaciju, da ne izbacuje error na početnoj strani
	
	if(Request::exists('post')){
		$validate=$validation->check([
			'name'=>[
				'required'=>true,
				'min'=>2,
				'max'=>50
			],
			'username'=>[
				'required'=>true,
				'min'=>2,
				'max'=>50,
				'unique'=>'users'
				],
			'password'=>[
				'required'=>true,
				'min'=>10
			],
			'confirmPassword'=>[
				'match'=>'password'
			]
		]);
		dump($validate->getPassed());
		dd($validate->getErrors());
	}
?>
<div class="row">
	<div class="col-md-4 offset-md-4">
		<div class="card">
			  <div class="card-header bg-primary">
				<h5 class="card-title text-white">User Registration</h5>
			  </div>
				<div class="card-body">
					<form method="post">
							<div class="form-group">
								<label for="name">Name*</label>
								<input type="text" class="form-control" id="name" name="name" placeholder="Enter your name">
							</div>
							<div class="form-group">
								<label for="username">Username*</label>
								<input type="text" class="form-control" id="username" name="username" placeholder="Enter your username">
							</div>
							<div class="form-group">
								<label for="password">Password*</label>
								<input type="password" class="form-control" id="password" name="password" placeholder="Enter your password">
							</div>
							<div class="form-group">
								<label for="confirmPassword">Confirm Password*</label>
								<input type="password" class="form-control" id="confirmPassword" name="confirmPassword" placeholder="Enter your password again">
							</div>
							<button type="submit" class="btn btn-primary">Create account</button>
					</form>
				
				
				</div>
	</div>
	</div>
</div>
<?php 
	Helper::getFooter('footer');
?>
	