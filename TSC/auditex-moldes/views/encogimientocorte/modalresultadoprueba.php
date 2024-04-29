<div class="modal fade" id="modalresultadoprueba">
    <div class="modal-dialog modal-xl">

        <div class="modal-content">

            <div class="modal-header">
                <h5 class="modal-title" id="">Resultados de prueba de encogimiento</h5>
                <button type="button" class="close" data-mdb-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>

            <div class="modal-body">

                <form id="frmresultadopruebaencogimiento" autocomplete="off">
                    
                    <ul class="nav nav-tabs" id="myTab" role="tablist">
                        <li class="nav-item" role="presentation">
                            <a class="nav-link active" id="datosgenerales-tab" data-toggle="tab" href="#datosgenerales" role="tab" aria-controls="datosgenerales" aria-selected="true">
                                Datos Generales
                            </a>
                        </li>
                        <li class="nav-item" role="presentation">
                            <a class="nav-link" id="imagengeneral-tab" data-toggle="tab" href="#imagengeneral" role="tab" aria-controls="imagengeneral" aria-selected="false">
                                Imagen General
                            </a>
                        </li>
                    </ul>

                    <div class="tab-content" id="myTabContent">
                        <!-- DATOS GENERALES -->
                        <div class="tab-pane fade show active pt-2" id="datosgenerales" role="tabpanel" aria-labelledby="datosgenerales-tab">

                            <!-- CONTENEDOR DE LAS PARTIDAS ASOCIADAS -->
                            <div class="row">

                                <div class="col-md-7">

                                    <div class="form-group-md row">
                                        <label class="col-md-4">Agregar Partida</label>
                                        <div class="col-md-8">

                                            <div class="input-group">
                                                <input type="text" class="form-control form-control-sm" id="txtpartidaadd" placeholder="PARTIDA">
                                                <div class="input-group-append">
                                                    <button class="btn-sm btn-block btn-primary " type="button" id="btnaddpartida">
                                                        <i class="fas fa-save"></i>
                                                    </button>
                                                </div>
                                            </div>

                                        </div>
                                    </div>

                                    <hr>

                                    <table class="table table-sm table-bordered">
                                        <thead class="thead-light text-center">
                                            <tr>  
                                                <th colspan="8" class="border-table"> Datos DDP</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <tr>      
                                                <td colspan="2" class="col-2 border-table">ARTÍCULO:</td>      
                                                <td colspan="6" class="col-10 border-table" id="lblarticulo"></td>
                                            </tr>
                                            <tr>      
                                                <td colspan="2" class="col-2 border-table">RUTA:</td>      
                                                <td colspan="6" class="col-10 border-table" id="lblruta"></td>
                                            </tr>
                                            <tr>      
                                                <td colspan="2" class="col-2 border-table">CLIENTE:</td>      
                                                <td colspan="6" class="col-10 border-table" id="lblcliente"></td>
                                            </tr>
                                            <tr>      
                                                <td colspan="3" class="col-6 border-table">ESTILO DE PRUEBA (TSC / CLIENTE):</td>      
                                                <td colspan="5" class="col-6 border-table" id="lblestilodeprueba"></td>
                                            </tr>
                                            <tr class="bg-thead-light">      
                                                <th class="text-center col-1  border-table align-vertical" rowspan="2">Partida</th>      
                                                <th class="text-center col-2  border-table align-vertical" rowspan="2">Color</th>      
                                                <th class="text-center col-3  border-table align-vertical" colspan="2">Datos Estándar</th>      
                                                <th class="text-center col-3  border-table align-vertical" colspan="2">Datos Datos TSC - Textil</th>      
                                                <th class="text-center col-3  border-table align-vertical" colspan="2">Datos de Testing - 3ra Lavada</th>
                                            </tr>
                                            <tr class="bg-thead-light">      
                                                <th class="text-center  border-table">Hilo</th>      
                                                <th class=" text-center  border-table">Trama</th>      
                                                <th class=" text-center  border-table">Hilo</th>      
                                                <th class=" text-center  border-table">Trama</th>      
                                                <th class=" text-center  border-table">Hilo</th>      
                                                <th class=" text-center  border-table">Trama</th>
                                            </tr>
                                        </tbody>
                                        <tbody id="tbodyresultadoprueba">


                                        </tbody>
                                    </table>

                                </div>

                                <!-- DATOS A AGREGAR -->
                                <div class="col-md-5">

                                    <table class="table table-sm table-bordered tablainput">
                                        <tbody>
                                            <tr>
                                                <td class="col-12 border-table" colspan="2">Como pueden apreciar en la imagén se utilizó un Molde</td>
                                            </tr>
                                            <tr>
                                                <td class="col-6 border-table" >
                                                    <input type="text" class="inputtabla input-datos" id="txtmoldeusar" readonly>
                                                </td>
                                                <td class="col-8 border-table" >en la cual se detalla lo siguiente:</td>
                                            </tr>
                                            <tr>
                                                <td colspan="3" class="col-12 border-table">En el Hilo(Largo de cuerpo)</td>
                                            </tr>
                                            <tr>
                                                <td class="col-2 border-table">Tendencia</td>
                                                <td class="col-10 border-table">
                                                    <input type="text" class="inputtabla input-datos" id="txthilotendencia" required>
                                                </td>
                                            </tr>
                                            <tr>
                                                <td colspan="2" class="col-12 border-table">En la Trama(Ancho de cuerpo)</td>
                                            </tr>
                                            <tr>
                                                <td class="col-2 border-table">Tendencia</td>
                                                <td  class="col-12 border-table">
                                                    <input type="text" class="inputtabla input-datos" id="txttramatendencia" required >
                                                </td>
                                            </tr>
                                            <tr>
                                                <td colspan="2" class="col-12 border-table">Por ello y en coordinación con María Muñante se sugiere lo siguiente:</td>
                                            </tr>
                                            <tr class="bg-thead-light">
                                                <td colspan="2" class="col-12 text-center border-table font-weight-bold">MOLDE A UTILIZAR SEGÚN EVALUACIÓN:</td>
                                            </tr>
                                            <tr>
                                                <td  class="col-4 border-table">HILO:</td>
                                                <td class="col-8 border-table" >
                                                    <input type="text" class="inputtabla input-datos" id="txthiloevaluacion" required>
                                                </td>
                                            </tr>
                                            <tr>
                                                <td class="col-4 border-table">TRAMA:</td>
                                                <td class="col-8 border-table" >
                                                    <input type="text" class="inputtabla input-datos" id="txttramaevaluacion" required>
                                                </td>
                                            </tr>
                                            <tr>
                                                <td  class="col-4 border-table">MANGA:</td>
                                                <td class="col-8 border-table">
                                                    <input type="text" class="inputtabla input-datos" id="txtmangaevaluacion" required>
                                                </td>
                                            </tr>
                                        </tbody>
                                    </table>


                                </div>


                            </div>

                            <!-- PARA AGREGAR IMAGENES -->
                            <table class="table table-bordered table-sm text-center">
                                <thead class="thead-light">
                                    <tr>
                                        <th class="border-table">
                                            IMAGENES
                                            <input type="file" multiple required id="input_imagenes" name="imagenes[]">
                                        </th>
                                    </tr>
                                </thead>
                            </table>

                            <!-- IMAGENES -->
                            <div class="row justify-content-md-center p-4" id="container-imagenes">
                            </div>

                        </div>


                        <!-- IMAGEN GENERAL -->
                        <div class="tab-pane fade pt-2 mb-2" id="imagengeneral" role="tabpanel" aria-labelledby="imagengeneral-tab">

                            <div class="row">

                                <div class="col-md-12">
                                    <input type="file" name="imgprincipal" id="input_imagegeneral" class="form-control form-control-sm" required>
                                </div>

                                <div class="col-md-12 mt-2" style="height: 500px !important;" >

                                    <img class="imgsubidas" src="" alt="" id="imggeneralcarga" >

                                </div>

                            </div>


                        </div>
                       
                    </div>



                    <!-- OPCIONES -->
                    <div class="row">

                        <div class="col-md-3">
                            <button class="btn btn-sm btn-block btn-success" type="submit">Guardar</button>
                        </div>

                        <div class="col-md-3">
                            <button class="btn btn-sm btn-block btn-danger" id="btnimprimirpdf" type="button">Imprimir</button>
                        </div>

                    </div>
                    

                </form>

            </div>

        </div>
        
    </div>
</div>