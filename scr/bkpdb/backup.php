<?
/*********************
> DESCRIÇÃO

Script faz backup de vários databases do mysql e envia por email
Extrai o SQL - Salva em um arquivo .sql - Zipa - Manda por e-mail - Apaga o .sql e o .zip

> CRÉDITOS

ENVIO DE ANEXOS - Vinicius G Mommensohn
Autor - http://www.phpbrasil.com/profile.php/user/scratch 
Tutorial - http://www.phpbrasil.com/articles/article.php/id/661

BACKUP DO MYSQL - Fabyo
Autor - http://forum.imasters.com.br/index.php?showuser=13485
Tutorial - http://forum.imasters.com.br/index.php?showtopic=125348&st=0&p=499575&#entry499575

CONFIGURAÇÕES, ELABORAÇÃO E ZIP
Maicon Rafael Pereira - mrpereira - maiconr@gmail.com
Rafael Silva - rafa.developer - rafa.developer@gmail.com

OBSERVAÇÕES
NÃO é necessário permissão de escrita na pasta onde o php está localizado.
O script cria todos os arquivos nescessarios em uma pasta separada, setada na variavel $folder_name assim fica mais seguro

LIBRARY
Library utilizada: http://www.phpconcept.net/pclzip/index.en.php
Library recomendada por: Rodrigo Romano Moreira

******************************/

// Configurações Mysql

$host_externo = "localhost"; // host
$usuario = "admme_usrgestor"; // usuário do mysql
$senha = "fgsd168#"; // senha do mysql
$databases = array("admme_fclin"); // base para backup

// Configurações E-mail, recebimento do backup

$remetente = "Tiago Floriano";
$email_remetente = "tiago@cetecnologia.com";

$assunto = "Backup Servidor - Database"; 
$mensagem = " - Backup do banco de dados;
Data: ".date("d/m/Y")." Hora: ".date("H:i:s")."
IP: ".$_SERVER['REMOTE_ADDR']."
Sistema de Backup dos Banco de Dados"; // Mensagem no e-mail de backup

$destinatario = "Tiago Floriano"; 
$email_destinatario = "webmaster.rs@gmail.com";

// Configurações de arquivos

$quero_zipar = TRUE; // TRUE or FALSE - Caso não quiser ZIP receberá em txt.

$receber_backup_mail = TRUE; // TRUE or FALSE - Você pode optar por apenas salvar o backup na pasta
$excluir_backups = TRUE; // TRUE or FALSE - Depois de enviado o email deletar os backups do servidor.


// Fim das configurações
 

/////// FINALIZA AS CONFIGURAÇÕES E INICIA A ROTINA

set_time_limit(0);

require("pclzip.lib.php");  //biblioteca para ZIP

mysql_connect(($ip = $_SERVER['REMOTE_ADDR'] == " 127.0.0.1"?'localhost':$host_externo), $usuario, $senha) or die ("Erro ao conectar no Mysql");

// FUNÇÕES

function sqlAddslashes($str = '', $is_like = FALSE)
{
    if ($is_like)
    {
        $str = str_replace('\\', '\\\\\\\\', $str);
        }else{
        $str = str_replace('\\', '\\\\', $str);
        }
        $str = str_replace('\'', '\\\'', $str);
        return $str;
}

function dumptb($table) {
    $nline = "\n";
    $dp = "CREATE TABLE $table ($nline";
    $firstfield = 1;
    $fields_array = mysql_query("SHOW FIELDS FROM $table");
    
    while ($field = mysql_fetch_array($fields_array))
    {
        if (!$firstfield)
        {
            $dp .= ",\n";
        }else{
            $firstfield = 0;
        }
        $dp .= "\t".$field["Field"]." ". $field["Type"];
        if (isset($field['Default']) && $field['Default'] != '')
        {
                    $dp .= ' default \'' . sqlAddslashes($field['Default']) . '\'';
        }
        if ($field['Null'] != 'YES')
        {
            $dp .= ' NOT NULL ';
        }
        if (!empty($field["Extra"]))
        {
            $dp .= $field["Extra"];
        }
    }
    mysql_free_result($fields_array);

    $keysindex_array = mysql_query("SHOW KEYS FROM $table");

    while ($key = mysql_fetch_array($keysindex_array))
    {
        $kname = $key['Key_name'];
        if ($kname != "PRIMARY" and $key['Non_unique'] == 0)
        {
            $kname = "UNIQUE|$kname";
        }

        $index[$kname][] = $key['Column_name'];
    }
    mysql_free_result($keysindex_array);
    
    while(list($kname, $columns) = @each($index))
    {
        $dp .= ",\n";
        $colnames = implode($columns,",");
        if($kname == 'PRIMARY')
        {
            $dp .= "\tPRIMARY KEY ($colnames)";
        }else{
            if (substr($kname,0,6) == 'UNIQUE')
            {
                $kname = substr($kname,7);
            }
            $dp .= "   KEY $kname ($colnames)";
        }
    }
    $dp .= "\n);\n\n";
    $rows = mysql_query("SELECT * FROM $table");
    $numfields=mysql_num_fields($rows);
    
    while ($row = mysql_fetch_array($rows))
    {
        $dp .= "INSERT INTO $table VALUES(";
        $fieldcounter=-1;
        $firstfield=1;
        while (++$fieldcounter<$numfields)
        {
            if(!$firstfield)
            {
                $dp .=' , ';
            }else{
                $firstfield=0;
            }
            if (!isset($row[$fieldcounter]))
            {
                $dp .= 'NULL';
            }else{
                $dp .= "'".mysql_escape_string($row[$fieldcounter])."'";
            }
        }
        $dp .= ");\n";
    }
    mysql_free_result($rows);
    return $dp;
}

