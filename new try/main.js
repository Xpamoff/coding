$(document).ready(()=>{
    window.player = {};
    player.name = "";
    let btn = $('.play_btn');

    $('.name_input').on('input', ()=>{
        player.name = $('.name_input').val();
        btn.attr('disabled', !player.name);
    })
    btn.on('click', ()=>{
        localStorage.setItem("character_name", player.name);
        location.href = "game.html";
    })
    $('.toPlay').on('click', ()=>{
        let elem = $('.opening');
        $('body, html').animate({scrollTop:elem.offset().top}, 1500);
    })

});