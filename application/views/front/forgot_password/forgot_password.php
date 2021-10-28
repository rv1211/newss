<section class="seo_home_area">
    <div class="home_bubble">
        <div class="bubble b_one"></div>
        <div class="bubble b_two"></div>
        <div class="bubble b_three"></div>
        <div class="bubble b_four"></div>
        <div class="bubble b_five"></div>
        <div class="bubble b_six"></div>
        <div class="triangle b_seven" data-parallax='{"x": 20, "y": 150}'><img
                src="<?= base_url(); ?>assets/front-end/img/seo/triangle_one.png" alt=""></div>
        <div class="triangle b_eight" data-parallax='{"x": 120, "y": -10}'><img
                src="<?= base_url(); ?>assets/front-end/img/seo/triangle_two.png" alt=""></div>
        <div class="triangle b_nine"><img src="<?= base_url(); ?>assets/front-end/img/seo/triangle_three.png" alt="">
        </div>
    </div>
    <div class="banner_top">
        <div class="container">
            <div class="row">
                <div class="col-md-8 mx-auto">

                    <?php $errors = $this->form_validation->error_array(); ?>
                    <div class="sign_info">
                        <div class="row">
                            <div class="col-lg-12">
                                <div class="login_info">
                                    <h2 class="f_p f_600 f_size_24 t_color3 mb_40">Forgot password</h2>
                                    <form action="<?= base_url('forgot-password-email'); ?>" method="post"
                                        name="forgot_pwd_form" class="forgot_pwd">
                                        <div class="form-group text_box">
                                            <!-- <label class="f_p text_c f_400">Email</label> -->
                                            <input type="text" name="email" id="email" placeholder="Your Email"
                                                required>
                                            <?php if (isset($errors['email'])) { ?>
                                            <label class="error"><?= @$errors['email']?></label>
                                            <?php } ?>
                                        </div>
                                        <div class="d-flex align-items-center justify-content-center">
                                            <button type="submit" class="btn_three mt-0" id="forgot_btn">Submit</button>
                                        </div>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>