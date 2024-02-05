// JavaScript Document

function agregarEnvio(e){
    var b=validarRegistros(e);
    //b=1;
    if(b==0){
		addRow();
	}
}
function validarRegistros(e){
	var error=0;
	var contenedorAcordeon=$("#accordionoc");//:nth(0)
	var ultimoRegistro=contenedorAcordeon.find("div.card:last-child");//:nth(0)
	if(ultimoRegistro.find('input.nroEnvio').val()>0){
		var inputs=ultimoRegistro.find('input');
		var selects=ultimoRegistro.find('select');
		var ckeditors=ultimoRegistro.find(".ckeditor-mensaje");

		inputs.each(function(index, el) {
			if (!this.checkValidity()) {
	            //this.focus();
	            document.getElementById("miForm").reportValidity();
	            error=1;
	            e.preventDefault();
	            return false;
	        }
		});
		if(error==0){
			selects.each(function(index, el) {
				if (!this.checkValidity()) {
		            //this.focus();
		            document.getElementById("miForm").reportValidity();
		            error=1;
		            e.preventDefault();
		            return false;
		        }
			});
		}
		if(error==0){
			ckeditors.each(function(index, el) {
		    	editor=this.id;
		    	var messageLength = CKEDITOR.instances[editor].getData().replace(/<[^>]*>/gi, '').length;
		    	if( !messageLength ) {
		    		e.preventDefault();
		    		error=1;
		    		alert( 'Ingrese el cuerpo del mensaje' );
		    		return false;
		    	}
		    });
		}
	}
	return error;
}
function rescatarIdEliminado(t,name){
	/*console.log(t);
	console.log(name);*/
	var fila=$(t).closest("tr");
	var id=fila.find("input[name='"+name+"']").val();//reemplazar name segun sistema
	console.log(id);
	//console.log(detalleEliminados);
	//var v=id.val();
	//console.log(id);
    if(id>0){
		var detalleEliminados=$("#detalleEliminados");
		detalleEliminados.val(detalleEliminados.val()+","+id);
	}
	fila.remove();
}
/**SCRIPT DE DETALLE PRODUCTO*/
function obtenerPlantilla(selectPlantilla){
    ex=selectPlantilla.id.split("-");
    nroEnvio=ex[1];
    var idPlantilla=$("#idPlantilla-"+nroEnvio).val();
    $.ajax({
      type: "POST",
      url: "obtenerPlantilla.php",
      data: "idPlantilla="+idPlantilla,
      success: function(data) {
        console.log(data);
        plantilla=JSON.parse(data);
        
        $("#asunto-"+nroEnvio).val(plantilla.asunto)//exampleInputPassword1

        editorCuerpo="cuerpo-"+nroEnvio;
        CKEDITOR.instances[editorCuerpo].setData('',function(){
            CKEDITOR.instances[editorCuerpo].insertHtml(plantilla.cuerpo);
        });

        var adjunto="";
        var listaAdjuntos=$("#adjuntosPlantilla-"+nroEnvio).find('ul');
        listaAdjuntos.html("");
        plantilla.adjuntos.forEach(function(element){
                
          var archivo=element.ruta+element.archivo;
          console.log(archivo);
                
          adjunto+= '<li class="list-inline-item"><a href="'+archivo+'" target="_blank"><i class="fa fa-long-arrow-down mr-2"></i>';

          if(element.archivo=="img"){
            adjunto+='<img class="img-fluid" src="'+archivo+'" alt="">';
          }else{
            adjunto+=element.archivo;
          }

          adjunto+='</a></li>';
        });              
             
        listaAdjuntos.append(adjunto);
      }
    });
  }

