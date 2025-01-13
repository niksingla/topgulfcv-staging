<?php
/**
 * The template for displaying the footer
 *
 * Contains the closing of the #content div and all content after.
 *
 * @link https://developer.wordpress.org/themes/basics/template-files/#template-partials
 *
 * @package Top_Gulf_CV
 */

?>
 
<div class="footer-top">
    <img src="<?php echo get_template_directory_uri(); ?>/images/footer-top.png" alt="footer-top" class="img-fluid">
</div>

<div class="cart_wraper">
    <div class="content_wraper">
        <h1>Cart <span class="closeall">X</span></h1>

        <div class="cart_wraperbx" id="cartItems">
            <!-- Cart items will be dynamically added here -->
        </div>
        <p>Once you're ready, please click on 'Checkout' below to proceed to the payment options.</p>

        <div class="total_bx">
            <h5>Total <span class="amount_bx" id="totalAmount"><?= get_woocommerce_currency_symbol();?> 0.00</span></h5>

            <div class="new">
                <form>
                    <!-- <div class="form-check">
      <input type="checkbox" id="html">
      <label for="html">Click here to agree to our <a href="">terms & conditions.</a></label>
    </div> -->

                    <a href="/signup" class="check_button">Checkout</a>
                </form>
            </div>

        </div>
    </div>
</div>
<footer>
    <div class="container c-container">
        <div class="footer-main">
            <div class="row">
                <div class="col-xl-2 col-lg-4 col-md-4 col-sm-6 col-12">
                    <div class="d-block text-center text-lg-start mb-4 mb-lg-0">
                    <?php if(is_active_sidebar('footerone')) :?>
                            <?php  dynamic_sidebar('footerone');?>
                                            <?php endif; ?>

                    </div>

                </div>
                <div class="col-xl-2 col-lg-4 col-md-4 col-sm-12 col-12">
                    <div class="footer-links footer-m-links">
                    <?php if(is_active_sidebar('footertwo')) :?>
                            <?php  dynamic_sidebar('footertwo');?>
                                            <?php endif; ?>
                    </div>
                </div>
                <div class="col-xl-2 col-lg-4 col-md-4 col-sm-6 col-12">
                    <div class="footer-links footer-m-links">
                    <?php if(is_active_sidebar('footerthree')) :?>
                            <?php  dynamic_sidebar('footerthree');?>
                                            <?php endif; ?>
                    </div>
                </div>
                <div class="col-xl-3 col-lg-6 col-md-6 col-sm-6 col-12">
                    <div class="footer-links contact-us">
                    <?php if(is_active_sidebar('footerfour')) :?>
                            <?php  dynamic_sidebar('footerfour');?>
                                            <?php endif; ?>
                    </div>
                </div>
                <div class="col-xl-3 col-lg-6 col-md-6 col-sm-6 col-12">
                <?php if(is_active_sidebar('footerfive')) :?>
                            <?php  dynamic_sidebar('footerfive');?>
                                            <?php endif; ?>
                                            <?php
                        $show_social_section = get_field('enable_disable_social',5);
                        if($show_social_section === 'Enable'): ?>
                         <div class="f-social-media align-items-center justify-content-center justify-content-lg-start">
                         <?php if( have_rows('social_icon',5) ):
         while( have_rows('social_icon',5) ) : the_row(); ?>
                            <a href="<?php echo the_sub_field('social_link',5); ?>">
                                <img src="<?php echo the_sub_field('social_logo',5); ?>" alt="linkdin icon" class="img-fluid" />
                            </a>
                            <?php endwhile; endif;?>
                        </div>
                        <?php endif; ?>
                </div>

            </div>
        </div>
        <div class="login-footer">
            <ul>
                <li><?php if(is_active_sidebar('footerbotom')) :?>
                            <?php  dynamic_sidebar('footerbotom');?>
                                            <?php endif; ?></li>
            </ul>
        </div>
    </div>
</footer>
<script src="https://cdn.rawgit.com/michalsnik/aos/2.0.4/dist/aos.js"></script>
<script src="https://unpkg.com/aos@next/dist/aos.js"></script>


<script type="text/javascript">
    AOS.init({
        duration: 2000
    });    
</script>
<script type="text/javascript">
    jQuery(document).ready(function() {
        let isCartBarOpen = false
        function isMobile() {
            return window.innerWidth <= 768; // Adjust the breakpoint as needed
        }

        jQuery("#open-call").on("click", function(e) {
            e.preventDefault();
            if(!isCartBarOpen){
                if (isMobile()) {
                    jQuery(".cart_wraper").animate({
                        height: "toggle"
                    }, 700);
                } else {
                    jQuery(".cart_wraper").animate({
                        width: "toggle"
                    }, 700);
                }
                // jQuery("#open-call").toggleClass("opened closed");
                isCartBarOpen = true
            } else {
                isCartBarOpen = false
            }
        });
        jQuery(".add-to-cart-btn").on("click", function(e) {
            e.preventDefault();            
            
            if(!isCartBarOpen){
                if (isMobile()) {
                    jQuery(".cart_wraper").animate({
                        height: "toggle"
                    }, 700);
                } else {
                    jQuery(".cart_wraper").animate({
                        width: "toggle"
                    }, 700);
                }
                isCartBarOpen = true
                // jQuery(".add-to-cart-btn").toggleClass("opened closed");         
            }
        });

        jQuery(".closeall").click(function() {
            if (isMobile()) {
                jQuery(".cart_wraper").hide({
                    height: "toggle"
                }, 700);
            } else {
                jQuery(".cart_wraper").hide({
                    width: "toggle"
                }, 700);
            }
            isCartBarOpen = false
        });
    });
</script>


<script>
    jQuery(document).ready(function() {
        jQuery('[data-bs-toggle="popover"]').popover({
            trigger: 'hover',
            html: true,
        })
    });
</script>

<script type="text/javascript">
    var owl = jQuery('.owlcrousel_one');    
    if(owl.length){
        owl.owlCarousel({
            items: 5,
            loop: true,
            margin: 10,
            autoplay: true,
            autoplayTimeout: 3000,
            responsive: {
                0: {
                    items: 1
                },
                600: {
                    items: 2
                },
                1000: {
                    items: 5
                }
            }
    
        });
    }

    var owl = jQuery('.owlcrousel_two');
    if(owl.length){
        owl.owlCarousel({
            items: 1,
            loop: true,
            margin: 10,
            autoplay: true,
            autoplayTimeout: 15000,
            responsive: {
                0: {
                    items: 1
                },
                600: {
                    items: 1
                },
                1000: {
                    items: 1
                }
            }
    
        });
    }

    jQuery(document).ready(function() {
        var owl = jQuery('.owlcrousel_three');
        if(owl.length){
            owl.owlCarousel({
                items: 1,
                loop: true,
                margin: 10,
                autoplay: true,
                autoplayTimeout: 9000,
                responsive: {
                    0: {
                        items: 1
                    },
                    600: {
                        items: 1
                    },
                    1000: {
                        items: 1
                    }
                }
            
            });
        }
    })
</script>

<script type="text/javascript">
    jQuery(window).on('load', function () {
        const $video = $('.lazy-video');
        setTimeout(() => {               
            $video.attr('src',$video.find('source').data('src'))
            $video.fadeIn(); 
            for (let index = 0; index < $video.length; index++) {
                const element = $video[index];
                element.play();
            }
        }, 0);
    });
</script>

<?php 
wp_footer(); 
?>
</body>

</html>
