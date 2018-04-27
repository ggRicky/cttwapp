<?php

/* @var $this \yii\web\View */
/* @var $content string */

use yii\helpers\Html;

$asset = frontend\assets\AppAsset::register($this);
$baseUrl = $asset->baseUrl;

/* 2018-04-13: The next code is for Activating Bootstrap 3 Tooltip & Popover for your Yii Site

  source : http://webtips.krajee.com/activating-bootstrap-3-tooltip-popover-yii-site/

 */
$js = <<<SCRIPT
/* To initialize BS3 tooltips set this below */
$(function () { 
    $("[data-toggle='tooltip']").tooltip({placement: "right", delay: {show: 500, hide: 500}}); 
});;
/* To initialize BS3 popovers set this below */
$(function () { 
    $("[data-toggle='popover']").popover(); 
});
SCRIPT;
// Register tooltip/popover initialization javascript
$this->registerJs($js);

?>
<?php $this->beginPage() ?>
<!DOCTYPE html>
<html lang="<?= Yii::$app->language ?>">
<head>
    <meta charset="<?= Yii::$app->charset ?>">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, height=device-height,initial-scale=1.0"/>
    <?= Html::csrfMetaTags() ?>
    <title><?= Html::encode($this->title) ?></title>
    <?php $this->head() ?>
</head>

<body>
<?php $this->beginBody() ?>

<?= $content ?>

<?php $this->endBody() ?>
</body>
</html>
<?php $this->endPage() ?>