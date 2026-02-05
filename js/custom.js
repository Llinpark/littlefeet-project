(function ($) {
  "use strict";

    // CUSTOM LINK WITH AUTOMATIC MENU RETREAT
    $('.smoothscroll, .nav-link').click(function(){
        var el = $(this).attr('href');
        var elWrapped = $(el);
        var header_height = $('.navbar').height();

        // Closes both collapse and offcanvas mobile menus
        $('.navbar-collapse').collapse('hide');
        $('.offcanvas').offcanvas('hide');

        if(elWrapped.length) {
            scrollToDiv(elWrapped, header_height);
            return false;
        }
    });

    function scrollToDiv(element, navheight){
        var offset = element.offset();
        var offsetTop = offset.top;
        var totalScroll = offsetTop - navheight;

        $('body,html').animate({
            scrollTop: totalScroll
        }, 300);
    }
    
})(window.jQuery);


// (function ($) {
//   "use strict";

//     // NEW: Handle scroll-to-ID when arriving from another page (like donate.html)
//     $(window).on('load', function() {
//         if (window.location.hash) {
//             var target = $(window.location.hash);
//             var header_height = $('.navbar').height();
            
//             if (target.length) {
//                 scrollToDiv(target, header_height);
//             }
//         }
//     });

//     // CUSTOM LINK WITH AUTOMATIC MENU RETREAT
//     $('.smoothscroll, .nav-link').click(function(){
//         var el = $(this).attr('href');
        
//         // Only trigger smooth scroll if the link is an ID on the same page
//         if (el.startsWith('#')) {
//             var elWrapped = $(el);
//             var header_height = $('.navbar').height();

//             $('.navbar-collapse').collapse('hide');
//             $('.offcanvas').offcanvas('hide');

//             if(elWrapped.length) {
//                 scrollToDiv(elWrapped, header_height);
//                 return false;
//             }
//         }
//     });

//     function scrollToDiv(element, navheight){
//         var offset = element.offset();
//         var offsetTop = offset.top;
//         var totalScroll = offsetTop - navheight;

//         $('body,html').animate({
//             scrollTop: totalScroll
//         }, 500);
//     }
    
// })(window.jQuery);

// (function ($) {
//   "use strict";

//     // 1. FIX: Handle jumps from other pages (like donate.html)
//     $(window).on('load', function() {
//         if (window.location.hash) {
//             var target = $(window.location.hash);
//             if (target.length) {
//                 var header_height = $('.navbar').outerHeight();
//                 $('html, body').scrollTop(0); // Reset to top first
//                 setTimeout(function() {
//                     scrollToDiv(target, header_height);
//                 }, 300); // Small delay to allow page rendering
//             }
//         }
//     });

//     // 2. SMOOTH SCROLL FOR LINKS
//     $('.smoothscroll, .nav-link').click(function(e){
//         var el = $(this).attr('href');
        
//         // If it's an internal link on the same page
//         if (el.startsWith('#') || el.startsWith('index.html#')) {
//             var targetId = el.includes('#') ? '#' + el.split('#')[1] : el;
//             var elWrapped = $(targetId);
            
//             if(elWrapped.length) {
//                 e.preventDefault(); // Stop page reload
//                 var header_height = $('.navbar').outerHeight();

//                 $('.navbar-collapse').collapse('hide');
//                 $('.offcanvas').offcanvas('hide');

//                 scrollToDiv(elWrapped, header_height);
//             }
//         }
//     });

//     function scrollToDiv(element, navheight){
//         var offset = element.offset();
//         var totalScroll = offset.top - navheight;

//         $('body,html').animate({
//             scrollTop: totalScroll
//         }, 500);
//     }
    
// })(window.jQuery);