<?php
/**
 * Top Gulf CV functions and definitions
 *
 * @link https://developer.wordpress.org/themes/basics/theme-functions/
 *
 * @package Top_Gulf_CV
 */

if (!defined("_S_VERSION")) {
    // Replace the version number of the theme on each release.
    define("_S_VERSION", "1.0.0");
}

/**
 * Sets up theme defaults and registers support for various WordPress features.
 *
 * Note that this function is hooked into the after_setup_theme hook, which
 * runs before the init hook. The init hook is too late for some features, such
 * as indicating support for post thumbnails.
 */
function topgulfcv_setup()
{
    /*
     * Make theme available for translation.
     * Translations can be filed in the /languages/ directory.
     * If you're building a theme based on Top Gulf CV, use a find and replace
     * to change 'topgulfcv' to the name of your theme in all the template files.
     */
    load_theme_textdomain("topgulfcv", get_template_directory() . "/languages");

    // Add default posts and comments RSS feed links to head.
    add_theme_support("automatic-feed-links");

    /*
     * Let WordPress manage the document title.
     * By adding theme support, we declare that this theme does not use a
     * hard-coded <title> tag in the document head, and expect WordPress to
     * provide it for us.
     */
    add_theme_support("title-tag");

    /*
     * Enable support for Post Thumbnails on posts and pages.
     *
     * @link https://developer.wordpress.org/themes/functionality/featured-images-post-thumbnails/
     */
    add_theme_support("post-thumbnails");

    // This theme uses wp_nav_menu() in one location.
    register_nav_menus([
        "menu-1" => esc_html__("Primary", "topgulfcv"),
    ]);

    /*
     * Switch default core markup for search form, comment form, and comments
     * to output valid HTML5.
     */
    add_theme_support("html5", [
        "search-form",
        "comment-form",
        "comment-list",
        "gallery",
        "caption",
        "style",
        "script",
    ]);

    // Set up the WordPress core custom background feature.
    add_theme_support(
        "custom-background",
        apply_filters("topgulfcv_custom_background_args", [
            "default-color" => "ffffff",
            "default-image" => "",
        ])
    );

    // Add theme support for selective refresh for widgets.
    add_theme_support("customize-selective-refresh-widgets");

    /**
     * Add support for core custom logo.
     *
     * @link https://codex.wordpress.org/Theme_Logo
     */
    add_theme_support("custom-logo", [
        "height" => 250,
        "width" => 250,
        "flex-width" => true,
        "flex-height" => true,
    ]);
}
add_action("after_setup_theme", "topgulfcv_setup");

/**
 * Set the content width in pixels, based on the theme's design and stylesheet.
 *
 * Priority 0 to make it available to lower priority callbacks.
 *
 * @global int $content_width
 */
function topgulfcv_content_width()
{
    $GLOBALS["content_width"] = apply_filters("topgulfcv_content_width", 640);
}
add_action("after_setup_theme", "topgulfcv_content_width", 0);

/**
 * Register widget area.
 *
 * @link https://developer.wordpress.org/themes/functionality/sidebars/#registering-a-sidebar
 */
function topgulfcv_widgets_init()
{
    register_sidebar([
        "name" => esc_html__("Sidebar", "topgulfcv"),
        "id" => "sidebar-1",
        "description" => esc_html__("Add widgets here.", "topgulfcv"),
        "before_widget" => '<section id="%1$s" class="widget %2$s">',
        "after_widget" => "</section>",
        "before_title" => '<h2 class="widget-title">',
        "after_title" => "</h2>",
    ]);
}
add_action("widgets_init", "topgulfcv_widgets_init");

/**
 * Enqueue scripts and styles.
 */
function topgulfcv_scripts()
{
    $css_folder_path = get_template_directory() . "/css/";
    if (is_dir($css_folder_path)) {
        $css_files = glob($css_folder_path . "*.css");
        if ($css_files) {
            foreach ($css_files as $css_file) {
                if ("responsive" === basename($css_file, ".css")) {
                    wp_enqueue_style(
                        basename($css_file, ".css"),
                        get_template_directory_uri() .
                        "/css/" .
                        basename($css_file),
                        ["style"],
                        null
                    );
                } else {
                    wp_enqueue_style(
                        basename($css_file, ".css"),
                        get_template_directory_uri() .
                        "/css/" .
                        basename($css_file),
                        [],
                        null
                    );
                }
            }
        }
    }
    wp_enqueue_style("topgulfcv-style", get_stylesheet_uri(), [], _S_VERSION);
    wp_style_add_data("topgulfcv-style", "rtl", "replace");

    $js_folder_path = get_template_directory() . "/custom_js/";
    if (is_dir($js_folder_path)) {
        $js_files = glob($js_folder_path . "*.js");
        if ($js_files) {
            $jquery_depend = ["custom", "owl.carousel.min"];
            wp_enqueue_script('jquery-min', get_template_directory_uri() . "/custom_js/" . 'jquery.min.js', [], true);
            foreach ($js_files as $js_file) {
                if(basename($js_file, ".js") != 'jquery.min'){
                    $script_id = 'custom-'.str_replace(".", "-", basename($js_file, ".js"));
                    $path = get_template_directory_uri() . "/custom_js/" . basename($js_file);
                    
                    if(basename($js_file, ".js") == 'cart'){
                        wp_enqueue_script($script_id, $path, ["jquery-min"],'3.0', true);
                    }else if (in_array(basename($js_file, ".js"), $jquery_depend)) {
                        wp_enqueue_script($script_id, $path, ["jquery-min"], true);
                    } else {
                        wp_enqueue_script($script_id, $path, [], true);
                    }
                }
            }
        }
        // if (is_checkout()) {
        //     wp_dequeue_script('wc-checkout');
        //     wp_deregister_script('wc-checkout');
        //     wp_enqueue_script('wc-checkout-script', plugins_url('woocommerce/assets/js/frontend/checkout.min.js'), array('jquery-min'), true);
         
        // }
        // if (is_checkout()) {
        //     wp_enqueue0_script(
        //         'stripe',
        //         'https://js.stripe.com/v3/',
        //         [],
        //         '3.0',
        //         true
        //     );         
        // }
    }

    wp_enqueue_script("topgulfcv-navigation", get_template_directory_uri() . "/js/navigation.js", [], _S_VERSION, true);
    // wp_enqueue_script("topgulfcv-cart", get_template_directory_uri() . "/js/cart.js", [], _S_VERSION, true);

    if (is_singular() && comments_open() && get_option("thread_comments")) {
        wp_enqueue_script("comment-reply");
    }
}
add_action("wp_enqueue_scripts", "topgulfcv_scripts");

function enqueue_custom_admin_scripts()
{
    wp_enqueue_script("jquery-ui-dialog");
    wp_enqueue_style("wp-jquery-ui-dialog");
}

add_action("admin_enqueue_scripts", "enqueue_custom_admin_scripts");

include get_template_directory() . "/free_services_functions.php";

include get_template_directory() . "/paid_services_functions.php";
/** 
 * Implement the Custom Header feature.
 */
require get_template_directory() . "/inc/custom-header.php";

/**
 * Custom template tags for this theme.
 */
require get_template_directory() . "/inc/template-tags.php";

/**
 * Functions which enhance the theme by hooking into WordPress.
 */
require get_template_directory() . "/inc/template-functions.php";

/**
 * Customizer additions.
 */
require get_template_directory() . "/inc/customizer.php";

/**
 * Load Jetpack compatibility file.
 */
if (defined("JETPACK__VERSION")) {
    require get_template_directory() . "/inc/jetpack.php";
}

/**Custom Functionalities */
require get_template_directory() . "/topgulf-classes/cv-form-handler.php";

?>

<?php
function orpp($data)
{
}
//add_action('wp_head','orpp',1,1);

