// LEEMOS IMAGENES
$("#input_imagenes").change(function(){

    // QUITAMOS HIJOS ANTES DE LEER IMAGENES
    let contenedor = document.getElementById("container-imagenes");

    while(contenedor.firstChild){
           contenedor.removeChild(contenedor.firstChild);
    }

    addimage(this);

});

// LEEMOS IMAGEN GENERAL
$("#input_imagegeneral").change(function(){

    readImage(this);
});

function readImage(file){
    var reader = new FileReader();

    reader.onload = function(e){
        
        // CREAMOS IMAGEN
        let img = document.getElementById("imggeneralcarga");
        img.src = e.target.result;
    }

    reader.readAsDataURL(file.files[0]);
}

// FUNCION PARA AGREGAR IMAGENES Y MOSTRARLAR
function addimage(input){

    let contenedor = document.getElementById("container-imagenes");

    // RECORREMOS ARCHIVOS
    for(let file of input.files){

        var reader = new FileReader();
        reader.onload = function(e){


            // CREAMOS IMAGEN
            let img = document.createElement("img");
            img.src = e.target.result;
            img.classList = "imgsubidas";

            // CREAMOS DIV
            let div = document.createElement("div");
            div.classList = "col-md-4 mb-md-2";

            // AGREGAMOS IMAGEN A DIV
            div.appendChild(img);
            // DIV CONTENEDOR 
            contenedor.appendChild(div);
        }

        reader.readAsDataURL(file);

    }


}


// OBTENEMOS IMAGENES
async function getimageencogimientos(){


    // QUITAMOS HIJOS ANTES DE LEER IMAGENES
    let contenedor = document.getElementById("container-imagenes");

    while(contenedor.firstChild){
           contenedor.removeChild(contenedor.firstChild);
    }

    let response = await get("auditex-moldes", "encogimientoscorte", "getimagenespruebaencogimiento", {
        ficha:FICHA
    });

    let img = "";
    // RECORREMOS IMAGENES
    for(let item of response){

        img += `
        
            <div class='col-md-4 mb-md-2'>
                <img src='/tsc/public/auditex-moldes/tmpencogimientos/${item.RUTAIMG}' class='imgsubidas'>
            </div>

        `;

    }

    $("#container-imagenes").html(img);

    // console.log(response);

}

// IMPRIMIR PDF
$("#btnimprimirpdf").click(function(){
    window.open(`pdfencogimientos.php?ficha=${FICHA}&partida=${PARTIDA}`,"_blank");
    // window.open()
});