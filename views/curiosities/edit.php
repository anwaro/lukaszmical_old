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
<?php $links = explode(";", $web["links"]);
$anchor = array_map(
    function($val) {return "<a class='link button' target='_blank' href='$val'>LINK</a>"; },
    $links
);
?>
<div class="news" title="<?= $web['date'] ?>">
    <div class="info">
        <?= $web["text"]?>
        <?php if(strlen($web['entry'])): ?>
            <a href="<?= $web['entry'] ?>" target='_blank' title="Wpis"><i class="icon fa-share"></i></a>
        <?php endif; ?>
    </div>
    <?= implode($anchor) ?>
</div>
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