function custom_register_template($templates)
{$templates["topgulfcv-templates/free-services-template.php"] = "free services template";
    $templates["topgulfcv-templates/paid-services-report.php"] = "Paid Services report";
    $templates["topgulfcv-templates/paid-services-email-template.php"] = "Paid Services email template";
    $templates["topgulfcv_pages/paid-professional-proofreading.php"] = "paid professional proofreading";
    $templates["topgulfcv_pages/paid-career-consultancy.php"] = "paid career consultancy";
    $templates["topgulfcv_pages/paid-cv-resume-anaysis.php"] = "paid cv resume anaysis";
    $templates["topgulfcv_pages/paid-cv-resume-writing.php"] = "paid cv resume writing";
    $templates["topgulfcv_pages/paid-interview-preparation.php"] = "paid interview preparation";
    $templates["topgulfcv_pages/paid-linkedin-profile.php"] = "paid linkedin profile";
    $templates["topgulfcv_pages/paid-services.php"] = "paid services";
    $templates["templates/about-us.php"] = "About Us";
    $templates["templates/contact.php"] = "Contact";
    $templates["topgulfcv_pages/free-services.php"] = "Free Services";
    $templates["topgulfcv_pages/testimonials.php"] = "Testimonials";
    $templates["topgulfcv_pages/thankyou.php"] = "Thank You";
    $templates["topgulfcv_pages/home.php"] = "Homepage Template 1";
    $templates["topgulfcv_pages/home2.php"] = "Homepage Template 2";
    $templates["topgulfcv_pages/blog.php"] = "Blog";
    $templates["topgulfcv_pages/faq.php"] = "FAQ";

    return $templates;}
add_filter("theme_page_templates", "custom_register_template");

function topgulfcv_admin_menu_page()
{
    add_menu_page(
        "TopGulFCV", // Page title
        "TopGulFCV Menu", // Menu title
        "manage_options", // Capability required to access the page
        "topgulfcv-admin-options", // Menu slug (should be unique)
        "topgulfcv_admin_page_content", // Callback function to display page content
        "dashicons-upload", // Icon URL or dashicon name
        40// Position in the admin menu (change this to control the menu order)
    );
}
add_action("admin_menu", "topgulfcv_admin_menu_page");

function topgulfcv_admin_page_content()
{
    if (!empty($_POST)) {
        $primary_val = $_POST["primary_menu_select"];
        update_option("topgulf_primary_menu", $primary_val);
    }
    ob_start();
    ?>
    <div class="wrap"><h2>TopGulfCV Page</h2>
		<form method="post">
			<label for="primary_menu_select">Select primary menu:</label>
			<select id="primary_menu_select" name="primary_menu_select">
				<option value="">--Select a Menu--</option>
				<?php
$selected = get_option("topgulf_primary_menu");
    $all_menus = wp_get_nav_menus();
    foreach ($all_menus as $menu) {?>
					<option value="<?=$menu->term_id?>" <?php echo $selected == $menu->term_id
        ? "selected"
        : ""; ?>><?=$menu->name?></option>
					<?php }
    ?>
			</select>
			<p><input class="button button-primary" type="submit" name="submit" value="Submit"></p>
		</form>
	</div>
	<?php
$echo = ob_get_clean();
    echo $echo;
}
function add_animation_script()
{
    ?>
	<script type="text/javascript">
		const observer = new IntersectionObserver(entries => {
			entries.forEach(entry => {
			if (entry.isIntersecting) {
					entry.target.classList.add('onscroll-anime');
					observer.unobserve(entry.target);
				}
			})
		})
        if(document.querySelector(".anime-on-scroll") != null){
            observer.observe(document.querySelector(".anime-on-scroll"))
        }
	</script>
	<?php
}
// add_action("wp_footer", "add_animation_script");

// Register Custom Post Type
function custom_slider_post_type()
{
    $labels = [
        "name" => _x("Sliders", "Post Type General Name", "text_domain"),
        "singular_name" => _x(
            "Slider",
            "Post Type Singular Name",
            "text_domain"
        ),
        "menu_name" => __("Sliders", "text_domain"),
        "all_items" => __("All Sliders", "text_domain"),
        "view_item" => __("View Slider", "text_domain"),
        "add_new_item" => __("Add New Slider", "text_domain"),
        "add_new" => __("Add New", "text_domain"),
        "edit_item" => __("Edit Slider", "text_domain"),
        "update_item" => __("Update Slider", "text_domain"),
        "search_items" => __("Search Slider", "text_domain"),
        "not_found" => __("Not Found", "text_domain"),
        "not_found_in_trash" => __("Not found in Trash", "text_domain"),
    ];

    $args = [
        "label" => __("slider", "text_domain"),
        "description" => __("Header Slider", "text_domain"),
        "labels" => $labels,
        "supports" => ["title", "editor", "thumbnail", "custom-fields"],
        "hierarchical" => false,
        "public" => false, // Set to true if you want it to be publicly accessible.
        "show_ui" => true,
        "show_in_menu" => true,
        "show_in_nav_menus" => true,
        "show_in_admin_bar" => true,
        "menu_icon" => "dashicons-images-alt2", // Choose an icon: https://developer.wordpress.org/resource/dashicons/
        "menu_position" => 20,
        "can_export" => true,
        "has_archive" => false,
        "exclude_from_search" => true,
        "publicly_queryable" => false,
        "capability_type" => "page",
    ];

    register_post_type("slider", $args);
}

add_action("init", "custom_slider_post_type", 0);

function custom_home_slider_post_type()
{
    $labels = [
        "name" => _x("Home Sliders", "Post Type General Name", "text_domain"),
        "singular_name" => _x(
            "Slider",
            "Post Type Singular Name",
            "text_domain"
        ),
        "menu_name" => __("Home Sliders", "text_domain"),
        "all_items" => __("All Home Sliders", "text_domain"),
        "view_item" => __("View Slider", "text_domain"),
        "add_new_item" => __("Add New Slider", "text_domain"),
        "add_new" => __("Add New", "text_domain"),
        "edit_item" => __("Edit Slider", "text_domain"),
        "update_item" => __("Update Slider", "text_domain"),
        "search_items" => __("Search Slider", "text_domain"),
        "not_found" => __("Not Found", "text_domain"),
        "not_found_in_trash" => __("Not found in Trash", "text_domain"),
    ];

    $args = [
        "label" => __("home slider", "text_domain"),
        "description" => __("Home Slider", "text_domain"),
        "labels" => $labels,
        "supports" => ["title", "custom-fields"],
        "hierarchical" => false,
        "public" => false, // Set to true if you want it to be publicly accessible.
        "show_ui" => true,
        "show_in_menu" => true,
        "show_in_nav_menus" => true,
        "show_in_admin_bar" => true,
        "menu_icon" => "dashicons-images-alt2", // Choose an icon: https://developer.wordpress.org/resource/dashicons/
        "menu_position" => 20,
        "can_export" => true,
        "has_archive" => false,
        "exclude_from_search" => true,
        "publicly_queryable" => false,
        "capability_type" => "page",
    ];

    register_post_type("home_slider", $args);
}

add_action("init", "custom_home_slider_post_type", 0);

function footerone()
{
    register_sidebar(array(
        'name' => 'footerone',
        'id' => 'footerone',
        'description' => 'will be display on footerone',

        'before_title' => '<h3 class="footerone">',
        'after_title' => '</h3>',
    )
    );
}
add_action('widgets_init', 'footerone');

function footertwo()
{
    register_sidebar(array(
        'name' => 'footertwo',
        'id' => 'footertwo',
        'description' => 'will be display on footertwo',

        'before_title' => '<h3 class="footertwo">',
        'after_title' => '</h3>',
    )
    );
}
add_action('widgets_init', 'footertwo');

function footerthree()
{
    register_sidebar(array(
        'name' => 'footerthree',
        'id' => 'footerthree',
        'description' => 'will be display on footerthree',

        'before_title' => '<h3 class="footerthree">',
        'after_title' => '</h3>',
    )
    );
}
add_action('widgets_init', 'footerthree');

