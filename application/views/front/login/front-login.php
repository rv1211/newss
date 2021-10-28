<head>
	<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/font-awesome/4.4.0/css/font-awesome.min.css">
</head>
<section class="seo_home_area">
	<div class="home_bubble">
		<div class="bubble b_one"></div>
		<div class="bubble b_two"></div>
		<div class="bubble b_three"></div>
		<div class="bubble b_four"></div>
		<div class="bubble b_five"></div>
		<div class="bubble b_six"></div>
		<div class="triangle b_seven" data-parallax='{"x": 20, "y": 150}'><img src="<?= base_url(); ?>assets/front-end/img/seo/triangle_one.png" alt=""></div>
		<div class="triangle b_eight" data-parallax='{"x": 120, "y": -10}'><img src="<?= base_url(); ?>assets/front-end/img/seo/triangle_two.png" alt=""></div>
		<div class="triangle b_nine"><img src="<?= base_url(); ?>assets/front-end/img/seo/triangle_three.png" alt="">
		</div>
	</div>
	<div class="banner_top">
		<div class="container">
			<div class="sign_info">
				<div class="row">
					<div class="col-lg-5">
						<div class="sign_info_content">
							<h3 class="f_p f_600 f_size_24 t_color3 mb_40">First time here?</h3>
							<h2 class="f_p f_400 f_size_30 mb-30">Grow your ecommerce business and reduce cost</h2>
							<ul class="list-unstyled mb-0">
								<li><i class="ti-check"></i> Reduce Shipping Cost & Increase Reach</li>
								<li><i class="ti-check"></i> Lower return costs as compared to forward charges</li>
								<li><i class="ti-check"></i> Maximum insurance coverage for lost shipments</li>
								<li><i class="ti-check"></i> Effective order tracking via SMS and Email notifications
								</li>
							</ul>

							<a href="<?= base_url('sign-up'); ?>" class="btn_three sign_btn_transparent">Sign Up</a>
						</div>
					</div>
					<?php $errors = $this->form_validation->error_array(); ?>
					<div class="col-lg-7">
						<div class="login_info">
							<h2 class="f_p f_600 f_size_24 t_color3 mb_40">Login</h2>
							<form action="<?= base_url(''); ?>" method="post" name="login_form" class="login-form sign-in-form" autocomplete="off">
								<div class="form-group text_box">
									<label class="f_p text_c f_400">Email</label>
									<input type="email" name="user_email" id="user_email" placeholder="Your Email" autocomplete="off">
									<?php if (isset($errors['user_email'])) { ?>
										<label class="error"><?= @$errors['user_email'] ?></label>
									<?php } ?>
								</div>
								<div class="form-group text_box">
									<label class="f_p text_c f_400">Password</label>
									<div class="password_signup">
										<div class="pwd-input">
											<input type="password" name="user_password" id="user_password" placeholder="Your Password" autocomplete="off" value="<?= isset($_POST['user_password']) ? $_POST['user_password'] : ''; ?>">
										</div>
										<div>
											<i class="fa fa-eye eye_icon_login" id="toggle_signup_pwd"></i>
										</div>
									</div>
									<br />
									<?php if (isset($errors['user_password'])) { ?>
										<label class="error"><?= @$errors['user_password'] ?></label>
									<?php } ?>
								</div>
								<?php if (isset($errors['user_password'])) { ?>
									<label class="error"><?= @$errors['user_password'] ?></label>
								<?php } ?>
								<div class="d-flex justify-content-between align-items-center">
									<button type="submit" class="btn_three" id="login_btn">Log in</button>
									<div class="social_text d-flex ">
										<div class="lead-text">
											<a href="<?= base_url('forgot-password') ?>" class="text_reg">Forgot password
												?</a>
										</div>
										<div class="lead-text">Don't have an account?</div>
										<a href="<?= base_url('sign-up'); ?>" class="text_reg">Click here</a>
									</div>
								</div>
							</form>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>
</section>


<!-- <script type="text/javascript">
    const togglePassword = document.querySelector('#togglePassword');
    const password = document.querySelector('#user_password');
    togglePassword.addEventListener('click', function (e) {
    // toggle the type attribute
    
    const type = password.getAttribute('type') === 'password' ? 'text' : 'password';
    password.setAttribute('type', type);
    // toggle the eye slash icon
    this.classList.toggle('fa-eye');
});
</script> -->
