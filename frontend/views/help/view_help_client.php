<?php
use yii\helpers\Html;
use yii\helpers\Url;

/* @var $this yii\web\View */

$this->title = 'Ayuda';
$description = 'Módulo Administrador de Clientes';

$asset = \frontend\assets\AppAsset::register($this);
$baseUrl = $asset->baseUrl;

// 2018-06-07 : Stores a return url parameter.
$ret_url_param = Yii::$app->getRequest()->getQueryParam('ret_url');
// 2018-06-07 : Stores a return hash parameter.
$ret_hash_param = Yii::$app->getRequest()->getQueryParam('ret_hash');
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

    <!-- Main menu return -->
    <div class="row">
        <div class="col-lg-10 col-lg-offset-1 text-center">
            <?= Html::a(Yii::t('app','R e g r e s a r'), Url::to([$ret_url_param]).'&hash='.$ret_hash_param, ['class' => 'btn btn-dark btn-ctt-fixed-width', 'title' => Yii::t('app', 'Regresar al nivel anterior')]) ?>
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

            <!-- 2018-06-25 : Edición de la ayuda para el Módulo de Clientes -->
            <h4><?= Yii::t('app','Descripción');?></h4>

            <br/>

            <!-- Help Description-->
            <div><p>Este módulo permite al usuario autorizado administrar todo lo relacionado a los clientes que el sistema <b>CTTwapp v1.0</b> administrará para los procesos de la empresa.
                    A continuacción se describen las funcionalidades disponible en este módulo y en la siguiente ilustración se indican los puntos importantes que serán detallados
                    conforme a la numeración.</p></div><br/><br/>

            <!-- Help Map-->
            <div align="center">
                <div class="ctt-image-help">
                    <img src="<?=$baseUrl?>/img/ctt-help-mod-client.jpg" class="ctt-image-help" style="width:100%">
                    <div class="container-ctt-image-help">
                        <h4>Módulo Clientes</h4>
                    </div>
                </div>
            </div>

            <br/><br/><h4><?= Yii::t('app','Funcionalidades');?></h4><br/>

            <!--Help Content -->
            <div>

                <!--  Badge 1  ||||||||||||||||||||||||||||||||||||||||||||||||||| -->
                <div class="row">
                    <div class="well well-sm"><img src="<?=$baseUrl?>/img/1.jpg" class="ctt-image-help-badge" align="left"><span class="text-info"><h4  style="padding-left: 60px; text-align: left">Área : Encabezado de Imagen Corporativa.</h4></span></div>
                </div>

                <p>En esta área se presenta el logotipo de <b>CTT Exp & Rentals</b>, asi como una imagen que cambiará de forma aleatoria y automática, mostrando diferentes posters relacionados al ámbito de trabajo de la empresa.</p>
                <p>Debajo de esta área se muestra una banda separadora color azul que divide ésta con el área designada para trabajar en el módulo de Clientes.</p>
                <br/>

                <!--  Badge 2  ||||||||||||||||||||||||||||||||||||||||||||||||||| -->
                <div class="row">
                    <div class="well well-sm"><img src="<?=$baseUrl?>/img/2.jpg" class="ctt-image-help-badge" align="left"><span class="text-info"><h4  style="padding-left: 60px; text-align: left">Área : Barra de Navegación</h4></span></div>
                </div>

                <p>La barra de navegación se puede mostrar y ocultar al presionar el botón ubicado en el extremo superior derecho del módulo Clientes. Esta barra mostrará <b>SOLO</b> las opciones a las que tiene acceso el usuario autentificado en base a su perfil de seguridad.</p>
                <p>La barra de navegación también contiene el botón de cierre de sesión ( <em>logout</em> ) y el nombre del usuario que actualmente está autentificado. Es importante que un usuario, al terminar de trabajar en el sistema, cierre su sesión de trabajo
                   pues de esta manera aumentará la seguridad del mismo y de los procesos de la empresa.</p>

                <blockquote class="ctt-blockquote"><b>MUY IMPORTANTE</b> : En cualquier momento el usuario puede acercar el cursor del mouse a cualquier botón y al mantenerlo por un par de segundos se mostrará un mensaje o '<em>tooltip</em>' que dará una breve explicación acerca del uso de dicho botón.</blockquote>
                <p>Por último, es importante mencionar que el <b>botón fijo de flecha arriba</b> que se haya en el <u>extremo inferior derecho</u>, se usa para desplazarse al tope del área de trabajo. El uso de este botón resulta muy útil para visualizar rápidamente el área de datos.</p>
                <br/>

                <!--  Badge 3  ||||||||||||||||||||||||||||||||||||||||||||||||||| -->
                <div class="row">
                    <div class="well well-sm"><img src="<?=$baseUrl?>/img/3.jpg" class="ctt-image-help-badge" align="left"><span class="text-info"><h4  style="padding-left: 60px; text-align: left">Área : Cierre de Sesión</h4></span></div>
                </div>

                <p>Esta área se muestra en un color naranja para resaltar al usuario el botón para cerrar su sesión de trabajo. También muestra el usuario que actualmente está autentificado.</p>
                <p>Cada usuario tiene un perfil de acceso, a través del cual se le pernitirá el ingreso a ciertas áreas del sistema según sus funciones. Por lo tanto cabe mencionar que las opciones disponibles
                   en la barra de navegación, son <b>DINÁMICAS</b> pues cambian según el usuario autentificado y sus privilegios.</p>
                <br/>

                <!--  Badge 4  ||||||||||||||||||||||||||||||||||||||||||||||||||| -->
                <div class="row">
                    <div class="well well-sm"><img src="<?=$baseUrl?>/img/4.jpg" class="ctt-image-help-badge" align="left"><span class="text-info"><h4  style="padding-left: 60px; text-align: left">Área : Opciones Disponibles</h4></span></div>
                </div>

                <p>En esta área se muestra las opciones a las que puede tener acceso el usuario que está actualmente autentificado.</p>
                <p>Cuando se crea un usuario, también se le otorgan sus privilegios de acceso en lo que se denomina su <b>PERFIL DE ACCESO</b>. Este perfil está en función de los privilegios que otorgue la gerencia responsable.</p>
                <br/>

                <!--  Badge 5  ||||||||||||||||||||||||||||||||||||||||||||||||||| -->
                <div class="row">
                    <div class="well well-sm"><img src="<?=$baseUrl?>/img/5.jpg" class="ctt-image-help-badge" align="left"><span class="text-info"><h4  style="padding-left: 60px; text-align: left">Área : Botón de Regreso</h4></span></div>
                </div>

                <p>Este botón le permite al usuario regresar al nivel superior anterior en la jerarquía de navegación del sistema. Por ejemplo, si el usuario se encuentra en el módulo de Clientes, entonces presionar este botón lo llevará
                   a la página anfitrión del sistema.</p>
                <blockquote class="ctt-blockquote"><b>IMPORTANTE</b> : Este botón se encuentra en cada módulo que integra al sistema, y forma parte escencial del esquema de navegación del mismo.</blockquote>
                <br/>

                <!--  Badge 6  ||||||||||||||||||||||||||||||||||||||||||||||||||| -->
                <div class="row">
                    <div class="well well-sm"><img src="<?=$baseUrl?>/img/6.jpg" class="ctt-image-help-badge" align="left"><span class="text-info"><h4  style="padding-left: 60px; text-align: left">Área : Identificación, Operaciones y Sub-módulos.</h4></span></div>
                </div>

                <p>Esta área muestra la <b>identificación del módulo</b> ( <u>tamaño de letra 2.5 em / color gris obscuro</u> ) y de bajo de ésta una breve <b>descripción</b> que la acompaña ( <u>tamaño de letra 1.5 em / color azul</u> ). <br/><br/>
                   De igual modo en esta área se mostrarán los mensajes al usuario, siendo éstos de tres categorias diferentes : <span style="color:green"><b>Éxito</b></span>, <span style="color:orange"><b>Advertencia</b></span>
                   y <span style="color:red"><b>Error</b></span>.</p>
                <blockquote class="ctt-blockquote"><b>IMPORTANTE</b> : Cuando aparezca un mensaje dirigido al usuario, éste <b>se mantendrá por 25 segundos aproximadamente</b>, para después cerrarse automáticamente y recorrer todos los controles por debajo del mensaje hacia arriba.</blockquote>
                <p>Las <b>operaciones</b> y los <b>sub-módulos</b> estan representados por botones que al hacer clic en ellos iniciaran un proceso, o bien llevarán al usuario a otro módulo subordinado. Por ejemplo, para este módulo existe el
                   botón <b>Crear Cliente</b> el cual al presionarlo enviará al usuario a la pantalla de captura para dar de alta a un nuevo registro de cliente. De igual modo, el botón <b>Tipos de Clientes</b> le dará ingreso al usuario autentificado                    con acceso al sub-módulo, para ingresar los tipos de clientes administrados por el sistema.</p>
                <br/>

                <!--  Badge 7  ||||||||||||||||||||||||||||||||||||||||||||||||||| -->
                <div class="row">
                    <div class="well well-sm"><img src="<?=$baseUrl?>/img/7.jpg" class="ctt-image-help-badge" align="left"><span class="text-info"><h4  style="padding-left: 60px; text-align: left">Área : Datos Almacenados.</h4></span></div>
                </div>

                <p>Esta área muestra los <b>datos almacenados</b> en la base de datos de la entidad Clientes. Cada renglón o túpla representa a un cliente almacenado en el sistema. <br/><br/>
                   Por otro lado, cada renglón a su vez se divide en columnas y cada intersección <b>renglón-columna</b> corresponde a un atributo particular de un cliente.</p>
                <blockquote class="ctt-blockquote">
                <b>IMPORTANTE</b> : Esta área muestra grupos de <b>10 registros</b> a la vez, lo que facilita la revisión y búsqueda de datos particulares de un cliente. Cada grupo representa una página de información y se puede recorrer toda la información de los
                   clientes usando el <b>Control Paginador</b> que más adelante se describirá.</blockquote>

                <p>El usuario se puede desplazar entre las columnas sin perderlas de vista, usando la barra de desplazamiento horizontal. Cada columna mostrará el nombre de la misma y el usuario podrá hacer clic sobre el nombre y con ello <b>ORDENARÁ</b>
                   automáticamente la información en base al valor de dicha columna. Una flecha hacia arriba, o bien una flecha hacia abajo con las letras iniciales del alfabeto ( <b>a-z</b> / <b>z-a</b> ) denotarán el <b>orden ascendente</b> o <b>descendente respectivamente</b>.</p>
            
                <p>Otra funcionalidad muy importante, son los <b>CAMPOS DE FILTRADO</b> que aparecen justo debajo de los nombres de las columnas. Su finalidad es brindar al usuario un mecanismo a través del cual pueda <b>buscar y filtrar</b> datos de su interés.
                   Por ejemplo, si en el campo de filtrado el usuario escribe la palabra <b>ESTUDIOS</b>, el sistema mostrará y paginará únicamente los datos que coincidan con dicho criterio de filtrado.</p>
                
                <p>Para volver a mostrar y paginar <b>TODOS</b> los registros, se deberá suprimir la o las palabras del campo de filtrado para que dicho criterio deje de aplicarse a la vista de datos almacenados.</p>

                <p>Acompañando al control de paginado, está la etiqueta de <b>ELEMENTOS MOSTRADOS</b>. En esta se indica el gurpo actual de páginas que se despliegan. Por ejemplo, el valor de la etiqueta <b>Mostrado 1-10 de 12 elementos</b> indica los registros desplegados actualmente,
                   así como el total de registros por mostrar. </p>
                <p>Por último, esta área presenta un par de columnas de operación. La columna de <b>Acciones</b> y la columna de <b>Número Consecutivo</b> que se indica con un <b>símbolo #</b> ( <em>hash</em> ). La columna de Acciones se explicará más adelante a detalle.</p>
                <br/>

                <!--  Badge 8  ||||||||||||||||||||||||||||||||||||||||||||||||||| -->
                <div class="row">
                    <div class="well well-sm"><img src="<?=$baseUrl?>/img/8.jpg" class="ctt-image-help-badge" align="left"><span class="text-info"><h4  style="padding-left: 60px; text-align: left">Área : Acciones.</h4></span></div>
                </div>

                <p>En esta área se muestran tres diferentes iconos que visualmente representan las acciones de <b>consultar</b> un cliente ( <em>ojo</em> ), <b>modificar</b> un cliente ( <em>lápiz</em> ) y de <b>eliminar</b> un cliente ( <em>bote de basura</em> ).<br/><br/>
                   Para cada una de las acciones disponibles, incluyendo <b>crear un nuevo cliente</b>, el usuario debe contar con el permiso correspondiente en su perfil de acceso, o de lo contrario el sistema emitirá un mensaje de advertencia por intentar acceder a una acción <b>NO permitida</b>.</p>
                <p>

                <p><b>Acción Consultar</b>. Tener acceso a esta acción llevará al usuario a consultar los datos del cliente seleccionado en otra área especialmente diseñada para tal efecto.</p>
                <p><b>Acción Modificar</b>. Tener acceso a esta acción llevará al usuario a modificar los datos del cliente seleccionado en un formulario de captura de datos especialmente diseñado. Ahí el usuario podrá modificar o bien descartar las modificaciones hechas.</p>
                <p><b>Acción Eliminar</b>.  Al pasar el cursor sobre este icono ( <em>bote de basura</em> ), cambiará su color a <span style="color: red">ROJO</span>, para señalar que se trata de una <b>acción sensible</b>. Tener acceso a esta acción llevará al usuario a contestar una
                      pregunta de confirmación para suprimir los datos del cliente seleccionado. De ser afirmativa la respuesta, el registro en cuestión se eliminará de la base de datos y aparecerá un mensaje de aviso en el área descrita en el punto 6 anterior.</p>
                <p> En todo momento el usuario puede acercar el cursor del mouse y dejarlo un par de segundos para solicitar el '<em>tooltip</em>' que muestra una breve descripción de la acción.</p>
                <br/>

                <!--  Badge 9  ||||||||||||||||||||||||||||||||||||||||||||||||||| -->
                <div class="row">
                    <div class="well well-sm"><img src="<?=$baseUrl?>/img/9.jpg" class="ctt-image-help-badge" align="left"><span class="text-info"><h4  style="padding-left: 60px; text-align: left">Área : Control Paginador.</h4></span></div>
                </div>

                <p>En esta área se encuentra el <b>Control Paginador</b> que permite al usuario navegar entre las diferentes páginas de losn clientes almacenados en la base de datos del sistema. El usuario puede avanzar y retroceder entre las páginas del mismo modo que puede ir a la página final o
                   inicial de clientes.</p>
                <br/>

                <!--  Badge 10  ||||||||||||||||||||||||||||||||||||||||||||||||||| -->
                <div class="row">
                    <div class="well well-sm"><img src="<?=$baseUrl?>/img/10.jpg" class="ctt-image-help-badge" align="left"><span class="text-info"><h4  style="padding-left: 60px; text-align: left">Área : Panel de Herramientas.</h4></span></div>
                </div>

                <p>Esta área se diseñó para mantener y organizar herramientas útiles para el módulo de Clientes. Por omisión y para ahorar espacio visual, este panel siempre esta cerrado y se abre presionando el botón Herramientas. Una pequeña animación que rota le indica al usuario que puede abrir o
                   cerrar el panel.
                </p>
                <p>
                   Por ejemplo, este panel contiene la herramienta para <b>colorear registros</b>, y al hacer un clic sobre la '<em>gota de tinta</em>' inmediatamente los registros de clientes se marcarán en un color específico de acuerdo al <b>tipo de cliente</b> de que se trate.<br/>
                   Realizando nuevamente la operación, los colores se desactivan.
                </p>
                <p>
                   Otro ejemplo de herramienta, es el <b>icono de interrogación</b> que abre esta ayuda y que una vez concluida la consulta, al presionar el botón de <b>Regreso</b> el usuario volverá al módulo de Clientes.
                </p>
                <br/>

                <!--  Badge 10  ||||||||||||||||||||||||||||||||||||||||||||||||||| -->
                <div class="row">
                    <div class="well well-sm"><img src="<?=$baseUrl?>/img/11.jpg" class="ctt-image-help-badge" align="left"><span class="text-info"><h4  style="padding-left: 60px; text-align: left">Área : Pie de Imagen Informativa.</h4></span></div>
                </div>

                <p>En esta área se presentan los derechos y créditos formales sobre el uso del software libre ( <em>Open Source</em> ) empleado en le desarrollo de este proyecto.</p>
                <br/>

            </div>
        </div>
    </div>

</section>

<!-- Includes the view's footer file -->
<?php include(Yii::getAlias('@app').'/views/layouts/cttwapp_views_footer.inc'); ?>