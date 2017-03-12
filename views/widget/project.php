<?php
/* @var $this base\View */
/* @var $projects array */
/* @var $class string */
/* @var $column integer */

/**
 * @param $id
 * @return string
 */


function rateStar($id){
    $html = '';
    for ($i = 5; $i > 0; $i--){
        $html .= "<span id='rate-$id-$i' data-project='$id' data-rate='$i'>☆</span>";
    }
    return $html;
}

?>


<div class="row">
<?php $row = 0;?>
<?php foreach ($projects as $project):?>
    <?php if($row && !($row%$column)):?>
</div>
<div class="row">
    <?php endif;?>
    <div class='<?= $class ?>'>
        <article itemscope itemtype="http://schema.org/SoftwareApplication" class="box style2">
            <a itemprop="url" href='{%url%}projects/show/<?= $project["url"];?>' class='image featured'>
                <img itemprop='image' src='{%url%}web/images/projects/<?= $project["photo"] ?>' alt='<?= $project["description"];?>' />

                <?php if($project["rate"]): ?>
                    <div class="avg-rate-box">
                        <span class="avg-star">★</span>
                        <span class="avg-rate"><?= number_format($project["rate"], 1, '.', '') ?></span>
                    </div>
                <?php endif; ?>
            </a>
            <div id="rate-project-<?= $project["id"] ?>" class="rating">
                <?= rateStar($project["id"]) ?>
            </div>
            <h3><a itemprop='url' href='{%url%}projects/show/<?= $project["url"];?>'><?= $project["name"];?></a></h3>
            <p><?= $project["description"];?> </p>
        </article>
    </div>
    <?php $row++;?>
<?php endforeach;?>
