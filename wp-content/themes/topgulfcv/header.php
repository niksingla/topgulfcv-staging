<?php
/**
 * The header for our theme
 *
 * This is the template that displays all of the <head> section and everything up until <div id="content">
 *
 * @link https://developer.wordpress.org/themes/basics/template-files/#template-partials
 *
 * @package Top_Gulf_CV
 */

?>
<!doctype html>
<html <?php language_attributes(); ?>>
<head>
	<meta charset="<?php bloginfo( 'charset' ); ?>">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<!-- <link rel="profile" href="https://gmpg.org/xfn/11"> -->
    <link rel="stylesheet" href="https://cdn.rawgit.com/michalsnik/aos/2.0.4/dist/aos.css" />
    <link rel="stylesheet" href="https://unpkg.com/aos@next/dist/aos.css" />
    
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css" />
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/@fortawesome/fontawesome-free@6.4.2/css/fontawesome.min.css" />
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css" />
    <link rel="stylesheet" type="text/css" href="https://cdnjs.cloudflare.com/ajax/libs/animate.css/3.7.0/animate.min.css"/>    
	<?php wp_head(); ?>
</head>

<body <?php body_class(); ?>>
<!-- <script src="https://cdnjs.cloudflare.com/ajax/libs/lazysizes/5.3.2/lazysizes.min.js" async=""></script> -->
<script type="module">document.addEventListener("touchstart", function(){});</script>

<?php wp_body_open(); ?>
<div id="page" class="site">
	<a class="skip-link screen-reader-text" href="#primary"><?php esc_html_e( 'Skip to content', 'topgulfcv' ); ?></a>
	<!-- header start -->
    <header <?php $page_id = get_the_ID(); if (!is_front_page() && !is_singular('testimonial') && !is_post_type_archive('testimonial') && $page_id !== 1901 && $page_id !== 1479 && $page_id !== 1695 && $page_id !== 132) { echo 'class="innerpages"'; } ?>>
        
                    <?php
                $slider_args = array(
                    'post_type'      => 'slider', 
                    'posts_per_page' => -1,       
                    'post_status'    => 'publish', 
                );
                $slider_query = new WP_Query($slider_args);
                if ($slider_query->have_posts()) :
                    ?>
                    <div class="offer_wraper">
                        <div class="owl-carousel owl-theme owlcrousel_three">
                            <?php
                            while ($slider_query->have_posts()) : $slider_query->the_post();
                                $enable_slider = get_post_meta(get_the_ID(), '_enable_slider', true);

                                if ($enable_slider) :
                                    ?>
                                    <div class="item">
                                        <div class="banner-text responsive-size">
                                            <?php the_content(); ?>
                                        </div>
                                    </div>
                                    <?php
                                endif;
                            endwhile;
                            ?>
                        </div>
                    </div>
                    <?php
                    wp_reset_postdata();
                else :
                    
                endif;
                ?>
        <nav class="navbar navbar-expand-lg">
            <div class="container c-container">
            <a href="<?php echo esc_url(home_url('/')); ?>" class="navbar-brand">
            <?php 
            if (function_exists('the_custom_logo')) {
                $custom_logo_id = get_theme_mod('custom_logo');
                $logo = wp_get_attachment_image_src($custom_logo_id, 'full');
                if (has_custom_logo()) {
                    echo '<img src="' . esc_url($logo[0]) . '" alt="' . get_bloginfo('name') . '" class="img-fluid" />';
                } 
            }
            ?>
            </a>

                <div class="d-flex justify-content-end flex-lg-row-reverse align-items-center">
                    <li class="menu-item cart-icon">
            <a href="<?php echo wc_get_cart_url(); ?>" class="cart-contents" id="open-call">
            <i class="fa-solid fa-cart-shopping"></i>
                <span class="cart-count"><?php echo WC()->cart->get_cart_contents_count(); ?></span>
            </a>
             </li>
                        

            <button class="navbar-toggler" type="button" data-bs-toggle="offcanvas"
                    data-bs-target="#navbarOffcanvas" aria-controls="navbarOffcanvas" aria-expanded="false"
                    aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="offcanvas offcanvas-top" id="navbarOffcanvas" tabindex="-1"
                aria-labelledby="offcanvasNavbarLabel" style=" height: 100%;">
                <div class="offcanvas-header">
                    <button type="button" class="btn-close btn-close-black text-reset"
                        data-bs-dismiss="offcanvas" aria-label="Close"></button>
                </div>
                <div class="offcanvas-body">
                    <div class="navbar-nav justify-content-end flex-grow-1 pe-xl-3">
                        <?php
                        $defaults = array(
                            'menu_class' => '',
                            'menu' => 'Primary_Menu'
                        );
                        wp_nav_menu($defaults);
                        ?>
                        <?php if (is_user_logged_in()) { ?>
                            <a href="<?= wp_logout_url('/home') ?>" class="red-btn logout-btn">
                                <?= wp_get_current_user()->first_name; ?>, Logout?
                            </a>
                        <?php } ?>
                    </div>
                </div>
            </div>

                </div>
            </div>
        </nav>
    </header>
    <!-- header end -->
</div>