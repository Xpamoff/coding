$(document).ready(()=>{
    window.ground = {}
    window.player = {};

    startGame();

    function startGame(){
        ground.elem = $('.ground');
        ground.y = $(window).height()-ground.elem.height()-64;
        player.y = ground.y;
        player.elem = $('.player');
        player.elem.css({'top' : `${player.y}px`});
        player.x = 0;
        player.isInJump = false;
        player.jumpHeight = 200;

        let goLeft = false;
        let goRight = false;

        document.addEventListener("keydown", keyDownHandler);
        document.addEventListener("keyup", keyUpHandler);

        function keyDownHandler(e){
            if(e.keyCode == 39){
                goRight = true;

            }
            else if(e.keyCode == 37){
                goLeft = true;
            }
            else if(e.keyCode == 38&&!player.isInJump){
                player.isInJump = true;
                player.elem.animate({'top' : `${ground.y-player.jumpHeight}px`}, 300, 'linear', ()=>{
                    player.isInJump = false;
                    player.y -= player.jumpHeight;
                });
            }
        }
        function keyUpHandler(e){
            if(e.keyCode == 39){
                goRight = false;
            }
            else if(e.keyCode == 37){
                goLeft = false;
            }
        }

        function draw(){
            if(goRight){
                if(player.x + 4 <= $(window).width()-64) {
                    player.x += 4;
                }
            }
            if(goLeft){
                if(player.x - 4 >= 0) {
                    player.x -= 4;
                }
            }
            console.log(player.isInJump);
            if(!player.isInJump&&player.y < ground.y){
                player.elem.animate({'top' : `${ground.y}px`}, 300, 'linear', ()=>{
                    player.isInJump = false;
                    player.y = ground.y;
                });
            }

            player.elem.css({'left' : `${player.x}px`});
        }

        setInterval(draw, 10);
    }
});
