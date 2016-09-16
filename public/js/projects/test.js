/* global $$ */

var canvas, ctx,
	canvasWidth=700,
	canvasHeight=500,
	len = 100,
	sx,sy,sa,
	l1 = 0.8, l2 =0.7,
	a1= 0.4, a2 = 0.6
;

function init(){
	$$("#newDraw").addEvent("click", newDraw);
	canvas = $$("#gen");
	canvas.height = canvasHeight;
	canvas.width = canvasWidth;
	
	if(canvas && canvas.getContext){
		ctx = canvas.getContext("2d");
		ctx.fillStyle = "rgb(200, 200, 230)";
		ctx.fillRect(0,0,canvasWidth,canvasHeight);
		
		draw(canvasWidth/2, canvasHeight, len, Math.PI/2);
		
	}
}

function newDraw(){
	sx= Number($$("#startX").value||canvasWidth/2);
	sy= Number($$("#startY").value||canvasHeight);
	sl = Number($$("#startL").value||100);
	sa= Number($$("#startA").value||Math.PI/2);
	l1= Number($$("#l1").value||0.8);
	l2= Number($$("#l2").value||0.7);
	a1= Number($$("#a1").value||0.4);
	a2= Number( $$("#a2").value||0.6);
	
	ctx.fillStyle = "rgb(200, 200, 230)";
	ctx.fillRect(0,0,canvasWidth,canvasHeight);
	draw(sx,sy,sl,sa);
}

function draw(x,y,l,a){

	if(l<2) return 0;
	
	var x2 = x + l * Math.cos(a),
		y2 = y - l * Math.sin(a);
		
	ctx.beginPath();
        if(l<5){
            ctx.strokeStyle = "green";            
        }
        else{
            ctx.strokeStyle = "black";            
        }
	ctx.lineWidth =1/6*l;
	ctx.moveTo(x, y);
	ctx.lineTo(x2, y2);
	ctx.stroke();
	
	draw(x2, y2, l*l1, a+a1);
	draw(x2, y2, l*l2, a-a2);
	
}
$$.load(init);


/*
 * 
 * 
 */



var canvasM, ctxM,
	canvasWidthMagic=700,
	canvasHeightMagic=500,
        possX = possY = mouseX = mouseY = 55,
        r = 50,
        pf=10;

function magic(){
	canvasM = $$("#this-is-kind-of-magic");        
        canvasM.addEvent("mousemove", mousePoss);
	canvasM.height = canvasHeightMagic;
	canvasM.width = canvasWidthMagic;
        if(canvasM && canvasM.getContext){
		ctxM = canvasM.getContext("2d");
		ctxM.fillStyle = "rgb(0, 0, 0)";
                ctxM.fillRect(0, 0, canvasWidthMagic, canvasHeightMagic);
		setInterval(drawMagic,1000/60);
		
	}
    
}


function drawMagic(){
    possX += (mouseX-possX)*0.06;
    possY += (mouseY-possY)*0.06;
    ctxM.fillStyle = "rgba(0, 0, 0, 0.04)";
    ctxM.fillRect(0, 0, canvasWidthMagic, canvasHeightMagic);
    for(var i =0; i<pf;i++){       
        ctxM.beginPath();
        var p = rand(possX, possY);
        console.log(p);
        ctxM.fillStyle = randomColor();
        ctxM.arc(p[0], p[1], 2, 0, 2*Math.PI);
        ctxM.fill();
    }
}

function mousePoss(evt){
    var rect = canvasM.getBoundingClientRect();
    mouseX = evt.clientX - rect.left;
    mouseY = evt.clientY - rect.top;
}

function rand(x, y){
    var rr = Math.random() * r;
    var a = 2*Math.random() * Math.PI; 
    return[x+rr*Math.sin(a), y+rr*Math.cos(a)];
}

function randomColor(){
    var letters = '0123456789ABCDEF'.split('');
    var color = '#';
    for (var i = 0; i < 6; i++ ) {
        color += letters[Math.floor(Math.random() * 16)];
    }
    return color;
}
$$.load(magic);


/*
 function s(){a=$$("#this-is-kind-of-magic"),a.addEvent("mousemove",h),a.height=d,a.width=c,a&&a.getContext&&(b=a.getContext("2d"),b.fillStyle="rgb(0, 0, 0)",b.fillRect(0,0,c,d),setInterval(i,1e3/60))}
 function i(){b.fillStyle="rgba(0, 0, 0, 0.04)",b.fillRect(0,0,c,d);for(var t=0;g>t;t++){b.beginPath();var a=j(e,f);b.fillStyle=k(),b.arc(a[0],a[1],2,0,2*Math.PI),b.fill()}}
 function h(t){var n=a.getBoundingClientRect();e+=.14*(t.clientX-n.left-e),f+=.14*(t.clientY-n.top-f)}
 function j(t,a){var e=Math.random()*r,n=2*Math.random()*Math.PI;return[t+e*Math.sin(n),a+e*Math.cos(n)]}
 function k(){for(var t="0123456789ABCDEF".split(""),a="#",e=0;6>e;e++)a+=t[Math.floor(16*Math.random())];return a}var a,b,c=700,d=500,e=20,f=20,r=50,g=10;$$.load(s);
*/
