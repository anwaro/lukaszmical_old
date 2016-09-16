<br><br>
<canvas id="planet"></canvas>

<br><br>
<script>
    var c = document.getElementById("planet");
    var rec = Record(c, {});

</script>
<div id="record-info"></div>
<button onclick="rec.start();">Start</button>
<button onclick="rec.stop();">Stop</button>
<button onclick="rec.getVideo();">Daj film</button>

<br>
<br>
<h2>Wygenerowany film</h2>

<video controls  height="500" width="700">
    <source src="{%url%}/public/video/out2.mp4">
</video>

<br>
<br>
