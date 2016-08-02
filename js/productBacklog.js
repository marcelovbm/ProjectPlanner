'use strict';

//FUNCOES RELACIONADAS AO BACK LOG
var productBacklog 	=	{
	listProductBacklog(){
		if (document.getElementById('projectSelected').innerText != "Project Selected") {
			$(".panel").removeClass("hide");
			document.getElementById('panel-heading').innerHTML = "Product Backlog"; //INSERE HEADING
			$.ajax({
				url: 'controller/backlog.php',
				dataType: 'JSON',
				type: 'POST',
				data: 'nameProject=' + document.getElementById('projectSelected').innerHTML,
				success: function(data){
          //console.log(data);
          if(data.length != 0){
            if(data[0].edit === '<button type="button" class="btn btn-default btn-circle" data-toggle="modal" disabled><i class="material-icons list-icons" aria-hidden="true">mode_edit</i></button>'){
              document.getElementById('panel-body').innerHTML = '<table class="table table-condensed" id="tableBacklog"></table><button id="addButton" class="btn btn-circle btn-lg" data-toggle="modal" disabled>Add</button><button type="button" id="finalizeButton" name="finalizeButton" class="btn btn-circle btn-lg" disabled>Start Sprint</button>';
            }else{
              document.getElementById('panel-body').innerHTML = '<table class="table table-condensed" id="tableBacklog"></table><button type="button" id="addButton" class="btn btn-circle btn-lg" data-toggle="modal" data-target="#new-backLog">Add</button><button id="finalizeButton" name="finalizeButton" class="btn btn-circle btn-lg" onclick="productBacklog.addToSprint();">Start Sprint</button>';
            }
          }else{
            document.getElementById('panel-body').innerHTML = '<table class="table table-condensed" id="tableBacklog"></table><button type="button" id="addButton" class="btn btn-circle btn-lg" data-toggle="modal" data-target="#new-backLog">Add</button><button id="finalizeButton" name="finalizeButton" class="btn btn-circle btn-lg" onclick="productBacklog.addToSprint();">Start Sprint</button>';
          }
					$('#tableBacklog').bootstrapTable({
						data: 		data,
						detailView: true,
						detailFormatter: 'detailFormatter',
						rowStyle: 	function(row, index) {
										//console.log(row, index);
										return {
											classes: data[index].statusProductBacklog,
										};
							        },
						columns: 	[{
                					field: 'state',
                					checkbox: true,
                					formatter: 'stateFormatter',
              				},{
                    			field: 'productBacklogItem',
                    			title: 'Name',
                    			align: 'center',
                    			valign: 'middle',
                    			sortable: true
                			}, {
                    			field: 'PlanningPoker',
                    			title: 'Planning Poker',
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
					$('#tableBacklog').bootstrapTable('hideLoading');
				}
			})
			.done(function(){
				//console.log('success');
			})
			.fail(function(){
				console.log('erro');
			});
		} else {
			document.getElementById('notificationText').innerHTML = "Please select a project!";
			$('#notificacoes').modal('show');
		}
	},

	clearModalBackLog() {
		$('#cadBackLog').each(function() { //RESETA OS CAMPOS DO FORMULARIO DE CADASTRO
			this.reset();
		});
		productBacklog.listProductBacklog();
	},

	changeStatusBackLog(novoStatus, idBackLog) {
		var data = 'inputBackLogName=' + encodeURIComponent(idBackLog) + '&' + 'status=' + encodeURIComponent(novoStatus);
		$.ajax({ //ENVIA OS VALORES PARA ARQUIVO COM CONEXAO PARA O BANCO DE DADOS
			url: "controller/alteraStatusBackLog.php", //ARQUIVO COM CONEXAO AO BANCO DE DADOS
			type: "POST", //TIPO DE ENVIO
			data: data //VALORES ENVIADOS
		})
		.done(function(){
			//console.log('success');
			productBacklog.listProductBacklog();
		})
		.fail(function(){
			console.log('error');
		});
	},

	addBackLog() {
		var inputProjectName = document.getElementById('projectSelected').innerHTML;
		var formData = $("#cadBackLog").serialize(); //VALORES RECEBIDOS PELO FORMULARIO
		var data = 'inputProjectName=' + encodeURIComponent(inputProjectName) + '&' + formData;
		$.ajax({ //ENVIA OS VALORES PARA ARQUIVO COM CONEXAO PARA O BANCO DE DADOS
			url: "controller/addBacklog.php", //ARQUIVO COM CONEXAO AO BANCO DE DADOS
			type: "POST", //TIPO DE ENVIO
			dataType: "html", //TIPO DOS VALORES ENVIADOS
			data: data //VALORES ENVIADOS
		})
		.done(function(){
			//console.log('success');
			productBacklog.listProductBacklog();
			$('#cadBackLog').each(function() { //RESETA OS CAMPOS DO FORMULARIO DE CADASTRO
				this.reset();
			});
		})
		.fail(function(){
			console.log('error');
		});
	},

	editarBacklogModal(name) {
		var inputProjectName = document.getElementById('projectSelected').innerHTML;
		var data = 'bakclogName=' + encodeURIComponent(name) + '&' + 'inputProjectName=' + encodeURIComponent(inputProjectName);
		$.ajax({
				url: 'controller/editarBacklogModal.php',
				type: 'POST',
				data: data,
			})
			.done(function(msg) {
				document.getElementById('editarBacklog').innerHTML = msg;
				$('#edit-backLog').modal('show'); //MOSTRA O MODAL COM ID 'editProject'
			})
			.fail(function() {
				console.log("error");
			});
	},

	editBacklog(name) {
		var inputProjectName = document.getElementById('projectSelected').innerHTML;
		var editBackLog = $("#editBackLog").serialize();
		var data = 'inputProjectName=' + encodeURIComponent(inputProjectName) + '&' + 'inputBackLogName=' + encodeURIComponent(name) + '&' + editBackLog;
		$.ajax({ //ENVIA OS VALORES PARA ARQUIVO COM CONEXAO PARA O BANCO DE DADOS
				url: "controller/editarBacklog.php", //ARQUIVO COM CONEXAO AO BANCO DE DADOS
				type: "POST", //TIPO DE ENVIO
				data: data //VALORES ENVIADOS
			})
			.done(function() {
				//console.log("success");
				productBacklog.listProductBacklog();
				$('#edit-backLog').modal('hide');
			})
			.fail(function() {
				console.log("error");
			});
	},

	addToSprint() {
		//console.log($('#tableBacklog').bootstrapTable('getSelections').length);
		//console.log(this.idBacklogSelecionado);
		var inputProjectName = document.getElementById('projectSelected').innerHTML;
		if($('#tableBacklog').bootstrapTable('getSelections').length === 0){
			document.getElementById('notificationText').innerHTML = "You need to select an item!";
			$("#notificacoes").modal("show");
		} else {
			var projetoEscolhido = document.getElementById('projectSelected').innerHTML;
			$.ajax({
				url: 'controller/verificarSprint.php',
				type: 'POST',
				data: {inputProjectName: projetoEscolhido},
			})
			.done(function(msg) {
				if(msg === 'true '){
					document.getElementById('notificationText').innerHTML = 'Sprint already started!';
					$("#notificacoes").modal("show");
				} else {
					$('#new-timeSprint').modal('show');
					document.getElementById('submitSprintTime').onclick = function(){
						var sprintTime = $('#cadTimeSprint').serialize();
						var today = getTodayDateSprint();
						var end = getDateSprintEnd(sprintTime);
						var sprintTimeUpdate = 'inputProjectName=' + encodeURIComponent(inputProjectName) + '&' + sprintTime + '&inputTodaySprint=' + encodeURIComponent(today) + '&inputEndSprint=' + encodeURIComponent(end);
						$.ajax({
							url: 'controller/updateSprintTime.php',
							type: 'POST',
							data: sprintTimeUpdate
						})
						.done(function(){
							//console.log('success');
							$('#tableBacklog').bootstrapTable('getSelections').forEach(function (element) {
								var teste = 'inputProjectName=' + encodeURIComponent(inputProjectName) + '&' + 'productBacklogcolItem=' + encodeURIComponent(element.productBacklogItem);
								$.ajax({
									url: 'controller/addToSprint.php',
									type: 'POST',
									data: teste
								})
								.done(function() {
									//console.log("success");
									var status = 'inputProjectName=' + encodeURIComponent(inputProjectName);
									$.ajax({
										url: 'controller/statusSprint.php',
										type: 'POST',
										data: status
									})
									.done(function() {
										//console.log("success");
										//console.log(productBacklog.idBacklogSelecionado);
									})
									.fail(function() {
										console.log("error");
									});
								})
								.fail(function() {
									console.log("error");
								});
							});
							productBacklog.listProductBacklog();
							$('#new-timeSprint').modal('hide');
						})
						.fail(function(){
							console.log('error');
						});
					};
				}
			})
			.fail(function() {
				console.log("error");
			});
		}
	},

	deleteBacklogItem(idBacklog) {
		var inputProjectName = document.getElementById('projectSelected').innerHTML;
		var Row = document.getElementById(idBacklog);
		var Cell = Row.closest('tr');
		var data = 'inputProjectName=' + encodeURIComponent(inputProjectName) + '&' + 'keyBacklog=' + encodeURIComponent(idBacklog);
		if (Cell.className == 'warning' || Cell.className == 'success') {
			alert("The item was used!");
		} else {
			$('#deletar').modal('show'); //MOSTRA O MODAL COM ID 'deleteProject'
			$(document).ready(function() {
				$("#deletarYes").click(function() { //QUANDO O BOTAO COM ID 'deletarProjectYes' E CLICADO
					$.ajax({
						url: 'controller/deleteBacklogItem.php',
						type: 'POST',
						data: data
					})
					.done(function() {
						//console.log("success");
						productBacklog.listProductBacklog();
					})
					.fail(function() {
						console.log("error");
					});
				});
			});
		}
	}
};
