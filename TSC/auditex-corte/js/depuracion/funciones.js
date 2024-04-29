    // GET FICHA
    function getFicha(){

        let ficha = $("#txtficha").val().trim();
        MostrarCarga("Buscando ficha");
        get("auditex-corte","depuracion","getficha",{ficha})    
            .then(response => {
                
                frmficha.reset();

                if(response){
                    // GUARDAMOS DATOS EN VARIABLES
                    IDDEPURACION = response.IDDEPURACION == "" ? null : response.IDDEPURACION;
                    PARTIDA = response.PARTIDA;
                    OBSERVACION = response.OBSERVACION;
                    PESO = response.PESO;
                    FICHA = response.FICHA;

                    // ASIGNAMOS DATOS EN LOS CONTROLES
                    $("#txtficha").val(response.FICHA);
                    $("#txtcliente").val(response.CLIENTE);
                    $("#txtpedido").val(response.PEDIDO_VENDA);
                    $("#txtpartida").val(response.PARTIDA);
                    $("#txtcantidadficha").val(response.CANTFICHA);
                    $("#txtproveedor").val(response.PROVEEDOR);
                    $("#txtcolor").val(response.COLOR);
                    $("#txtprograma").val(response.PROGRAMA);
                    $("#txtusuario").val(response.USUARIO);
                    $("#txtfechainicio").val(response.FINICIO);
                    $("#txtfechafin").val(response.FFIN);
                    $("#txtobservaciones").val(response.OBSERVACION);
                    $("#txtpeso").val( parseFloat(response.PESO));

                    $("#card-motivos").text("MOTIVO: " + response.DEFECTOS);

                    // IR A LA PARTIDA
                    $("#refpartida").attr("href",`/TSC-WEB/auditoriatela/VerAuditoriaTela.php?partida=${response.PARTIDA}&codtel=${response.CODTEL}&codprv=${response.CODPRV}&numvez=${response.NUMVEZ}&parte=1&codtad=1`);

                    // `#${tipo}encogimientobefore`

                    $("label").addClass('active');

                    getFichaDetalle(ficha,response.ESTADO);

                }else{
                    Advertir("No se encontraron datos",1000);
                }

                // console.log(response.ESTADO);

                // SI LA FICHA ESTA CERRADO LA OCULTAMOS
                if(response.ESTADO == "1"){
                    $(".inhabilitar").attr("disabled",true);
                }else{
                    $(".inhabilitar").removeAttr("disabled",false);
                }


            })
            .catch(error => {
                AdvertirMini("error :(");
                console.log(error);
            })

    }

    // GET FICHA DETALLE
    function getFichaDetalle(ficha,estado){

        get("auditex-corte","depuracion","getfichadetalle",{ficha,estado},true)    
            .then(response => {
                $("#tbodyficha").html(response);
                // RESUMEN
                getResumenFichaDepuracion(ficha);
            })
            .catch(error => {
                console.log(error);
                AdvertirMini("Error buscando el detalle de la ficha");
            });

    }

    // RESUMEN FICHA
    function getResumenFichaDepuracion(ficha){

        get("auditex-corte","depuracion","getresumenfichadepuracion",{ficha},true)    
            .then(response => {
                $("#tbodyresumen").html(response);
                //InformarMini("Datos encontrados",1000);
                OcultarCarga();
            })
            .catch(error => {
                console.log(error);
                AdvertirMini("Error buscando el resumen de la ficha");
            });

    }

    // REGISTRAR FICHA CABECERA
    async function setFichaCabecera(){

        try{

            PESO        =  $("#txtpeso").val().trim();
            OBSERVACION =  $("#txtobservaciones").val().trim();

            if(PARTIDA != null && FICHA != null){
                let response = await post("auditex-corte","depuracion","setdepuracion",[
                    IDDEPURACION,   PARTIDA,    null,   OBSERVACION,
                    PESO,           FICHA
                ]) ;
                    
                if(response.TIPO == "1"){
                    IDDEPURACION = response.ID;
                }else{
                    Advertir(response.MENSAJE);
                }
                
                // console.log(response);
            }else{
                AdvertirMini("No selecciono ninguna ficha");
            }

        }catch(error){
            AdvertirMini("Ocurrio un error al registrr la ficha");
            console.log(error);
        }

    }

    // REGISTRAMOS PAQUETES
    async function setPaquetes(datos){


        try{

            // REGISTRAMOS FICHA DEPURACION
            if(IDDEPURACION == null){
                await setFichaCabecera();
                datos[1] = IDDEPURACION;
            }   
            
            let response = await post("auditex-corte","depuracion","setpaquetesdepuracion",datos) ;
            // console.log(response);    
            if(response.TIPO == "1"){
                IDPAQUETE = response.ID;
            }else{
                IDPAQUETE = null;
                Advertir(response.MENSAJE);
            }
    

        }catch(error){
            AdvertirMini("Ocurrio un error al registrar paquete");
            console.log(error);
        }

    }

    // DEFECTOS SEGUN PAQUETE
    async function getDefectosPaquete(idpaquete){
        try{
            let response = await get("auditex-corte","depuracion","getdefectospaquete",{idpaquete},true);
            $("#tbodydefectos").html(response);
            OcultarCarga();
            // InformarMini("Correcto");

        }catch(error){
            AdvertirMini("Ocurrio un error al obtener los defectos");
            console.log(error);
        }
    }

    // DEFECTOS SEGUN PAQUETE
    async function getDefectosNotInPaquete(idpaquete){
        try{
            let response = await get("auditex-corte","depuracion","getdefectosnotinpaquete",{idpaquete});
            // setComboSimple();
            setComboSimple("cbodefectos",response,"DESDEF","CODDEF");

            // $("#tbodydefectos").html(response);
            // InformarMini("Correcto");

        }catch(error){
            AdvertirMini("Ocurrio un error al obtener los defectos");
            console.log(error);
        }
    }

    // FUNTION REGISTRAMOS DEFECTOS
    async function setDefectosDepuracion(data){

        MostrarCarga();

        try{

            let response = await post("auditex-corte","depuracion","setdefectosdepuracion",data) ;
            // console.log(response);
            if(response.success){
                await getDefectosNotInPaquete(IDPAQUETE);
                await getDefectosPaquete(IDPAQUETE);
                frmdefectos.reset();
            }else{
                Advertir(response.rpt)
            }

        }catch(error){
            AdvertirMini("Ocurrio un error al registrar defecto");
            console.log(error);
        }

    }

    // GET DEFECTOS DEPURACION
    function getDefectosFicha(){

        get("auditex-corte","depuracion","getdefectosficha",{
            iddepuracion:IDDEPURACION
        }).then(response => {
            $("#card-motivos").text("MOTIVO: " + response.DEFECTOS);
        }).catch(error => {
            AdvertirMini("Ocurrio un error al obtener los defectos de la ficha");
            console.log(error);
        })

        // try{
        //     let response = await get("auditex-corte","depuracion","getdefectosficha",{
        //         iddepuracion:IDDEPURACION
        //     }) ;

        //     $("#card-motivos").text("MOTIVO: " + response.DEFECTOS);

        // }catch(error){
        //     AdvertirMini("Ocurrio un error al obtener los defectos de la ficha");
        //     console.log(error);
        // }
    }