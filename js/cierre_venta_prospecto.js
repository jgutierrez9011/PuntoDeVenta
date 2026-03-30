/*OCULTA EL PANEL DE OFERTA DE CIERRE*/
$('#oferta_cierre').hide();

//Lista de planes
$('#txtservicio').change(function()
  {
    var plan_ = document.getElementById("txtservicio").value;

    $.post('fnsvaclient.php', { plan: plan_ } ).done(function (respuesta)
     {
       $('#txtplan').html(respuesta);
     });
  });

var ofertasList = [];

function addOferta (pid, pservicio, pplan, prenta)
{
  var newOferta = {
           id : pid,
           servicio : pservicio,
           plan : pplan,
           renta : prenta
         };
         console.log(newOferta);
         ofertasList.push(newOferta);

}

function getOfertaList ()
{
  return ofertasList;
}

function drawtableOfertaList()
{
  var listOfertar = getOfertaList(),
      tbody = document.querySelector('#tableListOfertado tbody');

      tbody.innerHTML = '';

      for(var i = 0; i < listOfertar.length; i++)
      {
        var row = tbody.insertRow(i),
           idCell = row.insertCell(0),
            servicioCell =  row.insertCell(1),
            planCell = row.insertCell(2),
            rentaCell = row.insertCell(3);


        idCell.innerHTML = listOfertar[i].id;
        servicioCell.innerHTML = listOfertar[i].servicio;
        planCell.innerHTML = listOfertar[i].plan;
        rentaCell.innerHTML = listOfertar[i].renta;

        tbody.appendChild(row);
      }
}

document.querySelector('#btnagregaroferta').addEventListener('click',function(event){
  event.preventDefault();
  SaveOferta();
});
drawtableOfertaList();

function SaveOferta(){
  var sid = ofertasList.length + 1,
      sservicio = document.querySelector('#txtservicio').value,
      splan = document.querySelector('#txtplan').value,
      srenta = document.querySelector('#txtrenta').value;

 if((sservicio.length > 0) && (splan.length > 0) && (srenta.length > 0))
 {
   addOferta(sid,sservicio,splan,srenta);
   drawtableOfertaList();
   $('#content_mis_clientes_oferta_cierre').html('');
 }else {

    $('#content_mis_clientes_oferta_cierre').html('<div class="alert alert-warning"><strong>Error!</strong> Ups! Debe especificar el servicio, plan y oferta, intente nuevamente.</div>');

 }

}
