<?php
/* @var base\View $this  */
/* @var string $type  */
/* @var int $removed  */
/* @var array $web */


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
    <form action="{%url%}curiosities/delete/<?= $type ?>/<?= $web["id"]?>" method="POST">
    <?php endif;?>
        <b>Text:</b><br>
            <?= $web["text"]?><br>

        <b>Urls</b><br>
            <?= $web["links"]?><br>

        <b>Data</b><br>
            <?= $web["date"]?><br>

    <?php if(!$removed): ?>
            <input type="submit" name="remove" value="Usuń">
    </form>
    <?php endif;?>
</div>

<?php if($removed): ?>

    <div class="row-box">
        <a class="button" href="{%url%}curiosities/all/<?= $type ?>">Wszystkie</a>
    </div>
<?php endif;?>