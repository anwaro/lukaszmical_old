var isMobile = /Android|webOS|iPhone|iPad|iPod|BlackBerry|IEMobile|Opera Mini/i.test(navigator.userAgent);

var numX = 10;
var numY = 16;
var LenCub = 20;

var boardX = numX*LenCub;
var boardY = numY*LenCub;
var boardXwithMenu = boardX+100;

var BoardColor = "#678893";
var stX = 4;
var stY = 0;
var OneInLoop = 0;
var canvas;
var ctx;
var gameLoop;
var downPress = false;
var leftPress = false;
var rightPress = false;

var NumberCube = Math.floor(Math.random()*10000)%7;
var NumberNextCube = Math.floor(Math.random()*10000)%7;       
var NumTransform = 1;

var titleFontSize = "bold 24px Georgia";
var MenuFontSize = "bold 14px Georgia";

var Score = 0;
var Level = 1;
var initSpeed = 10;
var Speed = 10;
var fps = 60;
var move = 0;

var ColorCube ={
	cub0 : "#33CC33",cube0: "#259525",//gren
	cub1 : "#C670C6",cube1: "#9E5A9E",//purpure
	cub2 : "#D1A319",cube2: "#A98414",//orange
	cub3 : "#FF6666",cube3: "#CC5252",//red
	cub4 : "#5C5CD6",cube4: "#5353C1",//
	cub5 : "#E6E600",cube5: "#B8B800",//yellow
	cub6 : "#FF8533",cube6: "#D1793E" //
};
/**********************MAIN FUNCTION************************/

function startTetris() {
	ResetGame();

    gameLoop = setInterval(DrawAll, fps);
}

function END(right) {
    move=0;
    right&&(rightPress = false);
    !right&&(leftPress = false);
}

function LR(right) {
    rightPress = right;
    leftPress = !right;
    move = 0;
    MoveCubeLR(right);
}

function initCanvas(){
    canvas = document.getElementById("tetris");
    canvas.height=boardY;
    canvas.width = boardXwithMenu;
    if (canvas.getContext) {
        ctx = canvas.getContext("2d");
        DrawAll();
        DrawMenu();
    }
	window.addEventListener('keydown', keyPress, true);
	window.addEventListener('keyup', keyUp, true);

	$$(".rotate").addEvent('click', TransformCube);

	var right =  $$(".move-right");
    isMobile && right.addEvent('touchstart', function(){LR(true)});
    !isMobile &&right.addEvent('mousedown', function(){LR(true)});
	right.addEvent('mouseup', function(){END(true)});
	right.addEvent('touchend', function(){END(true)});

	var left =  $$(".move-left");
    isMobile && left.addEvent('touchstart', function(){LR(false)});
    !isMobile &&left.addEvent('mousedown', function(){LR(false)});
	left.addEvent('mouseup', function(){END(false)});
	left.addEvent('touchend', function(){END(false)});

	var down =  $$(".move-down");
    isMobile && down.addEvent('touchstart', function(){downPress = true; MoveCube()});
    !isMobile && down.addEvent('mousedown', function(){downPress = true; MoveCube()});
	down.addEvent('mouseup', function(){downPress = false});
	down.addEvent('touchend', function(){downPress = false});

}

function Block(poss,type,color,colorN){
	this.poss = poss;
	this.type = type;
	this.color = color;
	this.colorN = colorN;
}

