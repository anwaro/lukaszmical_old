<?php
/**@var $this base\View */
/**@var $size int */
/**@var $info array */



$this->title = "Panel administaracyjny";
?>

<div class="row-box">
    <div class="progress">
        <div class="progress-inside" style="width:<?= floor($size*100/2024) ?>%">
        </div>
    </div>
   Zajęte miejsce na dysku: <?= $size ?>MB /2048MB (<?= floor($size*100/2048) ?>%)
</div>


<div class="row-box">
    <div class="row">
        <div class="6u">
            Pokaż wszystkie wpisy z tagu<br>
            <a class="button switcher" href="{%url%}curiosities/all/webstuff/">#web</a>
            <a class="button switcher" href="{%url%}curiosities/all/unknownews/">#unknow</a>
            <a class="button switcher" href="{%url%}curiosities/all/hackingnews/">#hacking</a>

        </div>
        <div class="6u">
            Dodaj wpis z tagu<br>
            <a class="button switcher" href="{%url%}curiosities/add/webstuff/">#web</a>
            <a class="button switcher" href="{%url%}curiosities/add/unknownews/">#unknow</a>
            <a class="button switcher" href="{%url%}curiosities/add/hackingnews/">#hacking</a>

        </div>
    </div>
</div>


<div class="row-box">
    <h3>Dodaj projekt</h3>
    <form action="{%url%}projects/add" method="POST">
        <input type="text" name="url" title="url" autocomplete="off">
        <input type="submit" value="Dodaj">
    </form>
</div>
<div class="row-box">
    <div id="Browser" data-box="Browser-box">Browser</div>
    <div id="Browser-box">
        <table width="100%">
            <?php foreach (get_browser($_SERVER['HTTP_USER_AGENT'], true) as $key => $value): ?>
                <tr>
                    <td><?= $key ?></td>
                    <td><?= $value ?></td>
                </tr>
            <?php endforeach;?>
        </table>
    </div>
</div>


<?php foreach ($info as $name => $data): ?>
    <div class="row-box">
        <div id="<?= $name ?>" data-box="<?= $name ?>-box"><?= $name ?></div>
        <div id="<?= $name ?>-box">
            <table width="100%">
            <?php foreach ($data as $key => $value): ?>
                <tr>
                    <td><?= $key ?></td>
                    <td><?= $value ?></td>
                </tr>
            <?php endforeach;?>
            </table>
        </div>
    </div>
<?php endforeach;?>

