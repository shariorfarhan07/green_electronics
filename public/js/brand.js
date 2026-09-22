var owl = $('.owl-carousel');
owl.owlCarousel({
    //items:8,
    responsive:{
        0:{
            items:1,
            margin:0
        },
        600:{
            items:3,
            margin:10
        },
        1000:{
            items:6,
            margin:10

        }
    },
    loop:true,
    //margin:1,
    autoplay:true,
    autoplayTimeout:700,
    autoplayHoverPause:true

    
   


    
});
$('.play').on('click',function(){
    owl.trigger('play.owl.autoplay',[1000])
})
$('.stop').on('click',function(){
    owl.trigger('stop.owl.autoplay')
})