var AllBlock =[
/*  _
   |_|
   |_|_
   |_|_|
*/	new Block([[stX,stY],[stX,stY+1],[stX,stY+2],[stX+1,stY+2]],1,ColorCube.cub0, ColorCube.cube0),
/*    _
     |_|
    _|_|
   |_|_|
*/	new Block([[stX,stY],[stX,stY+1],[stX,stY+2],[stX-1,stY+2]],2,ColorCube.cub1, ColorCube.cube1),
/*  _ _
   |_|_|_
     |_|_|
*/	new Block([[stX,stY],[stX+1,stY],[stX+1,stY+1],[stX+2,stY+1]],3,ColorCube.cub2, ColorCube.cube2),
/*    _ _
    _|_|_|
   |_|_|
*/	new Block([[stX,stY],[stX+1,stY],[stX,stY+1],[stX-1,stY+1]],4,ColorCube.cub3, ColorCube.cube3),
/*  _ _ _ _
   |_|_|_|_|
*/	new Block([[stX,stY],[stX+1,stY],[stX+2,stY],[stX+3,stY]],5,ColorCube.cub4, ColorCube.cube4),
/*     _
     _|_|_
    |_|_|_|
*/	new Block([[stX,stY],[stX,stY+1],[stX-1,stY+1],[stX+1,stY+1]],6,ColorCube.cub5, ColorCube.cube5),
/*  _ _
   |_|_|
   |_|_|
*/	new Block([[stX,stY],[stX+1,stY],[stX,stY+1],[stX+1,stY+1]],7,ColorCube.cub6, ColorCube.cube6)
];

function OneCube(X,Y,value,color){
	this.X = X;
	this.Y = Y;
	this.value = value;
	this.color = color;
}

var Board = [];
var CubeArea = [];
var NewArea = [];
for(var i =0;i<numY;i++){
	Board[i] =[];
    CubeArea[i] =[];
    NewArea[i] =[];
	for(var j=0;j<numX;j++){
		Board[i][j]= new OneCube(LenCub*j,LenCub*i,1,BoardColor);
		NewArea[i][j]= new OneCube(LenCub*j,LenCub*i,false,BoardColor);
		CubeArea[i][j]= new OneCube(LenCub*j,LenCub*i,false,BoardColor);
	}
}

function ResetGame(){
	$$(".play").hide();
	Score = 0;
    move = 0;
	Level = 1;
	Speed = initSpeed;
	NumberCube = Math.floor(Math.random()*10000)%7;
	NumberNextCube = Math.floor(Math.random()*10000)%7;       
	NumTransform = 1;
	ResetPosition();
	for(var i =0;i<numY;i++){
		for(var j=0;j<numX;j++){
			Board[i][j].color= BoardColor;
            CubeArea[i][j].color= BoardColor;
            CubeArea[i][j].value= false;
            NewArea[i][j].color= BoardColor;
		}
	}
}

function DrawAll() {
	/**********DRAW BACKGROUND***************/
	ctx.beginPath();
    ctx.fillStyle = BoardColor;
	ctx.fillRect(0, 0, boardX, boardY);

	/*********DRAW FRAME*********************/
	ctx.beginPath();
	ctx.moveTo(boardX,0);
	ctx.lineTo(boardX,boardY);
	ctx.stroke();

	/*********CLEAR********/
	for(var i =0;i<numY;i++){
		for(var j=0;j<numX;j++){
			Board[i][j].color = BoardColor;
		}
	}
	/********DRAW PREV BLOCKS****************/
	for(var i =0;i<numY;i++){
		for(var j=0;j<numX;j++){
			if(CubeArea[i][j].value){
				ctx.fillStyle = CubeArea[i][j].color;
				ctx.beginPath();
				ctx.rect(CubeArea[i][j].X+1, CubeArea[i][j].Y+1,LenCub-2,LenCub-2);
				ctx.closePath();
				ctx.fill();
			}
		}
	}
	/**********DRAW CURRENT BLOCK***********/	
	for(var i=0;i<4;i++){
		var posX = AllBlock[NumberCube].poss[i][0];
		var posY = AllBlock[NumberCube].poss[i][1];
		
		ctx.fillStyle = AllBlock[NumberCube].color;
		ctx.beginPath();
		ctx.rect(Board[posY][posX].X+1, Board[posY][posX].Y+1,LenCub-2,LenCub-2);
		ctx.closePath();
		ctx.fill();			
	}
	
	(OneInLoop==0 || downPress) && MoveCube();
    move && leftPress && MoveCubeLR(false);
    move && rightPress && MoveCubeLR(true);
    move++;
	OneInLoop=(++OneInLoop)%Speed;
}

