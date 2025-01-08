<?php
/*
Template Name: paid-services-email-template
*/ 
?>
<!doctype html>
<html <?php language_attributes(); ?>>

<head>
    <meta charset="<?php bloginfo( 'charset' ); ?>">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="profile" href="https://gmpg.org/xfn/11">
    <link rel="stylesheet" href="https://cdn.rawgit.com/michalsnik/aos/2.0.4/dist/aos.css" />
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css" />
    <link rel="stylesheet"
        href="https://cdn.jsdelivr.net/npm/@fortawesome/fontawesome-free@6.4.2/css/fontawesome.min.css" />
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css" />
    <link rel="stylesheet" type="text/css"
        href="https://cdnjs.cloudflare.com/ajax/libs/animate.css/3.7.0/animate.min.css" />
    <script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/3.7.0/chart.min.js"></script>
    <?php wp_head(); ?>
</head>

<body <?php body_class(); ?>>
    <?php 
$cvid = isset($_GET['cvID']) ? $_GET['cvID'] : '';
$token = isset($_GET['token']) ? $_GET['token'] : '';
$expires = isset($_GET['expires']) ? $_GET['expires'] : '';

$expiration_timestamp = get_post_meta($cvid, 'expiration_timestamp', true);
$current_time = time();
$is_admin = current_user_can('administrator');
if ($current_time > $expiration_timestamp && !$is_admin) { ?>
    <div class="header_mail">
        <div class="container c-container">
            <a href="<?php echo esc_url(home_url('/')); ?>" class="navbar-brand">
                <?php 
                    if (function_exists('the_custom_logo')) {
                        $custom_logo_id = get_theme_mod('custom_logo');
                        $logo = wp_get_attachment_image_src($custom_logo_id, 'full');
                        if (has_custom_logo()) {
                            echo '<img src="' . esc_url($logo[0]) . '" alt="' . get_bloginfo('name') . '" class="img-fluid report-logo" />';
                        } 
                    }
                    ?>
            </a>
        </div>
    </div>
    <div class="container c-container">
        <div class="row">
            <div class="col-sm-12">
                <h2 class="report-expired"><?php  the_field('report_expired_text'); ?></h2>
            </div>
        </div>
    </div>
    </div>
    <div class="container c-container">
        <div class="row" style="margin-top: 20px;">
            <div class="col-lg-6 col-md-6 col-sm-12">
                <a href="<?php the_field('bottom_image_one_link'); ?>"> <img
                        src="<?php the_field('footer_image_one'); ?>" alt="" class="reportbott_img"></a>
            </div>
            <div class="col-lg-6 col-md-6 col-sm-12">
                <a href="<?php the_field('bottom_image_two_link'); ?>"> <img
                        src="<?php the_field('footer_image_two'); ?>" alt="" class="reportbott_img"> </a>
            </div>
        </div>
    </div>
    <?php
}
 else {
    $introduction = get_post_meta($cvid, "introduction", true);
    $summary = get_post_meta($cvid, "summary", true);
    $profile_summary = get_post_meta($cvid, "full_name", true);
    $current = get_post_meta($cvid, "current", true);
    $past = get_post_meta($cvid, "past", true);
    $education = get_post_meta($cvid, "education", true);
    $picture = get_post_meta($cvid, "picture", true);
    $layout = get_post_meta($cvid, "layout", true);
    $content_length = get_post_meta($cvid, "content_length", true);
    $spelling_grammer = get_post_meta($cvid, "spelling_grammer", true);
    $font_constent = get_post_meta($cvid, "font_constent", true);
    $keyword = get_post_meta($cvid, "keyword", true);
    $bullet_details = get_post_meta($cvid, "bullet_details", true);
    $concolustion= get_post_meta($cvid, "concolustion", true);
    $keyword1 = get_post_meta($cvid, "keyword1", true);
    $value1 = get_post_meta($cvid, "value1", true);
?>

    <div id="primary" class="content-area">
        <main id="main" class="site-main">
            <article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
                <div class="header_mail">
                    <div class="container c-container">
                        <a href="<?php echo esc_url(home_url('/')); ?>" class="navbar-brand">
                            <?php 
                    if (function_exists('the_custom_logo')) {
                        $custom_logo_id = get_theme_mod('custom_logo');
                        $logo = wp_get_attachment_image_src($custom_logo_id, 'full');
                        if (has_custom_logo()) {
                            echo '<img src="' . esc_url($logo[0]) . '" alt="' . get_bloginfo('name') . '" class="img-fluid report-logo" />';
                        } 
                    }
                    ?>
                        </a>
                    </div>
                </div>

                <div class="container c-container">
                    <div class="sumary_box">
                        <h2>Introduction:</h2>
                        <p><?php echo wpautop($introduction); ?></p>
                    </div>
                    <div class="sumary_box">
                        <h2>Summary:</h2>
                        <p><?php echo wpautop($summary); ?></p>
                    </div>
                    <div class="profile_wraper">
                        <ul class="leftprofile_bx">
                            <li>
                                <div class="left_wraperprof">
                                    <?php
                                $featured_image_url = get_post_meta($cvid, 'cv_report_image', true);
                                if ($featured_image_url) {
                                    echo '<img src="' . esc_url($featured_image_url) . '" alt="' . esc_attr(get_the_title()) . '">';
                                } else {
                                    echo '<img src="/wp-content/uploads/2024/03/download-11.jpg">'; 
                                }
                                ?>
                                </div>
                            </li>
                        </ul>
                        <ul>
                            <li>
                                <div class="right_wraperprof info_box">
                                    <h4>Name</h4>
                                    <div class="content_wrap">
                                        <p><?php echo wpautop($profile_summary); ?></p>
                                    </div>
                                </div>
                            </li>
                            <li>
                                <div class="right_wraperprof info_box">
                                    <h4>Current</h4>
                                    <div class="content_wrap">
                                        <p><?php echo wpautop($current); ?></p>
                                    </div>
                                </div>
                            </li>
                            <li>
                                <div class="right_wraperprof info_box">
                                    <h4>Past</h4>
                                    <div class="content_wrap">
                                        <p><?php echo wpautop($past); ?></p>
                                    </div>
                                </div>
                            </li>
                            <li>
                                <div class="right_wraperprof info_box">
                                    <h4>Education</h4>
                                    <div class="content_wrap">
                                        <p><?php echo wpautop($education); ?></p>
                                    </div>
                                </div>
                            </li>
                        </ul>
                    </div>

                    <div class="entry-content collapse_wraper">
                        <div class="accordion" id="accordionExample">
                            <div class="accordion-item">
                                <h2 class="accordion-header" id="headingTwo">
                                    <button class="accordion-button" type="button" data-bs-toggle="collapse"
                                        data-bs-target="#collapseTwo" aria-expanded="false" aria-controls="collapseTwo">
                                        Picture, Images Logos & Icons:
                                    </button>
                                </h2>
                                <div id="collapseTwo" class="accordion-collapse collapse show"
                                    aria-labelledby="headingTwo" data-bs-parent="#accordionExample">
                                    <div class="accordion-body">
                                        <p><?php echo wpautop($picture); ?></p>
                                    </div>
                                </div>
                            </div>
                            <div class="accordion-item">
                                <h2 class="accordion-header" id="headingThree">
                                    <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse"
                                        data-bs-target="#collapseThree" aria-expanded="false"
                                        aria-controls="collapseThree">
                                        Layout, Design, Structure & Format:
                                    </button>
                                </h2>
                                <div id="collapseThree" class="accordion-collapse collapse "
                                    aria-labelledby="headingThree" data-bs-parent="#accordionExample">
                                    <div class="accordion-body">
                                        <p><?php echo wpautop($layout); ?></p>
                                    </div>
                                </div>
                            </div>
                            <div class="accordion-item">
                                <h2 class="accordion-header" id="headingfor">
                                    <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse"
                                        data-bs-target="#collapsefor" aria-expanded="false" aria-controls="collapsefor">
                                        Content, Length & Size:
                                    </button>
                                </h2>
                                <div id="collapsefor" class="accordion-collapse collapse " aria-labelledby="headingfor"
                                    data-bs-parent="#accordionExample">
                                    <div class="accordion-body">
                                        <p><?php echo wpautop($content_length); ?></p>
                                    </div>
                                </div>
                            </div>
                            <div class="accordion-item">
                                <h2 class="accordion-header" id="headingfive">
                                    <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse"
                                        data-bs-target="#collapsefive" aria-expanded="false"
                                        aria-controls="collapsefive">
                                        Spelling & Grammar:
                                    </button>
                                </h2>
                                <div id="collapsefive" class="accordion-collapse collapse "
                                    aria-labelledby="headingfive" data-bs-parent="#accordionExample">
                                    <div class="accordion-body">
                                        <p><?php echo wpautop($spelling_grammer); ?></p>
                                    </div>
                                </div>
                            </div>
                            <div class="accordion-item">
                                <h2 class="accordion-header" id="headingsix">
                                    <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse"
                                        data-bs-target="#collapsesix" aria-expanded="false" aria-controls="collapsesix">
                                        Font, Consistency & Chronology:
                                    </button>
                                </h2>
                                <div id="collapsesix" class="accordion-collapse collapse " aria-labelledby="headingsix"
                                    data-bs-parent="#accordionExample">
                                    <div class="accordion-body">
                                        <p><?php echo wpautop($font_constent); ?></p>
                                    </div>
                                </div>
                            </div>
                            <div class="accordion-item">
                                <h2 class="accordion-header" id="headingseven">
                                    <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse"
                                        data-bs-target="#collapseseven" aria-expanded="false"
                                        aria-controls="collapseseven">
                                        Keywords:
                                    </button>
                                </h2>
                                <div id="collapseseven" class="accordion-collapse collapse "
                                    aria-labelledby="headingseven" data-bs-parent="#accordionExample">
                                    <div class="accordion-body">
                                        <p><?php echo $keyword; ?></p>
                                    </div>
                                    <div class="canvas-inner"> </div>
                                    <canvas id="myChart" width="400" height="200"></canvas>
                                    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
                                    <script>
                                    document.addEventListener("DOMContentLoaded", function() {
                                        var urlParams = new URLSearchParams(window.location.search);
                                        var keyword1Array = urlParams.getAll('keyword1[]');
                                        var value1Array = urlParams.getAll('value1[]');
                                        var additionalKeyword1Array =
                                            <?php echo json_encode(get_post_meta($cvid, 'all_keyword1_values', true)); ?>;
                                        var additionalValue1Array =
                                            <?php echo json_encode(get_post_meta($cvid, 'all_value1_values', true)); ?>;
                                        keyword1Array = keyword1Array.concat(additionalKeyword1Array);
                                        value1Array = value1Array.concat(additionalValue1Array);
                                        var ctx = document.getElementById('myChart').getContext('2d');
                                        var myChart = new Chart(ctx, {
                                            type: 'bar',
                                            data: {
                                                labels: keyword1Array,
                                                datasets: [{
                                                    label: '',
                                                    data: value1Array,
                                                    backgroundColor: [
                                                        'rgba(255, 99, 132, 0.2)',
                                                        'rgba(54, 162, 235, 0.2)',
                                                        'rgba(255, 206, 86, 0.2)',
                                                        'rgba(75, 192, 192, 0.2)',
                                                        'rgba(153, 102, 255, 0.2)',
                                                        'rgba(255, 99, 132, 0.2)',
                                                    ],
                                                    borderColor: [
                                                        'rgba(255, 99, 132, 1)',
                                                        'rgba(54, 162, 235, 1)',
                                                        'rgba(255, 206, 86, 1)',
                                                        'rgba(75, 192, 192, 1)',
                                                        'rgba(153, 102, 255, 1)',
                                                        'rgba(255, 99, 132, 1)',
                                                    ],
                                                    borderWidth: 1
                                                }]
                                            },
                                            options: {
                                                scales: {
                                                    yAxes: [{
                                                        ticks: {
                                                            beginAtZero: true
                                                        }
                                                    }]
                                                }
                                            }
                                        });
                                    });
                                    </script>
                                </div>
                            </div>
                            <div class="accordion-item">
                                <h2 class="accordion-header" id="headingeight">
                                    <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse"
                                        data-bs-target="#collapseeight" aria-expanded="false"
                                        aria-controls="collapseeight">
                                        Bullets & Detail:
                                    </button>
                                </h2>
                                <div id="collapseeight" class="accordion-collapse collapse "
                                    aria-labelledby="headingeight" data-bs-parent="#accordionExample">
                                    <div class="accordion-body">
                                        <p><?php echo wpautop($bullet_details); ?></p>
                                    </div>
                                </div>
                            </div>
                            <div class="accordion-item">
                                <h2 class="accordion-header" id="headingnine">
                                    <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse"
                                        data-bs-target="#collapsenine" aria-expanded="false"
                                        aria-controls="collapsenine">
                                        Conclusion (Recommendation & Next Steps):
                                    </button>
                                </h2>
                                <div id="collapsenine" class="accordion-collapse collapse "
                                    aria-labelledby="headingnine" data-bs-parent="#accordionExample">
                                    <div class="accordion-body">
                                        <p><?php echo wpautop($concolustion); ?></p>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-lg-6 col-md-6 col-sm-12">
                            <a href="<?php the_field('bottom_image_one_link'); ?>"> <img
                                    src="<?php the_field('footer_image_one'); ?>" alt="" class="reportbott_img"></a>
                        </div>
                        <div class="col-lg-6 col-md-6 col-sm-12">
                            <a href="<?php the_field('bottom_image_two_link'); ?>"> <img
                                    src="<?php the_field('footer_image_two'); ?>" alt="" class="reportbott_img"> </a>
                        </div>
                    </div>
                </div>
            </article>
        </main>
    </div>


    <?php
}
get_footer();
?>