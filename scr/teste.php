<?
/* --- CONEXAO --- */
include("../inc/crislib.php");//banco de dados
include("../inc/class/class.db.php");//banco de dados
$db = new db();
$db->conexaoPadrao();
/* --- CONEXAO --- */

/*$sel = mysql_query("CREATE TABLE IF NOT EXISTS categorias (id int(11) auto_increment, nome text, idpai int(11), primary key(id) )") or die(mysql_error());
$sel = mysql_query("INSERT INTO categorias (nome, idpai) VALUES ('Cat 1', '0')") or die(mysql_error());
$sel = mysql_query("INSERT INTO categorias (nome, idpai) VALUES ('Cat 2', '3')") or die(mysql_error());
$sel = mysql_query("INSERT INTO categorias (nome, idpai) VALUES ('Cat 3', '0')") or die(mysql_error());
$sel = mysql_query("INSERT INTO categorias (nome, idpai) VALUES ('Cat 4', '2')") or die(mysql_error());
$sel = mysql_query("INSERT INTO categorias (nome, idpai) VALUES ('Cat 5', '2')") or die(mysql_error());
$sel = mysql_query("INSERT INTO categorias (nome, idpai) VALUES ('Cat 6', '5')") or die(mysql_error());
$sel = mysql_query("INSERT INTO categorias (nome, idpai) VALUES ('Cat 7', '2')") or die(mysql_error());
$sel = mysql_query("INSERT INTO categorias (nome, idpai) VALUES ('Cat 8', '3')") or die(mysql_error());*/

function listaCat(){
	//lista categorias
	$sel = mysql_query("SELECT * FROM categorias WHERE idpai = '0'") or die(mysql_error());
	//verifica sub-categorias
	if(mysql_num_rows($sel) > 0){
		while($r = mysql_fetch_array($sel)){
			echo $r["nome"]."<br>";
			catFilho($r["id"]);
		}
	}
}

function catFilho($id){
	$sel = mysql_query("SELECT * FROM categorias WHERE idpai = '$id'") or die(mysql_error());
	if(mysql_num_rows($sel) > 0){
		while($r = mysql_fetch_array($sel)){
			echo "<blockquote>".$r["nome"]."<br>";
			catNetos($r["id"]);
			echo "</blockquote>";
		}
	}
}

function catNetos($id){
	$sel = mysql_query("SELECT * FROM categorias WHERE idpai = '$id'") or die(mysql_error());
	if(mysql_num_rows($sel) > 0){
		while($r = mysql_fetch_array($sel)){
			echo "<blockquote>".$r["nome"]."<br>";
			catFilho($r["id"]);
			echo "</blockquote>";
		}
	}
}

listaCat();
?>