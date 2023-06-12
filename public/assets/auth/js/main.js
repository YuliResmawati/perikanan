/* ----------------------------------------------------------------------------------------
* Author        	: Anik
* Author Web        : http://smartitsource.com/
* Template Name 	: Utrun is a App Landing Page Template.
* File          	: Custom js file
* Version       	: 1.0.0
* ---------------------------------------------------------------------------------------- */
(function ($) {
    "use strict";

        // Add current class
        jQuery(document).ready(function() {
          $("#header-top nav div.main-menu ul.navbar-nav li.nav-item a").click(function(){
              $("#header-top nav div.main-menu ul.navbar-nav li.nav-item a").removeClass('current');
              $(this).addClass("current");
          });
        });

      /*==============================
        Wow
      ================================*/ 
        AOS.init();


      /*==============================
        Smoth Scroll js
      ================================*/ 
        $('a.utrun-scroll[href*="#"]:not([href="#"])').on('click', function () {
            if (location.pathname.replace(/^\//, '') == this.pathname.replace(/^\//, '') && location.hostname == this.hostname) {
                var target = $(this.hash);
                target = target.length ? target : $('[name=' + this.hash.slice(1) + ']');
                if (target.length) {
                    $('html, body').animate({
                        scrollTop: (target.offset().top -90)
                    }, 1000, "easeInOutExpo");
                    return false;
                }
            }
        });


      /*==============================
        Tabl Active class
      ================================*/ 
    	$(document).ready(function(){
        $(function(){
            $(".cd-pricing-switcher label").click(function(){
                $(".cd-pricing-switcher label").removeClass('active');
                $(this).addClass("active");
            });
        });
    	});

      /*==============================
        Sticky Menu Header
      ================================*/ 
        var windows = $(window);
        var sticky = $('.sticky-hidden');

        windows.on('scroll', function() {
            var scroll = windows.scrollTop();
            if (scroll < 300) {
                sticky.removeClass('sticky-opnen');
            }else{
                sticky.addClass('sticky-opnen');
            }
        });
      /*==============================
        Preloader js
      ================================*/ 
        var preLoader = $(window);
        preLoader.on("load", function () {
            var preloader = jQuery('#loading');
            var spinnerTime = jQuery('.lds-dual-ring');
            preloader.fadeOut();
            spinnerTime.delay(400).fadeOut('slow');
        });

      /*==============================
        Owl Carousel Client Logo
      ================================*/ 
        $('#client-logo').owlCarousel({

            autoplay:true,
            autoplayTimeout:3000,
            autoplayHoverPause:true,
            loop:true,
            dots: false,
            singleItem:true,
            // margin:10,
            responsive:{
              0:{
                items: 1,
                nav: false
              },
              768:{
                items: 3,
                nav: false
              },
              991:{
                items: 6,
                nav: false,
                singleItem:false,
              }
            }
        });


      /*==============================
        Owl Carousel Client Testimonial
      ================================*/ 
        $('#client-testimoni').owlCarousel({

            autoplay:true,
            autoplayTimeout:3000,
            autoplayHoverPause:true,
            loop:true,
            dots: false,
            singleItem:true,
             margin:30,
             nav:true, 
             navText: ["<i class='flaticon-back'></i>","<i class='flaticon-next'></i>"],
            responsive:{
              0:{
                items: 1,
                nav: false
              },
              768:{
                items: 2,
                nav: false
              },
              991:{
                items: 3,
                nav: true,
                singleItem:false
              }
            }
        });

     /*==============================
        Scroll To Top
      ================================*/ 
      $(window).scroll(function(){
          if ($(this).scrollTop() > 100) {
            $(".scroll-top-top").fadeIn('600');
          }else{
            $(".scroll-top-top").fadeOut('700');
          }
      });

      // Top to Scroll 
      $(document).ready(function() {
          $(".scroll-top-top").on("click", function(){
             $('html, body').animate({scrollTop: 0}, 'slow');
          });
      });

      /*==============================
        Animate Tab 
      ================================*/ 
jQuery(document).ready(function($){
    //hide the subtle gradient layer (.cd-pricing-list > li::after) when pricing table has been scrolled to the end (mobile version only)
    checkScrolling($('.cd-pricing-body'));
    $(window).on('resize', function(){
      window.requestAnimationFrame(function(){checkScrolling($('.cd-pricing-body'))});
    });
    $('.cd-pricing-body').on('scroll', function(){ 
      var selected = $(this);
      window.requestAnimationFrame(function(){checkScrolling(selected)});
    });

    function checkScrolling(tables){
      tables.each(function(){
        var table= $(this),
          totalTableWidth = parseInt(table.children('.cd-pricing-features').width()),
          tableViewport = parseInt(table.width());
        if( table.scrollLeft() >= totalTableWidth - tableViewport -1 ) {
          table.parent('li').addClass('is-ended');
        } else {
          table.parent('li').removeClass('is-ended');
        }
      });
    }

    //switch from monthly to annual pricing tables
    bouncy_filter($('.cd-pricing-container'));

    function bouncy_filter(container) {
      container.each(function(){
        var pricing_table = $(this);
        var filter_list_container = pricing_table.children('.cd-pricing-switcher'),
          filter_radios = filter_list_container.find('input[type="radio"]'),
          pricing_table_wrapper = pricing_table.find('.cd-pricing-wrapper');

        //store pricing table items
        var table_elements = {};
        filter_radios.each(function(){
          var filter_type = $(this).val();
          table_elements[filter_type] = pricing_table_wrapper.find('li[data-type="'+filter_type+'"]');
        });

        //detect input change event
        filter_radios.on('change', function(event){
          event.preventDefault();
          //detect which radio input item was checked
          var selected_filter = $(event.target).val();

          //give higher z-index to the pricing table items selected by the radio input
          show_selected_items(table_elements[selected_filter]);

          //rotate each cd-pricing-wrapper 
          //at the end of the animation hide the not-selected pricing tables and rotate back the .cd-pricing-wrapper
          
          if( !Modernizr.cssanimations ) {
            hide_not_selected_items(table_elements, selected_filter);
            pricing_table_wrapper.removeClass('is-switched');
          } else {
            pricing_table_wrapper.addClass('is-switched').eq(0).one('webkitAnimationEnd oanimationend msAnimationEnd animationend', function() {    
              hide_not_selected_items(table_elements, selected_filter);
              pricing_table_wrapper.removeClass('is-switched');
              //change rotation direction if .cd-pricing-list has the .cd-bounce-invert class
              if(pricing_table.find('.cd-pricing-list').hasClass('cd-bounce-invert')) pricing_table_wrapper.toggleClass('reverse-animation');
            });
          }
        });
      });
    }
    function show_selected_items(selected_elements) {
      selected_elements.addClass('is-selected');
    }

    function hide_not_selected_items(table_containers, filter) {
      $.each(table_containers, function(key, value){
          if ( key != filter ) {  
          $(this).removeClass('is-visible is-selected').addClass('is-hidden');

        } else {
          $(this).addClass('is-visible').removeClass('is-hidden is-selected');
        }
      });
    }
  });


})(jQuery);


