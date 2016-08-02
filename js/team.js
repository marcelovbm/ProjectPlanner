'use strict';
//FUNCOES RELACIONADAS AO TEAM
var team 	=	{
	listTeam(){
		if (document.getElementById('projectSelected').innerText != "Project Selected") {
			var projetoEscolhido = document.getElementById('projectSelected').innerHTML;
			$.ajax({ //FAZ UM REQUISICAO PARA O ARQUIVO COM LIGACAO AO BANCO DE DADOS
				url: "controller/listTeam.php", //ARQUIVO COM LIGACAO AO BANCO DE DADOS
				type: "POST",
				data: "nameProject=" + projetoEscolhido
			})
			.done(function(msg) {
				document.getElementById('panel-heading').innerHTML = "Team";
				document.getElementById('panel-body').innerHTML = [msg];
				$.ajax({ //FAZ UM REQUISICAO PARA O ARQUIVO COM LIGACAO AO BANCO DE DADOS
					url: "controller/listScrumMaster.php" //ARQUIVO COM LIGACAO AO BANCO DE DADOS
				})
				.done(function(employeeScrumMaster) {
					document.getElementById('inputScrumMaster').innerHTML = employeeScrumMaster;
					$.ajax({ //FAZ UM REQUISICAO PARA O ARQUIVO COM LIGACAO AO BANCO DE DADOS
						url: "controller/listDevelopmentTeam.php" //ARQUIVO COM LIGACAO AO BANCO DE DADOS
					})
					.done(function(msg) {
						document.getElementById('inputDeveloperName').innerHTML = msg;
					})
					.fail(function(){
						console.log('error');
					});
				})
				.fail(function (){
					console.log('error');
				});
			})
			.fail(function(){
				console.log('error');
			});
		} else {
			document.getElementById('notificationText').innerHTML = "Please select a project!";
			$('#notificacoes').modal('show');
		}
	},

	addDevelopmenteTeam() {
		var inputProjectName = document.getElementById('projectSelected').innerHTML;
		var formDevelopmentTeam = $("#cadDevelopmenteTeam").serialize();
		if(formDevelopmentTeam === ""){
      $('#addDevelopmenteTeam').modal('hide');
			alert("You need to select a employee");
		} else {
			var data = 'inputProjectName=' + encodeURIComponent(inputProjectName) + '&' + formDevelopmentTeam;
			$.ajax({ //ENVIA OS VALORES PARA ARQUIVO COM CONEXAO PARA O BANCO DE DADOS
				url: "controller/addDevelopmentTeam.php", //ARQUIVO COM CONEXAO AO BANCO DE DADOS
				type: "POST", //TIPO DE ENVIO
				data: data, //VALORES ENVIADOS
			})
			.done(function(){
				//console.log('success');
				team.listTeam();
			})
			.fail(function(){
				console.log('error');
			});
		}
	},

	addScrumMaster() {
		var inputProjectName = document.getElementById('projectSelected').innerHTML;
		var scrumMaster = $("#cadScrumMaster").serialize();
		if(scrumMaster === ""){
      $('#addScrumMaster').modal('hide');
			alert("You need to select a employee");
		} else {
			var data = 'inputProjectName=' + encodeURIComponent(inputProjectName) + '&' + scrumMaster;
			$.ajax({ //ENVIA OS VALORES PARA ARQUIVO COM CONEXAO PARA O BANCO DE DADOS
				url: "controller/addScrumMaster.php", //ARQUIVO COM CONEXAO AO BANCO DE DADOS
				type: "POST", //TIPO DE ENVIO
				data: data //VALORES ENVIADOS
			})
			.done(function(){
				//console.log('success');
				team.listTeam();
				$('#addScrumMaster').modal('hide');
			})
			.fail(function (msg){
        console.log(msg);
				console.log('error');
			});
		}
	},

	removerEditarProductOwner() { //REMOVE O MODAL PARA EDITAR O PROJETO
		$('#editProductOwner').modal('hide'); //ESCONDE O MODAL COM ID 'editProject'
		$('#editarProductOwner').remove(); //REMOVE A TAG COM ID 'editarProject'
		team.listTeam();
	},

  editProductOwner() {
		var inputProjectName = document.getElementById('projectSelected').innerHTML;
		var productOwner = document.getElementById('inputEditarProductOwner');
    var productOwnerSelected = productOwner.options[productOwner.selectedIndex].value;
		if(productOwnerSelected === ''){
			$('#editProductOwner').modal('hide');
      alert("You need to select a employee");
		}else {
			var data = 'inputProjectName=' + inputProjectName + '&' + 'inputEditarProductOwner=' + productOwnerSelected;
			$.ajax({ //ENVIA OS VALORES PARA ARQUIVO COM CONEXAO PARA O BANCO DE DADOS
				url: "controller/editarProductOwner.php", //ARQUIVO COM CONEXAO AO BANCO DE DADOS
				type: "POST", //TIPO DE ENVIO
				data: data //VALORES ENVIADOS
			})
			.done(function(){
				//console.log('success');
				team.listTeam();
        $('#editProductOwner').modal('hide');
			})
			.fail(function (msg){
				console.log(msg);
			});
		}
	},

	receberEditProductOwner() {
		var inputProjectName = document.getElementById('projectSelected').innerHTML;
		var element = document.getElementById('editProductOwnerBody'); //RECEBE A TAG COM ID 'editarProjectBody'
		$.ajax({ //ENVIA OS VALORES PARA ARQUIVO COM CONEXAO PARA O BANCO DE DADOS
			url: "controller/receberProductOwner.php", //ARQUIVO COM CONEXAO AO BANCO DE DADOS
			type: "POST", //TIPO DE ENVIO
			data: "name=" + inputProjectName //VALORES ENVIADOS
		})
		.done(function(msg) { //RESPOSTA DA CONEXAO COM O ARQUIVO
      //console.log(msg);
			element.innerHTML = [msg]; //INSERE A RESPOSTA EM element
			$('#editProductOwner').modal('show'); //MOSTRA O MODAL COM ID 'editProject'
		})
		.fail(function (){
			console.log('error');
		});
	}
};
