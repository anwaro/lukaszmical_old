/* global ctx, $$, currentSong, nextSong, prevSong, audioContext, windows */

mp3player = new function(){
    var canvas,
            ctx,
            width = 169,
            height= 262,
            displayRatio,
            topcolor = "#32312F",
            defaultColor = "#191919",
            play = true,
            bufforEmpty = true,
            time,
            url="http://lukaszmical.pl/projects/ajaxSong/",
            songUrl = "http://lukaszmical.pl/public/sounds/mp3player/",
            type = ".mp3",
            songNumber = Math.floor(Math.random()*250),
            prevSong = new Song(),
            currentSong = new Song(),
            nextSong = new Song(),
            audioContextSupport = true,
            supportMp3,
            source,
            analyser,
            menu,
            next,
            prev,
            playStop,
            volUp,
            volDown,
            gradient,
            mouseDown=false,
            mouseDownTime;
    
    this.init = function(suppMp3){
        
    console.log("poszlo", suppMp3);
        canvas = document.getElementById("mp3screen");
        canvas.height=height;
        canvas.width=width;
        displayRatio = height/width;
        supportMp3 = suppMp3;
        initSong();
        setEqualizer();
        initButton();
        if(canvas && canvas.getContext){
            ctx = canvas.getContext("2d");
            gradient = ctx.createLinearGradient(0,height-100,0,height-50);
            gradient.addColorStop(0,"rgba(0, 0, 0, 0.7)");
            gradient.addColorStop(0.3,"rgba(255, 0, 0, 0.7)");
            gradient.addColorStop(0.6,"rgba(0, 128, 0, 0.7)");
            gradient.addColorStop(1,"rgba(0, 0, 255, 0.7)");
            setInterval(display, 1000/60);
        }
        
        
    };
    
    function initButton(){
        next = document.getElementById("next");
        menu = document.getElementById("menu");
        prev = document.getElementById("prev");
        playStop = document.getElementById("play");
        volUp = document.getElementById("volUp");
        volDown = document.getElementById("volDown");    
        
        
        next.onmousedown = function(){onmouseDown(1);};
        next.onmouseup = function(){onmouseUp(1);};
        prev.onmousedown = function(){onmouseDown(-1);};
        prev.onmouseup = function(){onmouseUp(-1);};
        playStop.onclick = playStopSong;
        
        
        volUp.onclick = function(){changeVolume(0.1);};
        volDown.onclick = function(){changeVolume(-0.1);};
    }
    
    function initSong(){   
        if(supportMp3){
            console.log("wow your browser is awesome, it support mp3 format");
            type = ".mp3";
        }
        else{
            console.log("Your browser doesn't support mp3 format, so it use ogg format which is more poor");
            type = ".ogg";
        }
        
        currentSong.elem = document.getElementById("currentSong");
        currentSong.elem.volume =0.5; 
        getSong(songNumber, "curr");
        
        
        nextSong.elem = document.getElementById("nextSong");
        getSong(songNumber+1, "next");
        
        prevSong.elem = document.getElementById("prevSong");
        getSong(songNumber-1, "prev");
        
    }
    
    function changeVolume(add){
        if(currentSong.elem.volume+add>0 && currentSong.elem.volume+add<1){
            currentSong.elem.volume+=add;
        }
    }
    
    function playStopSong(){
        if(play){
            play = false;
            currentSong.elem.pause();
        }else{
            if(typeof currentSong.elem.play==="function"){
                play = true;
                currentSong.elem.play();                
            }else{
                setTimeout(playStopSong, 100);
            }
        }
    }
    
    function stopPlay(){
        play = false;
        currentSong.elem.pause();
    }
    
    function bufforStartSong(){
        bufforEmpty = false;
        play = true;
        currentSong.elem.play();  
        
    }
    
    function bufforStopSong(){
        bufforEmpty = true;
        play = false;
        currentSong.elem.pause();
    }
    
    function setEqualizer(){
        try{
            var audioContext = new AudioContext() ||   new webkitAudioContext();
            source = audioContext.createMediaElementSource(currentSong.elem),
            analyser = audioContext.createAnalyser();
            source.connect(analyser);
            analyser.connect(audioContext.destination);
        }catch(err){
            audioContextSupport = false;
            console.log("Your browser doesn't support audioContext object, equalizer will not display");
        }
    }
    
    function display(){
        ctx.beginPath();
        ctx.fillStyle = defaultColor;
        ctx.rect(0,14, width, height);
        ctx.fill();
        
        displayPhoto();
        displayTop();
        displayProgres();
        audioContextSupport && displayEqualizer();
        
        
        var currentTime = currentSong.elem.currentTime;
        var len = currentSong.elem.duration;
        var bufor =0;
        
        if(Math.abs(len-currentTime)<0.1){
            playNextSong(1);
        }
        
        
        try{
            bufor= currentSong.elem.buffered.end(0);
        }
        catch(IndexSizeError){}
        
        if(play && bufor-currentTime<2 &&len - currentTime >3){
            bufforStopSong();
        }
        
        
        if(bufforEmpty && bufor-currentTime>8){
            bufforStartSong();
        }
        
    }
    
    function displayPhoto(){
        var load = false;
        if(currentSong.image.complete && currentSong.image.src){
            var ratio = currentSong.image.height/currentSong.image.width;
            var marginLeft = (currentSong.image.width-width)/2;
            var marginTop = 0;
            var cutImageWidth = width;
            var cutImageHeight = height;
            
            try{
                ctx.drawImage(currentSong.image, marginLeft,  marginTop, cutImageWidth, cutImageHeight, 0, 14, width, height-14);
            }catch(InvalidStateError){
                load = true;
            }
            
        }else{
            load = true;
        }
        
        if(bufforEmpty || load){
            var a = ((new Date()).getTime()/250)%(2*Math.PI);
            
            ctx.save();
            ctx.beginPath();
            ctx.lineWidth=2;
            ctx.translate(width/2, height/2);
            ctx.strokeStyle="#FFFFFF";
            ctx.arc(0, 0, 40, a, a+0.7*Math.PI);
            ctx.stroke();
            ctx.restore();
            
        }
    }
    
    function displayProgres(){
        ctx.beginPath();
        ctx.fillStyle = "rgba(48, 48, 41, 0.8)";
        ctx.rect(0, height-50, width, 50);
        ctx.fill();
        
        ctx.font="bold 10px Arial";
        ctx.fillStyle = '#FFFFFF';
        ctx.textAlign="center"; 
        ctx.textBaseline="top"; 
        ctx.fillText(currentSong.artist, width/2,height-48); 
        
        ctx.font="9px Arial";
        ctx.fillText(currentSong.title, width/2,height-36); 
        
        var currentTime = currentSong.elem.currentTime;
        var len = currentSong.elem.duration;
        
        
        ctx.textAlign="left";
        ctx.fillText(formatMMSS(currentTime), 5,height-20);
        ctx.textAlign="right";
        ctx.fillText("-"+formatMMSS(len-currentTime), width-5,height-20);
        
        ctx.beginPath();
        ctx.strokeStyle = '#FFFFFF';
        ctx.lineWidth = 8;
        ctx.moveTo(30,height-16);
        ctx.lineTo(width-30 ,height-16);
        ctx.stroke();
        
        
        
        var bufor =0;
        try{
            bufor= currentSong.elem.buffered.end(0)/len*(width-60);
        }
        catch(IndexSizeError){
            
        }
        
        ctx.beginPath();
        ctx.strokeStyle = '#C3C3C3';
        ctx.moveTo(30,height-16);
        ctx.lineTo(30+bufor ,height-16);
        ctx.stroke();
        
        
        
        var ratio = currentTime/len*(width-60);
        
        ctx.beginPath();
        ctx.strokeStyle = '#1665BE';
        ctx.moveTo(30,height-16);
        ctx.lineTo(30+ratio ,height-16);
        ctx.stroke();       
    }
    
    function displayEqualizer(){
        var freqData = new Uint8Array(analyser.frequencyBinCount);

        analyser.getByteFrequencyData(freqData);

        ctx.fillStyle = gradient;

        for (var i = 0; i < 3/5*freqData.length; i+=16 ) {
            var magnitude = 0;
            for(var j=0; j<16;j++){
                magnitude += freqData[i+j];
            }
            magnitude/=16;
            ctx.fillRect((i/16)*(width-2)/38, height-50, (width-6)/38, -magnitude*0.2);
            ctx.fill();
        }
    }    
    
    function displayTop(){
        ctx.beginPath();
        ctx.fillStyle = topcolor;
        ctx.rect(0,0, width, 14);
        ctx.fill();
        
        time = new Date();
        ctx.font="bold 10px Arial";
        ctx.fillStyle = '#FFFFFF';
        ctx.textAlign="center"; 
        ctx.textBaseline="top"; 
        ctx.fillText(formatAMPM(time), width/2,2); 
        
        ctx.beginPath();
        ctx.strokeStyle = '#FFFFFF';
        ctx.lineWidth = 8;
        ctx.moveTo(width-22,7);
        ctx.lineTo(width-5, 7);
        ctx.stroke();
        ctx.lineWidth = 4;
        ctx.moveTo(width-6,7);
        ctx.lineTo(width-3, 7);
        ctx.stroke();
        
        if(play){
            ctx.lineWidth = 4;
            ctx.moveTo(width-35,3);
            ctx.lineTo(width-35, 11);
            ctx.lineTo(width-27, 7);
            ctx.lineTo(width-35,3);
            ctx.fill();            
        }else{            
            ctx.lineWidth = 2;
            ctx.moveTo(width-35,3);
            ctx.lineTo(width-35, 11);
            ctx.stroke();
            ctx.moveTo(width-30,3);
            ctx.lineTo(width-30, 11);
            ctx.stroke();
        }
        
        ctx.beginPath();   
        ctx.moveTo(4,6);
        ctx.lineTo(4, 8);
        ctx.lineTo(7,10);
        ctx.lineTo(7,4);
        ctx.lineTo(4,6);
        ctx.fill();
        var volume = currentSong.elem.volume.toFixed(2)*100 + " %";
        var a = 30/180*Math.PI;
        
        for(var i=0; i<4;i++){
            ctx.beginPath(); 
            ctx.lineWidth = 1;
            ctx.arc(2+i,7,6+i,-a,a);
            ctx.stroke();            
        }
        ctx.font="9px Arial";
        ctx.textAlign="left"; 
        ctx.fillText(volume, 17,2);
        
    }
    
    function onmouseDown(add){
        mouseDown = true;
        mouseDownTime = (new Date()).getTime();
        setTimeout(function(){speedUp(add);}, 100);
    }
    
    function onmouseUp(){
        mouseDown = false;
    }
    
    function playNextSong(add){
        if(add === 1 && nextSong.photo){
            stopPlay();
            songNumber++;
            prevSong.copy(currentSong);
            currentSong.copy(nextSong);
            nextSong.clear();
            playStopSong();
            getSong(songNumber+1, "next");            
        }
        else if(add === -1 && prevSong.photo){
            if(currentSong.elem.currentTime > 30){
                stopPlay();
                currentSong.elem.currentTime=0;
                playStopSong();
            }
            else{
                stopPlay();
                songNumber--;
                nextSong.copy(currentSong);
                currentSong.copy(prevSong);
                prevSong.clear();
                playStopSong();
                getSong(songNumber-1, "prev");   
            }
        }
    }
    
    function speedUp(add){
        if(mouseDown && (new Date()).getTime()-mouseDownTime > 1000){
            if(add > 0 ){
                if(currentSong.elem.currentTime+1<currentSong.elem.duration){
                    currentSong.elem.currentTime+=1;
                }
                else{
                    playNextSong(1);
                }
            }
            else{                
                if(currentSong.elem.currentTime-1>0){
                    currentSong.elem.currentTime-=1;
                }
                else{
                    playNextSong(-1);
                    
                }
            }
        
            
            setTimeout(function(){speedUp(add);}, 100); 
        
        }
        else if(!mouseDown && (new Date()).getTime()-mouseDownTime < 1000){
            playNextSong(add);
        }
        else if(mouseDown){
            setTimeout(function(){speedUp(add);}, 100); 
        }
    }
    
    function formatMMSS(ms){
        if(isNaN(ms)){
            return "0:00";
        }
        else{
            var m = Math.floor(ms/60);
            var s = Math.floor(ms%60);
            s = s<10?"0"+s:s;
            return m +":"+s;
        }
    }
    
    function formatAMPM(date) {
        var hours = date.getHours();
        var minutes = date.getMinutes();
        var ampm = hours >= 12 ? 'PM' : 'AM';
        hours = hours % 12;
        hours = hours ? hours : 12; // the hour '0' should be '12'
        minutes = minutes < 10 ? '0'+minutes : minutes;
        var strTime = hours + ':' + minutes + ' ' + ampm;
        return strTime;
    }
    
    function getSong(songNum, elem){
        var xhttp = new XMLHttpRequest();
        xhttp.onreadystatechange = function() {
            if (xhttp.readyState === 4 && xhttp.status === 200) {
                setNextSong(xhttp.responseText);
            }
        };
        xhttp.open("POST", url+songNum+"/"+elem);
        xhttp.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");
        xhttp.send();
    }
    
    function setNextSong(data){
        var info = obj = JSON.parse(data);
        if(info["audio"] === "prev"){
            setData(prevSong, info);
        }
        if(info["audio"] === "next"){    
            setData(nextSong, info);        
        }
        if(info["audio"] === "curr"){       
            setData(currentSong, info); 
        }
    }
    
    function setData(el, info){
        el.elem.src = songUrl+info["src"] + type;
        el.src = songUrl+info["src"] + type;
        el.photo= songUrl+info["cover"];
        el.artist =info["artist"];
        el.title = info["title"];
        el.image.src = songUrl+info["cover"];
        
    }
    
    function Song(){
        this.src="";
        this.photo="";
        this.title="";
        this.artist="";
        this.elem="";
        this.image = new Image();
        this.copy = function(el){
            this.src = el.src;
            this.photo = el.photo;
            this.title = el.title;
            this.artist = el.artist;
            this.elem.src = el.elem.src; 
            this.image.src = el.image.src;
        };
        this.clear = function(){
            this.src="";
            this.photo="";
            this.title="";
            this.artist="";
            this.image = new Image();
        };
    }
};


$$.load(
function(){
    var test = new Audio();
    test.onerror = function(){mp3player.init(false);};
    test.onloadeddata = function(){mp3player.init(true);};
    test.src = "http://lukaszmical.pl/public/sounds/test/test.mp3";
    console.log(test);
});