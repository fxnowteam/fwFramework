<?
class geral {
	//proteção contra acesso indevido aos arquivos dos sub-diretórios
	/*
	$seg = new geral();
	$seg->protege();
	*/
	public function protege(){
		/*$sn = $_SERVER['SCRIPT_NAME'];
		
		$permitidos = array("mods/agendamento_consulta/scripts/buscaPaciente.php",
		"mods/agendamento_consulta/scripts/cadPaciente.php",
		"mods/agendamento_consulta/scripts/exibeValor.php",
		"mods/agendamento_consulta/scripts/gravarAgendamento.php",
		"mods/agendamento_consulta/scripts/gravarCadPaciente.php",
		"mods/agendamento_consulta/scripts/mostraagenda.php",
		"mods/agendamento_consulta/scripts/buscaPaciente.php",
		"mods/agendamento_pesquisa/scripts/alteraAgendamento.php",
		"mods/agendamento_pesquisa/scripts/resultados.php",
		"mods/atendimento_consulta/scripts/atendimento.php",
		"mods/atendimento_consulta/scripts/listaPacientes.php",
		"mods/atendimento_consulta/scripts/triagem.php",
		"mods/cadastro_convenios/scripts/listaConvenios.php",
		"mods/cadastro_convenios/scripts/salvaConvenio.php",
		"mods/cadastro_operadores/scripts/salvaCadastro.php",
		"mods/suporte/scripts/sendTicket.php'");
		
		$verificador = false;
		$contagem = 0;
		
		while(($contagem + 1) != count($permitidos)){
			$verifica = substr($permitidos[$contagem],$sn);
			if($verifica === false){
				
			}else{
				$verificador = true;
			}
			$contagem = $contagem + 1;
		}
		
		if($verificador == false){
			echo "Oops! Acesso ilegal! Seu IP foi registrado por seguran&ccedil;a. Se continuar tentando ele ser&aacute; bloqueado em nosso servidor.";
			exit;
		}else{
			$explode = explode("/",$sn);
			$modulo = $explode[1];
			include_once("class.permissoes.php");
			$permissoes = new permissoes();
			if($permissoes->permissao($modulo) == false){
				echo "Oops! Voc&ecirc; n&atilde;o tem permiss&atilde;o para executar esta a&ccedil;&atilde;o!";
				exit;
			}
		}*/
	}
	//include geral
	public function js($path){
		e("<script type=\"text/javascript\" src=\"$path\"></script>");
	}
	//include geral
	public function css($path){
		e("<link type=\"text/css\" href=\"$path\" rel=\"stylesheet\">");
	}
	//include dentro de modulos
	public function mjs($path){
		e("<script type=\"text/javascript\" src=\"/s/mods/$path/inc/js.js\"></script>");
	}
	//include dentro de modulos
	public function mcss($path){
		e("<link type=\"text/css\" href=\"/s/mods/$path/inc/css.css\" rel=\"stylesheet\">");
	}
	//ajax no cache
	public function nocache(){
	        $gmtDate = gmdate("D, d M Y H:i:s");
		header("Expires: {$gmtDate} GMT");
		header("Last-Modified: {$gmtDate} GMT");
		header("Cache-Control: no-cache, must-revalidate");
		header("Pragma: no-cache");
	}
	//verifica configurações do sistema, de acordo com o cliente
	public function config($op){
		/*
		 * verifica diversas configurações feitas pelo cliente ou pelo suporte 
		 */

		//verifica nome da atual tabela de CIDs
		if($op == "tabelacid"){
			#$nome = "";
			$nome = "20110904";
			return $nome;
		}

		//verifica se há atendimento de triagem ou se é apenas a presença
		if($op == "triagem"){
			return false;
		}
	}
	
	//verifica o tema do cliente
	public function tema($cliente,$opcao){
	        $sel = sel("clientes","url = '$cliente'");
	        $o = fetch($sel);
	        
	        $sel2 = sel("cliente_tema","idcliente = '".$o["id"]."'");
	        
	        if(total($sel2) == 0){
	                return false;
	        }else{
	                $f = fetch($sel2);
	                $return = $f[$opcao];
	                return $return;
	        }
	}      
	
