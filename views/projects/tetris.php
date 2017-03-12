<?php

$size = 20;
$tapSize = 60;

$height = ($size * 16 +50) . "px";
$width = ($size * 10 +100) . "px";
$move = ($tapSize/2) . "px";
$tap = $tapSize . "px";

?>

<style>
    canvas{
        background-color: #2a65a0;
    }
    .row-box{
        position: relative;
    }
    .play {
        min-width: 150px;
        position: absolute;
        left: 50%;
        top: 50%;
        transform: translate(-50%, -50%);

    }
    .tetris-area{
        margin:30px auto;
        width: <?= $width ?>;
        height: <?= $height ?>;
    }
    .rotate,  .move-left, .move-right, .move-down{
        font-size:40px;
        height:50px;
        line-height:50px;
        float: left;
        width: 25%;
        color: #4d686d;
    }

</style>
<div class="row-box">
    <div class="tetris-area">
        <canvas id="tetris"></canvas>
        <div class="move-left"><i class="fa fa-chevron-left" aria-hidden="true"></i></div>
        <div class="move-right"><i class="fa fa-chevron-right" aria-hidden="true"></i></div>
        <div class="rotate"><i class="fa fa-undo" aria-hidden="true"></i></div>
        <div class="move-down"><i class="fa fa-chevron-down"></i></div>
    </div>

    <div class="play">
        <a class="button" href="javascript:startTetris()">PLAY</a>
    </div>
</div>