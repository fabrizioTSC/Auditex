<!-- MODAL ENCOGIMIENTO -->
<div class="modal fade" id="modalagrupador" tabindex="-1" aria-labelledby="modalagrupador" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="modalagrupadorlabel">Agrupamiento de partidas</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <form class="modal-body" id="frmagrupador">

            <div class="row">
                <div class="col-md-8">
                    <label for="">Partida Hija:</label>
                    <input type="text" class="form-control form-control-sm" id="txtpartidacopia" required> 
                </div>
                <div class="col-md-4">
                    <label for="">&nbsp;</label>
                    <button class="btn btn-sm btn-block btn-primary" type="submit" >Agrupar</button>
                </div>
            </div>

            <div class="table-responsive mt-2">
                <table class="table table-sm table-bordered table-hover">
                    <thead class="thead-light">
                        <tr>
                            <th class="border-table">Partida</th>
                            <th class="border-table">Operación</th>
                        </tr>
                    </thead>
                    <tbody id="tbodyagrupador">

                    </tbody>
                </table>
            </div>



      </form>

      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Cerrar</button>
        <!-- <button type="button" class="btn btn-primary" id="btnagrupar" >Guardar</button> -->
      </div>
    </div>
  </div>
</div>