function addRow(){
	var contenedorAcordeon=$("#accordionoc");//:nth(0)
	//var acordeonBase=contenedorAcordeon.find("div:last-child");//:nth(0)
	var acordeonBase=contenedorAcordeon.find("div.card:last-child");//:nth(0)
	//var acordeonBase=contenedorAcordeon.find("div.card:first-child");//:nth(0)
	//console.log(acordeonBase);
	//acordeonBase=$(acordeonBase[0]);
	acordeonBase.removeClass('collapse');
	
	nuevoAcordeon=acordeonBase.clone();
	nuevoAcordeon=$(nuevoAcordeon[0]);
	nuevoAcordeon.removeClass('d-none');

	//console.log(nuevoAcordeon);
	//console.log(nuevoAcordeon.find(".nroEnvio"));
	nroEnvio=nuevoAcordeon.find(".nroEnvio");
	nroEnvioAnterior=nroEnvio.val();

	var nuevoNroEnvio=parseInt(nroEnvioAnterior)+1;
	nroEnvio.val(nuevoNroEnvio);

	nuevoAcordeon.find("#cke_cuerpo-"+nroEnvioAnterior).remove();

	nuevoAcordeon.find('.sumId').each(function(index, el) {
		//console.log(this);
		ex=this.id.split("-");
		nuevoId=ex[0]+"-"+nuevoNroEnvio;

		this.id=nuevoId;
	});

	/*console.log(contenedorAcordeon);
	console.log(nuevoAcordeon);*/
	//console.log(nuevoAcordeon[0]);
	contenedorAcordeon.append(nuevoAcordeon);

	//console.log(nuevoNroEnvio);
	target=$("#button-"+nuevoNroEnvio);
	//console.log(target);
	//console.log(target.data("target"));
	ex=target.data("target").split("-");
	nuevoTarget=ex[0]+"-"+nuevoNroEnvio;
	target.attr("data-target",nuevoTarget);

	label=$("#labelCustomFile-"+nuevoNroEnvio);
	$("#customFile-"+nuevoNroEnvio).val("");
	$("#customFile-"+nuevoNroEnvio).attr("name","adjuntos-"+nuevoNroEnvio+"[]");
	ex=label.attr("for").split("-");
	nuevoFor=ex[0]+"-"+nuevoNroEnvio;
	label.attr("for",nuevoFor);
	$("#labelCustomFile-"+nuevoNroEnvio).html("Adjuntar archivos");
	
	$("#labelNroEnvio-"+nuevoNroEnvio).html(nuevoNroEnvio);
	$("#nroEnvio-"+nuevoNroEnvio).val(nuevoNroEnvio);
	$("#hiddenNroEnvio-"+nuevoNroEnvio).val(nuevoNroEnvio);
	$("#fecha_hora-"+nuevoNroEnvio).focus();
	$("#intervalo_minutos-"+nuevoNroEnvio).val("");
	$("#asunto-"+nuevoNroEnvio).val("");
	//$("#asunto-"+nuevoNroEnvio).val("");
	$("#adjuntosPlantilla-"+nuevoNroEnvio).find('ul').html("");

	var sel2=$("#idPlantilla-"+nuevoNroEnvio);
	//console.log(sel2);
	nuevoSel2=sel2.clone(true);
	//nuevoSel2=sel2;
	contenedorSelectPlantilla=sel2.parent(".contenedorSelectPlantilla");
	contenedorSelectPlantilla.html("");
	contenedorSelectPlantilla.append(nuevoSel2)

	nuevoSel2.select2();//llamamos para inicializar select2
	nuevoSel2.select2('destroy');//como no se iniciliaza bien lo destruimos para que elimine las clases que arrastra de la clonacion
	nuevoSel2.select2();//volvemos a inicializar y ahora si se inicializa bien

	nuevoSel2.on('change',function(event) {
	    //console.log(this);
	    obtenerPlantilla(this);
	});

	CKEDITOR.replace("cuerpo-"+nuevoNroEnvio).setData('');

	bsCustomFileInput.init();
	//CKEDITOR.instances.editor1.setData('');
	/*acordeonBase.collapse('hide');
	nuevoAcordeon.collapse('show');*/
	
}

function accionEliminar(tr){
	//console.log(tr);
	var fila=$(tr)
	fila.find("td span.row-remove").on("click", function() {
		var filas=$("#tab_logic tbody tr");
		var id=$(this).closest("tr").find("input[name='idEstadoEmbudo[]']").val();//reemplazar name segun sistema
		var detalleEliminados=$("#detalleEliminados");
		//console.log(detalleEliminados);
		//var v=id.val();
		//console.log(id);
		if(id>0){
			detalleEliminados.val(detalleEliminados.val()+","+id);
		}
		$(this).closest("tr").remove();
		//alert("eliminado");
	});
}