function footerfour()
{
    register_sidebar(array(
        'name' => 'footerfour',
        'id' => 'footerfour',
        'description' => 'will be display on footerfour',

        'before_title' => '<h3 class="footerfour">',
        'after_title' => '</h3>',
    )
    );
}
add_action('widgets_init', 'footerfour');
function footerfive()
{
    register_sidebar(array(
        'name' => 'footerfive',
        'id' => 'footerfive',
        'description' => 'will be display on footerfive',

        'before_title' => '<p class="text-center">',
        'after_title' => '</p>',
    )
    );
}
add_action('widgets_init', 'footerfive');

function footerbotom()
{
    register_sidebar(array(
        'name' => 'footerbotom',
        'id' => 'footerbotom',
        'description' => 'will be display on footerbotom',

        'before_title' => '<p class="text-center">',
        'after_title' => '</p>',
    )
    );
}
add_action('widgets_init', 'footerbotom');
// Add Meta Box for Enable/Disable Slider
function custom_slider_meta_box()
{
    add_meta_box(
        "enable_slider_meta_box",
        "Enable Slider",
        "custom_slider_meta_box_callback",
        "slider",
        "side", // Change the position as needed
        "default"
    );
}

add_action("add_meta_boxes", "custom_slider_meta_box");

// Meta Box Callback
function custom_slider_meta_box_callback($post)
{
    $value = get_post_meta($post->ID, "_enable_slider", true);?>
    <label for="enable_slider">
        <input type="checkbox" name="enable_slider" id="enable_slider" <?php checked(
        $value,
        1
    );?>>
        Enable Slider
    </label>
    <?php
}

// Save Meta Box Data
function save_custom_slider_meta_box($post_id)
{
    if (defined("DOING_AUTOSAVE") && DOING_AUTOSAVE) {
        return;
    }
    if (!current_user_can("edit_post", $post_id)) {
        return;
    }

    $enable_slider = isset($_POST["enable_slider"]) ? 1 : 0;
    update_post_meta($post_id, "_enable_slider", $enable_slider);
}

add_action("save_post", "save_custom_slider_meta_box");

function custom_admin_script()
{
    ?>
<script>
jQuery(document).ready(function ($) {
    $("#email-dialog").dialog({
        autoOpen: false,
        modal: true,
        width: 600,
        height: 500,
        buttons: {
            "Send Message": function () {
                var userEmail = $(this).data('email');
                var userId = $(this).data('id');
                var title = $('#title-input').val();
                var description = $('#description-input').val();
                var message = tinyMCE.get('message').getContent();

                var fileInput = $('#file-input')[0].files[0];

                if (message.trim() !== '' && title.trim() !== '') {
                    var formData = new FormData();
                    formData.append('action', 'send_email_action');
                    formData.append('userEmail', userEmail);
                    formData.append('userId', userId);
                    formData.append('title', title);
                    formData.append('description', description);
                    formData.append('message', message);

                    if (fileInput) {
                        formData.append('file', fileInput);
                    }

                    $.ajax({
                        type: 'POST',
                        url: ajaxurl,
                        data: formData,
                        processData: false,
                        contentType: false,
                        success: function (response) {
							if (response.success === true) {
								$('span.email_status[data-id="' + userId + '"]').html('Sent');
								alert('Message sent successfully. ');

								$(this).dialog("close");
							} else {
                                $('span.email_status[data-id="' + userId + '"]').html('Sent');
       							 alert('Message sent successfully.');
                                    window.location.reload();
							}
												},
                        error: function (error) {
                            console.error(error);
                            alert('Error sending the message.');
                        }
                    });
                    $(this).dialog("close");
                } else {
                    alert('Please fill in all fields.');
                }
            },
            Cancel: function () {
                $(this).dialog("close");
            }
        }
    });

    $('.send-email').on('click', function (e) {
        e.preventDefault();
        var userEmail = $(this).data('email');
        var userId = $(this).data('id');
        $("#email-dialog").data('email', userEmail);
        $("#email-dialog").data('id', userId);
        $("#email-dialog").dialog("open");
    });

    $('.show-message-btn').on('click', function (e) {
    e.preventDefault();
    var message = $(this).data('message');
    var title = $(this).data('title');
    var reportMessages = $(this).data('report-message');
    var currentTime = new Date().toLocaleString();

    function formatTimestamp(timestamp) {
        var date = new Date(timestamp);
        var options = { month: 'long', day: 'numeric', year: 'numeric', hour: 'numeric', minute: 'numeric', hour12: true };
        return date.toLocaleString('en-US', options);
    }

    var content = '';
    if (message && title ) {
        content += '<strong>Message:</strong> ' + message +
                   '<p><strong>Title:</strong> ' + title + '</p>';
    }

    // Check if reportMessages is not empty and is an array
    if (Array.isArray(reportMessages) && reportMessages.length > 0) {
        $.each(reportMessages, function(index, item) {
            var formattedTimestamp = formatTimestamp(item.timestamp);
            content += '<p><strong>Report Message:</strong> ' + formattedTimestamp + ':' + item.message + '</p>';
        });
    }

    if (content.trim() !== '') {
        $('<div class="testesttets"></div>').html(content).dialog({
            title: 'Message',
            modal: true,
            width: 400,
            buttons: {
                Ok: function () {
                    $(this).dialog('close');
                }
            }
        });
    }
});



});
</script>



			<?php
}

add_action("admin_footer", "custom_admin_script");

function save_message_function()
{
    if (
        isset($_POST["postId"]) &&
        isset($_POST["message"]) &&
        isset($_POST["userEmail"]) &&
        isset($_POST["userId"]) &&
        isset($_POST["title"]) &&
        isset($_POST["report_messages"])
    ) {
        $post_id = $_POST["postId"];
        $new_message = $_POST["message"];
        $title = $_POST["title"];
        $report_message = get_post_meta($post_id, "report_message", true);
        $existing_messages = get_post_meta($post_id, "message_column", true);
        $current_datetime = current_time("mysql");
        $formatted_message = "<p><b>Subject:</b> " . esc_html($title) . "</p>" .
        "<p><b>Message:</b> " . nl2br(esc_html($new_message)) . "</p>" .
            "[<b>" . $current_datetime . "] </b>";

        if (!empty($existing_messages)) {
            $existing_messages = $formatted_message . $existing_messages;
        } else {
            $existing_messages = $formatted_message;
        }

        update_post_meta($post_id, "message_column", $existing_messages);

        echo wp_send_json_success(["msg" => "Message saved successfully."]);
    } else {
        echo wp_send_json_error(["msg" => "Invalid data."]);
    }
    wp_die();
}

add_action("wp_ajax_save_message_action", "save_message_function");

