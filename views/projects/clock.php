<div class="clock-all">
    <div class="clockDivApple">
        <canvas id="clock1" class="apple clockCanv"></canvas>
        <div class="clockApple"></div>
    </div>
</div>
<script>
</script>


<div class="clock-all">
    <div class="clockDivKors">
        <canvas id="clock2" class="kors clockCanv"></canvas>
        <div class="clockKors"></div>
    </div>
</div>
<script>
    document.addEventListener('DOMContentLoaded', function () {
        Clock(document.getElementById("clock1"), "apple");
        Clock(document.getElementById("clock2"), "kors");
    });
</script>