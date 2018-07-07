<?php
use yii\helpers\Html;
use yii\helpers\Url;

/* @var $this yii\web\View */

$this->title = 'Ayuda';
$description = 'Proceso de recuperación de contraseña';

$asset = \frontend\assets\AppAsset::register($this);
$baseUrl = $asset->baseUrl;

?>

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

    <!-- Login return -->
    <div class="row">
        <div class="col-lg-10 col-lg-offset-1 text-center">
            <?= Html::a(Yii::t('app','R e g r e s a r'), Url::to(['site/login']), ['class' => 'btn btn-dark btn-ctt-fixed-width', 'title' => Yii::t('app', 'Regresar al nivel anterior')]) ?>
        </div>
    </div>

    <!-- Yii2 Title layout -->
    <div class="row">
        <div class="col-lg-10 yii2-header">
            <p><?= Yii::t('app',Html::encode($this->title)); ?><span><i class="fa fa-cog fa-spin fa-1x fa-fw"></i></span></p>
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

            <!-- 2018-07-04 : Edición de la ayuda para el proceso de recuperación de contraseña -->
            <h4><?= Yii::t('app','Descripción');?></h4>

            <br/>

            <!-- Help Description-->
            <div>
                <p>En este documento se describe paso a paso el proceso de recuperación de una contraseña, para el caso en que un usuario lo haya olvidado o bien lo desee cambiar. En la siguiente ilustración se muestra la pantalla de control de acceso al sistema <b>CTTwapp v1.0</b>.<br/>
                   En la ilustración se puede observar un formulario de captura para ingresar el <b>Usuario</b> y la <b>Contraseña</b>. También se aprecia un texto informativo y una <b>liga para iniciar el proceso de restablecimiento</b> de una contraseña.<br/>
                   Esta página por lo regular se utiliza como acceso principal al sistema, pero también sirve para iniciar el proceso de recuperación de contraseña, mismo que se detalla a continuación.
                </p>
            </div>

            <br/><br/>

            <!-- Help Map-->
            <div class="well well-lg">
                <div class="ctt-image-help-frame">
                    <img src="<?=$baseUrl?>/img/ctt-recover-pswd_01.jpg" class="ctt-image-help-frame" style="width:100%">
                    <div class="ctt-image-help-container">
                        <h5>Control de Acceso</h5>
                    </div>
                </div>
            </div>

            <br/><br/><h4><?= Yii::t('app','Proceso');?></h4><br/>

            <!--Help Content -->
            <div>

                <!--  Badge 1  ||||||||||||||||||||||||||||||||||||||||||||||||||| -->
                <div class="row">
                    <div class="well well-sm"><img src="<?=$baseUrl?>/img/1.jpg" class="ctt-image-help-badge" align="left"><span class="text-info"><h4 style="padding-left: 60px; text-align: left">Paso : Inicar el proceso de recuperación de contraseña.</h4></span></div>
                </div>

                <p>Para iniciar el proceso de recuperación de contraseña, haga clic en la liga que se encuentra al final del texto : <b>Para restablecer su contraseña en caso de olvido</b>.<br/>Este texto informativo y la liga, se encuentran por encima del boton <b>Ingresar</b>.</p>

                <br/><br/>

                <!--  Badge 2  ||||||||||||||||||||||||||||||||||||||||||||||||||| -->
                <div class="row">
                    <div class="well well-sm"><img src="<?=$baseUrl?>/img/2.jpg" class="ctt-image-help-badge" align="left"><span class="text-info"><h4 style="padding-left: 60px; text-align: left">Paso : Ingreso del correo electrónico.</h4></span></div>
                </div>

                <p>En la página que se muestra el usuario <b>DEBERÁ</b> ingresar el correo electrónico <b>CON EL QUE FUE REGISTRADO</b> en el sistema <b>CTTwapp v1.0</b>. Una vez hecho esto se debe presionar el botón <b>Enviar</b>.</p>

                <br/>

                <blockquote class="ctt-blockquote"><b>MUY IMPORTANTE</b> : Ningún otro correo electrónico, diferente al registrado en el sistema será válido para este proceso.</blockquote>
                <br/>

                <div class="well well-lg">
                    <div class="ctt-image-help-mini-frame">
                        <img src="<?=$baseUrl?>/img/ctt-recover-pswd_02.jpg" class="ctt-image-help-frame" style="width:100%">
                        <div class="ctt-image-help-container">
                            <h5>Ingreso del correo electrónico registrado en el sistema CTTwapp v1.0 para el usuario</h5>
                        </div>
                    </div>
                </div>

                <br/><br/>

                <!--  Badge 3  ||||||||||||||||||||||||||||||||||||||||||||||||||| -->
                <div class="row">
                    <div class="well well-sm"><img src="<?=$baseUrl?>/img/3.jpg" class="ctt-image-help-badge" align="left"><span class="text-info"><h4 style="padding-left: 60px; text-align: left">Paso : Confirmación</h4></span></div>
                </div>

                <p>
                   Si en el paso anterior se ingresó una dirección de correo que se encuentra registrada y relacionada con el usuario que intenta recuperar su contraseña, entonces se emitirá un mensaje con breves instrucciones a seguir.
                   De lo contrario se emitirá el mensaje de error correspondiente.
                </p>
                <br/>

                <div class="well well-lg">
                    <div class="ctt-image-help-mini-frame">
                        <img src="<?=$baseUrl?>/img/ctt-recover-pswd_03.jpg" class="ctt-image-help-frame" style="width:100%">
                        <div class="ctt-image-help-container">
                            <h5>Mensaje con instrucciones para el usuario.</h5>
                        </div>
                    </div>
                </div>

                <br/><br/>

                <!--  Badge 4  ||||||||||||||||||||||||||||||||||||||||||||||||||| -->
                <div class="row">
                    <div class="well well-sm"><img src="<?=$baseUrl?>/img/4.jpg" class="ctt-image-help-badge" align="left"><span class="text-info"><h4 style="padding-left: 60px; text-align: left">Paso : Verificación de identidad.</h4></span></div>
                </div>

                <p>El usuario <b>DEBERÁ</b> abrir su cuenta de correo y revisar la existencia de un mensaje enviado automáticamente por el sistema <b>CTTwapp v1.0</b>. Dicho correo contendrá una liga para la <b>confirmación de la identidad del usuario</b>, misma que al hacer clic en esta, el usuario dará por confirmado su deseo expreso de recuperar o cambiar su contraseña.</p>

                <br/>

                <div class="well well-lg">
                    <div class="ctt-image-help-mini-frame" style="width:50%">
                        <img src="<?=$baseUrl?>/img/ctt-recover-pswd_04.jpg" class="ctt-image-help-frame" style="width:80%">
                        <div class="ctt-image-help-container">
                            <h5>Liga para confirmación de la identidad del usuario.</h5>
                        </div>
                    </div>
                </div>

                <br/>

                <blockquote class="ctt-blockquote">
                    <b>MUY IMPORTANTE</b> : Si la liga para restablecer la contraseña se usa en más de una ocasión, se generará un error como el que se muestra a continuación debido a que tal liga tiene una caducidad que forma
                       parte de la propia seguridad del sistema.
                </blockquote>

                <br/>

                <div class="well well-lg">
                    <div class="ctt-image-help-mini-frame">
                        <img src="<?=$baseUrl?>/img/ctt-recover-pswd_07.jpg" class="ctt-image-help-frame" style="width:100%">
                        <div class="ctt-image-help-container">
                            <h5>Liga para confirmación de la identidad en estado de caducidad.</h5>
                        </div>
                    </div>
                </div>

                <br/><br/>

                <!--  Badge 5  ||||||||||||||||||||||||||||||||||||||||||||||||||| -->
                <div class="row">
                    <div class="well well-sm"><img src="<?=$baseUrl?>/img/5.jpg" class="ctt-image-help-badge" align="left"><span class="text-info"><h4 style="padding-left: 60px; text-align: left">Paso : Restablecimiento de la contraseña</h4></span></div>
                </div>

                <p>Una vez que el usuario haga clic en la liga del correo que recibió, se redireccionará hacia una página en la cuál podrá <b>INGRESAR SU NUEVA CONTRASEÑA</b>.</p>

                <br/>

                <blockquote class="ctt-blockquote"><b>IMPORTANTE</b> : El usuario <b>DEBE RECORDAR</b> su nueva contraseña, pues será su nueva clave de acceso en su próximo ingreso al sistema.</blockquote>
                <br/>

                <div class="well well-lg">
                    <div class="ctt-image-help-mini-frame">
                        <img src="<?=$baseUrl?>/img/ctt-recover-pswd_05.jpg" class="ctt-image-help-frame" style="width:100%">
                        <div class="ctt-image-help-container">
                            <h5>Registro de la nueva contraseña del usuario.</h5>
                        </div>
                    </div>
                </div>

                <br/><br/>

                <!--  Badge 6  ||||||||||||||||||||||||||||||||||||||||||||||||||| -->
                <div class="row">
                    <div class="well well-sm"><img src="<?=$baseUrl?>/img/6.jpg" class="ctt-image-help-badge" align="left"><span class="text-info"><h4 style="padding-left: 60px; text-align: left">Paso : Ingreso del usuario al sistema con su nueva contraseña.</h4></span></div>
                </div>

                <p>
                   Después de ingresar su nueva contraseña y si no se presentan problemas, <b>SE NOTIFICARÁ AL USUARIO</b> de que su contraseña fue generada y almacenada correctamente. <br/>
                   En esta misma ventana el usuario podrá ingresar sus datos para probar su ingreso al sistema.
                </p>

                <br/>

                <div class="well well-lg">
                    <div class="ctt-image-help-mini-frame">
                        <img src="<?=$baseUrl?>/img/ctt-recover-pswd_06.jpg" class="ctt-image-help-frame" style="width:100%">
                        <div class="ctt-image-help-container">
                            <h5>Confirmación de generación y registro exitoso de la nueva contraseña del usuario.</h5>
                        </div>
                    </div>
                </div>

                <br/><br/>

                <!--  Badge 7  ||||||||||||||||||||||||||||||||||||||||||||||||||| -->
                <div class="row">
                    <div class="well well-sm"><img src="<?=$baseUrl?>/img/7.jpg" class="ctt-image-help-badge" align="left"><span class="text-info"><h4 style="padding-left: 60px; text-align: left">PASO : Ingreso al sistema.</h4></span></div>
                </div>

                <p>
                   Una vez ingresado el valor del usuario y de la nueva contraseña generada, el sistema recuperará el perfil que aplicará al usuario a fin de activar las opciones que el administrador del sistema le haya designado.<br/>
                   Una ventana de autentificación le dará la bienvenida y en el menú principal, el usuario podrá consultar las opciones que su perfil le otorga.
                </p>

                <br/>

                <div class="well well-lg">
                    <div class="ctt-image-help-mini-frame">
                        <img src="<?=$baseUrl?>/img/ctt-recover-pswd_08.jpg" class="ctt-image-help-frame" style="width:100%">
                        <div class="ctt-image-help-container">
                            <h5>Ingreso al sistema con la nueva contraseña restablecida.</h5>
                        </div>
                    </div>

                    <br/><br/>

                    <div class="ctt-image-help-mini-frame">
                        <img src="<?=$baseUrl?>/img/ctt-recover-pswd_09.jpg" class="ctt-image-help-frame" style="width:100%">
                        <div class="ctt-image-help-container">
                            <h5>Opciones propias del perfil del usuario.</h5>
                        </div>
                    </div>
                </div>

                <br/><br/>

                <!--  Badge 8  ||||||||||||||||||||||||||||||||||||||||||||||||||| -->
                <div class="row">
                    <div class="well well-sm"><img src="<?=$baseUrl?>/img/8.jpg" class="ctt-image-help-badge" align="left"><span class="text-info"><h4 style="padding-left: 60px; text-align: left">Soporte.</h4></span></div>
                </div>

                <p>
                   Las operaciones de restablecimiento de contraseñas o bien registro de contactos para reportar incidencias o preguntas, el sistema <b>CTTwapp v1.0</b> las realiza mediante una cuenta
                   de correo electrónico especializada y manejada por un administrador. La dirección para cualquier situación relacionada con el sistema es : <b>soporte.cttwapp@gmail.com</b>
                </p>

                <br/>

                <div class="well well-lg">
                    <div class="ctt-image-help-mini-frame">
                        <img src="<?=$baseUrl?>/img/ctt-recover-pswd_10.jpg" class="ctt-image-help-frame" style="width:100%">
                        <div class="ctt-image-help-container">
                            <h5>Cuenta de correo de soporte del sistema : <b>soporte.cttwapp@gmail.com</b></h5>
                        </div>
                    </div>
                </div>

                <br/><br/><br/>

            </div>
        </div>
    </div>

</section>

<!-- Includes the view's footer file -->
<?php include(Yii::getAlias('@app').'/views/layouts/cttwapp_views_footer.inc'); ?>