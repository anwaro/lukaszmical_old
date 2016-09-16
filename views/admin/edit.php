<?php 
$this->title = "Edytuj informacje o projekcie";
?>

<form action="../../admin/update/<?= $info["url"];?>" method="POST">
    Url: <input type="text" name="url" value="<?= $info["url"]; ?>"><br>
    Nazwa: <input type="text" name="name" value="<?= $info["name"]; ?>"><br>
    Opis: <input type="text" name="descr" value="<?= $info["descr"]; ?>"><br>
    Zdjęcie: <input type="text" name="photo" value="<?= $info["photo"]; ?>"><br>
    Css: <input type="text" name="css" value="<?= $info["css"]; ?>"><br>
    Js: <input type="text" name="js" value="<?= $info["js"]; ?>"><br>
    Show: <input type="text" name="display" value="<?= $info["display"]; ?>"><br>
    Template: <input type="text" name="template" value="<?= $info["template"]; ?>"><br>
    Data: <input type="date" name="date" value="<?= $info["date"]; ?>"><br>
    <input type="submit" name="edit">
</form>
<br><br>
 