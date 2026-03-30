/*TABLA DE BASE DE CLIENTES*/
$('#tblmisclientes').DataTable({
  "fixedColumns":   {
                     "leftColumns": 1
                    },
  "order": [[1, "asc"]],
  "dom":'Bfrtip',
  "buttons": ['copy','csv','excel','pdf','print'],
  "language":{
    "lengthMenu": "Mostrar _MENU_ registros por pagina",
    "info": "Mostrando pagina _PAGE_ de _PAGES_",
    "infoEmpty": "No hay registros disponibles",
    "infoFiltered": "(filtrada de _MAX_ registros)",
    "loadingRecords": "Cargando...",
    "processing":     "Procesando...",
    "search": "Buscar:",
    "zeroRecords":    "No se encontraron registros coincidentes",
    "paginate": {
      "next":       "Siguiente",
      "previous":   "Anterior"
    },
  }
});

/*TABLA DE BASE DE CLIENTES FILTRADA*/
function InitOverviewDataTable() {
var table_baseClientes =  $('#tblmisclientes_filtro').DataTable({
         "fixedColumns":   {
                            "leftColumns": 1
                           },
         "order": [[1, "asc"]],
         "dom":'Bfrtip',
         "buttons": ['copy','csv','excel','pdf','print'],
         "language":{
           "lengthMenu": "Mostrar _MENU_ registros por pagina",
           "info": "Mostrando pagina _PAGE_ de _PAGES_",
           "infoEmpty": "No hay registros disponibles",
           "infoFiltered": "(filtrada de _MAX_ registros)",
           "loadingRecords": "Cargando...",
           "processing":     "Procesando...",
           "search": "Buscar:",
           "zeroRecords":    "No se encontraron registros coincidentes",
           "paginate": {
             "next":       "Siguiente",
             "previous":   "Anterior"
           },
         }
       });
}

/*TABLA DE MIS CLIENTES*/
$('#tblmisclientes_prospecto').DataTable({
  "fixedColumns":   {
                     "leftColumns": 1
                    },
  "order": [[1, "asc"]],
  "dom":'Bfrtip',
  "buttons": ['copy','csv','excel','pdf','print'],
  "language":{
    "lengthMenu": "Mostrar _MENU_ registros por pagina",
    "info": "Mostrando pagina _PAGE_ de _PAGES_",
    "infoEmpty": "No hay registros disponibles",
    "infoFiltered": "(filtrada de _MAX_ registros)",
    "loadingRecords": "Cargando...",
    "processing":     "Procesando...",
    "search": "Buscar:",
    "zeroRecords":    "No se encontraron registros coincidentes",
    "paginate": {
      "next":       "Siguiente",
      "previous":   "Anterior"
    },
  }
});

/*TABLA DE BASE DE CLIENTES FILTRADA*/
function InitOverviewDataTable_mycustomer() {
var table_baseMisClientes =  $('#tblmisclientes_prospecto_filtro').DataTable({
         "fixedColumns":   {
                            "leftColumns": 1
                           },
         "order": [[1, "asc"]],
         "dom":'Bfrtip',
         "buttons": ['copy','csv','excel','pdf','print'],
         "language":{
           "lengthMenu": "Mostrar _MENU_ registros por pagina",
           "info": "Mostrando pagina _PAGE_ de _PAGES_",
           "infoEmpty": "No hay registros disponibles",
           "infoFiltered": "(filtrada de _MAX_ registros)",
           "loadingRecords": "Cargando...",
           "processing":     "Procesando...",
           "search": "Buscar:",
           "zeroRecords":    "No se encontraron registros coincidentes",
           "paginate": {
             "next":       "Siguiente",
             "previous":   "Anterior"
           },
         }
       });
}

/*Comienza llenado de combobox de gerencia base de clientes*/
$('#txtzona_filtro_base_clientes_1').change(function()
{
  var el_idzona = $(this).val();

  // Lista de tiendas
  $.post('fnsvaclient.php', { var_zona: el_idzona} ).done( function( respuesta )
  {
    $( '#txttienda_filtro_base_clientes_2' ).html( respuesta );

     $('#txttienda_filtro_base_clientes_2').selectpicker('refresh');

  });
});

$('#txttienda_filtro_base_clientes_2').change(function()
{
  var el_tienda = $(this).val();

  // Lista de tiendas
  $.post('fnsvaclient.php', { var_tienda: el_tienda} ).done( function( respuesta )
  {
    $( '#txtempleado_filtro_base_clientes_3' ).html( respuesta );

     $('#txtempleado_filtro_base_clientes_3').selectpicker('refresh');

  });
});
/*Termina llenado de combobox de gerencia base de clientes*/

