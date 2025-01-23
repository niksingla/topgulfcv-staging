<?php
use WPDesk\FCF\Free\Settings\Option\CustomFieldOption;


add_action('wp', function() {
    if (WC()->session && !is_admin() && !is_ajax() && ( !WC()->session->get('chosen_payment_method') || WC()->session->get('chosen_payment_method') !== 'ppcp-gateway' )) {
        WC()->session->set('chosen_payment_method', 'ppcp-gateway');
    }
});

add_action('wp_ajax_uplaod_the_cv_manually', 'uplaod_the_cv_manually');
add_action('wp_ajax_nopriv_uplaod_the_cv_manually', 'uplaod_the_cv_manually');

function uplaod_the_cv_manually() {
    if (!isset($_POST['woocommerce-process-checkout-nonce']) || 
        !wp_verify_nonce(sanitize_text_field($_POST['woocommerce-process-checkout-nonce']), 'woocommerce-process_checkout')) {
        wp_send_json_error(['message' => 'Session Expired']);
        wp_die();
    }
    if (!empty($_FILES['billing_uploaded_resume'])) {
        $file = $_FILES['billing_uploaded_resume'];    
        $nonce = sanitize_text_field($_POST['woocommerce-process-checkout-nonce']);
        $filename = $nonce . '_' . sanitize_file_name($file['name']);

        $upload_dir = wp_upload_dir();
        $target_dir = $upload_dir['basedir'] . '/temp_uploads/';
        wp_mkdir_p($target_dir);

        $target_file = $target_dir . $filename;
        if (move_uploaded_file($file['tmp_name'], $target_file)) {
            $file_url = $upload_dir['baseurl'] . '/temp_uploads/' . $filename;
            wp_send_json_success([
                'message' => 'File uploaded successfully', 
                'file_url' => $file_url, 
                'file_name' => $filename
            ]);
        } else {
            wp_send_json_error(['message' => 'Failed to upload file']);
        }        
    } else {
        wp_send_json_error('No file uploaded');
        wp_die();
    }
}


add_action( 'woocommerce_order_status_processing', 'handle_paid_services_on_processing_order', 10, 1 );

function handle_paid_services_on_processing_order( $order_id ) {
    // Get order object    
    $order = wc_get_order( $order_id );
    if ( ! $order ) {
        return;
    }

    // Get billing email
    $billing_email = $order->get_billing_email();
    if ( ! $billing_email ) {
        return;
    }

    // Check if a user exists with this email
    $user = get_user_by( 'email', $billing_email );

    if ( $user ) {
        $user_id = $user->ID; // Existing user ID
    } else {
        // Create a new user
        $username = sanitize_user( current( explode( '@', $billing_email ) ), true );
        $password = wp_generate_password();

        $user_id = wp_create_user( $username, $password, $billing_email );
    }

    // Call your function
    add_paid_services( $user_id, $order_id );
}

