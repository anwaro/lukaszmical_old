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
        <meta http-equiv="content-type" content="text/html; charset=utf-8" />
        <meta name="description" content="" />
        <meta name="keywords" content="" />
        <link href="{%url%}/favicon.ico" rel="shortcut icon" type="image/x-icon">
        <!-- Dodatkowe tagi -->

        <meta property="og:title" content="{%title%}" />
        <meta property="og:image" content="{%url%}/{%image%}" />
        <meta property="og:url" content="{%fullurl%}" />
        <meta property="og:description" content="{%descr%}" />
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
        <script>
            var url ="{%url%}";
        </script>
        <!--[if lte IE 8]><script src="{%url%}/public/css/ie/html5shiv.js"></script><![endif]-->
        <script src="{%url%}public/js/jquery/jquery.min.js"></script>
        <script src="{%url%}public/js/jquery/jquery.scrolly.min.js"></script>
        <script src="{%url%}public/js/jquery/skel.min.js"></script>
        <script src="{%url%}public/js/jquery/init.js"></script>
        <script src="{%url%}public/js/myQuery.js"></script>
        {%js%}
        <link rel="stylesheet" href="{%url%}public/css/style.css" >
        <noscript>
        <link rel="stylesheet" href="{%url%}public/css/skel.css" >
        <link rel="stylesheet" href="{%url%}public/css/style-desktop.css" >
        </noscript>
        <!--[if lte IE 8]><link rel="stylesheet" href="{%url%}/public/css/ie/v8.css" /><![endif]-->
        <!--[if lte IE 9]><link rel="stylesheet" href="{%url%}/public/css/ie/v9.css" /><![endif]-->
        {%css%}
    </head>
    <body>
        <nav id="nav">
            <ul class="container">
                <li><a href="{%url%}">Home</a></li>
                <li><a href="{%url%}projects">Projekty</a></li>
                <li><a href="{%url%}webstuff">Webstuff</a></li>
                <li><a href="#contact" class="scrolly">Kontakt</a></li>        
            <?php if(Session::get("login")): ?>
                <li><a href="{%url%}admin">Admin </a></li>
                <li><a href="{%url%}admin/all">Wszystkie </a></li> 
                <li><a href="{%url%}admin/logout">Wyloguj </a></li>                
            <?php endif; ?>
            </ul>
        </nav>
        <div id="content-block" style="opacity: 0">
            <?= $content; ?>
        </div>
    </body>
</html>