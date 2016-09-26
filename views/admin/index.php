<?php

$this->title = "Panel administaracyjny";
?>

<div class="row-box">
    <div class="progress">
        <div class="progress-inside" style="width:<?= floor($size*100/2024) ?>%">
        </div>
    </div>
   Zajęte miejsce na dysku: <?= $size ?>MB /2024MB (<?= floor($size*100/2024) ?>%) 
</div>


<div class="row-box">
    Pokaż wszystkie wpisy z tagu<br>
    <a class="button" href="{%url%}curiosities/all/webstuff/">#webstuff</a>
    <a class="button" href="{%url%}curiosities/all/unknownews/">#unknownews</a>
    <a class="button" href="{%url%}curiosities/all/hackingnews/">#hackingnews</a>
</div>


<div class="row-box">
    Dodaj wpis z tagu<br>
    <a class="button" href="{%url%}curiosities/add/webstuff/">#webstuff</a>
    <a class="button" href="{%url%}curiosities/add/unknownews/">#unknownews</a>
    <a class="button" href="{%url%}curiosities/add/hackingnews/">#hackingnews</a>
</div>

<div class="row-box">
    <h3 style="margin-top: 60px;">Dodaj projekt</h3>
    <form action="{%url%}projects/add" method="POST">
        <p>Nazwa projektu</p>
        <input type="text" name="url" title="url" autocomplete="off">
        <input type="submit" value="Dodaj">
    </form>
</div>