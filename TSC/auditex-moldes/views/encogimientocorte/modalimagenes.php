<div class="modal fade tamanoletramodalimagen" id="imagenesmodal" tabindex="-1" aria-labelledby="imagenesmodal" aria-hidden="true">
    <div class="modal-dialog modal-xl">
        <div class="modal-content">

            <div class="modal-header">
                <h5 class="modal-title" id="">RESULTADOS DE PRUEBA DE ENCOGIMIENTO</h5>
                <button type="button" class="close" data-mdb-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>

            <form class="modal-body" id="frmimagemes"> 

                <div class="row">

                    <div class="col-md-12"> 
                        <!--  SEGUNDA TABLA DE PREVISUALIZACIÓN  -->
                        <table class="table table-bordered table-sm" style="width: 100% !important;">

                            <tbody>
                                <tr> <!--tr = fila-->
                                    <td colspan="2" style="width: 75% !important;">DATOS DE DDP:</td> <!--td = columna-->

                                    <td  rowspan="17" style="width: 25% !important;">
                                        <input type="file" class="form-control-sm" id="imgInp1"> 
                                        <br> 
                                        <img id="blah1" src="https://via.placeholder.com/350" alt="Tu imagen" style="width: 100%;" />
                                    </td> 
                                </tr>

                               <tr>
                                    <td style="width: 25% !important;">PARTIDA:</td>
                                    <td style="width: 25% !important;" id="lblpartida"></td>
                               </tr>

                               <tr>
                                    <td style="width: 25% !important;">ARTÍCULO:</td>
                                    <td style="width: 25% !important;" id="lblarticulo" class="celda"></td>
                               </tr>

                                <tr>
                                    <td style="width: 25% !important;">COLOR:</td>
                                    <td style="width: 25% !important;">
                                        <input type="text" class="form-control form-control-sm" id="lblcolor">
                                    </td>
                                </tr>

                                <tr>
                                    <td>MOLDE T/M:</td>
                                    <td>
                                        <input type="text" class="form-control form-control-sm" id="lblmolde">
                                    </td>
                                </tr>

                                <tr>
                                    <td>RUTA:</td>
                                    <td id="lblruta" class="celda"></td>
                                </tr>

                                <tr>
                                    <td>CLIENTE:</td>
                                    <td id="lblcliente"></td>
                                </tr>

                                <tr>
                                    <td colspan="2">DATO ESTÁNDAR PARTIDA:</td>
                                    <!-- <td>
                                        <input type="text" class="form-control form-control-sm" id="lblpartida1">
                                    </td> -->
                                </tr>

                                <tr>
                                    <td>HILO:</td>
                                    <td id="lblhiloest"></td>
                                </tr>

                                <tr>
                                    <td>TRAMA:</td>
                                    <td id="lbltramaest"></td>
                                </tr>

                                <tr>
                                    <td colspan="2">DATOS TSC - TEXTIL:</td>
                                </tr>

                                <tr>
                                    <td>HILO:</td>
                                    <td id="lblhilotsc"></td>
                                </tr>

                                <tr>
                                    <td>TRAMA</td>
                                    <td id="lbltramatsc"></td>
                                </tr>

                                <tr>
                                    <td colspan="2">DATOS DE TESTING - 3RA LAVADA:</td>
                                </tr>

                                <tr>
                                    <td>HILO:</td>
                                    <td id="lblhilotes"></td>
                                </tr>

                                <tr>
                                    <td>TRAMA:</td>
                                    <td id="lbltramates"></td>
                                </tr>

                                <tr>
                                    <td>ESTILO DE PRUEBA:</td>
                                    <td>
                                        <input type="text" class="form-control form-control-sm" id="lblestilocli">
                                    </td>
                                </tr>

                            </tbody>

                        </table>
                    </div>

                </div>    

                <!-- SEGUNDA TABLA DE PREVISUALIZACIÓN -->
                <div class="row">

                    <div class="col-12">
                        <table class="table table-bordered table-sm">
                            <tbody>
                                <tr>
                                    <td colspan="3">RESULTADOS DDP</td>
                                </tr>

                                <tr>
                                    <td colspan="3">
                                        <input type="file" class="form-control-sm mt-2" id="imgInp2"> 
                                        <br>
                                        <img id="blah" src="https://via.placeholder.com/400" alt="Tu imagen" />
                                    </td>
                                        
                                </tr>

                                <tr>
                                    <td>Como pueden apreciar en la imagén se utilizó un Molde</td>
                                        <td> 
                                            <!-- <input type="text" value="1x1" class="form-control form-control-sm" id="lblmolde1"> -->
                                            <input type="text" class="form-control form-control-sm" id="lblmolde1">
                                        </td>
                                    <td>en la cual se detalla lo siguiente:</td>
                                </tr>

                                <tr>
                                    <td colspan="2">En el Hilo(Largo de cuerpo). Los resultados están con tendencia a:</td> 
                                    <td>
                                        <input type="text" class="form-control form-control-sm" id="lbllargo">
                                    </td>
                                </tr>

                                <tr>
                                    <td colspan="2">En la Trama(Ancho de cuerpo). Los resultados están en tendencia a:</td>
                                    <td>
                                        <input type="text" class="form-control form-control-sm" id="lblancho">
                                    </td>
                                </tr>

                                <tr>
                                    <td colspan="3">Por ello y en coordinación con María Muñante se sugiere lo siguiente:</td>
                                </tr>

                                <tr>
                                    <td colspan="3">MOLDE A UTILIZAR SEGÚN EVALUACIÓN:</td>
                                </tr>

                                <tr>
                                    <td>HILO:</td>
                                    <td colspan="2">
                                        <input type="text" class="form-control form-control-sm" id="lblhilo">
                                    </td>
                                </tr>

                                <tr>
                                    <td>TRAMA:</td>
                                    <td colspan="2">
                                        <input type="text" class="form-control form-control-sm" id="lbltrama">
                                    </td>
                                </tr>

                                <tr>
                                    <td>MANGA:</td>
                                    <td colspan="2"> 
                                        <!-- id="lblmangausar" colspan="2">A -->
                                        <input type="text" class="form-control form-control-sm" id="lblmanga">
                                    </td>
                                </tr>

                            </tbody>
                        </table>
                    </div>

                </div> 

                <!-- BOTONES -->
                <div class="row">

                    <!-- BOTONES IMPRIMIR - CERRAR -->
                    <div class="col-md-8">

                        <button class="btn btn-danger btn-sm" id="btnimprimir">
                            <i class="fas fa-file-pdf"></i>
                            Imprimir
                        </button>

                        <button type="button" class="btn btn-secondary btn-sm" data-mdb-dismiss="modal">
                            <i class="fas fa-times"></i>
                            Cerrar
                        </button>

                    </div>

                    <!-- BOTONES IMPRIMIR -->
                    <div class="col-md-4">
                        <button type="button" class="btn btn-primary btn-sm float-right" id="btnguardarimagen"> 
                            <i class="fas fa-save"></i>
                            Guardar
                        </button>
                    </div>

                </div>

            </form>               

        </div>
    </div>
</div>