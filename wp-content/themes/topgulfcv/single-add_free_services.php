<?php
get_header();
?>

<section class="content-section hyhy">
    <div class="container c-container">
        <div class="row align-items-center">
             <!-- Show form shortcode when ?form-popup is present -->
                <?php if (isset($_GET['form_fill'])): ?>
                <?php
                $form_shortcode = get_field('button_page');
                if ($form_shortcode) {
                    echo do_shortcode($form_shortcode);
                } else {
                    echo '<p>No form available.</p>';
                }
                ?>                
            <?php else: ?>
            <div class="col-lg-6 col-md-6 col-12">
                <div class="banner-left-sec" data-aos="fade-right">
                    <h2 class="section-title"><?php the_title(); ?></h2>
                    <p><?php the_content(); ?></p>
                </div>
            </div>
            <div class="col-lg-6 col-md-6 col-12 free_videobx" data-aos="fade-left">
                <div class="row">
                    <div class="ratio ratio-16x9 video_wraper">
                        <video playsinline autoplay muted loop preload="none" style="display:none;" class="lazy-video">
                            <source data-src="<?php the_field('banner_video'); ?>" type="video/mp4">
                        </video>                        
                    </div>
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
                        <h3 class="section-title"><?php the_field('second_heading'); ?></h3>
                        <p class="mt-2 mt-md-4"><?php the_field('second_content'); ?></p>
                        <button class="red-btn my-5 open-popup" onclick="window.location.href = window.location.href.split('?')[0] + '?form_fill';">
                            <?php the_field('button_name'); ?>
                        </button>
                    <?php endif; ?>
                </div>
            </div>
        </div>
    </div>
</section>

<script>
    // document.addEventListener('wpcf7mailsent', function(event) {
    //     sessionStorage.removeItem('openPopupId');
    //     document.cookie = "visited_success_page=true; path=/; max-age=" + (60 * 60 * 24 * 1); 
    //     $(location).attr('href', "<?php echo esc_url(get_field('success_page_link')); ?>");
    // })
    document.addEventListener("DOMContentLoaded", (event) => {
        document.querySelector('.hyhy form.wpcf7-form').action = "<?php echo esc_url(get_field('success_page_link')); ?>"
        document.cookie = "visited_success_page=true; path=/; max-age=" + (60 * 60 * 24 * 1); 
    });
    

</script>
<?php
get_footer();
?>