add_action("wp_ajax_send_email_action", "send_email_action");
function send_email_action()
{
    $userEmail = sanitize_email($_POST["userEmail"]);
    $userId = intval($_POST["userId"]);
    $title = sanitize_text_field($_POST["title"]);
    $message = stripslashes($_POST["message"]);
    // Set the timezone to India
    date_default_timezone_set('Asia/Kolkata');
    $currentDateTime = date("F j, Y g:i a");

    $existingTitle = get_post_meta($userId, "title", true);
    $existingDescription = get_post_meta($userId, "description", true);
    $existingMessage = get_post_meta($userId, "message_column", true);

    $combinedTitle = $currentDateTime . " :" . ($title ? $title : "No new title provided") . "<br>" . $existingTitle;
    $combinedMessage = $currentDateTime . ": " . ($message ? $message : "No new Message provided") . "<br>" . $existingMessage;

    update_post_meta($userId, "title", $combinedTitle);
    update_post_meta($userId, "description", $combinedDescription);
    update_post_meta($userId, "message_column", $combinedMessage);

    $attachments = [];
    if (isset($_FILES["file"])) {
        $file = $_FILES["file"];
        $file_name = $file["name"];
        $file_tmp = $file["tmp_name"];

        $upload_dir = wp_upload_dir();
        $file_path = $upload_dir["path"] . "/" . $file_name;
        move_uploaded_file($file_tmp, $file_path);

        $attachments[] = $file_path;

   
    }

    $expirationTimestamp = strtotime("+5 days");
    $token = md5(uniqid(rand(), true));
    $link = site_url() . "/email-page/?userId={$userId}&title=" . urlencode($title) . "&description=" . urlencode($description) . "&token={$token}&expires={$expirationTimestamp}";

    $subject = $title;
    $body = "
	<table border='0' cellpadding='0' cellspacing='0' width='100%' class='wrapperBody' style='max-width:600px'>
		<tbody>
			<tr>
				<td align='center' valign='top'>
					<table border='0' cellpadding='0' cellspacing='0' width='100%' class='tableCard' style='background-color:#fff;border-color:#e5e5e5;border-style:solid;border-width:0 1px 1px 1px;'>
						<tbody>
							<tr>
								<td style='background-color:#00d2f4;font-size:1px;line-height:3px' class='topBorder' height='3'>&nbsp;</td>
							</tr>
							<tr>
								<td style='padding-top: 60px; padding-bottom: 20px;' align='center' valign='middle' class='emailLogo'>
									<a href='#' style='text-decoration:none' target='_blank'>
										<img alt='' border='0' src='https://topgulfcv.com/wp-content/themes/topgulfcv/images/topgulf.png' style='width:100%;max-width:150px;height:auto;display:block' width='150'>
									</a>
								</td>
							</tr>
							<tr>
								<td style='padding-bottom: 5px; padding-left: 20px; padding-right: 20px;' valign='top' class='mainTitle'>
									$message
								</td>
							</tr>

							<tr>
								<td style='padding-left:20px;padding-right:20px' align='center' valign='top' class='containtTable ui-sortable'>

									<table border='0' cellpadding='0' cellspacing='0' width='100%' class='tableButton' style=''>
										<tbody>
											<tr>
												<td style='padding-top:20px;padding-bottom:20px' align='center' valign='top'>
													<table border='0' cellpadding='0' cellspacing='0' align='center'>
														<tbody>
															<tr>
															
															</tr>
														</tbody>
													</table>
												</td>
											</tr>
										</tbody>
									</table>
								</td>
							</tr>
							<tr>
								<td style='font-size:1px;line-height:1px' height='20'>&nbsp;</td>
							</tr>

						</tbody>
					</table>
				</td>
			</tr>
		</tbody>
	</table>
";
    echo $body;

    $headers = ["Content-Type: text/html; charset=UTF-8"];

    $success = wp_mail($userEmail, $subject, $body, $headers, $attachments);

    foreach ($attachments as $attachment) {
        if (file_exists($attachment)) {
            unlink($attachment);
        }
    }

    if ($success) {
        update_post_meta($userId, "email_status", "Sent");
        echo json_encode(["success" => true]);
    } else {
        $error_message = error_get_last();
        error_log("Error sending email: " . json_encode($error_message));

        echo json_encode([
            "success" => false,
            "error" => "Error sending the message. Please check the error log.",
        ]);
    }

    wp_die();
}

// function save_message_function() {
//     if (isset($_POST['postId']) && isset($_POST['message'])) {
//         $post_id = $_POST['postId'];
//         $new_message = $_POST['message'];
//         $existing_messages = get_post_meta($post_id, 'message_column', true);
//         $current_datetime = current_time('mysql');
//         $formatted_message = '[<b>' . $current_datetime . '] </b>' . $new_message;
//         if (!empty($existing_messages)) {
//             $existing_messages = $formatted_message . "\n\n<br><br>" . $existing_messages;
//         } else {
//             $existing_messages = $formatted_message;
//         }
//         update_post_meta($post_id, 'message_column', $existing_messages);

//         echo wp_send_json_success(array('msg' => 'Message saved successfully.'));
//     } else {
//         echo 'Invalid data.';
//     }
//     wp_die();
// }

// add_action('wp_ajax_save_message_action', 'save_message_function');

function save_custom_columns_data($post_id)
{
    if (isset($_POST["status"])) {
        $old_status = get_post_meta($post_id, "status", true);
        $new_status = sanitize_text_field($_POST["status"]);
        update_post_meta($post_id, "status", $new_status);
        if ($old_status !== $new_status && $new_status === "Done") {
            send_thanks_email($post_id);
        }
    }
}
add_action("save_post", "save_custom_columns_data");

function send_thanks_email($post_id)
{
    $user_email = get_post_meta($post_id, "email", true);
    $subject = "Thanks for your service!";
    $message = "Dear user, thank you for using our service.";
    wp_mail($user_email, $subject, $message);
}

function custom_admin_footer()
{
    global $post_type;

    // Check if the current post type is "paid_services"
    if ($post_type === 'paid_services') {
        ?>
        <div id="email-dialog" class="emailadmin t21" title="Send Message">
            <div>
               
                <div>
                <label for="title-input" class="admintitle">Subject:</label><br>
                <input type="text" id="title-input" class="inputbox" size="100">
            </div>
            <label for="message" class="adminmessage">Enter your message:</label><br>
                <?php
wp_editor('', 'message', array(
            'textarea_name' => 'message',
            'media_buttons' => false,
            'tinymce' => array(
                'toolbar1' => 'bold italic underline strikethrough | bullist numlist | outdent indent | alignleft aligncenter alignright alignjustify',
                'toolbar2' => '',
            ),
        ));
        ?>
            </div>

            <!-- <script>
                jQuery(document).ready(function($) {
                    $('#wp-message-wrap .wp-editor-tabs').remove();
                });
            </script> -->

            <br>
            <div style="margin-top: 10px;">
                <label for="file-input"></label>
                <input type="file" class="upload_wraper" id="file-input" name="file">
            </div>
        </div>
        <?php
}
}

add_action("admin_footer", "custom_admin_footer");

// Enqueue Flatpickr styles

add_action("admin_head", "my_custom_css");

function my_custom_css()
{
    echo '
<style>

select.status-select {
     max-width: 100%;
}
.acf-button-group label.selected a{
    color:#fff !important;
}

#exportPdfButton{
    margin-top: 10px;
}

.extendLinkForm {
    width: 100px;
    display: inline-block;
    margin-top: -5px;
}
.sendreport .button {
    width: 100px;
    margin-bottom: 10px;
    text-align: center;
}
.sendreport a {
    margin-bottom: 0px !important;
}

.post-type-paid_services #submitpost{
    display:none;
}

.post-type-paid_services .service1.column-service1 {
	height: 100px;
	overflow: scroll;
	display: block;
}
.post-type-paid_services .table-view-list thead tr th {
	width: 110px;
}
.post-type-paid_services .paid-table {
	overflow-y: scroll;
	width: 100%;
    height:70%;
}
#sendEmail {
    width: 130px;
    height: 40px;
    background: #fe005a;
    color: #fff;
    border-radius: 10px;
    border: none;
    font-size: 14px;
    margin-top: 10px;
}
#emailModal label {
	font-size: 16px;
	line-height: 2;
}
.close {
	color: #aaa;
	/* float: right; */
	font-size: 28px;
	/* font-weight: bold; */
	background: #000 !important;
	width: auto !important;
	border-radius: inherit !important;
	width: 25px !important;
	height: 25px !important;
	text-align: center;
	padding: 4px;
	position: absolute;
	top: 0;
	right: 0;
}
#message {
	margin: 10px 0;
	height: 200px;
	width: 100%;
}
#emailModal div.modal-content {
	width: 38%;
	position: relative;
}
.post-type-paid_services .row-actions {
	color: #a7aaad;
	font-size: 13px;
	padding: 2px 0 0;
	position: relative;
	left: -9999em;
	display: none;
}
.post-type-free_services .row-actions {
	color: #a7aaad;
	font-size: 13px;
	padding: 2px 0 0;
	position: relative;
	left: -9999em;
	display: none;
}
div#email-dialog {
    height: auto !important;
}
.post-type-paid_services div.ui-dialog.ui-corner-all.ui-widget.ui-widget-content.ui-front.ui-dialog-buttons.ui-draggable.ui-resizable {
    width: 600px !important;
    // left: 50% !important;
    height: 500px !important;
    overflow-y: auto;
    top: 50% !important;
    margin: -250px 0 0 -300px !important;
}
.testesttets p {
    line-height: 28px;
    padding: 0 !important;
    margin: 0;
}


