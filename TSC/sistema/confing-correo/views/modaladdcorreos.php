<!-- MODAL LAVADO -->
<div class="modal fade" id="modaladdcorreos" tabindex="-1" aria-labelledby="modaladdcorreos" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="modaladdcorreoslabel">Agregar correos segun tipo de envio</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body" >

        <form class="row mb-2" id="frmcorreos"> 
            <div class="col-md-6">
                <label for="">Correos</label>
                <select name="" id="cbocorreos" class="custom-select custom-select-sm select2" style="width: 100%;"></select>
            </div>
            <div class="col-md-4">
                <label for="">Correos</label>
                <select name="" id="cbotipocorreo" class="custom-select custom-select-sm" >
                    <option value="R">DESTINATARIO</option>
                    <option value="C">COPIADO</option>
                    <option value="E">REMITENTE</option>
                </select>
            </div>
            <div class="col-md-2">
                <label for="">&nbsp;</label>
                <button class="btn btn-block btn-sm btn-primary" type="submit">
                    <i class="fas fa-save"></i>
                </button>
            </div>
        </form>



      </div>      

      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Cerrar</button>
        <!-- <button type="button" class="btn btn-primary" id="btnguardarlavada" >Guardar</button>   -->
      </div>
    </div>
  </div>
</div>
