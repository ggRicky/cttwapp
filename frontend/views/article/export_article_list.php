<?php

use yii\helpers\Html;
use yii\helpers\Url;

// 2019-09-20 : Shows the article list and the link for download the available CSV file

$this->title = 'Exportar';
$description = 'Productos y Servicios';

$asset = \frontend\assets\AppAsset::register($this);
$baseUrl = $asset->baseUrl;

// 2018-06-11 : If there is a page parameter, then stores and validate it.
// Verifies and validate the current page value.
$ret_page = Yii::$app->getRequest()->getQueryParam('page');
$ret_page = (empty($ret_page)?'1':$ret_page);

// Access to sessions through the session application component
$session = Yii::$app->session;

// Validate the existence and content of the session array 'keylist'.
if (isset($session['keylist']) && count($session['keylist'])>0) {

    // Prepares the key list message
    $message = Yii::t('app','Los registros seleccionados para exportar en formato CSV son los siguientes').". [ "."\"".implode("\", \"",$session['keylist'])."\""." ]";
    // Gets the key list for querying
    $list = "'".implode("', '",$session['keylist'])."'";

    // Gets the CSV file name
    $file_name = Yii::getAlias('@webroot').Yii::getAlias('@downloads').'/exported_article_list.csv';

    // Exports the selected records using the SQL COPY statement and the key list
    $sql = "COPY (SELECT * FROM article WHERE \"id\" IN (".$list.")) TO '$file_name' CSV HEADER;";
    // Executes the SQL statement
    Yii::$app->db->createCommand($sql)->execute();

    // Gets the full url to refer the CSV file
    $url_csv = Url::to(Yii::getAlias('@downloads').'/exported_article_list.csv');

    // If file exists, create the link for download the CSV file
    if (file_exists($file_name)) {
        // Creates the text link for download the CSV file
        $link1 = "<a href='".$url_csv."'>".Yii::t('app','Descargar la lista de productos y servicios seleccionados').'.'."</a>";
        // Creates the glyphicon link for download the CSV file
        $link2 = "<a href='".$url_csv."' class='btn glyphicon glyphicon-cloud-download' data-toggle='tooltip' title='".Yii::t('app', 'Descargar')."' ></a>";
        // Joins the links to the user message
        $message = $message."<br>".$link1.$link2;
        // Shows the final message using a Flash
        Yii::$app->session->setFlash('success', $message);
    }
}
?>

    <!-- Blue ribbon decoration -->
    <section class="ctt-section bg-primary">
        <div class="col-lg-12">
            <div id="work-view-area" class="row">
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
                <?= Html::a(Yii::t('app','R e g r e s a r'), ['article/index', 'page' => $ret_page, 'hash' => '0'], ['class' => 'btn btn-dark btn-ctt-fixed-width', 'data-toggle' => 'tooltip', 'title' => Yii::t('app', 'Regresar al nivel anterior')]) ?>
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
                <p><?= Yii::t('app',Html::encode($description));?></p>
            </div>
        </div>

        <!-- Yii2 work area -->
        <div class="row">
            <div class="col-lg-12 text-justify yii2-content">

                <!-- Flash messages area -->

                <!-- 2018-05-25 : Flash success message -->
                <?php if (Yii::$app->session->hasFlash('success')): ?>
                    <div class="alert alert-success alert-dismissible fade in">
                        <a href="#" class="close  link-close" data-dismiss="alert" data-toggle="tooltip" aria-label="close" title="<?= Yii::t('app','Cerrar') ?>">&times;</a>
                        <h4><strong>¡ <?= Yii::t('app','Información'); ?> !</strong></h4>
                        <p><?= Yii::$app->session->getFlash('success') ?></p>
                    </div>
                <?php endif; ?>

                <!-- Business logic for export a article list -->
                <div class="article-export"></div>
            </div>
        </div>
    </section>

<!-- Includes the actions view's footer file -->
<?php include(Yii::getAlias('@app').'/views/layouts/cttwapp_views_actions_footer.inc'); ?>

<!-- Includes the custom modal window to confirm the GridView actions-->
<?php include(Yii::getAlias('@app').'/views/layouts/cttwapp_views_modal_confirm.inc'); ?>