function add_paid_services( $user_id, $order_id ){
    $user = get_userdata($user_id);
    if ($user) {
        $user_name = $user->display_name;
        $user_email = $user->user_email;
        $order = wc_get_order( $order_id ); 
        
        // Retrieve WooCommerce billing fields
        $billing_first_name = isset($_POST['billing_first_name']) ? sanitize_text_field($_POST['billing_first_name']) : '';
        $billing_last_name = isset($_POST['billing_last_name']) ? sanitize_text_field($_POST['billing_last_name']) : '';
        $billing_city = isset($_POST['billing_city']) ? sanitize_text_field($_POST['billing_city']) : '';
        $billing_country = (WC()->countries->get_countries())[$_POST['billing_country']];
        $total_amount = $order->get_total();
        $service_name = implode(', ', get_order_item_names($order));        
        $post_data = [
            "post_title"  => $billing_first_name . " " . $billing_last_name,
            "post_type"   => "paid_services",
            "post_status" => "draft",
        ];
        $post_id = wp_insert_post($post_data);

        if (!is_wp_error($post_id)) {

            /**Send Email to customer */
            $options = get_option('custom_email_options');
            $custom_subject = $options['custom_email_subject'] ?? 'Thank You for Your Order';
            $custom_message = get_custom_email_message(); 
            $message = get_email_template_custom($custom_message, $service_name);
            if ($user_email) {
                $headers = array('Content-Type: text/html; charset=UTF-8');
                wp_mail($user_email, $custom_subject, $message, $headers);
                update_option( 'test7', 'pass' );
            }

            // Update custom fields with WooCommerce billing information
            update_field("email", $user_email, $post_id);
            update_field("first_name11", $billing_first_name, $post_id);
            update_field("last_name11", $billing_last_name, $post_id);
            update_field("city11", $billing_city, $post_id);
            update_field("country11", $billing_country, $post_id);
            update_field("amount", $total_amount, $post_id);
            update_field("selected_services", $service_name, $post_id);
            update_post_meta($post_id, "_user_id", $user_id);
            update_post_meta( $post_id, 'order_number', $order_id );

            // Handle uploaded resume file
            if (isset($_POST['uploaded_resume'])) {
                if (!isset($_POST['woocommerce-process-checkout-nonce']) || 
                    !wp_verify_nonce(sanitize_text_field($_POST['woocommerce-process-checkout-nonce']), 'woocommerce-process_checkout')) {
                    return $post_id;
                }                            
                $upload_dir = wp_upload_dir();
                $user_folder = $upload_dir['basedir'] . '/cvs/' . $post_id;
                
                if (!file_exists($user_folder)) {
                    wp_mkdir_p($user_folder);
                }
            
                // Retrieve the file URL from the POST data
                $file_url = sanitize_text_field($_POST['uploaded_resume']);
                $file_name = basename($file_url);
            
                
                
                // Check if the file exists in the temporary folder and move it to the permanent directory
                $temp_file_path = $upload_dir['basedir'] . '/temp_uploads/' . $file_name;
                
                // Remove the nonce from the file name before saving
                $file_name = str_replace($_POST['woocommerce-process-checkout-nonce'], '', $file_name);
                
                // Define the file path where it will be saved
                $file_path = $user_folder . '/' . $file_name;
                
                if (file_exists($temp_file_path)) {
                    $saved = rename($temp_file_path, $file_path);
                    
                    if ($saved) {
                        // Update post meta with the new file URL
                        $resume_url = $upload_dir['baseurl'] . '/cvs/' . $post_id . '/' . $file_name;
                        update_post_meta($post_id, 'uploaded_resume', $resume_url);
            
                        // Optionally, remove the temporary file if still exists
                        if (file_exists($temp_file_path)) {
                            unlink($temp_file_path);
                        }
                    }
                }
            }
            return $post_id;
        }
    }
    return false;
}

/**Email Template */
function get_email_template_custom($custom_message, $services){
    $message = "<table border='0' cellpadding='0' cellspacing='0' width='100%' class='wrapperBody' style='max-width:600px'>
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
                                    <table border='0' cellpadding='0' cellspacing='0' width='100%' class='tableButton'>
                                        <tbody>
                                            <tr>
                                                <td style='padding-left:20px;padding-right:20px' valign='top' class='containtTable ui-sortable'>
                                                    $custom_message
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
    </table>";
    $serv = "$services";
    $message = str_replace('[service_names]',$serv,$message);
    return $message;
}


function get_order_item_names($order) {
    $item_names = [];
    foreach ($order->get_items() as $item) {
        $product = wc_get_product($item->get_product_id());
        if ($product) {
            $item_names[] = $product->get_name();
        }
    }
    return $item_names;
}


//add_filter('woocommerce_checkout_fields', function($fields) {})    

function custom_input_html($output, $key, $args, $value){
    if (true || ! isset( $args[ CustomFieldOption::FIELD_NAME ] ) || ! $args[ CustomFieldOption::FIELD_NAME ] ) {			                
        $custom_attributes = [];        
        if($args['id'] == 'billing_uploaded_resume'){
            $is_resume_upload = false;
            foreach ( WC()->cart->get_cart() as $cart_item_key => $cart_item ) {
                $product = $cart_item['data'];
                $product_id = $cart_item['product_id'];
                $product_tags = get_the_terms( $product_id, 'product_tag' );                        
                if($product_tags){
                    foreach ($product_tags as $tag) {
                        if(get_term($tag)->name=="resume_upload"){
                            $is_resume_upload = true;
                        }    
                    }
                }        
            }
            if($is_resume_upload){
                $args['type'] = 'file';
                $args['required'] = true;
            } 
        }

        $field_type  = $args['type'];
        if(file_exists(__DIR__."/flexible-checkout-fields/fields/$field_type.php")){
            ob_start();
            require "flexible-checkout-fields/fields/$field_type.php";
            $output = ob_get_clean();        
        } else if(('file' == $field_type && 'billing_uploaded_resume' == $args['id']) || $field_type == 'country' && file_exists(__DIR__."/flexible-checkout-fields/fields/custom.php")) {            
            ob_start();
            require "flexible-checkout-fields/fields/custom.php";
            $output = ob_get_clean();
        }
        if(!$is_resume_upload && $args['id'] == 'billing_uploaded_resume'){
            $output = '';
        }
        return $output;                
    }
    return $output;
}
add_filter( 'woocommerce_form_field', 'custom_input_html', 1999, 4 );

