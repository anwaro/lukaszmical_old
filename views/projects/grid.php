<?php
/**
 * Created by PhpStorm.
 * User: lukasz
 * Date: 28.06.17
 * Time: 22:08
 */

?>
<canvas id="grid" class=" action" data-action="close"></canvas>

<div class="photo-loader end action" data-action="close">
    <span id="pr-1" class="loader-pr"></span>
    <div id="progress" class="photo-progress">
        <div class="bar">
            <span id="pr-2" class="loader-pr"></span>
        </div>
    </div>
    <label for="image" class="photo-label">
        <input type="file" id="image" class="file-input"  accept="image/*">
    </label>
</div>
<div class="settings action" data-action="open"></div>

<div class="setting-box">
    <a href="#" class="close action" data-action="close"></a>

    <br>----------- OGÓLNE --------------
    <div class="input-box">

        <label>Zasięg działania</label>
        <input title="as" class="slider input-action" type="range" step="1" min="0" max="4000" data-action="setValue"
               data-var="maxRange">
        <span id="maxRange" class="val"></span>
    </div>

    <div class="input-box">
        <label>Siła odziałania</label>
        <input title="as" class="slider input-action" type="range" step="1" min="0" max="600" data-action="setValue"
               data-var="maxForce">
        <span id="maxForce" class="val"></span>
    </div>

    <br>----------- INTRO --------------

    <div class="input-box">
        <label>Ilość x</label>
        <input title="as" class="slider input-action" type="range" step="1" min="5" max="100" data-action="setValue"
               data-var="countX">
        <span id="countX" class="val"></span>
    </div>

    <div class="input-box">
        <label>Ilość y</label>
        <input title="as" class="slider input-action" type="range" step="1" min="5" max="100" data-action="setValue"
               data-var="countY">
        <span id="countY" class="val"></span>
    </div>

    <div class="input-box">
        <div class="btn action" data-action="generatePoint">ZASTOSUJ</div>
    </div>

    <br>------------ ZDJĘCIE -------------

    <div class="input-box">
        <label>Ilość pixeli</label>
        <input title="as" class="slider input-action" type="range" step="1" min="5" max="60000" data-action="setValue"
               data-var="pixelCount">
        <span id="pixelCount" class="val"></span>
    </div>


    <div class="input-box">
        <label>Maksymalna ilość pixeli</label>
        <input title="as" class="slider input-action" type="range" step="1" min="5" max="80000" data-action="setValue"
               data-var="maxPixelCount">
        <span id="maxPixelCount" class="val"></span>
    </div>

    <div class="input-box">
        <div class="btn action" data-action="loadPhoto">PRZEŁADUJ</div>
        <div class="btn action" data-action="generatePoint">USUŃ</div>
    </div>

    <br>------------ INNE -------------

    <div class="input-box">
        <div class="btn action" data-action="toggle" data-var="exp">EXP TOGGLE</div>
        <div class="btn action" data-action="toggle" data-var="smooth">SMOOTH TOGGLE</div>
    </div>


</div>
<div class="stats">
    <div id="fps"></div>
    <div id="particle"></div>
</div>

