<div class="run-bg">
    <div class="container">
        <div class="row run-box">
            <div class="col-sm-6 col-lg-3 col">
                <div class="input-area"  data-type="period">
                    <div class="input-label">CZAS BIEGU</div>
                    <div class="input-box">
                        <input id="run-period-h" type="text" title="Hours" data-max="24" maxlength="2" value="0"> h :
                    </div>
                    <div class="input-box">
                        <input id="run-period-m" type="text" title="Minutes" data-max="59" maxlength="2" value="0"> m :
                    </div>
                    <div class="input-box">
                        <input id="run-period-s" type="text" title="Seconds" data-max="59" maxlength="2" value="0"> s
                    </div>
                </div>
            </div>
            <div class="col-sm-6 col-lg-3 col">
                <div class="input-area" data-type="distance">
                    <div class="input-label">DYSTANS</div>
                    <div class="input-box">
                        <input id="run-distance-km" class="w3" type="text" title="Kilometers" maxlength="3" data-max="999"  value="0"> km :
                    </div>
                    <div class="input-box">
                        <input id="run-distance-m" class="w3" type="text" title="Meters" maxlength="3" data-max="999" value="0"> m
                    </div>
                    <div class="radio-box">
                        <label class="input-box"  title="1 km">
                            <input type="radio" class="run-radio" name="distance" title="1 km" data-km="1" data-m="0"> 1km
                        </label>
                        <label class="input-box" title="5 km" >
                            <input type="radio" class="run-radio" name="distance" title="5 km" data-km="5" data-m="0"> 5km
                        </label>
                        <label class="input-box" title="10 km" >
                            <input type="radio" class="run-radio" name="distance" title="10 km" data-km="10" data-m="0"> 10km
                        </label>
                        <label class="input-box" title="Half Marathon 21km 97m">
                            <input type="radio" class="run-radio" name="distance" title="Half Marathon 21km 97m" data-km="21" data-m="97"> h-mar
                        </label>
                        <label class="input-box" title="Marathon 42km  195m">
                            <input type="radio" class="run-radio" name="distance" title="Marathon 42km 195m" data-km="42" data-m="195"> mar
                        </label>
                    </div>
                </div>
            </div>
            <div class="col-sm-6 col-lg-3 col">
                <div class="input-area" data-type="pace">
                    <div class="input-label">TEMPO BIEGU</div>
                    <div class="input-box">
                        <input id="run-pace-m" data-type="s_km" type="text" title="Minutes" maxlength="2" data-max="59" value="0"> m
                    </div>
                    <div class="input-box">
                        <input id="run-pace-s" data-type="s_km" type="text" title="Seconds" maxlength="2" data-max="59" value="0"> s
                    </div>
                </div>
            </div>
            <div class="col-sm-6 col-lg-3 col">
                <div class="input-area" data-type="speed">
                    <div class="input-label">PRĘDKOŚĆ</div>
                    <div class="input-box">
                        <input id="run-speed-km-h" data-type="km_h" type="text" class="w3" title="Speed km/h" maxlength="4" data-max="30" value="0"> km/h
                    </div>
                    <div class="input-box">
                        <input id="run-speed-m-s"  data-type="m_s" type="text" class="w3" title="Speed m/s" maxlength="4" data-max="30" value="0"> m/s
                    </div>
                </div>
            </div>
        </div>

        <div class="row run-box">
            <div class="col-md-12 col">
                <div class="table-area">
                    <div class="table-header">
                        <div class="empty-box"></div>
                        <div id="run-table-header-top" class="table-title"></div>
                    </div>
                    <div class="table-body">
                        <div class="table-side"><span id="run-table-header-side" class="side-label" ></span></div>
                        <div class="table-main">
                            <table id="run-table-body"></table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
