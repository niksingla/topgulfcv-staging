<?php
function enqueue_custom_scripttts() {
    global $pagenow;

    if ($pagenow === 'edit.php' && isset($_GET['post_type']) && $_GET['post_type'] === 'free_services') {
        wp_enqueue_script('custom-scripts', get_template_directory_uri() . '/js/custom-status.js', array('jquery'), null, true);
    }
}
add_action('admin_enqueue_scripts', 'enqueue_custom_scripttts');

function Free_Services_post_type()
{
    $labels = [
        "name" => _x("Free Services", "Post Type General Name", "topgulfcv"),
        "singular_name" => _x("Free", "Post Type Singular Name", "topgulfcv"),
        "menu_name" => __("Free Services", "topgulfcv"),
        "parent_item_colon" => __("Parent Free Services", "topgulfcv"),
        // 'all_items'           => __( 'All Free Services', 'topgulfcv' ),
        // 'view_item'           => __( 'View Free Services', 'topgulfcv' ),
        // 'edit_item'           => __( 'Edit Free_ Services', 'topgulfcv' ),
        "update_item" => __("Update Free_ Services", "topgulfcv"),
        "search_items" => __("Search", "topgulfcv"),
        "not_found" => __("Not Found", "topgulfcv"),
        "not_found_in_trash" => __("Not found in Trash", "topgulfcv"),
    ];
    $args = [
        "label" => __("Free Services", "topgulfcv"),
        "description" => __("Free Services", "topgulfcv"),
        "labels" => $labels,
        "supports" => ["title"],
        "taxonomies" => ["genres"],
        "hierarchical" => false,
        "public" => false,
        "show_ui" => true,
        "show_in_menu" => true,
        "show_in_nav_menus" => true,
        "show_in_admin_bar" => true,
        "menu_position" => 6,
        "menu_icon" => "dashicons-welcome-widgets-menus",
        "can_export" => true,
        "has_archive" => false,
        "exclude_from_search" => false,
        "publicly_queryable" => true,
        "map_meta_cap" => true,
        "capabilities" => [
            "create_posts" => "do_not_allow",
        ],
    ];
    register_post_type("Free_Services", $args);
}
add_action("init", "Free_Services_post_type", 0);




function custom_remove_post_title($columns)
{
    if ("free_services" === get_post_type()) {
        unset($columns["title"]);
        unset($columns["date"]);
        unset($columns["column-cf7_2_post"]);
    }
    return $columns;
}

add_filter("manage_free_services_posts_columns", "custom_remove_post_title");

// Customize the post list table row
function custom_custom_columns_content($column_name, $post_ID)
{
    if (
        "free_services" === get_post_type($post_ID) &&
        $column_name === "title"
    ) {
        echo esc_html__("No Title", "text-domain");
    }
}
add_action(
    "manage_free_services_posts_custom_column",
    "custom_custom_columns_content",
    10,
    2
);

add_filter('manage_submission_posts_columns', 'set_custom_submission_columns');


