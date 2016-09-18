<?php 

$this->title = "Edytuj wpis";
?>

<style>
    small{
        font-size: 70%;
    }
</style>
<div class="row-box">
    <form action="{%url%}curiosities/edit/<?= $type ?>/<?= $_web["id"]?>" method="POST">
        <b>Text:</b> <small>(<?= $_web["text"]?>)</small>:
        <textarea  name="text" ><?= $web["text"]?></textarea><br>

        <b>Urls</b> <small>(<?= $_web["links"]?>) </small>:
        <input type="text" name="links" value="<?= $web["links"]?>" ><br>
        <b>Data</b> <small>(<?= $_web["date"]?>) </small>:
        <input type="date" name="date" value="<?= $web["date"]?>"><br>
            <input type="submit" name="edit">
    </form>
</div>