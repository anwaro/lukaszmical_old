<?php  
	// Inicjalizujemy sesje
	session_start();
	
	require "lib/basic.php";
	
?>
<!DOCTYPE HTML>
<html>
	<head>
		<?php 			
			if($_404){	
				echo '<meta http-equiv="Refresh" Content="0; URL=http://lukaszmical.pl/404/">';
			}
		?>
		<title>Witam na mojej stronie</title>
		<meta http-equiv="content-type" content="text/html; charset=utf-8" />
		<meta name="description" content="" />
		<meta name="keywords" content="" />
		<link href="/favicon.ico" rel="shortcut icon" type="image/x-icon">


		<script>
			(function(i,s,o,g,r,a,m){i['GoogleAnalyticsObject']=r;i[r]=i[r]||function(){
			(i[r].q=i[r].q||[]).push(arguments)},i[r].l=1*new Date();a=s.createElement(o),
			m=s.getElementsByTagName(o)[0];a.async=1;a.src=g;m.parentNode.insertBefore(a,m)
			})(window,document,'script','//www.google-analytics.com/analytics.js','ga');

			ga('create', 'UA-57170208-1', 'auto');
			ga('require', 'displayfeatures');
			ga('send', 'pageview');
		</script>
		<!--[if lte IE 8]><script src="/css/ie/html5shiv.js"></script><![endif]-->
		<script src="/js/jquery/jquery.min.js"></script>
		<script src="/js/jquery/jquery.scrolly.min.js"></script>
		<script src="/js/jquery/skel.min.js"></script>
		<script src="/js/jquery/init.js"></script>
		<!--<script src="https://raw.githubusercontent.com/anwaro/myQuery/master/src/myQuery.js"></script>-->
		<script src="/js/myQuery.js"></script>
		<noscript>
			<link rel="stylesheet" href="/css/skel.css" />
			<link rel="stylesheet" href="/css/style.css" />
			<link rel="stylesheet" href="/css/style-desktop.css" />
		</noscript>
		<!--[if lte IE 8]><link rel="stylesheet" href="/css/ie/v8.css" /><![endif]-->
		<!--[if lte IE 9]><link rel="stylesheet" href="/css/ie/v9.css" /><![endif]-->
		<?php 	includeFile(); 	?>
	</head>
	<body>
			<nav id="nav">
				<ul class="container">
					<li><a href="/">Home</a></li>
					<li><a href="/lab">Laboratorium</a></li>
					<li><a href="/#contact">Kontakt</a></li>
				</ul>
			</nav>
		<nav id="navMobile">
			<span class="icon fa-globe">Menu</span>
			<ul>
					<li><a href="/">Home</a></li>
					<li><a href="/lab">Lab</a></li>
					<li><a href="/#contact">Kontakt</a></li>
			</ul>
		</nav>
			<?php require "page/" . $_GET["page"] . ".php"; ?>
	</body>
</html>