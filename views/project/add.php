<?php
/* @var $this base\View */
/* @var $projectUrl string */

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
            <input title="name" type="text" name="name" ><br>
        <b>Url</b> <small>(koncówka url)</small>:
        <input type="text" name="url" title="url" value="<?= $projectUrl ?>" ><br>
        <b>Opis</b> <small>(krótki opis)</small>:
            <input type="text" title="description" name="description" ><br>
        <b>Zdjęcie</b> <small>(sama nazwa chyba, że jest w folderze)</small>: 
            <input type="text" title="cover" name="photo" value="default.jpg"><br>
        <b>Css</b> <small>(plik css bez rozszerzenia np. projects/name. Kolejne pliki rozdzielamy ";")</small>: 
        <input type="text" name="css" title="Css file" value="projects/<?= $projectUrl; ?>"><br>
        <b>Js</b> <small>(plik css bez rozszerzenia np. projects/name. Kolejne pliki rozdzielamy ";")</small>: 
            <input type="text" name="js" title="Js file" value="projects/<?= $projectUrl; ?>"><br>
        <b>Template</b> <small>(Szablon domyślnie '', 'game')</small>: 
            <input type="text" title="Template name" name="template"><br>
        <b>Data</b>: <input type="date" title="date" name="date"><br>
        <input type="hidden" name="display" value="0">
            <input type="submit" name="add">
    </form>
</div>
