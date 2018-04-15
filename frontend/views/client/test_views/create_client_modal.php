<?php

use yii\helpers\Html;

/* @var $this yii\web\View */

$this->title = 'Cliente';
$asset = \frontend\assets\AppAsset::register($this);
$baseUrl = $asset->baseUrl;

?>

<!-- Yii2 Content -->
<section id="yii2" class="yii2-page">

    <!-- Business logic for create a client -->
    <div class="render-area">

        <?= $this->render('_form_modal', [
            'model' => $model,
        ]) ?>

    </div>

</section>
