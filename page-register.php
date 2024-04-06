<!doctype html>
<html lang="en">
<head>
  <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1, minimum-scale=1, maximum-scale=1, viewport-fit=cover" />
  <meta name="apple-mobile-web-app-capable" content="yes" />
  <meta name="apple-mobile-web-app-status-bar-style" content="black-translucent">
  <meta name="theme-color" content="#000000">
  <title>OSPIA APP Registro</title>
  <meta name="description" content="Mobilekit HTML Mobile UI Kit">
  <meta name="keywords" content="bootstrap 5, mobile template, cordova, phonegap, mobile, html" />
  <link rel="icon" type="image/png" href="assets/img/favicon.png" sizes="32x32">
  <link rel="apple-touch-icon" sizes="180x180" href="assets/img/icon/192x192.png">
  <link rel="stylesheet" href="assets/css/style.css">
  <link rel="manifest" href="__manifest.json">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/animate.css/4.1.1/animate.min.css">
  <!-- Pikaday Library -->
  <link rel="stylesheet" type="text/css" href="https://cdn.jsdelivr.net/npm/pikaday/css/pikaday.css">
</head>

<style>
  .calendario{
    width: 30%;
    display: inline-block;
  }
  .lblRegister{
    color: white;
    font-size: large;
  }
</style><?php

$token=$_GET["token"]?>

