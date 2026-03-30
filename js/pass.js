/*Clinica de rentencion*/
function fnclinica()
	{

	var pass1
	var pass2 = "CR182006"
	var passgeneral = "GT2018"

	pass1 = prompt("Ingresa su password")
	if (pass2 == pass1 || passgeneral == pass1)
	{

	document.getElementById("clinica").href = "../bases/Clinica.xlsm"

	alert("Documento descargado")

	}
	else {
	alert("Denegado, password incorrecto");
	location.reload()
	}
	}

/*NOR-OCCIDE FIDELIZACION*/
function fidenoroc()
	{

	var pass1
	var pass2 = "CC401060"
	var passgeneral = "GT2018"

	pass1 = prompt("Ingresa su password")
	if (pass2 == pass1 || passgeneral == pass1)
	{

	document.getElementById("norocfide").href = "../bases/fidelizacion zona nor-occidente.xlsx"

	alert("Documento descargado")

			}
	else {
	alert("Denegado, password incorrecto");
	location.reload()
	}
	}




/*NOR-OCCIDE RETENCIONES*/
function retenoroc()
	{

	var pass1
	var pass2 = "CC401060"
	var passgeneral = "GT2018"

	pass1 = prompt("Ingresa su password")
	if (pass2 == pass1 || passgeneral == pass1)
	{

	document.getElementById("norocreten").href = "../bases/retenciones zona nor-occidente.xlsx"

	alert("Documento descargado")

			}
	else {
	alert("Denegado, password incorrecto");
	location.reload()
	}
	}




/*NOR-OCCIDE VENTAS*/
function ventanoroc()
	{

	var pass1
	var pass2 = "CC401060"
	var passgeneral = "GT2018"

	pass1 = prompt("Ingresa su password")
	if (pass2 == pass1 || passgeneral == pass1)
	{

	document.getElementById("norocventa").href = "../bases/ventas zona nort-occidente.xlsx"

	alert("Documento descargado")

			}
	else {
	alert("Denegado, password incorrecto");
	location.reload()
	}
	}





/*NOR-OCCIDE CREDITOS*/
function credinoroc()
	{

	var pass1
	var pass2 = "CC401060"
	var passgeneral = "GT2018"

	pass1 = prompt("Ingresa su password")
	if (pass2 == pass1 || passgeneral == pass1)
	{

	document.getElementById("norocredito").href = "../bases/credito zona nor-occidente.xlsx"

	alert("Documento descargado")

			}
	else {
	alert("Denegado, password incorrecto");
	location.reload()
	}
	}






/*---------------------------------------------------------------------------------------------------------------------------------------*/



