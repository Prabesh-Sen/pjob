//change navbar color
$(document).ready(function(){
    $(window).scroll(function(){
        var scroll=$(window).scrollTop();
        if(scroll>150){
            $(".navbar").css("background","#222");
            $(".navbar").css("box-shadow","rgba(0, 0,0, 0.1) 0px 4px 12px")
        }
        else{
            $(".navbar").css("background","transparent ");

        }
    })
})
//smooth scroll
var navbarHeight= $(".navbar").outerHeight();
$(".navbar-menu a").click(function(e){
    var targetHref= $(this).atter("href");
    $("html,body").animate({
        scrollTop: $(targetHref).offset().top - navbarHeight
    },1000)
    e.preventDefault();
});