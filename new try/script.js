$(document).ready(()=>{
    window.player = {};
    const objectTypes = {
        grounds: '<div class="game-object grounds"></div>',
        heart: '<div class="game-object heart"></div>'
    }
    window.playground = {};
    player.elem = $('.player');
    playground.elem = $('.game');
    playground.downside = 324 - 32 - 32;
    player.x = 0;
    player.y = 0;
    let goRight = false;
    let goLeft = false;
    let isOnJump = false;
    let jumpStarted = false;
    player.jumpHeight = 128;

    const newHrt = $(objectTypes.heart);

    window.heart = {};
    heart.h1 = newHrt.clone();
    heart.h2 = newHrt.clone();

    drawHearts();

    initGrounds();
    initPlayer();

    document.addEventListener('keydown', going);
    document.addEventListener('keyup', stopping);


    function checkObjects(){
        if()
    }

    function drawHearts(){
        let h1x = Math.floor(Math.random()*(576-32)/2);
        let h2x = Math.floor(Math.random()*(576-32)/2 + (576-32)/2);
        let h1y = Math.floor(Math.random()*128 + playground.downside-128);
        let h2y = Math.floor(Math.random()*128 + playground.downside-128);

        heart.h1.css({'left' : `${h1x}px`, 'top' : `${h1y}px`});
        heart.h2.css({'left' : `${h2x}px`, 'top' : `${h2y}px`});
        playground.elem.append(heart.h1);
        playground.elem.append(heart.h2);
    }

    function draw(){
        if(goRight && player.x + 3 <= 576 - 32){
            player.elem.css({'background-image' : 'url("Biker.png")'});
            player.x += 3;
        }
        if(goLeft && player.x - 3 >=0){
            player.elem.css({'background-image' : 'url("Biker_rev.png")'});
            player.x -= 3;
        }
        if(isOnJump){
            if(jumpStarted){
                player.y += 4;
                if(player.y >= player.jumpHeight){
                    jumpStarted = false;
                }
            }
            else{
                player.y -= 4;
                if(player.y <= 0){
                    isOnJump = false;
                }
            }
        }

        checkObjects();
        player.elem.css({'left' : `${player.x}px`, 'top' : `${playground.downside - player.y}px`});
    }

    function going(e){
        if(e.keyCode == 39){
            goRight = true;
        }
        if(e.keyCode == 37){
            goLeft = true;
        }

        if(e.keyCode == 38 && !isOnJump){
            isOnJump = true;
            jumpStarted = true;
        }
    }
    function stopping(e){
        if(e.keyCode == 39){
            goRight = false;
        }
        if(e.keyCode == 37){
            goLeft = false;
        }
    }

    function initGrounds(){
        for(let x = 0; x < $(window).width()/32-1; x++){
            const newObj = $(objectTypes.grounds);
            const obj = newObj.clone();
            obj.css({'left' : `${x*32}px`, 'top' : `${playground.downside+32}px`});
            playground.elem.append(obj);
        }
    }
    function initPlayer(){
        player.elem.css({'top' : `${playground.downside}px`});
    }

    setInterval(draw, 10);
});