<?php

/* @var $this \yii\web\View */
/* @var $content string */

use yii\helpers\Html;

$asset = frontend\assets\AppAsset::register($this);
$baseUrl = $asset->baseUrl;

?>
<?php $this->beginPage() ?>
    <!DOCTYPE html>
    <html lang="<?= Yii::$app->language ?>">
    <head>
        <meta charset="<?= Yii::$app->charset ?>">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <?= Html::csrfMetaTags() ?>
        <title><?= Html::encode(Yii::t('app', $this->title)) ?></title>
        <?php $this->head() ?>

        <!-- 2018-05-20 : Code Snippet added for Positive SSL secure seal validation -->
        <script type="text/javascript"> //<![CDATA[
            var tlJsHost = ((window.location.protocol == "https:") ? "https://secure.comodo.com/" : "http://www.trustlogo.com/");
            document.write(unescape("%3Cscript src='" + tlJsHost + "trustlogo/javascript/trustlogo.js' type='text/javascript'%3E%3C/script%3E"));
            //]]>
        </script>
    </head>

    <body>
    <!-- 2018-06-26 : CTT Pre-loader -->
    <div class="se-pre-con"></div>
    <?php $this->beginBody() ?>

    <?= $content ?>

    <?php $this->endBody() ?>
    </body>
    </html>
<?php $this->endPage() ?>