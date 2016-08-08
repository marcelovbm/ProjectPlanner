'use strict';
//FUNCOES RELACIONADAS AO MEETING
var riscos =	{
	listRiscos(){
		//$("#finalizeButton").addClass("hide");
		if (document.getElementById('projectSelected').innerText != "Project Selected") {
			var projetoEscolhido = document.getElementById('projectSelected').innerHTML;
			$.ajax({ //FAZ UM REQUISICAO PARA O ARQUIVO COM LIGACAO AO BANCO DE DADOS
				url: "controller/riscos.php", //ARQUIVO COM LIGACAO AO BANCO DE DADOS
				type: "POST",
				dataType: 'HTML',
				data: "nameProject=" + projetoEscolhido
			})
			.done(function(msg) {
				document.getElementById('panel-heading').innerHTML = 'Riscos';
				document.getElementById('panel-body').innerHTML = msg;
				document.getElementById('addButton').setAttribute('data-target', '#new-riscos');
			})
			.fail(function(jqXHR, textStatus) {
				alert("Request failed: " + textStatus);
			});
		} else {
			document.getElementById('notificationText').innerHTML = "Please select a project!";
			$('#notificacoes').modal('show');
		}
	},

	clearModalRiscos() {
		$('#cadRiscos').each(function() { //RESETA OS CAMPOS DO FORMULARIO DE CADASTRO
			this.reset();
		});
		riscos.listRiscos();
	},

	addRiscos() {
		var inputProjectName = document.getElementById('projectSelected').innerHTML;
		var obj = {};
		var formData = $("#cadRiscos").serializeArray(); //VALORES RECEBIDOS PELO FORMULARIO
		$.each(formData, function() {
	        if (obj[this.name] !== undefined) {
	            if (!obj[this.name].push) {
	                obj[this.name] = [obj[this.name]];
	            }
	            obj[this.name].push(this.value || '');
	        } else {
	            obj[this.name] = this.value || '';
	        }
	    });
		obj.inputProjectName = inputProjectName;
		var data = JSON.stringify(obj);
		//console.log(obj);
		$.ajax({ //ENVIA OS VALORES PARA ARQUIVO COM CONEXAO PARA O BANCO DE DADOS
			url: 'controller/addRiscos.php', //ARQUIVO COM CONEXAO AO BANCO DE DADOS
			type: 'POST', //TIPO DE ENVIO
			data: data //VALORES ENVIADOS
		})
		.done(function(msg){
			//console.log(msg);
		})
		.fail(function(){
			console.log("error");
		})
		.always(function(){
			$('.ui.dropdown').dropdown('clear');
			$('#cadRiscos').each(function() { //RESETA OS CAMPOS DO FORMULARIO DE CADASTRO
				this.reset();
			});
			meeting.listMeeting();
		});
	}
};
