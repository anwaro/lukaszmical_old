
function Tester(){
    this.mp3 = function(){
        var a = document.createElement('audio');
        return !!(a.canPlayType && a.canPlayType('audio/mpeg;').replace(/no/, ''));
    };

    this.context2d = function(){
        try {
            var canvas = document.createElement('canvas');
            if(canvas && canvas.getContext){
                canvas.getContext("2d");
                return true;
            }else {
                return false;
            }
        }
        catch(error){
            return false;
        }
    };

    this.audio = function () {
        try {
            var audio = new Audio();
        }
        catch(error){
            return false;
        }
    };
    this.audioContext = function(){
        try{
            var audioContext = new AudioContext() ||   new webkitAudioContext();
            var source = audioContext.createMediaElementSource(new Audio());
            var analyser = audioContext.createAnalyser();
            source.connect(analyser);
            analyser.connect(audioContext.destination);
            return true;
        }
        catch(error){
            return false;
        }
    };

    this.isMobile = function () {
        return !!/Android|webOS|iPhone|iPad|iPod|BlackBerry|IEMobile|Opera Mini|Phone/i.test(navigator.userAgent);
    }
}
