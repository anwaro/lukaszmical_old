<div id="plotMath">
    <div id="setting">
        <table class="plot">
            <tr>
                <td>Funkcja &nbsp; <i> f<sub>(x)</sub>=</i></td>
                <td colspan=3><input id="function" type="text" size="70" value="x"></td>
            </tr>
            <tr>
                <td>Zakres od</td>
                <td><input id="xmin" type="text" size="5" value="0"></td>
                <td>do</td>
                <td><input id="xmax" type="text" size="5" value="10"></td>
            </tr>
            <tr>
                <td>Wysokość</td>
                <td><input id="y" type="text" size="5" value="500">px</td>
                <td>Szerokość</td>
                <td><input id="x" type="text" size="5" value="600">px</td>
            </tr>
            <tr>
                <td>Podziałka x</td>
                <td><input id="g_x" type="text" size="5" value="10"></td>
                <td>Podziałka y</td>
                <td><input id="g_y" type="text" size="5" value="10"></td>
            </tr>
            <tr>
                <td>Margines pionowy</td>
                <td><input id="m_x" type="text" size="5" value="70">px</td>
                <td>Margines poziomy</td>
                <td><input id="m_y" type="text" size="5" value="50">px</td>
            </tr>
            <tr>
                <td>Opis osi X</td>
                <td><input id="o_x" type="text" size="15" value="x"></td>
                <td>Opis osi Y</td>
                <td><input id="o_y" type="text" size="15" value="y"></td>
            </tr>
            <tr>
                <td></td>
                <td><input id="draw" type="button" value="Rysuj"></td>
                <td>
                    <a id="down" href download>
                        <input id="convert" type="button" value="Pobierz">
                    </a>
                </td>
                <td id="canvasImg"></td>
            </tr>
        </table>
    </div>
    <div>
        <canvas id="mathCanvas"></canvas>
    </div>
    <br>
    <div id="info">
        <div class="opt">PI, Pi pi
            <div class="help">&pi;</div>
        </div>
        <div class="opt">abs(x)
            <div class="help">Returns the absolute value of x</div>
        </div>
        <div class="opt">acos(x)
            <div class="help">Returns the arccosine of x, in radians</div>
        </div>
        <div class="opt">asin(x)
            <div class="help">Returns the arcsine of x, in radians</div>
        </div>
        <div class="opt">atan(x)
            <div class="help">Returns the arctangent of x as a numeric value between -PI/2 and PI/2 radians</div>
        </div>
        <div class="opt">ceil(x)
            <div class="help">Returns x, rounded upwards to the nearest integer</div>
        </div>
        <div class="opt">cos(x)
            <div class="help">Returns the cosine of x (x is in radians)</div>
        </div>
        <div class="opt">exp(x)
            <div class="help">Returns the value of e<sup>x</sup></div>
        </div>
        <div class="opt">floor(x)
            <div class="help">Returns x, rounded upwards to the nearest integer</div>
        </div>
        <div class="opt">log(x)
            <div class="help">Returns the natural logarithm (base E) of x</div>
        </div>
        <div class="opt">pow(x,y)
            <div class="help">Returns the value of x to the power of y</div>
        </div>
        <div class="opt">rand
            <div class="help">Returns a random number between 0 and 1Returns a random number between 0 and 1</div>
        </div>
        <div class="opt">round(x)
            <div class="help">Rounds x to the nearest integer</div>
        </div>
        <div class="opt">sin(x)
            <div class="help">Returns the sine of x (x is in radians)</div>
        </div>
        <div class="opt">sqrt(x)
            <div class="help">Returns the square root of x</div>
        </div>
        <div class="opt">tan(x)
            <div class="help">Returns the tangent of an angle</div>
        </div>
    </div>
</div>

<script>
    document.addEventListener('DOMContentLoaded', function () {
        M.init();
    });
</script>

