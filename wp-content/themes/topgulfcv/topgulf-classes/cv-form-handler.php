<?php
/**
 * Handle frontend forms.
 *
 * @package topgulfcv\Classes\
 */

defined( 'ABSPATH' ) || exit;

/**
 * CV_Form_Handler class.
 */
class CV_Form_Handler {

	/**
	 * Hook in methods.
	 */
	public static function init() {
		add_action( 'wp_loaded', array( __CLASS__, 'process_login' ), 20 );
		add_action( 'wp_loaded', array( __CLASS__, 'process_registration' ), 20 );
		// add_action( 'wp_loaded', array( __CLASS__, 'process_lost_password' ), 20 );
		// add_action( 'wp_loaded', array( __CLASS__, 'process_reset_password' ), 20 );
	}


		/**
	 * Process the login form.
	 *
	 * @throws Exception On login error.
	 */
	public static function process_login() {

		static $valid_nonce = null;

		if ( null === $valid_nonce ) {
			// The global form-login.php template used `_wpnonce` in template versions < 3.3.0.
			//$nonce_value = wc_get_var( $_REQUEST['topgulfcv-login-nonce'], wc_get_var( $_REQUEST['_wpnonce'], '' ) ); 
			// $nonce_value = isset( $_POST['topgulfcv-login-nonce'] ) ? wp_unslash( $_POST['topgulfcv-login-nonce'] ) : $nonce_value;
			// $valid_nonce = wp_verify_nonce( $nonce_value, 'topgulfcv-login' );
		}

		if ( isset( $_POST['login'], $_POST['username'], $_POST['password'] ) ) {
			try {
				$creds = array(
					'user_login'    => trim( wp_unslash( $_POST['username'] ) ), 
					'user_password' => $_POST['password'], 
					'remember'      => isset( $_POST['rememberme'] ), 
				);

				$validation_error = new WP_Error();
				$validation_error = apply_filters( 'woocommerce_process_login_errors', $validation_error, $creds['user_login'], $creds['user_password'] );

				if ( $validation_error->get_error_code() ) {
					throw new Exception( '<strong>' . __( 'Error:', 'woocommerce' ) . '</strong> ' . $validation_error->get_error_message() );
				}

				if ( empty( $creds['user_login'] ) ) {
					throw new Exception( '<strong>' . __( 'Error:', 'woocommerce' ) . '</strong> ' . __( 'Username is required.', 'woocommerce' ) );
				}

				// Peform the login.
				$user = wp_signon( apply_filters( 'woocommerce_login_credentials', $creds ), is_ssl() );

				if ( is_wp_error( $user ) ) {
					throw new Exception( $user->get_error_message() );
				} 
				//$redirect = remove_query_arg( array( 'wc_error', 'password-reset' ), $redirect );
				wp_redirect( home_url('wp-admin/profile.php'), 302); 
				//wp_redirect( wp_validate_redirect( apply_filters( 'woocommerce_login_redirect', $redirect, $user ), wc_get_page_permalink( 'myaccount' ) ) ); // phpcs:ignore
				exit;
			} catch ( Exception $e ) {
				wc_add_notice( apply_filters( 'login_errors', $e->getMessage() ), 'error' );
				do_action( 'woocommerce_login_failed' );
			}
		}
	}


