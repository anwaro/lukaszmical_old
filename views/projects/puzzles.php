<div id="puzzles">
    <span id="reset" class="icon fa-reply" onclick=" reset();"></span>
    <img id="imageView" height="200" src>
    <article id="select">
        <div class="container">
            <div class="row rel">
                <div class="4u">
                    <section class="box style1">
                        <span class="icon featured fa-file-image-o" onclick="$$('.URL').hide();
                                $$('#image').click();"></span>
                        <h3>Obraz z koputera</h3>
                    </section>
                </div>
                <div class="4u">
                    <section class="box style1">
                        <span class="icon featured fa-globe" onclick="$$('.URL').fadeIn();"></span>
                        <h3>Podaj URL obrazka</h3>
                    </section>
                </div>
                <div class="4u">
                    <section class="box style1">
                        <span class="icon featured fa-th-large" onclick="$$('.URL').hide();
                                $$('#select').fadeOut(300, function () {
                                    $$('#sample').fadeIn(300)
                                })"></span>
                        <h3>Wybierz z dostępnych</h3>
                    </section>
                </div>

                <div class="URL box">
                    URL obrazka <input type="text" name="photoURL" id="photoURL"
                                       value="/images/projects/puzzle/sample.jpg">
                    <span id="confirmURL" class="icon fa-arrow-right" onclick="imageExists();"></span>
                </div>


                <input type="file" accept="image/*" id="image" onchange=" $puzzles.newGame('KOM');">
            </div>
        </div>
    </article>


    <div class="MSG box" onclick="$$(this).fadeOut();">

    </div>

    <div id="sample" class="container">
        <div class="row">
            <div class="sampleImg">
                <a class="image featured" onclick=" $puzzles.newGame('SAM', 1);"><img
                        src="/images/projects/puzzle/image1.jpg" alt=""/></a>
            </div>
            <div class="sampleImg">
                <a class="image featured" onclick="$puzzles.newGame('SAM', 2);"><img
                        src="/images/projects/puzzle/image2.jpg" alt=""/></a>
            </div>
            <div class="sampleImg">
                <a class="image featured" onclick="$puzzles.newGame('SAM', 3);"><img
                        src="/images/projects/puzzle/image3.jpg" alt=""/></a>
            </div>
            <div class="sampleImg">
                <a class="image featured" onclick="$puzzles.newGame('SAM', 4);"><img
                        src="/images/projects/puzzle/image4.jpg" alt=""/></a>
            </div>
            <div class="sampleImg">
                <a class="image featured" onclick="$puzzles.newGame('SAM', 5);"><img
                        src="/images/projects/puzzle/image5.jpg" alt=""/></a>
            </div>
        </div>
    </div>
    <div id="puzzleArea">
        <div id="puzzleAreaLay">

        </div>
    </div>
</div>


