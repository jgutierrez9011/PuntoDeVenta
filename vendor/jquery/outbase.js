
$('#btnexpbases').click(function(){

    var _fechainicio = $('#finicio_tolbar').val();
    var _fechafin = $('#ffin_tolbar').val();

    //  alert("En hora buena!, se exporto con exito las bases.");
  $.ajax({
          async: true,
          type:"POST",
          dataType:"html",
          contentType:"application/x-www-form-urlencoded",
          url:"exportbases.php",
          data:{fechainicio : _fechainicio, fechafin: _fechafin},
          success:function(data)
          {
                //alert("En hora buena!, se exporto con exito las bases.");
                var opResult = JSON.parse(data);
                      var $a=$("<a>");
                      $a.attr("href",opResult.data);
                      //$a.html("LNK");
                      $("body").append($a);
                      $a.attr("download","bases.xlsx");
                      $a[0].click();
                      $a.remove();
          }
        })
})
