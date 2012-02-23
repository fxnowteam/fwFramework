<?
session_start();
include("inc/crislib.php");//banco de dados
include("inc/class/class.geral.php");//geral
micoxdecode();
$geral = new geral();
include("themes/".THEME."/index.php");
?>
