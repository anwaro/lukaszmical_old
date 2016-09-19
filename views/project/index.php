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
            <div class="row">
              <?php $row = 0;?>
                <?php foreach ($projects as $project):?>
                <?php if($row && !($row%4)):?>
            </div>
            <div class="row">
                <?php endif;?>
                    <div class='3u'>
                       <article itemscope itemtype="http://schema.org/SoftwareApplication" class="box style2">
                            <a itemprop="url" href='{%url%}projects/show/<?= $project["url"];?>' class='image featured'>
                                <img itemprop='image' src='{%url%}web/images/projects/<?= $project["photo"];?>' alt='<?= $project["descr"];?>' />
                            </a>
                            <h3><a itemprop='url' href='{%url%}projects/show/<?= $project["url"];?>'><?= $project["name"];?></a></h3>
                            <p><?= $project["description"];?> </p>
                       </article>
                    </div>   
                <?php $row++;?>
                <?php endforeach;?>
            </div>
        </div>
    </article>
</div>	