function custom_columns_contentt($column_name, $post_id)
{
    if ($column_name == "first_name1") {
        echo get_post_meta($post_id, "first_name", true);
    }

    if ($column_name == "last_name1") {
        echo get_post_meta($post_id, "last_name", true);
    }
    if ($column_name == "email11") {
        $email = get_post_meta($post_id, "email", true);
        echo $email . "</a>";
    }
    if ($column_name == "mobile") {
        echo get_post_meta($post_id, "mobile_no", true);
    }
    if ($column_name == "services") {
      echo  get_post_meta($post_id, "services", true);
    
    }
    // if ($column_name == "resume") {
    //     $uploaded_resume = get_post_meta($post_id, "uploaded_resume", true);
    //     $resume_name = basename($uploaded_resume);
    //     echo '<a href="' .
    //         esc_url($uploaded_resume) .
    //         '" target="_blank">' .
    //         esc_html($resume_name) .
    //         "</a>";
    // }
    if ($column_name == "date") {
        echo get_the_date("", $post_id) . " at " . get_the_time("", $post_id);
    }
    // if ($column_name == "responce") {
    //     $email = get_post_meta($post_id, "email", true);
    //     echo '<a href="#" class="send-email" data-id=' .
    //         $post_id .
    //         ' data-email="' .
    //         $email .
    //         '"><img src="/wp-content/uploads/2023/11/email.png" alt="Email" style="height: 45px;"></a><span data-id=' .
    //         $post_id .
    //         ' class="email-status">';
    //     $response = get_post_meta($post_id, "email_status", true);
    //     echo $response ? esc_html($response) : "Not Sent";
    //     echo "</span>";
    // }
    // if ($column_name == "message_column") {
    //     $message1 = get_post_meta($post_id, "message_column", true);
    //     $title1 = get_post_meta($post_id, "title", true); // Replace with your actual meta key for title
    //     $description1 = get_post_meta($post_id, "description", true); // Replace with your actual meta key for description
    //     if (esc_attr($message1)) {
    //         echo '<span class="message-show-box">
    //         <a href="#" class="show-message-btn"  data-message="' .
    //             esc_attr($message1) .
    //             '" data-title="' .
    //             esc_attr($title1) .
    //             '" data-description="' .
    //             esc_attr($description1) .
    //             '"><img src="/wp-content/uploads/2023/11/email.png" alt="Email" style="height: 45px;"></a>Show Message</span>';
    //     }
    // }
 // Assuming this code is within a function hooked to manage_posts_custom_column action
 }



function populate_status_column($column_name, $post_id) {
    if ($column_name == "status") {
        $current_status = get_post_meta($post_id, 'statuss', true);
        $status_options = array(
            'Pending'   => 'Pending',
            'In Review' => 'In Review',
            'Done'      => 'Done',
        );
        ?>
        <select class="statuss" name="statuss" data-postid="<?php echo $post_id; ?>">
            <?php
            foreach ($status_options as $value => $label) {
                $selected = selected($current_status, $value, false);
                echo "<option value='$value' $selected>$label</option>";
            }
            ?>
        </select>
    <?php
    }
}
add_action('manage_free_services_posts_custom_column', 'populate_status_column', 10, 2);

add_action('wpcf7_before_send_mail', 'save_form_data_to_post_meta');

function save_form_data_to_post_meta($contact_form) {
    $submission = WPCF7_Submission::get_instance();
    if ($submission) {
        $data = $submission->get_posted_data();
 
        if (!empty($data['free-service-name'])) {
            $post_id = wp_insert_post([
                'post_title' => 'Form Submission',
                'post_type' => 'free_services', 
                'post_status' => 'publish'
            ]);
            
            if ($post_id) {
                update_post_meta($post_id, 'first_name', sanitize_text_field($data['Firstname']));
                update_post_meta($post_id, 'last_name', sanitize_text_field($data['Lastname']));
                update_post_meta($post_id, 'email', sanitize_email($data['email-0']));
                update_post_meta($post_id, 'mobile_no', sanitize_text_field($data['tel-913']));
                update_post_meta($post_id, 'services', sanitize_text_field($data['free-service-name']));
            }
        }
    }
}

   
function update_post_status_callback() {
    if (isset($_POST['post_id']) && isset($_POST['new_status'])) {
        $post_id = absint($_POST['post_id']);
        $new_status = sanitize_text_field($_POST['new_status']);
        update_post_meta($post_id, 'statuss', $new_status);
    }
    die(); 
}
add_action('wp_ajax_update_post_status', 'update_post_status_callback');    


add_action("manage_free_services_posts_custom_column","custom_columns_contentt",10,2);

