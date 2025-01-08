<?php
/**
 * Template Name: Home page
 *
 * This is the template that displays all pages by default.
 * Please note that this is the WordPress construct of pages
 * and that other 'pages' on your WordPress site may use a
 * different template.
 *
 * @link https://developer.wordpress.org/themes/basics/template-hierarchy/
 *
 * @package Top_Gulf_CV
 */

get_header();

?>

<main id="primary" class="site-main">
    <!-- about us sec  start-->
    <section class="banner-sec">
        <div class="video-container">
            <video playsinline autoplay muted loop preload="none" style="display:none;" class="lazy-video">
                <source data-src="<?php the_field('home_banner_video') ?>" type="video/mp4">
            </video>
        </div>
        <div class="banner-inner">

            <div class="owl-carousel owl-theme banner-slider owlcrousel_two">
                <?php
                $paged = get_query_var('paged') ? get_query_var('paged') : 1; // setup pagination
                $the_query = new WP_Query(
                    array(
                        'post_type' => 'home_slider',
                        'paged' => $paged,
                        'orderby' => 'DESC',

                    )
                );
                while ($the_query->have_posts()):
                    $the_query->the_post();
                    ?>
                    <div class="item">
                        <!-- <img src=" <?php the_field('background_image'); ?>" alt="banner-img" class="img-fluid"> -->
                        <div class="slider_content">
                            <div class="banner-inner-content">
                                <div class="container c-container">
                                    <div class="row align-items-center justify-content-center">
                                        <div class="col-lg-12 col-12">
                                            <div class="banner-left-sec" data-aos="fade-zoom-in"
                                                data-aos-easing="ease-in-back" data-aos-delay="200" data-aos-offset="0">
                                                <?php the_field('banner_text'); ?>
                                                <div class="d-flex justify-content-center readm">
                                                    <a href="<?php the_field('button_url'); ?>"
                                                        class="red-btn my-2 my-sm-4">
                                                        <?php the_field('button_text'); ?>
                                                    </a>
                                                    <?php
                                                    $button_url = get_field('second_button_url');
                                                    $button_text = get_field('second_button_text');
                                                    if ($button_url && $button_text) {
                                                        echo '<a href="' . esc_url($button_url) . '" class="red-btn my-2 my-sm-4">' . esc_html($button_text) . '</a>';
                                                    } ?>

                                                </div>

                                            </div>
                                        </div>

                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                <?php endwhile; ?>
            </div>
        </div>
        </div>
    </section>
    <!-- banner section end -->
    <!-- about us sec  start-->
    <section class="about-sec">
        <div class="container c-container">
            <div class="trusted-by">
                <h3 class="section-sub-title text-center mb-2">
                    <?php the_field('our_clients_heading', 5); ?>
                </h3>
                <div class="owl-carousel owl-theme logo-pannel owlcrousel_one">
                    <?php if (have_rows('our_clients_logo', 5)):
                        while (have_rows('our_clients_logo', 5)):
                            the_row(); ?>
                            <div class="item">
                                <div class="trusted-by-logo">
                                    <img src="<?php echo the_sub_field('our_clients_logo_image', 5); ?>" alt="company-logo"
                                        class="img-fluid">
                                </div>
                            </div>
                        <?php endwhile;
                    endif; ?>
                </div>
            </div>
        </div>
    </section>
    <!-- about us sec  end-->
    <section class="content-section">
        <div class="container c-container">
            <div class="row align-items-center">
                <div class="col-lg-5 col-md-6 col-12" data-aos="fade-right">
                    <div class="content-img">
                        <img src="<?php echo the_field('our_clients_image', 5); ?>" alt="content-img-1" class="img-fluid">
                    </div>
                </div>
                <div class="col-lg-7 col-md-6 col-12">
                    <div class="content-section-text" data-aos="fade-top">
                        <h3 class="section-title">
                            <?php echo the_field('find_your_dream_job_heading', 5); ?>
                            <p class="mt-2 mt-md-4">
                            </p>
                        </h3>
                    </div>
                </div>
            </div>
            <div class="job-section">
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

            <hr class="border_line">
            <div class="job-section pb-0 paid-service">
                <h2 class="section-title text-center">  <?php echo the_field('paid_services_heading', 5); ?></h2>
                <div class="row justify-content-center" data-aos="fade-down">
                        <?php
                            $args = array(
                                'post_type' => 'product',
                                'posts_per_page' => -1 // Get all products
                            );
                            $products = new WP_Query($args);

                            if ($products->have_posts()) :
                                while ($products->have_posts()) :
                                    $products->the_post();
                                    $product_id = get_the_ID();
                                    $product = wc_get_product($product_id);
                                    $price = $product->get_price();
                                    $short_description = $product->get_short_description();
                                    $product_name = get_the_title();
                                    $product_image_url = get_the_post_thumbnail_url($product_id, 'full');
                                    $currency_symbol = get_woocommerce_currency_symbol();
                                    $attributes = $product->get_attributes();
                                    $attribute_value_output = '';
                                    $product_permalink = get_permalink($product_id);
 
                                    foreach ($attributes as $attribute) {
                                        $attribute_name = $attribute->get_name();
                                        $attribute_value = $product->get_attribute($attribute_name);
                                        $attribute_value_output .= $attribute_value;
                                    }
                            ?>
                                            <div class="col-md-6 col-sm-12 col-12 mb-4 col-lg-4" data-aos="zoom-in">
                                                <div class="job-sec-box">
                                                    <div class="job-sec-icon">
                                                        <img src="<?php echo $product_image_url; ?>" alt="icon">
                                                    </div>
                                                    <h5><?php echo $product_name; ?></h5>
                                                    <p><?php echo $short_description; ?></p>
                                                    <div class="d-flex justify-content-center readm">
                                                        <a href="  <?php echo $product_permalink; ?>" class="my-2 blue"><?php echo the_field('paid_services_read_more_button_', 5); ?> </a>
                                                    </div>
                                                    <div class="subscription-price my-3">
                                                        <h6 class="section-title"><span><small><?php echo $currency_symbol; ?></small>
                                                                <?php echo $price; ?>
                                                            </span>
                                                            <?php if (!empty($attribute_value_output)) : ?>
                                                            <?php echo $attribute_value_output; ?>
                                                            <?php endif; ?>
                                                        </h6>
                                                        <div class="asteric"><?php echo the_field('asteric'); ?> </div>
                                                    </div>
                                                    <div class="d-flex justify-content-center readm">
                                                        <button class="add-to-cart-btn red-btn my-2 my-sm-4" id="open-call-four"
                                                            data-product-id="<?php echo $product_id; ?>">Add to Cart</button>
                                                        <div id="cartSidebarContainer"></div>
                                                    </div>
                                                </div>
                                            </div>
                                            <?php
                                endwhile;
                                wp_reset_postdata();
                            endif;
                            ?>

                        </div>
            </div>
            <!--  <div class="row align-items-center flex-row-reverse">
                <div class="col-lg-5 col-md-6 col-12">
                    <div class="content-img">
                        <img src="<?php echo get_template_directory_uri(); ?>/images/content-img-2.png" alt="content-img-1" class="img-fluid">
                    </div>
                </div>
                <div class="col-lg-7 col-md-6 col-12">
                    <div class="content-section-text">
                        <h3 class="section-title">
                            We are Trusted by Popular
                            <span>800+ Company</span>
                            <p class="mt-2 mt-md-4">
                                
                            </p>
                        </h3>
                    </div>
                </div>
            </div> -->
        </div>
    </section>
    <section class="feedback want-hide">
        <div class="container c-container">
            <h3 class="section-title text-center ">
            <?php the_field('testimonials_heading', 5); ?>
            </h3>
            <p class="text-center"></p>
            <div class="testimonial-inner">
                <div class="row align-items-center">
                    <div class="col-md-4 col-12">
                        <div class="d-none d-md-block" data-aos="fade-down">
                            <img src="<?php the_field('testimonial_left_image',5); ?>"
                                alt="img" class="img-fluid">
                        </div>
                    </div>
                    <div class="col-md-8 col-12" data-aos="fade-top">

                        <div class="owl-carousel owl-theme client-slider">
                            <?php
                            // Query custom post type
                            $args = array(
                                'post_type' => 'testimonial',
                                'posts_per_page' => 4, // Display all posts, you can adjust as needed
                            );

                            $query = new WP_Query($args);

                            // Check if there are any posts
                            if ($query->have_posts()):
                                while ($query->have_posts()):
                                    $query->the_post();
                                    // Display your custom post type content here
                                    ?>

                               
                                        <div class="item">
                                            <div class="client-slider-inner">
                                                <img src="<?php echo get_template_directory_uri(); ?>/images/quote-img.png"
                                                    alt="quote" class="img-fluid quote">
                                                   <?php the_content(); ?> 
                                                <div class="d-flex align-items-center justify-content-center home_feedback">
                                                    <span>
                                                        <?php the_post_thumbnail(); ?>
                                                    </span>
                                                    <div class="ms-3">
                                                        <h6>
                                                      <?php the_title(); ?>
                                                        </h6>
                                                        <h6>
                                                            <?php echo the_field('designation'); ?>
                                                        </h6>
                                                        <p>
                                                        <img class="testimo-img"src=" <?php echo the_field('company_logo'); ?>">
                                                        </p>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                  
                                    <?php
                                endwhile;
                                // Restore original post data
                                wp_reset_postdata();
                            else:
                                // No posts found
                                echo 'No custom posts found.';
                            endif;
                            ?>


                        </div>
                    </div>
                </div>
                <div class="d-flex justify-content-center readm">

                <a href="/testimonials/"class="red-btn my-2 my-sm-4"><?php echo the_field('testimonials_button_text'); ?> </a>
                </div>
            </div>
          
        </div>
        <!-- <div class="feedback-inner">
                <div class="bgseeker">
                    <img class="w-100" src="images/Testimonial-Background.png" alt="Background">
                    <div class="pro_one">

                        <a href="#" data-bs-toggle="popover" data-bs-placement="right"
                            data-bs-content="Vivamus sagittis lacus vel augue laoreet rutrum faucibus. "><img
                                src="images/testimonial-images.png" alt="profile"></a>
                    </div>
                    <div class="pro_two">
                        <a href="#" data-bs-toggle="popover" data-bs-placement="top"
                            data-bs-content="Vivamus sagittis lacus vel augue laoreet rutrum faucibus. "><img
                                src="images/testimonial-image2.png" alt="profile"></a>
                    </div>
                    <div class="pro_three">
                        <a href="#" data-bs-toggle="popover" data-bs-placementt="right"
                            data-bs-content="Vivamus sagittis lacus vel augue laoreet rutrum faucibus. "><img
                                src="images/Testimonial-Images6.png" alt="profile"></a>
                    </div>
                    <div class="pro_four">
                        <a href="#" data-bs-toggle="popover" data-bs-placement="bottom"
                            data-bs-content="Vivamus sagittis lacus vel augue laoreet rutrum faucibus. "><img
                                src="images/testimonial-image3.png" alt="profile"></a>
                    </div>
                    <div class="pro_six">
                        <a href="#" data-bs-toggle="popover" data-bs-placement="left"
                            data-bs-content="Vivamus sagittis lacus vel augue laoreet rutrum faucibus. "><img
                                src="images/Testimonial-Image5.png" alt="profile"></a>
                    </div>
                </div>
            </div> -->
        </div>
    </section>
   
    <?php
    $show_blog_section = get_field('enable_disable',5);
    if($show_blog_section === 'Enable'): ?>

    <section class="blog">
        <div class="container c-container">
            <h3 class="section-title text-center mb-5">
                Our Latest <span class="d-inline"> Blog</span>
            </h3>
            <div class="blog-inner">
                <div class="row justify-content-center">
                    <?php  
                    $file_path = site_url().'/wp-content/uploads/2023/10/';
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
                    <div class="col-lg-4 col-md-6 col-12" data-aos="fade-top">
                        <div class="blog-box">
                            <a href="<?php echo get_permalink(); ?>">
                                <div class="blog-img position-relative">
                                    <img src="<?php echo get_the_post_thumbnail_url(); ?>" alt="blog-img"
                                        class="img-fluid">
                                    <span class="blog-date"> <?php echo esc_html( get_the_date() ); ?></span>
                                </div>
                                <div class="blog-text">
                                    <h5><?php the_title(); ?></h5>
                                    <p class="mt-2 "><?php
                                        $content = get_the_content();
                                        echo wp_trim_words( $content, 30, '...' );
                                        ?></p>
                                    <a href="<?php echo get_permalink(); ?>" class="readmore">Read More</a>
                                    <div class="d-flex justify-content-end blog-shape">
                                        <a href="<?php echo get_permalink(); ?>"><img src="<?= $file_path;?>blog-arrow.png"
                                                alt="arrow" class="img-fluid position-relative"></a>
                                    </div>
                                </div>
                            </a>
                        </div>
                    </div>
                    <?php endwhile; ?>
                
                </div>
                <div class="d-flex justify-content-center readm">
                <a href="/blog/"class="red-btn my-2 my-sm-4">Read more</a>
                </div>
            </div>
  
        </div>
    </section>

    <?php endif; ?>

    <section class="job-a-reality" data-aos="fade-down" data-aos-easing="linear" data-aos-duration="1500">
        <div class="container c-container">
            <div class="content-sec-inner text-center">
                <h4 class="section-title">
                    <?php echo the_field('ready_to_make_heading',5); ?>
                </h4>
                <p>
                    <?php echo the_field('ready_to_make_para',5); ?>
                </p>
                <div class="d-flex justify-content-center readm">
                    <a href="<?php echo the_field('free_services_url',5); ?>" class="red-btn my-2 my-sm-4">Free Services
                    </a>
                    <a href="<?php echo the_field('paid_services_url',5); ?>" class="red-btn my-2 my-sm-4 bg-black">Paid
                        Services</a>
                </div>
                <p>
                    <?php echo the_field('ready_to_make_2nd_para'); ?>
                </p>
            </div>
        </div>
    </section>
    <!-- <section class="new-cta">
        <div class="container c-container">
            <div class="content-sec-inner text-center">
                <h4 class="section-title">Ready to make the move get noticed by employers in the region? </h4>
                <div class="d-flex justify-content-center gap-3">
                    <a href="#" class="red-btn my-2 my-sm-4">Free Services </a>
                    <a href="#" class="red-btn my-2 my-sm-4 bg-black">Paid Services</a>
                </div>
            </div>
        </div>
    </section> -->
</main><!-- #main -->

<?php
get_sidebar();
get_footer();