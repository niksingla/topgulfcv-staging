<?php
/**
 * The template for displaying all pages
 *
 * This is the template that displays all pages by default.
 * Please note that this is the WordPress construct of pages
 * and that other 'pages' on your WordPress site may use a
 * different template.
 *
 * @link https://developer.wordpress.org/themes/basics/template-hierarchy/
 *
 * @package Top_Gulf_CV
 */

 global $post;
	if(is_front_page()){
		get_template_part( 'topgulfcv_pages/home');
	}
	else if( home_url($wp->request) === home_url('signup') ){
		get_template_part( 'topgulfcv_pages/signup');
	}
	else if( home_url($wp->request) === home_url('about') ){
		get_template_part( 'topgulfcv_pages/about');
	}
	else if( home_url($wp->request) === home_url('blog') ){
		get_template_part( 'topgulfcv_pages/blog');
	}
	else if( home_url($wp->request) === home_url('upload-cv') ){
		get_template_part( 'topgulfcv_pages/upload-cv');
	}
	else if( home_url($wp->request) === home_url('signin') ){
		get_template_part( 'topgulfcv_pages/signin');
	}
	else if( home_url($wp->request) === home_url('contact-us') ){
		get_template_part( 'topgulfcv_pages/contact-us');
	}
	else if( home_url($wp->request) === home_url('paid-services') ){
		get_template_part( 'topgulfcv_pages/paid-services');
	}
	else if( home_url($wp->request) === home_url('free-services') ){
		get_template_part( 'topgulfcv_pages/free-services');
	}
	else{
		get_header();
		?>

			<main id="primary" class="site-main">

				<?php
				while ( have_posts() ) :
					the_post();

					get_template_part( 'template-parts/content', 'page' );

					// If comments are open or we have at least one comment, load up the comment template.
					if ( comments_open() || get_comments_number() ) :
						comments_template();
					endif;

				endwhile; // End of the loop.
				?>

			</main><!-- #main -->

		<?php
		get_sidebar();
		get_footer();
	}