<?php
/*
* Template Name: Free Success Template
*
*
*/
get_header();
?>
<script>
document.addEventListener('DOMContentLoaded', function() {
    function getCookie(name) {
        let value = "; " + document.cookie;
        let parts = value.split("; " + name + "=");
        if (parts.length === 2) return parts.pop().split(";").shift();
    }

    if (!getCookie('visited_success_page')) {
        window.location.href = '/'; 
        exit;
    }
});
</script>
<div class="sucesswrapper"><?php echo the_field('heading'); ?></div>
<div class="container c-container">
    <div class="row justify-content-center">
        <?php
        $repeater_rows = get_field('upload_file');
        if ($repeater_rows) {
            foreach ($repeater_rows as $row) {
                $sub_field_1 = $row['cv'];
                $sub_field_2 = $row['heading'];
                $sub_field_3 = $row['content']; 
                ?>
                <div class="col-md-6 col-sm-12 col-12 mb-2 col-lg-6">
                    
                    <div class="job-sec-box template-box">  
                        <h3><?php echo esc_html($sub_field_2) ?></h3> 
                        <br>
                        <p><?php echo ($sub_field_3) ?></p>
                        <br>
                        <?php if ($sub_field_1 && pathinfo($sub_field_1, PATHINFO_EXTENSION) !== 'pdf') { ?>
                            <img src="<?php echo $sub_field_1; ?>">
                        <?php } else { ?>
                         <?php }?>
                        <div class="justify-content-center readm download_btn">
                            <?php if ($sub_field_1 && pathinfo($sub_field_1, PATHINFO_EXTENSION) !== 'pdf') { ?>
                                <a href="#" class="red-btn my-2 my-sm-4" id="downloadBtn">Download</a>
                            <?php } ?>
                        </div>
                    </div>
                    <?php if ($sub_field_1 && pathinfo($sub_field_1, PATHINFO_EXTENSION) == 'pdf') { ?>
                        <iframe id="pdf-view" class="pdf-iframe" src="<?php echo $sub_field_1; ?>" width="100%" height="500px"></iframe>
                        <p class='p-for-safari' style="display:none;">If the above PDF does not work, <a href="<?php echo esc_url($sub_field_1); ?>" target="_blank">click here to view the PDF</a>.</p>
                    <?php } ?>
                </div>
                <?php
            }
        }
        ?>    
    </div> 
</div> 
<script src="https://unpkg.com/html2pdf.js@0.10.0/dist/html2pdf.bundle.js"></script>
<script>
    document.querySelectorAll(".pdf-iframe").forEach((element,index)=>{ 
        element.contentWindow.onload = function() {
            if(this.document.getElementsByTagName("img")[0]){
                this.document.getElementsByTagName("img")[0].style.width="100%";
            }
        };
        if(!navigator.pdfViewerEnabled){
            jQuery('.pdf-iframe').hide()
        }
        if(/Android|webOS|iPhone|iPad|iPod|BlackBerry|IEMobile|Opera Mini/i.test(navigator.userAgent)){
            jQuery('.p-for-safari').show()
        }
    })    
</script>
<script>
    var numbering = 1;
    jQuery(document).ready(function($){
        $('.download_btn').click(function(){            
            var container = $(this).closest('.job-sec-box').get(0)
            var pdf = html2pdf(container, {
                margin: 10,
                filename: 'TopGulfCV_'+numbering+ '.pdf',
                image: { type: 'jpeg', quality: 0.98 },
                html2canvas: { scale: 2 },
                jsPDF: { unit: 'mm', format: 'a4', orientation: 'portrait' },
                html2pdf: { width: 800 },
            });
            numbering++
        })
    })
 </script>


<?php get_footer(); ?>
 