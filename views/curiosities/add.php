<?php 

$this->title = "Dodaj nowy wpis";
?>

<style>
    small{
        font-size: 70%;
    }
</style>
<div class="row-box">
    <form action="{%url%}curiosities/add/<?= $type ?>" method="POST">
        <b>Text:</b>
        <textarea  name="text" ></textarea><br>

        <b>Urls</b> <small>(odzielone ;) </small>:
        <input type="text" name="links" ><br>
            <input type="submit" name="add_webstuff">
    </form>
</div>