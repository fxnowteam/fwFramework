<html>
	<head>
		<title><?= TITLESISTEMA ?></title>
		<link rel="stylesheet" type="text/css" href="inc/css/geral.css">
		<script type="text/javascript" src="inc/jquery-1.5.1.js"></script>
                <? /*<script src="http://ajax.googleapis.com/ajax/libs/jquery/1.3/jquery.min.js" type="text/javascript"></script> */ ?>
		<link type="text/css" href="inc/jqueryui_marrom/css/mint-choc/jquery-ui-1.8.10.custom.css" rel="stylesheet" />
		<? /*<script type="text/javascript" src="inc/jqueryui_marrom/js/jquery-1.4.4.min.js"></script>*/ ?>
		<script type="text/javascript" src="inc/jqueryui_marrom/js/jquery-ui-1.8.10.custom.min.js"></script>
		<link type="text/css" href="inc/jqueryui.css" rel="stylesheet" />
		<script type="text/javascript" src="inc/jqueryui.js"></script>
		<script type="text/javascript" src="inc/ajax_dentro_do_ajax.js"></script>
		<script type="text/javascript" src="inc/crislib.js"></script>
		<script type="text/javascript" src="inc/geral.js"></script>
		<link type="text/css" href="inc/dropdownmenu.css" rel="stylesheet" />
		<link type="text/css" href="inc/css/novomenudropdown.css" rel="stylesheet" />
		<meta http-equiv="content-language" content="pt-br">
		<meta http-equiv="content-type" content="text/html; charset=iso-8859-1">
		<meta name="description" content="Sistemas de gestão empresarial, gestão para clinicas e consultórios médicos e odontológicos, com prontuário eletrônico, controle financeiro, entre outros." />
		<meta name="keywords" content="médico,gestão,clinica,consultório,odonto,odontológico,odontograma,prontuário,digital,online,virtual,sistema,aplicativo,gsetão,empresarial">
		<meta name="robots" content="noindex,nofollow">
		<meta name="robots" content="noarchive">
		<meta name="author" content="Tiago Floriano" />
		<meta name="reply-to" content="tiago@cetecnologia.com">
		<meta name="google" content="notranslate" />
		<style type="text/css">
			<!--
			#conteudo {
			    background-image: url(img/5/80.png);
			    background-position: center;
			    background-repeat: no-repeat;
			}
			-->
		</style>
	</head>
	<body onload="carregaFrames()">

		<div id="topo">
			<div id="logo">
				<a href="?home"><img src="img/5/50.png"></a>
			</div>
			<div id="loginbox"></div>
		</div>
		<div id="conteudo">

			<div id="menudd">
				<ul class="topnav">
					<li><a href="#home">P&aacute;gina inicial</a></li>
					<li><a href="#sobre">Sobre</a></li>
					<li><a href="#recursos">Recursos</a></li>
					<li><a href="#faleconosco">Fale conosco</a></li>
				</ul>
			</div>
		
			<div id="conteudoSis"></div>
			
		</div>
                <div style="clear:both;"></div>
		<div id="copy">
                    &copy; 2011-<?= date("Y") ?> <?= RAZAOSOCIAL ?>.<br>
		</div>
		<link rel="stylesheet" type="text/css" href="http://fonts.googleapis.com/css?family=Ubuntu:regular,bold&subset=Latin">
	</body>
</html>
