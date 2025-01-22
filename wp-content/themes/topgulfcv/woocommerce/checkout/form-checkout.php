<?php

/**
 * Checkout Form
 *
 * This template can be overridden by copying it to yourtheme/woocommerce/checkout/form-checkout.php.
 *
 * HOWEVER, on occasion WooCommerce will need to update template files and you
 * (the theme developer) will need to copy the new files to your theme to
 * maintain compatibility. We try to do this as little as possible, but it does
 * happen. When this occurs the version of the template file will be bumped and
 * the readme will list any important changes.
 *
 * @see https://woocommerce.com/document/template-structure/
 * @package WooCommerce\Templates
 * @version 9.4.0
 */

if (! defined('ABSPATH')) {
    exit;
}

do_action('woocommerce_before_checkout_form', $checkout);

// If checkout registration is disabled and not logged in, the user cannot checkout.
if (! $checkout->is_registration_enabled() && $checkout->is_registration_required() && ! is_user_logged_in()) {
    echo esc_html(apply_filters('woocommerce_checkout_must_be_logged_in_message', __('You must be logged in to checkout.', 'woocommerce')));
    return;
}

?>
<style>
    .woocommerce .all-form {
        padding: 0;
    }
    .checkout #customer_details-custom .form-group {
        padding: 0;
        margin: 0;
        margin-bottom: 15px;
    }
    .checkout #customer_details-custom .form-check {
        display: block;
        margin-bottom: 10px;
        padding: 20px 0;
    }
    .checkout #customer_details-custom .form-check input {
        padding: 0;
        height: 20px;
        width: 20px;
        margin-bottom: 0;
        margin-right: 0;
        margin-top: 12px;
        display: none;
        cursor: pointer;
        margin-left: 0px !important;
        display: inline-block;
        position: absolute;
    }
    .checkout #customer_details-custom .form-group span.select2-selection {
        display: block;
        width: 100%;
        height: calc(1.5em + 1.5rem + 2px);
        padding: 0.75rem 1rem;
        font-size: 1rem;
        font-weight: 400;
        line-height: 1.5;
        color: #1e2022;
        background-color: #fff;
        background-clip: padding-box;
        border: 1px solid #d5dae2;
        border-radius: 0.25rem;
        -webkit-transition: border-color 0.15s ease-in-out, -webkit-box-shadow 0.15s ease-in-out;
        transition: border-color 0.15s ease-in-out, -webkit-box-shadow 0.15s ease-in-out;
        -o-transition: border-color 0.15s ease-in-out, box-shadow 0.15s ease-in-out;
        transition: border-color 0.15s ease-in-out, box-shadow 0.15s ease-in-out;
        transition: border-color 0.15s ease-in-out, box-shadow 0.15s ease-in-out, -webkit-box-shadow 0.15s ease-in-out;
        outline: none;
    }
    .select2-container .select2-selection--single .select2-selection__rendered{
        padding-left:0;
        padding-right:0;
    }
    .checkout #customer_details-custom .form-group .select2-selection__arrow {
        top: 8px;
        right: 4px;
    }
    #customer_details-custom .form-inner {
        margin: 0;
    }
</style>
<form name="checkout" method="post" class="checkout woocommerce-checkout" action="<?php echo esc_url(wc_get_checkout_url()); ?>" enctype="multipart/form-data" aria-label="<?php echo esc_attr__('Checkout', 'woocommerce'); ?>">

    <div class="row">        
        <?php if ($checkout->get_checkout_fields()) : ?>
        
            <?php do_action('woocommerce_checkout_before_customer_details'); ?>

            <div class="col col-lg-4 col-md-6" id="customer_details-custom">
                <div class="all-form">
                    <div class="form-inner">
                        <?php do_action( 'woocommerce_checkout_billing' ); ?>
                        <?php
                        $my_items = [];
                        $total = 0;
                        $is_resume_upload = false;
                        foreach (WC()->cart->get_cart() as $cart_item_key => $cart_item) {
                            $product = $cart_item['data'];
                            $product_id = $cart_item['product_id'];
                            $product_tags = get_the_terms($product_id, 'product_tag');
                            if ($product_tags) {
                                foreach ($product_tags as $tag) {
                                    if (get_term($tag)->name == "resume_upload") {
                                        $is_resume_upload = true;
                                    }
                                }
                            }
                            $my_items[] = get_post($product_id)->post_title;
                            $total += wc_get_product($product_id)->price;
                        }
                        if ( !empty($my_items)): ?>
        
                            
                            <?php if ($is_resume_upload) { // if CV/Resume Analysis is selected 
                            ?>
                                <div class="form-group">
                                    <div class="upload-left-image">
                                        <label class="file">
                                            <span class='file-name'>Upload CV*</span>
                                            <input type="file" name="uploaded_resume" ondragover="allowDrop(event)" oninput="cvChange(event)" ondrop="handleDrop(event)" id="ui_cv_input" required />
                                            <p id="cvError" class="error"></p>
                                        </label>
        
                                    </div>
                                    <p class="selected-file d-none"></p>
                                </div>
                                <div class="form-group">
                                    <label> * Field Required </label>
                                </div>
                            <?php } ?>
                            <?php if ($is_resume_upload) { // if CV/Resume Analysis is selected 
                            ?>
                                <script type="text/javascript">
                                    function allowDrop(event) {
                                        event.preventDefault()
                                    }
        
                                    function cvChange(event) {
                                        document.querySelector('span.file-name').innerHTML = event.target.files[0].name
                                    }
        
                                    function handleDrop(event) {
                                        event.preventDefault();
                                        const fileInput = document.getElementById('ui_cv_input');
                                        const dropArea = document.getElementById('dropArea');
                                        const files = event.dataTransfer.files;
                                        if (files.length > 0) {
                                            fileInput.files = files;
                                            fileInput.dispatchEvent(new Event('change'));
                                            document.querySelector('span.file-name').innerHTML = files[0].name
                                        }
                                    }
                                </script>
                            <?php } ?>
                        <?php else:  ?>
                            <h2>No services added to the cart.</h2>
                            <a href="/paid-services/" class="red-btn my-2 my-sm-4">Continue Shopping</a>
        
                        <?php endif; ?>
                    </div>
                </div>                                    
                <?php do_action('woocommerce_checkout_after_customer_details'); ?>
            </div>
        <?php endif; ?>
        <div class="col col-lg-8 col-md-6">

            <?php do_action('woocommerce_checkout_before_order_review_heading'); ?>
        
            <h3 id="order_review_heading"><?php esc_html_e('Your order', 'woocommerce'); ?></h3>
        
            <?php do_action('woocommerce_checkout_before_order_review'); ?>
        
            <div id="order_review" class="woocommerce-checkout-review-order">
                <?php do_action('woocommerce_checkout_order_review'); ?>
            </div>
        
            <?php do_action('woocommerce_checkout_after_order_review'); ?>
        </div>
    </div>

</form>

<?php do_action('woocommerce_after_checkout_form', $checkout); ?>