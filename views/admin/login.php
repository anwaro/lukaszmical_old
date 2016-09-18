<?php

$this->title = "Logowanie do panelu";

?>
<div class="info row-box">
   <?= $info ?>
</div>
<div class="row-box">
    <form method="POST">
        <input name="password" type="password">
        <input name="login" type="submit">
    </form>    
</div>