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
							<h3 class="f_p f_600 f_size_24 t_color3 mb_40">Allready have an account?</h3>
							<h2 class="f_p f_400 f_size_30 mb-30">Login now and<br> starting using our <br><span class="f_700">amazing</span> service</h2>
							<ul class="list-unstyled mb-0">
								<li><i class="ti-check"></i> Reduce Shipping Cost & Increase Reach</li>
								<li><i class="ti-check"></i> Lower return costs as compared to forward charges</li>
								<li><i class="ti-check"></i> Maximum insurance coverage for lost shipments</li>
								<li><i class="ti-check"></i> Effective order tracking via SMS and Email notifications
								</li>
							</ul>
							<a href="<?= base_url(''); ?>" class="btn_three sign_btn_transparent">Log in</a>
						</div>
					</div>
					<div class="col-lg-7">
						<div class="login_info">
							<h2 class="f_p f_600 f_size_24 t_color3 mb_40">Sign Up</h2>
							<form action="<?= base_url('sign-up'); ?>" name="signup_form" method="post" class="login-form sign-in-form" autocomplete="off">
								<div class="form-group text_box">
									<label class="f_p text_c f_400">First Name</label>
									<input type="text" name="first_name" id="first_name" placeholder="First Name" value="<?= isset($_POST['first_name']) ? $_POST['first_name'] : ''; ?>">
									<?php if (isset($errors['first_name'])) { ?>
										<label class="error"><?= @$errors['first_name'] ?></label>
									<?php } ?>
								</div>
								<div class="form-group text_box">
									<label class="f_p text_c f_400">Last Name</label>
									<input type="text" name="last_name" id="last_name" placeholder="Last Name" value="<?= isset($_POST['last_name']) ? $_POST['last_name'] : ''; ?>">
									<?php if (isset($errors['last_name'])) { ?>
										<label class="error"><?= @$errors['last_name'] ?></label>
									<?php } ?>
								</div>
								<div class="form-group text_box">
									<label class="f_p text_c f_400">Email Address</label>
									<input type="email" name="user_email" id="user_email" placeholder="Your Email" value="<?= isset($_POST['user_email']) ? $_POST['user_email'] : ''; ?>" autocomplete="off">
									<?php if (isset($errors['user_email'])) { ?>
										<label class="error"><?= @$errors['user_email'] ?></label>
									<?php } ?>
								</div>
								<div class="form-group text_box">
									<label class="f_p text_c f_400">Password</label>
									<div class="password_signup">
										<div class="pwd-input">
											<input type="password" name="user_password" id="user_password" placeholder="Your Password" value="<?= isset($_POST['user_password']) ? $_POST['user_password'] : ''; ?>" autocomplete="off">
										</div>
										<div>
											<i class="fa fa-eye eye_icon_signup" id="toggle_signup_pwd"></i>
										</div>
									</div>
									<br />
									<?php if (isset($errors['user_password'])) { ?>
										<label class="error"><?= @$errors['user_password'] ?></label>
									<?php } ?>
								</div>
								<div class="form-group text_box">
									<label class="f_p text_c f_400">Confirm Password</label>
									<div class="password_signup">
										<div class="pwd-input">
											<input type="password" name="user_confirm_password" id="user_confirm_password" placeholder="Your Confirm Password" value="<?= isset($_POST['user_confirm_password']) ? $_POST['user_confirm_password'] : ''; ?>">
										</div>
										<div>
											<i class="fa fa-eye eye_icon_signup" id="toggle_signup_pwd_con"></i>
										</div>
									</div>
									<br />
									<?php if (isset($errors['user_confirm_password'])) { ?>
										<label class="error"><?= @$errors['user_confirm_password'] ?></label>
									<?php } ?>
								</div>
								<div class="form-group text_box">
									<label class="f_p text_c f_400">Mobile No</label>
									<input type="text" name="user_phone" id="user_phone" placeholder="Your Mobile No" value="<?= isset($_POST['user_phone']) ? $_POST['user_phone'] : ''; ?>">
									<?php if (isset($errors['user_phone'])) { ?>
										<label class="error"><?= @$errors['user_phone'] ?></label>
									<?php } ?>
								</div>
								<div class="form-group text_box">
									<label class="f_p text_c f_400">Website</label>
									<input type="text" name="user_website" id="user_website" placeholder="Your Website" value="<?= isset($_POST['user_website']) ? $_POST['user_website'] : ''; ?>">
									<?php if (isset($errors['user_website'])) { ?>
										<label class="error"><?= @$errors['user_website'] ?></label>
									<?php } ?>
								</div>
								<div class="extra mb_20">

									<div class="checkbox remember">
										<label>
											<input type="checkbox" name="user_agreement" id="user_agreement" value="1">
											I agree to <a href="<?= base_url('pack-and-drop-agreement.pdf'); ?>" target="_blank">terms and conditions</a> of this website
										</label>
										<?php if (isset($errors['user_agreement'])) { ?>
											<label class="error" style="color: red;"><?= @$errors['user_agreement']; ?></label>
										<?php } ?>
										<label id="user_agreement-error" class="error" style="color: red;" for="user_agreement"></label>
									</div>
									<!-- //check-box-->
									<!-- <div class="forgotten-password">
                                        <a href="#">Forgot Password?</a>
                                    </div> -->
								</div>
								<div class="d-flex justify-content-between align-items-center">
									<button type="submit" id="signup_btn" class="btn_three">Sign Up</button>
								</div>
							</form>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>
</section>
