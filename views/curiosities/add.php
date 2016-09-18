<?php 

$this->title = "Dodaj nowy wpis";
?>

<style>
    small{
        font-size: 70%;
    }
</style>
<form action="{%url%}webstuff/add" method="POST">
    <b>Text:</b>
    <textarea  name="webstuff-text" ></textarea><br>
    
    <b>Urls</b> <small>(odzielone ;) </small>:
    <input type="text" name="webstuff-links" ><br>
        <input type="submit" name="add_webstuff">
</form>