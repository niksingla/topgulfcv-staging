<?php 

get_header();
?>
<style>
    .error{
        color:red;
        margin:0px;
        text-align:left;
    }
</style>    
	<main id="primary" class="site-main">
        <!-- form-inner  -->
        <section class="all-form">
            <div class="container">
                <div class="form-inner">
                    <?php
                    $my_items = [];
                    $total = 0;
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
                        $my_items[] = get_post($product_id)->post_title;                                                
                        $total += wc_get_product($product_id)->price;   
                        
                    }
                    if(!empty($my_items)):?> 
           
                        <h3 class="section-title text-center" style="font-size:35px;">You are one step closer to achieving your true potential in the job market!</h3>
                        <?php wc_print_notices(); ?>
                        <form method="post" <?php echo $is_resume_upload ? 'enctype="multipart/form-data"':''; ?>>
                        <?php do_action( 'woocommerce_register_form_start' ); ?>
                        <div class="form-group">
                                <label>First name*</label>
                                <input type="text" placeholder="Enter your first name" name="fname" id="reg_fname" class="form-control" maxlength="20" required>
                                <p id="userError" class="error"></p>
                            </div>
                            <div class="form-group">
                                <label>Last name*</label>
                                <input type="text" placeholder="Enter your last name" name="lname" id="reg_lname" class="form-control" maxlength="20" required>
                                <p id="lastError" class="error"></p>
                            </div>

                            <div class="row">
                                <div class="col">
                                    <div class="form-group">
                                        <label>City*</label>
                                        <input type="text" placeholder="Enter City" name="city" id="reg_city" class="form-control" required>
                                        <p id="cityError" class="error"></p>
                                    </div>
                                </div>
                                <div class="col">
                                <div class="form-group">
                                    <?php
                                    // Hardcoded list of countries
                                    $countries = [
                                        "Afghanistan", "Albania", "Algeria", "Andorra", "Angola", "Antigua and Barbuda", "Argentina", "Armenia", "Australia",
                                        "Austria", "Azerbaijan", "Bahamas", "Bahrain", "Bangladesh", "Barbados", "Belarus", "Belgium", "Belize", "Benin", "Bhutan",
                                        "Bolivia", "Bosnia and Herzegovina", "Botswana", "Brazil", "Brunei", "Bulgaria", "Burkina Faso", "Burundi", "Cabo Verde",
                                        "Cambodia", "Cameroon", "Canada", "Central African Republic", "Chad", "Chile", "China", "Colombia", "Comoros", "Congo, Democratic Republic of the",
                                        "Congo, Republic of the", "Costa Rica", "Croatia", "Cuba", "Cyprus", "Czechia", "Denmark", "Djibouti", "Dominica", "Dominican Republic",
                                        "East Timor", "Ecuador", "Egypt", "El Salvador", "Equatorial Guinea", "Eritrea", "Estonia", "Eswatini", "Ethiopia", "Fiji", "Finland",
                                        "France", "Gabon", "Gambia", "Georgia", "Germany", "Ghana", "Greece", "Grenada", "Guatemala", "Guinea", "Guinea-Bissau", "Guyana",
                                        "Haiti", "Honduras", "Hungary", "Iceland", "India", "Indonesia", "Iran", "Iraq", "Ireland", "Israel", "Italy", "Jamaica", "Japan",
                                        "Jordan", "Kazakhstan", "Kenya", "Kiribati", "Korea, North", "Korea, South", "Kosovo", "Kuwait", "Kyrgyzstan", "Laos", "Latvia",
                                        "Lebanon", "Lesotho", "Liberia", "Libya", "Liechtenstein", "Lithuania", "Luxembourg", "Madagascar", "Malawi", "Malaysia", "Maldives",
                                        "Mali", "Malta", "Marshall Islands", "Mauritania", "Mauritius", "Mexico", "Micronesia", "Moldova", "Monaco", "Mongolia", "Montenegro",
                                        "Morocco", "Mozambique", "Myanmar", "Namibia", "Nauru", "Nepal", "Netherlands", "New Zealand", "Nicaragua", "Niger", "Nigeria",
                                        "North Macedonia", "Norway", "Oman", "Pakistan", "Palau", "Palestine", "Panama", "Papua New Guinea", "Paraguay", "Peru", "Philippines",
                                        "Poland", "Portugal", "Qatar", "Romania", "Russia", "Rwanda", "Saint Kitts and Nevis", "Saint Lucia", "Saint Vincent and the Grenadines",
                                        "Samoa", "San Marino", "Sao Tome and Principe", "Saudi Arabia", "Senegal", "Serbia", "Seychelles", "Sierra Leone", "Singapore", "Slovakia",
                                        "Slovenia", "Solomon Islands", "Somalia", "South Africa", "South Sudan", "Spain", "Sri Lanka", "Sudan", "Suriname", "Sweden", "Switzerland",
                                        "Syria", "Taiwan", "Tajikistan", "Tanzania", "Thailand", "Togo", "Tonga", "Trinidad and Tobago", "Tunisia", "Turkey", "Turkmenistan",
                                        "Tuvalu", "Uganda", "Ukraine", "United Arab Emirates", "United Kingdom", "United States", "Uruguay", "Uzbekistan", "Vanuatu", "Vatican City",
                                        "Venezuela", "Vietnam", "Yemen", "Zambia", "Zimbabwe"
                                    ];

                                    // Sort the countries alphabetically
                                    sort($countries);
                                    ?>
                                    <label>Select Country*</label>
                                    <select name="country" id="reg_country" class="form-control" required>
                                        <option value="">Select a country</option>
                                        <?php
                                        foreach ($countries as $country) {
                                            echo '<option value="' . $country . '">' . $country . '</option>';
                                        }
                                        ?>
                                    </select>
                                    <p id="countryError" class="error"></p>
                                </div>

                                </div>
                            </div>
                            <div class="form-group">
                                <label>Email*</label>
                                <input type="email" name="email" id="reg_email" placeholder="Enter your email" class="form-control" required>
                                <p id="emailError" class="error"></p>
                            </div>
                            <?php if($is_resume_upload){ // if CV/Resume Analysis is selected ?>
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
                            <?php }?>
                            <div class="form-check">
                            <input class="form-check-input" type="checkbox" value="on" name="marketing" data-name="marketing">
                                <label class="form-check-label" for="newsletter">
                                    Would you like to receive job seeking tips, insights, updates and marketing emails?
                                </label>
                              
                            </div>
                            <!-- <div class="form-check"> -->
                                <!-- <input class="form-check-input" type="checkbox" value="" id="agreement" required> -->
                                <!-- <label class="form-check-label" for="agreement"> -->
                                <p>By signing up, and submitting your CV/Resume, you agree to our <a href="/terms-conditions/">Terms & Conditions</a> and <a href="/privacy-policy/">Privacy Policy</a> </p>
                                <!-- </label> -->
                            <!-- </div> -->
                            <?php wp_nonce_field( 'topgulfcv-register', 'topgulfcv-register-nonce' ); ?>
                            <input type="hidden" name="service_name" value="<?= implode(', ',$my_items); ?>">
                            <input type="hidden" name="total_amount" value="<?= $total; ?>">
                            <div class="sign-in-btn">
                                <button class="red-btn" onclick="return validateUserForm()" type="submit" name="register">
                                Proceed To Checkout
                                </button>
                            </div>
                            <?php //do_action( 'woocommerce_register_form' ); ?>

                            <?php //do_action( 'woocommerce_register_form_end' ); ?>
                        </form>
                        <?php if($is_resume_upload){ // if CV/Resume Analysis is selected ?>
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
                        <?php } ?>
                    <?php else:  ?>
                        <h2>No services added to the cart.</h2>
                        <a href="/paid-services/" class="red-btn my-2 my-sm-4">Continue Shopping</a>

                    <?php endif; ?>

                </div>
            </div>
        </section>
        <!-- form-inner  -->
    </main><!-- #main -->
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const reg_fname = document.getElementById("reg_fname");
            const reg_lname = document.getElementById("reg_lname");
            const reg_city = document.getElementById("reg_city");
            const reg_country = document.getElementById("reg_country");
            const reg_email = document.getElementById("reg_email");
            const ui_cv_input = document.getElementById("ui_cv_input");

            function validateField(input, errorElement, errorMessage, minLength = 0) {
                if (!input || !errorElement) return;

                if (input.value.trim() === "") {
                    errorElement.innerHTML = errorMessage;
                } else if (minLength > 0 && input.value.trim().length < minLength) {
                    errorElement.innerHTML = `Please enter a valid name.`; 
                } else {
                    errorElement.innerHTML = "";
                }
            }

            reg_fname && reg_fname.addEventListener('input', function() {
                validateField(reg_fname, document.getElementById("userError"), "First name is required", 2);
            });
            
            reg_lname && reg_lname.addEventListener('input', function() {
                validateField(reg_lname, document.getElementById("lastError"), "Last name is required", 2);
            });
            
            reg_city && reg_city.addEventListener('input', function() {
                validateField(reg_city, document.getElementById("cityError"), "City is required");
            });
            
            reg_country && reg_country.addEventListener('input', function() {
                validateField(reg_country, document.getElementById("countryError"), "Country is required");
            });
            
            reg_email && reg_email.addEventListener('input', function() {
                validateField(reg_email, document.getElementById("emailError"), "Email is required");

                // Check email format
                if (reg_email.value !== "" && !/^[A-Za-z0-9._%+-]+@[A-Za-z0-9.-]+\.[A-Za-z]{2,}$/.test(reg_email.value)) {
                    document.getElementById("emailError").innerHTML = "Invalid email format";
                }
            });
            
            ui_cv_input && ui_cv_input.addEventListener('input', function() {
                validateField(ui_cv_input, document.getElementById("cvError"), "CV is required");
            });

            // Define validateUserForm in the global scope
            window.validateUserForm = function() {
                validateField(reg_fname, document.getElementById("userError"), "First name is required", 2);
                validateField(reg_lname, document.getElementById("lastError"), "Last name is required", 2);
                validateField(reg_city, document.getElementById("cityError"), "City is required");
                validateField(reg_country, document.getElementById("countryError"), "Country is required");
                validateField(reg_email, document.getElementById("emailError"), "Email is required");
                
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

            // Add an event listener to the button instead of using onclick in HTML
            const submitButton = document.querySelector(".sign-in-btn button");
            submitButton && submitButton.addEventListener("click", function(event) {
                if (!validateUserForm()) {
                    event.preventDefault(); // Prevent form submission if validation fails
                } else {
                    saveUserInfo(event)
                }
            });

            /** Autofill User info from local storage */
            let userInfo = JSON.parse(localStorage.getItem("userData"))
            if(userInfo){
                let fname = userInfo.fname ? userInfo.fname : ''
                let lname = userInfo.lname ? userInfo.lname : ''
                let city = userInfo.city ? userInfo.city : ''
                let country = userInfo.country ? userInfo.country : ''
                let email = userInfo.email ? userInfo.email : ''
                $('[name="fname"]').val(fname)
                $('[name="lname"]').val(lname)
                $('[name="city"]').val(city)
                $('[name="country"]').val(country)
                $('[name="email"]').val(email)            
            }
            
        });
        /** Save User info to the local storage */
        function saveUserInfo(e){
            let fname = $(e.target).parents('form').find('[name="fname"]').val()
            let lname = $(e.target).parents('form').find('[name="lname"]').val()
            let city = $(e.target).parents('form').find('[name="city"]').val()
            let country = $(e.target).parents('form').find('[name="country"]').val()
            let email = $(e.target).parents('form').find('[name="email"]').val()
            if(fname && lname && city && country && email){
                localStorage.setItem("userData", JSON.stringify({
                    fname: fname,
                    lname: lname,
                    city: city,
                    country: country,
                    email: email
                }));
            }
            // e.preventDefault()
        }
    </script>

<?php
?>

<?php
// $ppcp_data = WC()->session->get('ppcp');
// if ( $ppcp_data ) {
//     $order = $ppcp_data['order'];
//     if($order->payment_source() && $order->payment_source()->properties() && $order->payment_source()->properties()->account_status){
//         if($order->payment_source()->properties()->account_status == 'UNVERIFIED');
//     }
// }
?>            
<?php
if (!WC()->session->get('chosen_payment_method')) {
    WC()->session->set('chosen_payment_method', 'ppcp-gateway');    
}
get_footer();
?>