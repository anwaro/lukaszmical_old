<?php
/** @var base\View $this */
/** @var array $info */
$this->title = "Edytuj informacje o projekcie";
?>
<div class="row-box">
    <form action="{%url%}projects/edit/<?= $info["id"];?>" method="POST">
        Url: <input title="url" type="text" name="url" value="<?= $info["url"]; ?>"><br>
        Nazwa: <input title="Name" type="text" name="name" value="<?= $info["name"]; ?>"><br>
        Opis: <input title="Description" type="text" name="description" value="<?= $info["description"]; ?>"><br>
        Zdjęcie: <input  title="Cover" type="text" name="photo" value="<?= $info["photo"]; ?>"><br>
        Css: <input  title="Css file" type="text" name="css" value="<?= $info["css"]; ?>"><br>
        Js: <textarea  title="Js file" type="text" name="js" ><?= $info["js"]; ?></textarea><br>
        Ocena: <input  title="Mark" type="text" name="mark" value="<?= $info["mark"]; ?>"><br>
        Show: <input  title="Showed" type="text" name="display" value="<?= $info["display"]; ?>"><br>
        Template: <input  title="Template" type="text" name="template" value="<?= $info["template"]; ?>"><br>
        Data: <input  title="Date" type="date" name="date" value="<?= $info["date"]; ?>"><br>
        <input type="submit" name="edit">
    </form>
</div>
<br><br>
 