/*CENTRO FIDELIZACION*/
function centrofide()
	{

	var pass1
	var pass2 = "GS236159"
	var pass3 = "GT2018"

	pass1 = prompt("Ingresa su password")
	if (pass2 == pass1 || pass3 == pass1)
	{

	document.getElementById("fidecentro").href = "../bases/fidelizacion zona centro.xlsx"

	alert("Documento descargado")

	}
	else {

	alert("Denegado, password incorrecto");
	location.reload()
	}

	}




	/*CENTRO RETENCIONES*/

	function centrorete()
	{
		var variable1 = "GS236159"
		var variable2
		var variable3 = "GT2018"

		variable2 = prompt("Ingresar su password")

if ( variable1 == variable2 || variable3 == variable2)

{
	 document.getElementById("retecentro").href = "../bases/retenciones zona centro.xlsx"
	  alert("Documento descargado")

}
		else
		{

	alert("Denegado, password incorrecto")
	location.reload()
		}


	}




	/*CENTRO CREDITOS*/

	function creditoscye()
	{
		var creditoscye1 = "GS236159"
		var creditoscye2
		var creditoscye3 = "GT2018"

		creditoscye2 = prompt("Ingresar su password")

if ( creditoscye1 == creditoscye2 || creditoscye2 == creditoscye3)

{
	 document.getElementById("codecredito2").href = "../bases/credito zona centro.xlsx"
	  alert("Documento descargado")

}
		else
		{

	alert("Denegado, password incorrecto")
	location.reload()
		}


	}




		/*CENTRO VENTAS*/

	function centroventas()
	{

		var ventascye1 = "GS236159"
		var ventascye2
		var ventascye3 = "GT2018"

		ventascye2 = prompt("Ingresar su password")

if ( ventascye1 == ventascye2 || ventascye2 == ventascye3)

{
	 document.getElementById("ventascentro").href = "../bases/ventas zona centro.xlsx"
	  alert("Documento descargado")

}
		else
		{

	alert("Denegado, password incorrecto")
	location.reload()
		}


	}

	/*--------------------------------------------------------------------------------------------------------------------------------*/



	/*ZONA NORTE FIDELIZACION*/

		function fiedenorte()
	{

		var fidenor1 = "AG257180"
		var fidenor2
		var fidenor3 = "GT2018"

		fidenor2 = prompt("Ingresar su password")

if ( fidenor1 == fidenor2 || fidenor1 == fidenor3)

{
	 document.getElementById("fidenor").href = "../bases/fidelizacion zona norte.xlsx"
	  alert("Documento descargado")

}
		else
		{

	alert("Denegado, password incorrecto")
	location.reload()
		}


	}






	/*ZONA NORTE RETENCIONES*/

		function retenorte()
	{

		var retenorte1 = "AG257180"
		var retenorte2
		var passgeneral = "GT2018"

		retenorte2 = prompt("Ingresar su password")

if ( retenorte1 == retenorte2 || passgeneral == retenorte2)

{
	 document.getElementById("retenor").href = "../bases/retenciones zona norte.xlsx"
	  alert("Documento descargado")

}
		else
		{

	alert("Denegado, password incorrecto")
	location.reload()
		}


	}




		/*ZONA NORTE CREDITOS*/

		function credinor()
	{

		var credinor1 = "AG257180"
		var credinor2
		var passgeneral = "GT2018"

		credinor2 = prompt("Ingresar su password")

if ( credinor1 == credinor2 || credinor2 == passgeneral)

{
	 document.getElementById("credinor").href = "../bases/credito zona norte.xlsx"
	  alert("Documento descargado")

}
		else
		{

	alert("Denegado, password incorrecto")
	location.reload()
		}


	}





	/*ZONA NORTE VENTAS*/

		function ventasnor()
	{

		var ventasnor1 = "AG257180"
		var ventasnor2
		var norventaspass = "GT2018"

		ventasnor2 = prompt("Ingresar su password")

if ( ventasnor1 == ventasnor2 || ventasnor2 == norventaspass)

{
	 document.getElementById("ventanor").href = "../bases/ventas zona norte.xlsx"
	  alert("Documento descargado")

}
		else
		{

	alert("Denegado, password incorrecto")
	location.reload()
		}


	}