	//
	public function cboth(){
		e("<div style=\"clear:both\"></div>");
	}
	

	public function montaMenu(){
		include_once("class.permissoes.php");
		$permissoes = new permissoes();
		
		//lista menus
		e("<ul class=\"topnav\">");
		#$menus = "";
		#$submenus = "";
		$sel = sel("menu","menupai = '0'","ordem ASC");
		$totalmenus = total($sel);
		while($o = fetch($sel)){
		    $cont = $cont + 1;
		    /*if($cont == 1){
			$display = "block";
		    }else{
			$display = "none";
		    }
		    if($o["link"] == "#"){
			$onclick = " onmouseover=\"abreSub('$cont','$totalmenus')\"";
		    }else{
			$onclick = "";
		    }*/
		    if($permissoes->permissao($o["modulo"]) == true or $o["modulo"] == "global"){
			    e("<li><a href=\"".$o["link"]."\">".$o["nome"]."</a>");
			    //se o menu comporta um submenu, lista os submenus
			    $sel2 = sel("menu","menupai = '".$o["id"]."'","ordem ASC");
			    if(total($sel2) > 0){
				#$submenus .= "<div id=\"sub_".$cont."\" class=\"submenu\" style=\"display: $display\">";
				e("<ul class=\"subnav\">");
				while($r = fetch($sel2)){
					if($permissoes->permissao($r["modulo"]) == true or $r["modulo"] == "global"){
						e("<li><a href=\"".$r["link"]."\">".$r["nome"]."</a></li>");
					}
				}
				e("</ul>");
				#$submenus .= "</div>";
			    }
			    e("</li>");
		    }
		}
		#e($menus.$submenus);
		e("</ul>");
	}
	

	public function montaMenu2(){
		include_once("class.permissoes.php");
		$permissoes = new permissoes();
		?>
		<ul class="topnav">
                        <?
                        $sel = sel("menu","menupai = '0'","ordem ASC");
                        $totalmenus = total($sel);
                        while($o = fetch($sel)){
                                $cont = $cont + 1;
                                if($permissoes->permissao($o["modulo"]) == true or $o["modulo"] == "global"){
                                        $sel2 = sel("menu","menupai = '".$o["id"]."'","ordem ASC");
                                        if(total($sel2) > 0){ $idlink = " id=\"menu_".$o["id"]."\""; }else{ unset($idlink); }
                                        e("<li><a href=\"".$o["link"]."\"$idlink>".$o["nome"]."</a>");
                                        if(total($sel2) > 0){ e("<span></span>"); }
                                        e("</li>");
                                }
                        }/*
                        ?>
			<li><a href="?home">In&iacute;cio</a></li>
			<? 
			$modulo = "agendamento";
			if($permissoes->permissao($modulo) == true){ 
			?><li><a href="#" id="agendamento">Agendamento</a><span></span></li><?
			}
			$modulo = "atendimento";
			if($permissoes->permissao($modulo) == true){ 
			?><li><a href="?fclin&m=atendimento_consulta">Atendimento</a></li><?
			}
			$modulo = "cadastros";
			if($permissoes->permissao($modulo) == true){ 
			?>
			<li><a href="#" id="cadastros">Cadastros</a><span></span></li><?
			}
			$modulo = "extras";
			if($permissoes->permissao($modulo) == true){ 
			?>
			<li><a href="#" id="extras">Extras</a><span></span></li><?
			}
			$modulo = "relatorios";
			if($permissoes->permissao($modulo) == true){ 
			?>
			<li><a href="#" id="relatorios">Relat&oacute;rios</a><span></span></li><?
			}
			$modulo = "sistema";
			if($permissoes->permissao($modulo) == true){ 
			?>
			<li><a href="#" id="sistema">Sistema</a><span></span></li><?
			}
			?>
			<li><a href="?sair">Sair</a></li> */?>
		</ul>
<?
	}
	
