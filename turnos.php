<?php
include_once("admin/config.php");
require 'admin/database.php';
if(!isset($_SESSION["user"]["ficha"])){
  header("Location: page-login.php");
}?>
<!doctype html>
<html lang="en">

<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1, minimum-scale=1, maximum-scale=1, viewport-fit=cover" />
    <meta name="apple-mobile-web-app-capable" content="yes" />
    <meta name="apple-mobile-web-app-status-bar-style" content="black-translucent">
    <meta name="theme-color" content="#000000">
    <title>OSPIA APP</title>
    <meta name="description" content="Mobilekit HTML Mobile UI Kit">
    <meta name="keywords" content="bootstrap 5, mobile template, cordova, phonegap, mobile, html" />
    <!-- <link rel="stylesheet" type="text/css" href="admin/assets/css/mapsjs-ui.css"> -->
    <!-- Responsive css-->
    <link rel="stylesheet" type="text/css" href="admin/assets/css/responsive.css">
    <link rel="icon" type="image/png" href="assets/img/favicon.png" sizes="32x32">
    <link rel="apple-touch-icon" sizes="180x180" href="assets/img/icon/192x192.png">
    <link rel="stylesheet" href="assets/css/style.css">
    <link rel="manifest" href="__manifest.json">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/animate.css/4.1.1/animate.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/animate.css/4.1.1/animate.min.css">
    <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
    <link rel="stylesheet" type="text/css" href="admin/vendor/datetimepicker-xdsoft/jquery.datetimepicker.css"/>
</head>
<style>
  html, body, #map {
    height: 100%;
    margin: 0;
    padding: 0;
  }

  #circular-menu{
    -webkit-transform: inherit;
    transform: inherit;
  }

  .float{
    position: fixed;
    width: 60px;
    height: 60px;
    bottom: 70px;
    right: 20px;
    /*background-color: #25d366;*/
    color: #FFF;
    border-radius: 50px;
    text-align: center;
    font-size: 50px;
    /*box-shadow: 2px 2px 3px #999;*/
    z-index: 100;
  }

  .float :hover{
    border-radius: 50px;
    border: solid 2px #0bd71c;
  }

	.float2{
    text-align: center;
	  position: fixed;
    width: 160px;
    height: 100px;
    bottom: 100px;
	  margin-left: auto;
    margin-right: auto;
    /*right: 220px;*/
    /*background-color: #25d366;*/
    color: #FFF;
    border-radius: 10px;
    font-size: 60px;
    /*box-shadow: 2px 2px 3px #999;*/
    z-index: 100;
  }

  .xdsoft_datepicker {
    width: 341px !important;
  }
  .xdsoft_calendar table, .xdsoft_time_box{
    height: 341px !important;
  }
  .xdsoft_year, .xdsoft_month{
    color: #4F5050;
  }
  .xdsoft_date{
    background-color: rgb(0 128 0 / 70%) !important;
    color: white !important;
  }
  .xdsoft_disabled{
    background-color: #f5f5f5 !important;
    color: #666 !important;
  }
  .xdsoft_current{
    border: solid 2px rgb(0 128 0 / 70%) !important;
    background-color: #f5f5f5 !important;
    color: #666 !important;
  }
</style>

