/*          _\|/_
            (0 0)
--------o00o-{_}-o00o-----------------------

UCREAUTH v1.0 (2011)
Funciones y procedimientos JavaScript
UCREATIVA. 
--------------------------------------------
*/

function open_form(form_name,width,height){
    document.getElementById("form_container").src = form_name;
    document.getElementById("form_base").style.display = 'block';
    document.getElementById("inactive_base").style.display = 'block';
    document.getElementById("form_base").style.height = height + "px";
    document.getElementById("form_base").style.width = width + "px";
    document.getElementById("form_container").style.height = height + "px";
    document.getElementById("form_container").style.width = width + "px";
    document.getElementById("button_close").style.display = 'block';
}

function close_form(){
	 document.getElementById("form_container").src = "";
    document.getElementById("form_base").style.display = 'none';
    document.getElementById("button_close").style.display = 'none';
    document.getElementById("inactive_base").style.display = 'none';
}

// -------

var v_open=0;

function show_close_menu(id){
	 $('#'+id).css('visibility','visible');
	 if(v_open==0){
	 	$('#'+id).slideDown(300);
	 	v_open=1;
	 }else{
	 	$('#'+id).slideUp(300);
	 	v_open=0;
	 }
}


function getInternetExplorerVersion() {
    var rv = -1; // Return value assumes failure.
    if (navigator.appName == 'Microsoft Internet Explorer') {
        var ua = navigator.userAgent;
        var re = new RegExp("MSIE ([0-9]{1,}[\.0-9]{0,})");
        if (re.exec(ua) != null)
            rv = parseFloat(RegExp.$1);
    }
    return rv;
}

function checkVersion() {
    var msg = "";
    var ver = getInternetExplorerVersion();
    if (ver > -1) {
        if (ver <= 8.0){
            msg = "Usted debe actualizar su navegador por razones críticas de seguridad."
            alert(msg);
            location.href = "http://www.mozilla.org/es-ES/firefox/new/";
        }
    }
}

// -------

function ajaxrequest_db(ruta,form,param){
    $(document).ready(function(){
                $.ajax({
                        url: 'searchcore.php?path='+ruta+'&form='+form+'&param='+ param,
                        cache: false,
                        type: "GET",
                        success: function(datos){
                                $("#listview").html(datos);
                        }
                });
    });
}

function validate_pssw() {
	var invalid = " "; // Invalid character is a space
	var minLength = 6; // Minimum length
	var pw1 = $("#txt_pssw").val();
	var pw2 = $("#txt_cpssw").val();

	if(/^\d{2,4}$/.test(pw1)) {
	  alert("La contraseña debe tener de 2 a 4 digitos.");
	  return false;
	}

	// check for a value in both fields.
	if (pw1 == '' || pw2 == '') {
		alert('Por favor digite su contraseña 2 veces.');
		return false;
	}
	// check for minimum length

	if (pw1.length < minLength) {
		alert('Su contraseña debe ser de al menos ' + minLength + ' caracteres. Intenta de nuevo.');
		return false;
	}

	// check for spaces
	if (pw1.indexOf(invalid) > -1) {
		alert("Espacios no son permitidos.");
		return false;
	}
	else {
		if (pw1 != pw2) {
			alert ("No se ha digitado correctamente la confirmación de la contraseña. Por favor escriba de nuevo su password.");
			return false;
		}
		else {
			return true;
		}
	}
}

function valChangeImage(txt){
   var formatFile='';
   var ext = ['.jpg','jpeg','.png','.JPG','JPEG','.PNG'];
   var existe = ""
   for(var i=4; i>=1; i--){
      formatFile += txt.value[txt.value.length-i];
   }
   for(var i=0; i<=ext.length-1; i++){
         if (formatFile==ext[i]){
            existe="S"
         break;
        }else{
          existe="N"
        }
   }
    if (existe == "N"){
         alert('Formato o extensión no válido de imagen, las imágenes deben ser .jpg o .png');
         txt.value='';
         txt.FileName='';
    }
}

function valChangeDoc(txt){
   var formatFile=''
   var ext = ['.doc','docx','.DOC','DOCX','.pdf','.PDF','.ppt','pptx','.PPT','PPTX','.xls','xlsx','.XLS','XLSX'];
   for(var i=4; i>=1; i--){
      formatFile += txt.value[txt.value.length-i];
   }
    for(var i=0; i<=ext.length-1; i++){
         if (formatFile==ext[i]){
            existe="S"
         break;
        }else{
          existe="N"
        }
   }
     if (existe == "N"){
         alert('Formato o extensión no válido para un archivo, los archivos deben ser .doc, .pdf, .ppt, .pptx, .xls o .xlsx');
         txt.value='';
         txt.FileName='';
     }
}

