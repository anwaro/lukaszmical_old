<?php

?>

<?php foreach ($errors as $error):?>
<div>Fatal Error 
    <?= $error["msg"]?> in <?= $error["file"]?>: <?= $error["file"]?>
</div>


<?php endforeach; ?>


<?php 

//var_dump($errors);