function custom_columns_headd($columnss)
{
    $columnss["first_name1"] = "First Name";
    $columnss["last_name1"] = "Last Name";
    $columnss["email11"] = "Email";
    $columnss["mobile"] = "Mobile";
    $columnss["services"] = "Services";
    // $columnss["resume"] = "Resume";
    $columnss["date"] = "Date";
    // $columnss["responce"] = "Response";
    // $columnss["message_column"] = "Old Response";
    $columnss["status"] = "Status";
    return $columnss;
}
add_filter("manage_free_services_posts_columns", "custom_columns_headd");


function custom_post_type_filterr() {
    global $typenow;
    if ($typenow == "free_services") {
        $args = array(
            'post_type' => 'free_services',
            'meta_key' => 'services',
            'orderby' => 'meta_value',
            'order' => 'ASC',
            'posts_per_page' => -1,
            'meta_query' => array(
                array(
                    'key' => 'services',
                    'compare' => 'EXISTS'
                )
            )
        );

        $query = new WP_Query($args);

        if ($query->have_posts()) {
            $unique_urls = array();

            echo '<select name="services_filter">';
            echo '<option value="">Select Services</option>';

            while ($query->have_posts()) {
                $query->the_post();
                $form_url = get_post_meta(get_the_ID(), 'services', true);
                $form_url = basename($form_url);
                if (!in_array($form_url, $unique_urls)) {
                    $unique_urls[] = $form_url;
                    $selected = (isset($_GET['services_filter']) && $_GET['services_filter'] == $form_url) ? ' selected="selected"' : '';
                    echo '<option value="' . esc_attr($form_url) . '"' . $selected . '>' . esc_html($form_url) . '</option>';
                }
            }

            echo '</select>';
            wp_reset_postdata();
        }
    }
}
add_action("restrict_manage_posts", "custom_post_type_filterr");

function filter_free_services_by_meta($query) {
    global $pagenow;
    $post_type = isset($_GET['post_type']) ? $_GET['post_type'] : '';
    if ($post_type == 'free_services' && $pagenow == 'edit.php' && isset($_GET['services_filter']) && $_GET['services_filter'] != '') {
        $meta_query = array(
            array(
                'key' => 'services',
                'value' => $_GET['services_filter'],
                'compare' => '='
            )
        );
        $query->set('meta_query', $meta_query);
    }
}
add_action('pre_get_posts', 'filter_free_services_by_meta');


function custom_filter_postss($query)
{
    global $typenow;
    if (
        $typenow == "free_services" &&
        isset($_GET["services"]) &&
        !empty($_GET["services"])
    ) {
        $custom_filter_value = sanitize_text_field($_GET["services"]);
        if (!empty($custom_filter_value)) {
            $query->set("meta_key", "free-service-name");
            $query->set("meta_value", $custom_filter_value);
        }
    }
}
add_filter("parse_query", "custom_filter_postss");

function custom_dashboard_widget()
{
    wp_add_dashboard_widget(
        "Free Services",
        "Free Services",
        "custom_dashboard_widget_content"
    );
}

function custom_dashboard_widget_content()
{
    $custom_post_type = "free_services";
    $total_posts = wp_count_posts($custom_post_type)->publish;
    $args = [
        "post_type" => $custom_post_type,
        "meta_query" => [
            [
                "key" => "email_status",
                "value" => "sent",
                "compare" => "=",
            ],
        ],
    ];
    $response_posts = new WP_Query($args);
    $response_count = $response_posts->found_posts;
    $unresponse_count = $total_posts - $response_count;
    echo "<p><b>Total Free Services :</b> " . $total_posts . "</p>";
    // echo "<p><b>Response :</b> " . $response_count . "</p>";
    // echo "<p><b>Unresponded :</b> " . $unresponse_count . "</p>";
    wp_reset_postdata();
}
add_action("wp_dashboard_setup", "custom_dashboard_widget");