	public function janelaUI($nomejanela,$nomedivajax,$width,$height,$conteudo=false){
		?>
		<div id="<?= $nomejanela ?>" style="display: none;">
		    <div class="ui-overlay">
			<div class="ui-widget-overlay" style="position: absolute; z-index: 99999999999999;"></div>
			<div id="<?= $nomejanela ?>_background" class="ui-widget-shadow ui-corner-all" style="width: <?= $width+22 ?>px; height: <?= $height+22 ?>px; position: absolute; z-index: 99999999999999; left: 50%; top: 50%; padding: 11px; margin-left: -<?= ($width+22)/2 ?>px; margin-top: -<?= ($height+22)/2 ?>px;"></div>
		    </div>
		    <div id="<?= $nomedivajax ?>" style="position: absolute; z-index: 99999999999999; width: <?= $width ?>px; height: <?= $height ?>px; left: 50%; top: 50%; padding: 10px; margin-left: -<?= $width/2 ?>px; margin-top: -<?= $height/2 ?>px; overflow:auto;" class="ui-widget ui-widget-content ui-corner-all"><?= $conteudo ?></div>
		</div>
		<?
	}
	
	public function aUI($nome,$onclick,$icon){
		e("<a href=\"#\" onclick=\"$onclick\" id=\"dialog_link\" class=\"ui-state-default ui-corner-all\" style=\"margin-right: 5px;\"><span class=\"ui-icon ui-icon-$icon\"></span>$nome</a>");
	}
	
	public function alertas($idalerta,$alertaLido=false){
		/*
		ALERTAS GERAIS
		*/
		$sel = sel("alertas","status = '1'");
		
		if(total($sel) > 0){
			//pega id do usuário
			$buscaidusr = sel("operadores","usuario = '".$_SESSION["usuario"]."'");
			$o = fetch($buscaidusr);
			$idusuario = $o["id"];
		
			//o usuário está informando que o alerta $idalerta já foi lido e não precisa mais ser exibido
			if($alertaLido == true){
				$ins = ins("alertas_lidos","idalerta, idusuario","'$idalerta','$idusuario'");
			}
		
			e("<div id=\"alertas\">");
			while($g = fetch($sel)){
				$busca = sel("alertas_lidos","idalerta = '".$g["id"]."' and idusuario = '$idusuario'");
				if(total($busca) == 0){
					e("<div style=\"margin: 2px;\"\">");
					info($g["mensagem"]."<br>[<a href=\"#\" onclick=\"alertaLido('".$g["id"]."')\">Li, estou ciente e quero excluir este alerta</a>]");
					e("</div>");
				}
			}
			e("</div>");
		}
		
		/*
		ALERTAS MÓDULO FINANCEIRO
		*/
	        include_once("inc/class/class.permissoes.php");
		$prm = new permissoes();
		
		if($prm->permissao("fin") == true){
			e("<div id=\"alertasFin\">");
			$sel2 = sel("fin_".$_SESSION["cliente"],"data = '".date("Y-m-d")."'");
			if(total($sel2) > 0){
				if($_SESSION["alertafinanceiro"] != 2){
					$_SESSION["alertafinanceiro"] = 1;
				}
				if($_SESSION["alertafinanceiro"] == 1){
					e("<div style=\"margin: 2px;\"\">");
					info("<b>Financeiro:</b> h&aacute; pend&ecirc;ncias para hoje! Clique <a href=\"/s/?fclin&m=fin\">aqui</a> para ver. [<a href=\"#\" onclick=\"ocultarAlertaFinanceiro()\">ocultar esta mensagem nesta sess&atilde;o</a>]");
					e("</div>");
				}
			}
			e("</div>");
		}
	}
	
	public function idOp($login){
		$sel = sel("operadores","usuario = '$login'");
		$g = fetch($sel);
		return $g["id"];
	}
	
	public function idOpProf($idprof){
		$sel = sel("profissional_".$_SESSION["cliente"],"id = '$idprof'");
		$g = fetch($sel);
		return $g["idoperador"];
	}
}
?>
