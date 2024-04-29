<!-- MODAL LAVADO -->
<div class="modal fade" id="modallavado" tabindex="-1" aria-labelledby="modallavado" aria-hidden="true">
  <div class="modal-dialog modal-lg ">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="modallavadolabel">Datos Reales Lavadas</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body" id="frmmodal">

        <div class="row">

            <!-- BOLSA 1 -->
            <form class="col-md-12 frmbolsas" autocomplete="off">

              <input type="hidden" name="numerobolsa" value="1">
              <input type="hidden" name="idbolsa"   id="idbolsa1" >


              <!-- TABLA -->
                <table class="table table-bordered tablainput text-center">
                  <tbody>
                      <tr>
                        <td rowspan="3" class="align-vertical " >
                          <!-- BOLSA 1 -->
                          <button class="btn btn-success w-100" type="button">BOLSA 1</button>
                          <button class="btn btn-primary w-100 mt-1" type="submit">Guardar</button>
                        </td>
                        <td class="text-white bg-info">HILO</td>
                        <td class="text-white bg-info">HILO</td>
                        <td class="text-white bg-info">HILO</td>
                        <td class="text-white bg-warning">TRAMA</td>
                        <td class="text-white bg-warning">TRAMA</td>
                        <td class="text-white bg-warning">TRAMA</td>
                        <td class="">AC</td>
                        <td class="">BD</td>
                      </tr>
                      <tr>
                        <td><input type="number" step="0.01" class='inputtabla bolsa1hilo'   id="bolsa1hilo_orden1"     data-orden="1" data-id="" required></td>
                        <td><input type="number" step="0.01" class='inputtabla bolsa1hilo'   id="bolsa1hilo_orden2"     data-orden="2" data-id="" required></td>
                        <td><input type="number" step="0.01" class='inputtabla bolsa1hilo'   id="bolsa1hilo_orden3"     data-orden="3" data-id="" required></td>
                        <td><input type="number" step="0.01" class='inputtabla bolsa1trama'  id="bolsa1trama_orden1"    data-orden="1" data-id="" required></td>
                        <td><input type="number" step="0.01" class='inputtabla bolsa1trama'  id="bolsa1trama_orden2"    data-orden="2" data-id="" required></td>
                        <td><input type="number" step="0.01" class='inputtabla bolsa1trama'  id="bolsa1trama_orden3"    data-orden="3" data-id="" required></td>
                        <td><input type="number" step="0.01" class='inputtabla bolsa1acbd'   id="bolsa1ac" required></td>
                        <td><input type="number" step="0.01" class='inputtabla bolsa1acbd'   id="bolsa1bd" required></td>
                      </tr>
                      <tr>
                        <td colspan="3"><input type="number" step="0.01" class='inputtabla text-center totalhilo' id="totalbolsa1hilo"   ></td>
                        <td colspan="3"><input type="number" step="0.01" class='inputtabla text-center totaltrama' id="totalbolsa1trama"   ></td>
                        <td colspan="2"><input type="number" step="0.01" class='inputtabla text-center' id="reviradobolsa1"  ></td>
                      </tr>
                  </tbody>
                </table>

            </form>

            <!-- BOLSA 2 -->
            <form class="col-md-12 frmbolsas" autocomplete="off">

              <input type="hidden" name="numerobolsa" value="2">
              <input type="hidden" name="idbolsa"   id="idbolsa2" >

                <table class="table table-bordered tablainput text-center">
                  <tbody>
                      <tr>
                        <td rowspan="3" class="align-vertical " >
                          <!-- BOLSA 1 -->
                          <button class="btn btn-success w-100" type="button">BOLSA 2</button>
                          <button class="btn btn-primary w-100 mt-1" type="submit">Guardar</button>
                        </td>
                        <td class="text-white bg-info">HILO</td>
                        <td class="text-white bg-info">HILO</td>
                        <td class="text-white bg-info">HILO</td>
                        <td class="text-white bg-warning">TRAMA</td>
                        <td class="text-white bg-warning">TRAMA</td>
                        <td class="text-white bg-warning">TRAMA</td>
                        <td class="">AC</td>
                        <td class="">BD</td>
                      </tr>
                      <tr>
                        <td><input type="number" step="0.01" class='inputtabla bolsa2hilo'   id="bolsa2hilo_orden1"     data-orden="1" data-id="" required></td>
                        <td><input type="number" step="0.01" class='inputtabla bolsa2hilo'   id="bolsa2hilo_orden2"     data-orden="2" data-id="" required></td>
                        <td><input type="number" step="0.01" class='inputtabla bolsa2hilo'   id="bolsa2hilo_orden3"     data-orden="3" data-id="" required></td>
                        <td><input type="number" step="0.01" class='inputtabla bolsa2trama'  id="bolsa2trama_orden1"    data-orden="1" data-id="" required></td>
                        <td><input type="number" step="0.01" class='inputtabla bolsa2trama'  id="bolsa2trama_orden2"    data-orden="2" data-id="" required></td>
                        <td><input type="number" step="0.01" class='inputtabla bolsa2trama'  id="bolsa2trama_orden3"    data-orden="3" data-id="" required></td>
                        <td><input type="number" step="0.01" class='inputtabla bolsa2acbd'   id="bolsa2ac" required></td>
                        <td><input type="number" step="0.01" class='inputtabla bolsa2acbd'   id="bolsa2bd" required></td>
                      </tr>
                      <tr>
                        <td colspan="3"><input type="number" step="0.01" class='inputtabla text-center totalhilo' id="totalbolsa2hilo"   ></td>
                        <td colspan="3"><input type="number" step="0.01" class='inputtabla text-center totaltrama' id="totalbolsa2trama"   ></td>
                        <td colspan="2"><input type="number" step="0.01" class='inputtabla text-center' id="reviradobolsa2"  ></td>
                      </tr>
                  </tbody>
                </table>

            </form>

            <!-- BOLSA 3 -->
            <form class="col-md-12 frmbolsas" autocomplete="off">

              <input type="hidden" name="numerobolsa" value="3">
              <input type="hidden" name="idbolsa"   id="idbolsa3" >

                <table class="table table-bordered tablainput text-center">
                 
                  <tbody>
                        <tr>
                          <td rowspan="3" class="align-vertical " >
                            <!-- BOLSA 1 -->
                            <button class="btn btn-success w-100" type="button">BOLSA 3</button>
                            <button class="btn btn-primary w-100 mt-1" type="submit">Guardar</button>
                          </td>
                          <td class="text-white bg-info">HILO</td>
                          <td class="text-white bg-info">HILO</td>
                          <td class="text-white bg-info">HILO</td>
                          <td class="text-white bg-warning">TRAMA</td>
                          <td class="text-white bg-warning">TRAMA</td>
                          <td class="text-white bg-warning">TRAMA</td>
                          <td class="">AC</td>
                          <td class="">BD</td>
                        </tr>
                        <tr>
                          <td><input type="number" step="0.01" class='inputtabla bolsa3hilo'   id="bolsa3hilo_orden1"     data-orden="1" data-id="" required></td>
                          <td><input type="number" step="0.01" class='inputtabla bolsa3hilo'   id="bolsa3hilo_orden2"     data-orden="2" data-id="" required></td>
                          <td><input type="number" step="0.01" class='inputtabla bolsa3hilo'   id="bolsa3hilo_orden3"     data-orden="3" data-id="" required></td>
                          <td><input type="number" step="0.01" class='inputtabla bolsa3trama'  id="bolsa3trama_orden1"    data-orden="1" data-id="" required></td>
                          <td><input type="number" step="0.01" class='inputtabla bolsa3trama'  id="bolsa3trama_orden2"    data-orden="2" data-id="" required></td>
                          <td><input type="number" step="0.01" class='inputtabla bolsa3trama'  id="bolsa3trama_orden3"    data-orden="3" data-id="" required></td>
                          <td><input type="number" step="0.01" class='inputtabla bolsa3acbd'   id="bolsa3ac" required></td>
                          <td><input type="number" step="0.01" class='inputtabla bolsa3acbd'   id="bolsa3bd" required></td>
                        </tr>
                        <tr>
                          <td colspan="3"><input type="number" step="0.01" class='inputtabla text-center totalhilo' id="totalbolsa3hilo"   ></td>
                          <td colspan="3"><input type="number" step="0.01" class='inputtabla text-center totaltrama' id="totalbolsa3trama"   ></td>
                          <td colspan="2"><input type="number" step="0.01" class='inputtabla text-center' id="reviradobolsa3"  ></td>
                        </tr>
                    </tbody>

                </table>

            </form>

            
            <!-- GENERALES -->
            <div class="col-md-12">

                <table class="table table-bordered text-center tablainput">
                  <tbody>
                    <tr>
                      <td class="bg-warning">HILO</td>
                      <td class="bg-warning">TRAMA</td>
                    </tr>
                    <tr>
                      <td ><input type="text" class="inputtabla text-center" id="promediohilo"  readonly value="0"></td>
                      <td ><input type="text" class="inputtabla text-center" id="promediotrama" readonly value="0"></td>
                    </tr>

                  </tbody>
                </table>


            </div>


        </div>

      </div>





        <!-- <table class="table table-sm table-bordered text-center tablainput">


            <tr>
                <td rowspan="6" style="vertical-align: middle;" id="lblpartidalavado">PARTIDA</td>
                <td colspan="6" id="tdlabellavada">MUESTRA 1RA LAVADA</td>
            </tr>
            <tr>
                <td colspan="2">BOLSA 1</td>
                <td colspan="2">BOLSA 2</td>
                <td colspan="2">BOLSA 3</td>
            </tr>
            <tr>
                <td>H</td>
                <td>T</td>
                <td>H</td>
                <td>T</td>
                <td>H</td>
                <td>T</td>
            </tr>
            <tr>
                <td style="height: 30px;"><input type="number" step="0.01" class='inputtabla bolsa1hilo' data-orden="1"></td>
                <td><input type="number" step="0.01" class='inputtabla bolsa1trama'   data-orden="1"></td>
                <td><input type="number" step="0.01" class='inputtabla bolsa2hilo'    data-orden="1"></td>
                <td><input type="number" step="0.01" class='inputtabla bolsa2trama'   data-orden="1"></td>
                <td><input type="number" step="0.01" class='inputtabla bolsa3hilo'    data-orden="1"></td>
                <td><input type="number" step="0.01" class='inputtabla bolsa3trama'   data-orden="1"></td>
            </tr>
            <tr>
                <td style="height: 30px;"><input type="number" step="0.01" class='inputtabla bolsa1hilo' data-orden="2"></td>
                <td><input type="number" step="0.01" class='inputtabla bolsa1trama'   data-orden="2"></td>
                <td><input type="number" step="0.01" class='inputtabla bolsa2hilo'    data-orden="2"></td>
                <td><input type="number" step="0.01" class='inputtabla bolsa2trama'   data-orden="2"></td>
                <td><input type="number" step="0.01" class='inputtabla bolsa3hilo'    data-orden="2"></td>
                <td><input type="number" step="0.01" class='inputtabla bolsa3trama'   data-orden="2"></td>
            </tr>
            <tr>
                <td style="height: 30px;"><input type="number" step="0.01" class='inputtabla bolsa1hilo' data-orden="3"></td>
                <td><input type="number" step="0.01" class='inputtabla bolsa1trama'   data-orden="3"></td>
                <td><input type="number" step="0.01" class='inputtabla bolsa2hilo'    data-orden="3"></td>
                <td><input type="number" step="0.01" class='inputtabla bolsa2trama'   data-orden="3"></td>
                <td><input type="number" step="0.01" class='inputtabla bolsa3hilo'    data-orden="3"></td>
                <td><input type="number" step="0.01" class='inputtabla bolsa3trama'   data-orden="3"></td>
            </tr>

            <tr>
                <td>%</td>
                <td id="totalbolsa1hilo"    class="totalhilo bg-info text-white"></td>
                <td id="totalbolsa1trama"   class="totaltrama bg-info text-white"></td>
                <td id="totalbolsa2hilo"    class="totalhilo bg-info text-white"></td>
                <td id="totalbolsa2trama"   class="totaltrama bg-info text-white"></td>
                <td id="totalbolsa3hilo"    class="totalhilo bg-info text-white"></td>
                <td id="totalbolsa3trama"   class="totaltrama bg-info text-white"></td>
            </tr>

            <tr>
                <td>PROM. FINAL</td>
                <td     class="bg-warning text-white">HILO</td>
                <td colspan="2"  id="promediohilo"   class="bg-warning text-white"></td>
                <td     class="bg-warning text-white">TRAMA</td>
                <td colspan="2" id="promediotrama"  class="bg-warning text-white"></td>
            </tr>

            <tr>
                <td rowspan="2">
                    AC/BD
                </td>
                <td>AC</td>
                <td>BD</td>
                <td>AC</td>
                <td>BD</td>
                <td>AC</td>
                <td>BD</td>
            </tr>
            <tr>
                <td style="height: 30px;"><input type="number" step="0.01" class='inputtabla bolsa1acbd' id="bolsa1ac" ></td>
                <td><input type="number" step="0.01" class='inputtabla bolsa1acbd' id="bolsa1bd"></td>
                <td><input type="number" step="0.01" class='inputtabla bolsa2acbd' id="bolsa2ac"></td>
                <td><input type="number" step="0.01" class='inputtabla bolsa2acbd' id="bolsa2bd"></td>
                <td><input type="number" step="0.01" class='inputtabla bolsa3acbd' id="bolsa3ac"></td>
                <td><input type="number" step="0.01" class='inputtabla bolsa3acbd' id="bolsa3bd"></td>
            </tr>   
            <tr>
                <td>% DE REVIRADO</td>
                <td colspan="2"  id="reviradobolsa1" class="bg-info text-white" ></td> 
                <td colspan="2"  id="reviradobolsa2" class="bg-info text-white"></td> 
                <td colspan="2"  id="reviradobolsa3" class="bg-info text-white"></td> 
            </tr>


            
        </table> -->

        


      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Cerrar</button>
        <button type="button" class="btn btn-primary" id="btnguardarlavada" >Calcular Datos</button>
      </div>
    </div>
  </div>
</div>