.area_wraper {
	width: 100%;
	margin-top: 10px;
}

.inputbox {
	width: 100%;
	margin-top: 10px;
	margin-bottom: 10px;
	height: 40px;
	line-height: 40px;
}

.ui-button.ui-corner-all.ui-widget {
	width: 130px;
	height: 40px;
	background: #fe005a;
	color: #fff;
	border-radius: 10px;
	border: none;
	font-size:14px;
}

.ui-button.ui-corner-all.ui-widget:hover {
	width: 130px;
	height: 40px;
	background: #fe005a;
	color: #fff;
	border-radius: 10px;
	border: none;
}

.ui-button.ui-corner-all.ui-widget:focus {
	width: 130px;
	height: 40px;
	background: #fe005a;
	color: #fff;
	border-radius: 10px;
	border: none;}

	.ui-dialog-titlebar-close {
	background: #000 !important;
	width: auto !important;
	border-radius: inherit !important;
}


.send-email {
	display: block;
	text-align: left;
}

.email-status {
	display: block;
	text-align: left;
}
.message-show-box a {
	display: block;
}
.message-show-box {
	width: 100%;
	text-align: center;
	display: block;
}

.post-type-paid_services .editinline{
    display:none !important;
}

.post-type-free_services .editinline{
    display:none !important;
}





.subsubsub .mine{
	display:none;
	}

    @media (max-width:767px) {
        #wp-content-media-buttons a {
            padding: 0 10px;
        }
        #woocommerce-product-data .hndle .product-data-wrapper .woocommerce-product-type-tip {
            margin-left: 0;
        }
        #woocommerce-product-data .hndle label {
            padding-right: 0px;
            margin-top: 0;
            /* display: inline-block; */
            width: auto;
        }
        .metabox-prefs label {
            display: inline-block;
            padding-right: 15px;
            line-height: 2.35;
            width: 120px;
        }
        .sendreport .button {
            width: 120px !important;
            margin-bottom: 10px;
            /* white-space: inherit; */
            display: inline-block;
        }

        #fieldset-billing input {
            width: 87%;
            padding-right: 10px;
        }
        span.select2-selection.select2-selection--single {
            width: 87%;
        }

        #fieldset-shipping input {
            width: 87%;
            padding-right: 10px;
        }
        span.select2-selection.select2-selection--single {
            width: 87%;
        }
        .email-status {
            display: block;
            text-align: left;
        }
        .send-email {
            display: block;
            text-align: left;
        }
        .send-email img {
            width: 30px;
            height: 40px !important;
        }
        .post-type-paid_services div.ui-dialog.ui-corner-all.ui-widget.ui-widget-content.ui-front.ui-dialog-buttons.ui-draggable.ui-resizable {
            width: 100% !important;
            left: 0 !important;
            margin: 0 !important;
            top: 20% !important;
        }
        .message-show-box {
            text-align: left;
        }
        .message-show-box img {
            width: 30px;
            height: 30px;
        }
        #emailModal div.modal-content {
            width: 80% !important;
            position: relative;
            top:15%;
        }


    }

    @media (min-width:768px) and (max-width:1200px) {
        .sendreport a {
            margin-bottom: 0px !important;
            padding: 0px 3px !important;
        }
        .sendreport button {
            margin-bottom: 0px !important;
            padding: 0px 3px !important;
        }
        .button {
            width: auto !important;
            white-space: inherit !important;
        }
        th#status11 {
            width: 90px;
        }
    }



</style>';
}
add_filter("nav_menu_css_class", "special_nav_class", 10, 2);

function special_nav_class($classes, $item)
{
    if (in_array("current-menu-item", $classes)) {
        $classes[] = "active ";
    }
    return $classes;
}

function add_classes_on_li($classes, $item, $args)
{
    $classes[] = "nav-item nav-link";
    return $classes;
}
add_filter("nav_menu_css_class", "add_classes_on_li", 1, 3);

add_filter("wc_add_to_cart_message_html", "__return_false");

/*****************Testimonial Custom Code*****************************/

function create_Testimonials_cpt()
{
    $labels = [
        "name" => "Testimonials",
        "singular_name" => "Testimonial",
        "menu_name" => "Testimonials",
        "add_new_item" => "Add New Testimonial",
        "edit_item" => "Edit Testimonial",
        "new_item" => "New Testimonial",
        "view_item" => "View Testimonial",
        "search_items" => "Search Testimonial",
        "not_found" => "No Case Testimonial found",
        "not_found_in_trash" => "No Testimonials found in Trash",
    ];

    $args = [
        "label" => "Testimonials",
        "labels" => $labels,
        "public" => true,
        "publicly_queryable" => true,
        "show_ui" => true,
        "show_in_menu" => true,
        "query_var" => true,
        "rewrite" => ["slug" => "testimonials"],
        "capability_type" => "post",
        "has_archive" => true,
        "hierarchical" => false,
        "menu_position" => 5,
        "supports" => ["title", "editor", "thumbnail"],
    ];

    register_post_type("testimonial", $args);
}
add_action("init", "create_Testimonials_cpt");
/***************** End Testimonial Custom Code*****************************/

function change_success_url($redirect_url)
{
    ?>
	<form action="<?=$redirect_url?>" id="submit-form" method="post">
		<input type="hidden" name="form_fill" value="true">
	</form>
	<script>
		document.getElementById('submit-form').submit()
        sessionStorage.removeItem('openPopupId');
	</script>
	<?php exit();
}
add_filter("wpcf7_redirect_url", "change_success_url", 10, 1);

function dequeue_all_cf7_scripts() {
    // Dequeue all Contact Form 7 scripts except 'contact-form-7-js-extra'
    global $wp_scripts;

    foreach ($wp_scripts->registered as $script) {       
        if (strpos($script->handle, 'contact-form-7') === 0 || strpos($script->handle, 'wpcf7-redirect') === 0) {
            wp_dequeue_script($script->handle);
        }
    }    
}
add_action('wp_enqueue_scripts', 'dequeue_all_cf7_scripts', PHP_INT_MAX);

function stop_succes_page()
{
    if (is_page() && str_contains(get_the_title(), "Success")) {
        $success_templates = [
            "free-basic-cv-analysis.php",
            "free-cover-letter-template.php",
            "free-cv-resume-template.php",
            "free-interview-tips.php",
            "free-linkedin-profile-tips.php",
            "free-success.php",
        ];
        if (in_array(basename(get_page_template()), $success_templates)) {
            if (!isset($_POST) || !$_POST["form_fill"]) {
                wp_redirect("/");
                exit();
            }
        }
    }
}
// add_action("template_redirect", "stop_succes_page");

add_action('wp_ajax_add_to_cart', 'custom_add_to_cart');
add_action('wp_ajax_nopriv_add_to_cart', 'custom_add_to_cart');

function custom_add_to_cart()
{
    $product_id = intval($_POST['product_id']);

    if ($product_id > 0) {
        $added_to_cart = WC()->cart->add_to_cart($product_id);
        if ($added_to_cart) {
            echo json_encode(array('success' => true, 'message' => 'Product added to cart'));
        } else {
            echo json_encode(array('success' => false, 'message' => 'Error adding product to cart'));
        }
    }

    wp_die();
}

