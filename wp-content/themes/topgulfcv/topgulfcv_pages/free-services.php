<?php
/* Template Name: Free Services */ 
get_header();
$free_services_page = get_option('free_services_archive_page', 139);
?>

<main id="primary" class="site-main">
    <!-- banner section start -->
    <section class="content-section">
        <div class="container c-container">
            
                <div class="row align-items-center">
                    <div class="col-lg-6 col-md-6 col-12">
                        <div class="banner-left-sec" data-aos="fade-right">
                            <h2 class="section-title">
                            <?php the_field('free_services_heading', $free_services_page); ?>                            
                            </h2>
                            <p><?php the_field('free_services_para', $free_services_page); ?></p>
                        </div>
                    </div>
                    <div class="col-lg-6 col-md-6 col-12">
                        <div class="banner-right-sec" data-aos="fade-left">
                            <!-- <img src="<?php echo get_template_directory_uri(); ?>/images/about-img-1.png" alt="about-img" class="img-fluid"> -->
                            <div class="ratio ratio-16x9">
                                <video playsinline autoplay muted loop preload="none" style="display:none;" class="lazy-video">
                                    <source data-src="<?php the_field('free_services_video', $free_services_page); ?>" type="video/mp4">
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
                <?php echo the_field('free_services_heading',get_option('page_on_front')); ?>
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
                                    <a href="<?php the_permalink(); ?>" class="my-2 blue"><?php echo the_field('free_services_read_more', get_option('page_on_front')); ?></a>
                                </div>

                                <div class="d-flex justify-content-center readm">
                                    <!-- Button to open the form on the same page with ?form-popup parameter -->
                                    <button class="red-btn open-popup" onclick="window.location.href = '<?php the_permalink(); ?>?form_fill';">
                                        <?php the_field('button_name', $post_id); ?>
                                    </button>
                                </div>
                            </div>
                        </div>
                    <?php endwhile; ?>
                </div>
            </div>
    </section>
</main><!-- #main -->

<?php
get_sidebar();
get_footer();
