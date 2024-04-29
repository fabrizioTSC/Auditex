<div class="modal fade" id="moldedisponiblemodal"  >
    <div class="modal-dialog">

        <div class="modal-content">

            <div class="modal-header">
                <h5 class="modal-title" id="ingresomoldes">MOLDE DISPONIBLE</h5>
                <button type="button" class="close" data-mdb-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>

            <div class="modal-body">
                    <div class="row">
                        <div class="col-6 form-group">
                            <label id="lblestilocliente" for="">Estilo Cliente:</label>
                        </div>
                        <div class="col-6">
                            <label id="lblestilotsc" for="">Estilo TSC:</label>
                        </div> 
                    </div>

                    <div class="row">

                        <div class="col-12 form-group">
                            <label for="">Encogimientos:</label>
                            <div class="card mt-3 ">
        
                                <div class="container-general float-left w-100">

                                    <div class="table-responsive">

                                        <table class="table table-bordered table-sm" id="tabledatos">

                                            <thead class="thead-light">
                                                <!-- Nombre de la cabecera de mi tabla -->  
                                                <tr>
                                                
                                                    <th>Nro.</th>
                                                    <th>Hilo</th> 
                                                    <th>Trama</th>
                                                    <th>Manga</th> 
                                                    <th>Marca</th> 
                                                </tr>

                                            </thead>

                                            <tbody id="tbodydatosmoldesdisponible">

                                            </tbody>

                                        </table>  

                                    </div>  

                                </div>      

                            </div> 
                        </div>

                    </div>
            </div>
            
            <div class="modal-footer">
                <button type="button" class="fa fa-cloud btn btn-primary" id="btnguardarencogimientosdisponibles"> Guardar</button>
                <button type="button" class="fa fa-times btn btn-secondary" data-mdb-dismiss="modal"> Cerrar</button>
            </div>
            
        </div>
    </div>
</div>