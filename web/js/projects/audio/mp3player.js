/**@var {function} Audio */
/**@var {function} AudioContext */
/**@var {object} player.vis.analyser */
/**@var {function} webkitAudioContext */

CanvasRenderingContext2D.prototype.loadConfig = function(config){
    for(var prop in config){
        if(config.hasOwnProperty(prop) && prop in this){
            this[prop] = config[prop];
        }
    }
};

CanvasRenderingContext2D.prototype.strokeLine = function(points, option, close){
    this.beginPath();
    this.loadConfig(option || {});
    this.moveTo(points[0][0], points[0][1]);
    for(var i =0; i<points.length;i++){
        this.lineTo(points[i][0], points[i][1]);
    }
    close && this.lineTo(points[0][0], points[0][1]);
    this.stroke();

};
CanvasRenderingContext2D.prototype.fillArea = function(points, option){
    this.beginPath();
    this.loadConfig(option || {});
    this.moveTo(points[0][0], points[0][1]);
    for(var i =0; i<points.length;i++){
        this.lineTo(points[i][0], points[i][1]);
    }
    this.lineTo(points[0][0], points[0][1]);
    this.fill();
};


mp3player = new function(){
    var canvas,
        ctx,
        width = 169,
        height= 262,
        time;
    var color={
        topBg: "#32312F",
        main: "#191919",
        progressArea: "rgba(48, 48, 41, 0.8)",
        progressBg: "#FFFFF",
        progress: '#1665BE',
        buffer: "#C3C3C3",
        font : '#FFFFFF',
        top: '#FFFFFF',
        spin: '#FFFFFF',
        menu: 'rgba(3, 3, 3, 0.8)',
        select: '#1665BE',
        // border:
        vis: {
            grad: null,
            c1: "rgba(0, 0, 0, 0.7)",
            c2: "rgba(255, 0, 0, 0.7)",
            c3: "rgba(0, 128, 0, 0.7)",
            c4: "rgba(0, 0, 255, 0.7)"
        }
    };

    var player = {
        data: [],
        buffer: false,
        play: false,
        type: ".mp3",
        audio:{
            prev: new Song(),
            current: new Song(),
            next: new Song()
        },
        url:{
            info: "/song/get/",
            audio: "/sounds/mp3/",
            cover: "/images/projects/mp3player/covers/"
        },
        vis:{
            support: false,
            source: null,
            analyser: null
        }

    };

    var mouse ={
        down : false,
        downTime: null
    };

    var controls ={
        menu: {
            el : null,
            open: false,
            maxH: 198,
            height: 0,
            list: null,
            select:0

        },
        next: null,
        prev: null,
        play: null,
        vol:{
            up: null,
            down: null
        }
    };

    this.init = function(supportMp3){
        canvas = document.getElementById("mp3screen");
        canvas.height=height;
        canvas.width=width;
        if(canvas && canvas.getContext){
            ctx = canvas.getContext("2d");
            setInterval(render, 1000/60);
            initButton();
            initSong(supportMp3);
            setVisualizer();
        }
    };

    function initButton(){
        controls.next = document.getElementById("next");
        controls.prev = document.getElementById("prev");
        controls.menu.el = document.getElementById("menu");
        controls.play = document.getElementById("play");
        controls.vol.up = document.getElementById("vol-up");
        controls.vol.down = document.getElementById("vol-down");

        controls.next.addEventListener('mousedown', function(){mouseDown(1)});
        controls.next.addEventListener('mouseup', mouseUp);
        controls.next.addEventListener('touchend', mouseUp);

        controls.prev.addEventListener('mousedown', function(){mouseDown(-1)});
        controls.prev.addEventListener('mouseup', mouseUp);
        controls.prev.addEventListener('touchend', mouseUp);

        controls.play.addEventListener('click', playStopSong);
        controls.menu.el.addEventListener('click', openCloseMenu);

        controls.vol.up.addEventListener('click', function(){changeVolume(0.1)});
        controls.vol.down.addEventListener('click', function(){changeVolume(-0.1)});
    }

    function initSong(supportMp3){
        if(supportMp3){
            console.log("Wow your browser is awesome, it support mp3 format");
            player.type = ".mp3";
        }
        else{
            console.log("Your browser doesn't support mp3 format, so it use ogg format which is more poor");
            player.type = ".ogg";
        }
        player.audio.current.elem = document.getElementById("current-song");
        player.audio.current.elem.volume =0.5;
        player.audio.next.elem = document.getElementById("next-song");
        player.audio.prev.elem = document.getElementById("prev-song");
        loadAllSong();
    }

    function changeVolume(add){
        if(player.audio.current.elem.volume+add>0 && player.audio.current.elem.volume+add<1){
            player.audio.current.elem.volume+=add;
        }
    }

    function playStopSong(){
        if(controls.menu.open && !controls.menu.close){
            playFromList();
        }
        else if(player.play){
            player.play = false;
            player.audio.current.elem.pause();
        }else{
            if(typeof player.audio.current.elem.play==="function"){
                player.play = true;
                player.audio.current.elem.play();
            }else{
                setTimeout(playStopSong, 100);
            }
        }
    }

    function stopPlay(){
        player.play = false;
        player.audio.current.elem.pause();
    }

    function openCloseMenu() {
        if(controls.menu.open){
            controls.menu.close = true;
        }
        else {
            controls.menu.select = player.audio.current.id;
            initMenuList();
            controls.menu.open = true;
        }
    }

    function initMenuList() {
        controls.menu.list = [];
        for(var i = controls.menu.select - 5; i < controls.menu.select+5; i++){
            controls.menu.list.push(getItem(i))
        }
        controls.menu.list.reverse()
    }

    function getItem(id) {
        if(id < 0) id+=player.data.length;
        if(id>=player.data.length) id-=player.data.length;
        return [id, player.data[id]];
    }

    function playFromList() {
        player.play = false;
        player.audio.current.elem.pause();

        player.audio.current.id = controls.menu.select;
        getSong(player.audio.current, 0);
        getSong(player.audio.prev, -1);
        getSong(player.audio.next, 1);
        controls.menu.close = true;
        playStopSong();

    }

    function setVisualizer(){
        color.vis.grad = ctx.createLinearGradient(0,height-100,0,height-50);
        color.vis.grad.addColorStop(0,  color.vis.c1);
        color.vis.grad.addColorStop(.3, color.vis.c2);
        color.vis.grad.addColorStop(.6, color.vis.c3);
        color.vis.grad.addColorStop(1,  color.vis.c4);
        player.vis.support = true;
        try{
            var audioContext = new AudioContext() || new webkitAudioContext();
            player.vis.source = audioContext.createMediaElementSource(player.audio.current.elem);
            player.vis.analyser = audioContext.createAnalyser();
            player.vis.source.connect(player.vis.analyser);
            player.vis.analyser.connect(audioContext.destination);
            console.log("Your browser support audioContext object");
        }catch(err){
            player.vis.support = false;
            console.log("Your browser doesn't support audioContext object, equalizer will not render", err);
        }
    }

    function render(){
        ctx.beginPath();
        ctx.fillStyle = color.main;
        ctx.clearRect(0,14, width, height);

        renderPhoto();
        renderTop();
        renderProgress();
        if(controls.menu.open){
            renderMenu();
        }
        else if(player.vis.support){
            renderEqualizer();
        }

        var len = player.audio.current.elem.duration;
        if(Math.abs(len-player.audio.current.elem.currentTime)<0.1){
            playNextSong(1);
        }
        player.buffer =!(len > 0 && player.audio.current.elem.paused && player.play);
    }

    function renderMenu(){
        if(!controls.menu.close && controls.menu.height<controls.menu.maxH){
            controls.menu.height+=10;
        }
        if(controls.menu.close){
            controls.menu.height-=10;
            if(controls.menu.height<0){
                controls.menu.height=0;
                controls.menu.close=false;
                controls.menu.open=false;
                return 0;
            }
        }
        var bottom = 14+controls.menu.height;
        var listId = 0;
        ctx.fillArea([[0, 14], [width, 14], [width, bottom], [0, bottom]], {fillStyle: color.menu});
        while (bottom >=14+20){
            if(getItemId(listId) == controls.menu.select){
                ctx.fillArea([[0, bottom], [width, bottom], [width, bottom-20], [0, bottom-20]], {fillStyle: color.select});
            }

            ctx.loadConfig({
                font: "bold 9px Arial",
                textAlign: "left",
                textBaseline: "middle",
                fillStyle: color.font
            });
            ctx.fillStyle = color.font;
            ctx.fillText(label(listId), 5, bottom - 10);
            bottom-=20;
            listId++;
        }
    }

    function getItemId(id) {
        return controls.menu.list[id][0]
    }

    function label(id){
        var data = controls.menu.list[id][1];
        return getItemId(id) +  ". " + data['artist'] +' - ' + data['title'];

    }

    function renderPhoto(){
        var load = false;
        if(player.audio.current.image.complete && player.audio.current.image.src){
            var marginLeft = (player.audio.current.image.width-width)/2;
            try{
                ctx.drawImage(player.audio.current.image, marginLeft,  0, width, height, 0, 14, width, height-14);
            }catch(InvalidStateError){
                load = true;
            }

        }else{
            load = true;
        }

        if(!player.buffer || load){
            var a = ((new Date()).getTime()/250)%(2*Math.PI);
            ctx.save();
            ctx.beginPath();
            ctx.lineWidth=2;
            ctx.translate(width/2, height/2);
            ctx.strokeStyle=color.spin;
            ctx.arc(0, 0, 40, a, a+0.7*Math.PI);
            ctx.stroke();
            ctx.restore();
        }
    }

    function renderProgress() {
        ctx.beginPath();
        ctx.fillStyle = color.progressArea;
        ctx.fillRect(0, height - 50, width, 50);

        ctx.loadConfig({
            font: "bold 10px Arial",
            textAlign: "center",
            textBaseline: "top",
            fillStyle: color.font
        });
        ctx.fillText(player.audio.current.artist, width / 2, height - 44);
        ctx.font = "9px Arial";
        ctx.fillText(player.audio.current.title, width / 2, height - 32);

        var currentTime = player.audio.current.elem.currentTime;
        var len = player.audio.current.elem.duration;


        ctx.textAlign = "left";
        ctx.fillText(formatMMSS(currentTime), 5, height - 18);
        ctx.textAlign = "right";
        ctx.fillText("-" + formatMMSS(len - currentTime), width - 5, height - 18);

        var progress = currentTime / len * (width - 60);
        var buffer = progress + 1;
        try {
            buffer = player.audio.current.elem.buffered.end(0) / len * (width - 60);
        }
        catch (IndexSizeError) {}

        ctx.strokeLine([[30, height - 12], [width - 30, height - 12]], {'strokeStyle': color.progressBg,'lineWidth': 8});
        ctx.strokeLine([[30, height - 12], [30 + buffer, height - 12]], {'strokeStyle': color.buffer});
        ctx.strokeLine([[30, height - 12], [30 + progress, height - 12]], {'strokeStyle': color.progress});

    }
    function renderEqualizer(){
        var freqData = new Uint8Array(player.vis.analyser.frequencyBinCount);

        player.vis.analyser.getByteFrequencyData(freqData);

        ctx.fillStyle = color.vis.grad;

        for (var i = 0; i < 3/5*freqData.length; i+=16 ) {
            var magnitude = 0;
            for(var j=0; j<16;j++){
                magnitude += freqData[i+j];
            }
            magnitude/=16;
            ctx.fillRect((i/16)*(width-2)/38, height-50, (width-6)/38, -magnitude*0.2);
        }
    }

    function renderTop(){
        ctx.beginPath();
        ctx.fillStyle = color.topBg;
        ctx.fillRect(0,0, width, 14);

        time = new Date();

        ctx.loadConfig({
            font: "bold 10px Arial",
            textAlign: "center",
            textBaseline: "top",
            fillStyle: color.font
        });
        ctx.fillText(formatAMPM(time), width/2,2);

        //BATTERY
        ctx.strokeLine([[width-22,7], [width-5, 7]],{strokeStyle: color.top, lineWidth: 8});
        ctx.strokeLine([[width-6,7], [width-3, 7]],{strokeStyle: color.top, lineWidth: 4});


        if(player.play){
            // PLAY ICON
            ctx.fillArea([[width-35,3], [width-35, 11], [width-27, 7]], {lineWidth: 4});
        }else{
            // PAUSE ICON
            ctx.strokeLine([[width-35,3], [width-35, 11]], {lineWidth: 2});
            ctx.strokeLine([[width-30,3], [width-30, 11]], {lineWidth: 2});
        }


        // SPEAKER ICON
        ctx.fillArea([[4,6], [4,8], [7,10], [7,4]], {});

        var a = 30/180*Math.PI;

        for(var i=0; i<4;i++){
            ctx.beginPath();
            ctx.lineWidth = 1;
            ctx.arc(2+i,7,6+i,-a,a);
            ctx.stroke();
        }
        ctx.font="9px Arial";
        ctx.textAlign="left";

        ctx.fillText(player.audio.current.elem.volume.toFixed(2)*100 + " %", 17,2);
    }

    function mouseDown(add){
        if(controls.menu.open && !controls.menu.close){
            var id = controls.menu.select + add;
            if(id<0) id += player.data.length;
            if(id>=player.data.length)id -= player.data.length;
            controls.menu.select = id;
            initMenuList();

        }else{
            mouse.down = true;
            mouse.downTime = (new Date()).getTime();
            setTimeout(function(){speedUp(add);}, 100);
        }

    }

    function mouseUp(){
        mouse.down = false;
    }

    function playNextSong(add){
        if(add === 1){
            stopPlay();
            player.audio.prev.copy(player.audio.current);
            player.audio.current.copy(player.audio.next);
            player.audio.next.clear();
            playStopSong();
            getSong(player.audio.next, 1);
        }
        else if(add === -1){
            if(player.audio.current.elem.currentTime > 30){
                stopPlay();
                player.audio.current.elem.currentTime=0;
                playStopSong();
            }
            else{
                stopPlay();
                player.audio.next.copy(player.audio.current);
                player.audio.current.copy(player.audio.prev);
                player.audio.prev.clear();
                playStopSong();
                getSong(player.audio.prev, -1);
            }
        }
    }

    function speedUp(add){
        if(mouse.down && (new Date()).getTime()-mouse.downTime > 1000){
            if(add > 0 ){
                if(player.audio.current.elem.currentTime+1<player.audio.current.elem.duration){
                    player.audio.current.elem.currentTime+=1;
                }
                else{
                    playNextSong(1);
                }
            }
            else{
                if(player.audio.current.elem.currentTime-1>0){
                    player.audio.current.elem.currentTime-=1;
                }
                else{
                    playNextSong(-1);
                }
            }
            setTimeout(function(){speedUp(add);}, 100);
        }
        else if(!mouse.down && (new Date()).getTime()-mouse.downTime < 1000){
            playNextSong(add);
        }
        else if(mouse.down){
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
        return hours + ':' + minutes + ' ' + ampm;
    }

    function loadAllSong(){
        var xhttp = new XMLHttpRequest();
        xhttp.onreadystatechange = function() {
            if (xhttp.readyState === 4 && xhttp.status === 200) {
                setSongData(xhttp.responseText);
            }
        };
        xhttp.open("POST", player.url.info);
        xhttp.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");
        xhttp.send();
    }

    function getSong(el, add){
        var id = player.audio.current.id + add;
        if(id<0)  id = player.data.length;
        if(id>=player.data.length) id = 0;
        var info = player.data[id];
        el.id = id;
        el.elem.src = player.url.audio+info["src"] + player.type;
        el.artist =info["artist"];
        el.title = info["title"];
        el.image.src = player.url.cover+info["cover"];
    }

    function setSongData(data){
        player.data = JSON.parse(data);
        player.audio.current.id = Math.floor(Math.random()*player.data.length);
        getSong(player.audio.current, 0);
        getSong(player.audio.prev, -1);
        getSong(player.audio.next, 1);
    }

    function Song(){
        this.id = 0;
        this.title="";
        this.artist="";
        this.elem=null;
        this.image = new Image();
        this.copy = function(el){
            this.id = el.id;
            this.title = el.title;
            this.artist = el.artist;
            this.elem.src = el.elem.src;
            this.image.src = el.image.src;
        };
        this.clear = function(){
            this.id = 0;
            this.src="";
            this.title="";
            this.artist="";
            this.image = new Image();
        };
    }
};


$$.load(function(){
    var test = new Audio();
    test.onerror = function(){mp3player.init('MP3', false)};
    test.onloadeddata = function(){mp3player.init('MP3', true)};
    test.src = "/sounds/test/test.mp3";
});