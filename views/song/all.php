<?php
/**
 * Created by PhpStorm.
 * User: lukasz
 * Date: 25.09.16
 * Time: 21:39
 */

/**@var base\View $this */
/**@var array $songs */
?>

<?php foreach ($songs as $song):?>

    <div class="song-box">
        <div class="image">
            <img width="100px" src="{%url%}web/images/projects/mp3player/covers/<?=$song["cover"] ?>">
        </div>
        <div class="info">
            <div class="row-12">
                <div class="progress">
                    <div class="progress-inside" style="width:1%">
                    </div>
                </div>
            </div>
            <div class="row-12">
                <div class="play-switch icon fa-play">
                    <audio preload="metadata" src="{%url%}web/sounds/mp3/<?=$song["src"] ?>.mp3"></audio>
                </div>
                <div class="song-info">
                    <b><?= $song["artist"] ?> </b>- <?= $song["title"] ?><br>
                    <?= $song["src"] ?>
                </div>

                <div data-id="<?=$song["id"] ?>" class="song-action icon fa-close <?= ($song["remove"]?'delete':'') ?>"></div>
                <div data-id="<?=$song["id"] ?>" class="song-action icon fa-check <?= $song["new"]?'new':'' ?>"></div>
            </div>

        </div>
    </div>


<?php endforeach; ?>


<script>
    $('.fa-close:not(.delete)').click(function () {
        var el = $(this);
        $.ajax(url + 'song/delete/' + el.data('id')).success(function (data) {
            el.addClass('delete');
            console.log(data);
        })
    });
    $('.fa-check:not(.new)').click(function () {
        var el = $(this);
        $.ajax(url + 'song/copy/' + el.data('id')).success(function (data) {
            el.addClass('new');
            console.log(data);
        })

    });

    $('.progress-inside, .progress').click(function (e) {
        if ($(this).is(currentBar) || $(this).find('.progress-inside').is(currentBar)) {
            var posX = $(this).offset().left;
            currentAudio.currentTime = ((e.pageX - posX) / $('.progress').width()) * currentAudio.duration;
            currentBar.css('width', (currentAudio.currentTime * 100 / currentAudio.duration).toFixed(2) + "%")
        }
    });

    var progress;
    var currentAudio;
    var currentBar;
    function setProgress() {
        currentBar.css('width', (currentAudio.currentTime*100/currentAudio.duration).toFixed(2) + "%")
    }
    $('.play-switch').click(function () {
        clearInterval(progress);
        var $switcher = $(this);
        var playing = $('.fa-pause');
        var audio;

        playing.each(function () {
            var au = $( this ).find('audio');
            if(au.length){
                au[0].pause();
            }
        });
        
        if($switcher.hasClass('fa-play')){
            playing.removeClass('fa-pause')
                .addClass('fa-play');

            currentAudio = $switcher.find('audio')[0];
            currentBar = $switcher.parent().parent().find('.progress-inside');

            $switcher.removeClass('fa-play')
                .addClass('fa-pause');

            currentAudio.play();
            progress = setInterval(setProgress, 100)
        }
        else{
            playing
                .removeClass('fa-pause')
                .addClass('fa-play');

        }
    })
</script>