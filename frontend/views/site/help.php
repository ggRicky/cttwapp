<?php
use yii\helpers\Html;

/* @var $this yii\web\View */

$this->title = 'Ayuda';
$description = 'Tópicos Generales';

$asset = \frontend\assets\AppAsset::register($this);
$baseUrl = $asset->baseUrl;

//2018-04-26 : Used to get a random int, and display a random parallax.
$randomBg = rand(1,11);;
?>

<!-- Header -->
<header id="top">
    <div class="row"> <!-- Bootstrap's row -->
        <div class="col-lg-12"> <!-- Bootstrap's col -->
            <!-- CTT logo to display over the parallax efect with opacity level -->
            <img src="<?=$baseUrl?>/img/ctt-logo_1.png" class="ctt-logo">
            <!-- Parallax Efect -->
            <div id="parallax<?=$randomBg?>" class="parallax-section" data-stellar-background-ratio="0.5">
                <div class="row"></div>
            </div>
        </div>
    </div>
</header>

<!-- Blue ribbon decoration -->
<section id="work-area-index" class="ctt-section bg-primary">
    <div class="col-lg-12">
        <div class="row">
            <!-- CTT water mark background logo decoration -->
            <div class="ctt-water-mark"></div>
        </div>
    </div>
</section>

<!-- Yii2 Content -->
<section id="yii2" class="yii2-page">

    <!-- Main menu return -->
    <div class="row">
        <div class="col-lg-10 col-lg-offset-1 text-center">
            <?= Html::a(Yii::t('app','R e g r e s a r'), ['site/index'], ['class' => 'btn btn-dark btn-ctt-fixed-width', 'title' => Yii::t('app', 'Regresar al nivel anterior')]) ?>
        </div>
    </div>

    <!-- Yii2 Title layout -->
    <div class="row">
        <div class="col-lg-10 yii2-header">
            <p><?= Yii::t('app',Html::encode($this->title)); ?><span><i class="fa fa-cog fa-spin fa-1x fa-fw"></i></p>
        </div>
    </div>

    <!-- Yii2 complementary description -->
    <div class="row">
        <div class="col-lg-10 text-info yii2-description">
            <p><?= Yii::t('app',Html::encode($description));?></p>
        </div>
    </div>

    <!-- Yii2 work area -->
    <div class="row">
        <div class="col-lg-12 text-justify yii2-content">
            <h4><?= Yii::t('app','Objetivos');?></h4>
            <br/>
            <div>
                <p>El sistema <b>CTTwapp v1.0 beta</b> [ <em>CTT Web Application</em> ] ha sido concebido por la Dirección de <b>CTT Exp. & Rentals S.A. de C.V.</b> , como un sistema que automatice procesos de administración de la empresa.</p>
                <p>Por ello, esta aplicación se ha implementado usando <b>TI's [ Tecnologías de Información ]</b> en la nube. De esta manera se pretende que la aplicación sea operable desde cualquier dispositivo y desde cualquier lugar con una conexión a Internet.</p>
                <p>En resumen los <b>objetivos generales</b> que debe cumplir esta aplicación son los siguientes :</p>
                <ul>
                    <li> <b>Automatizar procesos sensibles dentro de la empresa usando tecnologías de información actuales.</b></li>
                    <li> <b>Tener una aplicación segura y robusta que pueda ser operada en cualquier dispositivo con una conexión a Internet, y desde cualquier lugar.</b></li>
                    <li> <b>Que la aplicación cuente con una curva de vida útil prologada y extendida tal como la versión del sistema anterior.</b></li>
                </ul>

                <p>Además, la aplicación contará con las siguientes <b>características</b> :</p>
                <ul>
                    <li> <b>Registro y administración de usuarios.</b></li>
                    <li> <b>Inicio y cierre de sesión de trabajo.</b></li>
                    <li> <b>Acerca y versión del sistema.</b></li>
                    <li> <b>Ayuda del sistema.</b></li>
                    <li> <b>Contacto de soporte técnico para los usuarios.</b></li>
                    <li> <b>Administrador de clientes y funcionalidades específicas.</b></li>
                    <li> <b>Administrador de catálogos y marcas de productos.</b></li>
                    <li> <b>Administrador de artículos y funcionalidades específicas.</b></li>
                    <li> <b>Administrador de inventarios.</b></li>
                    <li> <b>Administrador de proyectos y funcionalidades específicas.</b></li>
                    <li> <b>Administrador de reservaciones de equipo.</b></li>
                    <li> <b>Administrador de cotizaciones.</b></li>
                </ul>
            </div>

            <br/>
            <br/>

            <h4><?= Yii::t('app','Selector');?></h4>

            <br/>

            <div>
                <p>Se puede acceder a las opciones del sistema usando el selector principal ubicado en la página de inicio. Un pequeño recuadro con líneas en la esquina superior derecha mostrará el selector principal al hacer clic en éste. También pueden ocultar el selector haciendo de nuevo clic en el botón antes mencionado.
                    La primera sección del selector es la siguiente y muestra la cabecera y el botón para mostrar y ocultar el mismo. Es importante mencionar que el selector aparecerá y se ocultará en el extremo derecho de la aplicación.</p>

                <br/>

                <div class="well well-lg">
                    <div class="polaroid">
                        <img src="<?=$baseUrl?>/img/ctt-sec_01.png" alt="Cabecera" class="polaroid-img">
                        <div class="polaroid-container">
                            <p>Cebecera del Selector</p>
                        </div>
                    </div>
                </div>

                <br/>

                <p>La segunda sección del selector muestra los botones <b>Registro</b> y <b>Sesión</b>. El botón <b>Registro</b> se usa para dar de alta a un nuevo usuario del sistema, del mismo modo el botón <b>Sesión</b> permite que un usuario ya registrado entre y use el sistema según los privilegios asignados.</p>

                <br/>

                <div class="well well-lg">
                    <div class="polaroid">
                        <img src="<?=$baseUrl?>/img/ctt-sec_02.png" alt="Acceso" class="polaroid-img">
                        <div class="polaroid-container">
                            <p>Sección Acceso</p>
                        </div>
                    </div>
                </div>

                <br/>

                <p>En la tercera sección del selector se agrupa a los botones <b>Acerca</b> <b>Ayuda</b>, y <b>Contacto</b>. El botón <b>Acerca</b> muestra los datos de identificación del proyecto, el botón <b>Ayuda</b> muestra este página y los tópicos generales de información del sistema. El botón <b>Contacto</b> se usa para
                    informar de algún problema o bien de alguna sugerencia. Al ingresar los datos solicitados, se enviará un correo electrónico a la direción de <code>soporte.cttwapp@gmail.com</code> y una vez recibido se realizarán las acciones pertinentes.</p>

                <br/>

                <div class="well well-lg">
                    <div class="polaroid">
                        <img src="<?=$baseUrl?>/img/ctt-sec_03.png" alt="Asistencia" class="polaroid-img">
                        <div class="polaroid-container">
                            <p>Sección Asistencia</p>
                        </div>
                    </div>
                </div>

                <br/>

                <p>Por último, en la cuarta sección del selector se muestran los botones <b>Clientes</b>, <b>Catálogos</b>, <b>Artículos</b>, <b>Inventarios</b>, <b>Proyectos</b>, <b>Reservaciones</b> y <b>Cotizaciones</b>. Estas son las operaciones disponibles a las que el usuario puede acceder con los privilegios asignados por el administrador del sistema.
                En cada operación existen una serie de funcionalidades que permitiran la administración de datos y procesos, así como la generación de reportes.<br/><br/>Al seleccionar alguna de las opciones disponibles se revisará si el usuario tiene los privilegios de acceso y en su caso le ingresará al administrador elegido.</p>
                <br/>

                <div class="well well-lg">
                    <div class="polaroid">
                        <img src="<?=$baseUrl?>/img/ctt-sec_04.png"  alt="Operaciones" class="polaroid-img">
                        <div class="polaroid-container">
                            <p>Sección Operaciones</p>
                        </div>
                    </div>
                </div>

                <br/>

            </div>

            <br/>
            <br/>

            <h4><?= Yii::t('app','Contacto');?></h4>

            <br/>

            <div>
                <p>
                   En el sistema CTTwapp v1.0 existe una opción destinada a que el usuario pueda solicitar apoyo de soporte técnico, reportar incidencias o bien tramitar algún proceso inherente al trabajo en el sistema.
                   Esta sección de la ayuda describe el proceso a través del cual un usuario puede contactar al administrador del sistema. <br/><br/>
                </p>

                <br/>

                <div class="row ctt-bagde-padding">
                    <div class="well well-sm"><img src="<?=$baseUrl?>/img/1.jpg" class="ctt-image-help-badge" align="left"><span class="text-info"><h4 style="padding-left: 60px; text-align: left">Formulario de Contacto.</h4></span></div>
                </div>

                <p>
                    <b>MUY IMPORTANTE</b> :  En este formulario todos los campos son obligatorios ( <span style="color: red;">*</span> ) pues se utilizarán para redactar y enviar un correo electrónico a la cuenta de administración del sistema : <b>soporte.cttwapp@gmail.com</b>.
                </p>

                <p>Los datos solicitados y de carácter obligatorio en un formulario de Contacto son</b> :</p>
                <ul>
                    <li> <b>Nombre.</b></li>
                    <li> <b>Correo Electrónico.</b></li>
                    <li> <b>Asunto.</b></li>
                    <li> <b>Descripción.</b></li>
                    <li> <b>Código de Verificación.</b></li>
                </ul>

                <br/><br/>

                <div class="well well-lg">
                    <div class="ctt-image-help-frame">
                        <img src="<?=$baseUrl?>/img/ctt-contact_01.jpg" class="ctt-img-help">
                        <div class="ctt-image-help-container">
                            <h5>Formulario de Contacto</b></h5>
                        </div>
                    </div>
                </div>

                <br/><br/>

                <div class="row ctt-bagde-padding">
                    <div class="well well-sm"><img src="<?=$baseUrl?>/img/2.jpg" class="ctt-image-help-badge" align="left"><span class="text-info"><h4 style="padding-left: 60px; text-align: left">LLenado del formulario de contacto.</h4></span></div>
                </div>

                <p>
                    Una vez que los datos de la solicitud de contacto se han ingresado, es <b>MUY IMPORTANTE</b> ingresar <b>CORRECTAMENTE</b> el <b>código de verificación</b>, pues es una medida de seguridad para validar el ingreso de datos por parte de un usuario real.
                </p>

                <br/><br/>

                <div class="well well-lg">
                    <div class="ctt-image-help-frame">
                        <img src="<?=$baseUrl?>/img/ctt-contact_02.jpg" class="ctt-img-help">
                        <div class="ctt-image-help-container">
                            <h5>Ejemplo de un Formulario de Contacto con datos</b></h5>
                        </div>
                    </div>
                </div>

                <br/><br/>

                <div class="row ctt-bagde-padding">
                    <div class="well well-sm"><img src="<?=$baseUrl?>/img/3.jpg" class="ctt-image-help-badge" align="left"><span class="text-info"><h4 style="padding-left: 60px; text-align: left">Recepción del formulario de contacto.</h4></span></div>
                </div>

                <p>
                    Al completar el envío del correo de contacto, en la cuenta de soporte del sistema aparecerá la solicitud para que sea procesada a la brevedad por el administrador del sistema o bien por el proveedor de soporte técnico.
                </p>

                <br/><br/>

                <div class="well well-lg">
                    <div class="ctt-image-help-frame">
                        <img src="<?=$baseUrl?>/img/ctt-contact_03.jpg" class="ctt-img-help">
                        <div class="ctt-image-help-container">
                            <h5>Mensaje de Contacto Recibido</b></h5>
                        </div>
                    </div>
                </div>

                <br/><br/>

            </div>

        </div>
    </div>

</section>

<!-- Includes the view's footer file -->
<?php include(Yii::getAlias('@app').'/views/layouts/cttwapp_views_footer.inc'); ?>