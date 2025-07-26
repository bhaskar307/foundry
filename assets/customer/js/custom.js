jQuery(document).ready(function($){
  

  var HHeight = $("header.header").outerHeight();
  $('.headerspace').css('height',HHeight);



	$(window).scroll(function () {
		if ($(this).scrollTop() > 5 ) {
			$('header.header').addClass('fixed');
		} else {
			$('header.header').removeClass('fixed');
		}
	}); 
  




  var swiper = new Swiper(".homeslider", {
    navigation: {
      nextEl: ".swiper-button-next",
      prevEl: ".swiper-button-prev",
    },
    pagination: {
      el: ".swiper-pagination",
      clickable: true,
    },
    autoplay: {
      delay: 4000,
      disableOnInteraction: false,
    },
  });  

  var swiper = new Swiper(".workslider", {
    slidesPerView: 2,
    loop: true,
    navigation: {
      nextEl: ".swiper-button-next",
      prevEl: ".swiper-button-prev",
    },
    breakpoints: {
      640: {
        slidesPerView: 2,
        spaceBetween: 10,
      },
      768: {
        slidesPerView: 2,
        spaceBetween: 20,
      },
      1024: {
        slidesPerView: 3,
        spaceBetween: 30,
      },
    },
  }); 
  
  var swiper = new Swiper(".eventslider", {
    slidesPerView: 1,
    grid: {
      rows: 2,
      fill: "row",
    },
    spaceBetween: 30,
    pagination: {
      el: ".swiper-pagination",
      clickable: true
    },
    on: {
    init:  function () {
        swiperClassHandler (this.activeIndex, '.swiper-slide')
      },
      slideChange: function () {
        swiperClassHandler (this.activeIndex, '.swiper-slide')
      },
    },
  });

  var swiper = new Swiper(".slide3", {
    slidesPerView: 1,
    spaceBetween: 10,
    pagination: {
      el: ".swiper-pagination",
      clickable: true,
    },
    breakpoints: {
      640: {
        slidesPerView: 1,
        spaceBetween: 20,
      },
      768: {
        slidesPerView: 2,
        spaceBetween: 40,
      },
      1024: {
        slidesPerView: 3,
        spaceBetween: 50,
      },
    },
  });

  var swiper = new Swiper(".featslide", {
    slidesPerView: 2,
    spaceBetween: 10,
    breakpoints: {
      640: {
        slidesPerView: 2,
        spaceBetween: 20,
      },
      768: {
        slidesPerView: 2,
        spaceBetween: 40,
      },
      1024: {
        slidesPerView: 4,
        spaceBetween: 50,
      },
    },
  });

  var swiper = new Swiper(".slide2", {
    slidesPerView: 1,
    spaceBetween: 10,
    pagination: {
      el: ".swiper-pagination",
      clickable: true,
    },
    autoplay: {
        delay: 2500,
        disableOnInteraction: false,
    },
    breakpoints: {
      640: {
          slidesPerView: 1,
          spaceBetween: 10,
      },
      768: {
          slidesPerView: 2,
          spaceBetween: 20,
      },
      1024: {
          slidesPerView: 2,
          spaceBetween: 20,
      },
    },
  });

  var swiper = new Swiper(".testislide", {
    slidesPerView: 1,
    spaceBetween: 10,
    loop: true,
    pagination: {
      el: ".swiper-pagination",
      clickable: true,
    },
    autoplay: {
      delay: 2500,
      disableOnInteraction: false,
    },
  });
   
  var $animation_elements = $('.imageeffect .wp-block-image, .fadeLeft, .fadeUp, .fadeRight, .fadePopup');
  var $window = $(window);
  function check_if_in_view() {
    var window_height = $window.height();
    var window_top_position = $window.scrollTop();
    var window_bottom_position = (window_top_position + window_height);
    $.each($animation_elements, function() {
      var $element = $(this);
      var element_height = $element.outerHeight();
      var element_top_position = $element.offset().top;
      var element_bottom_position = (element_top_position + element_height);
      if ((element_bottom_position >= window_top_position) &&
          (element_top_position <= window_bottom_position)) {
          $element.addClass('in-view');
      } else {
        //$element.removeClass('in-view');
      }
    });
  }
  $window.on('scroll resize', check_if_in_view);
  $window.trigger('scroll');

  const popoverTriggerList = document.querySelectorAll('[data-bs-toggle="popover"]')
const popoverList = [...popoverTriggerList].map(popoverTriggerEl => new bootstrap.Popover(popoverTriggerEl))


    
});

