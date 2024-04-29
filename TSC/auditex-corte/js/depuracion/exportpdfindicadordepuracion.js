// EXPORTAR PDF INDICADOR
function exportPDFIndicador(){


    // let indicadorgeneral = html2canvas(document.getElementById("chartgeneral"), {
    //     onrendered: function(canvas) {
    //         return canvas.toDataURL('image/png');              
    //         // var imgData = canvas.toDataURL('image/png');i
    //         // console.log('Report Image URL: '+imgData);
    //         // var doc = new jsPDF('p', 'mm', [297, 210]); //210mm wide and 297mm high
            
    //         // doc.addImage(imgData, 'PNG', 10, 10);
    //         // doc.save('sample.pdf');
    //     }
    // });

    // return indicadorgeneral;
}

// ASIGNAMOS IMAGENES AL PDF
function sethtml2Canvas(contenido,x,y,width,height,save = false){
    
    html2canvas(document.getElementById(contenido), {
        onrendered: function(canvas) {

            // CREAMOS IMAGEN
            var imgData = canvas.toDataURL('image/png');
            // AGREGAMOS IMAGEN AL PDF
            DOCPDF.addImage(imgData, 'PNG', x,y,width,height);

            if(save){
                // GUADAMOS PDF
                DOCPDF.save('sample.pdf');
            }
        }
    });

}