// SELEÇÃO DOS DATABASES
$n=0;
while($databases[$n]){ 
mysql_select_db($databases[$n]);

// Fim da seleção

$file_name = $databases[$n].date('--Y-m-d-H-i-s').".sql";
$filehandle = fopen($file_name,'w');
$result = mysql_query("SHOW tables"); 
    while ($row = mysql_fetch_array($result))
    {
        fwrite($filehandle,dumptb($row[0])."\n\n\n");
    }
fclose($filehandle);


if ($quero_zipar == TRUE){ // ZIPANDO

	$archive = new PclZip("backup-".$databases[$n].".zip");
	$list = $archive->create(array(
						
						array( PCLZIP_ATT_FILE_NAME => $folder_name.$file_name)
					  ),
					  PCLZIP_OPT_ADD_PATH, $databases[$n],
					  PCLZIP_OPT_REMOVE_PATH, $folder_name);
	if ($list == 0) {
	  die("ERROR : '".$archive->errorInfo(true)."'");
	}

$file_name	= "backup-".$databases[$n].".zip";
} //término do zip


if ($receber_backup_mail == TRUE){ // ENVIANDO ARQUIVO POR EMAIL 

$boundary = strtotime('NOW');
   
$headers = "From: $remetente <$email_remetente>\n";
$headers .= "To: $destinatario <$email_destinatario>\r\n";
$headers .= "MIME-Version: 1.0\n";
$headers .= "Content-Type: multipart/mixed; boundary=\"" . $boundary . "\"\n";
 
$msg = "--" . $boundary . "\n";
$msg .= "Content-Type: text/plain; charset=\"iso-8859-1\"\n"; 
$msg .= "Content-Transfer-Encoding: quoted-printable\n\n"; 

$msg .= "$mensagem\n";
 
$msg .= "--" . $boundary . "\n";
$msg .= "Content-Transfer-Encoding: base64\n"; 
$msg .= "Content-Disposition: attachment; filename=\"$file_name\"\n\n";

ob_start();
   readfile($file_name);
   $enc = ob_get_contents();
ob_end_clean();

$msg_temp = base64_encode($enc). "\n"; 
$tmp[1] = strlen($msg_temp);
$tmp[2] = ceil($tmp[1]/76);

for ($b = 0; $b <= $tmp[2]; $b++) {
    $tmp[3] = $b * 76;
    $msg .= substr($msg_temp, $tmp[3], 76) . "\n";
}

unset($msg_temp, $tmp, $enc); 

mail($email_destinatario, $assunto.": $databases[$n]", $msg, $headers) or die("Erro ao enviar e-mail");

} // Término do envio 



if($excluir_backups == TRUE && $receber_backup_mail == TRUE){

	$dir = "./";
	$dh = opendir($dir);
	
	while (false !== ($filename = readdir($dh))) {
	
		if ((substr($filename,-4) == ".sql")||(substr($filename,-4)== ".zip")) 
			{ 
				unlink($dir.$filename);
				if (unlink) echo "$filename - excluído<br />"; 
				else echo "$filename - erro ao excluir<br />";
			}
	}
}

echo "<h1>Backup realizado com sucesso";
if ($receber_backup_mail == TRUE){
		echo "- Em breve você receberá no e-mail: $email_destinatario</h1>";
	}else{
			echo "- Você não acionou a diretiva $receber_backup_mail, portanto deverá fazer o download do arquivo de backup na pasta do script";
		}
		
$n++;} // fim
?>
