<?php
/**
 * Review order table
 *
 * This template can be overridden by copying it to yourtheme/woocommerce/checkout/review-order.php.
 *
 * HOWEVER, on occasion WooCommerce will need to update template files and you
 * (the theme developer) will need to copy the new files to your theme to
 * maintain compatibility. We try to do this as little as possible, but it does
 * happen. When this occurs the version of the template file will be bumped and
 * the readme will list any important changes.
 *
 * @see https://woocommerce.com/document/template-structure/
 * @package WooCommerce\Templates
 * @version 5.2.0
 */

defined( 'ABSPATH' ) || exit;
?>
<table class="shop_table woocommerce-checkout-review-order-table">
	<thead>
		<tr>
		<th class="product-remove"><span class="screen-reader-text"><?php esc_html_e( 'Remove item', 'woocommerce' ); ?></span></th>
			<th class="product-name"><?php esc_html_e( 'Product', 'woocommerce' ); ?></th>
			<th class="product-total"><?php esc_html_e( 'Subtotal', 'woocommerce' ); ?></th>
		</tr>
	</thead>
	<tbody>		
		<?php
			$ppcp_data = WC()->session->get('ppcp');
			// echo '<pre>';
			// print_r($ppcp_data);
			// echo '</pre>';
			if ( isset($ppcp_data) && !empty($ppcp_data) ) {
				$order = isset($ppcp_data['order']) ? $ppcp_data['order'] : null;
				if(isset($order) && !empty($order)){
					if($order->payment_source() && $order->payment_source()->properties() && $order->payment_source()->properties()->account_status){
						if($order->payment_source()->properties()->account_status == 'UNVERIFIED'){
							if ( WC()->session->get('order_awaiting_payment') ) {
								WC()->session->__unset('order_awaiting_payment');
							} 
							if ( WC()->session->get('ppcp_fraudnet_session_id') ) {
								WC()->session->__unset('ppcp_fraudnet_session_id');
							} 
							if ( WC()->session->get('alg_wc_pgbc_data') ) {
								WC()->session->__unset('alg_wc_pgbc_data');
							} 
							if ( WC()->session->get('checkout-fields') ) {
								WC()->session->__unset('checkout-fields');
							} 
							if ( WC()->session->get('ppcp_guest_customer_id') ) {
								WC()->session->__unset('ppcp_guest_customer_id');
							} 
							if ( WC()->session->get('ppcp') ) {					
								WC()->session->__unset('ppcp');
							} 
						}
					}
				}
			}
		?>
		<script>
			console.log(<?php echo json_encode(WC()->session)?>);
			
		</script>
		<?php
		do_action( 'woocommerce_review_order_before_cart_contents' );

		foreach ( WC()->cart->get_cart() as $cart_item_key => $cart_item ) {
			$_product   = apply_filters( 'woocommerce_cart_item_product', $cart_item['data'], $cart_item, $cart_item_key );
			$product_id = apply_filters( 'woocommerce_cart_item_product_id', $cart_item['product_id'], $cart_item, $cart_item_key );

			if ( $_product && $_product->exists() && $cart_item['quantity'] > 0 && apply_filters( 'woocommerce_checkout_cart_item_visible', true, $cart_item, $cart_item_key ) ) {
				?>
				<tr class="<?php echo esc_attr( apply_filters( 'woocommerce_cart_item_class', 'cart_item', $cart_item, $cart_item_key ) ); ?>">
				<td class="product-remove">
							<?php
								echo apply_filters( // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped
									'woocommerce_cart_item_remove_link',
									sprintf(
										'<a href="%s" class="remove" aria-label="%s" data-product_id="%s" data-product_sku="%s">&times;</a>',
										esc_url( wc_get_cart_remove_url( $cart_item_key ) ),
										/* translators: %s is the product name */
										esc_attr( sprintf( __( 'Remove %s from cart', 'woocommerce' ), wp_strip_all_tags( apply_filters( 'woocommerce_cart_item_name', $_product->get_name(), $cart_item, $cart_item_key ) ) ) ),
										esc_attr( $product_id ),
										esc_attr( $_product->get_sku() )
									),
									$cart_item_key
								);
							?>
					</td>
					<td class="product-name">
						<?php echo wp_kses_post( apply_filters( 'woocommerce_cart_item_name', $_product->get_name(), $cart_item, $cart_item_key ) ) . '&nbsp;'; ?>
						<?php echo apply_filters( 'woocommerce_checkout_cart_item_quantity', ' <strong class="product-quantity">' . sprintf( '&times;&nbsp;%s', $cart_item['quantity'] ) . '</strong>', $cart_item, $cart_item_key ); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped ?>
						<?php echo wc_get_formatted_cart_item_data( $cart_item ); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped ?>
					</td>
					<td class="product-total">
						<?php 
							$item_price = apply_filters( 'woocommerce_cart_item_subtotal', WC()->cart->get_product_subtotal( $_product, $cart_item['quantity'] ), $cart_item, $cart_item_key ); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped 
							echo $item_price;
							// echo str_replace('&#36;','AED',$item_price) ;
						?>
					</td>					
				</tr>
				<?php
			}
		}

		do_action( 'woocommerce_review_order_after_cart_contents' );
		?>
	</tbody>
	<tfoot>

		<tr class="cart-subtotal">
			<th> </th>
			<th><?php esc_html_e( 'Subtotal', 'woocommerce' ); ?></th>
			<td>
				<?php 								
					// ob_clean();
						wc_cart_totals_subtotal_html(); 
					// $abc = ob_get_clean();
					// echo $abc;
				?>
			</td>
		</tr>

		<?php foreach ( WC()->cart->get_coupons() as $code => $coupon ) : ?>
			<tr class="cart-discount coupon-<?php echo esc_attr( sanitize_title( $code ) ); ?>">
				<th><?php wc_cart_totals_coupon_label( $coupon ); ?></th>
				<td><?php wc_cart_totals_coupon_html( $coupon ); ?></td>
			</tr>
		<?php endforeach; ?>

		<?php if ( WC()->cart->needs_shipping() && WC()->cart->show_shipping() ) : ?>

			<?php do_action( 'woocommerce_review_order_before_shipping' ); ?>

			<?php wc_cart_totals_shipping_html(); ?>

			<?php do_action( 'woocommerce_review_order_after_shipping' ); ?>

		<?php endif; ?>

		<?php foreach ( WC()->cart->get_fees() as $fee ) : ?>
			<tr class="fee">
				<th><?php echo esc_html( $fee->name ); ?></th>
				<td><?php wc_cart_totals_fee_html( $fee ); ?></td>
			</tr>
		<?php endforeach; ?>

		<?php if ( wc_tax_enabled() && ! WC()->cart->display_prices_including_tax() ) : ?>
			<?php if ( 'itemized' === get_option( 'woocommerce_tax_total_display' ) ) : ?>
				<?php foreach ( WC()->cart->get_tax_totals() as $code => $tax ) : // phpcs:ignore WordPress.WP.GlobalVariablesOverride.Prohibited ?>
					<tr class="tax-rate tax-rate-<?php echo esc_attr( sanitize_title( $code ) ); ?>">
						<th><?php echo esc_html( $tax->label ); ?></th>
						<td><?php echo wp_kses_post( $tax->formatted_amount ); ?></td>
					</tr>
				<?php endforeach; ?>
			<?php else : ?>
				<tr class="tax-total">
					<th><?php echo esc_html( WC()->countries->tax_or_vat() ); ?></th>
					<td><?php wc_cart_totals_taxes_total_html(); ?></td>
				</tr>
			<?php endif; ?>
		<?php endif; ?>

		<?php do_action( 'woocommerce_review_order_before_order_total' ); ?>

		<tr class="order-total">
			<th> </th><th><?php esc_html_e( 'Total', 'woocommerce' ); ?></th>
			<td><?php wc_cart_totals_order_total_html(); ?></td>
		</tr>

		<?php do_action( 'woocommerce_review_order_after_order_total' ); ?>

	</tfoot>	
	<script>
		document.addEventListener('DOMContentLoaded', function() {
			jQuery(document).on('click', '.woocommerce-checkout-review-order-table .product-remove a.remove', function(event) {
				event.preventDefault(); // Prevent the default link behavior

				var $this = jQuery(this);
				var productId = $this.data('product_id');
				jQuery.post($this.attr('href'), function() {
					var cartItems = JSON.parse(localStorage.getItem('cartItems')) || [];
					cartItems = cartItems.filter(function(item) {
						return item.id !== productId;
					});
					localStorage.setItem('cartItems', JSON.stringify(cartItems));
					window.location.reload();
				});
			});
			let urlString = location.href;
			let paramString = urlString.split('?')[1];
			let queryString = new URLSearchParams(paramString);
			var email = ''
			var fname = ''
			var lname = ''
			var service_id = 0
			var billing_city = ''
			var billing_country = ''
			let userData = localStorage.getItem('userData')
			if(userData){
				userData = JSON.parse(userData)
				if(userData){
					fname = userData['fname']
					lname = userData['lname']
					email = userData['email']					
					billing_city = userData['city']					
				}
			}
			for(let pair of queryString.entries()) {
				if(pair[0]=='service_id') service_id = pair[1]								
				if(pair[0]=='country') billing_country = pair[1]				
			}			
			if(fname && lname && email && service_id && billing_city && billing_country){
				jQuery('[name="billing_email"]').val(email)
				jQuery('[name="billing_first_name"]').val(fname)
				jQuery('[name="billing_last_name"]').val(lname)
				jQuery('[name="billing_service_id"]').val(service_id)
				jQuery('[name="billing_city"]').val(billing_city)
				jQuery('[name="billing_country"]').val(billing_country)
			} else {
				alert('Please fill in your details first.');
				location.href = "<?= site_url('signup'); ?>";
			}
		});
		if(jQuery != null){
			convert_aed_to_usd()
		}
		function convert_aed_to_usd(){
			var ajaxurl = "<?= admin_url('admin-ajax.php'); ?>"
			jQuery.ajax({
				url: ajaxurl,
				type: 'GET',
				data: {
					action: 'update_conversion_rate_ns'
				},
				success: function(response) {
					if (response.success) {											
						console.log('Live conversion of AED to USD is successful: ' + response.data.rate);
					} else {
						console.log('Error: ' + response.data.message);
					}
				},
				error: function() {
					console.log('AJAX request failed. Please try again.');
				}
			})
		}
	</script>
</table>
