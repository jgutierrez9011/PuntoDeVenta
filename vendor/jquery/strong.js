function validaPass() {
        var valor = document.getElementById("password").value;

        var minuscula = false;
        var mayuscula = false;
        var numero = false;
        var caracter = false;
        //Se crea un arreglo donde se encuetran los diferentes mensajes con respecto a los aspectos que le hacen falta a la contrasena
        var mensaje = ["<li>Una min&uacute;scula</li>", "<li>Una May&uacute;scula</li>", "<li>Un N&uacute;mero</li>", "<li>Un car&aacute;cter simb&oacute;lico</li>"];
        //La contrasena tiene que ser mayor que 8 digitos, este valor se puede reducir si el desarrollador desea
        if (valor.length > 5){
        //recorre cada caracter de la cadena
        for(i=0;i<valor.length;i++) {
            //si el codigo ASCII es el de las minusculas, pone a true el flag de minusculas
            if(valor.charCodeAt(i)>=97 && valor.charCodeAt(i)<=122) {
                minuscula=true;
                mensaje[0] = "";
            //si el codigo ASCII es el de las mayusculas, pone a true el flag de mayusculas
            } else if(valor.charCodeAt(i)>=65 && valor.charCodeAt(i)<=90) {
                mayuscula=true;
                mensaje[1] = "";
            //si el codigo ASCII es el de loss numeros, pone a true el flag de numeros
            } else if(valor.charCodeAt(i)>=48 && valor.charCodeAt(i)<=57) {
                numero=true;
                mensaje[2] = "";
            //si no es ninguno de los anteriores, a true el flag de caracter simbolico
            } else   {
                caracter=true;
                mensaje[3] = "";
            }
        }
    //se comprueba que todos los aspectos a tratan en la contrasena se cumplan.
        if(caracter==true && numero==true && minuscula==true && mayuscula==true) {
            //si todos los aspectos se cumplen entonces se envia el formulario
            document.getElementById("btncambiar").submit();

        } else {
            //si no se cumplen los datos requeridos de la contrasena entonces se retorna al boton falso y se manda un mensaje
            //indicando en que aspecto de la contrasena fallo
            document.getElementById("mensaje").innerHTML = "<div class='alert alert-warning'>La contraseña elegida no es segura. Introduzca al menos: <ul>"+mensaje[0]+mensaje[1]+mensaje[2]+mensaje[3]+"</ul></div>";
            return false;
        }
    }
    else
    {
        //si la contrasena no es mayor que 8 entonces se manda este mensaje
        document.getElementById("mensaje").innerHTML = "<div class='alert alert-warning'>La contraseña debe de ser mayor de 5 digitos</div>";
        //Y se retorna al boton falso para que no envie los datos del formulario
        return false;
    }
    }
