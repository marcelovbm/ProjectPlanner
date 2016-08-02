'use strict';

//FUNCOES RELACIONADAS A SPRINT
var sprint 	=	{
	listSprint(){
		var projetoEscolhido = document.getElementById('projectSelected').innerText;
		if (projetoEscolhido != "Project Selected") {
			$.ajax({
				url: 'controller/sprint.php',
				type: 'POST',
				dataType: 'html',
				data: 'nameProject=' + projetoEscolhido
			})
			.done(function(msg) {
				//alert(msg);
				document.getElementById('panel-heading').innerHTML = "Sprint"; //INSERE HEADING
				document.getElementById('panel-body').innerHTML = msg;
				$(".cardSprint").draggable({
					revert: "invalid",
			    snap: ".bodySprint",
			    stack: ".cardSprint",
			    containment: "document"
				});
				$(".bodySprint").droppable({
					tolerance: 'pointer',
	        drop: function(event,ui) {
            var id = $(ui.draggable).attr('id');
            //var toy = $(ui.draggable).html();
            var box = $(this).attr('id');
            var data = 'inputProjectName=' + encodeURIComponent(projetoEscolhido) + '&' + 'id=' + encodeURIComponent(id) + '&' + 'box=' + encodeURIComponent(box);
            $.ajax({
            	url: 'controller/changeKanban.php',
            	type: 'POST',
            	data: data
            })
            .done(function() {
            	/*$(ui.draggable).remove();
              $('#' + box).append('<li class = "cardSprint" id="' + id + '"><a>' + toy + '</a></li>');
              $('li#' + id).draggable();*/
              sprint.listSprint();
            	//console.log("success");
            })
            .fail(function() {
            	console.log("error");
            });
	        }
				});
				//console.log("success");
			})
			.fail(function() {
				console.log("error");
			});
		} else {
			document.getElementById('notificationText').innerHTML = "Please select a project!";
			$('#notificacoes').modal('show');
		}
	},

	finalizeSprint(idSprint){
		// body...
		var inputProjectName = document.getElementById('projectSelected').innerHTML;
		var data = 'idSprint=' + encodeURIComponent(idSprint) + '&' + 'inputProjectName=' + encodeURIComponent(inputProjectName);
		$.ajax({
			url: 'controller/finalizeSprint.php',
			type: 'POST',
			data: data
		})
		.done(function() {
			//console.log(msg);
			sprint.listSprint();
		})
		.fail(function() {
			console.log("error");
		});
	}
};
