'use strict';

//FUNCOES RELACIONADAS AO EMPLOYEE
var employee 	= 	{
	listEmployee(){
		document.getElementById('panel-heading').innerHTML = "Employee"; //INSERE HEADING
		document.getElementById('panel-body').innerHTML = '<table  id="tableEmployee" class="table table-condensed table-striped"></table><button type="button" id="addButton" class="btn btn-circle btn-lg" data-toggle="modal" data-target="#new-employee">Add</button>'; //INSERE RESPOSTA DO BANCO DE DADOS
		$.ajax({
			url: 'controller/employee.php',
			dataType: 'JSON',
			success: function( data ) {
				//console.log(data);
				$('#tableEmployee').bootstrapTable({
					data: data,
					striped: true,
					columns: [{
	                    field: 'employeeName',
	                    title: 'Name',
	                    align: 'center',
	                    valign: 'middle',
	                    sortable: true
	                }, {
	                    field: 'employeeEmail',
	                    title: 'Email',
	                    align: 'center',
	                    valign: 'middle',
	                    sortable: true,
	                }, {
	                    field: 'employeeFunction',
	                    title: 'Function',
	                    align: 'center',
	                    valign: 'top',
	                    sortable: true,
	                }, {
	                    field: 'Project_NameProject',
	                    title: 'Project',
	                    align: 'center',
	                    valign: 'middle',
	                    sortable: true,
	                }, {
	                    field: 'edit',
	                    title: 'Edit',
	                    align: 'center',
	                    valign: 'middle',
	                }, {
	                    field: 'delete',
	                    title: 'Delete',
	                    align: 'center',
	                    valign: 'middle',
	                }]
				});
				$('#tableEmployee').bootstrapTable('hideLoading');
			}
		})
		.done(function(){
			//console.log('success');
		})
		.fail(function(){
			console.log('error');
		});
	},

	addEmployee() {
		var formData = $("#cadEmployee").serialize(); //VALORES RECEBIDOS PELO FORMULARIO
		var data = formData;
		$.ajax({ //ENVIA OS VALORES PARA ARQUIVO COM CONEXAO PARA O BANCO DE DADOS
			url: "controller/addEmployee.php", //ARQUIVO COM CONEXAO AO BANCO DE DADOS
			type: "POST", //TIPO DE ENVIO
			dataType: "html", //TIPO DOS VALORES ENVIADOS
			data: data //VALORES ENVIADOS
		})
		.done(function(){
			//console.log('success');
			$('#cadEmployee').each(function() { //RESETA OS CAMPOS DO FORMULARIO DE CADASTRO
				this.reset();
			});
		})
		.fail(function(){
			console.log('error');
		})
		.always(function(){
			employee.listEmployee();
		});
	},

	clearModalEmployee() {
		$('#cadEmployee').each(function() { //RESETA OS CAMPOS DO FORMULARIO DE CADASTRO
			this.reset();
		});
	},

	modalEditarEmployee(id) {
		var element = document.getElementById('editarEmployeeBody'); //RECEBE A TAG COM ID 'editarProjectBody'
		$.ajax({ //ENVIA UM VALOR PARA O BANCO DE DADOS
			url: "controller/editarEmployeeModal.php", //ARQUIVO RELACIONADO AO BANCO DE DADOS
			type: "POST", //TIPO DE ENVIO
			data: "employeeEmail=" + id //DADO ENVIADO PARA O ARQUIVO
		})
		.done(function(msg) { //RESPOSTA DA CONEXAO COM O ARQUIVO
			//console.log('success');
			element.innerHTML = [msg]; //INSERE A RESPOSTA EM element
			$('#editEmployee').modal('show'); //MOSTRA O MODAL COM ID 'editProject'
		})
		.fail(function(){
			console.log('error');
		});
	},

	editarEmployee() {
		var formData = $("#eidtarEmployee").serialize();
		$.ajax({ //ENVIA OS VALORES PARA ARQUIVO COM CONEXAO PARA O BANCO DE DADOS
			url: "controller/editarEmployee.php", //ARQUIVO COM CONEXAO AO BANCO DE DADOS
			type: "POST", //TIPO DE ENVIO
			data: formData, //VALORES ENVIADOS
		})
		.done(function(msg) {
			//console.log('success');
			if (msg === 'Usuário está relacionado a um projeto!') {
				document.getElementById('myboxEditarEmployee').innerHTML = '<p> User is already in a <project!></project!></p>';
				document.getElementById('myboxEditarEmployee').classList.add('alert-danger');
				document.getElementById('myboxEditarEmployee').classList.remove('hide');
			}else {
				$('#editEmployee').modal('hide'); //ESCONDER O MODAL COM ID 'editProject'
				employee.listEmployee();
			}
		})
		.fail(function(){
			console.log('error');
		});
	},

	deleteEmployee(id){
		$('#deletar').modal('show'); //MOSTRA O MODAL COM ID 'deleteProject'
		$(document).ready(function() {
			$("#deletarYes").click(function() { //QUANDO O BOTAO COM ID 'deletarProjectYes' E CLICADO
				$.ajax({ //ENVIA VALOR PARA ARQUIVO COM CONEXAO PARA O BANCO DE DADOS
					url: "controller/deleteEmployee.php", //ARQUIVO PARA O BANCO DE DADOS
					type: "POST", //TIPO DE ENVIO
					data: "employeeEmail=" + id //CELULAR DA POSICAO 1 E ENVIADA
				})
				.done(function(msg){
					if(msg == 'User is in a project!'){
						document.getElementById('notificationText').innerText = msg;
						document.getElementById('notificationText').margin = 0;
						$('#notificacoes').modal('show');
					}else{
						console.log(msg);
						employee.listEmployee();
					}
				})
				.fail(function(){
					console.log('error');
				});
			});
		});
	}
};
