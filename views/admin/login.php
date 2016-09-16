<?php

$this->title = "Logowanie do panelu";

?>
<div class="info">
   <?= $info ?>
</div>

<form action ="/admin" method="POST">
    <input name="password" type="password">
    <input name="login" type="submit">
</form>