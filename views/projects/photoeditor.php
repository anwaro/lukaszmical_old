<div id="photo">
    <div id="photo-panel">
        <input type="file" id="photo-choser-input">
        <label id="photo-choser-label" for="photo-choser-input">
            <div id="photo-choser">Wybierz zdjęcie</div>
        </label>
        <div id="photo-orginal" class="switch">
            ORGINAŁ
            <button id="orginal-show" class="switcher true" value="true"></button>
        </div>
        <div id="photo-touse" class="switch">
            NAKŁADAJ
            <button id="photo-use" class="switcher false" value="false"></button>
        </div>
    </div>

    <div id="photo-option">
        <div class="photoedit color">
            KOLOR
            <div class="photomenu">
                <div data-edit="negatyw" class="edit photooption negatyw">NEGATYW</div>
                <div data-edit="szary" class="edit photooption szary">SZAROŚĆ</div>
                <div data-edit="sepia" class="edit photooption sepia">SEPIA</div>
                <div data-edit="bit" class="edit photooption bit">KOLORY</div>
            </div>
        </div>
        <div class="photoedit kontur1">
            KONTUR
            <div class="photomenu">
                <div data-edit="kontur1" class="edit photooption kontur1">KONTUR 1</div>
                <div data-edit="kontur2" class="edit photooption kontur2">KONTUR 2</div>
            </div>
        </div>
        <div id="akcent" data-edit="akcent" class="edit photoedit akcent hide-child">
            AKCENT
        </div>
        <div class="photoedit  progcz-bi">
            PROGOWANIE
            <div class="photomenu">
                <div data-edit="progowanie-2" class="edit photooption progsz-bi">SZAROŚĆ I BIEL</div>
                <div data-edit="progowanie-1" class="edit photooption progcz-bi">CZARNY I BIAŁY</div>
                <div data-edit="progowanie-0" class="edit photooption progcz-szar">CZARNY I SZAROŚĆ</div>
            </div>
        </div>
        <div class="photoedit pixel">
            PIXEL
            <div class="photomenu">
                <div data-edit="circle"  class="edit photooption circle">KÓŁKA</div>
                <div data-edit="pixel"   class="edit photooption pixel">PIXEL</div>
                <div data-edit="dots"    class="edit photooption dots">KROPKI</div>
                <div data-edit="randpix" class="edit photooption randpix">RANDPIX</div>
            </div>
        </div>
        <div class="photoedit m3x3">
            MASKA
            <div class="photomenu">
                <div data-size='3' class="maskshow photooption m3x3">3x3</div>
                <div data-size='5' class="maskshow photooption m5x5">5x5</div>
                <div data-edit="randMask" class="edit photooption losowa">LOSOWA</div>
            </div>
        </div>
        <div class="photoedit lab">
            LAB
            <div class="photomenu">
                <div data-edit="lab" class="edit photooption lab">RAND</div>
            </div>
        </div>

        <div><input id="range" type="range" min="1" max="100" step="1" value="15"></div>
        <div id="mask" class="hide">
            <div id="mask-matrix"></div>
            <div data-edit='ownMask-3' id="mask-action" class="edit">GO</div>
        </div>
    </div>


    <div id="photo-canvas">
        <canvas id="canvas-orginal"></canvas>
        <canvas id="canvas-input" style="display: none;"></canvas>
        <canvas id="canvas-output"></canvas>


    </div>
</div>