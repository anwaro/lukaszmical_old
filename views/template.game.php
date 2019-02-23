<?php
/** @var string $content */

?>
<!DOCTYPE HTML>
<html>
    <!--
    /*
     *  _            _                                                                        _                _
     * | |          | |                                               _                      | |              | |
     * | |          | |                                              |_|                     | |              | |
     * | |  _    _  | |   _   ______     ______   _____   ________    _    _____   ______    | |      _____   | |
     * | | | |  | | | |  / / |  __  |   /  ____| |___  | |  _   _ \  | |  / ____| |  __  |   | |     |  __ \  | |
     * | | | |  | | | | / /  | |  | |   |  \__      / /  | | | | | | | | | |      | |  | |   | |     | |  \ | | |
     * | | | |  | | | |/ /   | |  | |    \__  \    / /   | | | | | | | | | |      | |  | |   | |     | |  | | | |
     * | | | |__| | | |\ \   | |__| |_   ___\  |  / /__  | | | | | | | | | |____  | |__| |_  | |  _  | |__/ | | |
     * |_| |______| |_| \_\  |________| |______/ |_____| |_| |_| |_| |_|  \_____| |________| |_| |_| |  ___/  |_| 
     *                                                                                               | |
     *                                                                                               | |
     *                                                                                               |_|
     *               
     */
    -->
    <head>
        <title>{%title%}</title>
        <meta name="viewport" content="width=device-width, initial-scale=1">

        <meta http-equiv="content-type" content="text/html; charset=utf-8" />
        <meta name="description" content="{%description%}" />
        <meta name="keywords" content="" />
        <link href="/favicon.ico" rel="shortcut icon" type="image/x-icon">
        <!-- Dodatkowe tagi -->

        <meta property="og:title" content="{%title%}" />
        <meta property="og:image" content="{%url%}/{%image%}" />
        <meta property="og:url" content="{%fullurl%}" />
        <meta property="og:description" content="{%description%}" />
        <meta property="og:type" content="article" />	

        <script>
            (function (i, s, o, g, r, a, m) {
                i['GoogleAnalyticsObject'] = r;
                i[r] = i[r] || function () {
                    (i[r].q = i[r].q || []).push(arguments);
                }, i[r].l = 1 * new Date();
                a = s.createElement(o),
                        m = s.getElementsByTagName(o)[0];
                a.async = 1;
                a.src = g;
                m.parentNode.insertBefore(a, m);
            })(window, document, 'script', '//www.google-analytics.com/analytics.js', 'ga');

            ga('create', 'UA-57170208-1', 'auto');
            ga('require', 'displayfeatures');
            ga('send', 'pageview');
        </script>
        <style>  
            body{
                background-image: url('/images/bg.png');
                text-align: center;
                margin:0;
                overflow:hidden;
            }
        </style>
        {%css%}
    </head>
    <body>
        <?= $content; ?>		
    </body>
    <script src="/js/myQuery.js"></script>
    {%js%}
</html>