<body class="bg1">
  <!-- 
  <div id="loader">
      <div class="spinner-border text-primary" role="status"></div>
  </div>
    loader -->

  <!-- App Header -->
  <div class="appHeader no-border transparent position-absolute">
    <div class="left animate__animated animate__fadeInRight">
      <a href="main-login.php?token=<?=$token?>&nueva_app=<?=$_GET['nueva_app']?>" class="headerButton goBack">
        <ion-icon name="chevron-back-outline"></ion-icon>VOLVER
      </a>
    </div>
    <div class="pageTitle"></div>
    <div class="right animate__animated animate__fadeInRight">
      <a href="page-login.php?token=<?=$token?>&nueva_app=<?=$_GET['nueva_app']?>" class="headerButton">Login</a>
    </div>
  </div>
  <!-- * App Header -->

  <!-- App Capsule -->
  <div id="appCapsule">

    <div class="login-form animate__animated animate__fadeInRight">
      <div class="section">
        <h1>Crear cuenta</h1>
      </div>
      <div class="section mt-2 mb-5">
        <form id="form-register" action="page-login.php"><?php
          $dni="";
          $fecha_nacimiento="";
          $email="";
          
          /*$dni="44933437";
          $fecha_nacimiento="2003-08-11";
          $email="axeltecnosoul@gmail.com";*/?>

          <input type="hidden" id="token" name="token" value="<?=$token?>">

          <br>
          <div class="form-group boxed text-start">
            <div class="input-wrapper">
              <label class="lblRegister">DNI:</label><br>
              <input type="text" required class="form-control" id="dni" placeholder="DNI" value="<?=$dni?>">
              <i class="clear-input">
                <ion-icon name="close-circle"></ion-icon>
              </i>
            </div>
          </div>

          <div class="form-group boxed d-none">
            <div class="input-wrapper">
              <!-- <input type="date" required class="form-control" id="fecha_nacimiento" placeholder="Fecha nacimiento" value="<?=$fecha_nacimiento?>"> -->
              <!-- <input type="text" required class="form-control" id="fecha_nacimiento" placeholder="Fecha de nacimiento" value="<?=$fecha_nacimiento?>">
              <i class="clear-input">
                <ion-icon name="close-circle"></ion-icon>
              </i> -->

            </div>
          </div>

          <div class="form-group boxed text-start">
            <label class="lblRegister">Fecha de nacimiento:</label><br>
            <div class="input-wrapper text-center">
              <select class="form-control calendario" id="daySelect">
                <option value="">- Dia -</option><?php
                //Opciones para seleccionar día
                // Generar opciones para seleccionar el día
                for ($i = 1; $i <= 31; $i++) {
                  echo "<option value='$i'>$i</option>";
                }
                ?>
              </select>
              <select class="form-control calendario" id="monthSelect">
                <!-- Opciones para seleccionar el mes -->
                <option value="">- Mes -</option>
                <option value="01">Enero</option>
                <option value="02">Febrero</option>
                <option value="03">Marzo</option>
                <option value="04">Abril</option>
                <option value="05">Mayo</option>
                <option value="06">Junio</option>
                <option value="07">Julio</option>
                <option value="08">Agosto</option>
                <option value="09">Septiembre</option>
                <option value="10">Octubre</option>
                <option value="11">Noviembre</option>
                <option value="12">Diciembre</option>
                <!-- Agrega más meses según necesites -->
              </select>
              <select class="form-control calendario" id="yearSelect">
                <option value="">- Año -</option><?php
                //Opciones para seleccionar el año
                // Obtener el año actual
                $currentYear = date("Y");
                // Definir el rango de años, por ejemplo, 10 años antes y 10 años después del año actual
                $startYear = $currentYear - 80;
                $endYear = $currentYear;
                // Generar opciones para seleccionar el año dentro del rango
                for ($year = $endYear; $year >= $startYear; $year--) {
                  echo "<option value='$year'>$year</option>";
                }?>
              </select>
            </div>
          </div>


          <div class="form-group boxed text-start">
            <div class="input-wrapper">
              <label class="lblRegister">Email:</label><br>
              <input type="email" required class="form-control" id="email" placeholder="Email address" value="<?=$email?>">
              <i class="clear-input">
                <ion-icon name="close-circle"></ion-icon>
              </i>
            </div>
          </div>

          <div class=" mt-1 text-start">
            <div class="form-check">
              <input type="checkbox" required class="form-check-input" id="customCheckb1">
              <label class="form-check-label" for="customCheckb1">Estoy de acuerdo con <a href="#" data-bs-toggle="modal" data-bs-target="#ModalBasic">los Terminos & Condiciones</a></label>
            </div>
            <div class="modal fade modalbox" id="ModalBasic" data-bs-backdrop="static" tabindex="-1" role="dialog">
              <div class="modal-dialog" role="document">
                <div class="modal-content">
                  <div class="modal-header">
                    <h3 class="modal-title">Términos y condiciones</h3>
                  </div>
                  <div class="modal-body">
                    <!-- <p>
                      Lorem ipsum dolor sit amet, consectetur adipiscing elit. Nunc fermentum, urna eget finibus
                      fermentum, velit metus maximus erat, nec sodales elit justo vitae sapien. Sed fermentum
                      varius erat, et dictum lorem. Cras pulvinar vestibulum purus sed hendrerit. Praesent et
                      auctor dolor. Ut sed ultrices justo. Fusce tortor erat, scelerisque sit amet diam rhoncus,
                      cursus dictum lorem. Ut vitae arcu egestas, congue nulla at, gravida purus.
                    </p>
                    <p>
                      Donec in justo urna. Fusce pretium quam sed viverra blandit. Vivamus a facilisis lectus.
                      Nunc non aliquet nulla. Aenean arcu metus, dictum tincidunt lacinia quis, efficitur vitae
                      dui. Integer id nisi sit amet leo rutrum placerat in ac tortor. Duis sed fermentum mi, ut
                      vulputate ligula.
                    </p>
                    <p>
                      Vivamus eget sodales elit, cursus scelerisque leo. Suspendisse lorem leo, sollicitudin
                      egestas interdum sit amet, sollicitudin tristique ex. Class aptent taciti sociosqu ad litora
                      torquent per conubia nostra, per inceptos himenaeos. Phasellus id ultricies eros. Praesent
                      vulputate interdum dapibus. Duis varius faucibus metus, eget sagittis purus consectetur in.
                      Praesent fringilla tristique sapien, et maximus tellus dapibus a. Quisque nec magna dapibus
                      sapien iaculis consectetur. Fusce in vehicula arcu. Aliquam erat volutpat. Class aptent
                      taciti sociosqu ad litora torquent per conubia nostra, per inceptos himenaeos.
                    </p> -->
                    <h5 style="color: #141515;font-weight: bold;">1. Términos y Condiciones generales y su aceptación</h5>
                    <p style="text-align: justify;text-justify: inter-word;">
                      A continuación, se describen los Términos y Condiciones Generales (en adelante las
                      &quot;Condiciones Generales&quot;) aplicables a la utilización de los servicios y contenidos suministrados
                      por la aplicación web (en adelante, el &quot;SITIO&quot;) que la OBRA SOCIAL DEL PERSONAL DE LA
                      INDUSTRIA DE LA ALIMENTACION (en adelante &quot;OSPIA&quot;) pone a disposición de los Usuarios en
                      general.<br>
                      La utilización del SITIO implica la aceptación expresa, plena y sin reservas por parte del Usuario
                      de todos y cada uno de los Términos y Condiciones Generales en la versión publicada por
                      OSPIA en el SITIO en el momento en que el Usuario acceda al mismo.
                      En consecuencia, el Usuario debe leer atentamente las Condiciones Generales previo a la
                      utilización del SITIO.<br>
                      Asimismo, la utilización del SITIO se encuentra sometida a todos los avisos, reglamentos de uso
                      e instrucciones puestos en conocimiento del Usuario por OSPIA, los que se integrarán a estas
                      condiciones en cuanto estos no se opongan a ellos.
                    </p>
                    <p style="text-align: justify;text-justify: inter-word;">
                      OSPIA está constantemente innovando a fin de ofrecer el mejor servicio posible a sus Usuarios.
                      Por el presente acuerdo, usted reconoce y acepta que el contenido y la naturaleza de los
                      Servicios que proporciona OSPIA pueden variar ocasionalmente sin previo aviso.
                    </p>
                    <p style="text-align: justify;text-justify: inter-word;">
                      Como parte de esta permanente innovación, usted reconoce y acepta que OSPIA pueda
                      suspender, ya sea de forma permanente o temporal, los Servicios, o alguna de las funciones
                      incluidas en estos, para usted o para los Usuarios en general, a discreción de OSPIA y sin previo
                      aviso. Usted podrá interrumpir el uso que haga de los Servicios en cualquier momento que lo
                      desee. No es necesario que informe de ello a OSPIA.
                    </p>
                    <p style="text-align: justify;text-justify: inter-word;">
                      A fin de poder acceder a determinados Servicios, es posible que se le solicite información
                      personal, por ejemplo, datos identificativos e información de contacto, como parte del proceso
                      de registro en el Servicio o como parte del uso continuado de los Servicios. Usted se
                      compromete a que cualquier información de registro que facilite a OSPIA será precisa, correcta
                      y actual.
                    </p>
                    <p style="text-align: justify;text-justify: inter-word;">
                      Teniendo en cuenta que OSPIA puede modificar en cualquier momento estos términos y
                      condiciones, le sugerimos consultarlos periódicamente.
                    </p>
                    <h5 style="color: #141515;font-weight: bold;">2. Quiénes somos</h5>
                    <p style="text-align: justify;text-justify: inter-word;">
                      OSPIA, a través de este SITIO, facilita a los Usuarios el acceso y la utilización de diversos
                      servicios puestos a su disposición por OSPIA o por terceros proveedores de información (en
                      adelante, los &quot; Servicios&quot;).
                    </p>
                    <h5 style="color: #141515;font-weight: bold;">3. Condiciones de Utilización del Sitio</h5>
                    <p style="text-align: justify;text-justify: inter-word;">
                      A) Obligaciones del Usuario.<br>
                      A.1) Hacer uso correcto del SITIO.<br>
                      El Usuario se compromete a utilizar el SITIO de conformidad con la ley, estas Condiciones
                      Generales, así como con la moral y buenas costumbres generalmente aceptadas y el orden
                      público.<br>
                      El Usuario se obliga a abstenerse de utilizar el SITIO con fines o efectos ilícitos, contrarios a lo
                      establecido en estas Condiciones Generales, lesivos de los derechos e intereses de terceros, o
                      que de cualquier forma puedan dañar, inutilizar, sobrecargar o deteriorar el SITIO o impedir la
                      normal utilización o disfrute del SITIO por parte de los Usuarios.<br>
                      A.2.1) Conducta general. Queda prohibido:<br>
                      a) utilizar el SITIO, directa o indirectamente, para violar cualquier ley aplicable, cualquiera
                      fuese su naturaleza, ya sea internacional, nacional, provincial o local;<br>
                      b) transmitir material pornográfico u obsceno;<br>
                      c) transmitir, distribuir o almacenar cualquier tipo de información, datos o materiales que
                      violen leyes o regulaciones internacionales, nacionales o provinciales;<br>
                      d) enviar o transmitir información cuyo contenido sea, directa o indirectamente, y sin que lo
                      siguiente se considere una limitación, trasgresor, profano, abusivo, difamatorio y/o
                      fraudulento, o que revele asuntos privados o personales que afecten a persona alguna, o que
                      de alguna manera violen derechos de terceros;<br>
                      e) utilizar los servicios utilizando un nombre falso, erróneo o inexistente, ya sea como persona
                      física o jurídica;<br>
                      f) transmitir material que el Usuario no tenga derecho a transmitir con arreglo a las leyes
                      vigentes (ya sea de “Copyright”, marca registrada, secreto comercial, patentes u otros
                      derechos de la propiedad de terceros) o con arreglo a relaciones contractuales o fiduciarias
                      (tales como los contratos de no divulgación);<br>
                      g) efectuar acciones que restrinjan, denieguen o impidan a cualquier individuo, grupo, entidad
                      u organización, el uso de los contenidos o servicios ofrecidos a través del SITIO;<br>
                      A.2.2) Seguridad.<br>
                      Queda prohibido:<br>
                      a) intentar la violación de los sistemas de autenticación, verificación de identidad y seguridad
                      del servidor, redes o cuentas de Usuarios; esto incluye, y no se limita, a tratar de acceder a
                      datos no destinados al Usuario, intentar ingresar en el servidor o cuentas sin contar con la
                      expresa autorización para hacerlo, o intentar probar la seguridad de nuestras redes, utilizando
                      herramientas para pruebas de intrusión u otras similares (por ejemplo de mapeo de rutas de
                      red windows, de mapeo de rutas de red Unix, de mapeo de puertos, clientes DNS, browser
                      SNMP, scanner de vulnerabilidades; Proxy de intercepción; Spider; Analizador de
                      vulnerabilidades web, Suite completa de análisis de seguridad web; Sniffer de paquetes de red;
                      Sniffer de passwords; Cliente TCP; Cliente y servidor TCP y UDP; analizador de redes
                      inalámbricas para Linux; analizador de redes inalámbricas para windows; Sistemas de
                      obtención de contraseñas WEP; etc.)<br>
                      b) intentar interrupciones en las comunicaciones de Internet, tales como alterar información
                      de ruteo, sobrecargar deliberadamente un servicio, efectuar ataques informáticos a otras
                      computadoras sobre Internet, entre otros;<br>
                      c) utilizar cualquier programa, comando o grupo de comandos, o enviar mensajes de cualquier
                      tipo, destinados a interferir con la sesión establecida por un Usuario en cualquier punto de
                      Internet;<br>
                      d) efectuar cualquier tipo de monitoreo que implique la intercepción de información no
                      destinados al Usuario;<br>
                      e) enviar o transmitir archivos que contengan virus u otras características destructivas que
                      puedan afectar de manera adversa el funcionamiento de una computadora ajena y/o puedan
                      afectar el correcto funcionamiento de las mismas y/o del SITIO;<br>
                      A 3.1) Medios para la obtención de Contenidos<br>
                      El Usuario deberá abstenerse de obtener e incluso de intentar obtener informaciones,
                      mensajes, gráficos, dibujos, archivos de sonido y/o imagen, fotografías, grabaciones, software
                      y, en general, cualquier clase de material accesibles a través del SITIO (en adelante, los
                      &quot;Contenidos&quot;) empleando para ello medios o procedimientos distintos de los que se empleen
                      habitualmente en Internet a este efecto y siempre que no entrañen un riesgo de daño o
                      inutilización del SITIO y/o de los Contenidos.<br>
                      A.3.2) Uso correcto de los Contenidos<br>
                      El Usuario se obliga a usar los Contenidos y los Servicios ofrecidos de forma diligente, correcta
                      y lícita y, en particular, se compromete a abstenerse de:<br>
                      a) utilizarlos de forma, con fines o efectos contrarios a la ley, a la moral y a las buenas
                      costumbres generalmente aceptadas o al orden público;<br>
                      b) reproducir o copiar, distribuir, permitir el acceso del público a través de cualquier
                      modalidad de comunicación pública, transformar o modificarlos, a menos que se cuente con la
                      autorización del titular de los correspondientes derechos o ello resulte legalmente permitido;<br>
                      c) suprimir, eludir o manipular el &quot;Copyright&quot; y demás datos identificativos de los derechos de
                      OSPIA o de sus titulares incorporados a los Contenidos, así como los dispositivos técnicos de
                      protección, las huellas digitales o cualesquiera mecanismos de información que pudieren
                      contener los Contenidos;<br>
                      d) emplear los Contenidos y, en particular, la información de cualquier clase obtenida a través
                      del SITIO o de los Servicios para comercializar o divulgar de cualquier modo dicha información.
                      A.3.3) Indemnidades<br>
                      El Usuario defenderá y mantendrá indemne a OSPIA, contra todo daño y/o perjuicio,
                      cualquiera fuese su naturaleza, inclusive los gastos por honorarios de abogados, que pudieran
                      surgir con motivo u ocasión de cualquier acción o demanda iniciada por un tercero como
                      consecuencia del incumplimiento del Usuario de cualquiera de las cláusulas del presente
                      contrato, o de la violación por el mismo de cualquier ley o derecho de un tercero.
                      De la misma manera, el Usuario mantendrá indemne a OSPIA y las empresas del Grupo, así
                      como también a sus funcionarios, directores, empleados, representantes, presentes o futuros,
                      de y contra todo daño y/o perjuicio, cualquiera fuese su naturaleza, derivado u ocasionado,
                      directa o indirectamente, por la utilización de los Servicios ofrecidos en el SITIO, cuando se
                      deriven o sean ocasionados, directa o indirectamente, del incumplimiento del Usuario de
                      cualquiera de las cláusulas del presente contrato, o de la violación por el mismo de cualquier
                      ley o derecho de un tercero.<br>
                      A.3.4) Utilización bajo exclusiva responsabilidad<br>
                      El Usuario es consciente de y acepta voluntariamente que el uso del SITIO y de los Contenidos
                      tiene lugar, en todo caso, bajo su única y exclusiva responsabilidad.<br>
                      El Usuario reconoce y acepta que es el único responsable de mantener la confidencialidad de
                      sus contraseñas asociadas a cualquiera de los Servicios a los que accede a través del Sitio.
                      En consecuencia, acepta que será el único responsable ante OSPIA de todas y cada una de las
                      actividades que se desarrollen mediante el acceso al Sitio a través de sus contraseñas.
                      Asimismo, el Usuario se compromete a notificar de inmediato a OSPIA de cualquier uso no
                      autorizado de sus contraseñas de que tenga conocimiento.<br>
                      El Usuario comprende que dadas las condiciones de seguridad que ofrece hoy Internet, debe
                      tener presente que al divulgar información personal en línea, ya sea al momento de
                      suscribirse, contratar algún producto y/o servicio o utilizando algún tipo de chat o
                      comunicación virtual, la misma puede ser recogida o utilizada por otros.
                    </p>
                    <h5 style="color: #141515;font-weight: bold;">4. EL SITIO</h5>
                    <p style="text-align: justify;text-justify: inter-word;">
                      A.4.1) Funcionamiento del SITIO y los Servicios.<br>
                      A.4.1.1.1) General.<br>
                      OSPIA contrata su acceso a Internet con un tercero proveedor del mismo. Usted acepta y
                      reconoce que el SITIO puede no siempre estar disponible debido a dificultades técnicas o fallas
                      de Internet, del proveedor, o por cualquier otro motivo ajeno a OSPIA. En consecuencia, OSPIA
                      no garantiza la disponibilidad y continuidad del funcionamiento del SITIO; como tampoco
                      garantiza la utilidad del SITIO para la realización de ninguna actividad en particular, ni su
                      infalibilidad y, en particular, aunque no de modo exclusivo, que los Usuarios puedan
                      efectivamente utilizar el SITIO y acceder a las distintas funciones que forman el SITIO.
                      OSPIA excluye cualquier responsabilidad por los daños y perjuicios de toda naturaleza que
                      sean originados en forma directa, indirecta o remota, por la interrupción, suspensión,
                      finalización, falta de disponibilidad o de continuidad del funcionamiento del SITIO, por la
                      defraudación de la utilidad que los Usuarios hubieren podido atribuir al SITIO, a la falibilidad
                      del SITIO, y en particular, aunque no de modo exclusivo, por los fallos en el acceso a las
                      distintas páginas web del SITIO.<br>
                      Cabe destacar que cualquier información o gestión disponible a través del Sitio puede ser
                      también satisfecha en forma personal o telefónica a través de sus Centros de Atención
                      Personalizada o a través de los números telefónicos que se informan en la cartilla médica.
                      OSPIA no se responsabiliza por cualquier daño, perjuicio o pérdida en el equipo del Usuario
                      originado por fallas en el sistema, servidor o en Internet.<br>
                      A.4.1.2) CONTENIDOS<br>
                      A.4.1.2.1) El Usuario acepta y entiende que el uso y o interpretación de la información
                      brindada en este sitio y las decisiones que se tomen en razón de las mismas, son realizadas
                      enteramente bajo su propio riesgo. En consecuencia, queda expresamente aclarado que las
                      decisiones a que el Usuario arribe son producto de sus facultades discrecionales. OSPIA puede
                      en cualquier momento modificar las opiniones y expresiones contenidas en el sitio sin previo
                      aviso.<br>
                      A.4.1.2.2) OSPIA NO SE RESPONSABILIZA BAJO NINGUNA CIRCUNSTANCIA POR LA
                      INTERPRETACIÓN Y/O POR LA INCORRECTA INTERPRETACIÓN DE LO EXPRESADO EN EL SITIO
                      EN FORMA EXPLÍCITA O IMPLÍCITA, NI DE SU USO INDEBIDO, ASÍ COMO TAMPOCO SERÁ
                      RESPONSABLE POR LOS PERJUICIOS DIRECTOS O INDIRECTOS CAUSADOS POR O A QUIENES
                      FUERAN INDUCIDOS A TOMAR U OMITIR DECISIONES O MEDIDAS, AL CONSULTAR EL SITIO.<br>
                      A.4.1.2.3) OSPIA no asume responsabilidad de ninguna índole, si en razón del acceso al SITIO o
                      por cualquier transferencia de datos, el equipo del Usuario se viese afectado por algún virus, o
                      por la presencia de otros elementos en los contenidos que puedan producir alteraciones en el
                      sistema informático, documentos electrónicos o ficheros de los Usuarios, siendo
                      responsabilidad del Usuario contar con los sistemas antivirus adecuados para proteger su
                      ordenador.<br>
                      A.4.1.2.4) OSPIA no se responsabiliza por los daños y perjuicios de toda naturaleza que puedan
                      deberse a la transmisión, difusión, almacenamiento, puesta a disposición, recepción,
                      obtención o acceso a los contenidos, y en particular, aunque no de modo exclusivo, por los
                      daños y perjuicios que puedan deberse a:<br>
                      a) el incumplimiento de la ley, la moral y las buenas costumbres generalmente aceptadas o el
                      orden público como consecuencia de la transmisión, difusión, almacenamiento, puesta a
                      disposición, recepción, obtención o acceso a los contenidos;<br>
                      b) la infracción de los derechos de propiedad intelectual e industrial, de los secretos
                      empresariales, de compromisos contractuales de cualquier clase, de los derechos al honor, a la
                      intimidad personal y familiar y a la imagen de las personas, de los derechos de propiedad y de
                      toda otra naturaleza pertenecientes a un tercero como consecuencia de la transmisión,
                      difusión, almacenamiento, puesta a disposición, recepción, obtención o acceso a los
                      contenidos;<br>
                      c) la realización de actos de competencia desleal y publicidad ilícita como consecuencia de la
                      transmisión, difusión, almacenamiento, puesta a disposición, recepción, obtención o acceso a
                      los contenidos;<br>
                      d) la inadecuación para cualquier clase de propósito y la defraudación de las expectativas
                      generadas por los contenidos;<br>
                      e) el incumplimiento, retraso en el cumplimiento, cumplimiento defectuoso o terminación por
                      cualquier causa de las obligaciones contraídas por terceros y contratos realizados con terceros
                      a través de o con motivo del acceso a los contenidos;<br>
                      f) los vicios y defectos de toda clase de los contenidos transmitidos, difundidos, almacenados,
                      puestos a disposición o de otra forma transmitidos o puestos a disposición, recibidos,
                      obtenidos o a los que se haya accedido a través del SITIO.<br>
                      A.4.2) Responsabilidad por los contenidos, productos y servicios alojados fuera del SITIO.
                      El SITIO, con el único objeto facilitarle a los Usuarios la búsqueda de y acceso a la información
                      disponible en Internet, pone a disposición de los Usuarios dispositivos técnicos de enlace,
                      directorios, buscadores, herramientas de búsqueda o cualquier otro tipo de vinculación
                      telemática. Esto permite a los Usuarios acceder a sitios de Internet pertenecientes a y/o
                      gestionados por Terceros (en adelante los &quot;Sitios Enlazados&quot;).<br>
                      OSPIA no ofrece ni comercializa por sí ni por medio de terceros los productos y servicios
                      disponibles en los Sitios Enlazados.<br>
                      El Usuario acepta y entiende que Internet contiene materiales de todo tipo, editados y no
                      editados, algunos de los cuales pueden contener escenas de sexo explícito o pueden ser
                      ofensivos para con usted o su grupo familiar.<br>
                      OSPIA no controla previamente, aprueba, vigila ni hace propios los productos, y servicios,
                      contenidos, información, datos, archivos, productos y cualquier clase de material existente en
                      los Sitios Enlazados.<br>
                      En consecuencia, su acceso, o el de su grupo familiar, a estos materiales es considerado a su
                      exclusivo riesgo. El Usuario, por tanto, debe extremar la prudencia en la valoración y
                      utilización de los servicios, información, datos, archivos, productos y cualquier clase de
                      material existente en los Sitios Enlazados.<br>
                      OSPIA no asume ningún tipo de responsabilidad por los daños y perjuicios de toda clase que
                      puedan deberse a:<br>
                      a) el funcionamiento, disponibilidad, accesibilidad o continuidad de los sitios enlazados;<br>
                      b) el mantenimiento de los servicios, información, datos, archivos, productos y cualquier clase
                      de material existente en los sitios enlazados;<br>
                      c) la prestación o transmisión de los servicios, información, datos, archivos, productos y
                      cualquier clase de material existente en los sitios enlazados;<br>
                      d) la calidad, licitud, fiabilidad y utilidad de los servicios, información, datos, archivos,
                      productos y cualquier clase de material existente en los sitios enlazados, y de los servicios
                      prestados por terceros a través del SITIO.<br>
                    </p>
                    <h5 style="color: #141515;font-weight: bold;">5. Derecho de Revocación</h5>
                    <p style="text-align: justify;text-justify: inter-word;">
                      OSPIA se reserva el derecho, en cualquier momento y sin necesidad de darle notificación
                      previa, de denegar, retirar el acceso al SITIO, o dar por concluido su calidad de Usuario del
                      SITIO por violación de las condiciones generales aquí descriptas.<br>
                      OSPIA se reserva el derecho en cualquier momento y sin necesidad de darle notificación
                      previa, de denegar, retirar el acceso al SITIO, o dar por concluido su calidad de Usuario del
                      SITIO si las condiciones de empadronamiento no se ajustan a la legislación vigente.
                    </p>
                    <h5 style="color: #141515;font-weight: bold;">6. General</h5>
                    <p style="text-align: justify;text-justify: inter-word;">
                      El presente acuerdo no podrá ser interpretado como un contrato de sociedad, mandato,
                      agencia, o que genere ningún tipo de relación entre OSPIA y el Usuario. Si alguna de las
                      condiciones que anteceden fuera declarada nula, dicha nulidad no afectará en modo alguno la
                      validez o exigibilidad del resto de las condiciones previstas en este acuerdo. Este acuerdo no
                      podrá ser enmendado o modificado por el Usuario, a excepción de que sea por medio de un
                      documento escrito y firmado tanto por el Usuario como por el representante legal de OSPIA.
                      Nuestra falta de acción con respecto a una violación del convenio por parte del Usuario u otros
                      no afecta nuestro derecho actuar frente a una violación posterior o similar. Los acápites del
                      presente acuerdo están puestos únicamente como referencia, y de ninguna manera definen,
                      limitan, delimitan o describen el ámbito o la extensión de dicha sección.
                    </p>
                    <h5 style="color: #141515;font-weight: bold;">7. Comunicación</h5>
                    <p style="text-align: justify;text-justify: inter-word;">
                      Toda notificación u otra comunicación que deba efectuarse bajo el presente, deberá realizarse
                      por escrito: (i) al Usuario: al domicilio informado por el Usuario o a la cuenta de correo
                      electrónico declarada; (ii).com.ar o a la calle Venezuela 1326 de la Ciudad Autónoma de
                      Buenos Aires.
                    </p>
                    <h5 style="color: #141515;font-weight: bold;">8. Jurisdicción y Derecho Aplicable</h5>
                    <p style="text-align: justify;text-justify: inter-word;">
                      Las presentes Condiciones Generales se regirán por las leyes de la República Argentina.
                      Las partes acuerdan que cualquier disputa o reclamo que surja de o con relación a, o en
                      conexión con la ejecución o cumplimiento de este Acuerdo, incluyendo sin limitación,
                      cualquier disputa sobre la validez, interpretación, exigibilidad o incumplimiento de este
                      Acuerdo, y/o cualquier disputa sobre las operaciones comerciales que realicen los Usuarios a
                      través de los sitios, será exclusiva y finalmente resueltas por la Justicia Nacional Ordinaria en lo
                      Comercial de la Capital Federal de la República Argentina.
                    </p>
                    <h5 style="color: #141515;font-weight: bold;">9. Propiedad Intelectual</h5>
                    <p style="text-align: justify;text-justify: inter-word;">
                      Todos los contenidos de este sitio, incluyendo, sin carácter limitativo, los textos (incluyendo los
                      comentarios, disertaciones, exposiciones y reproducciones), gráficos, logos, iconos, imágenes,
                      archivos de audio y video, software y todas y cada una de las características que se encuentran
                      en el SITIO son propiedad exclusiva de OSPIA y/o de sus proveedores de Contenidos, y los
                      mismos están protegidos por las leyes internacionales de propiedad intelectual. Las mejoras
                      y/o modificaciones de los Contenidos del Sitio son propiedad exclusiva de OSPIA. Todo el
                      software utilizado en este Sitio es propiedad de OSPIA y/o de sus proveedores de software. Su
                      uso indebido, así como su reproducción serán objeto de las acciones judiciales que
                      correspondan.<br>
                      La utilización de los servicios brindados por OSPIA no podrá, en ningún supuesto, ser
                      interpretada como una autorización y/o concesión de licencia de los derechos intelectuales de
                      OSPIA y/o de un tercero.<br>
                      Los Contenidos y el software del SITIO pueden ser utilizados como una herramienta de compra
                      y/o comunicación, o una fuente de información. Cualquier otro uso, incluyendo la
                      reproducción, modificación, distribución y/o transmisión, ya sea total o parcial, de los
                      Contenidos del SITIO está estrictamente prohibido, sin la expresa autorización de OSPIA.
                    </p>
                    <button type="button" class="btn btn-primary btn-block"><a href="#" data-bs-dismiss="modal">Aceptar</a></button>
                  </div>
                </div>
              </div>
            </div>
          </div>

          <div class="button1">
            <button type="submit" class="btn btn-primary btn-block btn-lg button1" id="btnCrearCuenta">CREAR CUENTA</button>
          </div>

        </form>
      </div>

      <div class="modal" tabindex="-1" role="dialog" id="DialogEmailEncontrado">
        <div class="modal-dialog" role="document">
          <div class="modal-content">
            <div class="modal-body">
              <h3 style="color: initial;margin-top: 10px;">El email ya se encuentra registrado.</h3>
            </div>
            <div class="modal-footer">
              <a href="#" class="btn btn-text-secondary" data-bs-dismiss="modal">CERRAR</a>
              <a href="page-login.php?token=<?=$token?>&nueva_app=<?=$_GET['nueva_app']?>" class="btn btn-text-secondary">LOGIN</a>
            </div>
          </div>
        </div>
      </div>

      <div class="modal" tabindex="-1" role="dialog" id="DialogEmailNOEncontrado">
        <div class="modal-dialog" role="document">
          <div class="modal-content">
            <div class="modal-body">
              <h3 style="color: initial;margin-top: 10px;">Este usuario ya está registrado con un mail diferente.</h3>
            </div>
            <div class="modal-footer">
              <a href="#" class="btn btn-text-secondary" data-bs-dismiss="modal">CERRAR</a>
            </div>
          </div>
        </div>
      </div>

      <div class="modal" tabindex="-1" role="dialog" id="DialogEmailNOEnviado">
        <div class="modal-dialog" role="document">
          <div class="modal-content">
            <div class="modal-body">
              <h3 style="color: initial;margin-top: 10px;">Ha fallado el envío del email, por favor intente mas tarde.</h3>
            </div>
            <div class="modal-footer">
              <a href="#" class="btn btn-text-secondary" data-bs-dismiss="modal">CERRAR</a>
            </div>
          </div>
        </div>
      </div>

      <div class="modal" tabindex="-1" role="dialog" id="DialogError">
        <div class="modal-dialog" role="document">
          <div class="modal-content">
            <div class="modal-body">
              <h3 style="color: initial;margin-top: 10px;">Ha ocurrido un error.</h3>
            </div>
            <div class="modal-footer">
              <a href="#" class="btn btn-text-secondary" data-bs-dismiss="modal">CERRAR</a>
            </div>
          </div>
        </div>
      </div>

      <div class="modal" tabindex="-1" role="dialog" id="DialogUserNotFound">
        <div class="modal-dialog" role="document">
          <div class="modal-content">
            <div class="modal-body">
              <h3 style="color: initial;margin-top: 10px;">Usuario no encontrado en la base de datos.</h3>
            </div>
            <div class="modal-footer">
              <a href="#" class="btn btn-text-secondary" data-bs-dismiss="modal">CERRAR</a>
            </div>
          </div>
        </div>
      </div>

      <div class="modal" tabindex="-1" role="dialog" id="DialogRegisterOk">
        <div class="modal-dialog" role="document">
          <div class="modal-content">
            <div class="modal-body">
              <h3 style="color: initial;margin-top: 10px;">Se ha enviado un mail a su casilla de correo.</h3>
            </div>
            <div class="modal-footer">
              <a href="page-login.php?token=<?=$token?>&nueva_app=<?=$_GET['nueva_app']?>" class="btn btn-text-secondary">CERRAR</a>
            </div>
          </div>
        </div>
      </div>

    </div>
  </div>
  <!-- * App Capsule -->

  <!-- ============== Js Files ==============  -->
  <!-- jQuery Js File -->
  <script src="assets/js/lib/jquery-3.4.1.min.js"></script>
  <!-- Bootstrap -->
  <script src="assets/js/lib/bootstrap.min.js"></script>
  <!-- Ionicons -->
  <script type="module" src="https://unpkg.com/ionicons@5.5.2/dist/ionicons/ionicons.js"></script>
  <!-- Splide -->
  <script src="assets/js/plugins/splide/splide.min.js"></script>
  <!-- ProgressBar js -->
  <script src="assets/js/plugins/progressbar-js/progressbar.min.js"></script>
  <!-- Base Js File -->
  <script src="assets/js/base.js"></script>
  <!-- Pikaday Library -->
  <script src="https://cdn.jsdelivr.net/npm/pikaday/pikaday.js"></script>
  <!-- MomentJS Library -->
  <script src="https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.29.1/moment.min.js"></script>


  <script>
    $(document).ready(function () {

      /*var today = new Date();
      var lastMonth = new Date().getMonth() - 1;

      var picker = new Pikaday({
        field: document.getElementById('fecha_nacimiento'),
        maxDate: today,  // maximum/latest date set to today
        // demo only
        position: 'top left',
        reposition: false,
        format: 'YYYY/MM/DD',
        minDate: '1920-01-01',
        yearRange: 100,
        toString(date, format) {
          // you should do formatting based on the passed format,
          // but we will just return 'D/M/YYYY' for simplicity
          //console.log(date);
          //const parsedDate = new Date(date);
          const parsedDate = moment(date);
          //console.log(parsedDate);
          //console.log(format);
          //const day = parsedDate.getUTCDate();
          //const month = parsedDate.getUTCMonth()+1;
          //const year = parsedDate.getUTCFullYear();
          //return `${year}-${month.toString().padStart(2, '0')}-${day.toString().padStart(2, '0')}`;
          return parsedDate.format('YYYY-MM-DD');
        },
      });*/

      $("#form-register").submit(function(e){
        e.preventDefault();
        $("#btnCrearCuenta").addClass("disabled")
        console.log("hola");
        let token=document.getElementById("token").value;
        let dni=document.getElementById("dni").value;
        //let fecha_nacimiento=document.getElementById("fecha_nacimiento").value;
        let daySelect=document.getElementById("daySelect").value;
        let monthSelect=document.getElementById("monthSelect").value;
        let yearSelect=document.getElementById("yearSelect").value;

        let email=document.getElementById("email").value;
        $.post("registrar_usuario.php",{dni:dni,daySelect:daySelect,monthSelect:monthSelect,yearSelect:yearSelect,email:email,token:token}, function(data){
          //console.log(data);
          data=JSON.parse(data);
          console.log(data);
          console.log(data.status);
          if(data.status==1){
            //e.target.submit();
            $("#DialogRegisterOk").modal("show")
          }else if(data.status==2){//email encontrado
            $("#DialogEmailEncontrado").modal("show")
          }else if(data.status==3){//usuario no encontrado
            $("#DialogUserNotFound").modal("show")
          }else if(data.status==4){//email NO encontrado
            $("#DialogEmailNOEncontrado").modal("show")
          }else if(data.status==5){//falló el envío del email
            $("#DialogEmailNOEnviado").modal("show")
          }else{//error
            $("#DialogError").modal("show")
          }
          if(data.status>1){
            $("#btnCrearCuenta").removeClass("disabled")
          }
        });
      })
    });
  </script>

</body>

</html>