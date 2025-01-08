<?php
/* Template Name: Free Services */ 
get_header();

?>

<main id="primary" class="site-main">
    <!-- banner section start -->
    <section class="content-section">
        <div class="container c-container">
            
                <div class="row align-items-center">
                    <div class="col-lg-6 col-md-6 col-12">
                        <div class="banner-left-sec" data-aos="fade-right">
                            <h2 class="section-title">
                                <?php the_field('free_services_heading'); ?>
                            </h2>
                            <p><?php the_field('free_services_para'); ?></p>
                        </div>
                    </div>
                    <div class="col-lg-6 col-md-6 col-12">
                        <div class="banner-right-sec" data-aos="fade-left">
                            <!-- <img src="<?php echo get_template_directory_uri(); ?>/images/about-img-1.png" alt="about-img" class="img-fluid"> -->
                            <div class="ratio ratio-16x9">
                                <video playsinline autoplay muted loop preload="none" style="display:none;" class="lazy-video">
                                    <source data-src="<?php the_field('free_services_video', 139); ?>" type="video/mp4">
                                </video>   
                            </div>

                        </div>
                    </div>
                </div>
           
        </div>
    </section>
    <!-- banner section end -->
    <section class="content-section pb-5">
        <div class="container c-container">
        <div class="job-section pb-0">
                <h2 class="section-title text-center">
                <?php echo the_field('free_services_heading', 5); ?>
                </h2>
                <div class="row justify-content-center">
                <?php
                    $paged = get_query_var('paged') ? get_query_var('paged') : 1; // setup pagination
                    $the_query = new WP_Query(
                        array(
                            'post_type' => 'add_free_services',
                            'paged' => $paged,
                            'orderby' => 'DESC',
                        )
                    );
                    while ($the_query->have_posts()):
                        $the_query->the_post();
                        $post_id = get_the_ID(); // Get the current post ID
                        $content = get_the_content(); // Get the full content
                        $excerpt = wp_trim_words($content, 21, '...'); // Limit to 21 words
                    ?>
                        <div class="col-md-6 col-sm-12 col-12 mb-2 col-lg-4" data-aos="zoom-in">
                            <div class="job-sec-box">
                                <div class="job-sec-icon">
                                    <img src="<?php the_post_thumbnail_url(); ?>" alt="icon">
                                </div>
                                <h5>
                                    <?php the_title(); ?>
                                </h5>
                                <p>
                                    <?php echo esc_html($excerpt); ?>
                                </p>
                                <div class="d-flex justify-content-center readm">
                                    <a href="<?php the_permalink(); ?>" class="my-2 blue"><?php echo the_field('free_services_read_more', 5); ?></a>
                                </div>

                                <div class="d-flex justify-content-center readm">
                                    <!-- Button to open the form on the same page with ?form-popup parameter -->
                                    <button class="red-btn open-popup" onclick="window.location.href = '<?php the_permalink(); ?>?form_fill';">
                                        <?php the_field('button_name'); ?>
                                    </button>
                                </div>
                            </div>
                        </div>
                    <?php endwhile; ?>
                </div>
            </div>
    </section>

    <!-- <section class="blog">
        <div class="container c-container">
            <h3 class="section-title text-center mb-5">
                Our Latest <span class="d-inline"> Blog</span>
            </h3>
            <div class="blog-inner">
                <div class="row justify-content-center">
                    <div class="col-lg-4 col-md-6 col-12">
                        <div class="blog-box">
                            <a href="#">
                                <div class="blog-img position-relative">
                                    <img src="images/blog-img-1.png" alt="blog-img" class="img-fluid">
                                    <span class="blog-date"> 16th oct 2023</span>
                                </div>
                                <div class="blog-text">
                                    <h5>New Generation</h5>
                                    <p class="mt-2 ">Lorem ipsum dolor sit amet, consectetur adipiscing elit. sed do
                                        eiusmodLorem
                                        ipsum
                                        dolor sir amet, consectetur adipiscing elit, sed do eiusm</p>
                                    <a href="#" class="readmore">Read More</a>
                                    <div class="d-flex justify-content-end blog-shape">
                                        <a href="#"><img src="images/blog-arrow.png" alt="arrow"
                                                class="img-fluid position-relative"></a>
                                    </div>
                                </div>
                            </a>
                        </div>
                    </div>
                    <div class="col-lg-4 col-md-6 col-12">
                        <div class="blog-box">
                            <a href="#">
                                <div class="blog-img position-relative">
                                    <img src="images/blog-img-2.png" alt="blog-img" class="img-fluid">
                                    <span class="blog-date"> 16th oct 2023</span>
                                </div>
                                <div class="blog-text">
                                    <h5>Most Important</h5>
                                    <p class="mt-2 ">Lorem ipsum dolor sit amet, consectetur adipiscing elit. sed do
                                        eiusmodLorem
                                        ipsum
                                        dolor sir amet, consectetur adipiscing elit, sed do eiusm</p>
                                    <a href="#" class="readmore">Read More</a>
                                    <div class="d-flex justify-content-end blog-shape">
                                        <a href="#"><img src="images/blog-arrow.png" alt="arrow"
                                                class="img-fluid position-relative"></a>
                                    </div>
                                </div>
                            </a>
                        </div>
                    </div>
                    <div class="col-lg-4 col-md-6 col-12">
                        <div class="blog-box">
                            <a href="#">
                                <div class="blog-img position-relative">
                                    <img src="images/blog-img-3.png" alt="blog-img" class="img-fluid">
                                    <span class="blog-date"> 16th oct 2023</span>
                                </div>
                                <div class="blog-text">
                                    <h5>New days Insipiration</h5>
                                    <p class="mt-2 ">Lorem ipsum dolor sit amet, consectetur adipiscing elit. sed do
                                        eiusmodLorem
                                        ipsum
                                        dolor sir amet, consectetur adipiscing elit, sed do eiusm</p>
                                    <a href="#" class="readmore">Read More</a>
                                    <div class="d-flex justify-content-end blog-shape">
                                        <a href="#"><img src="images/blog-arrow.png" alt="arrow"
                                                class="img-fluid position-relative"></a>
                                    </div>
                                </div>
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section> -->
</main><!-- #main -->

<?php
get_sidebar();
get_footer();
