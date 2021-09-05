let r1 = document.getElementById("r1");
let r2 = document.getElementById("r2");
let r3 = document.getElementById("r3");

let count = 1;
setInterval(()=>{
    if(count%3==0){
        r1.checked = true;
    }
    else if(count%3==1){
        r2.checked = true;
    }
    else if(count%3==2){
        r3.checked = true;
    }
    count++;
}, 3000);

