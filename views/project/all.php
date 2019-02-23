<?php
/* @var $this base\View */
/* @var $projects array */

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
    <?php foreach ($projects as $project):?>
    <?php $show = $project["display"] ? "":"(ukryty)"; ?>
        <tr>
            <td><img src="/images/projects/<?= $project["photo"] ?>" height="50"></td>
            <td><a href = "/projects/show/<?= $project["url"] ?>"><?= $project["name"] ?></a> <?= $show ?></td>
            <td><a href = "/projects/edit/<?= $project["id"] ?>">Edytuj dane</a> </td>
            <td><a href = "/projects/delete/<?= $project["id"] ?>">Usuń (wyłączone)</a></td>
        </tr>            
    <?php endforeach;?>
    </table>
</div>