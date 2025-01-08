<?php 
$file_path = site_url().'/wp-content/uploads/2023/10/';
get_header();
?>
    <?php if(is_user_logged_in()){ ?>
        <main id="primary" class="site-main">
            <!-- form-inner  -->
        
            <section class="all-form">
                <div class="container">
                    <div class="form-inner">
                        <h3 class="section-title text-center">Upload CV</h3>
                        <p class="mt-2 text-center">Please upload your CV as PDF</p>
                        <div class="upload-left-image">
                            <form method="post" action="/upload">
                                <label class="file">
                                    <span class='file-name'>Upload CV</span>
                                    <input type="file" ondragover="allowDrop(event)" ondrop="handleDrop(event)" id="ui_cv_input" multiple="" />
                                </label>
                            </form>
                        </div>
                        <div class="upload-cv-btn">
                          <a href="/success-paid-services/">  <button class="red-btn" id="make-payment" disabled>Proceed to pay</button>
                            </a></div>
                        
                        <!-- <div class="upload-left-image">
                        <?php
                        echo do_shortcode('[contact-form-7 id="94774ec" title="Upload CV"]')
                        ?>    
                        </div> -->

                        <div class="hidden-uploader d-none">
                            <?php 
                            $shortcode = '[wordpress_file_upload uploadpath="uploads/cvs/%username%/" uploadrole="administrator,subscriber" createpath="true" redirect="true" redirectlink="/my-account/"]';
                            echo do_shortcode($shortcode); ?>
                        </div>
                    </div>
                </div>
            </section>
        <!-- form-inner  -->
        </main><!-- #main -->

        <script type="text/javascript">
            jQuery(document).ready(function($){
                $('#upfile_1').attr('accept', '.pdf')
                $('#ui_cv_input').click(function(e){
                    e.preventDefault();
                    const targetFileInput = document.getElementById('input_1');
                    targetFileInput.click();
                    return;
                })
            })
            
            function allowDrop(event){
                event.preventDefault()
            }
            function handleDrop(event){
                event.preventDefault();
                
                const fileInput = document.getElementById('upfile_1');
                const dropArea = document.getElementById('dropArea');

                const files = event.dataTransfer.files;

                if (files.length > 0) {
                    fileInput.files = files;
                    fileInput.dispatchEvent(new Event('change'));
                    document.querySelector('span.file-name').innerHTML = files[0].name
                }
            }
            $('#upfile_1').change(function(e){
                if (e.target.files.length > 0) {
                    document.querySelector('span.file-name').innerHTML = e.target.files[0].name
                    $('#make-payment').removeAttr('disabled')
                }
            })
            $('#make-payment').click(function(){
                jQuery('#make-payment').html('Please wait...');                
                if(!jQuery('#make-payment').is("[disabled]")){
                    $('#upload_1').click()
                }
            })
        </script>
    <?php } else {?>
        <h3 class="section-title text-center">Please Sign up to access this page</h3>
    <?php   }
get_footer();
?>