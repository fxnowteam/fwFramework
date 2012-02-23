<?
session_start();

include("../../inc/crislib.php");//banco de dados
include("../../inc/class/class.db.php");//banco de dados
$db = new db();
$db->conexaoPadrao();

include("../../inc/class/class.geral.php");//banco de dados
$geral = new geral();
$geral->protege();
$geral->nocache();

include("../../inc/class/class.auth.php");//banco de dados
$logado = new auth();
$verLogado = $logado->estaLogado($_SESSION["cliente"],$_SESSION["usuario"],$_SESSION["senha"]);

if($verLogado != "2" or $_GET["idag"] == ""){
	exit;
}
$_SESSION["idag_uploadimg"] = "";
$_SESSION["idag_uploadimg"] = str($_GET["idag"]);
?><!DOCTYPE HTML>
<!--
/*
 * jQuery File Upload Plugin HTML Example 5.1
 * https://github.com/blueimp/jQuery-File-Upload
 *
 * Copyright 2010, Sebastian Tschan
 * https://blueimp.net
 *
 * Licensed under the MIT license:
 * http://creativecommons.org/licenses/MIT/
 */
-->
<html lang="en" class="no-js">
<head>
<meta charset="utf-8">
<title>Upload</title>
<link rel="stylesheet" href="http://ajax.googleapis.com/ajax/libs/jqueryui/1.8.16/themes/base/jquery-ui.css" id="theme">
<link rel="stylesheet" href="../jquery.fileupload-ui.css">
<link rel="stylesheet" href="style.css">
</head>
<body>
<div id="fileupload">
    <form action="upload.php" method="POST" enctype="multipart/form-data">
        <div class="fileupload-buttonbar">
            <label class="fileinput-button">
                <span>Adicionar imagens...</span>
                <input type="file" name="files[]" multiple>
            </label>
            <button type="submit" class="start">Iniciar upload</button>
            <button type="reset" class="cancel">Cancelar upload</button>
            <button type="button" class="delete">Apagar arquivos</button>
        </div>
    </form>
    <div class="fileupload-content">
        <table class="files"></table>
        <div class="fileupload-progressbar"></div>
    </div>
</div>
<script id="template-upload" type="text/x-jquery-tmpl">
    <tr class="template-upload{{if error}} ui-state-error{{/if}}">
        <td class="preview"></td>
        <td class="name">{{if name}}${name}{{else}}Untitled{{/if}}</td>
        <td class="size">${sizef}</td>
        {{if error}}
            <td class="error" colspan="2">Error:
                {{if error === 'maxFileSize'}}File is too big
                {{else error === 'minFileSize'}}File is too small
                {{else error === 'acceptFileTypes'}}Filetype not allowed
                {{else error === 'maxNumberOfFiles'}}Max number of files exceeded
                {{else}}${error}
                {{/if}}
            </td>
        {{else}}
            <td class="progress"><div></div></td>
            <td class="start"><button>Iniciar</button></td>
        {{/if}}
        <td class="cancel"><button>Cancelar</button></td>
    </tr>
</script>
<script id="template-download" type="text/x-jquery-tmpl">
    <tr class="template-download{{if error}} ui-state-error{{/if}}">
        {{if error}}
            <td></td>
            <td class="name">${name}</td>
            <td class="size">${sizef}</td>
            <td class="error" colspan="2">Error:
                {{if error === 1}}File exceeds upload_max_filesize (php.ini directive)
                {{else error === 2}}File exceeds MAX_FILE_SIZE (HTML form directive)
                {{else error === 3}}File was only partially uploaded
                {{else error === 4}}No File was uploaded
                {{else error === 5}}Missing a temporary folder
                {{else error === 6}}Failed to write file to disk
                {{else error === 7}}File upload stopped by extension
                {{else error === 'maxFileSize'}}File is too big
                {{else error === 'minFileSize'}}File is too small
                {{else error === 'acceptFileTypes'}}Filetype not allowed
                {{else error === 'maxNumberOfFiles'}}Max number of files exceeded
                {{else error === 'uploadedBytes'}}Uploaded bytes exceed file size
                {{else error === 'emptyResult'}}Empty file upload result
                {{else}}${error}
                {{/if}}
            </td>
        {{else}}
        	
        {{/if}}
    </tr>
</script>
<script src="http://ajax.googleapis.com/ajax/libs/jquery/1.6.4/jquery.min.js"></script>
<script src="http://ajax.googleapis.com/ajax/libs/jqueryui/1.8.16/jquery-ui.min.js"></script>
<script src="http://ajax.aspnetcdn.com/ajax/jquery.templates/beta1/jquery.tmpl.min.js"></script>
<script src="../jquery.iframe-transport.js"></script>
<script src="../jquery.fileupload.js"></script>
<script src="../jquery.fileupload-ui.js"></script>
<script src="application.js"></script>
</body> 
</html>
