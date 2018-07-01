var canvas;
var ctx;

var winX;
var winY;

var elements = [];

function init() {
    canvas = document.getElementById('rock-paper-scissors');
    resize();
    ctx = canvas.getContext('2d');
    initElements();
    requestAnimationFrame(draw);
}

function initElements() {
    for(var i = 0; i < 80; i++){
        elements.push([
            winX * Math.random(),   // x
            winY + winY *Math.random(),              // y
            20 * Math.random() + 20, // size
            2 * Math.random() + 1, // v
            2 * Math.random() * Math.PI// v
        ]);
    }
}

function draw() {
    requestAnimationFrame(draw);
    ctx.fillStyle = "#4d9dff";
    ctx.fillRect(0, 0, winX+1, winY+1);
    for(var i = 0; i < elements.length; i++){
        ctx.drawImage(image, 0, 0, 190, 190,
            elements[i][0] + elements[i][2] /2 * Math.sin(elements[i][1] / elements[i][2] + elements[i][4]),
            elements[i][1],
            elements[i][2],
            elements[i][2]
        );
        elements[i][1] -= elements[i][3];
        if(elements[i][1] < -60){
            elements[i][1] = winY + 60;
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




