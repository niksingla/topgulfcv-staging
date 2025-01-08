<?php
/*
* Template Name: paid services details
*
*
*/
get_header();
?>
 <section class="content-section paid-services-details-page">
        <div class="container c-container">
            
                <div class="row align-items-center">
                    <div class="col-lg-6 col-md-6 col-12">
                        <div class="banner-left-sec" data-aos="fade-right">
                            <h2 class="section-title">
                            <?php echo the_title(); // This displays the product title ?>
                            </h2>
                            <p>     <?php
                        global $product;
                        echo $product->get_description(); // This displays the product description
                        ?></span> </p>
                               
                        </div> 
                    </div>
                    <div class="col-lg-6 col-md-6 col-12" data-aos="fade-left">
                        <!-- <div class="banner-right-sec img-round" data-aos="fade-left">
                            <img src="<?php the_post_thumbnail_url(); ?>" alt="about-img" class="img-fluid">
                        </div> -->
                        <div class="ratio ratio-16x9 video_wraper">
                            <video playsinline autoplay muted loop preload="none" style="display:none;" class="lazy-video">
                                <source data-src="<?php the_field('banner_video'); ?>" type="video/mp4">
                            </video>  
                          
                            </div>
                    </div>
                </div>
            
        </div>
    </section> 
    <!-- banner section end -->
    <section class="content-section listdetails">
        <div class="container c-container">
            <div class="row align-items-center flex-row-reverse" data-aos="fade-down">

                <div class="col-lg-12 col-md-12 col-12">
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

                        <?php
                    global $product;
                    if ($product) {
                        $product_id = $product->get_id();
                        $add_to_cart_url = esc_url( wc_get_cart_url() ); // URL to redirect after adding to cart
                    }
                    ?>

                    <a href="#" class="red-btn my-2 my-sm-4 add-to-cart-btn" id="add-to-cart-and-redirect" data-product-id="<?php echo esc_attr($product_id); ?>">
                        <?php the_field('yalla_letsgo'); ?>
                    </a>

                    <!-- <script>
                        document.addEventListener('DOMContentLoaded', function () {
                            document.getElementById('add-to-cart-and-redirect').addEventListener('click', function(e) {
                                e.preventDefault();
        
                                var productId = this.getAttribute('data-product-id');
                                addToWooCommerceCart(productId)                            
                                // AJAX request to add product to cart
                                var xhr = new XMLHttpRequest();
                                xhr.open('POST', wc_add_to_cart_params.ajax_url, true);
                                xhr.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded');
        
                                xhr.onload = function() {
                                    if (xhr.status >= 200 && xhr.status < 400) {
                                        // Redirect to cart page
                                        window.location.href = '<?php echo esc_url($add_to_cart_url); ?>';
                                    }
                                };
        
                                xhr.send('action=woocommerce_add_to_cart&product_id=' + productId);
                            });
                        })
                    </script> -->
                    </div>
                </div>
                
            </div>
        </div>
    </section>

<?php get_footer();?>
