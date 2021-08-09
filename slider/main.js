let r1 = document.getElementById("r1");
let r2 = document.getElementById("r2");
let r3 = document.getElementById("r3");
let r4 = document.getElementById("r4");

let count = 1;

let slideInter = setInterval(() => {
    count++;
    console.log(count);
    if(count == 2){
        r2.checked = true;
    }
    else{
        if(count == 3){
            r3.checked = true;
        }
        else {
            if(count == 4){
            r4.checked = true;
            }
            else{
                r1.checked = true;
                count = 1;
            }
        }
    }
}, 3000);

function onLabel(){
    clearInterval(slideInter);
}