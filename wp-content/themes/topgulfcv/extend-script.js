
console.log('Custom JavaScript loaded!');

document.addEventListener('DOMContentLoaded', function() {
    var extendLinkButton = document.getElementsByClassName('extendLinkButton');
    var extendLinkForm = document.getElementsByClassName('extendLinkForm');    
    var calendarInput = document.getElementsByClassName('calendar');
    var doneButton = document.getElementsByClassName('doneButton');

    if (extendLinkButton.length>0) {        
        for(let i=0; i<extendLinkButton.length;i++){            
            extendLinkButton[i].addEventListener('click', function(event) {
                event.preventDefault();
                let linkContainer = jQuery(event.target).parent('.extendLinkContainer');                
                linkContainer.find('.extendLinkForm').get(0).style.display = 'block';
                // extendLinkForm.style.display = 'block';
                initializeFlatpickr();
            });           
        }
    }

    function initializeFlatpickr() {
        for(let i=0; i<calendarInput.length;i++){
            var flatpickrInstance = flatpickr(calendarInput[i], {
                dateFormat: 'Y-m-d',
                minDate: 'today',
                // onChange: function(selectedDates, dateString, instance) {
                //     console.log('Selected Date:', dateString);
                // }
            });

        }            
    }
    if (doneButton.length>0) {
        for(let i=0; i<doneButton.length;i++){
            doneButton[i].addEventListener('click', function(event) {
                event.preventDefault();
                postID = event.target.dataset['post_id']    
                let linkContainer = jQuery(event.target).parents('.extendLinkContainer');
                var selectedDate = linkContainer.find('.flatpickr-input').val()            
                // var selectedDates = flatpickrInstance.selectedDates;
                if (postID && selectedDate) {                    
                    console.log('Formatted Date:', selectedDate);                     
                    submitFormAjax(postID,selectedDate);
                }
            });            
        }
    }


    function submitFormAjax(postID,selectedDate) {
        var ajaxurl = "<?php echo site_url()?>"+'/wp-admin/admin-ajax.php';  
        var formData = new FormData()
        formData.append('action','update_report_expiry')
        formData.append('postId',postID)
        formData.append('selectedDate',selectedDate)
        fetch(ajaxurl, {
            method: 'POST',
            body: formData
        })
        .then(response => response.text())
        .then(data => {
            alert('Link extended successfully!');
            window.location.reload();
        })
        .catch(error => {
            console.error('Error:', error);
        });
    }


});