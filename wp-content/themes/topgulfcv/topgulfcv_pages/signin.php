<?php 
$file_path = site_url().'/wp-content/uploads/2023/10/';
get_header();
?>

	<main id="primary" class="site-main">
        <!-- form-inner  -->
        <section class="all-form">
            <div class="container">
                <div class="form-inner">
                    <h3 class="section-title text-center">LOGIN</h3>
                    <?php wc_print_notices(); ?>
                    <form method="post">
                        <div class="form-group">
                            <label>Email</label>
                            <input type="email" name="username" placeholder="Email" class="form-control">
                        </div>
                        <div class="form-group">
                            <label>Password</label>
                            <input type="password" placeholder="Password" name="password" class="form-control">
                        </div>
                        <div class="d-flex justify-content-end">
                            <a href="#" class="f-password">Forgot Password?</a>
                        </div>
                        <div class="Checkbox">
                            <div class="form-group">
                                <input type="checkbox" name="rememberme" id="html">
                                <label for="html">Remember me</label>
                            </div>
                        </div>
                        <div class="sign-in-btn">
                            <button class="red-btn" type="input" name="login">
                                Login
                            </button>
                        </div>
                        <?php wp_nonce_field( 'topgulfcv-login', 'topgulfcv-login-nonce' ); ?>
                        <div class="d-flex justify-content-center flex-column gap-4 align-items-center">
                            <p>Not a user yet?<a href="<?= home_url('signup');?>" class="signup-link"> SIGN UP</a></p>

                            <h5>or</h5>

                            <a href="#">
                                <img src="<?= site_url();?>/wp-content/uploads/2023/10/g-login.png" alt="login" class="img-fluid"></a>
                        </div>
                    </form>
                </div>
            </div>
        </section>
        <!-- form-inner  -->
    </main><!-- #main -->

<?php
get_footer();
?>