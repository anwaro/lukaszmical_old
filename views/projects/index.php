<?php
/* @var $this View */

$this->setTitle('Projekty');
    $row = 0;
    $content = '';
    foreach ($allProjects as $p) {
        if ($row && $row % 4 == 0) {
            $content .= '</div>'
                    . '<div class="row">';
        }
        $content .= "
                <div class='3u'>
                    <article class='box style2'>
                            <a href='{%url%}/projects/show/" . $p["url"] . "' class='image featured'>
                                <img src='{%url%}/public/images/projects/" . $p["photo"] . "' alt='" . $p["descr"] . "' />
                            </a>
                            <h3><a href='{%url%}/projects/show/" . $p["url"] . "'>" . $p["name"] . "</a></h3>
                            <p>" . $p["descr"] . " </p>
                    </article>
            </div>";
        $row++;
    }
?>

<div class="wrapper style3">
    <article id="myproject">
        <header>
            <h2>Moje projekty</h2>
            <p>Projekty i gry wykonane w ostatnim czasie</p>
        </header>                                        
        <div class="container">  
            <div class="row">
                <?= $content;?>
            </div>
        </div>
    </article>
</div>	