/*Comienza llenado de combobox de gerencia mis clientes*/
$('#txtzona_filtro_mis_clientes_1').change(function()
{
  var el_idzona = $(this).val();

  // Lista de tiendas
  $.post('fnsvaclient.php', { var_zona: el_idzona} ).done( function( respuesta )
  {
    $( '#txttienda_filtro_mis_clientes_2' ).html( respuesta );

     $('#txttienda_filtro_mis_clientes_2').selectpicker('refresh');

  });
});

$('#txttienda_filtro_mis_clientes_2').change(function()
{
  var el_tienda = $(this).val();

  // Lista de tiendas
  $.post('fnsvaclient.php', { var_tienda: el_tienda} ).done( function( respuesta )
  {
    $( '#txtempleado_filtro_mis_clientes_3' ).html( respuesta );

     $('#txtempleado_filtro_mis_clientes_3').selectpicker('refresh');

  });
});
/*Termina llenado de combobox de gerencia mis clientes*/

/*Comienza llenado de combobox de gerencia funnel*/
$('#txtzona_filtro_funnel_3').change(function()
{
  var el_idzona = $(this).val();

  // Lista de tiendas
  $.post('fnsvaclient.php', { var_zona: el_idzona} ).done( function( respuesta )
  {
    $( '#txttienda_filtro_funnel_3' ).html( respuesta );

     $('#txttienda_filtro_funnel_3').selectpicker('refresh');

  });
});

$('#txttienda_filtro_funnel_3').change(function()
{
  var el_tienda = $(this).val();

  // Lista de tiendas
  $.post('fnsvaclient.php', { var_tienda: el_tienda} ).done( function( respuesta )
  {
    $( '#txtempleado_filtro_funnel_3' ).html( respuesta );

     $('#txtempleado_filtro_funnel_3').selectpicker('refresh');

  });
});
/*Termina llenado de combobox de gerencia mis funnel*/


/*MUESTRA LOS CLIENTES DE LA BASE DE PROSPECTOS SEGUN LOS FILTROS PARA CUANDO EL USUARIO SEA GERENCIA*/
    $('#btnfiltrar_base_clientes_3').click(function(){

               //event.preventDefault();
          var zona_basepros_gerencia_ = document.querySelector('#txtzona_filtro_base_clientes_1').value,
              tienda_basepros_gerencia_ = document.querySelector('#txttienda_filtro_base_clientes_2').value,
              ejecutivo_basepros_gerencia_  =  document.querySelector('#txtempleado_filtro_base_clientes_3').value;


              $.ajax({
                 url:"fnsvaclient.php?zonabaseprosgeren="+zona_basepros_gerencia_+'&tiendabaseprosgeren='+tienda_basepros_gerencia_+'&ejecutivobasegeren='+ejecutivo_basepros_gerencia_,
                 beforeSend: function(objeto){
                $('#vista_general_base_clientes_prospecto').html('');
                $("#cargando_base_prospectos").html('<div class="loading"><img src="../img/ajax-loader.gif" alt="loading" /><br/>Cargando informacion de base de prospectos, un momento por favor...</div>');
                },
                success:function(data){

                $("#cargando_base_prospectos").html('');
                $("#vista_general_base_clientes_prospecto").html(data).fadeIn('slow');
                InitOverviewDataTable();

                }
              })

         });

