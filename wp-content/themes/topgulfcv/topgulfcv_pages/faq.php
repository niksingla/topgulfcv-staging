<?php 
/**
 * Template Name: FAQ
 *
 * */
get_header();
?>
<div id="primary" class="content-area">
    <main id="main" class="site-main">
        <div class="header_mail">
            <div class="sub-banner cont-banner"style="background-image: url(<?php the_field('banner_image'); ?>);">
            <div class="container" data-aos="fade-down">
                <div class="sub-banner-content">
                    <h1 class="section-title"><?php the_field('heading'); ?></h1>
                    </p>
                </div>
            </div>
            </div>
            <div class="container c-container">
                <div class="entry-content collapse_wraper">
                    <?php $i=1; if (have_rows('accordion')): ?>
                    <div class="accordion" id="accordionExample">
                        <?php while (have_rows('accordion')): the_row(); ?>
                        <div class="accordion-item">
                            <h2 class="accordion-header" id="heading<?php echo $i; ?>">
                                <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse"
                                    data-bs-target="#collapse<?php echo $i; ?>" aria-expanded="false"
                                    aria-controls="collapse<?php echo $i; ?>">
                                    <?php echo the_sub_field('title'); ?>
                                </button>
                            </h2>
                            <div id="collapse<?php echo $i; ?>" class="accordion-collapse collapse"
                                aria-labelledby="heading<?php echo $i; ?>" data-bs-parent="#accordionExample">
                                <div class="accordion-body">
                                    <p><?php echo the_sub_field('content'); ?></p>
                                </div>
                            </div>
                        </div>
                        <?php $i++; endwhile; ?>
                    </div>
                    <?php endif; ?>
                </div>
                <div class="row">
                    <div class="col-lg-6 col-md-6 col-sm-12">
                      <a href="<?php the_field('bottom_image_one_link'); ?>">  <img src="<?php the_field('bottom_image_one'); ?>" alt="" class="reportbott_img"></a>        
                    </div>
                    <div class="col-lg-6 col-md-6 col-sm-12">
                    <a href="<?php the_field('bottom_image_two_link'); ?>">  <img src="<?php the_field('bottom_image_two'); ?>" alt="" class="reportbott_img"> </a>
                    </div>
                </div>
            </div>
        </div>
    </main>
</div>



<?php get_footer();?>