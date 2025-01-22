
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
        case 'file': ?>
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
        <script type="text/javascript">
            function allowDrop(event){
                event.preventDefault()
            }
            function cvChange(event){                                
                document.querySelector('span.file-name').innerHTML = event.target.files[0].name                               
            }
            function handleDrop(event){                                
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
        <?php break;
}
