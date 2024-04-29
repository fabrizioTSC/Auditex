 // GET GENERALES
 async function getIndicadorGeneral(parametros){
    try{
        let response  = await post("auditex-testing","indicadortesting","getindicadorgeneral",parametros);
        setTablaIndicador(response,"tblgeneral");

        // return response;    
    }catch(error){
        console.log(error);
        Advertir("Ocurrio un error al generar indicador");
    }
} 

// GET PROVEEDORES
async function getIndicadorProveedores(parametros){
    try{
        let response  = await post("auditex-testing","indicadortesting","getindicadorproveedores",parametros);
        // console.log("GENERAL",response);

        let proveedores = DistinctArray(response,"PROVEEDOR");
        setTablaIndicadorProveedor(response,"proveedores");
        console.log("PROVEEDORES",proveedores);

        // return response;    
    }catch(error){
        console.log(error);
        Advertir("Ocurrio un error al generar indicador");
    }
} 

// GET CLIENTES
async function getIndicadorClientes(parametros){
    try{
        let response  = await post("auditex-testing","indicadortesting","getindicadorclientes",parametros);
        // console.log("GENERAL",response);

        // let proveedores = DistinctArray(response,"PROVEEDOR");
        setTablaIndicadorProveedor(response,"clientes");
        // console.log("PROVEEDORES",proveedores);

        // return response;    
    }catch(error){
        console.log(error);
        Advertir("Ocurrio un error al generar indicador");
    }
} 

// DATOS DE TELA
function getDatosTabla(idthead,idtbody,idtfoot) {

    // HEAD
    let thead = document.getElementById(idthead);
    let trthead = thead.children[0];
    let THEADDATOS = [];
    let TBODY = [];

    if(trthead.children.length > 0){

        for (let i = 0; i < trthead.children.length; i++) {
            THEADDATOS.push(trthead.children[i].innerText);
        }

    }

    

    // TBODYS
    let tbody   = document.getElementById(idtbody);

    if(tbody.children.length > 0){

        for(let i = 0; i < tbody.children.length; i++){

            let tr              = tbody.children[i];
            let trarray = [];
            for(let j = 0; j < tr.children.length; j++){
    
                let td      =  tr.children[j];
    
                let texto           = td.innerText;
                // let background      = td.style.background;
                let background      = td.dataset.color;
                background = background ? hexToRgb(background) : "";
    
                trarray.push(
                    {
                        texto,
                        background
                    }
                );
            }
    
            TBODY.push(trarray);        
        }

    }



    // console.log(TBODY);


    // let trbody = tbody.children[0];
    // let TBODY1 = [];

    // for (let i = 0; i < trbody1.children.length; i++) {
        // TBODY1.push(trbody1.children[i].innerText);
    // }

    // // TBODY 2
    // //let tbody = document.getElementById(idtbody);
    // let trbody2 = tbody.children[1];
    // let TBODY2 = [];

    // for (let i = 0; i < trbody2.children.length; i++) {
    //     TBODY2.push(trbody2.children[i].innerText);
    // }

    // // TBODY 3
    // //let tbody = document.getElementById(idtbody);
    // let trbody3 = tbody.children[2];
    // let TBODY3 = [];

    // for (let i = 0; i < trbody3.children.length; i++) {
    //     TBODY3.push(trbody3.children[i].innerText);
    // }

    // // TBODY 4
    // //let tbody = document.getElementById(idtbody);
    // let trbody4 = tbody.children[3];
    // let TBODY4 = [];

    // for (let i = 0; i < trbody4.children.length; i++) {
    //     TBODY4.push(trbody4.children[i].innerText);
    // }

    // // TFOOT 1
    // let tfoot = document.getElementById(idtfoot);
    // let trtfoot = tfoot.children[0];
    // let TFOOT = [];

    // for (let i = 0; i < trtfoot.children.length; i++) {
    //     TFOOT.push(trtfoot.children[i].innerText);
    // }

    // // TFOOT 2  
    // // let tfoot2 = document.getElementById(idtfoot);
    // let trtfoot2 = tfoot.children[1];
    // let TFOOT2 = [];

    // for (let i = 0; i < trtfoot2.children.length; i++) {
    //     TFOOT2.push(trtfoot2.children[i].innerText);
    // }


    // DEVOLVEMOS DATOS
    return {
        thead: THEADDATOS,
        tbody: TBODY,
        // tbody2: TBODY2,
        // tbody3: TBODY3,
        // tbody4: TBODY4,
        // tfoot1: TFOOT,
        // tfoot2: TFOOT2
    }



}

 // GET PROVEEDORES
async function getproveedores(){
    PROVEEDOR = await get("auditex-testing","testing","getproveedorestela",{});
    setComboSimple("cboproveedor",PROVEEDOR,"DESCRIPCIONPROVEEDOR","IDPROVEEDOR",true,false,"TODOS");
}

// GET PROVEEDORES
async function getclientes(){
    CLIENTE = await get("auditex-testing","testing","getclientes",{});
    setComboSimple("cbocliente",CLIENTE,"DESCRIPCIONCLIENTE","IDCLIENTE",true,false,"TODOS");
}

// GET TIPO TELAS
 async function gettipotela(){
    TIPOTELA = await get("auditex-testing","testing","gettipostela",{});
    setComboSimple("cbotipotela",TIPOTELA,"DESTEL","DESTEL",true,false,"TODOS");
}

// PROGRAMA SSEGUN CLIENTE
$("#cbocliente").change(function(){
    let id = $("#cbocliente").val();
    getprogramacliente(id).then(response => {

    }).catch(error => {
        Advertir("Ocurrio un error al obtener programa");
        console.log(error);
    })
});

// GET PROGRAMA CLIENTE
async function getprogramacliente(idcliente){

    let response = await get("auditex-testing","testing","getprogramacliente",{
        idcliente
    });
    // console.log(response);
    setComboSimple("cboprograma",response,"PROGRAMA","PROGRAMA");

}