function add_export_button() {
    global $typenow;

    if ($typenow == 'free_services') {
        $selected_service = isset($_GET['services_filter']) ? sanitize_text_field($_GET['services_filter']) : '';
        $export_url = add_query_arg(array(
            'action' => 'export_free_services',
            'services_filter' => $selected_service
        ), admin_url('admin-ajax.php'));

        ?>
        <div class="alignright actions">
            <a href="<?php echo esc_url($export_url); ?>" class="button">Export</a>
        </div>
        <?php
    }
}
add_action('restrict_manage_posts', 'add_export_button');



function export_free_services_callback() {
    $args = array(
        'post_type' => 'free_services',
        'posts_per_page' => -1,
    );

    if (isset($_GET['services_filter']) && !empty($_GET['services_filter'])) {
        $selected_service = sanitize_text_field($_GET['services_filter']);
        $args['meta_query'] = array(
            array(
                'key' => 'services',
                'value' => $selected_service,
                'compare' => '=',
            ),
        );
    }

    $query = new WP_Query($args);

    if (!$query->have_posts()) {
        header('Content-Type: text/plain');
        echo "No data available for the selected service.";
        exit();
    }

    header('Content-Type: text/csv');
    header('Content-Disposition: attachment; filename="free_services_data.csv"');
    header('Pragma: no-cache');
    header('Expires: 0');

    $output = fopen('php://output', 'w');

    fputcsv($output, array(
        'First Name',
        'Last Name',
        'Email',
        'Mobile',
        'Services',
        'Date',
        'Status',
    ));

    while ($query->have_posts()) {
        $query->the_post();

        fputcsv($output, array(
            get_post_meta(get_the_ID(), 'first_name', true),
            get_post_meta(get_the_ID(), 'last_name', true),
            get_post_meta(get_the_ID(), 'email', true),
            get_post_meta(get_the_ID(), 'mobile_no', true),
            get_post_meta(get_the_ID(), 'services', true),
            get_the_date('', get_the_ID()) . ' at ' . get_the_time('', get_the_ID()),
            get_post_meta(get_the_ID(), 'statuss', true),
        ));
    }

    fclose($output);
    wp_reset_postdata();
    exit();
}

add_action('wp_ajax_export_free_services', 'export_free_services_callback');
add_action('wp_ajax_nopriv_export_free_services', 'export_free_services_callback');


/*-------------------------------------------Add Free Post Type -----------------------------------------------------*/

function add_free_services_post_type()
{
    $labels = [
        "name" => _x("Add Free Services", "Post Type General Name", "text_domain"),
        "singular_name" => _x(
            "Add Free Services",
            "Post Type Singular Name",
            "text_domain"
        ),
        "menu_name" => __("Add Free Services", "text_domain"),
        "all_items" => __("All Add Free Services", "text_domain"),
        "view_item" => __("View Add Free Services", "text_domain"),
        "add_new_item" => __("Add New Add Free Services", "text_domain"),
        "add_new" => __("Add New", "text_domain"),
        "edit_item" => __("Edit Add Free Services", "text_domain"),
        "update_item" => __("Update Add Free Services", "text_domain"),
        "search_items" => __("Search Add Free Services", "text_domain"),
        "not_found" => __("Not Found", "text_domain"),
        "not_found_in_trash" => __("Not found in Trash", "text_domain"),
    ];

    $args = [
        "label" => __("Add Free Services", "text_domain"),
        "description" => __("Header Add Free Services", "text_domain"),
        "labels" => $labels,
        "supports" => ["title", "editor", "thumbnail", "custom-fields"],
        "hierarchical" => true,
        "public" => true, 
        "show_ui" => true,
        "show_in_menu" => true,
        "show_in_nav_menus" => true,
        "show_in_admin_bar" => true,
        "menu_icon" => "dashicons-admin-page",
        "menu_position" => 20,
        "can_export" => true,
        "has_archive" => true,
        "exclude_from_search" => true,
        "publicly_queryable" => true,
        "capability_type" => "page",
        "rewrite" => [
            "slug" => "service", 
            "with_front" => true, 
        ],
    ];

    register_post_type("add_free_services", $args);
}

add_action("init", "add_free_services_post_type", 0); 