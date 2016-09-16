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

<?php
echo "<table id='pr-list'>";
foreach ($webstuffs as $web){
    echo 
    '<tr>'
        . '<td><p>'.$web["text"].'</p></td>'
        . '<td>'.$web["links"].'</td>'
        . '<td>'.$web["date"].'</td>'
        . '<td><a href = "{%url%}webstuff/edit/'.$web["id"].'">Edytuj dane</a> </td>'
        . '<td><a href = "{%url%}webstuff/remove/'.$web["id"].'">Usuń</a><br></td>'
    . '</tr>';
}
echo "</table>";