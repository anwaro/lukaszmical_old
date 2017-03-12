<?php
/* @var $this base\View */
/* @var $projects array */ 

$this->setTitle('Projekty');

?>

<div class="wrapper style3">
    <article id="myproject">
        <header>
            <h2>Moje projekty</h2>
            <p>Projekty i gry wykonane w ostatnim czasie</p>
        </header>                                        
        <div class="container">

            <?= $this->renderContent('widget/project', [
                'projects' => $projects,
                'class' => '3u',
                'column' => 4
            ]) ?>
        </div>
    </article>
</div>	