if(false){

    // Add custom settings tab
    add_filter('woocommerce_settings_tabs_array', 'add_checkout_fields_tab', 50);
    function add_checkout_fields_tab($settings_tabs) {
        $settings_tabs['checkout_fields'] = __('Checkout Fields', 'topgulfcv');
        return $settings_tabs;
    }
    
    // Add settings for the custom tab
    add_action('woocommerce_settings_checkout_fields', 'add_checkout_fields_settings');
    function add_checkout_fields_settings() {
        woocommerce_admin_fields(get_checkout_fields_settings());
    }
    
    // Save settings for the custom tab
    add_action('woocommerce_update_options_checkout_fields', 'save_checkout_fields_settings');
    function save_checkout_fields_settings() {
        woocommerce_update_options(get_checkout_fields_settings());
    }
    
    // Define the settings
    function get_checkout_fields_settings() {   
        $settings = array(
            'section_title' => array(
                'name' => __('Checkout Fields Settings', 'topgulfcv'),
                'type' => 'title',
                'desc' => '',
                'id' => 'checkout_fields_section_title'
            ),
            'enable_custom_field' => array(
                'name' => __('Customized Fields', 'topgulfcv'),
                'type' => 'checkbox',
                'desc' => __('Load customized checkout fields.', 'topgulfcv'),
                'id' => 'enable_custom_field',
                'default' => 'yes',
            ),
            'form_main_title' => array(
                'name'     => __('Form Main Title', 'topgulfcv'),
                'type'     => 'text',
                'desc'     => __('Set the main title for the form. Default is "Checkout Form".', 'topgulfcv'),
                'id'       => 'form_main_title',
                'default'  => __('Checkout Form', 'topgulfcv'),
                'required' => array('enable_custom_field', '=', 'yes'),
            ),
            // Section for First Name Field
            'first_name_section_title' => array(
                'name' => __('First Name Field Settings', 'topgulfcv'),
                'type' => 'info',
                'desc' => '',
                'id' => 'first_name_section_title',
                'required' => array('enable_custom_field', '=', 'yes'),
            ),
            'enable_first_name' => array(
                'name' => __('Enable First Name Field', 'topgulfcv'),
                'type' => 'checkbox',
                'desc' => __('Show or hide the First Name field.', 'topgulfcv'),
                'id' => 'enable_first_name',
                'default' => 'yes',
                'required' => array('enable_custom_field', '=', 'yes'),
            ),        
            'custom_first_name_label' => array(
                'name' => __('Customize First Name Label', 'topgulfcv'),
                'type' => 'text',
                'desc' => __('Set a custom label for the First Name field.', 'topgulfcv'),
                'id' => 'custom_first_name_label',
                'default' => __('First Name', 'topgulfcv'),
                'required' => array('enable_custom_field', '=', 'yes'),
            ),
            'last_name_section_info' => array(
                'name' => __('Last Name Field Settings', 'topgulfcv'),
                'type' => 'info',
                'desc' => __('Configure the Last Name field.', 'topgulfcv'),
                'id' => 'last_name_section_info',
                'required' => array('enable_custom_field', '=', 'yes'),
            ),
            'enable_last_name' => array(
                'name' => __('Enable Last Name Field', 'topgulfcv'),
                'type' => 'checkbox',
                'desc' => __('Show or hide the Last Name field.', 'topgulfcv'),
                'id' => 'enable_last_name',
                'default' => 'yes',
                'required' => array('enable_custom_field', '=', 'yes'),
            ),
            'custom_last_name_label' => array(
                'name' => __('Customize Last Name Label', 'topgulfcv'),
                'type' => 'text',
                'desc' => __('Set a custom label for the Last Name field.', 'topgulfcv'),
                'id' => 'custom_last_name_label',
                'default' => __('Last Name', 'topgulfcv'),
                'required' => array('enable_custom_field', '=', 'yes'),
            ),
            'city_section_info' => array(
                'name' => __('City Field Settings', 'topgulfcv'),
                'type' => 'info',
                'desc' => __('Configure the City field.', 'topgulfcv'),
                'id' => 'city_section_info',
                'required' => array('enable_custom_field', '=', 'yes'),
            ),
            'enable_city' => array(
                'name' => __('Enable City Field', 'topgulfcv'),
                'type' => 'checkbox',
                'desc' => __('Show or hide the City field.', 'topgulfcv'),
                'id' => 'enable_city',
                'default' => 'yes',
                'required' => array('enable_custom_field', '=', 'yes'),
            ),
            'custom_city_label' => array(
                'name' => __('Customize City Label', 'topgulfcv'),
                'type' => 'text',
                'desc' => __('Set a custom label for the City field.', 'topgulfcv'),
                'id' => 'custom_city_label',
                'default' => __('City', 'topgulfcv'),
                'required' => array('enable_custom_field', '=', 'yes'),
            ),
            'country_section_info' => array(
                'name' => __('Country Field Settings', 'topgulfcv'),
                'type' => 'info',
                'desc' => __('Configure the Country field.', 'topgulfcv'),
                'id' => 'country_section_info',
                'required' => array('enable_custom_field', '=', 'yes'),
            ),
            'enable_country' => array(
                'name' => __('Enable Country Field', 'topgulfcv'),
                'type' => 'checkbox',
                'desc' => __('Show or hide the Country field.', 'topgulfcv'),
                'id' => 'enable_country',
                'default' => 'yes',
                'required' => array('enable_custom_field', '=', 'yes'),
            ),
            'email_section_info' => array(
                'name' => __('Email Field Settings', 'topgulfcv'),
                'type' => 'info',
                'desc' => __('Configure the Email field.', 'topgulfcv'),
                'id' => 'email_section_info',
                'required' => array('enable_custom_field', '=', 'yes'),
            ),
            'custom_country_label' => array(
                'name' => __('Customize Country Label', 'topgulfcv'),
                'type' => 'text',
                'desc' => __('Set a custom label for the Country field.', 'topgulfcv'),
                'id' => 'custom_country_label',
                'default' => __('Country', 'topgulfcv'),
                'required' => array('enable_custom_field', '=', 'yes'),
            ),
            'enable_email' => array(
                'name' => __('Enable Email Field', 'topgulfcv'),
                'type' => 'checkbox',
                'desc' => __('Show or hide the Email field.', 'topgulfcv'),
                'id' => 'enable_email',
                'default' => 'yes',
                'required' => array('enable_custom_field', '=', 'yes'),
            ),
            'custom_email_label' => array(
                'name' => __('Customize Email Label', 'topgulfcv'),
                'type' => 'text',
                'desc' => __('Set a custom label for the Email field.', 'topgulfcv'),
                'id' => 'custom_email_label',
                'default' => __('Email', 'topgulfcv'),
                'required' => array('enable_custom_field', '=', 'yes'),
            ),
            'marketing_checkbox_section_info' => array(
                'name' => __('Marketing Checkbox Settings', 'topgulfcv'),
                'type' => 'info',
                'desc' => __('Configure the Marketing Checkbox field.', 'topgulfcv'),
                'id' => 'marketing_checkbox_section_info',
                'required' => array('enable_custom_field', '=', 'yes'),
            ),
            'enable_marketing_checkbox' => array(
                'name' => __('Enable Marketing Checkbox', 'topgulfcv'),
                'type' => 'checkbox',
                'desc' => __('Show or hide the Marketing checkbox.', 'topgulfcv'),
                'id' => 'enable_marketing_checkbox',
                'default' => 'yes',
                'required' => array('enable_custom_field', '=', 'yes'),
            ),
            'custom_marketing_checkbox_label' => array(
                'name' => __('Customize Marketing Checkbox Label', 'topgulfcv'),
                'type' => 'text',
                'desc' => __('Set a custom label for the Marketing checkbox.', 'topgulfcv'),
                'id' => 'custom_marketing_checkbox_label',
                'default' => __('Subscribe to marketing emails', 'topgulfcv'),
                'required' => array('enable_custom_field', '=', 'yes'),
            ),
            'add_fields_button' => array(
                'type' => 'custom_html',
                'id'   => 'add_fields_button',
                'html' => '<button type="button" class="button add-field-button">' . __('Add Fields', 'topgulfcv') . '</button>
                        <div id="dynamic-fields-container"></div>',
            ),
            'section_end' => array(
                'type' => 'sectionend',
                'id' => 'checkout_fields_section_end',
            ),
        );
        
        return $settings;
    }
}