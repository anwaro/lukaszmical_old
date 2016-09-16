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

<?php
echo "<table id='pr-list'>";
foreach ($list as $pr){
    $show = $pr["display"] ? "":"(ukryty)";
    echo '<tr><td><img src="'.URL.'/public/images/projects/'.$pr["photo"].'" height="50"></td>';
    echo '<td><a href = "'.URL.'/projects/show/'.$pr["url"].'">'.$pr["name"].'</a> '.$show.'</td>';
    echo '<td><a href = "'.URL.'/admin/edit/'.$pr["url"].'">Edytuj dane</a> </td>';
    echo '<td><a href = "'.URL.'/admin/delete/'.$pr["url"].'">Usuń (wyłączone)</a><br></td></tr>';
}
echo "</table>";