add_action('wp_ajax_remove_from_cart', 'custom_remove_from_cart');
add_action('wp_ajax_nopriv_remove_from_cart', 'custom_remove_from_cart');
function custom_remove_from_cart()
{
    $product_id = intval($_POST['product_id']);

    if ($product_id > 0) {
        $cart = WC()->cart->get_cart();

        foreach ($cart as $cart_item_key => $cart_item) {
            if ($cart_item['product_id'] === $product_id) {
                $removed_from_cart = WC()->cart->remove_cart_item($cart_item_key);

                if ($removed_from_cart) {
                    echo json_encode(array('success' => true, 'message' => 'Product removed from cart'));
                } else {
                    error_log('Error removing product from cart. Product ID: ' . $product_id);
                    echo json_encode(array('success' => false, 'message' => 'Error removing product from cart'));
                }

                wp_die();
            }
        }
        echo json_encode(array('success' => false, 'message' => 'Product not found in cart'));
    } else {
        echo json_encode(array('success' => false, 'message' => 'Invalid product ID'));
    }

    wp_die();
}

function hide_acf_field_group()
{
    global $current_screen;
    if ($current_screen->base == 'post' || $current_screen->base == 'page') {
        echo '<style>#acf-group_655c84b1908df { display: none !important; }</style>';
    }
}
add_action('acf/input/admin_head', 'hide_acf_field_group');

function custom_clear_cart_on_checkout($order_id)
{
    WC()->cart->empty_cart();
    $cart_count = WC()->cart->get_cart_contents_count();
    update_option('cart_count_option', $cart_count);
}

function update_report_expiry()
{
    $post_id = $_POST['postId'];
    $new_expire_timestamp = strtotime($_POST['selectedDate']);
    update_post_meta($post_id, 'expiration_timestamp', $new_expire_timestamp);
    wp_die();
}
add_action('wp_ajax_update_report_expiry', 'update_report_expiry');
add_action('wp_ajax_nopriv_update_report_expiry', 'update_report_expiry');
add_action('save_post', 'update_status_on_save', 10, 2);

add_action('admin_init', 'update_status_on_admin_edit');

function update_status_on_admin_edit()
{
    if (isset($_GET['post']) && isset($_GET['action']) && $_GET['action'] === 'edit' && isset($_GET['send_email']) && $_GET['send_email'] === 'true') {
        $post_id = intval($_GET['post']);
        $current_user = wp_get_current_user();
        if (user_can($current_user, 'administrator')) {
            update_post_meta($post_id, 'status-update', 'In Review');

        }
    }?>


<?php
}

function custom_admin_init_script()
{
    global $pagenow, $typenow;

    if (is_admin() && $pagenow === 'edit.php' && $typenow === 'paid_services') {
        if (!defined('DOING_AJAX') || !DOING_AJAX || !isset($_REQUEST['action']) || $_REQUEST['action'] !== 'export_paid_services_csv') {
            ?>
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/flatpickr/dist/flatpickr.min.css">
<script src="https://cdn.jsdelivr.net/npm/flatpickr"></script>
<script>
    document.addEventListener('DOMContentLoaded', function() {
    var extendLinkButton = document.getElementsByClassName('extendLinkButton');
    var extendLinkForm = document.getElementsByClassName('extendLinkForm');
    var calendarInput = document.getElementsByClassName('calendar');
    var doneButton = document.getElementsByClassName('doneButton');

    if (extendLinkButton.length>0) {
        for(let i=0; i<extendLinkButton.length;i++){
            extendLinkButton[i].addEventListener('click', function(event) {
                event.preventDefault();
                let linkContainer = jQuery(event.target).parent('.extendLinkContainer');
                linkContainer.find('.extendLinkForm').get(0).style.display = 'block';
                // extendLinkForm.style.display = 'block';
                initializeFlatpickr();
            });
        }
    }

    function initializeFlatpickr() {
        for(let i=0; i<calendarInput.length;i++){
            var flatpickrInstance = flatpickr(calendarInput[i], {
                dateFormat: 'Y-m-d',
                minDate: 'today',
                // onChange: function(selectedDates, dateString, instance) {
                //     console.log('Selected Date:', dateString);
                // }
            });

        }
    }
    if (doneButton.length>0) {
        for(let i=0; i<doneButton.length;i++){
            doneButton[i].addEventListener('click', function(event) {
                event.preventDefault();
                postID = event.target.dataset['post_id']
                let linkContainer = jQuery(event.target).parents('.extendLinkContainer');
                var selectedDate = linkContainer.find('.flatpickr-input').val()
                // var selectedDates = flatpickrInstance.selectedDates;
                if (postID && selectedDate) {
                    console.log('Formatted Date:', selectedDate);
                    submitFormAjax(postID,selectedDate);
                }
            });
        }
    }


    function submitFormAjax(postID,selectedDate) {
        var ajaxurl = "<?php echo site_url() ?>"+'/wp-admin/admin-ajax.php';
        var formData = new FormData()
        formData.append('action','update_report_expiry')
        formData.append('postId',postID)
        formData.append('selectedDate',selectedDate)
        fetch(ajaxurl, {
            method: 'POST',
            body: formData
        })
        .then(response => response.text())
        .then(data => {
            alert('Link extended successfully!');
            window.location.reload();
        })
        .catch(error => {
            console.error('Error:', error);
        });
    }


});
</script>
<?php
}
    }
}

add_action('admin_init', 'custom_admin_init_script');

function load_more_testimonials() {
    $loaded_testimonials = isset($_POST['loaded_testimonials']) ? $_POST['loaded_testimonials'] : array();
    $initial_testimonials_count = isset($_POST['initial_testimonials_count']) ? intval($_POST['initial_testimonials_count']) : 0;

    $args = array(
        'post_type' => 'testimonial',
        'paged' => $_POST['page'],
        'post__not_in' => $loaded_testimonials,
        'posts_per_page' => 4, // Load 4 testimonials at a time
    );

    if ($initial_testimonials_count > 0) {
        $args['offset'] = $initial_testimonials_count;
    }

    $query = new WP_Query($args);

    if ($query->have_posts()):
        while ($query->have_posts()):
            $query->the_post();
            ?>
            <div class="testimonial" data-testimonial-id="<?php echo get_the_ID(); ?>">
                <blockquote>
                    <p><?php echo get_the_content(); ?></p>
                </blockquote>

                <div class="quote-footer text-right">
                    <div class="quote-author-img">
                        <img src="<?php the_post_thumbnail_url(); ?>">
                    </div>
                    <h4><?php the_title(); ?></h4>
                    <h4><?php echo get_field('designation'); ?></h4>
                    <?php $company_logo = get_field('company_logo'); ?>
                    <?php if ($company_logo): ?>
                        <p><strong><img src="<?php echo $company_logo; ?>"></strong></p>
                    <?php endif; ?>
                </div>
            </div>
        <?php endwhile;

        wp_reset_postdata();
    else:
        echo '<p class="no-testimonials">No more Testimonials</p>';
    endif;

    die();
}


add_action('wp_ajax_load_more_testimonials', 'load_more_testimonials');
add_action('wp_ajax_nopriv_load_more_testimonials', 'load_more_testimonials');

function custom_hide_bulk_edit_option($actions)
{

    if ('free_services' == get_current_screen()->post_type) {
        unset($actions['edit']);
    }

    return $actions;
}

add_filter('bulk_actions-edit-free_services', 'custom_hide_bulk_edit_option');

function custom_hide_bulk_edit_optionn($actions)
{

    if ('paid_services' == get_current_screen()->post_type) {
        unset($actions['edit']);

    }

    return $actions;
}

add_filter('bulk_actions-edit-paid_services', 'custom_hide_bulk_edit_optionn');