/*---------------------------------------------------------------------------------------------------------------------------------------------*/


		/*ESPECIALES FIDELIZACION*/

		function espefide()
	{

		var fideocci1 = "GS236159"
		var fideocci2
		var espefidepass = "GT2018"

		fideocci2 = prompt("Ingresar su password")

if ( fideocci1 == fideocci2 || fideocci2 == espefidepass)

{
	 document.getElementById("fideespe").href = "../bases/fidelizacion zona especiales.xlsx"
	  alert("Documento descargado")

}
		else
		{

	alert("Denegado, password incorrecto")
	location.reload()
		}


	}




		/*ESPECIALES RETENCIONES*/

		function reteespe()
	{

		var retenocci1 = "GS236159"
		var retenocci2
		var eperretenpass = "GT2018"

		retenocci2 = prompt("Ingresar su password")

if ( retenocci1 == retenocci2 || retenocci2 == eperretenpass)

{
	 document.getElementById("esperete").href = "../bases/retenciones zona especiales.xlsx"
	  alert("Documento descargado")

}
		else
		{

	alert("Denegado, password incorrecto")
	location.reload()
		}


	}




		/*ESPECIALES CREDITOS*/

		function crediespe()
	{

		var crediocci1 = "GS236159"
		var crediocci2
		var especredipass = "GT2018"

		crediocci2 = prompt("Ingresar su password")

if ( crediocci1 == crediocci2 || crediocci2 == especredipass)

{
	 document.getElementById("especredito").href = "../bases/credito zona especiales.xlsx"
	  alert("Documento descargado")

}
		else
		{

	alert("Denegado, password incorrecto")
	location.reload()
		}


	}



		/*ESPECIALES VENTAS*/

		function ventasespe()
	{

		var ventasocci1 = "GS236159"
		var ventasocci2
		var espeventaspasss = "GT2018"

		ventasocci2 = prompt("Ingresar su password")

if ( ventasocci1 == ventasocci2 || ventasocci2 == espeventaspasss )

{
	 document.getElementById("espeventas").href = "../bases/ventas zona espaciales.xlsx"
	  alert("Documento descargado")

}
		else
		{

	alert("Denegado, password incorrecto")
	location.reload()
		}


	}





	/*---------------------------------------------------------------------------------------------------------------------------------------*/



		/*ZONA SUR ORIENTE FIDELIZACION*/

		function fidesur()
	{

		var fidesur1 = "MG001466"
		var fidesur2
		var surfidepass = "GT2018"

		fidesur2 = prompt("Ingresar su password")

if ( fidesur1 == fidesur2 || surfidepass == fidesur2)

{
	 document.getElementById("fidesur").href = "../bases/fidelizacion sur oriente.xlsx"
	  alert("Documento descargado")

}
		else
		{

	alert("Denegado, password incorrecto")
	location.reload()
		}


	}





		/*ZONA SUR ORIENTE RETENCIONES*/

		function retesur()
	{

		var retesur1 = "MG001466"
		var retesur2
		var retesurpass = "GT2018"

		retesur2 = prompt("Ingresar su password")

if ( retesur1 == retesur2 || retesur2 == retesurpass)

{
	 document.getElementById("retesur").href = "../bases/retenciones zona sur oriente.xlsx"
	  alert("Documento descargado")

}
		else
		{

	alert("Denegado, password incorrecto")
	location.reload()
		}


	}






		/*ZONA SUR ORIENTE CREDITOS*/

		function credisur()
	{

		var credisur1 = "MG001466"
		var credisur2
		var surcredipass = "GT2018"

		credisur2 = prompt("Ingresar su password")

if ( credisur1 == credisur2 || credisur2 == surcredipass)

{
	 document.getElementById("credisur").href = "../bases/credito zona sur oriente.xlsx"
	  alert("Documento descargado")

}
		else
		{

	alert("Denegado, password incorrecto")
	location.reload()
		}


	}






		/*ZONA SUR ORIENTE VENTAS*/

		function ventasur()
	{

		var ventasur1 = "MG001466"
		var ventasur2
		var surventapass = "GT2018"

		ventasur2 = prompt("Ingresar su password")

if ( ventasur1 == ventasur2 || ventasur2 == surventapass)

{
	 document.getElementById("ventasur").href = "../bases/ventas zona sur oriente.xlsx"
	  alert("Documento descargado")

}
		else
		{

	alert("Denegado, password incorrecto")
	location.reload()
		}


	}