	/**
	 * Process the registration form.
	 *
	 * @throws Exception On registration error.
	 */
	public static function process_registration() {

		
		



		$nonce_value = isset( $_POST['_wpnonce'] ) ? wp_unslash( $_POST['_wpnonce'] ) : ''; 
		$nonce_value = isset( $_POST['topgulfcv-register-nonce'] ) ? wp_unslash( $_POST['topgulfcv-register-nonce'] ) : $nonce_value; 

		if ( isset( $_POST['register'], $_POST['email'] ) && wp_verify_nonce( $nonce_value, 'topgulfcv-register' ) ) {
			$username = isset( $_POST['username'] ) && !empty($_POST['username']) ? wp_unslash( $_POST['username'] ) : ''; 
			$password = isset( $_POST['password'] ) ? $_POST['password'] : '12345'; 
			$email    = wp_unslash( $_POST['email'] ); 
			$user_first_name = wp_unslash( $_POST['fname'] ); 
			$user_last_name = wp_unslash( $_POST['lname'] ); 
			$billing_city = wp_unslash( $_POST['city'] ); 
			$billing_country = wp_unslash( $_POST['country'] ); 
			
			try {
				// $validation_error  = new WP_Error();
				// $validation_error  = apply_filters( 'woocommerce_process_registration_errors', $validation_error, $username, $password, $email );
				// $validation_errors = $validation_error->get_error_messages();

				// if ( 1 === count( $validation_errors ) ) {
				// 	throw new Exception( $validation_error->get_error_message() );
				// } elseif ( $validation_errors ) {
				// 	foreach ( $validation_errors as $message ) {
				// 		wc_add_notice( '<strong>' . __( 'Error:', 'woocommerce' ) . '</strong> ' . $message, 'error' );
				// 	}
				// 	throw new Exception();
				// }
				if(''===$username){
					$email_parts    = explode( '@', $email );
					$email_username = $email_parts[0];
					$username = $email_username;
					if(username_exists($username)){
						// $redirect = wc_get_page_permalink( 'success-paid-services' );
						$user = get_user_by('login',$username);
						$new_customer = $user->ID;												
						$link = 'checkout/?email='.urlencode($email);

						$new_post_id = update_paid_services($new_customer);
						if($new_post_id){
							$link .= '&service_id='.$new_post_id;
							$link .= '&city='.$_POST['city'];
							$link .= '&country='.getCountryCode($_POST['country']);

						}
						wp_redirect( home_url($link), 302); 
						exit;
					}
				}
				$new_customer = wp_create_user(wc_clean( $username ), $password, sanitize_email( $email ));
				$new_post_id = update_paid_services($new_customer);
				

				//$new_customer = wc_create_new_customer( sanitize_email( $email ), wc_clean( $username ), $password );

				if ( is_wp_error( $new_customer ) ) {
					throw new Exception( $new_customer->get_error_message() );
				}

				wp_update_user(array(
					'ID' => $new_customer,
					'first_name' => $user_first_name,
					'last_name' => $user_last_name,
					'billing_city' => $billing_city,
					'billing_country' => $billing_country

				));
				
				// Only redirect after a forced login - otherwise output a success notice.
				if ( apply_filters( 'wordpress_registration_auth_new_customer', true, $new_customer ) ) {
					// wc_set_customer_auth_cookie( $new_customer );

					
					// $redirect = wc_get_page_permalink( 'success-paid-services' );
					$link = 'checkout/?email='.urlencode($email);
					if($new_post_id){
						$link .= '&service_id='.$new_post_id;
						$link .= '&city='.$_POST['city'];
						$link .= '&country='.getCountryCode($_POST['country']);
					}
					wp_redirect( home_url($link), 302); 
					exit;
				}
			} catch ( Exception $e ) {
				if ( $e->getMessage() ) {
					wc_add_notice( '<strong>' . __( 'Error:', 'woocommerce' ) . '</strong> ' . $e->getMessage(), 'error' );
				}
			}
		}
	}

}

CV_Form_Handler::init();
function update_paid_services($user_id)
{
    $user = get_userdata($user_id);

    if ($user) {
        $user_name = $user->display_name;
        $user_email = $user->user_email;
        $user_first_name = $_POST["fname"];
        $user_last_name = $_POST["lname"];
        $post_data = [
            "post_title" => $user_first_name . " " . $user_last_name,
            "post_type" => "paid_Services",
            "post_status" => "draft",
        ];
        $post_id = wp_insert_post($post_data);

        if (!is_wp_error($post_id)) {
            update_field("email", $user_email, $post_id);
            update_field("first_name11", $user_first_name, $post_id);
            update_field("last_name11", $user_last_name, $post_id);
            update_field("city11", $_POST["city"], $post_id);
            update_field("country11", $_POST["country"], $post_id);
            update_field("amount", $_POST["total_amount"], $post_id);
            update_field("selected_services", $_POST["service_name"], $post_id);
            update_post_meta($post_id, "_user_id", $user_id);                        

            if(isset($_FILES['uploaded_resume'])){
				$upload_dir = wp_upload_dir(); 
				$user_folder = $upload_dir['basedir'] . '/cvs/' . $post_id;
				if (!file_exists($user_folder)) {
					wp_mkdir_p($user_folder);
				}
                $file = $_FILES['uploaded_resume'];            
                $file_name = sanitize_file_name($file['name']);
                $file_path = $user_folder . '/' . $file_name;
                $saved = move_uploaded_file($file['tmp_name'], $file_path);
                if($saved){
                    $resume_url = $upload_dir['baseurl'] . '/cvs/' . $post_id . '/' . $file_name;
                    update_post_meta( $post_id, 'uploaded_resume', $resume_url );                       
                }
            }
			return $post_id;
        }
    }
	return false;
}
function getCountryCode($countryName) {    
    $apiUrl = "https://restcountries.com/v3.1/name/" . urlencode($countryName);
    
    $ch = curl_init();
    
    curl_setopt($ch, CURLOPT_URL, $apiUrl);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($ch, CURLOPT_TIMEOUT, 10); // Set timeout (optional)
    
    $response = curl_exec($ch);

    // Check for errors
    if (curl_errno($ch)) {
        echo "cURL Error: " . curl_error($ch);
        curl_close($ch);
        return 'AE';
    }
    
    curl_close($ch);
    
    $data = json_decode($response, true);
    
    if (!empty($data) && isset($data[0]['cca2'])) {
        return $data[0]['cca2']; // Return the 2-letter country code
    }
    
    return 'AE';
}