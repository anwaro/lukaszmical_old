<?php
/**
 * Created by PhpStorm.
 * User: lukasz
 * Date: 04.12.16
 * Time: 22:07
 */

?>

<div>


</div>


<iframe id="spotify" src="https://play.spotify.com/"></iframe>


<script>
    function iframeRef( frameRef ) {
        return frameRef.contentWindow
            ? frameRef.contentWindow.document
            : frameRef.contentDocument
    }

    var inside = iframeRef( document.getElementById('one') )
    console.log(inside);
</script>