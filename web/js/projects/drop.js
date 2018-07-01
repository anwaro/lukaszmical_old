var canvas;
var ctx;

var winX;
var winY;

var drops = [];

var image = new Image();
image.src = "/web/images/drop.png";

function init() {
    canvas = document.getElementById('drop');
    resize();
    ctx = canvas.getContext('2d');
    initDrops();
    requestAnimationFrame(draw);
}

function initDrops() {
    for(var i = 0; i < 80; i++){
        drops.push([
            winX * Math.random(),   // x
            winY + winY *Math.random(),              // y
            20 * Math.random() + 20, // size
            2 * Math.random() + 1, // v
            2 * Math.random() * Math.PI// v


        ])
    }
}


function draw() {
    requestAnimationFrame(draw);
    ctx.fillStyle = "#4d9dff";
    ctx.fillRect(0, 0, winX+1, winY+1);
    for(var i = 0; i < drops.length; i++){
        ctx.drawImage(image, 0, 0, 190, 190,
            drops[i][0] + drops[i][2] /2 * Math.sin(drops[i][1] / drops[i][2] + drops[i][4]),
            drops[i][1],
            drops[i][2],
            drops[i][2]
        );
        drops[i][1] -= drops[i][3];
        if(drops[i][1] < -60){
            drops[i][1] = winY + 60;
        }
    }
    ctx.fillStyle = "rgba(77, 157, 255, .5)";
    ctx.fillRect(0, 0, winX+1, winY+1);
}

function resize() {
    canvas.width = winX = window.innerWidth;
    canvas.height = winY = window.innerHeight;
}

document.addEventListener('DOMContentLoaded', init);







