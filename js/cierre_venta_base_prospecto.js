/*OCULTA EL PANEL DE OFERTA DE CIERRE*/
$('#oferta_cierre_base').hide();

//Lista de planes
$('#txtservicio_base').change(function()
  {
    var plan_ = document.getElementById("txtservicio_base").value;

    $.post('fnsvaclient.php', { plan: plan_ } ).done(function (respuesta)
     {
       $('#txtplan_base').html(respuesta);
     });
  });

var ofertasList_base = [];

function addOferta_base (pid, pservicio, pplan, prenta)
{
  var newOferta = {
           id : pid,
           servicio : pservicio,
           plan : pplan,
           renta : prenta
         };
         console.log(newOferta);
         ofertasList_base.push(newOferta);

}

function getOfertaList_base ()
{
  return ofertasList_base;
}

function drawtableOfertaList_base()
{
  var listOfertar = getOfertaList_base(),
      tbody = document.querySelector('#tableListOfertado_base tbody');

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

document.querySelector('#btnagregaroferta_base').addEventListener('click',function(event){
  event.preventDefault();
  SaveOferta_base();
});
drawtableOfertaList_base();

function SaveOferta_base(){
  var sid = ofertasList_base.length + 1,
      sservicio = document.querySelector('#txtservicio_base').value,
      splan = document.querySelector('#txtplan_base').value,
      srenta = document.querySelector('#txtrenta_base').value;

 if((sservicio.length > 0) && (splan.length > 0) && (srenta.length > 0))
 {
   addOferta_base(sid,sservicio,splan,srenta);
   drawtableOfertaList_base();
   $('#content_base_clientes_oferta_cierre').html('');
 }else {

    $('#content_base_clientes_oferta_cierre').html('<div class="alert alert-warning"><strong>Error!</strong> Ups! Debe especificar el servicio, plan y oferta, intente nuevamente.</div>');

 }

}
