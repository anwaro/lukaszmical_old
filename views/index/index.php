<?php
    /* @var $this base\View */
    /* @var $projects array */

    $this->title = 'Home';
?>

<div class="wrapper style1 first">
    <article class="container" id="top">
        <div class="row">
            <div class="4u">
                <span class="image fit"><img src="{%url%}web/images/stat/profil.jpg" alt="" /></span>
            </div>
            <div class="8u">
                <header>
                    <h1>
                        <span itemprop="author" itemscope itemtype="http://schema.org/Person">
                            <strong itemprop="name">Łukasz Micał</strong>
                        </span>
                    </h1>								
                </header>
                <p>Witam na mojej stronie, na której przedstawiam moje projekty</p>
                <p></p>
                <a href="#myproject" class="button big scrolly">Moje projekty</a>
            </div>
        </div>
    </article>
</div>
<div class="wrapper style3">
    <article id="myproject">
        <header>
            <h2>Moje projekty</h2>
            <p>Projekty i gry wykonane w ostatnim czasie</p>
        </header>
        <div class="container">
            <?= $this->renderContent('widget/project', [
                'projects' => $projects,
                'class' => '4u',
                'column' => 3
            ]) ?>
        </div>
        <footer>
            <a href="{%url%}projects" class="button big scrolly">Więcej</a>
        </footer>
    </article>
</div>		
<div class="wrapper style4">
    <article id="contact" class="container 75%">
        <div class="row">
            <div class="12u">
                <h3>Find me on ...</h3>
                <ul class="social">
                    <li><a href="https://twitter.com/LukaszMical" class="icon fa-twitter"><span class="label">Twitter</span></a></li>
                    <li><a href="https://www.facebook.com/lukas.anwaro" class="icon fa-facebook"><span class="label">Facebook</span></a></li>
                    <li><a href="https://plus.google.com/+ŁukaszMicał" class="icon fa-google-plus"><span class="label">Google+</span></a></li>
                    <li><a href="https://github.com/anwaro" class="icon fa-github"><span class="label">Github</span></a></li>
                </ul>
            </div>
        </div>
    </article>
</div>