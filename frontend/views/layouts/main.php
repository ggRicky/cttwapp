<?php

/* @var $this \yii\web\View */
/* @var $content string */

use yii\helpers\Html;

$asset = frontend\assets\AppAsset::register($this);
$baseUrl = $asset->baseUrl;

/*

  2018-04-13 19:20 Hrs.

  The next code is for Activating Bootstrap 3 Tooltip & Popover for your Yii Site

  link : http://webtips.krajee.com/activating-bootstrap-3-tooltip-popover-yii-site/


  2018-04-25 22:45 Hrs.

  Stackoverflow -- Bootstrap button tooltip hide on click --

  link : https://stackoverflow.com/questions/35079509/bootstrap-button-tooltip-hide-on-click

  description : The problem is that the tooltip stays visible after the button is clicked, and the modal is shown.
                As soon as the modal is closed, the tooltip is hidden again.

                The next code fixed it.

                The problem was that focus stays on the button when it is pressed. Changing the trigger to hover
                solves the problem.

   code added : trigger: "hover"

   original code in cttwapp-core.js :

   $(document).ready(function(e){
     $('[data-toggle="tooltip"]').tooltip({ placement: "right", trigger: "hover", delay: {show: 500, hide: 500}});
   });

*/

$js = <<<SCRIPT
/* To initialize BS3 tooltips set this below */
$(function () { 
    $('[data-toggle="tooltip"]').tooltip({placement: "right", trigger: "hover", delay: {show: 500, hide: 5}});
});
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
    <meta name="viewport" content="width=device-width, initial-scale=1">
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