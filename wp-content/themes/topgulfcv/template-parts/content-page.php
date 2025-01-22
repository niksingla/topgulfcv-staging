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
