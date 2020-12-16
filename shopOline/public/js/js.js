
$(document).ready(function(){
    //change menu icon
    $('#nav-icon1').click(function(){
        $(this).toggleClass('open');
    });

    // back to top
    $('.back-top').click(function(){
        $('html, body').animate({scrollTop:0}, '300');
    });

    $(window).bind('scroll', function() {
        var navHeight = $(window).height() - 500;
        if ($(window).scrollTop() > navHeight) {
            $('.back-top').css('opacity',1);
        } else {
            $('.back-top').css('opacity',0);
        }
    });
	$(window).scroll(function() {
        if ($(document).scrollTop() > 100) {
            $('.navbar').addClass('f');
        } else {
            $('.navbar').removeClass('f');
        }
    });
})


    