<?php
/**
 * Template part for displaying page content in page.php
 *
 * @link https://developer.wordpress.org/themes/basics/template-hierarchy/
 *
 * @package Top_Gulf_CV
 */

?>

<div id="primary" class="content-area new-blog">
    <main id="main" class="site-main">
        <!-- banner section start -->
    <!-- <section class="about-sec about-secinner">
        <div class="container c-container">
            <div class="banner-inner">
                <div class="row align-items-center">
                    <div class="col-lg-6 col-12">
                        <div class="banner-left-sec">
                            <h2 class="section-title">
                                Your dream Job <span>Is Near to You</span>
                            </h2>
                            <p>Lorem ipsum dolor sit amet, consectetur adipiscing elit. Ut elit tellus,luctus
                                nec ullamcorper mattis, pulvinar dapibus leo.Lorem ipsum dolor sit amet,
                                consectetur adipiscing elit. Ut elit tellus,luctus nec ullamcorper mattis,
                                pulvinar dapibus leo.</span> </p>
                        </div>
                    </div>
                    <div class="col-lg-6 col-12">
                        <div class="banner-right-sec">
                            <img src="https://topgulfcv.com/wp-content/uploads/2024/02/content-img-1.png" alt="about-img" class="img-fluid">
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section> -->
    <!-- banner section end -->

    <section class="blog-detail">
        <!-- <div class="container text-center blog-head">
            <h3 class="section-title text-center ">
                Our Latest <span class="d-inline"> Blog</span>
            </h3>
            <p class="text-center mb-4 mb-md-5
            ">Lorem ipsum dolor sit amet consectetur, adipisicing elit. Minus sint necessitatibus quam eveniet veniam
                atque,</p>
        </div> -->
        <div class="container c-container">
            <div class="row">
                <div class="col-sm-12">
                    <div class="row">
                        <div class="col-sm-12">
                            <div class="detail-inner">
                            <?php if (has_category()) : ?>
                            <div class="cat-links btn btn-danger rounded-pill">
                              
                                <?php the_category(', '); ?>
                            </div>
                        <?php endif; ?>
                              </a>
                                <h4><?php the_title(); ?></h4>

                                <!-- <div class="jobImage">
                                    <div class="image-card">
                                        <img class="w-100" src="<?php echo get_the_post_thumbnail_url(); ?>" alt="Job">
                                    </div>
                                    <span class="dateTop"><?php echo esc_html( get_the_date() ); ?></span>
                                </div> -->
                                <p>
                                <?php the_content(); ?>
                            </p>
                                <!-- <div class="row detail-column">
                                    <div class="col-sm-12">
                                        <div class="row">
                                            <div class="col-sm-4">
                                                <div class="jobImage">
                                                    <div class="image-card">
                                                        <img class="w-100" src="https://topgulfcv.com/wp-content/uploads/2024/02/content-img-1.png" alt="Banner">
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-sm-4">
                                                <div class="jobImage">
                                                    <div class="image-card">
                                                        <img class="w-100" src="https://topgulfcv.com/wp-content/uploads/2024/02/content-img-1.png" alt="Banner">
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-sm-4">
                                                <div class="jobImage">
                                                    <div class="image-card">
                                                        <img class="w-100" src="https://topgulfcv.com/wp-content/uploads/2024/02/content-img-1.png" alt="Banner">
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div> -->
                            


                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
    </main>
</div>
