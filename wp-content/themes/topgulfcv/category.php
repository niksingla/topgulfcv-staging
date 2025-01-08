<?php
/*
 * Template Name: Custom Category Template
 */
$file_path = site_url().'/wp-content/uploads/2023/10/';
get_header(); ?>

<div id="primary" class="content-area">
    <main id="main" class="site-main test121" role="main">
        <div class="container c-container">
            <div class="blog-inner">
                <div class="row justify-content-center" id="category-posts-container">
                    <?php
                    $category = get_queried_object();
                    $category_id = $category->term_id;
                    $paged = get_query_var('paged') ? get_query_var('paged') : 1;
                    $args = array(
                        'cat' => $category_id,
                        'paged' => $paged,
                        'orderby' => 'DESC',
                        'posts_per_page' => 1,
                    );
                    $query = new WP_Query($args);

                    if ($query->have_posts()) :
                        while ($query->have_posts()) : $query->the_post();
                            ?>
                            <div class="col-lg-4 col-md-6 col-sm-6 col-12 mb-3 mb-lg-5">
                                <div class="blog-box">
                                    <a href="<?php echo get_permalink(); ?>">
                                        <div class="blog-img position-relative">
                                            <img src="<?php echo get_the_post_thumbnail_url(); ?>" alt="blog-img"
                                                 class="img-fluid">
                                            <span class="blog-date"><?php echo esc_html(get_the_date()); ?> </span>
                                        </div>
                                        <div class="blog-text">
                                            <h5><?php the_title(); ?></h5>
                                            <p class="mt-2 "> <?php
                                                $content = get_the_content();
                                                echo wp_trim_words($content, 30, '...');
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
                        <?php endwhile;
                        wp_reset_postdata();
                    else :
                        echo 'No posts found.';
                    endif;
                    ?>
                </div>
                <div class="d-flex justify-content-center readm cat-btn mt-3">
                    <button id="load-more-posts" class="btn text-center btn-primary red-btn my-2 my-sm-4">Load More</button>
                </div>
            </div>
        </div>

    </main><!-- #main -->

</div><!-- #primary -->

<?php get_footer(); ?>

<script>
jQuery(function($) {
    var page = 1;
    var totalPages = <?php echo $query->max_num_pages; ?>;

    $('#load-more-posts').on('click', function() {
        page++;
        var data = {
            action: 'load_posts',
            page: page,
            category_id: '<?php echo $category_id; ?>',
            nonce: '<?php echo wp_create_nonce('load_more_posts_nonce'); ?>'
        };

        $.post('<?php echo admin_url('admin-ajax.php'); ?>', data, function(response) {
            $('#category-posts-container').append(response);
            if (page >= totalPages) {
                $('#load-more-posts').hide();
            }
        });
    });
    if (page >= totalPages) {
        $('#load-more-posts').hide();
    }
});

</script>
