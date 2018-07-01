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
                    <div class="radio-box">
                        <input type="button" class="input-example" value="0:45:00" data-type="period" data-h="0" data-min="45" data-sec="0" title="0:45:00">
                        <input type="button" class="input-example" value="1:00:00" data-type="period" data-h="1" data-min="0" data-sec="0" title="1:00:00">
                        <input type="button" class="input-example" value="1:30:00" data-type="period" data-h="1" data-min="30" data-sec="0" title="1:30:00">
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
                        <input type="button" class="input-example" value="1 km" data-type="distance" data-km="1" data-m="0" title="1 km">
                        <input type="button" class="input-example" value="5 km" data-type="distance" data-km="5" data-m="0" title="5 km">
                        <input type="button" class="input-example" value="10 km" data-type="distance" data-km="10" data-m="0" title="10 km">
                        <input type="button" class="input-example" value="h-mar" data-type="distance" data-km="21" data-m="97" title="Half Marathon 21km 97m">
                        <input type="button" class="input-example" value="mar"  data-type="distance" data-km="42" data-m="195" title="Marathon 42km 195m">
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
                    <div class="radio-box">
                        <input type="button" class="input-example" value="4'00''" data-type="pace" data-min="4" data-sec="0" title="4'00''">
                        <input type="button" class="input-example" value="4'15''" data-type="pace" data-min="4" data-sec="15" title="4'15''">
                        <input type="button" class="input-example" value="4'30''" data-type="pace" data-min="4" data-sec="30" title="4'30''">
                        <input type="button" class="input-example" value="4'45''" data-type="pace" data-min="4" data-sec="45" title="4'45''">
                        <input type="button" class="input-example" value="5'00''" data-type="pace" data-min="5" data-sec="0" title="5'00''">
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
                    <div class="radio-box">
                        <input type="button" class="input-example" value="12km/h" data-type="speed" data-km_h="12" data-m_s="3.3" title="12km/h">
                        <input type="button" class="input-example" value="13km/h" data-type="speed" data-km_h="13" data-m_s="3.6" title="13km/h">
                        <input type="button" class="input-example" value="14km/h" data-type="speed" data-km_h="14" data-m_s="3.9" title="14km/h">
                        <input type="button" class="input-example" value="15km/h" data-type="speed" data-km_h="15" data-m_s="4.2" title="15km/h">
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
