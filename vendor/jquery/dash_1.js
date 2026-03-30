function filter_ciclo(periodo){

var ventas = 'Ventas por zona. Periodo ';
    ventas = ventas + periodo;
var bajas = 'Bajas por zona. Periodo ';
    bajas = bajas + periodo;
var credito = 'Creditos por zona. Periodo ';
    credito = credito + periodo;
var fidelizacion = 'Fidelizacion por zona. Periodo ';
    fidelizacion = fidelizacion + periodo;
var neteo = 'Neto por zona. Periodo ';
    neteo = neteo + periodo;

$('#loader_ventas').html('<img src="../img/ajax-loader.gif" alt="loading"/> Cargando...');
$('#loader_bajas').html('<img src="../img/ajax-loader.gif" alt="loading"/> Cargando...');
$('#loader_credito').html('<img src="../img/ajax-loader.gif" alt="loading"/> Cargando...');
$('#loader_fidelizacion').html('<img src="../img/ajax-loader.gif" alt="loading"/> Cargando...');
$('#loader_neto').html('<img src="../img/ajax-loader.gif" alt="loading"/> Cargando...');
$('#loader_pais').html('<img src="../img/ajax-loader.gif" alt="loading"/> Cargando...');

var _periodo = 1;


$.ajax({
 url:"fndashboard.php",
 method:"POST",
 async: true,
 data:{periodo:_periodo},
 dataType:"JSON",
 success:function(data)
 {
    //Quitamos la imagen de carga en el contenedor
    $('#periodo').html(data.periodo);
 }
      })

//var ciclo = $('#periodo').val();

var _ingventa = 1;

$.ajax({
 url:"fndashboard.php",
 method:"POST",
 async: true,
 data:{ingventa:_ingventa},
 dataType:"JSON",
 success:function(data)
 {
    //Quitamos la imagen de carga en el contenedor
    $('#ingresoVentas').html(data.ingresoventas + " $");
 }
      })

 var _ingneto = 1;

 $.ajax({
       url:"fndashboard.php",
       method:"POST",
       async: true,
       data:{ingneto:_ingneto},
       dataType:"JSON",
       success:function(data)
       {
          //Quitamos la imagen de carga en el contenedor
          $('#ingresoNeto').html(data.ingresoneto + " $");
       }
        })

 var _cantneto = 1;
   $.ajax({
        url:"fndashboard.php",
        method:"POST",
        async: true,
        data:{cantneto:_cantneto},
        dataType:"JSON",
        success:function(data)
        {
          //Quitamos la imagen de carga en el contenedor
          $('#cantidadNeto').html("Cantidad :" + data.aportealtasbajas);
        }
          })

var _cantventa = 1;
$.ajax({
       url:"fndashboard.php",
       method:"POST",
       async: true,
       data:{cantventa:_cantventa},
       dataType:"JSON",
       success:function(data)
       {
          //Quitamos la imagen de carga en el contenedor
          $('#CantidadVentas').html("Cantidad :" + data.cantidadventas);
       }
      })

      var _egresobajas = 1;
      $.ajax({
             url:"fndashboard.php",
             method:"POST",
             async: true,
             data:{ egresobajas:_egresobajas},
             dataType:"JSON",
             success:function(data)
             {
                //Quitamos la imagen de carga en el contenedor
                $('#egresoBajas').html(data.egresobajas + " $");
             }
            })

        var _cantbajas = 1;
        $.ajax({
                   url:"fndashboard.php",
                   method:"POST",
                   async: true,
                   data:{ cantbajas: _cantbajas},
                   dataType:"JSON",
                   success:function(data)
                   {
                      //Quitamos la imagen de carga en el contenedor
                      $('#cantidadBajas').html("Cantidad : " + data.cantidadbajas);
                   }
                  })

          var _egresocredito = 1;
                  $.ajax({
                             url:"fndashboard.php",
                             method:"POST",
                             async: true,
                             data:{ egresocredito: _egresocredito},
                             dataType:"JSON",
                             success:function(data)
                             {
                                //Quitamos la imagen de carga en el contenedor
                                $('#egresoCredito').html(data.egresocreditos + " $");
                             }
                            })

          var _cantidadcredito = 1;
                  $.ajax({
                              url:"fndashboard.php",
                              method:"POST",
                              async: true,
                              data:{ cantidadcredito: _cantidadcredito},
                              dataType:"JSON",
                              success:function(data)
                              {
                                 //Quitamos la imagen de carga en el contenedor
                                 $('#cantidadCreditos').html("Cantidad : " + data.cantidadcreditos);
                              }
                         })

           var _ingfidelizacion = 1;
                    $.ajax({
                              url:"fndashboard.php",
                              method:"POST",
                              async: true,
                              data:{ ingfidelizacion : _ingfidelizacion},
                              dataType:"JSON",
                              success:function(data)
                              {
                                //Quitamos la imagen de carga en el contenedor
                                $('#ingresoFidelizacion').html(data.ingresofidelizacion + " $");
                              }
                            })


              var _cantfidelizacion = 1;
                      $.ajax({
                               url:"fndashboard.php",
                               method:"POST",
                               async: true,
                               data:{ cantfidelizacion : _cantfidelizacion},
                               dataType:"JSON",
                               success:function(data)
                               {
                                  //Quitamos la imagen de carga en el contenedor
                                  $('#cantidadFidelizacion').html("Cantidad : " + data.cantidadfidelizacion);
                               }
                             })

               $('#datos_ventas_cargando').html('<img src="../img/ajax-loader.gif" alt="loading"/> Cargando...');
               $('#datos_fidelizacion_cargando').html('<img src="../img/ajax-loader.gif" alt="loading"/> Cargando...');
               $('#datos_credito_cargando').html('<img src="../img/ajax-loader.gif" alt="loading"/> Cargando...');
               $('#datos_bajas_cargando').html('<img src="../img/ajax-loader.gif" alt="loading"/> Cargando...');
               $('#datos_neto_cargando').html('<img src="../img/ajax-loader.gif" alt="loading"/> Cargando...');

                             /*Tabla de ventas*/
                             var _zonapaisventas = "pais"
                             $.ajax({
                                      url:"fndashboardcmb.php",
                                      method:"POST",
                                      async: true,
                                      data:{ zonapaisventas : _zonapaisventas},
                                      success:function(data)
                                      {
                                         //Quitamos la imagen de carga en el contenedor
                                         $('#datos_ventas').html(data).fadeIn('slow');
                                         $('#datos_ventas_cargando').html('');
                                      }
                                    })

                             /*Tabla de fidelizacion*/
                             var _zonapaisfide = "pais"
                             $.ajax({
                                     url:"fndashboardcmb.php",
                                     method:"POST",
                                     async: true,
                                     data:{ zonapaisfide : _zonapaisfide},
                                     success:function(data)
                                     {
                                       //Quitamos la imagen de carga en el contenedor
                                       $('#datos_fidelizacion').html(data).fadeIn('slow');
                                       $('#datos_fidelizacion_cargando').html('');
                                     }
                                     })

                               /*Tabla de fidelizacion*/
                               var _zonapaiscredito = "pais"
                               $.ajax({
                                       url:"fndashboardcmb.php",
                                       method:"POST",
                                       async: true,
                                       data:{ zonapaiscredito : _zonapaiscredito},
                                             success:function(data)
                                       {
                                             //Quitamos la imagen de carga en el contenedor
                                             $('#datos_credito').html(data).fadeIn('slow');
                                             $('#datos_credito_cargando').html('');
                                       }
                                       })
                                       /*Tabla de fidelizacion*/
                                var _zonapaisbajas = "pais"
                                $.ajax({
                                        url:"fndashboardcmb.php",
                                        method:"POST",
                                        async: true,
                                        data:{ zonapaisbajas : _zonapaisbajas},
                                        success:function(data)
                                        {
                                          //Quitamos la imagen de carga en el contenedor
                                          $('#datos_bajas').html(data).fadeIn('slow');
                                          $('#datos_bajas_cargando').html('');
                                        }
                                        })

                                        /*Tabla de Neto*/
                                  var _zonaneto = "pais";
                                   $.ajax({
                                            url:"fndashboardcmb.php",
                                            method:"POST",
                                            async: true,
                                            data:{ zonaneto : _zonaneto},
                                            success:function(data)
                                            {
                                              //Quitamos la imagen de carga en el contenedor
                                              $('#datos_neto').html(data).fadeIn('slow');
                                              $('#datos_neto_cargando').html('');
                                             }
                                              })

                             /*Drill de ventas*/
                             var _zonaventas = 1;
                             var drill_ventas = "";
                                     $.ajax({
                                              url:"fndashboard.php",
                                              method:"POST",
                                              async: true,
                                              data:{ zonaventas : _zonaventas},
                                              dataType:"JSON",
                                              success:function(data)
                                              {
                                                 //Quitamos la imagen de carga en el contenedor
                                                 drill_ventas = data;
                                              }
                                            })

                             /*Drill de bajas*/
                             var _zonabajas = 1;
                             var drill_bajas = "";
                                     $.ajax({
                                              url:"fndashboard.php",
                                              method:"POST",
                                              async: true,
                                              data:{ zonabajas : _zonabajas},
                                              dataType:"JSON",
                                              success:function(data)
                                              {
                                                 //Quitamos la imagen de carga en el contenedor
                                                 drill_bajas = data;
                                              }
                                            })

                             /*Drill de credito*/
                             var _zonacreditos = 1;
                             var drill_creditos = "";
                                   $.ajax({
                                           url:"fndashboard.php",
                                           method:"POST",
                                           async: true,
                                           data:{ zonacreditos : _zonacreditos},
                                           dataType:"JSON",
                                           success:function(data)
                                           {
                                             //Quitamos la imagen de carga en el contenedor
                                             drill_creditos = data;
                                           }
                                          })

                                 /*Drill de fidelizacion*/
                                 var  _zonafidelizacion = 1;
                                 var drill_fidelizacion = "";
                                     $.ajax({
                                             url:"fndashboard.php",
                                             method:"POST",
                                             async: true,
                                             data:{ zonafidelizacion : _zonafidelizacion},
                                             dataType:"JSON",
                                             success:function(data)
                                                  {
                                                   //Quitamos la imagen de carga en el contenedor
                                                   drill_fidelizacion = data;
                                                   }
                                             })

                                             /*Drill de neto*/
                                             var _zonaneteo = 1;
                                             var drill_neteo = "";
                                                     $.ajax({
                                                              url:"fndashboard.php",
                                                              method:"POST",
                                                              async: true,
                                                              data:{ zonaneteo : _zonaneteo},
                                                              dataType:"JSON",
                                                              success:function(data)
                                                              {
                                                                 //Quitamos la imagen de carga en el contenedor
                                                                 drill_neteo = data;
                                                              }
                                                            })

  /*Funcion que carga grafica de ventas*/

  function graficaVentas(valores)
  {

  charventas =   Highcharts.chart('ventas', {
      chart: {
          type: 'column',
          renderTo:'ventas',
          events: {
                    drilldown: function (e) {
                        if (!e.seriesOptions) {

                            var chart = this, drilldowns = drill_ventas, series = drilldowns[e.point.name];
                            chart.showLoading('Actualizando gráfica ...');
                            //$overlay.show();
                            /*$.get("fndashboard.php?zona="+e.point.name, function(data)
                               {
                                chart.hideLoading();
                                chart.addSeriesAsDrilldown(e.point, data);
                              })*/


                            // Show the loading label
                            //chart.showLoading('Simulating Ajax ...');

                            setTimeout(function () {
                                chart.hideLoading();
                                //$overlay.hide();
                                chart.addSeriesAsDrilldown(e.point, series);
                            }, 1000);
                        }

                    }
                  }
      },
      title: {
          text: ventas
      },
      subtitle: {
          text: 'Click a la columna para ver departamentos.'
      },
      xAxis: {
          type: 'category'
      },
      yAxis: {
          title: {
              text: 'Total por zona'
          }

      },
      legend: {
          enabled: false
      },
      plotOptions: {
          series: {
              borderWidth: 0,
              dataLabels: {
                  enabled: true,
                  format: '{point.y:.1f} $'
              }
          }
      },

      tooltip: {
          headerFormat: '<span style="font-size:11px">{series.name}</span><br>',
          pointFormat: '<span style="color:{point.color}">{point.name}</span>: <b>{point.y:.2f} $</b> of total<br/>'
      },

      "series": valores,

      drilldown: {
                   series:{}
                 }
  });

}


var _grafventas = 1;
        $.ajax({
                 url:"fndashboard.php",
                 method:"POST",
                 async: true,
                 data:{ grafventas : _grafventas},
                 dataType:"JSON",
                 success:function(datos)
                 {
                    $('#loader_ventas').html('');
                    graficaVentas(datos);
                 }
                })

                /*Funcion que carga grafica de bajas*/

                function graficaBajas(valores)
                {

                  Highcharts.chart('bajas', {
                    chart: {
                        type: 'column',
                        renderTo:'bajas',
                        events: {
                                  drilldown: function (e) {
                                      if (!e.seriesOptions) {

                                          var chart = this, drilldowns = drill_bajas, series = drilldowns[e.point.name];
                                          chart.showLoading('Actualizando gráfica ...');
                                          //$overlay.show();
                                          /*$.get("fndashboard.php?zona="+e.point.name, function(data)
                                             {
                                              chart.hideLoading();
                                              chart.addSeriesAsDrilldown(e.point, data);
                                            })*/


                                          // Show the loading label
                                          //chart.showLoading('Simulating Ajax ...');

                                          setTimeout(function () {
                                              chart.hideLoading();
                                              //$overlay.hide();
                                              chart.addSeriesAsDrilldown(e.point, series);
                                          }, 1000);
                                      }

                                  }
                                }
                    },
                    title: {
                        text: bajas
                    },
                    subtitle: {
                        text: 'Click a la columna para ver departamentos.'
                    },
                    xAxis: {
                        type: 'category'
                    },
                    yAxis: {
                        title: {
                            text: 'Total por zona'
                        }

                    },
                    legend: {
                        enabled: false
                    },
                    plotOptions: {
                        series: {
                            borderWidth: 0,
                            dataLabels: {
                                enabled: true,
                                format: '{point.y:.1f} $'
                            }
                        }
                    },

                    tooltip: {
                        headerFormat: '<span style="font-size:11px">{series.name}</span><br>',
                        pointFormat: '<span style="color:{point.color}">{point.name}</span>: <b>{point.y:.2f} $</b> of total<br/>'
                    },

                    "series": valores,

                    drilldown: {
                                 series:{}
                               }
                });

              }

              /*Funcion que carga grafica de credito*/

              function graficaCredito(valores)
              {

                Highcharts.chart('credito', {
                  chart: {
                      type: 'column',
                      events: {
                                drilldown: function (e) {
                                    if (!e.seriesOptions) {

                                        var chart = this, drilldowns = drill_creditos, series = drilldowns[e.point.name];
                                        chart.showLoading('Actualizando gráfica ...');
                                        //$overlay.show();
                                        /*$.get("fndashboard.php?zona="+e.point.name, function(data)
                                           {
                                            chart.hideLoading();
                                            chart.addSeriesAsDrilldown(e.point, data);
                                          })*/


                                        // Show the loading label
                                        //chart.showLoading('Simulating Ajax ...');

                                        setTimeout(function () {
                                            chart.hideLoading();
                                            //$overlay.hide();
                                            chart.addSeriesAsDrilldown(e.point, series);
                                        }, 1000);
                                    }

                                }
                              }
                  },
                  title: {
                      text: credito
                  },
                  subtitle: {
                      text: 'Click a la columna para ver departamentos.'
                  },
                  xAxis: {
                      type: 'category'
                  },
                  yAxis: {
                      title: {
                          text: 'Total por zona'
                      }

                  },
                  legend: {
                      enabled: false
                  },
                  plotOptions: {
                      series: {
                          borderWidth: 0,
                          dataLabels: {
                              enabled: true,
                              format: '{point.y:.1f} $'
                          }
                      }
                  },

                  tooltip: {
                      headerFormat: '<span style="font-size:11px">{series.name}</span><br>',
                      pointFormat: '<span style="color:{point.color}">{point.name}</span>: <b>{point.y:.2f} $</b> of total<br/>'
                  },

                  "series": valores,

                  drilldown: {
                               series:{}
                             }
              });

            }

            /*Funcion que carga grafica de credito*/

            function graficaFidelizacion(valores)
            {

              Highcharts.chart('fidelizacion', {
                chart: {
                    type: 'column',
                    events: {
                              drilldown: function (e) {
                                  if (!e.seriesOptions) {

                                      var chart = this, drilldowns = drill_fidelizacion, series = drilldowns[e.point.name];
                                      chart.showLoading('Actualizando gráfica ...');
                                      //$overlay.show();
                                      /*$.get("fndashboard.php?zona="+e.point.name, function(data)
                                         {
                                          chart.hideLoading();
                                          chart.addSeriesAsDrilldown(e.point, data);
                                        })*/


                                      // Show the loading label
                                      //chart.showLoading('Simulating Ajax ...');

                                      setTimeout(function () {
                                          chart.hideLoading();
                                          //$overlay.hide();
                                          chart.addSeriesAsDrilldown(e.point, series);
                                      }, 1000);
                                  }

                              }
                            }
                },
                title: {
                    text: fidelizacion
                },
                subtitle: {
                    text: 'Click a la columna para ver departamentos.'
                },
                xAxis: {
                    type: 'category'
                },
                yAxis: {
                    title: {
                        text: 'Total por zona'
                    }

                },
                legend: {
                    enabled: false
                },
                plotOptions: {
                    series: {
                        borderWidth: 0,
                        dataLabels: {
                            enabled: true,
                            format: '{point.y:.1f} $'
                        }
                    }
                },

                tooltip: {
                    headerFormat: '<span style="font-size:11px">{series.name}</span><br>',
                    pointFormat: '<span style="color:{point.color}">{point.name}</span>: <b>{point.y:.2f} $</b> of total<br/>'
                },

                "series": valores,

                drilldown: {
                             series:{}
                           }
            });

          }

          /*Funcion que carga grafica de Neteo*/

          function graficaNeteo(valores)
          {

          charneteo =   Highcharts.chart('neto', {
              chart: {
                  type: 'column',
                  renderTo:'ventas',
                  events: {
                            drilldown: function (e) {
                                if (!e.seriesOptions) {

                                    var chart = this, drilldowns = drill_neteo, series = drilldowns[e.point.name];
                                    chart.showLoading('Actualizando gráfica ...');
                                    //$overlay.show();
                                    /*$.get("fndashboard.php?zona="+e.point.name, function(data)
                                       {
                                        chart.hideLoading();
                                        chart.addSeriesAsDrilldown(e.point, data);
                                      })*/


                                    // Show the loading label
                                    //chart.showLoading('Simulating Ajax ...');

                                    setTimeout(function () {
                                        chart.hideLoading();
                                        //$overlay.hide();
                                        chart.addSeriesAsDrilldown(e.point, series);
                                    }, 1000);
                                }

                            }
                          }
              },
              title: {
                  text: neteo
              },
              subtitle: {
                  text: 'Click a la columna para ver departamentos.'
              },
              xAxis: {
                  type: 'category'
              },
              yAxis: {
                  title: {
                      text: 'Total por zona'
                  }

              },
              legend: {
                  enabled: false
              },
              plotOptions: {
                  series: {
                      borderWidth: 0,
                      dataLabels: {
                          enabled: true,
                          format: '{point.y:.1f} $'
                      }
                  }
              },

              tooltip: {
                  headerFormat: '<span style="font-size:11px">{series.name}</span><br>',
                  pointFormat: '<span style="color:{point.color}">{point.name}</span>: <b>{point.y:.2f} $</b> of total<br/>'
              },

              "series": valores,

              drilldown: {
                           series:{}
                         }
          });

          }
}
