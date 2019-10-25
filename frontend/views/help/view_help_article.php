<?php
use yii\helpers\Html;
use yii\helpers\Url;

/* @var $this yii\web\View */

$this->title = 'Ayuda';
$description = 'Módulo Administrador de Productos y Servicios';

$asset = \frontend\assets\AppAsset::register($this);
$baseUrl = $asset->baseUrl;

// 2018-06-07 : Stores a return url parameter.
$ret_url_param = Yii::$app->getRequest()->getQueryParam('ret_url');
// 2018-06-07 : Stores a return hash parameter.
$ret_hash_param = Yii::$app->getRequest()->getQueryParam('ret_hash');

// 2018-04-26 : Used to get a random int, and display a random parallax.
$randomBg = rand(1,11);;

?>

<!-- Blue ribbon decoration -->
<section class="ctt-section bg-primary">
    <div class="col-lg-12">
        <div id="work-area-index" class="row">
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
            <?= Html::a(Yii::t('app','R e g r e s a r'), Url::to([$ret_url_param]).'&hash='.$ret_hash_param, ['class' => 'btn btn-dark btn-ctt-fixed-width', 'data-toggle' => 'tooltip', 'title' => Yii::t('app', 'Regresar al nivel anterior')]) ?>
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

            <!-- 2019-10-21 : Edición de la ayuda para el Módulo de Artículos -->
            <h4><?= Yii::t('app','Descripción');?></h4>

            <br/>

            <!-- Help Description-->
            <div><p>Este módulo permite al usuario autorizado administrar todo lo relacionado a los productos y servicios que el sistema <b>CTTwapp v1.0</b> administrará para los procesos de la empresa.
                    A continuacción se describen las funcionalidades disponible en este módulo y en la siguiente ilustración se indican los puntos importantes que serán detallados
                    conforme a la numeración.</p></div><br/><br/>

            <!-- Help Map-->
            <div class="well well-lg">
                <div class="ctt-image-help-frame">
                    <img src="<?=$baseUrl?>/img/ctt-help-mod-article.jpg" class="ctt-image-help-frame" style="width:100%">
                    <div class="ctt-image-help-container">
                        <h5>Módulo Productos y Servicios</h5>
                    </div>
                </div>
            </div>

            <br/><br/><h4><?= Yii::t('app','Funcionalidades');?></h4><br/>

            <!--Help Content -->
            <div>

                <!--  Badge 1  ||||||||||||||||||||||||||||||||||||||||||||||||||| -->
                <div class="row ctt-bagde-padding">
                    <div class="well well-sm"><img src="<?=$baseUrl?>/img/1.jpg" class="ctt-image-help-badge" align="left"><span class="text-info"><h4  style="padding-left: 60px; text-align: left">Área : Encabezado de Imagen Corporativa.</h4></span></div>
                </div>

                <p>En esta área se presenta el logotipo de <b>CTT Exp & Rentals</b>, asi como una imagen que cambiará de forma aleatoria y automática, mostrando diferentes posters relacionados al ámbito de trabajo de la empresa.</p>
                <p>Debajo de esta área se muestra una banda separadora color azul que divide ésta con el área designada para trabajar en el módulo de Productos y Servicios.</p>
                <br/>

                <!--  Badge 2  ||||||||||||||||||||||||||||||||||||||||||||||||||| -->
                <div class="row ctt-bagde-padding">
                    <div class="well well-sm"><img src="<?=$baseUrl?>/img/2.jpg" class="ctt-image-help-badge" align="left"><span class="text-info"><h4  style="padding-left: 60px; text-align: left">Área : Barra de Navegación</h4></span></div>
                </div>

                <p>La barra de navegación se puede mostrar y ocultar al presionar el botón ubicado en el extremo superior derecho del módulo Productos y Servicios o bien tan solo al hacer clic en cualquier parte de la pantalla. Esta barra mostrará <b>SOLO</b> las opciones a las que tiene acceso el usuario autentificado en base a su perfil de seguridad.</p>
                <p>La barra de navegación también contiene el botón de cierre de sesión ( <em>logout</em> ) y el nombre del usuario que actualmente está autentificado. Es importante que un usuario, al terminar de trabajar en el sistema, cierre su sesión de trabajo
                    pues de esta manera aumentará la seguridad del mismo y de los procesos de la empresa.</p>

                <blockquote class="ctt-blockquote"><b>MUY IMPORTANTE</b> : En cualquier momento el usuario puede acercar el cursor del mouse a cualquier botón y al mantenerlo por un par de segundos se mostrará un mensaje o '<em>tooltip</em>' que dará una breve explicación acerca del uso de dicho botón.</blockquote>
                <p>Por último, es importante mencionar que los <b>botones fijos de flecha arriba / flecha abajo</b> que se hayan en el <u>extremo inferior derecho</u>, se usan para que el usuario de forma sencilla se ubique en el tope o fondo del área de trabajo. El uso de estos botones resultan muy útil para visualizar rápidamente el área de datos.</p>
                <br/>

                <!--  Badge 3  ||||||||||||||||||||||||||||||||||||||||||||||||||| -->
                <div class="row ctt-bagde-padding">
                    <div class="well well-sm"><img src="<?=$baseUrl?>/img/3.jpg" class="ctt-image-help-badge" align="left"><span class="text-info"><h4  style="padding-left: 60px; text-align: left">Área : Cierre de Sesión</h4></span></div>
                </div>

                <p>Esta área se muestra en un color naranja para resaltar al usuario el botón para cerrar su sesión de trabajo. También muestra el usuario que actualmente está autentificado.</p>
                <p>Cada usuario tiene un perfil de acceso, a través del cual se le pernitirá el ingreso a ciertas áreas del sistema según sus funciones. Por lo tanto cabe mencionar que las opciones disponibles
                    en la barra de navegación, son <b>DINÁMICAS</b> pues cambian según el usuario autentificado y sus privilegios.</p>
                <br/>

                <!--  Badge 4  ||||||||||||||||||||||||||||||||||||||||||||||||||| -->
                <div class="row ctt-bagde-padding">
                    <div class="well well-sm"><img src="<?=$baseUrl?>/img/4.jpg" class="ctt-image-help-badge" align="left"><span class="text-info"><h4  style="padding-left: 60px; text-align: left">Área : Opciones Disponibles</h4></span></div>
                </div>

                <p>En esta área se muestra las opciones a las que puede tener acceso el usuario que está actualmente autentificado.</p>
                <p>Cuando se crea un usuario, también se le otorgan sus privilegios de acceso en lo que se denomina su <b>PERFIL DE ACCESO</b>. Este perfil está en función de los privilegios que otorgue la gerencia responsable.</p>
                <br/>

                <!--  Badge 5  ||||||||||||||||||||||||||||||||||||||||||||||||||| -->
                <div class="row ctt-bagde-padding">
                    <div class="well well-sm"><img src="<?=$baseUrl?>/img/5.jpg" class="ctt-image-help-badge" align="left"><span class="text-info"><h4  style="padding-left: 60px; text-align: left">Área : Botón de Regreso</h4></span></div>
                </div>

                <p>Este botón le permite al usuario regresar al nivel superior anterior en la jerarquía de navegación del sistema. Por ejemplo, si el usuario se encuentra en el módulo de Productos y Servicios, entonces presionar este botón lo llevará
                    a la página anfitrión del inventario.</p>
                <blockquote class="ctt-blockquote"><b>IMPORTANTE</b> : Este botón se encuentra en cada módulo que integra al sistema, y forma parte escencial del esquema de navegación del mismo.</blockquote>
                <br/>

                <!--  Badge 6  ||||||||||||||||||||||||||||||||||||||||||||||||||| -->
                <div class="row ctt-bagde-padding">
                    <div class="well well-sm"><img src="<?=$baseUrl?>/img/6.jpg" class="ctt-image-help-badge" align="left"><span class="text-info"><h4  style="padding-left: 60px; text-align: left">Área : Identificación, Operaciones y Sub-módulos.</h4></span></div>
                </div>

                <p>Esta área muestra la <b>identificación del módulo</b> ( <u>tamaño de letra 2.5 em / color gris obscuro</u> ) y de bajo de ésta una breve <b>descripción</b> que la acompaña ( <u>tamaño de letra 1.5 em / color azul</u> ). <br/><br/>
                    De igual modo en esta área se mostrarán los mensajes al usuario, siendo éstos de tres categorias diferentes : <span style="color:green"><b>Éxito</b></span>, <span style="color:orange"><b>Advertencia</b></span>
                    y <span style="color:red"><b>Error</b></span>.</p>
                <blockquote class="ctt-blockquote"><b>IMPORTANTE</b> : Cuando aparezca un mensaje dirigido al usuario, éste <b>se mantendrá por 25 segundos aproximadamente</b>, para después cerrarse automáticamente y recorrer todos los controles por debajo del mensaje hacia arriba.</blockquote>
                <p>Las <b>operaciones</b> y los <b>sub-módulos</b> estan representados por botones que al hacer clic en ellos iniciaran un proceso, o bien llevarán al usuario a otro módulo subordinado. Por ejemplo, para este módulo existe el
                    botón <b>Crear Artículo</b> el cual al presionarlo enviará al usuario a la pantalla de captura para dar de alta a un nuevo registro de producto o de servicio. De igual modo, el botón <b>Marcas</b> le dará ingreso al usuario autentificado con acceso al sub-módulo, para ingresar las marcas de productos o servicios administrados por el sistema.</p>
                <br/>

                <!--  Badge 7  ||||||||||||||||||||||||||||||||||||||||||||||||||| -->
                <div class="row ctt-bagde-padding">
                    <div class="well well-sm"><img src="<?=$baseUrl?>/img/7.jpg" class="ctt-image-help-badge" align="left"><span class="text-info"><h4  style="padding-left: 60px; text-align: left">Área : Datos Almacenados.</h4></span></div>
                </div>

                <p>Esta área muestra los <b>datos almacenados</b> en la base de datos de la entidad Productos y Servicios. Cada renglón o túpla representa a un producto o servicio almacenado en el sistema. <br/><br/>
                    Por otro lado, cada renglón a su vez se divide en columnas y cada intersección <b>renglón-columna</b> corresponde a un atributo particular de un producto o servicio.</p>
                <blockquote class="ctt-blockquote">
                    <b>IMPORTANTE</b> : Esta área, por omisión, muestra grupos de <b>10 registros</b> a la vez, lo que facilita la revisión y búsqueda de datos particulares de un producto o servicio. Cada grupo representa una página de información y se puede recorrer toda la información de los
                    productos o servicios usando el <b>Control Paginador</b> que más adelante se describirá.</blockquote>

                <p>El usuario se puede desplazar entre las columnas sin perderlas de vista, usando la barra de desplazamiento horizontal. Cada columna mostrará el nombre de la misma y el usuario podrá hacer clic sobre este nombre y con ello <b>ORDENARÁ</b>
                    automáticamente la información en base al valor de dicha columna. Una flecha hacia arriba, o bien una flecha hacia abajo con las letras iniciales del alfabeto ( <b>a-z</b> / <b>z-a</b> ) denotarán el <b>orden ascendente</b> o <b>descendente respectivamente</b>.</p>

                <p>Otra funcionalidad muy importante, son los <b>CAMPOS DE FILTRADO</b> que aparecen justo debajo de los nombres de las columnas. Su finalidad es brindar al usuario un mecanismo a través del cual pueda <b>buscar y filtrar</b> datos de su interés.
                    Por ejemplo, si en el campo de filtrado el usuario escribe la palabra <b>ESTUDIOS</b>, el sistema mostrará y paginará únicamente los datos que coincidan con dicho criterio de filtrado.</p>

                <p>Para volver a mostrar y paginar <b>TODOS</b> los registros, <b>se deberá suprimir</b> la o las palabras del campo de filtrado para que dicho criterio deje de aplicarse a la vista de datos almacenados.</p>

                <p>Acompañando al control de paginado, está la etiqueta de <b>ELEMENTOS MOSTRADOS</b>. En esta se indica el gurpo actual de páginas que se despliegan. Por ejemplo, el valor de la etiqueta <b>Mostrado 1-20 de 21 elementos</b> indica los registros desplegados actualmente,
                    así como el total de registros por mostrar. </p>
                <p>Por último, esta área presenta un par de columnas de operación. La columna de <b>Acciones</b> y la columna de <b>Número Consecutivo</b> que se indica con un <b>símbolo #</b> ( <em>hash</em> ). La columna de Acciones se explicará más adelante a detalle.</p>
                <br/>

                <!--  Badge 8  ||||||||||||||||||||||||||||||||||||||||||||||||||| -->
                <div class="row ctt-bagde-padding">
                    <div class="well well-sm"><img src="<?=$baseUrl?>/img/8.jpg" class="ctt-image-help-badge" align="left"><span class="text-info"><h4  style="padding-left: 60px; text-align: left">Área : Acciones.</h4></span></div>
                </div>

                <p>En esta área se muestran diferentes iconos que visualmente representan las acciones de <b>consultar</b> un producto o servicio ( <em>ojo</em> ), <b>modificar</b> un producto o servicio ( <em>lápiz</em> ),  <b>eliminar</b> un producto o servicio ( <em>bote de basura</em> ), <b>listar</b> un producto o servicio ( <em>Hoja</em> ),  <b>visualizar</b> un producto o <br/>servicio ( <em>cámara</em> ).<br/><br/>
                    Para cada una de las acciones disponibles, incluyendo <b>crear un nuevo producto o servicio</b>, el usuario debe contar con el permiso correspondiente en su perfil de acceso, o de lo contrario el sistema emitirá un mensaje de advertencia por intentar ejecutar una acción <b>NO permitida</b>.</p>

                <p><img src="<?=$baseUrl?>/img/actions_bar_02.jpg" align="left"></p>

                <br/><br/>

                <table class="table-bordered table-striped table-hover table-about">
                    <tbody>
                    <tr>
                        <th style="width: 180px;"><b>Acción Consultar</b><br/>( <em>Icono Ojo</em> )</th><td>Tener acceso a esta acción llevará al usuario a consultar los datos del producto o servicio seleccionado en otra área especialmente diseñada para tal efecto.</td>
                    </tr>
                    <tr>
                        <th><b>Acción Actualizar</b><br/>( <em>Icono Lápiz</em> )</th><td>Tener acceso a esta acción llevará al usuario a actualizar los datos del producto o servicio seleccionado en un formulario de captura de datos especialmente diseñado. Ahí el usuario podrá modificar o bien descartar las modificaciones hechas.</td>
                    </tr>
                    <tr>
                        <th><b>Acción Eliminar</b><br/>( <em>Icono Bote de Basura</em> )</th><td>Al pasar el cursor sobre este icono, cambiará su color a <span style="color: red">ROJO</span>, para señalar que se trata de una <b>acción sensible</b>. Tener acceso a esta acción llevará al usuario a contestar una
                            pregunta de confirmación para suprimir los datos del producto o servicio seleccionado. De ser afirmativa la respuesta, el registro en cuestión se eliminará de la base de datos y aparecerá un mensaje de aviso en el área descrita en el punto 6 anterior.</p>
                            <p> En todo momento el usuario puede acercar el cursor del mouse y dejarlo un par de segundos para solicitar el '<em>tooltip</em>' que muestra una breve descripción de la acción.</p></td>
                    </tr>
                    <tr>
                        <th><b>Acción Listar</b><br/>( <em>Icono Lista</em> )</th><td>Al pasar el cursor sobre este icono, cambiará su color a <span style="color: black">NEGRO</span> para señalar que se puede hacer clic sobre ésta. Tener acceso a esta acción permitirá al usuario incluir el producto o servicio seleccionado en un la lista final de productos y servicios que otros usuarios han de usar como la base de sus procesos.
                            Por ejemplo, al elaborar una cotización, solo los artículos señalados con ésta opción serán visibles y útiles en las listas de precios actuales y de esta forma podrán ser incluidos en las cotizaciones u otros procesos relacionados.</td>
                    </tr>
                    <tr>
                        <th><b>Acción Visualizar</b><br/>( <em>Icono Cámara</em> )</th><td>Al pasar el cursor sobre este icono, cambiará su color a <span style="color: orangered">NARANJA</span> para señalar que se puede hacer clic sobre ésta. Tener acceso a esta acción llevará al usuario a visualizar una imagen del producto, si se dispone de ésta.</p></td>
                    </tr>
                    </tbody>
                </table>

                <br/><br/>

                <!--  Badge 9  ||||||||||||||||||||||||||||||||||||||||||||||||||| -->

                <div class="row ctt-bagde-padding">
                    <div class="well well-sm"><img src="<?=$baseUrl?>/img/9.jpg" class="ctt-image-help-badge" align="left"><span class="text-info"><h4  style="padding-left: 60px; text-align: left">Área : Selector de Registros.</h4></span></div>
                </div>

                <p>Esta columna muestra una serie de controles denominados cajas de verificación ( <em>checkbox</em> ) que se usan para marcar o señalar registros, los cuales se desea procesar. Por ejemplo, este columna es importante
                   para las herramientas de <b>Imprimir</b>, <b>Exportar</b> e <b>Importar</b> que se alojan en el panel de <b>Herramientas</b>. Si se desea imprimir un grupo particular de registro, será necesario primero marcar éstos y después
                   solicitar el reporte impreso, o de lo contrario no podrá ser ejecutada la acción. De igual modo operan las herramientas de <b>Exportar</b> e <b>Importar</b> a una hoja de cálculo.</p>

                <p>Una opción importante y que también se aloja en el panel de <b>Herramientas</b>, es la opción <b>Desmarcar</b> y sirve para desmarcar todos los registros que se hayan marcado antes usando esta columna.</p>

                <blockquote class="ctt-blockquote">
                    <b>IMPORTANTE</b> : Todos los registros marcados usando esta columna, serán desmarcados automáticamente si el usuario cierra su sesión de trabajo o el propio navegador, o bien al paso de 2 horas.
                       Esto se debe a que el marcado de regsitros solo se usa para señalar los registros de interés a procesos específicos como la impresión de reportes.</blockquote>

                <br/>

                <!--  Badge 10  ||||||||||||||||||||||||||||||||||||||||||||||||||| -->

                <div class="row ctt-bagde-padding">
                    <div class="well well-sm"><img src="<?=$baseUrl?>/img/10.jpg" class="ctt-image-help-badge" align="left"><span class="text-info"><h4  style="padding-left: 60px; text-align: left">Área : Selector de Filtrado.</h4></span></div>
                </div>

                <p>Debajo de las cabeceras de las columnas, pueden existir selectores ( <em>combobox</em> ) que sirven para mostrar una serie de criterios por los cuales un usuario puede <b>filtrar</b> la información desplegada en el área de <b>Datos Almacenados</b>.</p>
                <p>De esta forma se puede facilitar la búsqueda de información específica. De igual modo se puede suprimir la acción de filtrado, elijiendo la opción <b>Ver Todo...</b></p>
                <br/>


                <!--  Badge 11  ||||||||||||||||||||||||||||||||||||||||||||||||||| -->
                <div class="row ctt-bagde-padding">
                    <div class="well well-sm"><img src="<?=$baseUrl?>/img/11.jpg" class="ctt-image-help-badge" align="left"><span class="text-info"><h4  style="padding-left: 60px; text-align: left">Área : Control Paginador.</h4></span></div>
                </div>

                <p>En esta área se encuentra el <b>Control Paginador</b> que permite al usuario navegar entre las diferentes páginas de los producto o servicio almacenados en la base de datos del sistema. El usuario puede avanzar y retroceder entre las páginas del mismo modo que puede ir a la página final o
                    inicial de producto o servicio.</p>
                <br/>

                <!--  Badge 12  ||||||||||||||||||||||||||||||||||||||||||||||||||| -->
                <div class="row ctt-bagde-padding">
                    <div class="well well-sm"><img src="<?=$baseUrl?>/img/12.jpg" class="ctt-image-help-badge" align="left"><span class="text-info"><h4  style="padding-left: 60px; text-align: left">Área : Panel de Herramientas.</h4></span></div>
                </div>

                <p>Esta área se diseñó para mantener y organizar herramientas útiles para el módulo de <b>Productos y Servicios</b>.</p>
                <p>Por omisión y para optimizar el espacio de trabajo, este panel permanece cerrado y se abre o cierra al presionar el botón <b>Herramientas</b>. Una pequeña animación que rota le indica al usuario que puede abrir o
                    cerrar el panel.
                </p>
                <p>
                    Como un ejemplo de su uso, al hacer clic sobre la herramienta <b>Colores</b> ( <em>gota de tinta</em> ) los registros de productos o servicios inmediatamente son marcados en un color específico, de acuerdo al
                    <b>tipo de producto o servicio</b> de que se trate. Realizando nuevamente la operación, los colores se desactivarań.
                </p>

                <p>La siguiente tabla describe cada una de las herramientas disponibles en el panel.</p>

                <br/>

                <p><img src="<?=$baseUrl?>/img/tools_bar_02.jpg" align="left"></p>

                <br/><br/>

                <table class="table-bordered table-striped table-hover table-about">
                    <tbody>
                    <tr>
                        <th style="width: 120px;"><b>Ayuda</b></th><td>Esta herramienta permite visualizar la ayuda general del módulo. Al hacer clic en el icono, se desplegará esta pantalla de información y una vez concluida la consulta, al presionar el botón de <b>Regreso</b> el usuario volverá al módulo de <b>Productos y Servicios</b>.</td>
                    </tr>
                    <tr>
                        <th><b>Colores</b></th><td>Esta herramienta permite marcar o desmarcar con colores distintivos a cada uno de los registros que se muestran, dependiendo de su tipo de artículo ( <b>Venta</b> o <b>Renta</b> ).</td>
                    </tr>
                    <tr>
                        <th><b>Columnas</b></th><td>Esta herramienta permite mostrar o bien ocultar temporalmente las columnas de información que el usuario requiera desplegar o no en el área de <b>Datos Almacenados</b>.</td>
                    </tr>
                    <tr>
                        <th><b>Paginado</b></th><td>Esta herramienta permite cambiar y establecer temporalmente el número de registros por página que el usuario requiera desplegar en el área de <b>Datos Almacenados</b>.</td>
                    </tr>
                    <tr>
                        <th><b>Desmarcar</b></th><td>Esta herramienta permite desmarcar todos los registros que se mantienen seleccionados en la columna <b>Selector</b> en el área de <b>Datos Almacenados</b>.</td>
                    </tr>
                    <tr>
                        <th><b>Imprimir</b></th><td>Esta herramienta permite generar e imprimir un archivo en formato <b>.PDF</b>, que contenga todos los registros que estén seleccionados en el área de <b>Datos Almacenados</b>.</td>
                    </tr>
                    <tr>
                        <th><b>Exportar</b></th><td>Esta herramienta permite exportar hacia un archivo en formato <b>.CSV</b>, todos aquellos registros que estén seleccionados en el área de <b>Datos Almacenados</b>. Posteriormente el contenido del archivo podrá ser editado usando una Hoja de Cálculo.</td>
                    </tr>
                    <tr>
                        <th><b>Importar</b></th><td>Esta herramienta permite importar al sistema, un conjunto de registros desde un archivo en formato <b>.CSV</b> e intregrar éstos al área de <b>Datos Almacenados</b>. Los archivos <b>.CSV</b> deberán ser creados previamente en una Hoja de Cálculo.</td>
                    </tr>
                    </tbody>
                </table>

                <br/><br/>

                <!--  Badge 13  ||||||||||||||||||||||||||||||||||||||||||||||||||| -->
                <div class="row ctt-bagde-padding">
                    <div class="well well-sm"><img src="<?=$baseUrl?>/img/13.jpg" class="ctt-image-help-badge" align="left"><span class="text-info"><h4  style="padding-left: 60px; text-align: left">Área : Pie de Imagen Informativa.</h4></span></div>
                </div>

                <p>En esta área se presentan los derechos y créditos formales sobre el uso del software libre ( <em>Open Source</em> ) empleado en le desarrollo de este proyecto.</p>
                <br/>
        </div>
    </div>

</section>

<!-- Includes the view's footer file -->
<?php include(Yii::getAlias('@app').'/views/layouts/cttwapp_views_footer.inc'); ?>