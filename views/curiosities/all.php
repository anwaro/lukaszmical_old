<?php

$this->title = "Wszystkie wpisy";
?>

<style>
    #pr-list{
        max-width: 800px;
        text-align: left;
        margin: auto;
    }
    
    table#pr-list>tbody>tr{
        border-bottom: 1px solid black;
    }
    
    table#pr-list>tbody>tr>td{
        padding:  5px;
    }
</style>

<div class="row-box">
    <a class="button" href="{%url%}curiosities/index/webstuff/all">#webstuff</a>
    <a class="button" href="{%url%}curiosities/index/unknownews/all">#unknownews</a>
    <a class="button" href="{%url%}curiosities/index/hackingnews/all">#hackingnews</a>
</div>
<br><br>
<table id='pr-list'>
<?php foreach ($curiosities as $web): ?>
    <tr>
        <td><p><?=$web["text"]?></p></td>
        <td><?=$web["links"]?></td>
        <td><?=$web["date"]?></td>
        <td><a href = "{%url%}curiosities/edit/<?= $type ?>/<?= $web["id"]?>">Edytuj dane</a> </td>
        <td><a href = "{%url%}curiosities/remove/<?= $type ?>/<?= $web["id"]?>">Usuń</a><br></td>
    </tr>
<?php endforeach;?>
</table>