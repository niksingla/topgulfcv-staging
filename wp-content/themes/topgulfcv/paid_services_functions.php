<?php
function enqueue_custom_scripttttts()
{
    global $pagenow;

    if (isset($_GET['post_type']) && $_GET['post_type'] === 'paid_services') {
        wp_enqueue_script('custom-scrippts', get_template_directory_uri() . '/js/paid-custom-status.js', array('jquery'), null, true);
    }
}
add_action('admin_enqueue_scripts', 'enqueue_custom_scripttttts');
function paid_Services_post_type()
{
    $labels = [
        "name" => _x("Paid Services", "Post Type General Name", "topgulfcv"),
        "singular_name" => _x("Paid", "Post Type Singular Name", "topgulfcv"),
        "menu_name" => __("Paid Services", "topgulfcv"),
        "parent_item_colon" => __("Parent paid Services", "topgulfcv"),
        "all_items" => __("All paid Services", "topgulfcv"),
        "view_item" => __("View paid Services", "topgulfcv"),
        // 'add_new_item'        => __( 'Add New paid_ Services', 'topgulfcv' ),
        // 'add_new'             => __( 'Add New', 'topgulfcv' ),
        "edit_item" => __("Edit paid Services", "topgulfcv"),
        "update_item" => __("Update paid Services", "topgulfcv"),
        "search_items" => __("Search", "topgulfcv"),
        "not_found" => __("Not Found", "topgulfcv"),
        "not_found_in_trash" => __("Not found in Trash", "topgulfcv"),
    ];
    $args = [
        "label" => __("paid Services", "topgulfcv"),
        "description" => __("paid Services", "topgulfcv"),
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
    register_post_type("paid_Services", $args);
}
add_action("init", "paid_Services_post_type", 0);

function customm_remove_post_title($columns)
{
    if ("paid_services" === get_post_type()) {
        unset($columns["title"]);
        unset($columns["date"]);
    }
    return $columns;
}

add_filter("manage_paid_services_posts_columns", "customm_remove_post_title");

function custom_custom_columns_contentt($column_name, $post_ID)
{
    if (
        "paid_services" === get_post_type($post_ID) &&
        $column_name === "title"
    ) {
        echo esc_html__("No Title", "text-domain");
    }
}
add_action(
    "manage_paid_services_posts_custom_column",
    "custom_custom_columns_contentt",
    10,
    2
);

function remove_add_new_free_services()
{
    remove_submenu_page(
        "edit.php?post_type=free_services",
        "post-new.php?post_type=free_services"
    );
    remove_submenu_page(
        "edit.php?post_type=paid_services",
        "post-new.php?post_type=paid_services"
    );
}
add_action("admin_menu", "remove_add_new_free_services");

function custom_columns_head($columns)
{
    $columns["first_name"] = "First Name";
    $columns["last_name"] = "Last Name";
    $columns["email1"] = "Email";
    $columns["city"] = "City";
    $columns["country"] = "Country";
    $columns["amount1"] = "Amount";
    $columns["order-no"] = "Order Number";
    $columns["payment-method"] = "Payment Method";
    $columns["service1"] = "Services";
    $columns["date1"] = "Date";
    $columns["sendreport"] = "Report";
    $columns["message11"] = "Sent Emails";
    $columns["responce"] = "Email";
    $columns["status11"] = "Status";

    return $columns;
}
add_filter("manage_paid_services_posts_columns", "custom_columns_head");

function enqueue_pdfhtml_scripts()
{
    wp_enqueue_script('pdfhtmlmake', 'https://cdnjs.cloudflare.com/ajax/libs/html2pdf.js/0.9.2/html2pdf.bundle.min.js', array(), '0.9.2', true);
    wp_enqueue_script('html2s', 'https://html2canvas.hertzen.com/dist/html2canvas.min.js', array('pdfmake'), '0.1.68', true);
}

add_action('admin_enqueue_scripts', 'enqueue_pdfhtml_scripts');


function add_custom_row_classes($classes, $class, $post_id) {
    if ('paid_services' == get_post_type($post_id)) {
        $order_id = $post_id ? get_post_meta( $post_id, 'order_number', true ) : '-';

        if ($order_id) {
            $order = wc_get_order($order_id);
        
            $status = $order->get_status();
            if(in_array($status,['processing','completed'])){
                $product_name = true;
            }
            // if ($order) {
            //     foreach ($order->get_items() as $item_id => $item) {
            //         $product_name = $item->get_name();
            //     }
            // } 
        }         
        if (!$product_name) {
            $classes[] = 'no-payment-method';
        }
    }    
    return $classes;
}
add_filter('post_class', 'add_custom_row_classes', 10, 3);

function hide_no_payment_method_rows() {
    echo '<style>
        .no-payment-method {
            display: none;
        }
    </style>';
}
add_action('admin_head', 'hide_no_payment_method_rows');


function custom_columns_content($column_name, $post_id)
{    
    $email = get_post_meta($post_id, "email", true);
    $user = get_user_by('email', $email);
    // $payment_method = $user ? get_user_meta($user->ID, '_payment_method', true) : false;
    $order_number = get_post_meta( $post_id, 'order_number', true );
    if($order_number){
        $order_payment_method = get_post_meta( $order_number, '_payment_method_title', true );
    } else {
        $order_payment_method = get_post_meta( $post_id+1, '_payment_method_title', true );
    }
    $payment_method = $order_payment_method ? $order_payment_method : false;    
    if ($column_name == "payment-method") {
        if ($payment_method) {
            echo $payment_method;
        } else {
            echo '-';
        }
    }
    if ($column_name == "first_name") {
        echo get_post_meta($post_id, "first_name11", true);
    }
    if ($column_name == "last_name") {
        echo get_post_meta($post_id, "last_name11", true);
    }
    if ($column_name == "email1") {
        echo get_post_meta($post_id, "email", true);
    }
    if ($column_name == "city") {
        echo get_post_meta($post_id, "city11", true);
    }
    if ($column_name == "country") {
        echo get_post_meta($post_id, "country11", true);
    }
    if ($column_name == "amount1") {
        echo get_post_meta($post_id, "amount", true);
    }
    if ($column_name == "order-no") {
        echo $post_id ? $post_id+1 : '-';
        // $email = get_post_meta($post_id, "email", true);
        // $user = get_user_by('email', $email);
        // if ($user) {
        //     $order_number = get_user_meta($user->ID, '_order_number', true);
        //     echo $order_number ? $order_number : '-';
        // } else {
        //     echo '-';
        // }
  

    }
   
    $selected_services = get_post_meta($post_id, "selected_services", true);
    if ($column_name == "service1") {
        // $echo = $selected_services;
        $order_id = $post_id ? $post_id+1 : '-';

        if ($order_id) {
            $order = wc_get_order($order_id);
        
            if ($order) {
                foreach ($order->get_items() as $item_id => $item) {
                    $product_name = $item->get_name();
                    echo $product_name . ',';
                }
            } 
        } 
        $uploaded_resume = get_post_meta($post_id, "uploaded_resume", true);
        if ($uploaded_resume) {
            $echo .= '<br><strong>Resume</strong>: <a href="' . $uploaded_resume . '" target="_blank">' . basename($uploaded_resume) . '</a>';
        }
    }
    if ($column_name == "date1") {
        echo get_the_date("", $post_id) . " at " . get_the_time("", $post_id);
    }
    if ($column_name == "sendreport" && strpos($selected_services, "CV/Resume Analysis") !== false) {
        $edit_page_url = admin_url('post.php?post=' . $post_id . '&action=edit');
        $send_report_url = $edit_page_url . '&send_email=true';
        $username = get_post_meta($post_id, 'cv_report_name', true);
        $image_resume = get_post_meta($post_id, "cv_report_image", true);
        // $logo_path = 'https://topgulfcv.com/wp-content/uploads/2024/03/topgulf.png';
      
        // $logo_data_url = 'data:image/png;base64,' . base64_encode(file_get_contents($logo_path));
        $image1_path = get_option('image1');
        $logo_path = get_option('header_logo');
        // $image1_data_url = 'data:image/png;base64,' . base64_encode(file_get_contents($image1_path));
        $image1_link = get_option('image1_link');

        $image2_path = get_option('image2');
        // $image2_data_url = 'data:image/png;base64,' . base64_encode(file_get_contents($image2_path));
        $image2_link = get_option('image2_link');
        ?>

        
    <script>

        function getBase64Image(img) {
            var canvas = document.createElement("canvas");
            canvas.width = img.width;
            canvas.height = img.height;
            var ctx = canvas.getContext("2d");
            ctx.drawImage(img, 0, 0);
            var dataURL = canvas.toDataURL("image/png");
            return dataURL.replace(/^data:image\/?[A-z]*;base64,/);
        }
        function imageToBase64(url, callback) {
            // Create a new image element
            let img = new Image();
            // Set crossOrigin to Anonymous to avoid CORS issues
            img.crossOrigin = 'Anonymous';
            
            // Once the image has loaded
            img.onload = function() {
                // Create a canvas element
                let canvas = document.createElement('canvas');
                // Set canvas dimensions to the image dimensions
                canvas.width = img.width;
                canvas.height = img.height;

                // Draw the image on the canvas
                let ctx = canvas.getContext('2d');
                ctx.drawImage(img, 0, 0);

                // Get the data URL of the image in base64 format
                let dataURL = canvas.toDataURL('image/png');
                console.log(dataURL);    
                // Remove the "data:image/png;base64," part to get the raw base64 string
                let base64String = dataURL.replace(/^data:image\/(png|jpg);base64,/, '');
                console.log(base64String);    
                
                // Call the callback function with the base64 string
                callback(base64String);
            };

            // Set the image source to start loading
            img.src = url;
        }

        function imageToBase64zz(url, callback) {
            fetch(url)
            .then((response) => response.blob())
            .then((blob) => {
            const reader = new FileReader();
            reader.readAsDataURL(blob);
            reader.onloadend = () => {
                    const base64String = reader.result;
                    callback(base64String);
                };
            });
        }
        function getDataUri(url)
        {
            return new Promise(resolve => {
                var image = new Image();
                image.setAttribute('crossOrigin', 'anonymous'); //getting images from external domain

                image.onload = function () {
                    var canvas = document.createElement('canvas');
                    canvas.width = this.naturalWidth;
                    canvas.height = this.naturalHeight; 

                    //next three lines for white background in case png has a transparent background
                    var ctx = canvas.getContext('2d');
                    ctx.fillStyle = '#fff';  /// set white fill style
                    ctx.fillRect(0, 0, canvas.width, canvas.height);

                    canvas.getContext('2d').drawImage(this, 0, 0);

                    resolve(canvas.toDataURL('image/png'));
                };

                image.src = url;
            })
        }
        // var base64 = getBase64Image(document.getElementById("imageid"));

        async function downloadPdf_<?php echo $post_id; ?>(username) {
            let logo = await getDataUri('<?php echo $logo_path; ?>'); 
            let img = await getDataUri('<?php echo $image1_path; ?>');        
            let img2 = await getDataUri('<?php echo $image2_path; ?>');  
            var docDefinition = {
                                    styles: {
                                        customClass1: {
                                            'border-radius': '10px' // Use quotes around the property name
                                        }
                                    }
                                };
            var content = [
                {
                    image:logo,
                    width: 150,
                    alignment: "center",
                    margin: [0, 0, 0, 10]
                },
                { text: { bold: true, text: "Name: " + username }, alignment: "center", margin: [0, 0, 0, 10] },
                <?php if ($image_resume) {
                    $image_data_url = 'data:image/png;base64,' . base64_encode(file_get_contents($image_resume));
                    echo '{ image: \'' . $image_data_url . '\', width: 100, margin: [0, 10, 0, 10] },';
                } ?>
                { text: { bold: true, text: "Introduction:" }, margin: [0, 10, 0, 5] },
                { text: '<?php echo esc_js(get_field('field_65ba0615b424a', $post_id)); ?>', margin: [0, 0, 0, 10] },
                { text: { bold: true, text: "Summary:" }, margin: [0, 10, 0, 5] },
                { text: '<?php echo esc_js(get_field('field_65ba0eb9a48c9', $post_id)); ?>', margin: [0, 0, 0, 10] },
                { text: { bold: true, text: "Profile Summary:" }, margin: [0, 10, 0, 5] },
                { text: '<?php echo esc_js(get_field('field_65cb011b6a30f', $post_id)); ?>', margin: [0, 0, 0, 10] },
                { text: { bold: true, text: "Current:" }, margin: [0, 10, 0, 5] },
                { text: '<?php echo esc_js(get_field('field_65cb01546a311', $post_id)); ?>', margin: [0, 0, 0, 10] },
                { text: { bold: true, text: "Past:" }, margin: [0, 10, 0, 5] },
                { text: '<?php echo esc_js(get_field('field_65cb013a6a310', $post_id)); ?>', margin: [0, 0, 0, 10] },
                { text: { bold: true, text: "Education:" }, margin: [0, 10, 0, 5] },
                { text: '<?php echo esc_js(get_field('field_65cb01676a312', $post_id)); ?>', margin: [0, 0, 0, 10] },
                { text: { bold: true, text: "Picture, Images Logos & Icons:" }, margin: [0, 10, 0, 5] },
                { text: '<?php echo esc_js(get_field('field_65bb6a90ae963', $post_id)); ?>', margin: [0, 0, 0, 10] },
                { text: { bold: true, text: "Layout, Design, Structure & Format:" }, margin: [0, 10, 0, 5] },
                { text: '<?php echo esc_js(get_field('field_65bb7dd48e573', $post_id)); ?>', margin: [0, 0, 0, 10] },
                { text: { bold: true, text: "Content, Length & Size:" }, margin: [0, 10, 0, 5] },
                { text: '<?php echo esc_js(get_field('field_65bb7f816f3e3', $post_id)); ?>', margin: [0, 0, 0, 10] },
                { text: { bold: true, text: "Spelling & Grammar:" }, margin: [0, 10, 0, 5] },
                { text: '<?php echo esc_js(get_field('field_65bb7fb46f3e4', $post_id)); ?>', margin: [0, 0, 0, 10] },
                { text: { bold: true, text: "Font, Consistency & Chronology:" }, margin: [0, 10, 0, 5] },
                { text: '<?php echo esc_js(get_field('field_65bb7fd16f3e5', $post_id)); ?>', margin: [0, 0, 0, 10] },
                { text: { bold: true, text: "Keywords:" }, margin: [0, 10, 0, 5] },
                { text: '<?php echo esc_js(get_field('field_65bb7ff26f3e6', $post_id)); ?>', margin: [0, 0, 0, 10] },
                { text: { bold: true, text: "Keyword & Value: " }, margin: [0, 10, 0, 5], style: "subfield" },
                <?php if (have_rows('field_65c9c3f8e9486', $post_id)) {
                    while (have_rows('field_65c9c3f8e9486', $post_id)) {
                        the_row();
                        $sub_field1 = get_sub_field('keyword11');
                        $sub_field2 = get_sub_field('value');
                        echo '{ text: \'' . esc_js($sub_field1) . '   ' . esc_js($sub_field2) . '\', margin: [0, 0, 0, 10], style: "subfield" },';
                    }
                } ?>
                { text: { bold: true, text: "Bullets & Detail:" }, margin: [0, 10, 0, 5] },
                { text: '<?php echo esc_js(get_field('field_65bb80106f3e7', $post_id)); ?>', margin: [0, 0, 0, 10] },
                { text: { bold: true, text: "Conclusion (Recommendation & Next Steps):" }, margin: [0, 10, 0, 5] },
                { text: '<?php echo esc_js(get_field('field_65bb80326f3e8', $post_id)); ?>', margin: [0, 0, 0, 10] },      
                {
                columns: [
                    {
                        stack: [
                            {
                                image: img,
                                width: 220,
                                link: '<?php echo $image1_link; ?>',
                                margin: [15, 15, 15, 15], 
                                style: 'customClass1'
                            }
                        ]
                    },
                    {
                        stack: [
                            {
                                image: img2,
                                width: 220,
                                link: '<?php echo $image2_link; ?>',
                                margin: [15, 15, 15, 15],
                                style: 'customClass1' 
                            }
                        ]
                    }

                ]
            }


            ];

            var docDefinition = {
                content: content,
                styles: {
                    header: { fontSize: 18, bold: true }
                }
            };

            pdfMake.createPdf(docDefinition).download(username + "_report.pdf");
        }
    </script>

    <?php
        $status_update = get_post_meta($post_id, 'status-update', true);
        $status_done = get_post_meta($post_id, 'status-done', true);
        $button_text = ($status_update === 'In Review' || $status_update === 'Done') ? 'View Report' : 'Create Report';

        echo '<a href="' . esc_url($send_report_url) . '" class="button" id="sendReportButton"> ' . $button_text . '</a>';
        if ($status_update === 'In Review' || $status_update === 'Done') {
            echo '<button class="button" id="exportPdfButton" onclick="event.preventDefault(); downloadPdf_' . $post_id . '(\'' . esc_js($username) . '\')">Export Report</button>';
        }
        $expireTimestamp = get_post_meta($post_id, 'expiration_timestamp', true);
        $remainingTime = $expireTimestamp - current_time('timestamp');
        if ($status_done === 'Done') {
            if ($remainingTime > 0) {
                $remainingDays = ceil($remainingTime / (24 * 60 * 60));
                $remainingTimeDisplay = $remainingDays . ' days';
                echo '<p>Expires in: ' . esc_html($remainingTimeDisplay) . '</p>';
            } else {
                $remainingTimeDisplay = ' ';
                echo '<div class="extendLinkContainer">';
                echo '<button class="button extendLinkButton">Report Expired</button>';
                echo '<div class="extendLinkForm" style="display:none;">';
                echo '<span class="closeButton" onclick="closeExtendForm()">×</span>';
                echo '<label for="extended_days">Extend link until: </label>';
                echo '<input type="text" class="calendar" name="selected_date">';
                echo '<input type="hidden" name="post_id" value="' . esc_attr($post_id) . '">';
                echo '<input type="button" data-post_id ="' . esc_attr($post_id) . '" class="doneButton button" value="Extend">';
                echo '</div>';
                echo '</div>';
                echo '<style>
            .sendreport .button {
                width: 100px;
                margin-bottom: 10px;
            }
            input.doneButton {

               height: 30px;
               line-height: 27px;
            }
            .extendLinkForm input {
                width: 100px;
                margin: 5px 0;
            }
            .extendLinkForm {
                width: 100px;
                display: inline-block;
                margin-top: -5px;
                position: relative;
            }

            span.closeButton {
                position: absolute;
                right: -24px;
                top: 0px;
                font-size: 20px;
                background: #000;
                line-height: 20px;
                height: 26px;
                padding: 0 6px;
                border-radius: 100px;
                color: #fff;
            }
            </style>';
                ?>
<script>
function closeExtendForm() {
    jQuery('.extendLinkForm').hide();
}
</script>
<?php
}
        }
        echo $export_pdf_script;
    }

    if (isset($echo)) {
        echo $echo;
    }

    if ($column_name == "responce") {
        $email = get_post_meta($post_id, "email", true);

        echo '<a href="#" class="send-email" data-id=' . $post_id . ' data-email="' . $email . '"><img src="/wp-content/uploads/2023/11/email.png" alt="Email" style="height: 45px;"></a><span data-id=' . $post_id . ' class="email-status">';
        // $response = get_post_meta($post_id, "email_status", true);
        // if (get_post_meta($post_id, 'status-update', true) == 'Done') {
        //     echo 'Sent';
        // } else {
        //     echo $response ? esc_html($response) : "Not Sent";
        // }
        echo "</span>";

        echo " ";
    }

    if ($column_name == "message11") {
        $message1 = get_post_meta($post_id, "message_column", true);
        $title1 = get_post_meta($post_id, "title", true);
        $description1 = get_post_meta($post_id, "description", true);
        $report_msgs = get_post_meta($post_id, "report_messages", true);

        if (!empty($report_msgs) || !empty($message1) || !empty($title1) || !empty($description1)) {
            echo '<span class="message-show-box"><a href="#" class="show-message-btn"  data-message="' . esc_attr($message1) . '" data-title="' . esc_attr($title1) . '" data-description="' . esc_attr($description1) . '" data-report-message="' . esc_attr(json_encode($report_msgs)) . '" ><img src="/wp-content/uploads/2023/11/email.png" alt="Email" style="height: 45px;"></a></span>';
        }
        echo " ";
    }

    if ($column_name == "status11") {
        $dynamic_options = get_post_meta($post_id, 'status-options-meta', true);
        $status_options = empty($dynamic_options) ? [
            "pending" => "Pending",
            "In Review" => "In Review",
            "Done" => "Done",
        ] : $dynamic_options;

        $status = get_post_meta($post_id, "status-update", true);
        $default_status = empty($status) ? 'pending' : $status;
        echo '<select class="status-select" name="status11" data-postid="' . esc_attr($post_id) . '">';
        if (!empty($status) && !array_key_exists($status, $status_options)) {
            echo '<option value="' . esc_attr($status) . '" selected>' . esc_html($status) . '</option>';
        }

        foreach ($status_options as $option_value => $option_label) {
            $selected = selected($default_status, $option_value, false);
            echo '<option value="' . esc_attr($option_value) . '" ' . $selected . '>' . esc_html($option_label) . '</option>';
        }
        echo '</select>';
    }


}
add_action("manage_paid_services_posts_custom_column", "custom_columns_content", 10, 2);

function update_paid_post_status_callbacck()
{
    if (isset($_POST['post_id']) && isset($_POST['new_status'])) {
        $post_id = absint($_POST['post_id']);
        $new_status = sanitize_text_field($_POST['new_status']);
        update_post_meta($post_id, 'status-update', $new_status);
    }
    die();
}
add_action('wp_ajax_update_paid_post_status', 'update_paid_post_status_callbacck');

function custom_post_type_filter()
{
    global $typenow;
    $post_type = 'paid_services';

    if ($typenow == $post_type) {
        global $typenow;
        if ($typenow == "paid_services") {
            $args = array(
                'post_type' => 'paid_services',
                'meta_key' => 'selected_services',
                'orderby' => 'meta_value',
                'order' => 'ASC',
                'posts_per_page' => -1,
                'meta_query' => array(
                    'relation' => 'OR',
                    array(
                        'key' => 'selected_services',
                        'compare' => 'EXISTS',
                    ),
                ),
            );

            $query = new WP_Query($args);

            if ($query->have_posts()) {
                $unique_services = array();

                echo '<select name="services">
                        <option value="">Select Services</option>';

                while ($query->have_posts()) {
                    $query->the_post();
                    $services = get_post_meta(get_the_ID(), 'selected_services', true);
                    $services_array = array_map('trim', explode(',', $services));
                    foreach ($services_array as $service) {
                        if (!empty($service) && !in_array($service, $unique_services)) {
                            $unique_services[] = $service;
                        }
                    }
                }
                foreach ($unique_services as $service) {
                    echo '<option value="' . esc_attr($service) . '">' . esc_html($service) . '</option>';
                }

                echo '</select>';
                wp_reset_postdata();
            }
        }
        echo '<div class="alignright">
        <a href="#" id="export-button" class="button">Export</a> </div>';
        ?>
<script>
jQuery(document).ready(function($) {
    $('#export-button').on('click', function(e) {
        e.preventDefault();
        var selectedService = $('[name="services"]').val();
        var urlParams = new URLSearchParams(window.location.search);
        var filterParam = urlParams.get('services');
        if (selectedService !== "") {
            console.log('Exporting filtered posts...');
            var exportUrl =
            '<?php echo admin_url('admin-ajax.php?action=export_paid_services_csv'); ?>';
            exportUrl += '&services=' + encodeURIComponent(selectedService);
            window.location.href = exportUrl;
        } else if (filterParam !== null) {
            console.log('Exporting filtered posts (from URL)...');
            var exportUrl =
            '<?php echo admin_url('admin-ajax.php?action=export_paid_services_csv'); ?>';
            exportUrl += '&services=' + encodeURIComponent(filterParam);
            window.location.href = exportUrl;
        } else {
            window.location.href =
                '<?php echo admin_url('admin-ajax.php?action=export_paid_services_csv'); ?>';
        }
    });
});
</script>





<?php
}
}

add_action('restrict_manage_posts', 'custom_post_type_filter');

function filter_custom_post_type_by_service($query)
{
    global $pagenow, $typenow;
    $post_type = 'paid_services';
    if ($typenow == $post_type && $pagenow == 'edit.php' && isset($_GET['services']) && $_GET['services'] != '') {
        $selected_service = sanitize_text_field($_GET['services']);
        $meta_query = array(
            'relation' => 'OR',
            array(
                'key' => 'selected_services',
                'value' => $selected_service,
                'compare' => 'LIKE',
            ),
            array(
                'key' => 'selected_services',
                'value' => ',' . $selected_service,
                'compare' => 'LIKE',
            ),
            array(
                'key' => 'selected_services',
                'value' => $selected_service . ',',
                'compare' => 'LIKE',
            ),
            array(
                'key' => 'selected_services',
                'value' => ',' . $selected_service . ',',
                'compare' => 'LIKE',
            ),
        );
        $query->set('meta_query', $meta_query);
    }
}
add_filter('parse_query', 'filter_custom_post_type_by_service');

function custom_dashboard_widgett()
{
    wp_add_dashboard_widget(
        "Paid Services",
        "Paid Services",
        "custom_dashboard_widget_contentt"
    );
}

function custom_dashboard_widget_contentt()
{
    $custom_post_typet = "paid_services";
    $total_postst = wp_count_posts($custom_post_typet)->draft;
    $args = [
        "post_type" => $custom_post_typet,
        "meta_query" => [
            [
                "key" => "email_status",
                "value" => "sent",
                "compare" => "=",
            ],
        ],
    ];
    $response_postst = new WP_Query($args);
    $response_countt = $response_postst->found_posts;
    $unresponse_countt = $total_postst - $response_countt;
    echo "<p><b>Total Paid Services :</b> " . $total_postst . "</p>";
    echo "<p><b>Response :</b> " . $response_countt . "</p>";
    echo "<p><b>Unresponded :</b> " . $unresponse_countt . "</p>";
    wp_reset_postdata();
}

add_action("wp_dashboard_setup", "custom_dashboard_widgett");

function export_paid_services_csv()
{
    $meta_query = array();

    if (isset($_GET['services']) && $_GET['services'] != '') {
        $selected_service = sanitize_text_field($_GET['services']);
        $meta_query = array(
            'relation' => 'OR',
            array(
                'key' => 'selected_services',
                'value' => $selected_service,
                'compare' => 'LIKE',
            ),
            array(
                'key' => 'selected_services',
                'value' => ',' . $selected_service,
                'compare' => 'LIKE',
            ),
            array(
                'key' => 'selected_services',
                'value' => $selected_service . ',',
                'compare' => 'LIKE',
            ),
            array(
                'key' => 'selected_services',
                'value' => ',' . $selected_service . ',',
                'compare' => 'LIKE',
            ),
        );
    }

    $args = array(
        'post_type' => 'paid_services',
        'posts_per_page' => -1,
        'meta_query' => $meta_query,
    );

    $query = new WP_Query($args);

    header('Content-Type: text/csv');
    header('Content-Disposition: attachment; filename="paid_services_export.csv"');
    header('Pragma: no-cache');
    header('Expires: 0');

    $output = fopen('php://output', 'w');
    fputcsv($output, array(
        'First Name',
        'Last Name',
        'Email',
        'City',
        'Country',
        'Amount',
        'Services',
        'Date',
        'Response',
        'status',
    ));

    while ($query->have_posts()) {
        $query->the_post();
        $row = array(
            sanitize_text_field(wp_kses(get_post_meta(get_the_ID(), "first_name11", true), '')),
            sanitize_text_field(wp_kses(get_post_meta(get_the_ID(), "last_name11", true), '')),
            sanitize_email(wp_kses(get_post_meta(get_the_ID(), "email", true), '')),
            sanitize_text_field(wp_kses(get_post_meta(get_the_ID(), "city11", true), '')),
            sanitize_text_field(wp_kses(get_post_meta(get_the_ID(), "country11", true), '')),
            floatval(wp_kses(get_post_meta(get_the_ID(), "amount", true), '')),
            sanitize_text_field(wp_kses(get_post_meta(get_the_ID(), "selected_services", true), '')),
            get_the_date("", get_the_ID()) . " at " . get_the_time("", get_the_ID()),
            sanitize_text_field(wp_kses(get_post_meta(get_the_ID(), "email_status", true), '')),
            sanitize_text_field(wp_kses(get_post_meta(get_the_ID(), "status-update", true), '')),
        );

        fputcsv($output, $row);
    }

    fclose($output);
    wp_reset_postdata();
    die();
}
add_action('wp_ajax_export_paid_services_csv', 'export_paid_services_csv');
add_action('wp_ajax_nopriv_export_paid_services_csv', 'export_paid_services_csv');

function enqueue_pdfmake_scripts()
{
    wp_enqueue_script('pdfmake', 'https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.68/pdfmake.min.js', array(), '0.1.68', true);
    wp_enqueue_script('vfs_fonts', 'https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.68/vfs_fonts.js', array('pdfmake'), '0.1.68', true);
}

add_action('admin_enqueue_scripts', 'enqueue_pdfmake_scripts');

function custom_post_type_meta_box()
{
    add_meta_box(
        'custom_image_meta_box',
        'Profile Image',
        'render_custom_image_meta_box',
        'paid_services',
        'side',
        'default'
    );
}
add_action('add_meta_boxes', 'custom_post_type_meta_box');
function render_custom_image_meta_box()
{
    global $post;
    $post_id = $post->ID;
    $custom_image = get_post_meta($post_id, 'cv_report_image', true);
    ?>

<p id="custom-image-preview">
    <?php if (!empty($custom_image)): ?>
    <img src="<?php echo esc_url($custom_image); ?>" alt="Profile Image" style="max-width: 100%; height: auto;">
    <?php else: ?>
    <em>No profile image found</em>
    <?php endif;?>
</p>
<p>
    <label for="upload-button">Upload Image:</label>
    <input type="button" id="upload-button" class="button" value="Select Image">
    <input type="hidden" id="cv_report_image_manually_selected" name="cv_report_image_manually_selected" value="">
    <input type="hidden" id="cv_report_image" name="cv_report_image" value="<?php echo esc_attr($custom_image); ?>">
</p>
<p>
    <label for="remove-image-button">Remove Image:</label>
    <input type="button" id="remove-image-button" class="button" value="Remove Image">
</p>

<script>
jQuery(document).ready(function($) {
    var mediaUploader;

    $('#upload-button').click(function(e) {
        e.preventDefault();
        if (mediaUploader) {
            mediaUploader.open();
            return;
        }
        mediaUploader = wp.media.frames.file_frame = wp.media({
            title: 'Choose Image',
            button: {
                text: 'Choose Image'
            },
            multiple: false
        });
        mediaUploader.on('select', function() {
            var attachment = mediaUploader.state().get('selection').first().toJSON();
            var oldImageUrl = $('#cv_report_image').val();
            $('#cv_report_image').val(attachment.url);
            $('#custom-image-preview').html('<img src="' + attachment.url +
                '" alt="Profile Image" style="max-width: 100%; height: auto;">');
            if (oldImageUrl !== attachment.url) {

                var data = {
                    action: 'update_cv_report_image',
                    post_id: $('#post_ID').val(),
                    new_image_url: attachment.url,
                };

                $.post(ajaxurl, data, function(response) {
                    console.log(response);
                });
            }
        });
        mediaUploader.open();
    });

    $('#remove-image-button').click(function(e) {
        e.preventDefault();
        $('#cv_report_image').val('');

        $('#custom-image-preview').html('<em>No profile image found</em>');

        // Update post meta to remove the image
        var data = {
            action: 'update_cv_report_image',
            post_id: $('#post_ID').val(),
            new_image_url: '',
        };

        $.post(ajaxurl, data, function(response) {
            console.log(response);
        });
    });
});
</script>

<?php
}

function remove_cv_report_image()
{
    $post_id = $_POST['post_id'];
    delete_post_meta($post_id, 'cv_report_image');
    echo 'Image removed successfully';
    wp_die();
}

add_action('wp_ajax_remove_cv_report_image', 'remove_cv_report_image');

function update_cv_report_image()
{
    $post_id = isset($_POST['post_id']) ? intval($_POST['post_id']) : 0;
    $new_image_url = isset($_POST['new_image_url']) ? esc_url($_POST['new_image_url']) : '';
    $current_image = get_post_meta($post_id, 'cv_report_image', true);
    update_post_meta($post_id, 'cv_report_image', $new_image_url);
    echo 'Image updated successfully';
 
    wp_die();
}

add_action('wp_ajax_update_cv_report_image', 'update_cv_report_image');

add_action('load-post.php', 'add_custom_button_to_edit_page');
function add_custom_button_to_edit_page()
{global $post, $pagenow;

    if ($pagenow == 'post.php' && $_GET['post']) {
        $post_type = get_post_type($_GET['post']);
        if ($post_type == 'paid_services') {
            $post_id = $_GET['post'];
            $newValue = get_post_meta($post_id, 'cv_report_name', true);
            update_field('field_65cdbfd61089e', $newValue, $post_id);
            $field1_values = get_post_meta($post_id, 'all_keyword1_values', true);
            $field2_values = get_post_meta($post_id, 'all_value1_values', true);
            $introduction_values = get_post_meta($post_id, 'introduction', true);
            update_field('field_65ba0615b424a', $introduction_values, $post_id);
            $summary_values = get_post_meta($post_id, 'summary', true);
            update_field('field_65ba0eb9a48c9', $summary_values, $post_id);

            $group_field_data = get_field('field_65cb01086a30e', $post_id);
            $group_field_data['field_65cb011b6a30f'] = get_post_meta($post_id, 'full_name', true);
            $group_field_data['field_65cb01546a311'] = get_post_meta($post_id, 'current', true);
            $group_field_data['field_65cb013a6a310'] = get_post_meta($post_id, 'past', true);
            $group_field_data['field_65cb01676a312'] = get_post_meta($post_id, 'education', true);
            update_field('field_65cb01086a30e', $group_field_data, $post_id);

            $picture_values = get_post_meta($post_id, 'picture', true);
            update_field('field_65bb6a90ae963', $picture_values, $post_id);
            $layout_values = get_post_meta($post_id, 'layout', true);
            update_field('field_65bb7dd48e573', $layout_values, $post_id);
            $content_length_values = get_post_meta($post_id, 'content_length', true);
            update_field('field_65bb7f816f3e3', $content_length_values, $post_id);
            $spelling_grammer_values = get_post_meta($post_id, 'spelling_grammer', true);
            update_field('field_65bb7fb46f3e4', $spelling_grammer_values, $post_id);
            $font_constent_values = get_post_meta($post_id, 'font_constent', true);
            update_field('field_65bb7fd16f3e5', $font_constent_values, $post_id);
            $keyword_values = get_post_meta($post_id, 'keyword', true);
            update_field('field_65bb7ff26f3e6', $keyword_values, $post_id);
            $bullet_details_values = get_post_meta($post_id, 'bullet_details', true);
            update_field('field_65bb80106f3e7', $bullet_details_values, $post_id);
            $concolustion_values = get_post_meta($post_id, 'concolustion', true);
            update_field('field_65bb80326f3e8', $concolustion_values, $post_id);
            $new_repeater_field = array();
            if (!empty($field1_values) && !empty($field2_values) && count($field1_values) === count($field2_values)) {
                $num_pairs = count($field1_values);
                for ($i = 0; $i < $num_pairs; $i++) {
                    if (!empty($field1_values[$i]) && !empty($field2_values[$i])) {
                        $new_repeater_field[] = array(
                            'field_65c9c44fe9487' => $field1_values[$i],
                            'field_65c9c45be9488' => $field2_values[$i],
                        );
                    }
                }
            }
            update_field('field_65c9c3f8e9486', $new_repeater_field, $post_id);
            $uploaded_resume = get_post_meta($post_id, "uploaded_resume", true);
            if ($uploaded_resume && !get_post_meta($post_id, 'python_name', true) && !get_post_meta($post_id, 'python_image', true)) {
                $status_update = get_post_meta($post_id, 'status-update', true);
                
                $resumefile = wp_upload_dir()['basedir'] . '/' . basename($uploaded_resume);
                $resumeBase = basename($uploaded_resume);
                
                $python_script_path = __DIR__ . '/name.py';
                
                $command = "python3 $python_script_path $resumeBase";
                
                $python_output = shell_exec($command);
                // print_r($python_output);
                // exit;
                
                $result = json_decode($python_output);
                if ($result->status == 'success') {
                    $candidate_name = $result->data->candidate_name;
                    // $arrPostData = [
                    //     'cv_report_name' => $candidate_name,
                    //     'python_name' => true,
                    // ];
                    update_post_meta($post_id, 'cv_report_name', $candidate_name);
                    update_post_meta($post_id, 'python_name', true);
                    if ($result->data->extracted_images) {
                        $candidate_image = $result->data->extracted_images[0]->filename;

                        $candidate_image = site_url() . '/wp-content/uploads/cvs/images/' . $candidate_image;
                        // $arrPostData['cv_report_image'] = $candidate_image;
                        // $arrPostData['python_image'] = true;

                        update_post_meta($post_id, 'cv_report_image', $candidate_image);
                        update_post_meta($post_id, 'python_image', true);

                    }                    
                }

            }

            if (isset($_GET['post']) && isset($_GET['action']) && $_GET['action'] == 'edit') {
                $email = get_post_meta($post_id, 'email', true);
                $expireTimestamp = strtotime('+7 days');
                $secretKey = 'njdfds5656dfsd545dfsfwe45';
                $token = md5($post_id . $expireTimestamp . $secretKey);
                $link = site_url('/paid-services-report-email-template/') . "?cvID=" . urlencode($post_id) . "&token=" . urlencode($token) . "&expires=" . urlencode($expireTimestamp);
                $status_done = get_post_meta($post_id, 'status-done', true);
                ?>
<script type="text/javascript">
document.addEventListener('DOMContentLoaded', function() {
    $ = jQuery
    var postType = $('#post_type').val();
    if (postType === 'paid_services') {
        var buttonHtml = '<div id="send-email-box" class="misc-pub-section">' +
            '<a href="#" id="send-email-button" class="button">Email Report</a>';
        <?php if ($status_done === 'Done') {?>
        buttonHtml +=
            '<a href="<?php echo $link; ?>" id="view-report-button" class="button" target="_blank" style="margin-left: 15px;">View Report</a>';
        <?php }?>
        buttonHtml += '</div>';
        $('#submitdiv').append(buttonHtml);

        $('#send-email-button').on('click', function(e) {
            e.preventDefault();

            $('#emailModal').css('display', 'block');
        });

        $('.close').on('click', function() {
            $('#emailModal').css('display', 'none');
        });

        $(window).on('click', function(event) {
            if (event.target == $('#emailModal')[0]) {
                $('#emailModal').css('display', 'none');
            }
        });

        $('#sendEmail').on('click', function() {
            var introduction = acf.getField('field_65ba0615b424a').val();
            var summary = acf.getField('field_65ba0eb9a48c9').val();
            var full_name = acf.getField('field_65cb011b6a30f').val();
            var current = acf.getField('field_65cb01546a311').val();
            var past = acf.getField('field_65cb013a6a310').val();
            var education = acf.getField('field_65cb01676a312').val();
            var picture = acf.getField('field_65bb6a90ae963').val();
            var layout = acf.getField('field_65bb7dd48e573').val();
            var content_length = acf.getField('field_65bb7f816f3e3').val();
            var spelling_grammer = acf.getField('field_65bb7fb46f3e4').val();
            var font_constent = acf.getField('field_65bb7fd16f3e5').val();
            var keyword = acf.getField('field_65bb7ff26f3e6').val();
            var bullet_details = acf.getField('field_65bb80106f3e7').val();
            var concolustion = acf.getField('field_65bb80326f3e8').val();
            var repeaterData = [];
            $('.acf-repeater .acf-row').each(function() {
                var dataKey = $(this).find('[data-name="chart_data"]').val();
                var keyword11 = $(this).find('.acf-field-65c9c44fe9487 input').val();
                var value11 = $(this).find('.acf-field-65c9c45be9488 input').val();

                repeaterData.push({
                    dataKey: dataKey,
                    keyword1: keyword11,
                    value1: value11,
                });
            });
            var repeaterDataJSON = JSON.stringify(repeaterData);


            $.ajax({
                url: ajaxurl,
                type: 'POST',
                data: {
                    action: 'send_custom_email',
                    introduction: introduction,
                    summary: summary,
                    full_name: full_name,
                    current: current,
                    past: past,
                    education: education,
                    picture: picture,
                    layout: layout,
                    content_length: content_length,
                    spelling_grammer: spelling_grammer,
                    font_constent: font_constent,
                    keyword: keyword,
                    bullet_details: bullet_details,
                    concolustion: concolustion,
                    message: tinymce.get('message').getContent(),
                    subject: $('#subject').val(),
                    cvid: <?php echo $post_id ?>,
                    repeater_data: repeaterDataJSON,
                    user_email: $('#email').val()

                },
                beforeSend: function() {
                    $('#spinner').show();
                    $('#sendEmail').prop('disabled', true);
                },

                complete: function() {
                    $('#spinner').hide();
                    $('#sendEmail').prop('disabled', false);
                },
                success: function(response) {
                    // var jsonResponse = JSON.parse(response);
                    alert("Email sent successfully!");

                    window.location.href = '/wp-admin/edit.php?post_type=paid_services';

                }

            });
        });
    }
})
</script>
<style>
.modal {
    display: none;
    position: fixed;
    z-index: 1;
    left: 0;
    top: 0;
    width: 100%;
    height: 100%;
    overflow: auto;
    background-color: rgba(0, 0, 0, 0.4);
}

.modal-content {
    background-color: #fefefe;
    margin: 10% auto;
    padding: 20px;
    border: 1px solid #888;
    width: 80%;
}

.close {
    color: #aaa;
    float: right;
    font-size: 28px;
    font-weight: bold;
}

.close:hover {
    color: black;
    text-decoration: none;
    cursor: pointer;
}

.spinner {
    border: 4px solid rgba(0, 0, 0, 0.1);
    border-radius: 50%;
    border-top: 4px solid #3498db;
    width: 20px;
    height: 20px;
    animation: spin 1s linear infinite;
    position: absolute;
    top: 50%;
    left: 50%;
    margin-top: -10px;
    margin-left: -10px;
    display: none;
}

@keyframes spin {
    0% {
        transform: rotate(0deg);
    }

    100% {
        transform: rotate(360deg);
    }
}
</style>
<?php
$emailshow = get_post_meta($post_id, 'email', true);
                $oldsubject = get_post_meta($post_id, 'report_subject', true);
                ?>
<div id="emailModal" class="modal">
    <div class="modal-content">
        <span class="close">&times;</span>
        <label for="email">Mail will be sent to:</label>
        <input type="text" id="email" value="<?php echo esc_attr($emailshow); ?>">
        <br><br>
        <label for="subject">Subject:</label>
        <input type="text" id="subject" name="subject" value="<?php echo esc_attr($oldsubject); ?>">
        <br>
        <label for="message">Message:</label>
        <?php
wp_editor('', 'message', array(
                    'textarea_name' => 'message',
                    'textarea_rows' => 12,
                    'media_buttons' => false,
                    'tinymce' => array(
                        'toolbar1' => 'bold italic underline strikethrough | bullist numlist | outdent indent | alignleft aligncenter alignright alignjustify',
                        'toolbar2' => '',
                    ),
                ));
                ?>
        <button id="sendEmail" class="button">Send Email</button>
    </div>
</div>



<?php
}
        }
    }}

add_action('wp_ajax_send_custom_email', 'send_custom_email');

function send_custom_email()
{
    $cvid = sanitize_text_field($_POST['cvid']);
    $userEmail = sanitize_email($_POST['user_email']);
    $repeaterData = json_decode(stripslashes($_POST['repeater_data']), true);
    $message = stripslashes($_POST['message']);
    $subject = isset($_POST['subject']) ? sanitize_text_field($_POST['subject']) : '';
    $currentTime = current_time("mysql");
    $oldMessages = get_post_meta($cvid, 'report_messages', true);
    // $message = wp_strip_all_tags($message);
    if ($oldMessages) {
        $oldMessages[] = array(
            'message' => $message,
            'timestamp' => $currentTime,
        );
    } else {
        $oldMessages = array(
            array(
                'message' => $message,
                'timestamp' => $currentTime,
            ),
        );
    }
    update_post_meta($cvid, 'report_messages', $oldMessages);
    update_post_meta($cvid, 'report_subject', $subject);
    update_post_meta($cvid, 'introduction', (($_POST['introduction'])));
    update_post_meta($cvid, 'summary', (($_POST['summary'])));
    update_post_meta($cvid, 'full_name', (($_POST['full_name'])));
    update_post_meta($cvid, 'current', (($_POST['current'])));
    update_post_meta($cvid, 'past', (($_POST['past'])));
    update_post_meta($cvid, 'education', (($_POST['education'])));
    update_post_meta($cvid, 'picture', ($_POST['picture']));
    update_post_meta($cvid, 'layout', ($_POST['layout']));
    update_post_meta($cvid, 'content_length', ($_POST['content_length']));
    update_post_meta($cvid, 'spelling_grammer', (($_POST['spelling_grammer'])));
    update_post_meta($cvid, 'font_constent', (($_POST['font_constent'])));
    update_post_meta($cvid, 'keyword', (($_POST['keyword'])));
    update_post_meta($cvid, 'bullet_details', (($_POST['bullet_details'])));
    update_post_meta($cvid, 'concolustion', (($_POST['concolustion'])));
    foreach ($repeaterData as $item) {
        $keyword1Values[] = sanitize_text_field($item['keyword1']);
        $value1Values[] = sanitize_text_field($item['value1']);
        update_post_meta($cvid, 'keyword1_' . $item['some_unique_identifier'], sanitize_text_field($item['keyword1']));
        update_post_meta($cvid, 'value1_' . $item['some_unique_identifier'], sanitize_text_field($item['value1']));
    }
    update_post_meta($cvid, 'all_keyword1_values', $keyword1Values);
    update_post_meta($cvid, 'all_value1_values', $value1Values);
    $expireTimestamp = strtotime('+7 days');
    $secretKey = 'njdfds5656dfsd545dfsfwe45';
    $token = md5($cvid . $expireTimestamp . $secretKey);

    $link = site_url('/paid-services-report-email-template/')
    . "?cvID=" . urlencode($cvid)
    . "&token=" . urlencode($token)
    . "&expires=" . urlencode($expireTimestamp);
    update_post_meta($cvid, 'expiration_timestamp', $expireTimestamp);
    $headers = array('Content-Type: text/html; charset=UTF-8');
    $result = wp_mail($userEmail, $subject, "<table border='0' cellpadding='0' cellspacing='0' width='100%' class='wrapperBody' style='max-width:600px'>
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
                            <td style='padding-left:20px;padding-right:20px' align='center' valign='top' class='containtTable ui-sortable'>

                                <table border='0' cellpadding='0' cellspacing='0' width='100%' class='tableButton' style=''>
                                    <tbody>
                                    <tr>
                                    <td style='padding-left:20px;padding-right:20px' valign='top' class='containtTable ui-sortable'>

                                    $message

                                    </td>
                                </tr>
                                        <tr>
                                            <td style='padding-top:20px;padding-bottom:20px' align='center' valign='top'>
                                                <table border='0' cellpadding='0' cellspacing='0' align='center'>
                                                    <tbody>
                                                        <tr>
                                                            <td style='background-color: #194461; padding: 12px 35px; border-radius: 6px;' align='center' class='ctaButton'>
                                                                <a href='$link' style='color:#fff;font-family:Poppins,Helvetica,Arial,sans-serif;font-size:13px;font-weight:600;font-style:normal;letter-spacing:1px;line-height:20px;text-transform:uppercase;text-decoration:none;display:block' target='_blank' class='text'>View Report</a>
                                                            </td>
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

                    </tr>
                        <tr>
                            <td style='font-size:1px;line-height:1px' height='20'>&nbsp;</td>
                        </tr>

                    </tbody>
                </table>
            </td>
        </tr>
    </tbody>
</table>", $headers);

    if ($result) {
        update_post_meta($cvid, 'status-update', 'Done');
        update_post_meta($cvid, 'status-done', 'Done');
        $response = array('status' => 'success', 'message' => 'Email sent successfully!');
    } else {
        update_post_meta($cvid, 'status-update', 'Pending');
        $response = array('status' => 'error', 'message' => 'Failed to send email.');
    }

    echo json_encode($response);
    wp_die();
}

add_action('add_meta_boxes', 'add_custom_button_meta_box');
function add_custom_button_meta_box()
{
    add_meta_box(
        'custom_update_button',
        'Update Fields',
        'render_custom_button_meta_box',
        'paid_services',
        'side',
        'default'
    );
}

function render_custom_button_meta_box()
{
    global $post;
    echo '<button id="custom_update_button" class="button">Update Fields</button>';
    echo '<div id="loader" style="display:none;"><img src="' . admin_url('images/spinner.gif') . '" /></div>';
}

add_action('admin_footer', 'custom_button_script');
function custom_button_script()
{
    global $post;
    if ($post->post_type == 'paid_services') {
        ?>
<script type="text/javascript">
jQuery(document).ready(function($) {
    $('#custom_update_button').on('click', function(e) {
        e.preventDefault();
        $('#loader').show();
        var post_id = <?php echo $post->ID; ?>;
        var profile_name = acf.getField('field_65cdbfd61089e').val();
        var introduction = acf.getField('field_65ba0615b424a').val();
        var summary = acf.getField('field_65ba0eb9a48c9').val();
        var full_name = acf.getField('field_65cb011b6a30f').val();
        var current = acf.getField('field_65cb01546a311').val();
        var past = acf.getField('field_65cb013a6a310').val();
        var education = acf.getField('field_65cb01676a312').val();
        var picture = acf.getField('field_65bb6a90ae963').val();
        var layout = acf.getField('field_65bb7dd48e573').val();
        var content_length = acf.getField('field_65bb7f816f3e3').val();
        var spelling_grammer = acf.getField('field_65bb7fb46f3e4').val();
        var font_constent = acf.getField('field_65bb7fd16f3e5').val();
        var keyword = acf.getField('field_65bb7ff26f3e6').val();
        var bullet_details = acf.getField('field_65bb80106f3e7').val();
        var concolustion = acf.getField('field_65bb80326f3e8').val();
        var repeaterData = [];
        $('.acf-repeater .acf-row').each(function() {
            var dataKey = $(this).find('[data-name="chart_data"]').val();
            var keyword11 = $(this).find('.acf-field-65c9c44fe9487 input').val();
            var value11 = $(this).find('.acf-field-65c9c45be9488 input').val();

            repeaterData.push({
                dataKey: dataKey,
                keyword1: keyword11,
                value1: value11,
            });
        });
        var repeaterDataJSON = JSON.stringify(repeaterData);



        var data = {
            'action': 'update_all_fields',
            'post_id': post_id,
            'profile_name': profile_name,
            'introduction': introduction,
            'summary': summary,
            'full_name': full_name,
            'current': current,
            'past': past,
            'education': education,
            'picture': picture,
            'layout': layout,
            'content_length': content_length,
            'spelling_grammer': spelling_grammer,
            'font_constent': font_constent,
            'keyword': keyword,
            'bullet_details': bullet_details,
            'concolustion': concolustion,
            repeater_data: repeaterDataJSON,


        };
        $.post(ajaxurl, data, function(response) {
            $('#loader').hide();
            alert('Fields updated successfully!');
        });
    });
});
</script>
<?php
}
}

add_action('wp_ajax_update_all_fields', 'update_all_fields_callback');
function update_all_fields_callback()
{
    $post_id = $_POST['post_id'];
    update_post_meta($post_id, 'cv_report_name', (($_POST['profile_name'])));
    update_post_meta($post_id, 'introduction', (($_POST['introduction'])));
    update_post_meta($post_id, 'summary', (($_POST['summary'])));
    update_post_meta($post_id, 'full_name', (($_POST['full_name'])));
    update_post_meta($post_id, 'current', (($_POST['current'])));
    update_post_meta($post_id, 'past', (($_POST['past'])));
    update_post_meta($post_id, 'education', (($_POST['education'])));
    update_post_meta($post_id, 'picture', ($_POST['picture']));
    update_post_meta($post_id, 'layout', ($_POST['layout']));
    update_post_meta($post_id, 'content_length', ($_POST['content_length']));
    update_post_meta($post_id, 'spelling_grammer', (($_POST['spelling_grammer'])));
    update_post_meta($post_id, 'font_constent', (($_POST['font_constent'])));
    update_post_meta($post_id, 'keyword', (($_POST['keyword'])));
    update_post_meta($post_id, 'bullet_details', (($_POST['bullet_details'])));
    update_post_meta($post_id, 'concolustion', (($_POST['concolustion'])));
    $repeaterData = json_decode(stripslashes($_POST['repeater_data']), true);
    foreach ($repeaterData as $item) {
        $keyword1Values[] = sanitize_text_field($item['keyword1']);
        $value1Values[] = sanitize_text_field($item['value1']);
        update_post_meta($post_id, 'keyword1_' . $item['some_unique_identifier'], sanitize_text_field($item['keyword1']));
        update_post_meta($post_id, 'value1_' . $item['some_unique_identifier'], sanitize_text_field($item['value1']));
    }
    update_post_meta($post_id, 'all_keyword1_values', $keyword1Values);
    update_post_meta($post_id, 'all_value1_values', $value1Values);

    wp_send_json_success('Fields updated successfully!');
}

?>