'use strict';
//FUNCOES RELACIODADAS AO PROJETO
var criterio = {
	listCriterios() {
		document.getElementById('panel-heading').innerHTML = "Critérios do Projeto"; //INSERE HEADING
		document.getElementById('panel-body').innerHTML = '<table class="table table-condensed" id="tableCriterios"></table><button type="button" id="addButton" class="btn btn-circle btn-lg" data-toggle="modal" data-target="#new-criterio">Add</button>';
    $.ajax({
			url: 'controller/criterios.php',
			dataType: 'JSON',
			success: function(data){
				//console.log(data);
				$('#tableCriterios').bootstrapTable({
					data: data,
					striped: true,
					columns: [{
	                    field: 'criterioName',
	                    title: 'Title',
	                    align: 'center',
	                    valign: 'middle',
	                    sortable: true
	                }, {
	                    field: 'criterioPeso',
	                    title: 'Peso',
	                    align: 'center',
	                    valign: 'middle',
	                    sortable: true
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
        $('#tableCriterios').bootstrapTable('hideLoading');
			}
		})
		.done(function(){
			//console.log('success');
		})
		.fail(function(){
			console.log('error');
		});
	},

  addCriterio(){
    var formData = $("#cadCriterio").serialize(); //VALORES RECEBIDOS PELO FORMULARIO
		var data = formData;
		$.ajax({ //ENVIA OS VALORES PARA ARQUIVO COM CONEXAO PARA O BANCO DE DADOS
			url: "controller/addCriterio.php", //ARQUIVO COM CONEXAO AO BANCO DE DADOS
			type: "POST", //TIPO DE ENVIO
			dataType: "html", //TIPO DOS VALORES ENVIADOS
			data: data //VALORES ENVIADOS
		})
		.done(function(){
			//console.log('success');
			$('#cadCriterio').each(function() { //RESETA OS CAMPOS DO FORMULARIO DE CADASTRO
				this.reset();
			});
		})
		.fail(function(){
			console.log('error');
		})
		.always(function(){
			criterio.listCriterios();
		});
  },

	clearModalCriterio() {
		$('#cadCriterio').each(function() { //RESETA OS CAMPOS DO FORMULARIO DE CADASTRO
			this.reset();
		});
	},

	modalEditarCriterio(id) {
		var element = document.getElementById('editar-Criterio'); //RECEBE A TAG COM ID 'editarProjectBody'
		$.ajax({ //ENVIA UM VALOR PARA O BANCO DE DADOS
			url: "controller/editarCriterioModal.php", //ARQUIVO RELACIONADO AO BANCO DE DADOS
			type: "POST", //TIPO DE ENVIO
			data: "inputNameCriterio=" + id //DADO ENVIADO PARA O ARQUIVO
		})
		.done(function(msg) { //RESPOSTA DA CONEXAO COM O ARQUIVO
			//console.log('success');
			element.innerHTML = [msg]; //INSERE A RESPOSTA EM element
			$('#edit-criterio').modal('show'); //MOSTRA O MODAL COM ID 'editProject'
		})
		.fail(function(){
			console.log('error');
		});
	},

	editarCriterio(name) {
		var editBackLog = $("#editarCriterio").serialize();
		var data = 'inputNameCriterio=' + encodeURIComponent(name) + '&' + editBackLog;
		$.ajax({ //ENVIA OS VALORES PARA ARQUIVO COM CONEXAO PARA O BANCO DE DADOS
				url: "controller/editarCriterio.php", //ARQUIVO COM CONEXAO AO BANCO DE DADOS
				type: "POST", //TIPO DE ENVIO
				data: data //VALORES ENVIADOS
			})
			.done(function() {
				//console.log("success");
				criterio.listCriterios();
				$('#edit-criterio').modal('hide');
			})
			.fail(function() {
				console.log("error");
			});
	},

	deleteCriterio(id){
		$('#deletar').modal('show'); //MOSTRA O MODAL COM ID 'deleteProject'
		$(document).ready(function() {
			$("#deletarYes").click(function() { //QUANDO O BOTAO COM ID 'deletarProjectYes' E CLICADO
				$.ajax({ //ENVIA VALOR PARA ARQUIVO COM CONEXAO PARA O BANCO DE DADOS
					url: "controller/deleteCriterio.php", //ARQUIVO PARA O BANCO DE DADOS
					type: "POST", //TIPO DE ENVIO
					data: "inputNameCriterio=" + id //CELULAR DA POSICAO 1 E ENVIADA
				})
				.done(function(msg){
					console.log(msg);
					criterio.listCriterios();
				})
				.fail(function(){
					console.log('error');
				});
			});
		});
	}

}
