<?php
/* @var base\View $this */
/* @var string $info */

$this->title = "Logowanie do panelu";

?>
<div class="info row-box">
   <?= $info ?>
</div>
<div class="row-box">
    <form method="POST">
        <input name="password" type="password" title="Password" autofocus>
        <input name="login" type="submit">
    </form>    
</div>