function DrawMenu(){
    ctx.beginPath();
    ctx.fillStyle = BoardColor;
    ctx.fillRect(boardX, 0, boardXwithMenu, boardY);
    ctx.beginPath();
	ctx.font = MenuFontSize;
	ctx.fillStyle = "white";
	ctx.fillText("Next block ", boardX+8, 20);
	ctx.fillText("Score: "+Score, boardX+8, 110);
	ctx.fillText("Level: "+Level, boardX+8, 130);
	DrawNextBlock();
}

function DrawNextBlock(){
	switch(NumberNextCube){
		case 0:
			DrawOneCube(boardX+15,30);
			DrawOneCube(boardX+15,50);
			DrawOneCube(boardX+15,70);
			DrawOneCube(boardX+35,70);
			break;
		case 1:
			DrawOneCube(boardX+35,30);
			DrawOneCube(boardX+35,50);
			DrawOneCube(boardX+35,70);
			DrawOneCube(boardX+15,70);
			break;
		case 2:
			DrawOneCube(boardX+35,30);
			DrawOneCube(boardX+35,50);
			DrawOneCube(boardX+15,50);
			DrawOneCube(boardX+15,70);
			break;
		case 3:
			DrawOneCube(boardX+15,30);
			DrawOneCube(boardX+15,50);
			DrawOneCube(boardX+35,50);
			DrawOneCube(boardX+35,70);
			break;
		case 4:
			DrawOneCube(boardX+10,30);
			DrawOneCube(boardX+30,30);
			DrawOneCube(boardX+50,30);
			DrawOneCube(boardX+70,30);
			break;
		case 5:
			DrawOneCube(boardX+35,30);
			DrawOneCube(boardX+15,50);
			DrawOneCube(boardX+35,50);
			DrawOneCube(boardX+55,50);
			break;
		case 6:
			DrawOneCube(boardX+15,30);
			DrawOneCube(boardX+15,50);
			DrawOneCube(boardX+35,50);
			DrawOneCube(boardX+35,30);
			break;
	}
}

function DrawOneCube(x,y){
	ctx.fillStyle = AllBlock[NumberNextCube].color;
	ctx.beginPath();
	ctx.rect(x+1,y+1,LenCub-2,LenCub-2);
	ctx.closePath();
	ctx.fill();	
}

function ChoseNextCube(){
	for(var i=0;i<4;i++){
		CubeArea[AllBlock[NumberCube].poss[i][1]][AllBlock[NumberCube].poss[i][0]].value = true;
		CubeArea[AllBlock[NumberCube].poss[i][1]][AllBlock[NumberCube].poss[i][0]].color = AllBlock[NumberCube].colorN;
	}
	ResetPosition();
	DeleteFullLayer();
	NumberCube = NumberNextCube;
	NumberNextCube =Math.floor(Math.random()*10000)%7;
	NumTransform=1;
	CheckStatusGame();
    DrawMenu();
}

function GameEnd(){
	clearInterval(gameLoop);
	ctx.font = titleFontSize;
	ctx.fillStyle = "white";
	ctx.fillText("GAME OVER", 15, 130);
	$$(".play").show();

}

function CheckStatusGame(){
	for(var j=0;j<numX;j++){
		if(CubeArea[0][j].value==true)return GameEnd();
	}
}

function DeleteFullLayer(){
	var NumFull = 0;
	for(var i =0;i<numY;i++){
		for(var j=0;j<numX;j++){
			NewArea[i][j].value = CubeArea[i][j].value;
			NewArea[i][j].color = CubeArea[i][j].color;
		}
	}
	for(var i =0;i<numY;i++){
		for(var j=0;j<numX;j++){if(CubeArea[i][j].value==true){NumFull++}};
		if(NumFull==numX){
			Score++;
			Level= Math.ceil(Score/40);
			Speed = initSpeed-Level;
			for(var k=0;k<=i;k++){
				for(var l=0;l<numX;l++){
					if(k==0){
						NewArea[k][l].value = false;
						NewArea[k][l].color = BoardColor;
					}
					else{
						NewArea[k][l].value = CubeArea[k-1][l].value;
						NewArea[k][l].color = CubeArea[k-1][l].color;
					}
				}
			}
			for(var k =0;k<numY;k++){
				for(var l=0;l<numX;l++){
					CubeArea[k][l].value = NewArea[k][l].value;
					CubeArea[k][l].color = NewArea[k][l].color;
				}
			}
		}
		NumFull=0;
	}
}