/*-----------------------------------------------------------------------------------------------------------------------------------------*/



	/*ZONA MANAGUA FIDELIZACION*/

		function fidemana1()
	{

		var fidemana1 = "SP248645"
		var fidemana2
		var m1fidepass = "GT2018"

		fidemana2 = prompt("Ingresar su password")

if ( fidemana1 == fidemana2 || fidemana2 == m1fidepass)

{
	 document.getElementById("fideman1").href = "../bases/fidelizacion zona managua i.xlsx"
	  alert("Documento descargado")

}
		else
		{

	alert("Denegado, password incorrecto")
	location.reload()
		}


	}





	/*ZONA MANAGUA 1 RETENCIONES*/

		function reteman1()
	{

		var reteman1 = "SP248645"
		var reteman2
		var m1passrete = "GT2018"

		reteman2 = prompt("Ingresar su password")

if ( reteman1 == reteman2 || reteman2 == m1passrete)

{
	 document.getElementById("reteman1").href = "../bases/retenciones zona managua i.xlsx"
	  alert("Documento descargado")

}
		else
		{

	alert("Denegado, password incorrecto")
	location.reload()
		}


	}





	/*ZONA MANAGUA 1 CREDITO*/

		function crediman1()
	{

		var crediman1 = "SP248645"
		var crediman2
		var ma1credipass = "GT2018"

		crediman2 = prompt("Ingresar su password")

if ( crediman1 == crediman2 || crediman2 == ma1credipass)

{
	 document.getElementById("crediman1").href = "../bases/credito zona managua i.xlsx"
	  alert("Documento descargado")

}
		else
		{

	alert("Denegado, password incorrecto")
	location.reload()
		}


	}




	/*ZONA MANAGUA I VENTAS*/

		function ventmana1()
	{

		var ventman1 = "SP248645"
		var ventman2
		var ma1ventapass = "GT2018"

		ventman2 = prompt("Ingresar su password")

if ( ventman1 == ventman2 || ventman2 == ma1ventapass )

{
	 document.getElementById("ventman1").href = "../bases/ventas zona managua i.xlsx"
	  alert("Documento descargado")

}
		else
		{

	alert("Denegado, password incorrecto")
	location.reload()
		}


	}

	/*ZONA MANAGUA I CLARO CLUB*/

	function ccmng1()
	{

		var ventman1 = "SP248645"
		var ventman2
		var ma1ventapass = "GT2018"

		ventman2 = prompt("Ingresar su password")

if ( ventman1 == ventman2 || ventman2 == ma1ventapass )

{
	 document.getElementById("ccmng1").href = "../bases/CLARO_CLUB_MANAGUA_I.xlsx"
	  alert("Documento descargado")

}
		else
		{

	alert("Denegado, password incorrecto")
	location.reload()
		}


	}

	/*ZONA MANAGUA II FIDELIZACION*/

		function fideman2()
	{

		var fideman21 = "MT000483"
		var fideman22
		var man2fide = "GT2018"

		fideman22 = prompt("Ingresar su password")

if ( fideman21 == fideman22 || man2fide == fideman22)

{
	 document.getElementById("fideman22").href = "../bases/fidelizacion zona managua ii.xlsx"
	  alert("Documento descargado")

}
		else
		{

	alert("Denegado, password incorrecto")
	location.reload()
		}


	}

	/*ZONA MANAGUA II RETENCIONES*/

		function reteman2()
	{

		var reteman21 = "MT000483"
		var reteman22
		var man2rete = "GT2018"

		reteman22 = prompt("Ingresar su password")

if ( reteman21 == reteman22 || reteman22 == man2rete)

{
	 document.getElementById("retenman22").href = "../bases/retenciones zona managua ii.xlsx"
	  alert("Documento descargado")

}
		else
		{

	alert("Denegado, password incorrecto")
	location.reload()
		}


	}



	/*ZONA MANAGUA II CREDITO*/

		function crediman2()
	{

		var crediman21 = "MT000483"
		var crediman22
		var man2credi = "GT2018"

		crediman22 = prompt("Ingresar su password")

if ( crediman21 == crediman22 || crediman22 == man2credi)

{
	 document.getElementById("creman22").href = "../bases/credito zona managua ii.xlsx"
	  alert("Documento descargado")

}
		else
		{

	alert("Denegado, password incorrecto")
	location.reload()
		}


	}




	/*ZONA MANAGUA II VENTAS*/

		function ventasman2()
	{

		var ventasman21 = "MT000483"
		var ventasman22
		var man2ventas = "GT2018"

		ventasman22 = prompt("Ingresar su password")

if ( ventasman21 == ventasman22 || ventasman22 == man2ventas)

{
	 document.getElementById("ventasman22").href = "../bases/ventas zona managua ii.xlsx"
	  alert("Documento descargado")

}
		else
		{

	alert("Denegado, password incorrecto")
	location.reload()
		}


	}

	/*ZONA MANAGUA II CLARO CLUB*/

		function ccmng2()
	{

		var ventasman21 = "MT000483"
		var ventasman22
		var man2ventas = "GT2018"

		ventasman22 = prompt("Ingresar su password")

if ( ventasman21 == ventasman22 || ventasman22 == man2ventas)

{
	 document.getElementById("ccmng2").href = "../bases/CLARO_CLUB_MANAGUA_II.xlsx"
	  alert("Documento descargado")

}
		else
		{

	alert("Denegado, password incorrecto")
	location.reload()
		}
	}

	/*-+-+-+-+-+-+-+-+-+-+-+-+-+-+-+-+-+-+-+-+-+-+-+-+-+--+-+-+-+-+-+-+-+-+-+-+-+-+-+-+-+-+-+-++-++-+-+-+--+-+-+-+-+-+-+-+-+-+-+-+*/

		/*MONITOR DIARIO*/
	/*
		function monitordiario()
	{

	 document.getElementById("monidiario").href = "monitor diario sac.xlsx"
	  alert("Documento descargado")



	}

	*/

		/*FINAL-REEL*/

	/*	function reel()
	{

	 document.getElementById("reelfinal").href = "finalreel.mp4"
	  alert("Video descargado")



	}
	*/





	/*BANNER LAS AMERICAS*//*
			function bannerla()
	{

	 document.getElementById("multiamerica").href = "bannersla.avi"
	  alert("Video descargado")



	}
*/