function remove_post_type_actions($actions)
{
    global $post;
    if ($post->post_type === 'paid_services') {
        unset($actions['edit']);
        unset($actions['trash']);
        unset($actions['view']);

    }

    return $actions;
}

add_filter('post_row_actions', 'remove_post_type_actions', 10, 2);

function remove_post_type_actionss($actions)
{
    global $post;
    if ($post->post_type === 'free_services') {
        unset($actions['edit']);
        unset($actions['trash']);
        unset($actions['view']);

    }

    return $actions;
}

add_filter('post_row_actions', 'remove_post_type_actionss', 10, 2);
add_action('wp_ajax_load_posts', 'load_posts');
add_action('wp_ajax_nopriv_load_posts', 'load_posts');

function load_posts()
{
    check_ajax_referer('load_more_posts_nonce', 'nonce');

    $paged = $_POST['page'];
    $category_id = $_POST['category_id'];
    $args = array(
        'cat' => $category_id,
        'paged' => $paged,
        'orderby' => 'DESC',
        'posts_per_page' => 1,
    );
    $query = new WP_Query($args);

    if ($query->have_posts()):
        while ($query->have_posts()): $query->the_post();
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
						                            <h5><?php the_title();?></h5>
						                            <p class="mt-2 "> <?php
        $content = get_the_content();
            echo wp_trim_words($content, 30, '...');
            ?></p>
						                            <a href="<?php echo get_permalink(); ?>" class="readmore">Read More</a>
						                            <div class="d-flex justify-content-end blog-shape">
						                                <a href="<?php echo get_permalink(); ?>"><img
						                                            src="/wp-content/uploads/2023/10/blog-arrow.png" alt="arrow"
						                                            class="img-fluid position-relative"></a>
						                            </div>
						                        </div>
						                    </a>
						                </div>
						            </div>
						        <?php endwhile;
        wp_reset_postdata();
    else:
        echo '';
    endif;

    die();
}

// Add thank you mail page to the admin menu
// Create the options page for email settings
function custom_options_menu() {
    add_menu_page(
        'Paid Services Thank You Email Page',
        'Thank you Email',
        'manage_options',
        'custom_email_settings',
        'custom_email_settings_page',
        'dashicons-email'
    );
}
add_action('admin_menu', 'custom_options_menu');

function custom_email_settings_page() {
    ?>
    <div class="wrap">
        <h2>Thank you email content - Paid Services</h2>
        <form method="post" action="options.php">
            <?php settings_fields('custom_email_options_group'); ?>
            <?php do_settings_sections('custom_email_settings_page'); ?>
            <?php submit_button(); ?>
        </form>
    </div>
    <?php
}

function custom_email_settings_init() {
    register_setting('custom_email_options_group', 'custom_email_options');

    add_settings_section(
        'custom_email_section',
        '',
        '',
        'custom_email_settings_page'
    );

    add_settings_field(
        'custom_email_subject',
        'Email Subject',
        'custom_email_subject_callback',
        'custom_email_settings_page',
        'custom_email_section'
    );

    add_settings_field(
        'custom_email_message',
        'Email Message',
        'custom_email_message_callback',
        'custom_email_settings_page',
        'custom_email_section'
    );
}
add_action('admin_init', 'custom_email_settings_init');

// Callback function for email subject
function custom_email_subject_callback() {
    $options = get_option('custom_email_options');
    echo '<input type="text" id="custom_email_subject" name="custom_email_options[custom_email_subject]" value="' . esc_attr($options['custom_email_subject'] ?? '') . '" />';
}

// Callback function for email message with wp_editor
function custom_email_message_callback() {
    $options = get_option('custom_email_options');
    $content = isset($options['custom_email_message']) ? $options['custom_email_message'] : '';
    $editor_id = 'custom_email_message';

    $settings = array(
        'textarea_name' => 'custom_email_options[custom_email_message]',
        'media_buttons' => false,
        'textarea_rows' => 10,
        'teeny' => true,
        'quicktags' => true,
    );

    wp_editor(wp_kses_post($content), $editor_id, $settings);
}

// Helper function to retrieve formatted email message
function get_custom_email_message() {
    $options = get_option('custom_email_options');
    $message = isset($options['custom_email_message']) ? $options['custom_email_message'] : '';
    $message = wpautop($message);
    $message = str_replace(array('<p>', '</p>', "\n"), '', $message);

    return $message;
}


add_action('wp_ajax_get_all_products_and_currency', 'get_all_products_and_currency');
add_action('wp_ajax_nopriv_get_all_products_and_currency', 'get_all_products_and_currency');

function get_all_products_and_currency() {    
    $test = get_woocommerce_currency_symbol();
    global $wp_filter;
    $filter_name = 'woocommerce_currency_symbol'; 

    if ('&#36;' == $test && isset($wp_filter[$filter_name])) {
        // remove_filter( $filter_name, array('Alg_WC_PGBC_Convert_Prices','convert_currency_symbol'),PHP_INT_MAX);
        add_filter( $filter_name, function($currency){
            return 'AED ';
        }, PHP_INT_MAX, 1 );
        $is_converted = true;
    } else {
        $is_converted = false;
    }
    $args = array(
        'post_type' => 'product',
        'posts_per_page' => -1
    );
    $products_query = new WP_Query($args);
    $products = array();        
    if ($products_query->have_posts()) {
        while ($products_query->have_posts()) {
            $products_query->the_post();
            $product = wc_get_product(get_the_ID());
            $price = $product->get_price();            
            if($is_converted){                
                $rates_value = get_option( 'alg_wc_pgbc_convert_rate' );
                $conversion_rate = $rates_value['ppcp-gateway'] ;
                $price=$price/$conversion_rate;                
            }            
            $products[] = array(
                'id' => $product->get_id(),
                'name' => $product->get_name(),
                'price' => number_format($price,2),                
                'image' => wp_get_attachment_url($product->get_image_id())
            );
        }
    }


    
    // Get the WooCommerce currency symbol without HTML encoding
    switch (get_woocommerce_currency_symbol()) {
        case 'AED':
            $currency_symbol =get_woocommerce_currency_symbol() .' ';
            break;
        default:        
            $currency_symbol = html_entity_decode(get_woocommerce_currency_symbol());            
            break;
    }
    
    wp_send_json(array(
        'products' => $products,
        'currency_symbol' => $currency_symbol, // Return as a plain string        
        'converstions' => $test,
    ));
}




function custom_filter_wpcf7_is_tel($result, $tel)
{
    $result = preg_match('/^\(?\+?([0-9]{1,4})?\)?[-\. ]?(\d{10})$/', $tel);
    return $result;
}
add_filter('wpcf7_is_tel', 'custom_filter_wpcf7_is_tel', 10, 2);

// Add a settings page to the WordPress admin
function register_export_report_settings() {
    add_options_page(
        'Export Report Data',
        'Export Report Data',
        'manage_options',
        'export-report-data',
        'export_report_data_page'
    );
}
add_action('admin_menu', 'register_export_report_settings');

// Register settings and fields
function export_report_settings_init() {
    register_setting('export_report_settings', 'image1');
    register_setting('export_report_settings', 'header_logo');
    register_setting('export_report_settings', 'image1_link');
    register_setting('export_report_settings', 'image2');
    register_setting('export_report_settings', 'image2_link');

    add_settings_section(
        'export_report_settings_section',
        'Export Report Data Settings',
        null,
        'export-report-data'
    );
    add_settings_field(
        'header_logo',
        'Header Logo',
        'export_report_header_logo_field',
        'export-report-data',
        'export_report_settings_section'
    );
    add_settings_field(
        'image1',
        'Image 1',
        'export_report_image1_field',
        'export-report-data',
        'export_report_settings_section'
    );

    add_settings_field(
        'image1_link',
        'Image 1 Link',
        'export_report_image1_link_field',
        'export-report-data',
        'export_report_settings_section'
    );
 
    add_settings_field(
        'image2',
        'Image 2',
        'export_report_image2_field',
        'export-report-data',
        'export_report_settings_section'
    );

    add_settings_field(
        'image2_link',
        'Image 2 Link',
        'export_report_image2_link_field',
        'export-report-data',
        'export_report_settings_section'
    );
}
add_action('admin_init', 'export_report_settings_init');

