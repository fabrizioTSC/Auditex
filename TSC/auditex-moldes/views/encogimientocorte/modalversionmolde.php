<div class="modal fade" id="modalversionmolde"  >
    <div class="modal-dialog">

        <div class="modal-content">

            <div class="modal-header">
                <h5 class="modal-title" id="ingresomoldes">Versión del Molde</h5>
                <button type="button" class="close" data-mdb-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>

            <div class="modal-body">

                <form action="" class="row" id="frmversionmolde" autocomplete="off">

                    <div class="col-md-8">

                        <label for="">Version Molde</label>
                        <input type="text" class="form-control form-control-sm" id="txtversionmolde">

                    </div>
                    
                    <div class="col-md-4">
                        <label for="">&nbsp;</label>
                        <button class="btn btn-sm btn-block btn-success" type="success">Registrar</button>
                    </div>


                    <div class="col-md-12 mt-2">

                        <div class="input-group mb-3">
                            <div class="input-group-prepend">
                                <div class="input-group-text">
                                    <input type="checkbox" id="chkselectallfichas_versionmolde">
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
                                    <tbody id="tbodyfichasasociadas_versionmolde">

                                    </tbody>
                            </table>

                        </div>

                    </div>


                </form>

                       
            </div>
            
            
            
        </div>
    </div>
</div>