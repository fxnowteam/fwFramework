$(document).ready(function(){

	$("ul.subnav").parent().append("<span></span>"); //Only shows drop down trigger when js is enabled (Adds empty span tag after ul.subnav*)

	$("ul.topnav li span").click(function() { //When trigger is clicked...

		//Following events are applied to the subnav itself (moving subnav up and down)
		$(this).parent().find("ul.subnav").slideDown('fast').show(); //Drop down the subnav on click

		$(this).parent().hover(function() {
		}, function(){
			$(this).parent().find("ul.subnav").slideUp('slow'); //When the mouse hovers out of the subnav, move it back up
		});

		//Following events are applied to the trigger (Hover events for the trigger)
		}).hover(function() {
			$(this).addClass("subhover"); //On hover over, add class "subhover"
		}, function(){	//On Hover Out
			$(this).removeClass("subhover"); //On hover out, remove class "subhover"
	});

});




    function abreSub(iddiv,totalmenus){
        //oculta submenus
        var contador = 0;
        while(contador != totalmenus){
            contador = contador + 1;
            if(document.getElementById('sub_'+contador) != null){
                document.getElementById('sub_'+contador).style.display = 'none';
            }
        }

        var contador = 0;

        //oculta submenus
        while(contador != totalmenus){
            contador = contador + 1;
            if(document.getElementById('menu_'+contador) != null){
                document.getElementById('menu_'+contador).style.background = '#473f24';
            }
        }

        var contador = 0;

        //
        if(document.getElementById('sub_'+iddiv) != null){
            document.getElementById('sub_'+iddiv).style.display = 'block';
        }
        document.getElementById('menu_'+iddiv).style.background = '#79725a';
    }


function alertaLido(id){
	$('#msgOk').html("Aguarde...");
	$('#alertas').load("inc/alertaLido.php", {id: id});
}

function ocultarAlertaFinanceiro(){
	$('#alertasFin').load("inc/alertaFinLido.php");
	$('#alertasFin').hide();
}

function carregaFrames(){
	$.getJSON("mods/autentica/scripts/verifica.php", function(json){ 
		$("#loginbox").load(json.loginbox); 
		if(json.status == 1){
			$("#nomeusuario").html(json.nomeusuario); 
		}
	}); 
}
