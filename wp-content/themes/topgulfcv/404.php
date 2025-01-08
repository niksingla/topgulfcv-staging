<?php
/**
 * The template for displaying 404 pages (not found)
 *
 * @link https://codex.wordpress.org/Creating_an_Error_404_Page
 *
 * @package Top_Gulf_CV
 */

get_header();
?>

	<main id="primary" class="site-main">

		<section class="error-404 not-found">
			<div class="container con-404 vh-100 d-flex justify-content-center">
				<div class="row justify-content-md-center d-block">
					<div class="col-md-12 mt-5">
						<img src="<?= site_url().'/wp-content/uploads/2023/10/'?>404.svg" class="img-fluid img-404 mx-auto d-block">
					</div>
					<div class="col-md-12 text-center error-page-404">
						<h2>Opps! Something's missing...</h2>
						<p class="not-found-subtitle">The page you are looking for doesn't exists / isn't available / was
							loading
							incorrectly.</p>
						<a class="btn btn-primary back-btn mt-3" style="background-color:var(--red); border-color:var(--red);"
							href="<?= site_url();?>">Back to Home Page</a>
					</div>
				</div>
			</div>
		</section><!-- .error-404 -->

	</main><!-- #main -->

<?php
get_footer();
