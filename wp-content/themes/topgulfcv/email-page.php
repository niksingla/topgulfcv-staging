<?php
/*
Template Name: Email Page
*/

get_header();
?>

<div id="primary" class="content-area">
    <main id="main" class="site-main">

        <article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
            <br><br><br>
            <div class="entry-content mail_wraper" style="text-align: center;">

                <?php
                $userId = isset($_GET['userId']) ? intval($_GET['userId']) : 0;
                $title = isset($_GET['title']) ? urldecode($_GET['title']) : '';
                $description = isset($_GET['description']) ? urldecode($_GET['description']) : '';
                $token = isset($_GET['token']) ? $_GET['token'] : '';
                $expires = isset($_GET['expires']) ? intval($_GET['expires']) : 0;

                if ($userId > 0 && $title !== '' && $description !== '' && $token !== '' && $expires > time()) {
                    echo "<h1>{$title}</h1>";
                    echo "<p>{$description}</p>";

                    // Check if the file is uploaded
                    // if (isset($_FILES['file']) && $_FILES['file']['error'] === UPLOAD_ERR_OK) {
                    //     $upload_dir = wp_upload_dir();
                    //     $file_name = $_FILES['file']['name'];
                    //     $file_url = $upload_dir['baseurl'] . '/' . $file_name;
                    //     echo "<p>Download your file: <a href='{$file_url}' target='_blank'>{$file_name}</a></p>";
                    // } else {
                    //     echo "<p>No file uploaded.</p>";
                    // }

                } else {

                    echo "Error: Invalid or expired link.";
                } ?>

            </div>

        </article><!-- #post-<?php the_ID(); ?> -->

    </main>
</div>

<?php
get_footer();
?>
