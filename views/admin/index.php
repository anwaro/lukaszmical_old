<?php

$this->title = "Panel administaracyjny";
?>

<div class="info">
   <?= $info ?>
</div>

<div class="info">
   Zajęte miejsce na dysku: <?= $size ?>MB /2024MB (<?= floor($size*100/2024) ?>%) 
</div>


<h3 style="margin-top: 60px;">Dodaj projekt</h3>
<form action="{%url%}/admin/add" method="POST">
    <p>Nazwa projektu</p>
    <input type="text" name="url" >
    <input type="submit" value="Dodaj">
</form>