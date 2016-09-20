<?php
/* @var base\View $this  */
/* @var int $removed  */
/* @var array $project */


$this->title = "Usuń wpis";
?>

<?php if($removed): ?>

    <div class="row-box">
        <h2>Usunięto poniższy wpis !</h2>
    </div>
<?php endif;?>
    <div class="row-box">
        <?php if(!$removed): ?>
        <h3 style="margin-top: 60px;">Czy na pewno chcesz usunąć wpis?</h3>
        <form action="{%url%}projects/delete/<?= $project["id"]?>" method="POST">
            <?php endif;?>

            <div class='4u' style="margin: auto;">
                <article  class="box style2">
                    <a  href='{%url%}projects/show/<?= $project["url"];?>' class='image featured'>
                        <img src='{%url%}web/images/projects/<?= $project["photo"];?>' alt='<?= $project["description"];?>' />
                    </a>
                    <h3><a href='{%url%}projects/show/<?= $project["url"];?>'><?= $project["name"];?></a></h3>
                    <p><?= $project["description"];?> </p>
                </article>
            </div>

            <?php if(!$removed): ?>
            <br>
            <input type="submit" name="remove" value="Usuń">
        </form>
    <?php endif;?>
    </div>


    <div class="row-box">
        <a class="button" href="{%url%}projects/all/">Wszystkie</a>
    </div>