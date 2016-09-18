<?php 

$this->title = "Usuń wpis";
?>

<?php if($removed): ?>
    
<div class="info">
   Usunięto poniższy wpis !<?= $info ?>
</div>
<?php endif;?>
<h3 style="margin-top: 60px;">Czy na pewno chcesz usunąć wpis?</h3>


<form action="{%url%}webstuff/remove/<?= $web["id"]?>" method="POST">
    <b>Text:</b><br>
        <?= $web["text"]?><br>
    
    <b>Urls</b><br>
        <?= $web["links"]?><br>
    
    <b>Data</b><br>
        <?= $web["date"]?><br>
    
        <input type="submit" name="remove_webstuff">
</form>