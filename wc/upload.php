<?php
session_start();
include("../inc/crislib.php");//banco de dados
include("../inc/class/class.db.php");//banco de dados
include("../inc/class/class.auth.php");//autenticação
include("../inc/class/class.install.php");//instaladores
include("../inc/class/class.log.php");//log de utilização
include("../inc/class/class.permissoes.php");//permissões de acesso
include("../inc/class/class.forms.php");//formulários
include("../inc/class/class.geral.php");//geral
micoxdecode();

//db
$db = new db();
$db->conexaoPadrao();
$logado = new auth();
$verLogado = $logado->estaLogado($_SESSION["cliente"],$_SESSION["usuario"],$_SESSION["senha"]);

if($verLogado == "2"){

$idpaciente = $_SESSION["idpacientefoto"];
$idat = $_SESSION["idat"];


/*
	This file receives the JPEG snapshot
	from webcam.swf as a POST request.
*/

// We only need to handle POST requests:
if(strtolower($_SERVER['REQUEST_METHOD']) != 'post'){
	exit;
}

$folder = 'uploads/';
$filename = md5($_SERVER['REMOTE_ADDR'].rand()).'.jpg';

$original = $folder.$filename;

// The JPEG snapshot is sent as raw input:
$input = file_get_contents('php://input');

if(md5($input) == '7d4df9cc423720b7f1f3d672b89362be'){
	// Blank image. We don't need this one.
	exit;
}

$result = file_put_contents($original, $input);
if (!$result) {
	echo '{
		"error"		: 1,
		"message"	: "Failed save the image. Make sure you chmod the uploads folder and its subfolders to 777."
	}';
	exit;
}

$info = getimagesize($original);
if($info['mime'] != 'image/jpeg'){
	unlink($original);
	exit;
}

// Moving the temporary file to the originals folder:
rename($original,'uploads/original/'.$filename);
$original = 'uploads/original/'.$filename;

// Using the GD library to resize 
// the image into a thumbnail:

$origImage	= imagecreatefromjpeg($original);
$newImage	= imagecreatetruecolor(200,142);
imagecopyresampled($newImage,$origImage,0,0,0,0,200,142,520,370); 

imagejpeg($newImage,'uploads/thumbs/'.$filename);

echo '{"status":1,"message":"Success!","filename":"'.$filename.'"}';

//se estivermos editando um paciente
if($idpaciente != ""){
   //verifica se já há uma foto
   $foto = campo("paciente_".$_SESSION["cliente"],"fotourl",$idpaciente);
   //se sim, deleta
   if($foto != ""){
     unlink("uploads/original/$foto");
     unlink("uploads/thumbs/$foto");
   }
   //grava no banco a nova foto do paciente
   $upd = upd("paciente_".$_SESSION["cliente"],"fotourl = '$filename'",$idpaciente);
   $_SESSION["idpacientefoto"] = "";
}else{
   $_SESSION["imagemwebcam"] = "";
   $_SESSION["imagemwebcam"] = $filename; //grava nome da imagem numa sessão para, quando salvar o cadastro, salvar a foto do paciente junto
}

if($idat != ""){
	$ins = ins("at_webcam_".$_SESSION["cliente"],"idagendamento, fotourl","'$idat', '$filename'");
}

}else{
	echo '{
		"error"		: 1,
		"message"	: "Voce nao esta logado!"
	}';
}
?>
