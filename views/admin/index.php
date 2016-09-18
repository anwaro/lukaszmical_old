<?php

$this->title = "Panel administaracyjny";
?>
<style>
    .progress{
        display: block;
        width: 100%;
        margin: auto;
        border: 1px solid #282828;
        border-radius: 10px;
        height: 20px;
        margin-top: 10px;
        background: #b3b3b3;
    }
    .progress-inside{
        display: block;
        float: left;
        border-radius: 10px;
        height: 18px;
        background: #f36868;
    }
</style>

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
    <form action="{%url%}/admin/add" method="POST">
        <p>Nazwa projektu</p>
        <input type="text" name="url" >
        <input type="submit" value="Dodaj">
    </form>
</div>