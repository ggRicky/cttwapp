<?php
use yii\helpers\Html;
/* @var $this yii\web\View */
$this->title = 'Ayuda';
$asset = \frontend\assets\AppAsset::register($this);
$baseUrl = $asset->baseUrl;
//2018-04-26 : Used to get a random int, and display a random parallax.
$randomBg = rand(1,13);
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
            <?= Html::a(Yii::t('app','R e g r e s a r'), ['site/index'], ['class' => 'btn btn-dark']) ?>
        </div>
    </div>

    <!-- Yii2 Title layout -->
    <div class="row">
        <div class="col-lg-10 yii2-header">
            <p><?= Yii::t('app',Html::encode($this->title)); ?></p>
        </div>
    </div>

    <!-- Yii2 complementary description -->
    <div class="row">
        <div class="col-lg-10 text-info yii2-description">
            <p><?= Yii::t('app','Tópicos Generales');?></p>
        </div>
    </div>

    <!-- Yii2 work area -->
    <div class="row">
        <div class="col-lg-12 text-justify yii2-content">
            <h4><?= Yii::t('app','Objetivos');?></h4>
            <br/>
            <div>
                El sistema <b>CTTWapp v1.0 beta</b> [ <em>CTT Web Application</em> ] ha sido concebido por la Dirección de <b>CTT Exp. & Rentals S.A. de C.V.</b> , como un sistema que automatice procesos de administración de la empresa. Por ello, esta aplicación se ha implementado usando <b>TI [ Tecnologías de Información ]</b> en la nube.
                <br/>
                De esta manera se pretende que la aplicación sea operable desde cualquier dispositivo y desde
                cualquier lugar.
                <br/>
                <br/>
                Los <b>objetivos generales</b> que debe cumplir esta aplicación son los siguientes :<br/><br/>
                <ul>
                    <li> <b>Automatizar procesos sensibles dentro de la empresa usando tecnologías de información actuales.</b></li>
                    <li> <b>Tener una aplicación segura y robusta que pueda ser operada en cualquier dispositivo con una conexión a Internet, y desde cualquier lugar.</b></li>
                    <li> <b>Que la aplicación cuente con una curva de vida útil prologada y extendida tal como la versión del sistema anterior.</b></li>
                </ul>
                <br/>
                Además, la aplicación contará con las siguientes <b>características</b> :
                <br/>
                <br/>
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
                Se puede acceder a las opciones del sistema usando el selector principal ubicado en la página de inicio. Un pequeño recuadro con líneas en la esquina superior derecha mostrará el selector principal al hacer clic en éste. También pueden ocultar el selector haciendo de nuevo clic en el botón antes mencionado.
                La primera sección del selector es la siguiente y muestra la cabecera y el botón para mostrar y ocultar el mismo. Es importante mencionar que el selector aparecerá y se ocultará en el extremo derecho de la aplicación.

                <br/>
                <br/>
                <br/>

                <div class="well well-lg">
                    <div class="polaroid">
                        <img src="<?=$baseUrl?>/img/ctt-sec_01.png"  alt="Cabecera" style="width:100%">
                        <div class="container-polaroid">
                            <p>Cebecera del Selector</p>
                        </div>
                    </div>
                </div>

                <br/>

                La segunda sección del selector muestra los botones <b>Registro</b> y <b>Sesión</b>. El botón <b>Registro</b> se usa para dar de alta a un nuevo usuario del sistema, del mismo modo el botón <b>Sesión</b> permite que un usuario ya registrado entre y use el sistema según los privilegios asignados.<br/><br/>

                <br/>

                <div class="well well-lg">
                    <div class="polaroid">
                        <img src="<?=$baseUrl?>/img/ctt-sec_02.png"  alt="Acceso" style="width:100%">
                        <div class="container-polaroid">
                            <p>Sección Acceso</p>
                        </div>
                    </div>
                </div>

                <br/>

                En la tercera sección del selector se agrupa a los botones <b>Acerca</b> <b>Ayuda</b>, y <b>Contacto</b>. El botón <b>Acerca</b> muestra los datos de identificación del proyecto, el botón <b>Ayuda</b> muestra este página y los tópicos generales de información del sistema. El botón <b>Contacto</b> se usa para
                informar de algún problema o bien de alguna sugerencia. Al ingresar los datos solicitados, se enviará un correo electrónico a la direción de <code>soporte.ctt@gmail.com</code> y una vez recibido se realizarán las acciones pertinentes.
                <br/>
                <br/>
                <br/>

                <div class="well well-lg">
                    <div class="polaroid">
                        <img src="<?=$baseUrl?>/img/ctt-sec_03.png"  alt="Asistencia" style="width:100%">
                        <div class="container-polaroid">
                            <p>Sección Asistencia</p>
                        </div>
                    </div>
                </div>

                <br/>

                Por último, en la cuarta sección del selector se muestran los botones <b>Clientes</b>, <b>Catálogos</b>, <b>Artículos</b>, <b>Inventarios</b>, <b>Proyectos</b>, <b>Reservaciones</b> y <b>Cotizaciones</b>. Estas son las operaciones disponibles a las que el usuario puede acceder con los privilegios asignados por el administrador del sistema.
                En cada operación existen una serie de funcionalidades que permitiran la administración de datos y procesos, así como la generación de reportes.<br/><br/>
                Al seleccionar alguna de las opciones disponibles se revisará si el usuario tiene los privilegios de acceso y en su caso le ingresará al administrador elegido.
                <br/>
                <br/>
                <br/>

                <div class="well well-lg">
                    <div class="polaroid">
                        <img src="<?=$baseUrl?>/img/ctt-sec_04.png"  alt="Operaciones" style="width:100%">
                        <div class="container-polaroid">
                            <p>Sección Operaciones</p>
                        </div>
                    </div>
                </div>

                <br/>

            </div>
        </div>
    </div>

