<?php
    /* @var base\View $this  */
    /* @var string $type  */
    /* @var array $curiosities*/

    $this->title = ucfirst($type);
    
    $info = [
        'webstuff' => [
            'user' => '@klocus',
            'userUrl' => 'http://www.wykop.pl/ludzie/klocus/',
            'tag' => '#webstuff',
            'tagUrl' => 'http://www.wykop.pl/tag/webstuff/',
            'about' => ' webdewem',
            
        ],
        'unknownews' => [
            'user' => '@imlmpe',
            'userUrl' => 'http://www.wykop.pl/ludzie/imlmpe/',
            'tag' => '#unknownews',
            'tagUrl' => 'http://www.wykop.pl/tag/unknownews/',
            'about' => 'it',
            
        ],
        'hackingnews' => [
            'user' => '@airdong',
            'userUrl' => 'http://www.wykop.pl/ludzie/airdong/',
            'tag' => '#hackingnews',
            'tagUrl' => 'http://www.wykop.pl/tag/hackingnews/',
            'about' => 'programowaniem, security i szeroko pojętym hackingiem',
            
        ],
    ];
    
    $info = $info[$type];

?>

<div class="row-box">
    <a class="button" href="{%url%}curiosities/index/webstuff">#webstuff</a>
    <a class="button" href="{%url%}curiosities/index/unknownews">#unknownews</a>
    <a class="button" href="{%url%}curiosities/index/hackingnews">#hackingnews</a>
</div>

<div class="news-search">
    Zbiór linków użytkownika 
    <a href="<?= $info['userUrl']?>"><?= $info['user']?></a> 
    na temat związane z <?= $info['about']?>. 
    Wszystkie wpisy dostępne są pod linkiem 
    <a href="<?= $info['tagUrl']?>"><?= $info['tag']?></a>
    <br>
    <br>
    <input title="search" name="search" type="search" id="news-search" autocomplete="off">
</div>

<?php foreach ($curiosities as $web):?>
    <?php $links = explode(";", $web["links"]);
      $anchor = array_map(
            function($val) {  return "<a class='link button' target='_blank' href='$val'>LINK</a>"; },
            $links
        );  
    ?>
    <div class="news" title="<?= $web['date'] ?>">
            <div class="info">
                <?= $web["text"]?>
                <?php if(strlen($web['entry'])): ?>
                    <a href="<?= $web['entry'] ?>" target='_blank' title="Wpis"><i class="icon fa-share"></i></a>
                <?php endif; ?>
            </div>
            <?= implode($anchor) ?>
    </div>

<?php endforeach;?>

<div id="page-switcher" class="row-box">

</div>
<br><br>

<script>
    var news = document.getElementsByClassName("news");
    var search = document.getElementById("news-search");
    var pageSwitcher = document.getElementById("page-switcher");
    search.addEventListener('keyup', filter);
    
    var newsData = [];
    var element;
    var pageNUmber = 1;
    var newsInPage=10;
    var elementsToShow = [];

    for(var i =0; i< news.length; i++){
        element = {
            element : news[i],
            info : news[i].children[0],
            info_text : news[i].children[0].innerHTML
        };
        newsData.push(element);
    }


    filter({target:{value:''}});
    function filter(event){
        clear();
        var search_text = event.target.value.toLowerCase();
        if(search_text.length === 1)search_text = '';
        for(var i =0; i<newsData.length; i++){
            if(newsData[i].info_text.toLowerCase().indexOf(search_text) !== -1){
                elementsToShow.push(newsData[i].element);
//                newsData[i].element.style.display = 'block';
                if(search_text.length){
                    newsData[i].info.innerHTML = newsData[i]
                            .info_text
                            .replace(
                                (new RegExp(search_text , "gi")),
                                function addBack(text){
                                    return "<span class='find'>"+text+"</span>";
                                }
                            );
                }
            }
        }
        switchPage(pageNUmber);
    }

    function switchPage(pageNr) {
        hideAll();
        pageNUmber = pageNr;
        var start = (pageNUmber - 1) * newsInPage;
        var stop = Math.min(pageNUmber * newsInPage, elementsToShow.length);
        for(var i =start; i<stop; i++){
            elementsToShow[i].style.display = 'block';
        }
        addSwitcher();
    }

    function hideAll() {
        for(var i =0; i<newsData.length; i++) {
            newsData[i].element.style.display = 'none';
        }

    }

    function clear(){
        elementsToShow = [];
        pageNUmber = 1;
        for(var i =0; i<newsData.length; i++){
            if(newsData[i].info.innerHTML.indexOf("class=") !== -1){                
                newsData[i].info.innerHTML = newsData[i].info_text;
            }
        }
    }

    function addSwitcher() {
        var count = Math.ceil(elementsToShow.length/newsInPage);
        var html = '';
        var active = '';
        for(var i = 1; i<=count;i++){
            if(i==pageNUmber){
                html += '<div class="button switcher switcher-active"  onclick="switchPage('+ i +')">'+ i +'</div>';

            }else{
                html += '<div class="button switcher"  onclick="switchPage('+ i +')">'+ i +'</div>';
            }
        }
        pageSwitcher.innerHTML = html;
    }
</script>