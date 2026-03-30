
  $(document).on('click', '.edit_data', function(){

       var employee_id = $(this).attr("id");
       $('#idfila').val(employee_id);
       });

/*  $("#btnguardar").click(function(){
     $("#btnguardar").attr("disabled", true);
 });*/

  /*CONSULTA LA INFORMACION BASICA DEL CLIENTE*/
  $("#numcontrato").focusout(function(){
        var ncontrato = $("#numcontrato").val();
        var facturador = $("#sisfacturador").val();

        $('#numcontrato').val(ncontrato);

        if(ncontrato != '')
        {

          //Añadimos la imagen de carga en el contenedor
          $('#content').html('<div class="loading"><img src="../img/ajax-loader.gif" alt="loading" /><br/>Buscando cliente un momento, por favor...</div>');

            if(facturador == 'BSCS')
            {
              $.ajax({
               url:"fncredito.php",
               method:"POST",
               data:{numecontrato:ncontrato},
               dataType:"JSON",
               success:function(data)
               {
                  //Quitamos la imagen de carga en el contenedor
                  $('#content').html('');
                  $('#cliente').val(data.costumer);


               }
                    })

                    $('#contentservicio').html('<div class="loading"><img src="../img/ajax-loader.gif" alt="loading" /><br/>Buscando servicio asociado, un momento por favor...</div>');

                    $.post('fncredito.php', { num_movil: ncontrato } ).done(function (respuesta)
                     {
                       $('#contentservicio').html('');
                       $('#servicio').html(respuesta);
                     });
            }

            if(facturador == 'OPEN')
            {
              $.ajax({
               url:"fncredito.php",
               method:"POST",
               data:{idcontratomultimedia:ncontrato},
               dataType:"JSON",
               success:function(data)
               {
                  //Quitamos la imagen de carga en el contenedor
                  $('#content').html('');
                  $('#cliente').val(data.cliente);
               }
                    })

                    $('#contentservicio').html('<div class="loading"><img src="../img/ajax-loader.gif" alt="loading" /><br/>Buscando servicio asociado, un momento por favor...</div>');

                    $.post('fncredito.php', { numcontratomultimedia: ncontrato } ).done(function (respuesta)
                     {
                       $('#contentservicio').html('');
                       $('#servicio').html(respuesta);
                     });
            }

        }else
        { //Quitamos la imagen de carga en el contenedor
        $('#content').html('');
        }
  })


 /*CONSULTA LAS FACTURAS DEL CLIENTE*/
  function load(idcontrato){
    $("#loader").fadeIn('slow');

    $.ajax({
       url:'fncredito.php?modalcontrato='+idcontrato,
       beforeSend: function(objeto){
       $('#loader').html('<img src="../img/ajax-loader.gif" alt="loading"/> Cargando...');
      },
      success:function(data){
        $(".outer_div").html(data).fadeIn('slow');
        $('#loader').html('');
      }
    })
  }

 /*SE EJECUTAR AL DAR CLIC AL BOTON AGREGAR FACTURAS*/
 $('#addfactura').click(function(){
       var ncontrato = $("#numcontrato").val();
       load(ncontrato);

  })

  function agregardetalle(id)
  {
    var fact = document.getElementById('factura_'+id).value;
    var mes = document.getElementById('mes_'+id).value;
    var montofact = document.getElementById('montofact_'+id).value;
    var montocred = document.getElementById('montocred_'+id).value;

    //Inicia validacion
    if (isNaN(montocred))
    {
    alert('Esto no es un numero');
    document.getElementById('montocred_'+id).focus();
    return false;
    }
    //Fin validacion
    $.ajax({
      url: "credito.php",
      method: "POST",
      data: {fact_:fact, mes_:mes, montofact_:montofact, montocred_:montocred},
      success: function(datos){ $("#resultados").html("factura agregada exitosamente");}
    });
  }

  /*GUARDA LA NOTA DE CREDITO*/
  $('#btnguardar').click(function(){

      $("#fechafactura").attr("type","hidden");
      var la_zona = document.getElementById("zona").value;
      var la_tienda = document.getElementById("tienda").value;
      var la_gestion = document.getElementById("gestion").value;
      var el_sisfacturador = document.getElementById("sisfacturador").value;
    /*  var el_detallereclamo = document.getElementById("detallereclamo").value; */
      var el_numcontrato = document.getElementById("numcontrato").value;
      var el_cliente = document.getElementById("cliente").value;
      var el_servicio = document.getElementById("servicio").value;
      var la_causa = document.getElementById("causas").value;
      var la_justificacion = document.getElementById("justificacion").value;
      var boton = "btnguardar";
      var bandera = 0;

      $.ajax({
                method:"POST",
                url: "fncredito.php",
                data:{zona:la_zona, tienda:la_tienda, gestion:la_gestion, sisfacturador:el_sisfacturador, numcontrato:el_numcontrato, cliente:el_cliente, servicio:el_servicio, causa:la_causa, justificacion:la_justificacion, btnguardar:boton},
                dataType:"JSON",
                success: function(data)
                {
                  $('#result').html('Informacion enviada con exito...');
                  bandera = 1;
                }
             })

        if(bandera == 1)
        {
          $("#btnguardar").attr("disabled", true);
        }


         });
})
