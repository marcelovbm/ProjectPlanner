'use strict';
//FUNCOES RELACIODADAS AO PROJETO
var project = {
	listproject() {
		document.getElementById('panel-heading').innerHTML = "Project"; //INSERE HEADING
		document.getElementById('panel-body').innerHTML = '<table class="table table-condensed" id="tableProject"></table><button type="button" id="addButton" class="btn btn-circle btn-lg" data-toggle="modal" data-target="#new-project">Add</button>'; //INSERE RESPOSTA DO BANCO DE DADOS
		$.ajax({
			url: 'controller/project.php',
			dataType: 'JSON',
			success: function(data){
				//console.log(data);
				$('#tableProject').bootstrapTable({
					data: data,
					singleSelect: true,
					striped: true,
					detailView: true,
					detailFormatter: 'detailFormatter',
					columns: [{
	                    field: 'state',
	                    checkbox: true
	                }, {
	                    field: 'nameProject',
	                    title: 'Name',
	                    align: 'center',
	                    valign: 'middle',
	                    sortable: true
	                }, {
	                    field: 'productOwner',
	                    title: 'Product Owner',
	                    align: 'center',
	                    valign: 'middle',
	                    sortable: true
	                }, {
	                    field: 'projectManager',
	                    title: 'Project Manager',
	                    align: 'center',
	                    valign: 'top',
	                    sortable: true
	                }, {
	                    field: 'data',
	                    title: 'End Date',
	                    align: 'center',
	                    valign: 'middle'
	                }, {
	                    field: 'edit',
	                    title: 'Edit',
	                    align: 'center',
	                    valign: 'middle'
	                }, {
	                    field: 'delete',
	                    title: 'Delete',
	                    align: 'center',
	                    valign: 'middle'
	                }]
				});
				$('#tableProject').bootstrapTable('hideLoading');
				$('#tableProject').on('check.bs.table', function (e, row) {
					project.selectProject(row);
        });
        $('#tableProject').on('uncheck.bs.table', function (){
          document.getElementById('projectSelected').innerHTML = 'Project Selected';
        });
			}
		})
		.done(function(){
			//console.log('success');
			$.ajax({ //FAZ UM REQUISICAO PARA O ARQUIVO COM LIGACAO AO BANCO DE DADOS
				url: "controller/listEmployeeProjectProductOwner.php" //ARQUIVO COM LIGACAO AO BANCO DE DADOS
			})
			.done(function(employeeOwner) {
				document.getElementById('inputProductOwner').innerHTML = employeeOwner;
				$.ajax({ //FAZ UM REQUISICAO PARA O ARQUIVO COM LIGACAO AO BANCO DE DADOS
					url: "controller/listEmployeeProjectProjectManager.php" //ARQUIVO COM LIGACAO AO BANCO DE DADOS
				})
				.done(function(employee) {
					document.getElementById('inputProjectManager').innerHTML = employee;
				})
				.fail(function(){
					console.log('error');
				});
			})
			.fail(function(){
				console.log('error');
			});
		})
		.fail(function(){

			console.log('error');
		});
	},

	selectProject(objProject) { //RECEBE O ID DO PROJETO DA LISTA
		document.getElementById('projectSelected').classList.remove('projectSelectedEmployee');
		document.getElementById('projectSelected').innerHTML = objProject.nameProject; //INSERE A CELULA DA POSICAO 1 NA TAG COM ID 'projectSelected'
	},

	editarProjeto() { //FAZ ALTERACOES NOS DADOS DO PROJETO
		var inputEditProjectName = $("#inputEditProjectName").val();
		var formData = $("#editarProject").serialize();
		var data = 'inputProjectName=' + encodeURIComponent(inputEditProjectName) + '&' + formData;
		$.ajax({ //ENVIA OS VALORES PARA ARQUIVO COM CONEXAO PARA O BANCO DE DADOS
			url: "controller/editarProjeto.php", //ARQUIVO COM CONEXAO AO BANCO DE DADOS
			type: "POST", //TIPO DE ENVIO
			data: data //VALORES ENVIADOS
		})
		.done(function(){
			//console.log('success');
		})
		.fail(function(){
			console.log('error');
		})
		.always(function(){
			project.listproject(); //CHAMA A FUNCAO 'myHeading'
		});
	},

	modalEditarProject(idProject) { //RECEBE O ID DO PROJETO DA LISTA
		var element = document.getElementById('editarProjectBody');
		$.ajax({ //ENVIA UM VALOR PARA O BANCO DE DADOS
			url: "controller/receberEditarProject.php", //ARQUIVO RELACIONADO AO BANCO DE DADOS
			type: "POST", //TIPO DE ENVIO
			data: "name=" + idProject //DADO ENVIADO PARA O ARQUIVO
		}).done(function(msg) { //RESPOSTA DA CONEXAO COM O ARQUIVO
			element.innerHTML = [msg]; //INSERE A RESPOSTA EM element
			$('#editProject').modal('show'); //MOSTRA O MODAL COM ID 'editProject'
		})
		.fail(function(){
			console.log('error');
		});
	},

	deletarProject(idProject) { //RECEBE O ID DO PROJETO QUE PRETENDE SER DELETADO
  	$('#deletar').modal('show'); //MOSTRA O MODAL COM ID 'deleteProject'
  	$(document).ready(function() {
  		$('#deletarYes').click(function() { //QUANDO O BOTAO COM ID 'deletarProjectYes' E CLICADO
  			$.ajax({ //ENVIA VALOR PARA ARQUIVO COM CONEXAO PARA O BANCO DE DADOS
  				url: "controller/deleteProject.php", //ARQUIVO PARA O BANCO DE DADOS
  				type: "POST", //TIPO DE ENVIO
  				data: "name=" + idProject, //CELULAR DA POSICAO 1 E ENVIADA
  				success: function(){
  					project.listproject(); //CHAMA A FUNCAO 'myHeading'
  				}
  			})
  			.done(function(){
  				//console.log('success');
  				document.getElementById('projectSelected').innerHTML = "Project Selected";
  			})
  			.fail(function(){
  				console.log('error');
  			});
  		});
  	});
  },

	removerEditarProject() { //REMOVE O MODAL PARA EDITAR O PROJETO
		$('#editProject').modal('hide'); //ESCONDE O MODAL COM ID 'editProject'
		document.getElementById('editarProject').remove(); //REMOVE A TAG COM ID 'editarProject'
		project.listproject();
	},

	removerClassProject() { //REMOVE AS CLASSES DE ALERT DA DIV E ESCONDE ELA NOVAMENTE
		document.getElementById('myboxProjeto').classList.remove('alert-success');
		document.getElementById('myboxProjeto').classList.add('hide');
		document.getElementById('myboxProjeto').classList.remove('alert-danger');
		document.getElementById('myboxProjeto').classList.add('hide');
		document.getElementById('divInputProjectName').classList.remove('has-error');
		document.getElementById('divInputProductOwner').classList.remove('has-error');
		document.getElementById('divStartDate').classList.remove('has-error');
		document.getElementById('divEndDate').classList.remove('has-error');
		document.getElementById('divInputProjectManager').classList.remove('has-error');
		project.listproject();
		$('#cadProjeto').each(function() { //RESETA OS CAMPOS DO FORMULARIO DE CADASTRO
			this.reset();
		});
	},

	myCallAddProject() { //FUNCAO PARA ADICIONAR UM PROJETO
		//REMOVE AS CLASSES DE ALERT E ERROR DA DIV
		document.getElementById('myboxProjeto').classList.remove('alert-success', 'hide');
		document.getElementById('myboxProjeto').classList.remove('alert-danger', 'hide');
		document.getElementById('divInputProjectName').classList.remove('has-error');
		document.getElementById('divInputProductOwner').classList.remove('has-error');
		document.getElementById('divStartDate').classList.remove('has-error');
		document.getElementById('divEndDate').classList.remove('has-error');
		document.getElementById('inputProjectDescription').classList.remove('has-error');
		document.getElementById('divInputProjectManager').classList.remove('has-error');
		var formData = $('#cadProjeto').serialize(); //VALORES RECEBIDOS PELO FORMULARIO
		$.ajax({ //ENVIA OS VALORES PARA ARQUIVO COM CONEXAO PARA O BANCO DE DADOS
			url: "controller/addProject.php", //ARQUIVO COM CONEXAO AO BANCO DE DADOS
			type: "POST", //TIPO DE ENVIO
			dataType: "html", //TIPO DOS VALORES ENVIADOS
			data: formData //VALORES ENVIADOS
		})
		.done(function(msg) { //RECEBE RESPOSTA APOS OS DADOS SEREM ENVIADOS
			if (msg == "<p><strong>Project Name</strong> não foi inserido!</p>") {
				document.getElementById('divInputProjectName').classList.add('has-error');
				document.getElementById('myboxProjeto').classList.add('alert-danger');
				document.getElementById('myboxProjeto').classList.remove('hide');
				document.getElementById('myboxProjeto').innerHTML = msg;
			} else {
				if (msg == "<p><strong>Product Owner</strong> não foi inserido!</p>") {
					document.getElementById('divInputProductOwner').addClass('has-error');
					document.getElementById('myboxProjeto').classList.add('alert-danger');
					document.getElementById('myboxProjeto').classList.remove('hide');
					document.getElementById('myboxProjeto').innerHTML = msg;
				} else {
					if (msg == "<p><strong>Project Manager</strong> não foi inserido!</p>") {
						document.getElementById('divInputProjectManager').classList.add('has-error');
						document.getElementById('myboxProjeto').classList.add('alert-danger');
						document.getElementById('myboxProjeto').classList.remove('hide');
						document.getElementById('myboxProjeto').innerHTML = msg;
					} else {
						if (msg == "<p><strong>Start date</strong> não foi inserido!</p>") {
							document.getElementById('divStartDate').classList.add('has-error');
							document.getElementById('myboxProjeto').classList.add('alert-danger');
							document.getElementById('myboxProjeto').classList.remove('hide');
							document.getElementById('myboxProjeto').innerHTML = msg;
						} else {
							if (msg == "<p><strong>End date</strong> não foi inserido!</p>") {
								document.getElementById('diveEndtDate').classList.add('has-error');
								document.getElementById('myboxProjeto').classList.add('alert-danger');
								document.getElementById('myboxProjeto').classList.remove('hide');
								document.getElementById('myboxProjeto').innerHTML = msg;
							} else {
								if (msg == "<p><strong>Project já existe!</strong></p>") {
									document.getElementById('myboxProjeto').classList.add('alert-danger');
									document.getElementById('myboxProjeto').classList.remove('hide');
									document.getElementById('myboxProjeto').innerHTML = msg;
								} else {
									if (msg == "<p><strong>Project cadastrado com sucesso!</strong></p>") {
										document.getElementById('myboxProjeto').classList.add('alert-success');
										document.getElementById('myboxProjeto').classList.remove('hide');
										document.getElementById('myboxProjeto').innerHTML = msg;
										$('#cadProjeto').each(function() {
											this.reset();
										});
									}
								}
							}
						}
					}
				}
			}
		})
		.fail(function() {
			console.log('error');
		})
		.always(function(){
			project.listproject();
		});
	}
}