<body class="bg1">
  <!-- App Header -->
  <div class="appHeader no-border transparent position-absolute">
  <div class="left animate__animated animate__fadeInRight">
    <a href="index.php" class="headerButton goBack">
      <ion-icon name="chevron-back-outline"></ion-icon>VOLVER
    </a>
  </div>
  <div class="pageTitle"></div>
        
  </div>
  <br>
  <!-- * App Header -->

  <!-- App Capsule -->
	<?php
	if ($_SESSION['user']['id'] == 0) {?>
		<span class="float2 w-auto " data-bs-toggle="modal">
			<h2><span class="badge bg-danger p-1 fs-5 h-auto" style="white-space: normal;">Para ingresar un turno debe cargar el telefono en Datos Personales</span></h2>
		</span><?php
	}else{
		if (!empty($_SESSION['user']['celular'])) {?>
			<span class="float btn-primary" data-bs-toggle="modal" data-bs-target="#ModalNuevoTurno">
				<ion-icon name="add-outline" style="vertical-align: -webkit-baseline-middle;"></ion-icon>
			</span><?php
		}else{?>
			<span class="float2 w-auto " data-bs-toggle="modal">
				<h2><span class="badge bg-danger p-1 fs-5 h-auto" style="white-space: normal;">Para ingresar un turno debe cargar el telefono en Datos Personales</span></h2>
			</span><?php
		}
	}?>
	
  <div class="section full" style="height: calc( 100% - 56px - 16px - 13px);">
    <h2 class="text-center">Turnos</h2>
    <div class="row" style="height: calc( 100% - 16px - 9px);overflow: scroll;">
      <div class="col-12">
        <ul id="cartilla" class="listview link-listview search-result animate__animated animate__fadeInRight" style="border-radius: 10px;"><?php
          $id=$_SESSION["user"]["id"];
          //$imagen=$_SESSION["user"]["imagen"];
          $ficha=$_SESSION["user"]["ficha"];
          $persona=$_SESSION["user"]["persona_id"];

          //$url=$url_ws."?Modo=20&Usuario=$usuario_ws&Ficha=$ficha";
          $url=$url_ws."?Modo=20&Persona=$persona";
          if($id==20){
            //echo $url;
          }
          $jsonData = json_decode(file_get_contents($url),true);
          if($jsonData["Ok"]!="false"){
            //var_dump($jsonData);
            $turnos=$jsonData["Turnos"];
            //var_dump($turnos[0]);
            foreach ($turnos as $turno) {
              //var_dump($turno);
              
              //var_dump($turno["TurnoCompleto"]);
              $fecha_turno=date("Y-m-d H:i",strtotime(str_replace("/","-",$turno["TurnoCompleto"])));
              //var_dump($fecha_turno);
              /*$TipoTurno="Turno normal";
              if($turno["TipoTurno"]==1){
                $TipoTurno="Sobre Turno";
              }*/
              $Estado="Confirmado / Ejecutado";
              if($turno["Estado"]=="A"){
                $Estado="Asignado";
              }?>
              <div class="row border m-2">
                <div class="col-10">
                  <!-- <h3 class="mb-05 titulo1">#<?=$turno["TurnoNumero"]?> - <?=$turno["TurnoCompleto"]?></h3> -->
                  <h3 class="mb-05 titulo1" style="text-align: center;"><?=$turno["TurnoCompleto"]?></h3>
                  <div class="text-muted">
                    <span onclick="" style="display: none;">
                      <?=$turno["Policlinico"]." - ".$turno["Especialidad"]." - ".$turno["Medico"]?>
                      <!-- <span class='btn btn-sm btn-link border'>(ir)</span> -->
                    </span>
                    <div onclick="">
                      <!--Nombre: --><?// echo $turno["Apellido"]." ".$turno["Nombre"];?>
                      Nombre: <? echo $turno["Nombre"];?>
                      <!-- <span class='btn btn-sm btn-link border'>(ir)</span> -->
                    </div>
                    <div onclick="">
                      <!-- Policlinico: <?=$turno["Policlinico"]?> -->
                      <?=$turno["Policlinico"]." (".$turno["PoliclinicoDireccion"].")<br>Tel: ".$turno["PoliclinicoTelefono"]?>
                      <!-- <span class='btn btn-sm btn-link border'>(ir)</span> -->
                    </div>
                    <div onclick="">
                      <!-- Especialidad: <?=$turno["Especialidad"]?> -->
                      <?=$turno["Especialidad"]?>
                      <!-- <span class='btn btn-sm btn-link border'>(ir)</span> -->
                    </div>
                    <div onclick="">
                      <!-- Profesional: <?=$turno["Medico"]?> -->
                      <?=$turno["Medico"]?>
                      <!-- <span class='btn btn-sm btn-link border'>(ir)</span> -->
                    </div>
                    <!-- <div class="mt-05"><strong>Tipo: <?php //echo $TipoTurno?> </strong></div> -->
                    <div class="mt-05"><strong>Estado: <?=$Estado?> </strong></div>
                    <!-- <span class="mt-05 btn btn-sm btn-link border prestadores" data-id="Prestador_Id">Ver especialidades</span> -->
                  </div>
                </div>
                <div class="col-2" style="text-align: center;align-self: center;"><?php
                  if($fecha_turno>=date("Y-m-d H:i")){?>
                    <div class="delete_turno bg-danger" data-turno="<?=$turno["TurnoNumero"]?>" style="margin-top:0;max-width: 40px;padding-top: 5px;padding-bottom: 5px;"><ion-icon name="trash"></ion-icon></div><?php
                  }?>
                </div>
              </div><?php
            }
          }else{?>
            <div class="row border border-2 border-secondary rounded m-2 p-1">
              <div class="col-12">
                <h3 class="mb-05 mt-05 titulo1">Sin turnos</h3>
              </div>
            </div><?php
          }?>
        </ul>
      </div>
    </div>
  </div>
  <!-- * App Capsule -->
    
  <!-- Modal Form Nuevo Turno -->
  <div class="modal fade modalbox animate__animated animate__fadeInRight" id="ModalNuevoTurno" data-bs-backdrop="static" tabindex="-1" role="dialog">
    <div class="modal-dialog" role="document">
      <div class="modal-content">
        <div class="modal-header">
          <h3 class="modal-title">Nuevo Turno</h3>
        </div>
        <div class="modal-body">
          <div class="login-form">
            <div class="section mt-2">
              
            </div>
            <div class="section mt-4 mb-5">
              <form name="form" method="post" name="form1">
                <div class="form-group basic">
                  <label class="form-label" for="id_afiliado">Afiliado</label>
                  <select name="id_afiliado" id="id_afiliado" class="form-control col-sm-12" required>
                    <option value="">Seleccione...</option><?php
                    $url=$url_ws."?Modo=6&Usuario=$usuario_ws&Ficha=$ficha";
                    //echo $url;
                    $jsonData = json_decode(file_get_contents($url),true);
                    $grupo_fliar=$jsonData[0]["Data"];
                    foreach ($grupo_fliar as $persona) {
                      if($persona['Id']==170835){
                        //$persona['Id']=121600;//para probar los mensajes
                      }?>
                      <option value='<?=$persona['Id']?>'><?=$persona['Apellido']." ".$persona['Nombre']?></option><?php
                    }?>
                  </select>
                </div>
                <div class="form-group basic">
                  <label class="form-label" for="id_policlinico">Policlinico</label>
                  <select name="id_policlinico" id="id_policlinico" class="form-control col-sm-12" required>
                    <option value="">Seleccione...</option><?php
                    $url=$url_ws."?Modo=14&Usuario=$usuario_ws";
                    //echo $url;
                    $jsonData = json_decode(file_get_contents($url),true);
                    //var_dump($jsonData);
                    $policlinicos=$jsonData["Data"];
                    foreach ($policlinicos as $policlinico) {?>
                      <option value='<?=$policlinico['Id']?>'><?=$policlinico['Policlinico']?></option><?php
                    }?>
                  </select>
                </div>
                <div class="form-group basic">
                  <label class="form-label" for="id_especialidad">Especialidad</label>
                  <select name="id_especialidad" id="id_especialidad" class="form-control col-sm-12" required>
                    <option value="">Seleccione un policlinico</option>
                  </select>
                </div>
                <div class="form-group basic">
                  <label class="form-label" for="id_profesional">Profesional</label>
                  <select name="id_profesional" id="id_profesional" class="form-control col-sm-12" required>
                    <option value="">Seleccione una especialidad</option>
                  </select>
                  <span id="mensaje" class="d-none text-danger"></span>
                </div>
                <div class="form-group basic">
                  <label class="form-label d-block" for="calendario">Calendario</label>
                  <input type="text" class="form-control" name="calendario" id="calendario"/>
                </div>
                  
                <div class="form-group basic">
                  <label class="form-label" for="hora">Turnos disponibles para el día <span id="dia"></span></label>
                  <select name="hora" id="hora" class="form-control col-sm-12" required>
                    <option value="">Seleccione una fecha</option>
                  </select>
                </div>
                
                <div class="mt-2">
                  <button type="submit" class="btn btn-primary btn-block btn-lg">Solicitar</button>
                  <button type="button" onclick="resetearFormulario()" class="btn btn-primary btn-block btn-lg" data-bs-dismiss="modal">Cerrar</button>
                </div>

              </form>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
  <!-- * Modal Form Nuevo Turno -->

  <!-- Modal Eliminar -->
  <div class="modal fade modalbox " id="ModalConfirmEliminarTurno" data-bs-backdrop="static" tabindex="-1" role="dialog" style="background-color: rgb(0 0 0 / 50%);">
    <div class="modal-dialog" role="document" style="top: 25%;left: 10%;width: 80%;min-width: 0;max-height: 30%;">
      <div class="modal-content" style="padding-top: 0;height: min-content;">
        <!-- <div class="modal-header">
          
        </div> -->
        <div class="modal-body" style="height: min-content;">
          <h3 class="modal-title" style="color:black">¿Está seguro que desea eliminar el turno?</h3>
        </div>
        <div class="modal-footer">
          <button type="button" id="btnEliminar" data-turno class="btn btn-danger btn-block btn-lg" data-bs-dismiss="modal">Eliminar</button>
          <button type="button" class="btn btn-primary btn-block btn-lg" data-bs-dismiss="modal">Cerrar</button>
        </div>
      </div>
    </div>
  </div>
  <!-- * Modal Eliminar -->

  <!-- Modal Confirmar nuevo turno -->
  <div class="modal fade modalbox " id="ModalConfirmNuevoTurno" data-bs-backdrop="static" tabindex="-1" role="dialog" style="background-color: rgb(0 0 0 / 50%);">
    <div class="modal-dialog" role="document" style="top: 25%;left: 10%;width: 80%;min-width: 0;max-height: 30%;">
      <div class="modal-content" style="padding-top: 0;height: min-content;">
        <!-- <div class="modal-header">
          
        </div> -->
        <div class="modal-body" style="height: min-content;">
          <h3 class="modal-title" style="color:black">El turno se dió de alta correctamente</h3>
        </div>
        <div class="modal-footer">
          <!-- <button type="button" class="btn btn-primary btn-block btn-lg">OK</button> -->
          <a href="turnos.php" type="button" class="btn btn-primary btn-block btn-lg">OK</a>
        </div>
      </div>
    </div>
  </div>
  <!-- * Modal Confirmar nuevo turno -->

  <!-- Modal error nuevo turno -->
  <div class="modal fade modalbox " id="ModalErrorTurno" data-bs-backdrop="static" tabindex="-1" role="dialog" style="background-color: rgb(0 0 0 / 50%);">
    <div class="modal-dialog" role="document" style="top: 25%;left: 10%;width: 80%;min-width: 0;max-height: 30%;">
      <div class="modal-content" style="padding-top: 0;height: min-content;">
        <!-- <div class="modal-header">
        </div> -->
        <div class="modal-body" style="height: min-content;">
          <h3 class="modal-title" style="color:black"></h3>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-primary btn-block btn-lg" data-bs-dismiss="modal">OK</button>
          <!-- <a href="turnos.php" type="button" class="btn btn-primary btn-block btn-lg">OK</a> -->
        </div>
      </div>
    </div>
  </div>
  <!-- * Modal error nuevo turno -->

  <!-- App Bottom Menu --><?php
  include_once("footer.php")?>
  <!-- * App Bottom Menu -->

  <!-- ============== Js Files ==============  -->
  <!-- Bootstrap -->
  <script src="assets/js/lib/bootstrap.min.js"></script>
  <!-- jQuery Js File -->
  <script src="assets/js/lib/jquery-3.4.1.min.js"></script>
  <!-- Ionicons -->
  <script type="module" src="https://unpkg.com/ionicons@5.5.2/dist/ionicons/ionicons.js"></script>
  <!-- Splide -->
  <script src="assets/js/plugins/splide/splide.min.js"></script>
  <!-- ProgressBar js -->
  <script src="assets/js/plugins/progressbar-js/progressbar.min.js"></script>
  <!-- Base Js File -->
  <!-- <script src="assets/js/base.js"></script> -->
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
  <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
  <script src="admin/vendor/datetimepicker-xdsoft/build/jquery.datetimepicker.full.min.js"></script>

  <script>
	function resetearFormulario() {
		document.getElementById("id_afiliado").options.selectedIndex=0;
		document.getElementById("id_policlinico").options.selectedIndex=0;
		document.getElementById("id_especialidad").options.selectedIndex=0;
		document.getElementById("id_profesional").options.selectedIndex=0;
		document.getElementById("hora").options.selectedIndex=0;
		document.getElementById("calendario").value="";
	}

    $(document).ready(function() {
      //$("#ModalNuevoTurno").modal("show")
      setCalendar([],"")
    });
	
    $(document).on("click",".delete_turno",function(){
      //alert("Eliminar turno");
      console.log("Eliminar turno");
      let turno=this.dataset.turno;
      $("#ModalConfirmEliminarTurno").modal("show")
      $("#btnEliminar").data("turno",turno)
      console.log($("#btnEliminar"));
      console.log($("#btnEliminar").data("turno"));
    });

    $(document).on("click","#btnEliminar",function(){
      let turno=$(this).data("turno");
      $.post("eliminar_turno.php",{turno:turno}, function(data){
        console.log(data);
        data=JSON.parse(data);
        console.log(data);
        if(data.Ok){
          document.location.href=document.location.href;
        }
      });
    });

    $(document).on("change","#id_afiliado",function(){
      //get_fechas()
      $("#mensaje").addClass("d-none").html("")
      $selectPoliclinico = document.getElementById("id_policlinico").options.selectedIndex=0

      $selectProfesional = document.getElementById("id_profesional");
      addOptionSeleccion($selectProfesional,"Seleccione una especialidad...")
      setCalendar([],"")
      $selectHora = document.getElementById("hora");
      addOptionSeleccion($selectHora,"Seleccione una fecha...")

      $selectEspecialidad = document.getElementById("id_especialidad");
      addOptionSeleccion($selectEspecialidad,"Seleccione un policlinico...")
    });

    $(document).on("change","#id_policlinico",function(){
      get_especialidades()
    });

    $(document).on("change","#id_especialidad",function(){
      get_profesionales()
    });

    $(document).on("change","#id_profesional",function(){
      get_fechas()
    });

    $("form").on("submit",function(e){
      e.preventDefault();
      //alert("enviando")
      let id_afiliado=$("#id_afiliado").val();
      let id_profesional=$("#id_profesional").val();
      let fecha=$("#calendario").val();
      let hora=$("#hora").val();
      //console.log(id_afiliado);
      $.post("get_turno.php",{id_afiliado:id_afiliado,id_profesional:id_profesional,fecha:fecha,hora:hora}, function(data){
        console.log(data);
        data=JSON.parse(data);
        console.log(data);
        if(data.Ok=="true"){
          //document.location.href=document.location.href;
          $("#ModalConfirmNuevoTurno").modal("show")
        }else{
          let modal=$("#ModalErrorTurno")
          modal.modal("show")
          modal.find(".modal-title").text(data.Status)
        }
      });
    });

    function get_especialidades(){
      let id_policlinico=$("#id_policlinico").val();
      //console.log(id_policlinico);
      $.post("get_policlinico.php",{id_policlinico:id_policlinico}, function(data){
        data=JSON.parse(data);
        //console.log(data);

        $selectProfesional = document.getElementById("id_profesional");
        addOptionSeleccion($selectProfesional,"Seleccione una especialidad...")
        setCalendar([],"")
        $selectHora = document.getElementById("hora");
        addOptionSeleccion($selectHora,"Seleccione una fecha...")

        $selectEspecialidad = document.getElementById("id_especialidad");
        let texto="Seleccione..."
        if(id_policlinico==0){
          texto="Seleccione un policlinico..."
        }
        addOptionSeleccion($selectEspecialidad,texto)
        //Genero los options del select
        data.Data.forEach((especialidad)=>{
          $option = document.createElement("option");
          let optionText = document.createTextNode(especialidad.Especialidad);
          $option.appendChild(optionText);
          $option.setAttribute("value", especialidad.IdEspecialidad);
          $selectEspecialidad.appendChild($option);
        })
        
      });
    }

    function get_profesionales(){
      let id_policlinico=$("#id_policlinico").val();
      let id_especialidad=$("#id_especialidad").val();
      //console.log(id_especialidad);
      $.post("get_profesionales.php",{id_policlinico:id_policlinico,id_especialidad:id_especialidad}, function(data){
        data=JSON.parse(data);
        //console.log(data);

        setCalendar([],"")
        $selectHora = document.getElementById("hora");
        addOptionSeleccion($selectHora,"Seleccione una fecha...")

        $selectProfesional = document.getElementById("id_profesional");
        let texto="Seleccione..."
        if(id_especialidad==0){
          texto="Seleccione una especialidad..."
        }
        addOptionSeleccion($selectProfesional,texto)
        //Genero los options del select
        data.Data.forEach((medico)=>{
          $option = document.createElement("option");
          let optionText = document.createTextNode(medico.Medico);
          $option.appendChild(optionText);
          $option.setAttribute("value", medico.IdEspecialidadMed);
          $selectProfesional.appendChild($option);
        })
        
      });
    }

    function get_fechas(){
      $("#mensaje").addClass("d-none").html("")
      let id_afiliado=$("#id_afiliado").val();
      let id_profesional=$("#id_profesional").val();
      //console.log(id_especialidad);
      if(id_profesional>0){
        $.post("get_fechas.php",{id_profesional:id_profesional,id_afiliado:id_afiliado}, function(data){
          data=JSON.parse(data);
          console.log(data);
          if(data.Data!=undefined){
            console.log(data.Data);
            let fechas=data.Data;
            console.log(fechas);

            $selectHora = document.getElementById("hora");
            addOptionSeleccion($selectHora,"Seleccione una fecha...")

            let diasHabilitados=[]
            let fechaLimite="";
            if(fechas){
              if(fechas[0].IdEspecialidadMed==id_profesional){
                fechas[0].Dias.forEach((dia)=>{
                  let diaInt=parseInt(dia.Dia)
                  if(diaInt==7) diaInt=0
                  diasHabilitados.push(diaInt)
                })
              }
              fechaLimite=fechas[0].FechaLimite;
            }
            setCalendar(diasHabilitados,fechaLimite)
          }else{
            let msg=""
            if(data.Msg!=undefined){
              msg=data.Msg
            }
            $("#mensaje").removeClass("d-none").html(msg)
            setCalendar([],"")
            get_horas("");
          }
          
        });
      }
    }

    function setCalendar(diasAtiende,fechaLimite){
      //console.log(diasAtiende);
			let diasSemana=[0,1,2,3,4,5,6];

      const diferenciaDeArreglos = (arr1, arr2) => {
        return arr1.filter(elemento => arr2.indexOf(elemento) == -1);
      }
      let diasBloqueados=diferenciaDeArreglos(diasSemana,diasAtiende);
      if(fechaLimite==""){
        fechaLimite=false
      }

      // Mostrar resultados:
      /*console.log("dias a bloquear");
      console.log( diasBloqueados );*/

			$.datetimepicker.setLocale('es');
			var fecha=$('#calendario');
			//console.log(dias);
			//var fechasBloqueadas=
      var currentDate = null;
      fecha.val('');
			fecha.datetimepicker({
				dayOfWeekStart : 1,
				format:'d/m/Y',// H:i
				formatDate:'d/m/Y',
        timepicker:false,
        lang: 'es', // Localización en español
				//maxDate: 0,
				//step:15,
				inline:true,
				minDate:0,//today
        //maxDate: "01/08/2023",
        maxDate: fechaLimite,
        value:'',
				defaultSelect: false,
        //theme:'dark',
        disabledWeekDays: diasBloqueados,
        onGenerate:function( ct ){
          /*console.log("onGenerate");
          console.log(ct);
          console.log(currentDate);*/
          const date=format_date(ct)
          /*console.log(date);
          console.log(fecha.val());*/
          if(date!=fecha.val()){
            //son distintos, borro la clase current
            $(".xdsoft_date.xdsoft_current").removeClass("xdsoft_current")
          }
        },
				onSelectDate:function(ct,$i,p){
          /*console.log("onSelectDate");
          console.log(ct);
          console.log(currentDate);*/
		  get_horas("");
          currentDate = ct;
          const date=format_date(ct)
          get_horas(date);
				},
			});
		}

    function get_horas(fecha){
      let id_profesional=$("#id_profesional").val();
      $("#dia").html(fecha)
      //console.log(id_profesional);
      if(fecha!=""){
        $.post("get_horas.php",{id_profesional:id_profesional,fecha:fecha}, function(data){
          //console.log(data);
          data=JSON.parse(data);
          //console.log(data);
          //console.log(data.Data);
          let horarios=data.Data.Horarios;
          //console.log(horarios);

          $selectHora = document.getElementById("hora");
          addOptionSeleccion($selectHora,"Seleccione...")

          //Genero los options del select
          horarios.forEach((horario)=>{
            //console.log(horario);
            $option = document.createElement("option");
            let optionText = document.createTextNode(horario.Hora);
            $option.appendChild(optionText);
            $option.setAttribute("value", horario.Hora);
            $selectHora.appendChild($option);
          })
          
        });
      }else{
        $selectHora = document.getElementById("hora");
        addOptionSeleccion($selectHora,"Seleccione una fecha...")
      }
    }

    function format_date(ct){
      let year = ct.getFullYear() // 2019
      let day = ct.getDate() // 23
      let month = ct.getMonth() // 23
      //console.log(year);
      day=String(day).padStart(2, '0');// Expected output: "05"
      month=parseInt(month)+1;
      month=String(month).padStart(2, '0');// Expected output: "05"
      const date=day+"/"+month+"/"+year;
      return date;
    }

    function addOptionSeleccion($select,texto){
      //Vacío el select
      $select.innerHTML=""
      
      //Genero el option "Seleccione..." del select
      $option = document.createElement("option");
      let optionText = document.createTextNode(texto);
      $option.appendChild(optionText);
      $option.setAttribute("value","");
      $select.appendChild($option);
    }

  </script>
</body>
</html>