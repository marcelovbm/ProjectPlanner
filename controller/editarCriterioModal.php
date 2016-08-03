<?php

session_start();
include 'connection_mysql.php';
$userName = $_SESSION['userName'];
$inputNameCriterio = $_POST['inputNameCriterio'];

$receberLinha = $mysqli->query("SELECT `criterioName`, `criterioPeso`
									              FROM `Criterios`
									              WHERE  `criterioName` = '$inputNameCriterio'
									              AND `User_email` = '$userName'");

$row = $receberLinha->fetch_array(MYSQLI_ASSOC);

echo '<div class="modal-header btn-primary">
        <button type="button" class="close" onclick="" data-dismiss="modal"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
        <h2 class="modal-title text-center" id="myModalLabel">New Critério</h2>
      </div>
      <div class="modal-body">
        <!-- CAIXA DE ALERTA NO MODAL DE CADASTRO -->
        <div id="myboxCriterio" class="alert alert text-center hide" role="alert"></div>
        <!-- FIM CAIXA DE ALERTA -->
        <!-- FORMULARIO DO MODAL DE CADASTRAR -->
        <form class="form-horizontal" role="form" name="editarCriterio" id="editarCriterio" method="POST">
          <div class="form-group" id="divInputNameCriterio">
            <label for="inputNameCriterio" class="col-xs-2 col-sm-4 control-label">Name</label>
            <div class="col-xs-7 col-sm-5">
              <input value="' . $row['criterioName'] . '" type="text" class="form-control " id="inputNameCriterio" disabled="disabled" name="inputNameCriterio" placeholder="Name" required="" autofocus="">
							</div>
						</div>
            <div class="form-group" id="divInputCriterioPeso">
              <label for="inputCriterioPeso" class="col-xs-2 col-sm-4 control-label">Peso</label>
              <div class="col-xs-7 col-sm-5">
                <select class="form-control" id="inputCriterioPeso" name="inputCriterioPeso">';
if ($row['criterioPeso'] == '1') {
	echo '					<option value="1">1</option>
                  <option value="2">2</option>
                  <option value="3">3</option>
                  <option value="4">4</option>
                  <option value="5">5</option>
                  <option value="6">6</option>
                  <option value="7">7</option>
                  <option value="8">8</option>
                  <option value="9">9</option>
                  <option value="10">10</option>';
} else if ($row['criterioPeso'] == '2') {
	echo '					<option value="2">2</option>
                  <option value="1">1</option>
                  <option value="3">3</option>
                  <option value="4">4</option>
                  <option value="5">5</option>
                  <option value="6">6</option>
                  <option value="7">7</option>
                  <option value="8">8</option>
                  <option value="9">9</option>
                  <option value="10">10</option>';
} else if ($row['criterioPeso'] == '3') {
	echo '					<option value="3">3</option>
                  <option value="1">1</option>
                  <option value="2">2</option>
                  <option value="4">4</option>
                  <option value="5">5</option>
                  <option value="6">6</option>
                  <option value="7">7</option>
                  <option value="8">8</option>
                  <option value="9">9</option>
                  <option value="10">10</option>';
} else if ($row['criterioPeso'] == '4') {
	echo '					<option value="4">4</option>
                  <option value="1">1</option>
                  <option value="2">2</option>
                  <option value="3">3</option>
                  <option value="5">5</option>
                  <option value="6">6</option>
                  <option value="7">7</option>
                  <option value="8">8</option>
                  <option value="9">9</option>
                  <option value="10">10</option>';
} else if ($row['criterioPeso'] == '5') {
	echo '					<option value="5">5</option>
                  <option value="1">1</option>
                  <option value="2">2</option>
                  <option value="3">3</option>
                  <option value="4">4</option>
                  <option value="6">6</option>
                  <option value="7">7</option>
                  <option value="8">8</option>
                  <option value="9">9</option>
                  <option value="10">10</option>';
} else if ($row['criterioPeso'] == '6') {
	echo '					<<option value="6">6</option>
                  <option value="1">1</option>
                  <option value="2">2</option>
                  <option value="3">3</option>
                  <option value="4">4</option>
                  <option value="5">5</option>
                  <option value="7">7</option>
                  <option value="8">8</option>
                  <option value="9">9</option>
                  <option value="10">10</option>';
} else if ($row['criterioPeso'] == '7') {
	echo '					<option value="7">7</option>
                  <option value="1">1</option>
                  <option value="2">2</option>
                  <option value="3">3</option>
                  <option value="4">4</option>
                  <option value="5">5</option>
                  <option value="6">6</option>
                  <option value="8">8</option>
                  <option value="9">9</option>
                  <option value="10">10</option>';
} else if ($row['criterioPeso'] == '8') {
	echo '					<option value="8">8</option>
                  <option value="1">1</option>
                  <option value="2">2</option>
                  <option value="3">3</option>
                  <option value="4">4</option>
                  <option value="5">5</option>
                  <option value="6">6</option>
                  <option value="7">7</option>
                  <option value="9">9</option>
                  <option value="10">10</option>';
} else if ($row['criterioPeso'] == '9') {
	echo '					<option value="9">9</option>
                  <option value="1">1</option>
                  <option value="2">2</option>
                  <option value="3">3</option>
                  <option value="4">4</option>
                  <option value="5">5</option>
                  <option value="6">6</option>
                  <option value="7">7</option>
                  <option value="8">8</option>
                  <option value="10">10</option>';
} else if ($row['criterioPeso'] == '10') {
	echo '					<option value="10">10</option>
                  <option value="1">1</option>
                  <option value="2">2</option>
                  <option value="3">3</option>
                  <option value="4">4</option>
                  <option value="5">5</option>
                  <option value="6">6</option>
                  <option value="7">7</option>
                  <option value="8">8</option>
                  <option value="9">9</option>';
}

echo '          </select>
              </div>
            </div>
          </form>
          <!-- FIM DO FORMULARIO -->
        </div>
        <div class="modal-footer ">
          <button type="button" name="' . $row['criterioName'] . '" id="submit" onclick="criterio.editarCriterio(name);" class="btn btn-primary">Edit</button>
          <button type="button" class="btn btn-danger" data-dismiss="modal">Cancel</button>
        </div>';
$receberLinha->close();
$mysqli->close();
?>
