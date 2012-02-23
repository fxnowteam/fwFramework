<?

$fazerSinc = 0; // 0 = desativado || 1 = ativado

$db_atual = 0; // 0 = aux || 1 = principal

if($db_atual == 0){
	$urlDB = "bm22.webservidor.net";
	$nomeDB = "station1_usrgestor";
	$usuarioDB = "station1_fclin";
	$senhaDB = "fgsd168#";
}else{
	$urlDB = "administre.me";
	$nomeDB = "admme_usrgestor";
	$usuarioDB = "admme_fclin";
	$senhaDB = "fgsd168#";
}

$con = mysql_connect($urlDB,$usuarioDB,$senhaDB) or die(mysql_error());
$db = mysql_select_db($nomeDB) or die(mysql_error());


?>
