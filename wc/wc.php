<?
session_start();

include("../inc/crislib.php");//banco de dados
include("../inc/class/class.db.php");//banco de dados
$db = new db();
$db->conexaoPadrao();

include("../inc/class/class.geral.php");//banco de dados
$geral = new geral();
$geral->protege();
$geral->nocache();

include("../inc/class/class.auth.php");//banco de dados
$logado = new auth();
$verLogado = $logado->estaLogado($_SESSION["cliente"],$_SESSION["usuario"],$_SESSION["senha"]);

if($verLogado != "2"){
	exit;
}

$_SESSION["idpacientefoto"] = "";
$_SESSION["idpacientefoto"] = strip_tags($_GET["i"]);
$_SESSION["idat"] = "";
$_SESSION["idat"] = strip_tags($_GET["at"]);
?><!DOCTYPE html>
<html>
<head>
<meta charset="utf-8" />
<title>Webcam</title>

<link rel="stylesheet" type="text/css" href="assets/css/styles.css" />
<link rel="stylesheet" type="text/css" href="assets/fancybox/jquery.fancybox-1.3.4.css" />

</head>
<body>

<div id="camera">
	<span class="tooltip"></span>
	<span class="camTop"></span>
    
    <div id="screen"></div>
    <div id="buttons">
    	<div class="buttonPane">
        	<a id="shootButton" href="" class="blueButton">Capturar!</a>
        </div>
        <div class="buttonPane hidden">
        	<a id="cancelButton" href="" class="blueButton">Cancelar</a> <a id="uploadButton" href="" class="greenButton">Salvar!</a>
        </div>
    </div>
    
    <span class="settings"></span>
</div>


<script src="http://ajax.googleapis.com/ajax/libs/jquery/1.5.2/jquery.min.js"></script>
<script src="assets/fancybox/jquery.easing-1.3.pack.js"></script>
<script src="assets/fancybox/jquery.fancybox-1.3.4.pack.js"></script>
<script src="assets/webcam/webcam.js"></script>
<script src="assets/js/script.js"></script>

</body>
</html>
