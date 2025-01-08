document.addEventListener('change', function (e) {
    var inputFile = e.target;
    if (inputFile.type === 'file' && inputFile.files.length > 0) {
        var fileNameContainer = document.getElementById('selected-file-name');
        if (fileNameContainer) {
            fileNameContainer.textContent = inputFile.files[0].name;
        }
    }
});

// cf7 form error removed when type text 
document.addEventListener('DOMContentLoaded', function () {
    const requiredFields = document.querySelectorAll('.wpcf7-form-control.wpcf7-validates-as-required');
    requiredFields.forEach(field => {
        field.addEventListener('input', function () {
            const errorMessage = this.closest('.wpcf7-form-control-wrap').querySelector('.wpcf7-not-valid-tip');
            if (errorMessage) {
                errorMessage.style.display = 'none';
            }
            this.classList.remove('wpcf7-not-valid');
        });
    });
});


function validateForm() {
    var newsletterCheckbox = document.getElementById("newsletter");
    var agreementCheckbox = document.getElementById("agreement");

    if (!newsletterCheckbox.checked || !agreementCheckbox.checked) {
      alert("Please check both checkboxes before submitting the form.");
      return false;
    }

    return true; // Form will be submitted if both checkboxes are checked
  }
// sticky header
$(window).scroll(function () {
    if ($(this).scrollTop() > 1) {
        $("header").addClass("sticky_header");
    } else {
        $("header").removeClass("sticky_header");
    }
});

//slider
$(document).ready(function () {
    $(".hero-pannel").owlCarousel({
        loop: true,
        margin: 30,
        lazyLoad: true,
        nav: true,
        responsiveClass: true,
        dots: false,
        items: 1,
        autoplay: false,
        navText: [
            '<span class="arrow-left"><img src="/wp-content/uploads/2023/11/slider-left-arrow.png" alt="arrow" /></span>',
            '<span class="arrow-right"><img src="/wp-content/uploads/2023/11/slider-right-arrow.png" alt="arrow" /></span>',
        ],
    });
});

$(document).ready(function () {
    var owl = $('.logo-pannel');
    owl.owlCarousel({
        items: 7,
        loop: false,
        dots: false,
        nav: false,
        margin: 5,
        autoplay: true,
        slideTransition: 'linear',
        autoplayTimeout: 0,
        autoplaySpeed: 30000,
        responsive: {
            0: {
                items: 3,
            },
            768: {
                items: 5,
            },
        },

    });

});

$(document).ready(function () {
    $(".client-slider").owlCarousel({
        loop: true,
        margin: 30,
        lazyLoad: true,
        nav: true,
        responsiveClass: true,
        dots: true,
        items: 1,
        autoplay: false,
        navText: [
            '<span class="arrow-left"><img src="/wp-content/uploads/2023/11/slider-left-arrow.png" alt="arrow" /></span>',
            '<span class="arrow-right"><img src="/wp-content/uploads/2023/11/slider-right-arrow.png" alt="arrow" /></span>',
        ],
        responsive: {
            0: {
                items: 1,
            },
            768: {
                items: 1,
            },
        },
    });
});


// jQuery(document).ready(function(){
// var url = window.location.href;  
// console.log("url"+url);		 
// jQuery('input.wpcf7-form-control.wpcf7-hidden').attr("value",url) ; 	
//  }); 	



document.addEventListener('DOMContentLoaded', function() {
    function openPopup(id) {
        var popup = document.getElementById(id);
        if (popup) {
            popup.style.display = 'block';
            document.body.classList.add('overflow-hidden'); // Add the class to body
        }
    }

    function closePopup(popup) {
        if (popup) {
            popup.style.display = 'none';
            document.body.classList.remove('overflow-hidden'); // Remove the class from body
        }
    }

    function clearSessionStorage() {
        sessionStorage.removeItem('openPopupId');
    }

    document.body.addEventListener('click', function(event) {
        if (event.target.classList.contains('open-popup')) {
            var popupId = event.target.getAttribute('data-popup-id');
            openPopup(popupId);
            sessionStorage.setItem('openPopupId', popupId);
        } else if (event.target.classList.contains('close-btn')) {
            var popup = event.target.closest('.contact-form-popup');
            closePopup(popup);
            clearSessionStorage();
        } else if (event.target.classList.contains('contact-form-popup')) {
            closePopup(event.target);
            clearSessionStorage();
        }
    });

    function checkSessionStorage() {
        var popupId = sessionStorage.getItem('openPopupId');
        if (popupId && document.getElementById(popupId)) {
            openPopup(popupId);
        }
    }

    checkSessionStorage();
    window.addEventListener('hashchange', checkSessionStorage);
    document.addEventListener('wpcf7invalid', function(event) {
        var formId = event.detail.contactFormId;
        var popupId = 'wpcf7-' + formId;
        sessionStorage.setItem('openPopupId', popupId);
    });
});


