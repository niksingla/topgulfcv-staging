<?php
/**
 * Template Name: Single post
 */
get_header();
?>

<div id="primary" class="content-area new-blog">
    <main id="main" class="site-main">

    <section class="blog-detail">
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
                                <p>By, <?php the_author(); ?></p>

                                <div class="jobImage">
                                    <div class="image-card">
                                        <img class="w-100" src="<?php echo get_the_post_thumbnail_url(); ?>" alt="Job">
                                    </div>
                                    <span class="dateTop"><?php echo esc_html( get_the_date() ); ?></span>
                                </div>
                                <p>
                                <?php the_content(); ?>
                            </p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
    </main>
</div>

<?php get_footer();?>