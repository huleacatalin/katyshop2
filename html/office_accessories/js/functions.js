$(function() {
	$('.field, textarea').focus(function() {
        if(this.title==this.value) {
            this.value = '';
        }
    }).blur(function(){
        if(this.value=='') {
            this.value = this.title;
        }
    });

    $('#sort-nav ul li').hover( function(){
        $(this).find('.dd').show();
    }, function() {
        $(this).find('.dd').hide();
    });

    $('.search-expand').click( function(){
       $(this).slideToggle();
       $('#search').slideToggle(); 
    });

    $('.retract-button').click( function() {
       $('#search').slideToggle();
       $('.search-expand').slideToggle(); 
    });

    $("#slider").jcarousel({
        scroll: 1,
        auto: 2,
        wrap: 'both',
        initCallback: mycarousel_initCallback,
        // This tells jCarousel NOT to autobuild prev/next buttons
        buttonNextHTML: null,
        buttonPrevHTML: null,
        itemVisibleInCallback: {
            onAfterAnimation: function(c, o, i, s) {
                $('.jcarousel-control a').removeClass('active');
                $('.jcarousel-control a:eq('+ (i-1) +')').addClass('active');
            }
        }
    }); 

    $('.product').hover( function() {
    	$(this).css('background-position', '0 -300px');       
    }, function() {
    	$(this).css('background-position', '0 0');    	
    });

    $(".product").click(function(){
        window.location=$(this).find("a").attr("href");
     return false;
    });

    $('.scroll-pane').jScrollPane({
        showArrows: true,
        horizontalDragMinWidth: 28,
        horizontalDragMaxWidth: 28       
    });
    
    if ($.browser.msie && $.browser.version == 6) {
        DD_belatedPNG.fix('#logo a, .search-expand, #search, .slider-holder, span.label-left, span.label-right, .label-bg, .label, .products-holder, .box-holder, .top, .bottom, .product, .footer-logo img, .jspHorizontalBar, .jspTrack, .jspDrag, .jspArrowRight, .jspArrowLeft');
    }

    var width =  24 * $('.jcarousel-control a').length;    
    $('.jcarousel-control').width(width+24);
    var left_pos = ((994 - width)/2 ) + 1;
    $('.jcarousel-control').css('left' , left_pos );                
});

 function mycarousel_initCallback(carousel) {
    jQuery('.jcarousel-control a').bind('click', function() {
        $('.jcarousel-control a').removeClass('active');
        $(this).addClass('active');
        carousel.scroll(jQuery.jcarousel.intval(jQuery(this).text()));
        return false;
    });
};    