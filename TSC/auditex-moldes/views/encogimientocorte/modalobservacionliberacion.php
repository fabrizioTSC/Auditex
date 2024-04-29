<div class="modal fade" id="modalobservacionliberacion">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="">OBSERVACIÓN DE LIBERACIÓN</h5>
                <button type="button" class="close" data-mdb-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>

            <div class="modal-body">
                <form class="row justify-content-md-center" id="frmobservacionliberacion">

                    <div class="col-12 form-group">
                        <label for="">Ingrese observación:</label>
                        <textarea rows="5" class="form-control form-control-sm" id="txtobservacionliberacion" required></textarea>
                    </div>



                    <div class="input-group mb-3 col-12 ocultarobservacion">
                        <div class="input-group-prepend">
                            <div class="input-group-text">
                                <input type="checkbox" id="chkselectallfichasobservacion">
                            </div>
                        </div>
                        <input type="text" class="form-control" value="Seleccionar fichas asociadas" readonly>
                    </div>

                    <div class="col-12 ocultarobservacion" style="max-height: 300px;overflow:auto">

                        <table class="table table-bordered table-sm text-center" >
                                <thead class="thead-light">
                                    <tr>
                                        <th>Ficha</th>
                                        <th>Estilo Tsc</th>
                                        <th>Programa</th>
                                        <th>Selección</th>
                                    </tr>
                                </thead>
                                <tbody id="tbodyfichasasociadasobservacion">

                                </tbody>
                        </table>

                    </div>


                    <div class="col-md-4 form-group ocultarobservacion">
                        <button class="btn btn-sm btn-block btn-primary" type="submit">
                            <i class="fas fa-save"></i>
                            Registrar
                        </button>
                    </div>

                </form>
            </div>

        </div>
    </div>
</div>