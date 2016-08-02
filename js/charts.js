'use strict';

var charts 	=	{
	projectCharts(){
		var projetoEscolhido = document.getElementById('projectSelected').innerHTML;
		$.ajax({
			url: 'controller/verifyStatusSprint.php',
			type: 'POST',
			data: {projectSelected: projetoEscolhido}
		})
		.done(function(msg) {
			//console.log("success");
			console.log(msg);
			if(msg === 'started'){
				$.ajax({
					url: 'controller/backlogItensValues.php',
					type: 'POST',
					dataType: 'JSON',
					data: {projectSelected: projetoEscolhido},
				})
				.done( function( msg ) {
					console.log(msg);
					var pointsTotal = 0;
					var timeDiff;
					var timeDiffDone;
					var dados = [];
					//DATA DE INICIO DA SPRINT
					var date1 = new Date( msg[0].SprintStarted );
					//DATA DE FIM DA SPRINT
					var date2 = new Date( msg[0].SprintTime );
					//TEMPO TOTAL
					timeDiff = Math.abs( date2.getTime() - date1.getTime() );
					//INTERVALO ENTRE AS DATAS
					var diffDays = Math.ceil( timeDiff / (1000 * 3600 * 24) );
					//ESTIMATIVA DA QUANTIDADE DE PONTOS POR DIA
					msg.forEach( function( element ) {
						//SOMA A ESTIMATIVA DE TODOS OS ITENS
						pointsTotal += parseInt( element.PlanningPoker );
					});
					var expectation = pointsTotal / ( diffDays - 1 );
					var pointsToDo = pointsTotal;
					var pontoToDo;
					//ARRAY PARA OS VALORES RELACIONADOS AO 'TO DO'
					for(var i = 1; i <= diffDays; i++){
						if( pointsToDo < 0 ) {
							pontoToDo = [i, 0];
						} else {
							pontoToDo = [i, pointsToDo];
						}
						dados.push(pontoToDo);
						pointsToDo = pointsToDo - expectation;
					}
					dados[0].splice(2,0,pointsTotal);
					//console.log(dados);
					var diffDaysDone = Math.ceil( timeDiffDone / (1000 * 3600 * 24) );
					var pontoDone;
					var countSuccess = 1;
					msg.forEach( function( element ) {
						//CASO O ITEM TENHA SUCCESS
						if( element.statusProductBacklog === 'success' ){
							//DATA DE INICIO DA SPRINT
							var dateDone1 = new Date( element.SprintStarted );
							//DATA DE FIM DA SPRINT
							var dateDone2 = new Date( element.productBacklogDate );
							//TEMPO TOTAL
							timeDiffDone = Math.abs( date2.getTime() - date1.getTime() );
							//INTERVALO ENTRE AS DATAS
							var diffDaysDone = Math.ceil( timeDiffDone / (1000 * 3600 * 24) );
							//PLANNING POKER DO ELEMENT
							var pointsDone = pointsTotal - parseInt(element.PlanningPoker);

							dados[countSuccess].splice(2,0,pointsDone);
							countSuccess++;
						}
					});
					console.log(dados);
					for(var i = countSuccess; i < dados.length; i++ ){
						dados[i].splice(2,0,NaN);
					}
					// Define the chart to be drawn.
			      	var data = new google.visualization.DataTable();
			      	data.addColumn('number', 'Day');
			      	data.addColumn('number', 'Expectation');
							data.addColumn('number', 'Done');
			      	data.addRows(dados);
			      	var options = {
				        chart: {
			        	  	title: 'Graphic about Sprint'
			        	},
			        	height: 500,
			      	};
				    var chart = new google.charts.Line(document.getElementById('panel-body'));
			    	chart.draw(data, options);
			    	document.getElementById('panel-heading').innerHTML = 'Graphic';
				})
				.fail(function() {
					console.log("error");
				});
			}else{
				document.getElementById('notificationText').innerHTML = "You need to start a sprint!";
				$('#notificacoes').modal('show');
			}
		})
		.fail(function() {
			console.log("error");
		});
	}
};
