<?php
/* Template Name: Thank You */
get_header();

?>

<div class="container c-container">
    <div class="row align-items-center">
        <div class="thankyou_wraper">
            <img src="<?php echo get_the_post_thumbnail_url(); ?>" alt="thankyou" class="img-fluid">
            <h1><?php the_field('thankyou_heading'); ?></h1>
            <p><?php echo the_content(); ?></p>
        </div>
    </div>
</div>





<?php get_footer(); ?>