function MoveCube(){
	var k =0;
	for(var i=0;i<4;i++){
		if(AllBlock[NumberCube].poss[i][1]+1==numY||CubeArea[AllBlock[NumberCube].poss[i][1]+1][AllBlock[NumberCube].poss[i][0]].value==true)k++;
	}
	if(k==0) for(var i=0;i<4;i++)AllBlock[NumberCube].poss[i][1]++;
	else{
		ChoseNextCube();
	}
}

function ResetPosition(){
	switch(NumberCube){
	case 0:
		AllBlock[NumberCube].poss = [[stX,stY],[stX,stY+1],[stX,stY+2],[stX+1,stY+2]];
		break;
	case 1:
		AllBlock[NumberCube].poss = [[stX,stY],[stX,stY+1],[stX,stY+2],[stX-1,stY+2]];
		break;
	case 2:
		AllBlock[NumberCube].poss = [[stX,stY],[stX+1,stY],[stX+1,stY+1],[stX+2,stY+1]];
		break;
	case 3:
		AllBlock[NumberCube].poss = [[stX,stY],[stX+1,stY],[stX,stY+1],[stX-1,stY+1]];
		break;
	case 4:
		AllBlock[NumberCube].poss = [[stX,stY],[stX+1,stY],[stX+2,stY],[stX+3,stY]];
		break;
	case 5:
		AllBlock[NumberCube].poss = [[stX,stY],[stX,stY+1],[stX-1,stY+1],[stX+1,stY+1]];
		break;
	case 6:
		AllBlock[NumberCube].poss = [[stX,stY],[stX+1,stY],[stX,stY+1],[stX+1,stY+1]];
		break;
	}
}

function MoveCubeLR(where){

	var left  = 0;
	var right = 0;
	
	for(var i=0;i<4;i++){
		if(AllBlock[NumberCube].poss[i][0]+1==numX)right++;
		else if(CubeArea[AllBlock[NumberCube].poss[i][1]][AllBlock[NumberCube].poss[i][0]+1].value==true)right++;
		if(AllBlock[NumberCube].poss[i][0]==0)left++;
		else if(CubeArea[AllBlock[NumberCube].poss[i][1]][AllBlock[NumberCube].poss[i][0]-1].value==true)left++;
	}
	if(where&&right==0)for(var i=0;i<4;i++)AllBlock[NumberCube].poss[i][0]++;
	if(!where&&left==0)for(var i=0;i<4;i++)AllBlock[NumberCube].poss[i][0]--;

}

