<?php

get_header();

?>

<main id="primary" class="site-main">
    <div class="sub-banner cont-banner"
        style="background-image: url(<?php site_url(); ?>/wp-content/uploads/2023/12/contact-banner.png);">
        <div class="container">
            <div class="sub-banner-content">
                <h1 class="section-title">Contact Us</h1>
                <p>Lets Have Discussion
                </p>
            </div>
        </div>
    </div>

    <section class="contact-form">
        <div class="container c-container">
            <h2 class="section-title  text-center mb-2">Get in <span class="d-inline-block">touch with us</span></h2>
            <p class="text-center">Can’t find exactly what you need? Let us know how we can help.</p>
            <div class="contact-form">
                <div class="row">
                    <div class="col-lg-6 col-md-6 col-12">
                        <div class="contact-form-right">
                            <?php echo do_shortcode(' [contact-form-7 id="ddc5076" title="contact us page"] ') ?>
                        </div>
                    </div>
                    <div class="col-lg-6 col-md-6 col-12">
                        <div class="ratio ratio-16x9 contact_wraper">
                            <video src="/wp-content/uploads/2024/02/pexels_videos_1903279-1440p-CONTACT-US.mp4" muted autoplay
                                loop loading="lazy">
                                Your browser does not support the video tag.
                            </video>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
</main><!-- #main -->

<?php
get_sidebar();
get_footer();