// Callback functions for settings fields
function export_report_image1_field() {
    $image1 = get_option('image1');
    echo '<input type="text" id="image1" name="image1" value="' . esc_url($image1) . '">';
    echo '<input type="button" id="upload_image1_button" class="button" value="Upload Image 1">';
}
function export_report_header_logo_field() {
    $header_logo = get_option('header_logo');
    echo '<input type="text" id="header_logo" name="header_logo" value="' . esc_url($header_logo) . '">';
    echo '<input type="button" id="upload_header_logo_button" class="button" value="Upload Header Logo">';
}

function export_report_image1_link_field() {
    $image1_link = get_option('image1_link');
    echo '<input type="url" name="image1_link" value="' . esc_url($image1_link) . '">';
}

function export_report_image2_field() {
    $image2 = get_option('image2');
    echo '<input type="text" id="image2" name="image2" value="' . esc_url($image2) . '">';
    echo '<input type="button" id="upload_image2_button" class="button" value="Upload Image 2">';
}

function export_report_image2_link_field() {
    $image2_link = get_option('image2_link');
    echo '<input type="url" name="image2_link" value="' . esc_url($image2_link) . '">';
}

// Display the settings page
function export_report_data_page() {
    ?>
    <div class="wrap">
        <h1>Export Report Data</h1>
        <form method="post" action="options.php">
            <?php
            settings_fields('export_report_settings');
            do_settings_sections('export-report-data');
            submit_button();
            ?>
        </form>
    </div>
    <?php
}

// Enqueue scripts for media uploader
function export_report_admin_scripts() {
    wp_enqueue_media();
    wp_enqueue_script('export-report-admin-script', get_template_directory_uri() . '/js/export-report-admin.js', array('jquery'), null, true);
}
add_action('admin_enqueue_scripts', 'export_report_admin_scripts');



function mytheme_add_woocommerce_support() {
    add_theme_support( 'woocommerce' );
  }
add_action( 'after_setup_theme', 'mytheme_add_woocommerce_support' );

add_filter('woocommerce_currency_symbol', 'change_existing_currency_symbol', 10, 2);

function change_existing_currency_symbol( $currency_symbol, $currency ) {
    switch( $currency ) {
        case 'AED': $currency_symbol = 'AED'; break;
    }
    return $currency_symbol;
}

add_action('wp_ajax_update_conversion_rate_ns', 'update_conversion_rate_ns_handler');
add_action('wp_ajax_nopriv_update_conversion_rate_ns', 'update_conversion_rate_ns_handler');

function update_conversion_rate_ns_handler() {
    $url = "https://cdn.jsdelivr.net/npm/@fawazahmed0/currency-api@latest/v1/currencies/aed.json";
    $response = wp_remote_get($url);
    if (is_wp_error($response)) {
        wp_send_json_error(['message' => 'Failed to fetch conversion rate']);
    }
    $body = wp_remote_retrieve_body($response);
    $data = json_decode($body, true);
    if (isset($data['aed']['usd'])) {
        $conversion_rate = $data['aed']['usd'];
        $rates_value = get_option( 'alg_wc_pgbc_convert_rate' );
        $rates_value['ppcp-gateway'] = number_format($conversion_rate,2);
        update_option( 'alg_wc_pgbc_convert_rate', $rates_value);
        wp_send_json_success(['rate' => number_format($conversion_rate,2)]);
    } else {
        wp_send_json_error(['message' => 'Conversion rate not available']);
    }
}

/** Update order number in the post */
add_action( 'woocommerce_new_order', 'custom_action_after_payment_success' );
function custom_action_after_payment_success( $order_id ) {    
    $order = wc_get_order( $order_id );
    if($order){
        $billing_service_id = $order->get_meta( '_billing_service_id' );
        if($billing_service_id){
            update_post_meta( $billing_service_id, 'order_number', $order_id );
        }
    }    
}
function custom_paypal_button_render(){
    return 'custom_paypal_button_render';
}
add_filter( 'woocommerce_paypal_payments_checkout_button_renderer_hook', 'custom_paypal_button_render', 10 );

function convert_usd_aed($usd){
    $rates_value = get_option( 'alg_wc_pgbc_convert_rate' );    
    $conversion_rate = $rates_value['ppcp-gateway'];       
    $aed =  (float) $usd / (float) $conversion_rate;
    $aed = round($aed);    
    return $aed ;
}

function custom_price_html($html, $price, $args, $unformatted_price, $original_price) {
    if(strpos($html, '&#36;') !== false){                
        $price2 = convert_usd_aed($original_price);               
        if($price2){
            $price2 = (int) $price2;            
            $price2 = number_format((float)$price2, 2);
        }            
        $price2 = str_replace('.',$args['decimal_separator'],$price2);
        $html = str_replace($price,$price2,$html);
        
        return str_replace('&#36;','AED', $html);            
    }
    return $html;
}
add_filter( 'wc_price', 'custom_price_html', $html, 6);


add_filter('wpcf7_form_hidden_fields', 'add_post_id_to_hidden_fields');
function add_post_id_to_hidden_fields($hidden_fields) {

    $success_page_link = get_field('success_page_link');
    if($success_page_link){
        $slug = trim(parse_url($success_page_link, PHP_URL_PATH), '/');
        $success_page_id = url_to_postid($slug);
        if($success_page_id){
            $hidden_fields['success-post-id'] = $success_page_id;
        }
    }
    
    return $hidden_fields;
}

add_filter('wpcf7_mail_components', 'add_acf_attachments_to_mail2', 10, 3);
function add_acf_attachments_to_mail2($mail_components, $contact_form, $instance) {
    if($instance->name() == 'mail_2'){
        $submission = WPCF7_Submission::get_instance();
        $data = $submission->get_posted_data();
        if (isset($data['success-post-id']) && !empty($data['success-post-id'])) {
            $attachments = get_field('upload_file',$data['success-post-id']);
            if(isset($attachments) && !empty($attachments)){
                if ( $mail_2 = $contact_form->prop( 'mail_2' ) and $mail_2['active'] ) {                                        
                    foreach ($attachments as $attachmentt) {
                        $url = $attachmentt['cv'] ? $attachmentt['cv']: null;
                        $relative_path = str_replace(content_url(), '', $url);
                        $file_path = WP_CONTENT_DIR . parse_url($relative_path, PHP_URL_PATH);
                        if (file_exists($file_path)) {
                            $mail_components['attachments'][] = $file_path;
                        }
                    }
                }        
            }
        }
    }          
    return $mail_components;
}

function get_cart_products_callback() {
    if ( ! class_exists( 'WooCommerce' ) ) {
        wp_send_json_error( 'WooCommerce is not active.' );
        return;
    }

    $cart_items = WC()->cart->get_cart();
    $products = [];

    foreach ( $cart_items as $cart_item ) {
        $product = $cart_item['data'];
        $product_id = $product->get_id();
        $product_name = $product->get_name();
        $product_price = $price = get_post_meta($product_id, '_price', true);
        $product_image_url = wp_get_attachment_url( $product->get_image_id() );

        $products[] = [
            'id'    => $product_id,
            'name'  => $product_name,
            'price' => $product_price,
            'image' => $product_image_url
        ];
    }

    wp_send_json_success( $products );
}
add_action( 'wp_ajax_get_cart_products', 'get_cart_products_callback' );
add_action( 'wp_ajax_nopriv_get_cart_products', 'get_cart_products_callback' );

function preload_style_css() {
    echo "<link rel='preload' href='" . get_template_directory_uri() . "/css/style.css' as='style' />";
}
add_action('wp_head', 'preload_style_css');