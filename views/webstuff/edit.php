<?php 

$this->title = "Edytuj wpis";
?>

<style>
    small{
        font-size: 70%;
    }
</style>
<form action="{%url%}webstuff/edit/<?= $_web["id"]?>" method="POST">
    <b>Text:</b> <small>(<?= $_web["text"]?>)</small>:
    <textarea  name="webstuff-text" ><?= $web["text"]?></textarea><br>
    
    <b>Urls</b> <small>(<?= $_web["links"]?>) </small>:
    <input type="text" name="webstuff-links" value="<?= $web["links"]?>" ><br>
    <b>Data</b> <small>(<?= $_web["date"]?>) </small>:
    <input type="date" name="webstuff-date" value="<?= $web["date"]?>"><br>
        <input type="submit" name="edit_webstuff">
</form>