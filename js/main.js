'use strict';

$(document).ready(function() {
  $.ajax({
	  url: "controller/userNameLogin.php"
	})
	.done(function(msg) {
		if (msg === "erro") {
			window.location.replace("index.html");
		} else {
			document.getElementById('userNameLogin').innerHTML = msg;
      document.getElementById('employee').addEventListener('click', function(){
        employee.listEmployee();
      });
      document.getElementById('criterio').addEventListener('click', function(){
        criterio.listCriterios();
      });
      document.getElementById('project').addEventListener('click', function(){
        document.getElementById('projectSelected').innerText = "Project Selected";
				project.listproject();
      });
      document.getElementById('team').addEventListener('click', function(){
        team.listTeam();
      });
      document.getElementById('backlog').addEventListener('click', function(){
        productBacklog.listProductBacklog();
      });
      document.getElementById('sprint').addEventListener('click', function(){
        sprint.listSprint();
      });
      document.getElementById('bugTraker').addEventListener('click', function(){
        bugTraker.listBugTraker();
      });
      document.getElementById('riscos').addEventListener('click', function(){
        riscos.listRiscos();
      });
      document.getElementById('meetings').addEventListener('click', function(){
        meeting.listMeeting();
				$('.ui.dropdown').dropdown();
      });
      document.getElementById('graphics').addEventListener('click', function(){
        charts.projectCharts();
      });
      document.getElementById('logoout').addEventListener('click', function(){
        $.ajax({
					url: "controller/logout.php"
				})
				.done(function() {
					window.location.replace("http://localhost/projectPlan/index.html");
				})
				.fail(function(){
					console.log('error');
				});
      });
		}
	})
	.fail(function(){
		console.log('error');
	});
});

function projectNotSelected() {
	if (document.getElementById('projectSelected').innerText == "Project Selected") {
		return 1;
	} else {
		return 0;
	}
}

/*FUNCAO RELACINADA A DESABILITACAO DE BACKLOG ITENS FINALIZADOS*/
function stateFormatter(value, row) {
    if (row.statusProductBacklog === "success") {
        return {
        	classes: row.statusProductBacklog,
            disabled: true
        };
    }
    return value;
}

function getTodayDateSprint(){
	var today = new Date();
	var dd = today.getDate();
	var mm = today.getMonth()+1; //January is 0!
	var yyyy = today.getFullYear();
	if(dd<10) {
	    dd='0'+dd;
	}
	if(mm<10) {
	    mm='0'+mm;
	}
	today = yyyy + '-' + mm + '-' + dd;
	return today;
}

function getDateSprintEnd(weeks){
	var time;
	if(weeks === 'inputSprintTime=2'){
		time = new Date(+new Date() + 1.21e+9); //duas semanas em milesegundos
	} else if(weeks === 'inputSprintTime=3'){
		time = new Date(+new Date() + 1.814e+9);
	} else {
		time = new Date(+new Date() + 2.419e+9);
	}
	var dd = time.getDate();
	var mm = time.getMonth()+1; //January is 0!
	var yyyy = time.getFullYear();
	if(dd<10) {
	    dd='0'+dd;
	}
	if(mm<10) {
	    mm='0'+mm;
	}
	time = yyyy + '-' + mm + '-' + dd;
	return time;
}

function detailFormatter(index, row) {
    var html = [];
    $.each(row, function (key, value) {
    	if(key == 'ProductBacklogDescription' || key == 'table_comment'){
    		html.push('<p><b>Description: </b></p><p>' + value + '</p>');
    	}
    });
    return html.join('');
}
