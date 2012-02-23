<?php
/**
 * Script para otimização de tabelas
 * Baseado no seguinte script: http://www.numaboa.com.br/informatica/linux/configuracoes/1063-php-cron
 */

include("../inc/crislib.php");//banco de dados
include("../inc/class/class.db.php");//banco de dados
$db = new db();
$db->conexaoPadrao();
 
$all_tables = mysql_query( "SHOW TABLES" );
while( $table = mysql_fetch_assoc( $all_tables ) ) {
	foreach( $table as $db=>$tablename ) {
		mysql_query( "OPTIMIZE TABLE " . $tablename ) or die ( mysql_error () );
	}
}

mail("tiago@cetecnologia.com","[administre.me] Otimização de tabelas","Tabelas otimizadas com sucesso!","From: noreply@cetecnologia.com"); 
 
mysql_close();
?>
