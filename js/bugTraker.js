'use strict';

//FUNCOES RELACIONADAS AO BUGTRAKER
var bugTraker 	=	{
	listBugTraker(){
		var projetoEscolhido = document.getElementById('projectSelected');
		if (projetoEscolhido.innerText != "Project Selected") {
			$.ajax({ //FAZ UM REQUISICAO PARA O ARQUIVO COM LIGACAO AO BANCO DE DADOS
				url: "controller/listBugTraker.php", //ARQUIVO COM LIGACAO AO BANCO DE DADOS
				type: "POST",
				dataType: 'HTML',
				data: "nameProject=" + projetoEscolhido.innerHTML
			})
			.done(function(msg) {
				$(".panel").removeClass("hide");
				$("#addButton").removeClass("hide");
				$("#addButton").attr("data-target", "#new-bugTraker");
				document.getElementById('panel-heading').innerHTML = "Bug Traker";
				document.getElementById('panel-body').innerHTML = msg;
				$.ajax({
					url: 'controller/listSprintBugTraker.php',
					type: 'POST',
					data: "inputProjectName=" + projetoEscolhido.innerHTML
				})
				.done(function(msg) {
					document.getElementById('inputBugTrakerItem').innerHTML = msg;
					//console.log("success");
				})
				.fail(function() {
					console.log("error");
				});
			})
			.fail(function(jqXHR, textStatus) {
				alert("Request failed: " + textStatus);
			});
		} else {
			document.getElementById('notificationText').innerHTML = "Please select a project!";
			$('#notificacoes').modal('show');
		}
	},

	clearModalBugTraker() {
		$('#cadBugTraker').each(function() { //RESETA OS CAMPOS DO FORMULARIO DE CADASTRO
			this.reset();
		});
		bugTraker.listBugTraker();
	},

	changeStatus(novoStatus, idBug) {
		var inputProjectName = document.getElementById('projectSelected').innerHTML;
		var data = 'inputBugName=' + encodeURIComponent(idBug) + '&' + 'status=' + encodeURIComponent(novoStatus) + '&' + 'inputProjectName=' + encodeURIComponent(inputProjectName);
		$.ajax({ //ENVIA OS VALORES PARA ARQUIVO COM CONEXAO PARA O BANCO DE DADOS
			url: "controller/alterarStatusBugTraker.php", //ARQUIVO COM CONEXAO AO BANCO DE DADOS
			type: "POST", //TIPO DE ENVIO
			data: data //VALORES ENVIADOS
		})
		.done(function(){
			//console.log('success');
			bugTraker.listBugTraker();
		})
		.fail(function(){
			console.log('error');
		});
	},

	addBugTraker() {
		var inputProjectName = document.getElementById('projectSelected').innerHTML;
		var formData = $("#cadBugTraker").serialize(); //VALORES RECEBIDOS PELO FORMULARIO
		var data = 'inputProjectName=' + encodeURIComponent(inputProjectName) + '&' + formData;
		$.ajax({ //ENVIA OS VALORES PARA ARQUIVO COM CONEXAO PARA O BANCO DE DADOS
			url: "controller/addBugTraker.php", //ARQUIVO COM CONEXAO AO BANCO DE DADOS
			type: "POST", //TIPO DE ENVIO
			data: data //VALORES ENVIADOS
		})
		.done(function() {
			//console.log("success");
			bugTraker.listBugTraker();
			$('#cadBugTraker').each(function() { //RESETA OS CAMPOS DO FORMULARIO DE CADASTRO
				this.reset();
			});
		})
		.fail(function() {
			console.log("error");
		});
	}
};
