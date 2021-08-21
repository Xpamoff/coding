$(document).ready(()=>{
    window.player = {};
    const objectTypes = {
        grounds: '<div class="game-object grounds"></div>',
        heart: '<div class="game-object heart"></div>',
        rock: '<div class="rock"></div>'
    }
    window.playground = {};
    player.elem = $('.player');
    playground.elem = $('.game');
    playground.downside = 324 - 32 - 32;
    player.x = 0;
    player.y = 0;
    player.jumpHeight = 128;

    let goRight = false;
    let goLeft = false;
    let isOnJump = false;
    let jumpStarted = false;

    const newHrt = $(objectTypes.heart);
    const newRock = $(objectTypes.rock);

    window.heart = {};


    player.score = 0;
    player.name = localStorage.getItem("character_name");
    $('.name').html("Имя: " + player.name);
    if(localStorage.getItem('best')) {
        $('.best').html("Лучший счёт: " + localStorage.getItem('best'));
    }
    else{
        localStorage.setItem('best', '0');
    }


    drawHearts();


    heart.h1.col = false;
    heart.h2.col = false;


    window.rock = {};
    rock.elem = newRock.clone();
    rock.dir = 1;

    initGrounds();
    initPlayer();
    initRock();

    document.addEventListener('keydown', going);
    document.addEventListener('keyup', stopping);


    function checkObjects(){
        heart.h1.x = heart.h1.offset().left - playground.elem.offset().left - 10;
        heart.h2.x = heart.h2.offset().left - playground.elem.offset().left - 10;
        heart.h1.y = heart.h1.offset().top - playground.elem.offset().top - 10;
        heart.h2.y = heart.h2.offset().top - playground.elem.offset().top - 10;
        if(Math.abs(player.x - heart.h1.x) <= 32 && Math.abs((playground.downside - player.y) - heart.h1.y) <= 32 && !heart.h1.col){
            player.score++;
            heart.h1.col = true;
            heart.h1.remove();
        }
        if(Math.abs(player.x - heart.h2.x) <= 32 && Math.abs((playground.downside - player.y) - heart.h2.y) <= 32 && !heart.h2.col){
            player.score++;
            heart.h2.col = true;
            heart.h2.remove();
        }
        player.left = player.x;
        player.right = player.x + 32;
        player.top = playground.downside - player.y;
        player.bottom = player.top + 32;

        rock.left = rock.x;
        rock.right = rock.x + 64;
        rock.top = rock.y;
        rock.bottom = rock.y + 64;

        if(player.left <= rock.right&&player.right >= rock.left&&player.top <= rock.bottom&&player.bottom >= rock.top){
            endGame();
        }
    }

    function drawHearts(){
        heart.h1 = newHrt.clone();
        heart.h2 = newHrt.clone();

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
            player.elem.css({'transform' : 'scaleX(1)'});
            player.x += 3;

        }
        if(goLeft && player.x - 3 >=0){
            player.elem.css({'transform' : 'scaleX(-1)'});
            player.x -= 3;
        }
        if(isOnJump){
            if(jumpStarted){
                player.y += 6.4;
                if(player.y >= player.jumpHeight){
                    jumpStarted = false;
                }
            }
            else{
                player.y -= 6.4;
                if(player.y <= 0){
                    isOnJump = false;
                    if(!goLeft && !goRight){
                        player.elem.css({'background-image' : `url("Biker_idle.png")`})
                    }
                }
            }
        }
        if(rock.x + 4*rock.dir <= 576 - 64 && rock.x + 4*rock.dir >=0){
            rock.x += 4*rock.dir;
        }
        else{
            rock.dir *= -1;
        }
        if(heart.h1.col && heart.h2.col){
            rock.dir *= 1.2;
            drawHearts();
        }
        $('.score').html("Счёт: " + player.score);
        checkObjects();
        rock.elem.css({'left' : `${rock.x}px`});
        player.elem.css({'left' : `${player.x}px`, 'top' : `${playground.downside - player.y}px`});
    }

    function going(e){
        if(e.keyCode == 39){
            goRight = true;
            if(!isOnJump) player.elem.css({'background-image' : `url("Biker_run.png")`})

        }
        if(e.keyCode == 37){
            goLeft = true;
            if(!isOnJump) player.elem.css({'background-image' : `url("Biker_run.png")`});
        }

        if(e.keyCode == 38 && !isOnJump){
            isOnJump = true;
            jumpStarted = true;
            player.elem.css({'background-image' : `url("Biker_jump.png")`})
        }
    }
    function stopping(e){
        if(e.keyCode == 39){
            goRight = false;
            if(!isOnJump) player.elem.css({'background-image' : `url("Biker_idle.png")`})

        }
        if(e.keyCode == 37){
            goLeft = false;
            if(!isOnJump) player.elem.css({'background-image' : `url("Biker_idle.png")`})
        }
    }

    function initRock(){
        rock.x = Math.floor(Math.random()*(576-64));
        rock.y = playground.downside - 32 - 80;
        rock.elem.css({'left' : `${rock.x}px`, 'top' : `${rock.y}px`});
        playground.elem.append(rock.elem);
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

    function endGame(){
        clearInterval(drawing);
        if(player.score > localStorage.getItem('best')){
            localStorage.setItem('best', player.score);
        }
        player.elem.css({'background-image' : `url("Biker_death.png")`})
        $('.tit').html("Game starts in a sec");
        count=0;
        clearInterval(anim);
        setInterval(anima, 100);
        setTimeout(()=>{
            clearInterval(anim);
            location.reload();

        }, 599);
    }
    let drawing = setInterval(draw, 10);
    let count = 0;
    function anima(){
        if(count==6) count = 0;
        player.elem.css({'background-position-x' : `${(count)*-48}px`})
        count++;
    }
    let anim = setInterval(anima, 100);
});