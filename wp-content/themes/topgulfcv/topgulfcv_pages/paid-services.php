<?php
/*
* Template Name: paid services
*
*
*/
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
                            <?php the_field('banner_heading'); ?>
                        </h2>
                        <p><?php the_field('banner_paragraph'); ?></span> </p>
                    </div>
                </div>
                <div class="col-lg-6 col-md-6 col-12">
                    <div class="banner-right-sec" data-aos="fade-left">
                        <!-- <img src="<?php echo get_template_directory_uri(); ?>/images/about-img-1.png" alt="about-img" class="img-fluid"> -->
                        <div class="ratio ratio-16x9">
                            <video playsinline autoplay muted loop preload="none" style="display:none;" class="lazy-video">
                                  <source data-src="<?php the_field('banner_video'); ?>" type="video/mp4">
                            </video> 
                        </div>
                    </div>
                </div>
            </div>
            <!-- <div class="row">
                    <div class="col-lg-6">
                        <div class="item" data-aos="fade-down">fade-down</div>
                        <div class="item" data-aos="fade-right">fade-right</div>

                    </div>
                    <div class="col-lg-6">
                        <div class="item" data-aos="fade-left">fade-left</div>
                    </div>
                </div> -->

        </div>
    </section>
    <!-- banner section end -->
    <section class="content-section pb-5">
        <div class="container c-container">
            <div class="job-section pb-0 paid-service">
                <h2 class="section-title text-center"><span>Paid Services</span></h2>
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
    </section>
    <?php //$product = get_product(492);
                            //echo "<a href='" . $product->add_to_cart_url() ."'>add to cart</a>"; ?> -->

</main><!-- #main -->


<?php
get_sidebar();
get_footer();