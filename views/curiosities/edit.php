<?php
/* @var base\View $this  */
/* @var string $type  */
/* @var array $web */
/* @var array $_web */


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
        <textarea title="text" name="text" ><?= $web["text"]?></textarea><br>

        <b>Urls</b> <small>(<?= $_web["links"]?>) </small>:
        <input title="links" type="text" name="links" value="<?= $web["links"]?>" ><br>
        <b>Data</b> <small>(<?= $_web["date"]?>) </small>:
        <input title="date" type="date" name="date" value="<?= $web["date"]?>"><br>
            <input type="submit" name="edit">
    </form>
</div>