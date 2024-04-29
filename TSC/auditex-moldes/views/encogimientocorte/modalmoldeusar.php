<div class="modal fade" id="modalmoldeusar"  >
    <div class="modal-dialog">

        <div class="modal-content">

            <div class="modal-header">
                <h5 class="modal-title" id="ingresomoldes">Molde a Usar</h5>
                <button type="button" class="close" data-mdb-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>

            <div class="modal-body">

                    <div class="row">
                        <div class="col-6 form-group">
                            <label id="lblestilocliente_moldeusar" for="">Estilo Cliente:</label>
                        </div>
                        <div class="col-6">
                            <label id="lblestilotsc_moldeusar" for="">Estilo TSC:</label>
                        </div> 
                    </div>

                   
                    <div class="table-responsive">

                        <table class="table table-bordered table-sm text-center" id="tabledatos">

                            <thead class="thead-light">
                                <tr>
                                
                                    <th>Nro.</th>
                                    <th>Hilo</th> 
                                    <th>Trama</th>
                                    <th>Manga</th> 
                                    <th>Marca</th> 
                                </tr>

                            </thead>

                            <tbody id="tbodymoldeusar">

                            </tbody>

                        </table>  

                    </div>  

                    <hr>
                    
                    <!-- <h3>Selección de Fichas Asociadas</h3> -->
                    <div class="input-group mb-3">
                        <div class="input-group-prepend">
                            <div class="input-group-text">
                                <input type="checkbox" id="chkselectallfichas">
                            </div>
                        </div>
                        <input type="text" class="form-control" value="Seleccionar fichas asociadas" readonly>
                    </div>

                    <div class="" style="max-height: 300px;overflow:auto">

                        <table class="table table-bordered table-sm text-center" >
                                <thead class="thead-light">
                                    <tr>
                                        <th>Ficha</th>
                                        <th>Estilo Tsc</th>
                                        <th>Programa</th>
                                        <th>Selección</th>
                                    </tr>
                                </thead>
                                <tbody id="tbodyfichasasociadas">

                                </tbody>
                        </table>

                    </div>

                    


                       
            </div>
            
            <div class="modal-footer">
                <button type="button" class="btn btn-primary" id="btnguardarmoldeusar">
                    <i class="fas fa-save"></i>
                    Guardar
                </button>
                <button type="button" class="btn btn-danger" data-mdb-dismiss="modal">
                    Cerrar
                </button>
            </div>
            
        </div>
    </div>
</div>