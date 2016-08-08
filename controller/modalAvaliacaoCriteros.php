<?php

session_start();
include 'connection_mysql.php';

$userName = $_SESSION['userName'];
$projectName = $_POST['name'];
$count = 1;

echo '<div class="modal-header btn-primary">
        <button type="button" class="close" onclick="project.removerClassProject();" data-dismiss="modal"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
        <h2 class="modal-title text-center" id="myModalLabel">Criterios</h2>
      </div>
      <div class="modal-body">
        <!-- CAIXA DE ALERTA NO MODAL DE CADASTRO -->
        <div id="myboxProjeto" class="alert text-center hide" role="alert"></div>
        <!-- FIM CAIXA DE ALERTA -->
        <!-- FORMULARIO DO MODAL DE CADASTRAR -->
        <form class="form-inline" role="form" method="POST" id="addAvaliacaoCriterio" name="addAvaliacaoCriterio">';

$recebeTabela = $mysqli->query("SELECT Criterios_criterioName, criterioAvaliacao
  FROM Project_has_Criterios
  WHERE Project_User_email = '$userName'
  AND Project_NameProject = '$projectName'");

if ($recebeTabela->num_rows > 0) {
  while($row = $recebeTabela->fetch_array(MYSQLI_ASSOC)){
    echo '<div class="form-group" id="divInputCriterio'.$count.'" name="divInputCriterio'.$count.'">
            <label class="sr-only" for="inputCriterio'.$count.'"></label>
            <div class="input-group">
              <div class="input-group-addon">'.$row['Criterios_criterioName'].'</div>';
    $nome = $row['Criterios_criterioName'];
    $tabela = $mysqli->query("SELECT criterioPeso
      FROM Criterios
      WHERE User_email = '$userName'
      AND criterioName = '$nome'");
    $rowNome = $tabela->fetch_array(MYSQLI_ASSOC);
    echo '    <div class="input-group-addon">'.$rowNome['criterioPeso'].'</div>';
    if ($row['criterioAvaliacao'] == 'Alto') {
      echo '  <select class="form-control" id="'.$count.'" name="'.$row['Criterios_criterioName'].'">
                <option value="Alto">Alto</option>
                <option value="Medio">Medio</option>
                <option value="Baixo">Baixo</option>
              </select>';
    } else if ($row['criterioAvaliacao'] == 'Medio') {
      echo '  <select class="form-control" id="inputCriterio'.$count.'" name="'.$row['Criterios_criterioName'].'">
                <option value="Medio">Medio</option>
                <option value="Alto">Alto</option>
                <option value="Baixo">Baixo</option>
              </select>';
    } else if ($row['criterioAvaliacao'] == 'Baixo') {
      echo '  <select class="form-control" id="inputCriterio'.$count.'" name="'.$row['Criterios_criterioName'].'">
                <option value="Baixo">Baixo</option>
                <option value="Alto">Alto</option>
                <option value="Medio">Medio</option>
              </select>';
    } else if ($row['criterioAvaliacao'] == NULL) {
      echo '  <select class="form-control" id="inputCriterio'.$count.'" name="'.$row['Criterios_criterioName'].'">
                <option selected value=""> -- select an option -- </option>
                <option value="Alto">Alto</option>
                <option value="Medio">Medio</option>
                <option value="Baixo">Baixo</option>
              </select>';
    }
    echo '  </div>
          </div>';
    $count += 1;
  }
}
echo '	</form>
				<!-- FIM DO FORMULARIO -->
			</div>
			<div class="modal-footer">
				<button type="button" class="btn btn-primary" name="'.$projectName.'" onclick="project.addAvaliacaoCriterio(name);">Ok</button>
				<button type="button" class="btn btn-danger" data-dismiss="modal">Cancel</button>
			</div>';
?>
