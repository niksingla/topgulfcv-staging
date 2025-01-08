<?php 
/**
 * Template Name: Blog
 *
 * */
$file_path = site_url().'/wp-content/uploads/2023/10/';
get_header();
?>

<main id="primary" class="site-main">
    <!-- banner section start -->
    <section class="about-sec">
        <div class="container c-container">
            <div class="">
                <div class="row align-items-center">
                    <div class="col-lg-6 col-12">
                        <div class="banner-left-sec">
                            <h2 class="section-title">
                                <?php the_field('title'); ?>
                            </h2>
                            <p> <?php the_field('description_'); ?> </p>
                        </div>
                    </div>
                    <div class="col-lg-6 col-12">
                        <div class="banner-right-sec">
                            <img src="<?php the_field('image'); ?>" alt="about-img" class="img-fluid">
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <!-- banner section end -->
    <section class="blog">
        <div class="container c-container">
            <h3 class="section-title text-center ">
                <?php the_field('blog_heading'); ?>
            </h3>
            <p class="text-center mb-4 mb-md-5
                "> <?php the_field('blog_description'); ?></p>
            <div class="blog-inner">
                <div class="row justify-content-center">
                    <?php
                        $paged = get_query_var('paged') ? get_query_var('paged') : 1; // setup pagination
                        $the_query = new WP_Query(
                            array(
                                'post_type' => 'post',
                                'paged' => $paged,
                                'orderby' => 'DESC',
                                'posts_per_page' => 3,

                            )
                        );
                        while ($the_query->have_posts()):
                            $the_query->the_post();
                            ?>
                    <div class="col-lg-4 col-md-6 col-sm-6 col-12 mb-3 mb-lg-5">
                        <div class="blog-box">
                            <a href="<?php echo get_permalink(); ?>">
                                <div class="blog-img position-relative">
                                    <img src="<?php echo get_the_post_thumbnail_url(); ?>" alt="blog-img"
                                        class="img-fluid">
                                    <span class="blog-date"><?php echo esc_html( get_the_date() ); ?> </span>
                                </div>
                                <div class="blog-text">
                                    <h5><?php the_title(); ?></h5>
                                    <p class="mt-2 "> <?php
                                        $content = get_the_content();
                                        echo wp_trim_words( $content, 30, '...' );
                                        ?></p>
                                    <a href="<?php echo get_permalink(); ?>" class="readmore">Read More</a>
                                    <div class="d-flex justify-content-end blog-shape">
                                        <a href="<?php echo get_permalink(); ?>"><img
                                                src="<?= $file_path;?>blog-arrow.png" alt="arrow"
                                                class="img-fluid position-relative"></a>
                                    </div>
                                </div>
                            </a>
                        </div>
                    </div>
                    <?php endwhile; ?>
                </div>
            </div>
        </div>
    </section>
    <div class="sec-pagination">
        <nav class="text-center">
            <ul class="pagination">
                <?php
            $pagination = paginate_links(array(
                'prev_text' => '<i class="fas fa-angle-left" aria-hidden="true"></i>',
                'next_text' => '<i class="fas fa-angle-right" aria-hidden="true"></i>',
                'type' => 'array',
                'current' => max(1, get_query_var('paged')),
                'total' => $the_query->max_num_pages,
                'screen_reader_text' => __( 'Posts navigation' ),
                'before_page_number' => '<li class="page-link">',
                'after_page_number' => '</li>',
                'current_class' => 'active',
            ));
            if ($pagination) {
                foreach ($pagination as $page) {
                    echo $page;
                }
            }
            ?>
            </ul>
        </nav>
    </div>

</main><!-- #main -->

<?php
get_footer();
?>