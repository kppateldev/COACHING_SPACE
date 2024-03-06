$(window).on('load', function() {
    $('.main-loader').hide();
    new WOW().init();
});


jQuery(document).ready(function () {
    if(jQuery(window).width() > 991){
        var header_height = jQuery('header').outerHeight();
        var stickyHeader = (jQuery('header').offset().top + header_height);
        jQuery(window).scroll(function(){
            if( jQuery(window).scrollTop() > stickyHeader ) {
                jQuery('header').addClass('stickyheader');
                jQuery('header').next('.page-height').css('padding-top', header_height+40);
            } else {
                jQuery('header').removeClass('stickyheader');
                jQuery('header').next('.page-height').css('padding-top', '');
            }
        });
    }
    jQuery(".toggle-btn").click(function(){
      jQuery("body").toggleClass("menu-open");
    });
    jQuery('.sidebar_overley').click(function (event) {
        // jQuery('body').removeClass('sidebar_open');
        jQuery('body').removeClass('menu-open');
    });
    jQuery(".menu li a").on("click", function(event) {
       jQuery("body").removeClass("menu-open");
    });

    /***DAshboard Sidebar***/
    jQuery('.has_sub_menu > a').click(function(){
        jQuery(this).next('.sub_menu').slideToggle();
        if(jQuery(this).parent('.has_sub_menu').hasClass('open')){
            jQuery(this).parent('.has_sub_menu').removeClass('open');
        } else {
            jQuery(this).parent('.has_sub_menu').addClass('open');
        }
    });
    /***/
    jQuery('.offcanvas-btn').click(function(){
        jQuery('body').toggleClass('dashboard-sidebar-wrap')
    });

    /******After Login MEnu*****/
     jQuery('.nav-user-linkbtn').click(function(){
        jQuery(".nav-user-links").not(jQuery(this).next()).removeClass('open-nav-box');
        jQuery(this).next('.nav-user-links').toggleClass('open-nav-box');
    });
})