function valChangeBK(txt){
   var formatFile=''
   var ext = ['.bak','.BAK'];
   for(var i=4; i>=1; i--){
      formatFile += txt.value[txt.value.length-i];
   }
    for(var i=0; i<=ext.length-1; i++){
         if (formatFile==ext[i]){
            existe="S"
         break;
        }else{
          existe="N"
        }
   }
     if (existe == "N"){
         alert('Formato o extensión no válido para un archivo, los archivos deben ser .bak o .BAK');
         txt.value='';
         txt.FileName='';
     }
}

function maxLength(me,count,e){
    tecla = (document.all) ? e.keyCode : e.which; 
    if (tecla==8)
        return true; 
    if(me.value.length>=count) 
        return false; 
}

function validarOnlyLet(e) { 
    tecla = (document.all) ? e.keyCode : e.which; 
    if ((tecla==8) 
    || (tecla==241) 
    || (tecla==209) 
    || (tecla==193) 
    || (tecla==201) 
    || (tecla==205) 
    || (tecla==211) 
    || (tecla==218) 
    || (tecla==225) 
    || (tecla==233) 
    || (tecla==237) 
    || (tecla==243) 
    || (tecla==250)) 
    return true; 
    patron =/[A-Za-z\s]/;
    te = String.fromCharCode(tecla); 
    return patron.test(te); 
}

function validarOnlyNum(e) { 
    tecla = (document.all) ? e.keyCode : e.which; 
    if ((tecla==8) || (tecla==45)) return true;
    patron =/\d/; 
    te = String.fromCharCode(tecla); 
    return patron.test(te); 
}

function validateEmail(email) {
    var at = email.lastIndexOf("@");
    
    // Make sure the at (@) sybmol exists and
    // it is not the first or last character
    if (at < 1 || (at + 1) === email.length)
	    return false;

    // Make sure there aren't multiple periods together
    if (/(\.{2,})/.test(email))
	    return false;

    // Break up the local and domain portions
    var local = email.substring(0, at);
    var domain = email.substring(at + 1);

    // Check lengths
    if (local.length < 1 || local.length > 64 || domain.length < 4 || domain.length > 255)
	    return false;

    // Make sure local and domain don't start with or end with a period
    if (/(^\.|\.$)/.test(local) || /(^\.|\.$)/.test(domain))
	    return false;

    // Check for quoted-string addresses
    // Since almost anything is allowed in a quoted-string address,
    // we're just going to let them go through
    if (!/^"(.+)"$/.test(local)) {
	    // It's a dot-string address...check for valid characters
	    if (!/^[-a-zA-Z0-9!#$%*\/?|^{}`~&'+=_\.]*$/.test(local))
		    return false;
    }

    // Make sure domain contains only valid characters and at least one period
    if (!/^[-a-zA-Z0-9\.]*$/.test(domain) || domain.indexOf(".") === -1)
	    return false;	

    return true;
}

function mostrarclock(){ 
    var Digital=new Date()
    var day=Digital.getDay()
    var hours=Digital.getHours()
    var minutes=Digital.getMinutes()
    var seconds=Digital.getSeconds()
    var year=Digital.getFullYear()
    var month=Digital.getMonth()+1
    var date=Digital.getDate()
    var dn="PM"
    var dia=""
    if (day==0)
        dia="Dom"
    if (day==1)
        dia="Lun"
    if (day==2)
        dia="Mar"
    if (day==3)
        dia="Mi&eacute;"
    if (day==4)
        dia="Jue"
    if (day==5)
        dia="Vie"
    if (day==6)
        dia="S&aacute;b"
    if (hours<12)
        dn="AM"
    if (hours>12)
        hours=hours-12
    if (hours==0)
        hours=12
    if (minutes<=9)
        minutes="0"+minutes
    if (seconds<=9)
        seconds="0"+seconds
    var ctime=dia+" "+hours+":"+minutes+":"+seconds+" "+dn+" - "+date+"/"+month+"/"+year
    setTimeout("mostrarclock()",1000)
    document.getElementById("clock").innerHTML =  ctime
}

function welcome_msj(){
     $(document).ready(function() {
         $("#welcome_msj").fadeOut(15000);
      });
}

function tabs(id_show){
  var i=0;
   for (i=1;i<=2;i++){
      if(id_show=='tab_' + i){
          document.getElementById(id_show).style.display='block';
          if(document.getElementById(i + '_tab')){
            document.getElementById(i + '_tab').style.backgroundColor='#6ABD45';
          }
      }else{
          document.getElementById('tab_' + i).style.display='none';
          if(document.getElementById(i + '_tab')){
             document.getElementById(i + '_tab').style.backgroundColor='#AD2026';
          }
      }
   }
}

function show_submenu(id){ 
   var i=0;
   for (i=1;i<=2;i++){
      if(id=='sm_' + i){
          $(function(){
            $("#sm_"+i).fadeIn(400);
          });
      }else{
          $("#sm_"+i).fadeOut(400);
      }
   }
}

function hidden_submenu(){ 
   for (i=1;i<=2;i++){
          $("#sm_"+i).fadeOut(400);
   }
}
