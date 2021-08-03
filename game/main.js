$(document).ready(() => {
    window.player = {

    }
    startgame();
    function startgame(){
        const objectTypes = {
            ground: '<div class="ground game-object"></div>',
            tunnel: '<div class="tunnel game-object"></div>',
            stone: '<div class="stone game-object"></div>',
            heart: '<div class="heart game-object"></div>',
        }
        window.objects = [];
        initObjectsArray();
        function initObjectsArray(){
            for(let y = 0; y < $(window).height()/64-1; y++){
                objects[y] = [];
                for(let x = 0; x < $(window).width()/64-1; x++){
                    objects[y][x] = [];
                    if(x==0&&y==0) continue;
                    const newObject = $(objectTypes.ground);
                    objects[y][x][0] = newObject.clone();
                }
            }
            const newObject = $(objectTypes.tunnel);
            objects[0][0][0] = newObject.clone();
        }

        function generateObjects(elem) {                                
            let entitiesCount = 0;
            while(entitiesCount < 10) {
                const y = Math.floor(Math.random()*objects.length);
                const x = Math.floor(Math.random()*objects[0].length);
                if(!objects[y][x][1] && !(y==0 && x==0)) {
                    objects[y][x][1] = elem.clone();
                    entitiesCount++;
                }
            }
        }
        generateObjects($(objectTypes.heart));
        generateObjects($(objectTypes.stone));

        drawMap();

        function drawMap(){
            for(let y=0;y<objects.length;y++){
                for(let x=0;x<objects[y].length;x++){
                    objects[y][x][0].css({'left' : `${x*64}px`, 'top' : `${y*64}px`});
                    $('body').append(objects[y][x][0]);
                    if(objects[y][x][1]){
                        objects[y][x][1].css({'left' : `${x*64}px`, 'top' : `${y*64}px`});
                        $('body').append(objects[y][x][1]);
                    }
                }
            }
        }

        function checkObject(y, x, second){
            let delay = 1000;
            if(second) delay=0;
            let object = objects[y][x][1];
            if(!object) return;
            if(!objects[y+1]) return;
            if(objects[y+1][x][1]) return;
            if(objects[y+1][x][0].is('.tunnel')){
                objects[y][x][0].removeClass('ground').addClass('tunnel');
                setTimeout(() => {
                    if(player.y == y+1&&player.x == x){
                        if(object.is('.stone')) endgame();
                        if(object.is('.heart')){ 
                            object.remove();
                            object = null;
                            player.score++;
                            if(player.score == 10){
                                endgame();
                            }
                        }
                    }
                    if(!object) return;
                        objects[y+1][x][1] = object;
                        delete objects[y][x][1];
                        object.animate({'top' : `${(y+1)*64}px`}, 200, 'linear', () => {
                            checkObject(y+1, x, true);
                        })
                        if(objects[y-1]){
                            checkObject(y-1, x);
                        }
                }, delay);
            }
        }

        player.elem = $('.player');
        player.x = 0;
        player.y = 0;
        player.score = 0;
        player.isMoving = false;
        player.move = function(x, y){
            if(player.isMoving) return;
            if(objects[player.y+y]&&objects[player.y+y][player.x+x]){
                if(objects[player.y+y][player.x+x][1] && objects[player.y+y][player.x+x][1].is('.stone')) return;
                player.x += x;
                player.y += y;
                player.isMoving = true;
                player.elem.animate({'left' : `${player.x*64}px`, 'top' : `${player.y*64}px`}, 200, 'linear', () => {
                    player.isMoving = false;
                })
                const object = objects[player.y][player.x];
                object[0].removeClass('ground').addClass('tunnel');

                if(object[1] && object[1].is('.heart')){
                    player.score++;
                    if(player.score==10){
                        endgame();
                    }
                    object[1].removeClass('heart');
                    delete object[1];
                }

                if(objects[player.y-1]){
                    checkObject(player.y-1, player.x);
                }
            }
        }.bind(player);


        $(document).keydown(e => {
            switch(e.keyCode){
                case 37: player.move(-1, 0);
                break;
                case 38: player.move(0, -1);
                break;
                case 39: player.move(1, 0);
                break;
                case 40: player.move(0, 1);
                break;
            }
        })

        function endgame(){
            $('.game-object').remove();
            $('body').append('<div class="player game-object"></div>');
            startgame();
        }

    }
})