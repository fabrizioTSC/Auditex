<!-- MODAL LAVADO -->
<div class="modal fade" id="modalfiltros" tabindex="-1" aria-labelledby="modalfiltros" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="modalfiltroslabel">Filtros Para los correos</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body" >

        <form class="row mb-2" id="frmfiltros"> 
            <div class="col-md-10">
                <label for="">Filtro</label>
                <input type="text" class="form-control form-control-sm" id="txtfiltro" required>
            </div>
            <div class="col-md-2">
                <label for="">&nbsp;</label>
                <button class="btn btn-block btn-sm btn-primary" type="submit">
                    <i class="fas fa-save"></i>
                </button>
            </div>
        </form>


        <table class="table table-sm table-bordered table-hover text-center">
            <thead class="thead-light">
                <tr>
                    <th>Filtro</th>
                    <th>Eliminar</th>
                </tr>
            </thead>
            <tbody  id="tbodyfiltros">
            </tbody>
        </table>


      </div>

        

      

      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Cerrar</button>
        <!-- <button type="button" class="btn btn-primary" id="btnguardarlavada" >Guardar</button>   -->
      </div>
    </div>
  </div>
</div>