/*MUESTRA LOS CLIENTES EN LA PESTAÑA MIS DE CLIENTES SEGUN LOS FILTROS PARA CUANDO EL USUARIO SEA GERENCIA*/
             $('#btnfiltrar_mis_clientes_3').click(function(){

                        //event.preventDefault();
                   var zona_mispros_gerencia_ = document.querySelector('#txtzona_filtro_mis_clientes_1').value,
                       tienda_mispros_gerencia_ = document.querySelector('#txttienda_filtro_mis_clientes_2').value,
                       ejecutivo_mispros_gerencia_  =  document.querySelector('#txtempleado_filtro_mis_clientes_3').value;


                       $.ajax({
                          url:"fnsvaclient.php?zonamisprosgeren="+zona_mispros_gerencia_+'&tiendamisprosgeren='+tienda_mispros_gerencia_+'&ejecutivomisgeren='+ejecutivo_mispros_gerencia_,
                          beforeSend: function(objeto){
                         $('#vista_general_mis_clientes_prospecto').html('');
                         $("#cargando_mis_prospectos").html('<div class="loading"><img src="../img/ajax-loader.gif" alt="loading" /><br/>Cargando informacion de base de prospectos, un momento por favor...</div>');
                         },
                         success:function(data){

                         $("#cargando_mis_prospectos").html('');
                         $("#vista_general_mis_clientes_prospecto").html(data).fadeIn('slow');
                         InitOverviewDataTable_mycustomer();

                         }
                       })

                  });

                  HelloWorld = function () {

                    var zona_funnel_gerencia_ = document.querySelector('#txtzona_filtro_funnel_3').value,
                        tienda_funnel_gerencia_  = document.querySelector('#txttienda_filtro_funnel_3').value,
                        carnet_funnel_gerencia_ = document.querySelector('#txtempleado_filtro_funnel_3').value,
                        inicia_periodo_funnel_gerencia_ = document.querySelector('#periodo_inicia_filtro_funnel_3').value,
                        finaliza_periodo_funnel_gerencia_  = document.querySelector('#periodo_finaliza_filtro_funnel_3').value;

                    $('#content_funnel').html('<div class="loading"><img src="../img/ajax-loader.gif" alt="loading" /><br/>Cargando informacion a la tabla, un momento por favor...</div>');

                   $.ajax({
                           url:"fnsvaclient.php?zona_funnel_gerencia_table="+zona_funnel_gerencia_+"&tienda_funnel_gerencia_table="+tienda_funnel_gerencia_+"&carnet_funnel_gerencia_table="+carnet_funnel_gerencia_+"&inicia_periodo_funnel_gerencia_table="+inicia_periodo_funnel_gerencia_+"&finaliza_periodo_funnel_gerencia_table="+finaliza_periodo_funnel_gerencia_,
                           success:function(data)
                           {
                               $('#content_funnel').html('');
                               $('#more_data').html(data);

                           }
                         })


                                           };

                  var buttons = Highcharts.getOptions().exporting.buttons.contextButton.menuItems;

                                        buttons.push({
                                         text: "View more data",
                                         onclick: HelloWorld
                                         });

                  /*Crea el embudo a partir de filtros gerenciales*/
                  function fn_draw_funnel_sales_filter_gerencia(valores)
                  {
                      Highcharts.chart('container', {
                         chart: {
                             type: 'funnel'
                         },
                         title: {
                             text: 'Embudo de Ventas'
                         },
                         plotOptions: {
                             series: {
                                 dataLabels: {
                                     enabled: true,
                                     format: '<b>{point.name}</b> ({point.y:,.0f})',
                                     softConnector: true
                                 },
                                 center: ['50%', '50%'],
                                 neckWidth: '30%',
                                 neckHeight: '25%',
                                 width: '80%'
                             }
                         },
                         legend: {
                             enabled: false
                         },
                         exporting: {
        buttons: {
            contextButton: {
                menuItems: buttons
            }
        }
    },
                         series: [{
                             name: 'Clientes unicos',
                             data: valores
                         }],

                         responsive: {
                             rules: [{
                                 condition: {
                                     maxWidth: 500
                                 },
                                 chartOptions: {
                                     plotOptions: {
                                         series: {
                                             dataLabels: {
                                                 inside: true
                                             },
                                             center: ['50%', '50%'],
                                             width: '100%'
                                         }
                                     }
                                 }
                             }]
                         }
                     });
                   }


                 /*MUESTRA EL EMBUDO DE VENTAS DEL EJECUTIVO*/
                  $('#btnfiltrar_filtro_funnel_3').click(function(event){

                    var zona_funnel_gerencia_ = document.querySelector('#txtzona_filtro_funnel_3').value,
                        tienda_funnel_gerencia_  = document.querySelector('#txttienda_filtro_funnel_3').value,
                        carnet_funnel_gerencia_ = document.querySelector('#txtempleado_filtro_funnel_3').value,
                        inicia_periodo_funnel_gerencia_ = document.querySelector('#periodo_inicia_filtro_funnel_3').value,
                        finaliza_periodo_funnel_gerencia_  = document.querySelector('#periodo_finaliza_filtro_funnel_3').value;

                    $('#content_funnel').html('<div class="loading"><img src="../img/ajax-loader.gif" alt="loading" /><br/>Cargando informacion del embudo de ventas, un momento por favor...</div>');

                   $.ajax({
                           url:"fnsvaclient.php",
                           method:"POST",
                           async: true,
                           data:{ zona_funnel_gerencia : zona_funnel_gerencia_, tienda_funnel_gerencia: tienda_funnel_gerencia_, carnet_funnel_gerencia:carnet_funnel_gerencia_, carnet_funnel_gerencia:carnet_funnel_gerencia_ , inicia_periodo_funnel_gerencia:inicia_periodo_funnel_gerencia_, finaliza_periodo_funnel_gerencia:finaliza_periodo_funnel_gerencia_},
                           dataType:"JSON",
                           success:function(data)
                           {
                               $('#content_funnel').html('');
                               fn_draw_funnel_sales_filter_gerencia(data);

                           }
                         })

                  })
