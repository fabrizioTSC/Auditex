<div class="modal fade" id="modalmoldepanousar"  >
    <div class="modal-dialog">

        <div class="modal-content">

            <div class="modal-header">
                <h5 class="modal-title" id="ingresomoldes">Molde Paño a Usar</h5>
                <button type="button" class="close" data-mdb-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>

            <div class="modal-body">

                <form action="" class="row" id="frmmoldepanousar" autocomplete="off">

                    <div class="col-md-4">

                        <label for="">Hilo</label>
                        <input type="text" class="form-control form-control-sm" id="txthilomoldepanousar" >

                    </div>
                    <div class="col-md-4">
                        <label for="">Trama</label>
                        <input type="text" class="form-control form-control-sm" id="txttramamoldepanousar" >
                    </div>
                    <div class="col-md-4">
                        <label for="">&nbsp;</label>
                        <button class="btn btn-sm btn-block btn-success" type="success">Registrar</button>
                    </div>

                    <div class="col-md-12 mt-2">

                        <div class="input-group mb-3">
                            <div class="input-group-prepend">
                                <div class="input-group-text">
                                    <input type="checkbox" id="chkselectallfichas_moldepano">
                                </div>
                            </div>
                            <input type="text" class="form-control" value="Seleccionar fichas asociadas" readonly>
                        </div>

                    </div>

                    <div class="col-md-12">

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
                                    <tbody id="tbodyfichasasociadas_moldepano">

                                    </tbody>
                            </table>

                        </div>

                    </div>


                </form>

                       
            </div>
            
            
            
        </div>
    </div>
</div>







<div class="modal fade" id="modalmoldeprimeralavada"  >
    <div class="modal-dialog">

        <div class="modal-content">

            <div class="modal-header">
                <h5 class="modal-title" id="ingresoprimeralavada">Primera Lavada</h5>
                <button type="button" class="close" data-mdb-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>

            <div class="modal-body">

                <form action="" class="row" id="frmmoldeprimeralavada" autocomplete="off">

                    <div class="col-md-4">

                        <label for="">Hilo</label>
                        <input type="text" class="form-control form-control-sm" id="txthilomoldeprimeralavada" required >
                    </div>
                    <div class="col-md-4">
                        <label for="">Trama</label>
                        <input type="text" class="form-control form-control-sm" id="txttramamoldeprimeralavada" required >
                    </div>
                    <div class="col-md-4">
                        <label for="">Densidad</label>
                        <input type="text" class="form-control form-control-sm" id="txtdensidadmoldeprimeralavada" required>
                    </div>


                    <div class="col-md-4">
                        <label for="">Inclinación BW</label>
                        <input type="text" class="form-control form-control-sm" id="txtinclinacionbwmoldeprimeralavada" required>
                    </div>
                    <div class="col-md-4">
                        <label for="">Inclinación AW</label>
                        <input type="text" class="form-control form-control-sm" id="txtinclinacionawmoldeprimeralavada" required>
                    </div>
                    <div class="col-md-4">
                        <label for="">Revirado</label>
                        <input type="text" class="form-control form-control-sm" id="txtreviradomoldeprimeralavada" required>
                    </div>
                    
                    <div class="col-md-4">
                        <label for="">&nbsp;</label>
                        <button class="btn btn-sm btn-block btn-success" type="success">Registrar</button>
                    </div>

                    

                    <div class="col-md-12 mt-2">

                        <div class="input-group mb-3">
                            <div class="input-group-prepend">
                                <div class="input-group-text">
                                    <input type="checkbox" id="chkselectallfichas_primeralavada">
                                </div>
                            </div>
                            <input type="text" class="form-control" value="Seleccionar fichas asociadas" readonly>
                        </div>

                    </div>

                    <div class="col-md-12">

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
                                    <tbody id="tbodyfichasasociadas_moldeprimeralavada">

                                    </tbody>
                            </table>

                        </div>

                    </div>


                </form>

                       
            </div>
            
            
            
        </div>
    </div>
</div>