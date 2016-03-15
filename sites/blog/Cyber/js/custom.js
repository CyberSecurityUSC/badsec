(function($){
    $(window).load(function(){
    	$(".site-header-main").sticky({ topSpacing: 0, center:true, responsiveWidth: true });
    	$(".site-header-main").on('sticky-start', function() { $(".site-header-main").addClass('shrink'); $(".circle").attr("width","50px");});
    	$('.site-header-main').on('sticky-end', function() { $(".site-header-main").removeClass('shrink'); $(".circle").attr("width","75px"); });
    });
})(jQuery)