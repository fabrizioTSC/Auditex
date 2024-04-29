<!-- MODAL ENCOGIMIENTO -->
<div class="modal fade" id="modalencogimiento" tabindex="-1" aria-labelledby="modalencogimiento" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="modalencogimientolabel">Encogimiento de paños</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <form class="modal-body" id="frmencogimiento">

            <table class="table table-sm table-bordered text-center tablainput">

                <!-- <tbody> -->

                <tr>
                    <!-- <td rowspan="6" style="vertical-align: middle;">PARTIDA 303276</td> -->
                    <td colspan="3" >ENCOGIMIENTO DE PAÑOS</td>
                </tr>
                <tr>
                    <td ></td>
                    <td >HILO</td>
                    <td >TRAMA</td>
                </tr>
                <tr>
                    <td>B/W</td>
                    <td style="height: 30px;"><input type="tel" class='inputtabla hiloencogimiento' id="hiloencogimientobefore"    data-tipo="B"></td>
                    <td style="height: 30px;"><input type="tel" class='inputtabla tramaencogimiento'  id="tramaencogimientobefore"   data-tipo="B"></td>
                </tr>
                <tr>
                    <td>A/W</td>
                    <td style="height: 30px;"><input type="tel" class='inputtabla hiloencogimiento' id="hiloencogimientoafter"     data-tipo="A"></td>
                    <td style="height: 30px;"><input type="tel" class='inputtabla tramaencogimiento' id="tramaencogimientoafter"    data-tipo="A"></td>
                </tr>
                <tr>
                    <td>% Encogimiento real</td>
                    <td><input type="tel" class='inputtabla' id="hilocalculadoencogimiento"  readonly></td>
                    <td><input type="tel" class='inputtabla' id="tramacalculadoencogimiento" readonly></td>
                    
                </tr>
                <tr>
                    <td>% Paño</td>
                    <td style="height: 30px;"> <input type="text" class='inputtabla' id="hilorealencogimiento" > </td>
                    <td style="height: 30px;"><input type="text" class='inputtabla' id="tramarealencogimiento"></td>
                </tr>
               <tr>
                    <td rowspan="2">Grado de inclinación</td>
                    <td>B/W</td>
                    <td>A/W</td>
               </tr>
               <tr>
                    <td style="height: 30px;"> <input type="tel" class='inputtabla' id="inclinacionbefore" > </td>
                    <td style="height: 30px;"><input type="tel" class='inputtabla'  id="inclinacionafter"></td>
               </tr>


                <!-- </tbody> -->
                
            </table>


      </form>

      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Cerrar</button>
        <button type="button" class="btn btn-primary" id="btnguardarencogimiento" >Guardar</button>
      </div>
    </div>
  </div>
</div>
