<?php

session_start();
include 'connection_mysql.php';


echo '<div class="modal-header btn-primary">
        <button type="button" class="close" onclick="project.removerClassProject();" data-dismiss="modal"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
        <h2 class="modal-title text-center" id="myModalLabel">New Project</h2>
      </div>
      <div class="modal-body">
      <!-- CAIXA DE ALERTA NO MODAL DE CADASTRO -->
      <div id="myboxProjeto" class="alert text-center hide" role="alert"></div>
        <!-- FIM CAIXA DE ALERTA -->
        <!-- FORMULARIO DO MODAL DE CADASTRAR -->
          <form class="form-inline" role="form" method="POST">
						<div class="form-group" id="divInputBackLogName">
							<label for="inputBackLogName" class="col-xs-2 col-sm-4 control-label">Item Name</label>
							<div class="input-group-addon">$</div>
              <div class="input-group-addon">.00</div>
              <select class="form-control">
                <option>1</option>
                <option>2</option>
                <option>3</option>
                <option>4</option>
                <option>5</option>
              </select>
						</div>
					</form>
					<!-- FIM DO FORMULARIO -->
				</div>
				<div class="modal-footer ">
					<button type="button" class="btn btn-primary btn-lg" name="" onclick="project.addAvaliacao(name);">Edit</button>
					<button type="button" class="btn btn-danger btn-lg" data-dismiss="modal">Cancel</button>
				</div>';


?>
