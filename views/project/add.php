<?php 

$this->title = "Dodaj nowy";
?>

<style>
    small{
        font-size: 70%;
    }
</style>
<div class="row-box">
    <form action="{%url%}projects/add" method="POST">
        <b>Nazwa</b> <small>(nazwa projektu)</small>:
            <input type="text" name="name" ><br>
        <b>Url</b> <small>(koncówka url)</small>:
        <input type="text" name="url" value="<?= $projUrl; ?>" ><br>
        <b>Opis</b> <small>(krótki opis)</small>:
            <input type="text" name="descr" ><br>
        <b>Zdjęcie</b> <small>(sama nazwa chyba, że jest w folderze)</small>: 
            <input type="text" name="photo" ><br>
        <b>Css</b> <small>(plik css bez rozszerzenia np. projects/name. Kolejne pliki rozdzielamy ";")</small>: 
        <input type="text" name="css" value="projects/<?= $projUrl; ?>"><br>
        <b>Js</b> <small>(plik css bez rozszerzenia np. projects/name. Kolejne pliki rozdzielamy ";")</small>: 
            <input type="text" name="js" value="projects/<?= $projUrl; ?>"><br>
        <b>Template</b> <small>(Szablon domyślnie '', 'game')</small>: 
            <input type="text" name="template"><br>
        <b>Data</b>: <input type="date" name="date"><br>
        <input type="hidden" name="display" value="0">
            <input type="submit" name="add">
    </form>
</div>
