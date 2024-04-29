<!-- MODAL ENCOGIMIENTO -->
<div class="modal fade" id="modaldefectos" tabindex="-1" aria-labelledby="modaldefectos" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="modaldefectoslabel">Defectos por Paquete</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <form class="modal-body" id="frmdefectos">

            <div class="row">
                <div class="col-md-8">
                    <label>Defectos</label>
                    <select name="" id="cbodefectos" class="custom-select custom-select-sm select2" style="width: 100%;"></select>
                </div>
                <div class="col-md-2">
                    <label for="">Cantidad</label>
                    <input type="number" class="form-control form-control-sm" id="txtcantidaddefectos" min="1" value="1">
                </div>
                <div class="col-md-2">
                    <label for="">&nbsp;</label>
                    <button class="btn btn-sm btn-block btn-primary"> <i class="fas fa-save"></i> </button>
                </div>
            </div>

            <table class="table table-bordered table-hover table-sm mt-3 text-center">   
                <thead class="thead-light">
                    <tr>    
                        <th>Defecto</th>
                        <th>Cantidad</th>
                        <th>Op</th>
                    </tr>
                </thead>
                <tbody id="tbodydefectos">

                </tbody>
            </table>

      </form>

      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Cerrar</button>
        <!-- <button type="button" class="btn btn-primary" id="btnguardarencogimiento" >Guardar</button> -->
      </div>
    </div>
  </div>
</div>
