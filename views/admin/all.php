<?php

$this->title = "Wszystkie projekty";
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
    <table id='pr-list'>
    <?php foreach ($list as $proj):?>
    <?php $show = $proj["display"] ? "":"(ukryty)"; ?>
        <tr>
            <td><img src="{%url%}web/images/projects/<?= $proj["photo"] ?>" height="50"></td>
            <td><a href = "{%url%}projects/show/<?= $proj["url"] ?>"><?= $proj["name"] ?></a> <?= $show ?></td>
            <td><a href = "{%url%}admin/edit/<?= $proj["id"] ?>">Edytuj dane</a> </td>
            <td><a href = "{%url%}admin/delete/<?= $proj["id"] ?>">Usuń (wyłączone)</a></td>
        </tr>            
    <?php endforeach;?>
    </table>
</div>