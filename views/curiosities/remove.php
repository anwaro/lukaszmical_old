<?php 

$this->title = "Usuń wpis";
?>

<?php if($removed): ?>
    
<div class="row-box">
   Usunięto poniższy wpis !<?= $info ?>
</div>
<?php endif;?>
<div class="row-box">
    <h3 style="margin-top: 60px;">Czy na pewno chcesz usunąć wpis?</h3>
    <form action="{%url%}webstuff/remove/<?= $type ?>/<?= $web["id"]?>" method="POST">
        <b>Text:</b><br>
            <?= $web["text"]?><br>

        <b>Urls</b><br>
            <?= $web["links"]?><br>

        <b>Data</b><br>
            <?= $web["date"]?><br>

            <input type="submit" name="remove">
    </form>
</div>