<div class="row-box" style="min-height:600px;">
    <br>
    <input id="rgb" type="text" title="color">
    <br>
    <div id="picker"
         style="margin:10px auto;height: 150px; width: 150px; border: 4px dashed; position: relative;"></div>

</div>

<script>
    var output = $$("#rgb");
    colorpicker("picker", function (el, color) {
        el.style.background = color;
        output.value = color;
    });

</script>