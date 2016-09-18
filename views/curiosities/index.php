<?php
    /* @var $this View */
    /* @var $type string */

    $this->title = ucfirst($type);
    
    $infos = [
        'webstuff' => [
            'user' => '@klocus',
            'userUrl' => 'http://www.wykop.pl/ludzie/klocus/',
            'tag' => '#webstuff',
            'tagUrl' => 'http://www.wykop.pl/tag/webstuff/',
            'about' => ' webdewem',
            
        ],
        'unknownews' => [
            'user' => '@klocus',
            'userUrl' => 'http://www.wykop.pl/ludzie/klocus/',
            'tag' => '#unknownews',
            'tagUrl' => 'http://www.wykop.pl/tag/webstuff/',
            'about' => ' webdewem',
            
        ],
        'hackingnews' => [
            'user' => '@klocus',
            'userUrl' => 'http://www.wykop.pl/ludzie/klocus/',
            'tag' => '#hackingnews',
            'tagUrl' => 'http://www.wykop.pl/tag/webstuff/',
            'about' => ' webdewem',
            
        ],
    ];
    
    $info = $infos[$type];

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
    <input name="search" type="search" id="news-search"autocomplete="off">
</div>

<?php foreach ($curiosities as $web):?>
    <?php $links = explode(";", $web["links"]);
      $anchor = array_map(
            function($val) {  return '<a class="link button" target="_blank" href="'.$val .'">LINK</a>'; },
            $links
        );  
    ?>
    <div class="news">
            <div class="info">
            <?= $web["text"]?>
            </div>
            <?= implode($anchor) ?>
    </div>

<?php endforeach;?>


<script>
    var news = document.getElementsByClassName("news");
    var search = document.getElementById("news-search");
    search.addEventListener('keyup', filter);
    
    
    newsdata = [];
    var element;
    for(var i =0; i< news.length; i++){
        element = {
            element : news[i],
            info : news[i].children[0],
            info_text : news[i].children[0].innerHTML
        };
        newsdata.push(element);
    }
    
    function filter(event){
        cleear();
        var search_text = event.target.value.toLowerCase();
        if(search_text.length === 1)search_text = '';
        for(var i =0; i<newsdata.length; i++){
            if(newsdata[i].info_text.toLowerCase().indexOf(search_text) !== -1){
                newsdata[i].element.style.display = 'block';
                if(search_text.length){
                    newsdata[i].info.innerHTML = newsdata[i]
                            .info_text
                            .replace(
                                (new RegExp(search_text , "gi")),
                                function addBack(text){
                                    return "<span class='find'>"+text+"</span>";
                                }
                            );
                }
            }
            else{
                newsdata[i].element.style.display = 'none';
            }
        }
    }
    
    function cleear(){
        for(var i =0; i<newsdata.length; i++){
            if(newsdata[i].info.innerHTML.indexOf("class=") !== -1){                
                newsdata[i].info.innerHTML = newsdata[i].info_text;
            }
        }
    }
</script>