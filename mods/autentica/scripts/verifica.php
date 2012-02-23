<?
/**
 * Função deste arquivo
 * Fazer um file_get_content (acho que é isso) em uma API externa
 * enviando $_SESSION["chavesessao"]; $_SESSION["usuario"]; $_SESSION["senha"]; $_SESSION["cliente"];
 * a api irá verificar na tabela de usuarios se o usuario e senha conferem e se estao relacionados ao cliente mencionado
 * e irá verificar se este usuário tem sessao aberta no sistema. Se tiver, retorna 1, se nao, retorna 0.
 */
$retorno = 1;
$_SESSION["nomeusuario"] = "Tiago";
if($retorno == 0){
	$json = array("status" => 0, "loginbox" => "pages/formLogin.htm");
}else{
	$json = array("status" => 1, "loginbox" => "pages/bemvindo.php", "nomeusuario" => $_SESSION["nomeusuario"]);
}
echo json_encode($json);
#unset($json,$_SESSION["nomeusuario"]);
?>