function TransformCube(){

	var NewPoss = [[],[],[],[]];
	for(var i =0;i<4;i++){
		NewPoss[i][0] =AllBlock[NumberCube].poss[i][0];
		NewPoss[i][1] =AllBlock[NumberCube].poss[i][1];
	}
	
	var NewTran = NumTransform;
	var Check   = 0;
		switch (NumberCube) {//[[stX,stY],[stX,stY+1],[stX,stY+2],[stX+1,stY+2]]
		case 0:		
			if(NewTran==1){
				if(NewPoss[0][0]==0)break;
				NewPoss[0][0]--;NewPoss[0][1]++;
				NewPoss[2][0]++;NewPoss[2][1]--;
				NewPoss[3][1]-=2;NewTran++;
			}
			else if(NewTran==2){
				if(NewPoss[0][1]==numY-1)break;
				NewPoss[0][0]++;NewPoss[0][1]++;
				NewPoss[2][0]--;NewPoss[2][1]--;
				NewPoss[3][0]-=2;NewTran++;
			}
			else if(NewTran==3){
				if(NewPoss[0][0]==numX-1)break;
				NewPoss[0][0]++;NewPoss[0][1]--;
				NewPoss[2][0]--;NewPoss[2][1]++;
				NewPoss[3][1]+=2;NewTran++;
			}
			else if(NewTran==4){
				if(NewPoss[0][1]==0)break;
				NewPoss[0][0]--;NewPoss[0][1]--;
				NewPoss[2][0]++;NewPoss[2][1]++;
				NewPoss[3][0]+=2;NewTran=1;
			}
			for(var i =0;i<4;i++){
				if(CubeArea[NewPoss[i][1]][NewPoss[i][0]].value==true)Check++;
			}			
			if(Check==0){
				AllBlock[NumberCube].poss = NewPoss;
				NumTransform =NewTran;
			}
			break;			
			
        case 1:
			if(NewTran==1){//[[stX,stY],[stX,stY+1],[stX,stY+2],[stX-1,stY+2]]
				if(NewPoss[0][0]==numX-1)break;
				NewPoss[0][0]--;NewPoss[0][1]++;
				NewPoss[2][0]++;NewPoss[2][1]--;
				NewPoss[3][0]+=2;NewTran++;
			}
			else if(NewTran==2){
				if(NewPoss[0][1]==0)break;
				NewPoss[0][0]++;NewPoss[0][1]++;
				NewPoss[2][0]--;NewPoss[2][1]--;
				NewPoss[3][1]-=2;NewTran++;
			}
			else if(NewTran==3){
				if(NewPoss[0][0]==0)break;
				NewPoss[0][0]++;NewPoss[0][1]--;
				NewPoss[2][0]--;NewPoss[2][1]++;
				NewPoss[3][0]-=2;NewTran++;
			}
			else if(NewTran==4){
				if(NewPoss[0][1]==0)break;
				NewPoss[0][0]--;NewPoss[0][1]--;
				NewPoss[2][0]++;NewPoss[2][1]++;
				NewPoss[3][1]+=2;NewTran=1;
			}
			for(var i =0;i<4;i++){
				if(CubeArea[NewPoss[i][1]][NewPoss[i][0]].value==true)Check++;
			}			
			if(Check==0){
				AllBlock[NumberCube].poss = NewPoss;
				NumTransform =NewTran;
			}
			break;
		case 2:
			if(NewTran==1||NewTran==3){//[[stX,stY],[stX+1,stY],[stX+1,stY+1],[stX+2,stY+1]]
				if(NewPoss[0][1]==0||NewPoss[3][1]==numY-1)break;
				NewPoss[0][0]++;NewPoss[0][1]++;
				NewPoss[2][0]++;NewPoss[2][1]--;
				NewPoss[3][1]-=2;NewTran++;
			}
			else if(NewTran==2||NewTran==4){
				if(NewPoss[0][1]==numY-1||NewPoss[0][0]==0)break;
				NewPoss[0][0]--;NewPoss[0][1]--;
				NewPoss[2][0]--;NewPoss[2][1]++;
				NewPoss[3][1]+=2;NewTran--;
			}
			
			for(var i =0;i<4;i++){
				if(CubeArea[NewPoss[i][1]][NewPoss[i][0]].value==true)Check++;
			}			
			if(Check==0){
				AllBlock[NumberCube].poss = NewPoss;
				NumTransform =NewTran;
			}
			break;
		case 3:
			if(NewTran==1||NewTran==3){//[[stX,stY],[stX+1,stY],[stX,stY+1],[stX-1,stY+1]]
				if(NewPoss[1][1]==0||NewPoss[3][1]==numY-1)break;
				NewPoss[1][0]--;NewPoss[1][1]--;
				NewPoss[2][0]++;NewPoss[2][1]--;
				NewPoss[3][0]+=2;NewTran++;
			}
			else if(NewTran==2||NewTran==4){
				if(NewPoss[1][1]==numY-1||NewPoss[1][0]==0)break;
				NewPoss[1][0]++;NewPoss[1][1]++;
				NewPoss[2][0]--;NewPoss[2][1]++;
				NewPoss[3][0]-=2;NewTran--;
			}
			for(var i =0;i<4;i++){
				if(CubeArea[NewPoss[i][1]][NewPoss[i][0]].value==true)Check++;
			}			
			if(Check==0){
				AllBlock[NumberCube].poss = NewPoss;
				NumTransform =NewTran;
			}
			break;
		case 4:
			if(NewTran==1||NewTran==3){//[[stX,stY],[stX+1,stY],[stX+2,stY],[stX+3,stY]]
				if(NewPoss[3][1]==0||NewPoss[3][1]>numY-3)break;
				NewPoss[0][0]+=2;NewPoss[0][1]+=2;
				NewPoss[1][0]++;NewPoss[1][1]++;
				NewPoss[3][0]--;NewPoss[3][1]--;NewTran++;
			}
			else if(NewTran==2||NewTran==4){
				if(NewPoss[1][0]==numX-1||NewPoss[1][0]<2||NewPoss[0][1]==numY-1)break;
				NewPoss[0][0]-=2;NewPoss[0][1]-=2;
				NewPoss[1][0]--;NewPoss[1][1]--;
				NewPoss[3][0]++;NewPoss[3][1]++;NewTran--;
			}
			for(var i =0;i<4;i++){
				if(CubeArea[NewPoss[i][1]][NewPoss[i][0]].value==true)Check++;
			}			
			if(Check==0){
				AllBlock[NumberCube].poss = NewPoss;
				NumTransform =NewTran;
			}
			break;
		case 5:
			if(NewTran==1){//[[stX,stY],[stX,stY+1],[stX-1,stY+1],[stX+1,stY+1]]
				if(NewPoss[3][1]==numY-1)break;
				NewPoss[0][0]--;NewPoss[0][1]++;
				NewPoss[2][0]++;NewPoss[2][1]++;
				NewPoss[3][0]--;NewPoss[3][1]--;NewTran++;
			}
			else if(NewTran==2){
				if(NewPoss[2][1]==numY-1||NewPoss[2][0]==numX-1)break;
				NewPoss[0][0]++;NewPoss[0][1]++;
				NewPoss[2][0]++;NewPoss[2][1]--;
				NewPoss[3][0]--;NewPoss[3][1]++;NewTran++;
			}
			else if(NewTran==3){
				if(NewPoss[0][1]==numY-1||NewPoss[3][1]==0)break;
				NewPoss[0][0]++;NewPoss[0][1]--;
				NewPoss[2][0]--;NewPoss[2][1]--;
				NewPoss[3][0]++;NewPoss[3][1]++;NewTran++;
			}
			else if(NewTran==4){
				if(NewPoss[3][1]==numY-1||NewPoss[3][0]==0)break;
				NewPoss[0][0]--;NewPoss[0][1]--;
				NewPoss[2][0]--;NewPoss[2][1]++;
				NewPoss[3][0]++;NewPoss[3][1]--;NewTran=1;
			}
			for(var i =0;i<4;i++){
				if(CubeArea[NewPoss[i][1]][NewPoss[i][0]].value==true)Check++;
			}			
			if(Check==0){
				AllBlock[NumberCube].poss = NewPoss;
				NumTransform =NewTran;
			}
			break;
		case 6:
			break;
	}
}
function keyUp(evt) {
    switch (evt.keyCode) {
    case 65:// a
    case 37:// ←
        leftPress = false;
        evt.stopPropagation();
        break;
    case 68:// d
    case 39:// →
        rightPress = false;
        evt.stopPropagation();
        break;
    case 83: // s
    case 40: // ↓
        downPress = false;
        evt.stopPropagation();
        break;
    }
}
function keyPress(evt) {
    move = 0;
	switch (evt.keyCode) {
    case 65:// a
    case 37:// ←
        rightPress = false; leftPress = true;
        evt.stopPropagation();
        break;
    case 68:// d
    case 39:// →
        leftPress = false; rightPress = true;
        evt.stopPropagation();
        break;
    case 87:// w
    case 38:// ↑
        TransformCube();
        evt.stopPropagation();
        break;
    case 83: // s
    case 40: // ↓
        downPress = true;
        evt.stopPropagation();
        break;
	}
}

$$.load(initCanvas);