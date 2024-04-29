    // BOTON GUARDAR
    $("#btnguardar").click(async function(){    
        MostrarCarga("Cargando...");
        await setFichaCabecera();
        InformarMini("Registrado correctamente...");
    });

    // ABRIMOS MODAL PARA DEFECTOS
    $("#tbodyficha").on('click','.adddefecto',async function(){

        MostrarCarga("Cargando...");

        // OBTENEMOS PAQUEETE
        let idpaquete       = $(this).data("idpaquete");
        let numeropaquete   = $(this).data("numeropaquete");
        let correlativo     = $(this).data("correlativo");

        IDPAQUETE = idpaquete == "" ? null : idpaquete;
        
        if(IDPAQUETE  == null){
            await setPaquetes([
                null,   IDDEPURACION,   numeropaquete,  null,
                null,   null,           null,           correlativo
            ]);
        }


        await getDefectosNotInPaquete(idpaquete);
        await getDefectosPaquete(idpaquete);

        $("#modaldefectos").modal({
                backdrop: 'static', 
                keyboard: false,
                show:true
        });

    });

     // ABRIMOS MODAL PARA DEFECTOS
     $("#tbodyficha").on('click','.addobservacion',async function(){

        // let observaciontd           = $(this).text();
        let observacioncompleta     = $(this).data("observacion");
        let idpaquete       = $(this).data("idpaquete");

        if(idpaquete != "" && idpaquete != null){
            
            let observacion =  await Obtener("Ingrese observaciones","textarea",observacioncompleta);

            if(observacion){  

                MostrarCarga("Registrando...");

                await setPaquetes([
                    idpaquete,  null,           null,           null,
                    null,       null,           observacion,    null
                ]);

                $(this).data("observacion",observacion);
                $(this).text( observacion.substring(0,10));

                InformarMini("Correcto");
            }

        }else{
            Advertir("Registre defectos para poder ingresar observación");
        }

        


    });

    // OCULTAMOS MODAL
    $("#modaldefectos").on("hidden.bs.modal", function () {
        MostrarCarga("Recalculando datos...");
        getFichaDetalle(FICHA,null);
        getDefectosFicha();

    });

    // FORMULARIO DEFECTOS
    frmdefectos.addEventListener('submit',async function(e){
    
        e.preventDefault();
        let datos = [
            null,   IDPAQUETE,  $("#cbodefectos").val(),    $("#txtcantidaddefectos").val().trim()
        ];
        
        await setDefectosDepuracion(datos);

    });

    // CAMBIAMOS CANTIDAD
    $("#tbodydefectos").on('click','.btnoperacion',async function(){

        let fila    = $(this).data("fila");
        let op      = $(this).data("op");
        let id      = $(this).data("id");

        op = parseFloat(op);
        let valor   = $(".filadef"+fila).text();
        valor = parseFloat(valor);

        let resul = valor + op;
        if(resul >= 1){
            $(".filadef"+fila).text(resul);
        }else{
            // Advertir("No se puede poner cantidad 0");
            let response = await Preguntar("La cantidad es 0, confirme para eliminar defecto");

            if(response.value){

                try{
                    MostrarCarga("Cargando...");
                    let response = await post("auditex-corte","depuracion","deletedefecto",[id]) ;
                    // console.log(response);
                    if(response.success){
                        await getDefectosNotInPaquete(IDPAQUETE);
                        await getDefectosPaquete(IDPAQUETE);
                        frmdefectos.reset();
                    }else{
                        Advertir(response.rpt)
                    }
        
                }catch(error){
                    AdvertirMini("Ocurrio un error al eliminar defecto");
                    console.log(error);
                }

            }

        }

    });

    // CAMBIAMOS CANTIDAD
    $("#tbodydefectos").on('click','.btnguardar',async function(){

        let fila        = $(this).data("fila");
        let id          = $(this).data("id");
        let cantidad    = $(".filadef"+fila).text();

        let datos = [
            id,   null,  null,     cantidad
        ];
        
        await setDefectosDepuracion(datos);

    });



    // ABRIMOS MODAL PARA DEFECTOS
    $("#tbodyficha").on('click','.addtonos',function(){

        let fila =  $(this).data("fila");
        let maximodefectos = $(".maxdefectos"+fila).text();
        maximodefectos = maximodefectos == "" ? 0 : parseFloat(maximodefectos);


        let tipo =  parseFloat($(this).data("tipo"));
        let tono    =  $(this).data("tono");  
        let tono2   =  tono == "C" ?  "D" : "C";

        let cant    =  parseFloat($(".addtonos"+tono+fila).text());
        let cant2   =  parseFloat($(".addtonos"+tono2+fila).text());


        // console.log(tipo,fila,tono,cant,tono2,cant2,maximodefectos);
        cant += tipo;

        if((cant + cant2 ) <= maximodefectos){
            
            if(cant >= 0 ){ 
                $(".addtonos"+tono+fila).text(cant);
            }

        }


    });

// $("#btnbuscarficha").click(function(){
//     alert("RAAAAAAAAAA");
// }); 