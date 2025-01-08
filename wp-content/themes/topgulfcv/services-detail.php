<?php
/*
* Template Name: Services Details
*
*
*/
get_header();
?>
 <section class="about-sec about-secinner bannerdetails">
        <div class="container c-container">
            <div class="banner-inner">
                <div class="row align-items-center">
                    <div class="col-lg-6 col-12">
                        <div class="banner-left-sec" data-aos="fade-right">
                            <h2 class="section-title">
                            <?php the_field('heading'); ?>
                            </h2>
                            <p> <?php the_field('heading_paragraph'); ?></span> </p>
                               
                        </div>
                    </div>
                    <div class="col-lg-6 col-12" data-aos="fade-left">
                        <!-- <div class="banner-right-sec img-round" data-aos="fade-left">
                            <img src="<?php the_post_thumbnail_url(); ?>" alt="about-img" class="img-fluid">
                        </div> -->
                        <div class="ratio ratio-16x9 video_wraper">
                        <iframe src="/wp-content/uploads/2024/02/pexels-c-technical-5971446-2160p-CV-RESUME-TEMPLATE.mp4" title="YouTube video" allowfullscreen></iframe>
                    
                            </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <!-- banner section end -->
    <section class="content-section listdetails">
        <div class="container c-container">
            <div class="row align-items-center flex-row-reverse"  data-aos="fade-down">

                <div class="col-lg-12 col-md-6 col-12">
                    <div class="content-section-text">
                        <h3 class="section-title">
                        <?php the_field('second_heading'); ?>
                            <p class="mt-2 mt-md-4">
                            <?php the_field('second_paragraph'); ?>
                            </p>
                          
                            
                        </h3>

                        <ul class="">
                              <h3 class="section-title">
                              <?php the_field('third_heading'); ?>
                              <?php the_field('third_paragraph'); ?>
                            
                        </h3>                          
                        </ul>

                        <a href="<?php the_field('get_started'); ?>" class="red-btn my-5">Get Started</a>
                    </div>
                </div>
                
            </div>
        </div>
    </section>

<?php get_footer();?>