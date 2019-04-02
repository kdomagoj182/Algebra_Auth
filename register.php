<?php
    include_once 'core/init.php';
	
	$user=new User();  #DB insert, što treba proslijediti, create lovi $userData array, #User class, metoda create#
	
	$validation=new Validation();  # objekt za validaciju, da ne izbacuje error na početnoj strani
	
	if(Request::exists('post')){
		if(Token::check(Request::getPost('CSRF_token'))){
			$validate=$validation->check(/*[
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
			]*/);
			
			if($validate->getPassed()){
				$salt=Hash::salt(32);
				
				$userData=[
					'username'=>Request::getPost('username'),
					'password'=>Hash::make(Request::getPost('password'), $salt),
					'salt'=>$salt,
					'name'=>Request::getPost('name')
				];
				
				try{
					
					$user->create($userData);
					throw new Exception('There was a problem creating an account!') #to mora biti u klasi User
					
				} catch(Exception $e){
					Session::flash('danger', $e->getMessage());
					Redirect::to('register');
				}
				
				
				Session::flash('success', 'You are registered successfully');
				Redirect::to('index');
			}
		}
	}
	
	Helper::getHeader('header', 'User Registration');
	
	include_once 'includes/notifications.php';
?>
<div class="row">
	<div class="col-md-4 offset-md-4">
		<div class="card">
			  <div class="card-header bg-primary">
				<h5 class="card-title text-white">User Registration</h5>
			  </div>
				<div class="card-body">
					<form method="post">
						<input type="hidden" name="CSRF_token" value="<?php echo Token::generate(); ?>">
							<div class="form-group">
								<label for="name">Name*</label>
								<input type="text" class="form-control" id="name" name="name" placeholder="Enter your name">
								<?php echo $validation->hasError('name') ? '<p class="text-danger">'.$validation->hasError('name').'</<p>': ''?>
							</div>
							<div class="form-group">
								<label for="username">Username*</label>
								<input type="text" class="form-control" id="username" name="username" placeholder="Enter your username">
								<?php echo $validation->hasError('username') ? '<p class="text-danger">'.$validation->hasError('username').'</<p>': ''?>
							</div>
							<div class="form-group">
								<label for="password">Password*</label>
								<input type="password" class="form-control" id="password" name="password" placeholder="Enter your password">
								<?php echo $validation->hasError('password') ? '<p class="text-danger">'.$validation->hasError('password').'</<p>': ''?>
							</div>
							<div class="form-group">
								<label for="confirmPassword">Confirm Password*</label>
								<input type="password" class="form-control" id="confirmPassword" name="confirmPassword" placeholder="Enter your password again">
								<?php echo $validation->hasError('confirmPassword') ? '<p class="text-danger">'.$validation->hasError('confirmPassword').'</<p>': ''?>
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
	