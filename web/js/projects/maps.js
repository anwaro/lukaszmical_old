
$maps = new function(){
	var canvas,ctx
	;
	
	this.init = function(){
		canvas = $$("#maps");
		canvas
		ctx = canvas.getContext("2d");
	}

}

$$.load(function(){
	$maps.init();
});