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
    var owl = $('.banner-slider');
    owl.owlCarousel({
        items: 1,
        loop: true,
        dots: false,
        nav: false,
        margin: 5,
        autoplay: true,
        autoplayTimeout: 2500,
        autoplaySpeed: 1000,
    });

});
$(document).ready(function () {
    $(".client-slider").owlCarousel({
        loop: true,
        margin: 30,
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


// AOS.init({
//    offset: 200,
//    duration: 600,
//    easing: 'ease-in-sine',
//    delay: 100,
//  });


