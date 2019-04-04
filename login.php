<?php
    include_once 'core/init.php';
	
	$user=new User();  #DB insert, što treba proslijediti, create lovi $userData array, #User class, metoda create#
	if($user->check()){
		Redirect::to('dashboard');
	}
	$validation=new Validation();  # objekt za validaciju, da ne izbacuje error na početnoj strani
	
	if(Request::exists('post')){
		if(Token::check(Request::getPost('CSRF_token'))){
			$validate=$validation->check([
				
				'username'=>[
					'required'=>true,
				],
				'password'=>[
					'required'=>true,
				]
			]);
			
			if($validate->getPassed()){
				$username=Request::getPost('username');
				$password=Request::getPost('password');
				
				if($user->login($username, $password)){
					Redirect::to('dashboard');
				} else {
					Session::flash('danger', 'Sorry, login failed! Please try again.');
					Redirect::to('login');
				}
			}
		}
	}
	
	Helper::getHeader('header', 'User Logn');
	
	include_once 'includes/notifications.php';
?>
<div class="row">
	<div class="col-md-4 offset-md-4">
		<div class="card">
			  <div class="card-header bg-primary">
				<h5 class="card-title text-white">User LogIn</h5>
			  </div>
				<div class="card-body">
					<form method="post">
						<input type="hidden" name="CSRF_token" value="<?php echo Token::generate(); ?>">
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
							<button type="submit" class="btn btn-primary">LogIn</button>
					</form>
				
				
				</div>
	</div>
	</div>
</div>
<?php 
	Helper::getFooter('footer');
?>
	