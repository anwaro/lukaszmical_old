<?php
/** @var base\View $this */
/** @var array $info */
$this->title = "Edytuj informacje o projekcie";
?>
<div class="row-box">
    <form action="{%url%}projects/edit/<?= $info["id"];?>" method="POST">
        <div class="row">
            <div class="8u">
                Url: <input title="url" type="text" name="url" value="<?= $info["url"]; ?>">
                Nazwa: <input title="Name" type="text" name="name" value="<?= $info["name"]; ?>">
                Opis: <input title="Description" type="text" name="description" value="<?= $info["description"]; ?>">
                Zdjęcie: <input  title="Cover" type="text" name="photo" value="<?= $info["photo"]; ?>">
            </div>
            <div class="4u">
                <article class="box style2">
                    <a href="{%url%}projects/show/<?= $info["url"] ?>" class='image featured'>
                        <img src='{%url%}web/images/projects/<?= $info["photo"];?>' alt='<?= $info["description"];?>' />
                    </a>
                    <h3><a href='{%url%}projects/show/<?= $info["url"] ?>'><?= $info["name"];?></a></h3>
                    <p><?= $info["description"];?> </p>
                </article>
            </div>
        </div>
        <div class="row">
            <div class="12u">
                Css: <input  title="Css file" type="text" name="css" value="<?= $info["css"]; ?>">
                Js: <textarea  title="Js file" type="text" name="js" ><?= $info["js"]; ?></textarea>
            </div>
        </div>
        <div class="row">
            <div class="4u">
                Ocena: <input  title="Mark" type="text" name="mark" value="<?= $info["mark"]; ?>">
            </div>
            <div class="4u">
                Show: <input  title="Showed" type="text" name="display" value="<?= $info["display"]; ?>">
            </div>
            <div class="4u">
                Template: <input  title="Template" type="text" name="template" value="<?= $info["template"]; ?>">
            </div>
        </div>
        <div class="row">
            <div class="6u">
                Data: <input  title="Date" type="date" name="date" value="<?= $info["date"]; ?>">
            </div>
            <div class="6u">
                <br>
                <input type="submit" name="edit">
            </div>
        </div>
    </form>
</div>
<br><br>
 