<?php /*
  * Template Name: Testimonial
  * Template Post Type: testimonial
  */
get_header();
?>
<style>
    .banner-inner {
        position: relative;
        margin-top: 15vh;
        margin-bottom: 15vh;
    }

    .section-title {
        margin-bottom: 0px;
    }

    .banner-inner p {
        margin-top: 30px;
    }
</style>

<section class="banner-sec">
        <div class="video-container"> 
            <video playsinline autoplay muted loop preload="none" style="display:none;" class="lazy-video">
                <source data-src="/wp-content/uploads/2024/02/pexels-noor-khalafy-15439491-1080p-TESTIMONIALS-PAGE.mp4" type="video/mp4">
            </video> 
        </div>
</section>
<section class="about-sec about-secinner">
    <div class="container c-container">
        

        <div class="container c-container testimonial_content">
            <div class="banner-inner">
                <div class="row align-items-center">
                    <div class="col-lg-8 col-12">
                        <div class="banner-left-sec aos-init aos-animate">
                            <h2 class="section-title">
                                <?php the_title(); ?> <span>
                                    <?php echo the_field('designation'); ?>
                                </span>
                            </h2>
                            <h4>
                                <?php echo the_field('company_name'); ?>
                                <h4>
                                    <p>
                                        <?php the_content(); ?>
                                    </p>
                        </div>
                    </div>
                    <div class="col-lg-4 col-12">
                        <div class="banner-right-sec aos-init aos-animate">
                            <img src="<?php echo get_the_post_thumbnail_url(); ?>" alt="about-img" class="img-fluid">
                        </div>
                    </div>
                </div>
            </div>
        </div>

</section>

<?php get_footer(); ?>