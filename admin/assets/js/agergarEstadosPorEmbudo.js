// JavaScript Document

function agregarEstado(e){
    var [b,texto,ultimoRegistro]=validarRegistros(e,["estado-","probabilidad-"]);
    //b=1;
    if(b==0){
		var modalAlert=$("#modalAlert");
		//alert("Para agregar un nuevo estado debe completar el campo "+texto);
		modalAlert.find('.modal-body').html("Para agregar un nuevo estado debe completar el campo "+texto);
		modalAlert.modal("show");
	}else{
		addRow();//ultimoRegistro=
	}
}
function validarRegistros(e,campos){
	var registros=$("#tab_logic tbody");
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
		campos.forEach(function(nameElemento){
			//var elemento=$("#"+ultimoRegistro).find("input[name='"+nameElemento+"']");
			var numRow=$("#"+ultimoRegistro).data("id");
			var elemento=$("#"+nameElemento+numRow)
			console.log(nameElemento+numRow)
			console.log(elemento)

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
		/*console.log(cur_td);
		console.log(children);
		console.log(children[0]);
		console.log("-----------------");*/
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