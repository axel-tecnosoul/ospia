// JavaScript Document

function agregarEtapa(e){
    var [b,texto,ultimoRegistro]=validarRegistros(e,["etapa-","probabilidad-"]);
    //b=1;
    if(b==0){
		var modalAlert=$("#modalAlert");
		//alert("Para agregar una nueva etapa debe completar el campo "+texto);
		modalAlert.find('.modal-body').html("Para agregar una nueva etapa debe completar el campo "+texto);
		modalAlert.modal("show");
	}else{
		addRow();//ultimoRegistro=
	}
}
function validarRegistros(e,campos){
	var registros=$("#tab_logic tbody");
	//console.log(registros);
	var primerRegistro=$(registros).find("tr:first").attr("id");
	var ultimoRegistro=$(registros).find("tr:last").attr("id");
	var b=1;
	//console.log(primerRegistro);
	//console.log(ultimoRegistro);
    if(ultimoRegistro!=primerRegistro){
		var invalidos=[0,''];
		var c=0;
		var texto="";
		var lbl=$("thead tr th");
		//console.log(lbl);
		//console.log(campos);

		var numRow=$("#"+ultimoRegistro).attr("data-id");
		//console.log($("#"+ultimoRegistro));
		//console.log($("#"+ultimoRegistro).attr("data-id"));
		campos.forEach(function(nameElemento){
			//var elemento=$("#"+ultimoRegistro).find("input[name='"+nameElemento+"']");

			var elemento=$("#"+nameElemento+numRow)
			//console.log(nameElemento+numRow)
			//console.log(elemento)

			var valor=elemento.val();
			var tipo=elemento[0].type;
            
			if(tipo=="hidden"){
				return;
			}
			if(tipo=="select-one"){
				if(valor!=""){
					valor=parseInt(valor);
				}
			}
			if(tipo=="number"){
				if(valor!=""){
					valor=parseFloat(valor);
				}
			}
			if(valor==0 || valor=="" || valor==false){// || 
				texto=$(lbl[c]).text();
				this.focus();
				e.preventDefault();
				b=0;
				return false;
			}
			c++;
		});
	}
	return [b, texto, ultimoRegistro];
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
function addRow(){
	var tabla=$("#tab_logic tbody");//:nth(0)
	var ultimaFila=tabla.find("tr:last");//:nth(0)
	//console.log(ultimaFila);
	
	nuevaFila=ultimaFila.clone();
	nuevaFila=$(nuevaFila[0]);
	nuevaFila.removeClass('d-none');
	
	nroFilaAnterior=nuevaFila.data("id");
	nuevoNroFila=parseInt(nroFilaAnterior)+1;
	
	//console.log(nuevaFila.data("id"));
	nuevaFila.attr("data-id",nuevoNroFila);
	nuevaFila.attr("id","addr"+nuevoNroFila);

	nuevaFila.find('.sumId').each(function(index, el) {
		//console.log(this);
		ex=this.id.split("-");
		nuevoId=ex[0]+"-"+nuevoNroFila;

		this.id=nuevoId;
	});

	nuevaFila.find('.sumHref').each(function(index, el) {
		//console.log(this);
		//ex=this.id.split("-");
		ex=$(this).attr("href").split("-");
		nuevoId=ex[0]+"-"+nuevoNroFila;

		//this.id=nuevoId;
		$(this).attr("href",nuevoId)
	});
	nuevaFila.find('input').each(function(index, el) {
		this.value="";
	});
	tabla.append(nuevaFila);

	var sel2=$("#idPlantilla-"+nuevoNroFila);
	resetSelect2(sel2)
	var sel2=$("#id_tipoTarea-"+nuevoNroFila);
	resetSelect2(sel2)
}
function resetSelect2(sel2){
	nuevoSel2=sel2.clone(true);
	//nuevoSel2=sel2;
	contenedorSelectPlantilla=sel2.parent();
	contenedorSelectPlantilla.html("");
	contenedorSelectPlantilla.append(nuevoSel2)

	nuevoSel2.select2();//llamamos para inicializar select2
	nuevoSel2.select2('destroy');//como no se iniciliaza bien lo destruimos para que elimine las clases que arrastra de la clonacion
	nuevoSel2.select2();//volvemos a inicializar y ahora si se inicializa bien
	nuevoSel2.val(null).trigger('change');
}
function addRow2(){
	//alert("hola");
	var newid = 0;
	var primero="";
	var ultimoRegistro=0;
	$.each($("#tab_logic tr"), function() {
		if (parseInt($(this).data("id")) > newid) {
			newid = parseInt($(this).data("id"));
		}
	});
	//debugger;
	newid++;
	//console.log(newid);
	var tr = $("<tr></tr>", {
		"id": "addr"+newid,
		"data-id": newid
	});
	//console.log(newid);
	var p=0;
	$.each($("#tab_logic tbody tr:nth(0) td"),function(){//loop through each td and create new elements with name of newid
		var cur_td = $(this); 
		var children = cur_td.children();
		console.log(cur_td);
		console.log(children);
		console.log(children[0]);
		console.log("-----------------");
		//console.log($(this).data("name"));
		if($(this).data("name")!=undefined){// add new td and element if it has a name
			var td = $("<td></td>", {
				"data-name": $(cur_td).data("name"),
				"class": this.className
			});
			var c = $(cur_td).find($(children[0]).prop('tagName')).clone();//.val("")
			
			var id=$(c).attr("id");
			ultimoRegistro=id;
			if(id!=undefined){
				//console.log("id1: ");
				//console.log(id);
				id=id.split("-");
				c.attr("id", id[0]+"-"+newid);//modificamos el id de cada input
				if(p==0){
					primero=c;
					p++;
				}
			}
			
			c.appendTo($(td));
			td.appendTo($(tr));
			
		}else {
			//console.log("<td></td>",{'text':$('#tab_logic tr').length})
			var td = $("<td></td>", {
				'text': $('#tab_logic tr').length
			}).appendTo($(tr));
		}
	});
	//console.log($(tr).find($("input[name='detalledni[]']")));
	//console.log(tr);//.find($("input"))
	$(tr).appendTo($('#tab_logic'));// add the new row
	if(newid>0){
		primero.focus();
	}
	//tr.find($("td #iddetalledni")).prop("readonly",false).attr("value","");
	//console.log($(tr).find("td span.row-remove"));
	accionEliminar(tr);
	return tr.attr("id");
}

function accionEliminar(tr){
	//console.log(tr);
	var fila=$(tr)
	fila.find("td span.row-remove").on("click", function() {
		var filas=$("#tab_logic tbody tr");
		var id=$(this).closest("tr").find("input[name='idEtapaEmbudo[]']").val();//reemplazar name segun sistema
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