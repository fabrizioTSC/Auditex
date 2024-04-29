const URLGLOBAL = "/TSC/";
// const URLGLOBAL = "/";


// SOLICITUDES GET PARA OBTENER UN JSON O UN HTML
async function get(modulo,controller,operacion,parameters = {},html = false){
    
    try{
        // DATOS QUE VAMOS A DEVOLVER
        let response;
        // PARAMETROS 
        let datos = {};

        datos = parameters;
        datos.operacion = operacion;

        //  EJECUTAMOS
        response = await $.ajax({
          url :`${URLGLOBAL}controllers/${modulo}/${controller}.controller.php`,
          type:'get',
          data:datos
        })
        // PARSEAMOS RESULTADO
        response = !html  ? JSON.parse(response) : response;
        // DEVOLVEMOS
        return response;
    }catch(error){
      // console.log(error);
      // Advertir("Ajax error: " + JSON.stringify(error));
      Advertir("Ajax error: " + JSON.stringify(error));
    }
    
}

// SOLICITUDES POST
async function post(modulo,controller,operacion,parameters,html = false){
    
    try{
      // DATOS QUE VAMOS A DEVOLVER
      let response;
      // PARAMETROS 
      let datos = {};

      datos.operacion = operacion;
      datos.parameters = parameters;
    
      //  EJECUTAMOS
      response = await $.ajax({
        url :`${URLGLOBAL}controllers/${modulo}/${controller}.controller.php`,
        type:'post',
        data:datos
      })

      // PARSEAMOS RESULTADO
      // response = JSON.parse(response);
      response = !html  ? JSON.parse(response) : response;
      
      // DEVOLVEMOS
      return response;
    }catch(error){
      console.log(error);
      Advertir("Ajax error: " + JSON.stringify(error));
    }
}


// // SOLICITUDES POST
// async function MoverArchivos(controller,parameters,html = false){
    

//   // DATOS QUE VAMOS A DEVOLVER
//   let response;
//   // PARAMETROS 
//   // let datos = {};

//   // datos.operacion = operacion;
//   // datos.parameters = parameters;

//   //  EJECUTAMOS
//   response = await $.ajax({
//     url :`${URLGLOBAL}controllers/${controller}.controller.php`,
//     type:'post',
//     data:parameters,
//     cache 	: false,
//     contentType : false,
//     processData : false
//   })

//   // PARSEAMOS RESULTADO
//   // response = JSON.parse(response);
//   response = !html  ? JSON.parse(response) : response;
  
//   // DEVOLVEMOS
//   return response;
// }

// SOLICITUDES POST
async function MoverArchivos(modulo,controller,parameters,html = false){
    

  // DATOS QUE VAMOS A DEVOLVER
  let response;


  //  EJECUTAMOS
  response = await $.ajax({
    // url :`${URLGLOBAL}controllers/${controller}.controller.php`,
    url :`${URLGLOBAL}controllers/${modulo}/${controller}.controller.php`,
    type:'post',
    data:parameters,
    cache 	: false,
    contentType : false,
    processData : false
  })

  // PARSEAMOS RESULTADO
  response = !html  ? JSON.parse(response) : response;
  
  // DEVOLVEMOS
  return response;
}



// DELETE
async function eliminar(controller,id){
    
  // DATOS QUE VAMOS A DEVOLVER
  let response;
  // PARAMETROS 
  let datos = {};

  datos.operacion = "eliminar";
  datos.id = id;
 
  //  EJECUTAMOS
  response = await $.ajax({
    url :`${URLGLOBAL}controllers/${controller}.controller.php`,
    type:'post',
    data:datos
  })

   // PARSEAMOS RESULTADO
  response = JSON.parse(response);
  // DEVOLVEMOS
  return response;
}

// LLENAR COMBO SIMPLE
function setComboSimple(combo,data,nombre,id,select = true,datajson = false,textdefault = "SELECCIONE",valordefault = ''){

  // console.log(data);
  
  let option = select ? `<option value='${valordefault}'>[${textdefault}]</option>` : "";

  for(let obj of data){
    let datahtml = "";
    if(datajson){
      for(let i in datajson){
        datahtml += ` data-${i}='${obj[i]}' `;
      }
    }

    option += `
      <option value='${obj[id]}' ${datahtml} > ${obj[nombre]} </option>
    `;
  }

  $(`#${combo}`).html(option);

}




// SOLICITUDES GET PARA OBTENER UN JSON O UN HTML
function getsync(modulo,controller,operacion,parameters = {},func){
    
  try{
      // DATOS QUE VAMOS A DEVOLVER
      let response;
      // PARAMETROS 
      let datos = {};

      datos = parameters;
      datos.operacion = operacion;

      //  EJECUTAMOS
      $.ajax({
        url :`${URLGLOBAL}controllers/${modulo}/${controller}.controller.php`,
        type:'get',
        data:datos,
        success:function(e){
          func(e);
        }
      });
      // .success(function(e){
      // })
      // PARSEAMOS RESULTADO
      // response = !html  ? JSON.parse(response) : response;
      // DEVOLVEMOS
      // return response;
  }catch(error){
    console.log(error);
    // Advertir("Ajax error: " + JSON.stringify(error));
    Advertir("Ajax error: " + JSON.stringify(error));
  }
  
}
