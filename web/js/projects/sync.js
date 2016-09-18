var width = 300;
var height = 300;
var angle = 0;
var dA = 1;
var canvas, ctx;


function init(){
    height = window.innerHeight;
    width = window.innerWidth;
    canvas = document.getElementById("sync");
    document.getElementById("speed")
            .addEventListener("change", function(event){
                dA = parseFloat(event.target.value) * Math.PI;
                console.log(dA);
    });
    canvas.width = width;
    canvas.height = height;
    if(canvas.getContext){
        ctx = canvas.getContext("2d");
        setInterval(loop, 50);
    }
}

function scroll(event){
    
}

function loop(){
    angle += dA;
    
    ctx.fillStyle = "black";
    ctx.fillRect(0,0,width, height);
    
    ctx.save();
    
    ctx.translate(width/2, height/2);
    ctx.beginPath();
    ctx.rotate(angle);
    ctx.lineWidth = 4;
    ctx.strokeStyle = "white";
    ctx.arc(0,0, 300, 0, 0.2);
    ctx.stroke();
    ctx.beginPath();
    ctx.strokeStyle = "red";
    ctx.arc(0,0, 300, Math.PI, Math.PI+0.2);
    ctx.stroke();
    ctx.restore();
}

document.addEventListener("DOMContentLoaded", init);
