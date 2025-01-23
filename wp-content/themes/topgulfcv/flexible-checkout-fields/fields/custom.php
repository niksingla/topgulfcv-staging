
<?php
switch ( $args['type'] ) {
    case 'country':
    $countries = 'shipping_country' === $key ? WC()->countries->get_shipping_countries() : WC()->countries->get_allowed_countries();        
    if ( 1 === count( $countries ) ) { ?>
            
            <strong><?php echo current( array_values( $countries ) ); ?></strong>
            
            <input type="hidden" name="<?php echo esc_attr( $key ); ?>" id="<?php echo esc_attr( $args['id'] ); ?>" value="<?php echo current( array_keys( $countries ) ); ?>" <?php echo implode( ' ', $custom_attributes ); ?> class="country_to_state" readonly="readonly" />
            
            <?php } else { ?>
                <div class="form-row form-group">
                    <?php $data_label = ! empty( $args['label'] ) ? 'data-label="' . esc_attr( $args['label'] ) . '"' : ''; ?>
                    <label for="<?php echo esc_attr( $key ); ?>">
                        <?php echo wp_kses_post( $args['label'] ); ?><?php if ( $args['required'] ) : ?>*<?php endif; ?>                        
                    </label>
                    <select name="<?php echo esc_attr( $key ); ?>" id="<?php echo esc_attr( $args['id'] ); ?>" class="country_to_state country_select form-control<?php echo esc_attr( implode( ' ', $args['input_class'] ) ); ?>" <?php echo implode( ' ', $custom_attributes ); ?> data-placeholder="<?php echo esc_attr( $args['placeholder'] ? $args['placeholder'] : esc_attr__( 'Select a country / region&hellip;', 'woocommerce' ) ); ?>" <?php echo $data_label; ?>>
                        <option value=""><?php echo esc_html__( 'Select a country / region&hellip;', 'woocommerce' ); ?></option>
        
                        <?php foreach ( $countries as $ckey => $cvalue ) { ?>
                            <option value="<?php echo esc_attr( $ckey ); ?>" <?php selected( $value, $ckey, false ); ?>><?php echo esc_html( $cvalue ); ?></option>
                        <?php } ?>
        
                    </select>
        
                    <noscript>
                        <button type="submit" name="woocommerce_checkout_update_totals" value="<?php echo esc_attr__( 'Update country / region', 'woocommerce' ); ?>"><?php echo esc_html__( 'Update country / region', 'woocommerce' ); ?></button>
                    </noscript>
                    
                </div>
                <?php }?>
        <?php 
        
        break;
        case 'file': 
            if($args['id'] == 'billing_uploaded_resume'): ?>            
                <div class="form-row form-group <?php echo esc_attr( $args['class']) ?esc_attr( $args['class']) :'' ; ?>"
                    id="<?php echo esc_attr( $key ); ?>_field"
                    data-priority="<?php echo esc_attr( $args['priority'] ); ?>"
                    data-fcf-field="<?php echo esc_attr( $key ); ?>" >
                    <div class="upload-left-image">
                    <label class="file" for="<?php echo esc_attr( $key ); ?>">
                        <span class='file-name'><?php echo wp_kses_post( $args['label'] ); ?></span>
                        <input type="file"
                            name="<?php echo esc_attr( $key ); ?>"
                            ondragover="allowDrop(event)"
                            oninput="cvChange(event)"
                            ondrop="handleDrop(event)"
                            id="<?php echo esc_attr( $key ); ?>"
                            data-fcf-field-input="<?php echo esc_attr( $key ); ?>"
                            required />
                        <p id="cvError" class="error" style="font-size:0.75em;color: var(--wc-red);margin: 0px;margin-top: -10px;text-align: left;"></p>
                    </label>

                    </div>   
                    <p class="selected-file d-none"></p>                          
                </div>
                <script type="text/javascript">
                    jQuery('#<?php echo esc_attr( $key ); ?>').on('change', function() {
                        const fileInput = jQuery(this)[0];
                        if (fileInput.files.length > 0) {
                            const formData = new FormData();
                            formData.append('billing_uploaded_resume', fileInput.files[0]);
                            formData.append('action', 'uplaod_the_cv_manually'); // Add action to FormData

                            // Get WooCommerce nonce using [name]
                            const checkoutNonce = jQuery('[name="woocommerce-process-checkout-nonce"]').val();
                            if (checkoutNonce) {
                                formData.append('woocommerce-process-checkout-nonce', checkoutNonce);
                            }

                            fetch('<?= admin_url('admin-ajax.php')?>', {
                                method: 'POST',
                                body: formData
                            })
                            .then(response => response.json())
                            .then(data => {
                                if (data.success) {
                                    data = data.data;

                                    const hiddenInput = document.createElement('input');
                                    hiddenInput.type = 'hidden';
                                    hiddenInput.name = 'uploaded_resume';
                                    hiddenInput.value = data.file_url;
                                    const billingForm = document.querySelector('form.checkout');
                                    billingForm.appendChild(hiddenInput);
                                }
                            })
                            .catch(error => {
                                console.error('Error uploading file:', error);
                            });
                        }
                    });

                    function allowDrop(event){
                        event.preventDefault()
                    }
                    function cvChange(event){                                
                        document.querySelector('span.file-name').innerHTML = event.target.files[0].name                               
                    }
                    function handleDrop(event){                                
                        event.preventDefault();                                
                        const fileInput = document.getElementById('<?php echo esc_attr( $key ); ?>');
                        const dropArea = document.getElementById('dropArea');
                        const files = event.dataTransfer.files;                                
                        if (files.length > 0) {
                            fileInput.files = files;
                            fileInput.dispatchEvent(new Event('change'));
                            document.querySelector('span.file-name').innerHTML = files[0].name                    
                        }
                    }
                    jQuery('form').on('checkout_place_order', function(e) {
                        if (validateUserForm()) return true
                        return false                    
                    });                
                    
                    const ui_cv_input = document.getElementById("billing_uploaded_resume");
                    function validateField(input, errorElement, errorMessage, minLength = 0) {
                        if (!input || !errorElement) return;

                        if (input.value.trim() === "") {
                            document.querySelector('.file-name').innerHTML = "<?php echo wp_kses_post( $args['label'] ); ?>"
                            errorElement.innerHTML = errorMessage;
                        }
                        else errorElement.innerHTML = ''
                    }

                    ui_cv_input && ui_cv_input.addEventListener('input', function() {
                        validateField(ui_cv_input, document.getElementById("cvError"), "CV is required");
                    });

                    // Define validateUserForm in the global scope
                    window.validateUserForm = function() {
                        if (ui_cv_input) {
                            validateField(ui_cv_input, document.getElementById("cvError"), "CV is required");
                        }

                        // Check if any error messages are present
                        const errors = document.querySelectorAll('.error');
                        for (const error of errors) {
                            if (error.innerText) {
                                return false;
                            }
                        }
                        return true;
                    }
                </script>
            <?php endif;?>
        <?php break;
}