</section>

<section>
    <!-- A button for go to the page's top -->
    <div class="col-lg-10 col-lg-offset-1 text-center up-btn-area">
        <div class="tooltip-conf">
            <span class="tooltip-text"><?=Yii::t('app', 'Ir al inicio');?></span>
            <a href="#work-area-index">
                <span class="glyphicon glyphicon-circle-arrow-up"></span>
            </a>
        </div>
    </div>
</section>

<!-- Footer -->
<footer>
    <div class="container">
        <div class="row">
            <div class="col-lg-10 col-lg-offset-1 text-center">
                <!-- CTT mini logo -->
                <div class="col-lg-12">
                    <img src="<?=$baseUrl?>/img/ctt-mini-logo_1.jpg" class="center-block img-responsive" height="42" width="105"/>
                </div>

                <!-- Credits layer -->
                <div class="row">
                    <div class="col-lg-10 col-lg-offset-1 text-center tsr-content">
                        <hr class="small">
                        <p class="text-muted">Copyright &copy; 2017-<?= date("Y"); ?><br/>T S R&nbsp;&nbsp;&nbsp;&nbsp;D e v e l o p m e n t&nbsp;&nbsp;&nbsp;&nbsp;S o f t w a r e</p>
                        <hr class="small">
                        <p class="text-muted">Supported by</p>
                        <p>
                            <a href="https://www.yiiframework.com/"><img src="<?=$baseUrl?>/img/yii_logo_light.svg" height="30"/></a>
                            <span>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</span>
                            <a href="https://www.jetbrains.com/"><img src="<?=$baseUrl?>/img/jetbrains.svg" height="40"/></a>
                        </p>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Blue ribbon footer decoration -->
    <section class="ctt-section-footer ctt-footer-container">
        <div class="col-lg-12">
            <div class="row "></div>
        </div>
    </section>
</footer>