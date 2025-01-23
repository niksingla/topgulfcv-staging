<?php
/**
 * Proceed to checkout button
 *
 * Contains the markup for the proceed to checkout button on the cart.
 *
 * This template can be overridden by copying it to yourtheme/woocommerce/cart/proceed-to-checkout-button.php.
 *
 * HOWEVER, on occasion WooCommerce will need to update template files and you
 * (the theme developer) will need to copy the new files to your theme to
 * maintain compatibility. We try to do this as little as possible, but it does
 * happen. When this occurs the version of the template file will be bumped and
 * the readme will list any important changes.
 *
 * @see     https://woo.com/document/template-structure/
 * @package WooCommerce\Templates
 * @version 7.0.1
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}

$my_items = [];
foreach ( WC()->cart->get_cart() as $cart_item_key => $cart_item ) {
    $product = $cart_item['data'];
    $product_id = $cart_item['product_id'];
    $my_items[] = $product_id;
 }
?>

<a href="<?= site_url('checkout')?>" id="myloader" class="checkout-button button alt wc-forward<?php echo esc_attr( wc_wp_theme_get_element_class_name( 'button' ) ? ' ' . wc_wp_theme_get_element_class_name( 'button' ) : '' ); ?>">
	<?php esc_html_e( 'Proceed to checkout', 'woocommerce' ); ?>
</a>
<img src="" class="loader" />
<form method="post" action="/signup" id="cart_products_form" hidden>
    <input type="text" name="product_ids" value="<?php echo implode(',',$my_items); ?>">
</form>

<script type="text/javascript">
    function proceedtopay(){
        document.querySelector('#cart_products_form').submit();
    }	
//For loader proceed to checkout button
jQuery(document).ready(function($) {
    $('#myloader').click(function() {
        $('.loader').show(); // Show the loader when the button is clicked
    });
});
</script>
