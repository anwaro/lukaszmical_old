<div class="clock-all">
    <div class="clockDivApple">
        <canvas id="clock1" class="apple clockCanv"></canvas>
        <div class="clockApple"></div>
    </div>
</div>
<script>
    var can1 = document.getElementById("clock1");
    Clock(can1, "apple");
</script>


<div class="clock-all">
    <div class="clockDivKors">
        <canvas id="clock2" class="kors clockCanv"></canvas>
        <div class="clockKors"></div>
    </div>
</div>
<script>
    var can2 = document.getElementById("clock2");
    Clock(can2, "kors");
</script>