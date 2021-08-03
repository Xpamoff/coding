$(document).ready(() => {
    window.player = {

    }
    startGame();
    function startGame() {
        const objectsTypes = {
            ground: '<div class="ground game-object"></div>',
            tunnel: '<div class="tunnel game-object"></div>',
            stone: '<div class="stone game-object"></div>',
            heart: '<div class="heart game-object"></div>',
        }
        window.objects = [];

        initObjectsArray();
        function initObjectsArray() {                                               //заполнения массива
            for(let y = 0; y < $(window).height()/64-1; y++) {
                objects[y] = [];
                for(let x = 0; x < $(window).width()/64-1; x++) {
                    objects[y][x] = [];
                    if(y == 0 && x == 0) continue;
                    const newObject = $(objectsTypes.ground);
                    
                    objects[y][x][0] = newObject.clone();
                }
            }
            const newObject = $(objectsTypes.tunnel);
            objects[0][0][0] = newObject.clone();
        }


        function walkThroughObjects(callback1, callback2) {
            for(let y = 0; y < objects.length; y++) {
                if(callback1) callback1.call(this, objects[y], y);
                for(let x = 0; x < objects[y].length; x++) {
                    if(callback2) callback2.call(this, objects[y][x], y, x);
                }
            }
        }
        
        function generateObjects(elem) {                                //генераций камней и сердец
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

        generateObjects($(objectsTypes.stone));
        generateObjects($(objectsTypes.heart));



        drawMap(objects);
        function drawMap() {
            walkThroughObjects(null, (item, y, x) => {
                item[0].css({'left': `${x*64}px`, 'top': `${y*64}px`});
                $('body').append(item[0]);
                if(item[1]) {
                    item[1].css({'left': `${x*64}px`, 'top': `${y*64}px`});
                    $('body').append(item[1]);
                }
            });
        }

        function checkObject(y, x, second) {            //падение камня/сердца
            let delay = 1000;
            if(second) delay = 0;
            let object = objects[y][x][1];
            if(!object) return;
            if(!objects[y+1]) return;
            if(objects[y+1][x][1]) return;
            if(objects[y+1][x][0].is('.tunnel')) {
                objects[y][x][0].removeClass('ground').addClass('tunnel');
                setTimeout(() => {
                    if(player.y == y+1 && player.x == x) {
                        if(object.is('.stone')) endGame();
                        if(object.is('.heart')) {
                            object.remove();
                            object = null;
                            player.score++;
                            if(player.score == 10) {
                                endGame();
                            }
                        }
                    }
                    if(!object) return;

                    objects[y+1][x][1] = object;
                    delete objects[y][x][1];
                    object.animate({'top': `${(y+1)*64}px`}, 200, 'linear', () => { 
                        checkObject(y+1, x, true);
                    });

                    if(objects[y-1]) {                  //вызов функции для клетки над упавшим объектом
                        checkObject(y-1, x);
                    }
                }, delay);
            }
        }

        player.elem= $('.player');
        player.x= 0;
        player.y= 0;
        player.score= 0;
        player.isMoving= false;
        player.move = function(x, y) {
            if(this.isMoving) return;
            if(objects[this.y+y] && objects[this.y+y][this.x+x]) {
                if(objects[this.y+y][this.x+x][1] && objects[this.y+y][this.x+x][1].is('.stone')) return;
                this.x += x;
                this.y += y;
                this.isMoving = true;
                player.elem.animate({'left': `${this.x*64}px`, 'top': `${this.y*64}px`}, 200, 'linear', () => {
                    this.isMoving = false;
                });

                const object = objects[this.y][this.x]
                object[0].removeClass('ground').addClass('tunnel');

                if(object[1] && object[1].is('.heart')) {
                    player.score++;
                    if(player.score == 10) {
                        endGame();
                    }
                    object[1].removeClass('heart')
                    delete object[1];
                }

                if(objects[this.y-1]) checkObject(this.y-1, this.x);
            }
        }.bind(player);

        $(document).keydown(e => {
            switch(e.keyCode) {
                case 37: player.move(-1, 0);
                break;
                case 38: player.move(0, -1);
                break;
                case 39: player.move(1, 0);
                break;
                case 40: player.move(0, 1);
                break;
            }
        });
        
    }
    
    function endGame() {
        $('.game-object').remove();
        $('body').append('<div class="player game-object"></div>');
        startGame();
    }

})