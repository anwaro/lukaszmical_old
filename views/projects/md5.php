<?php
$hash = '';
if (isset($_POST['password'])) {
    $hash = md5($_POST['password']);
}


?>
<div class="content">
    <form method="post">
        <label id="pass" for="password">Podaj hasło</label>
        <div class="pass-input">
            <input type="password" id="password" name="password" required autocomplete="off">
            <div class="show-pass">👁</div>
        </div>
        <button>Generuj</button>
    </form>
    <div class="hash">
        <label for="hash">Hash: </label>
        <input id="hash" value="<?= $hash ?>" readonly onclick="this.select()">
    </div>
</div>
<script>
    var showPass = $$('.show-pass');
    var input = $$('#password');
    var box = showPass.parent();


    showPass.addEventListener('click', function () {
        if (box.hasClass('text-mode')) {
            input.type = 'password';
            box.removeClass('text-mode');
        } else {
            input.type = 'text';
            box.addClass('text-mode');
        }
    });
</script>