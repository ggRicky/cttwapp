<?php

use yii\helpers\Html;
use yii\helpers\Url;
use yii\widgets\DetailView;

/* 2018-06-05 : Used to display Catalog, Brand and Warehouse Names for the actual article record */

use yii\helpers\ArrayHelper;
use app\models\Catalog;
use app\models\Brand;
use app\models\Warehouse;

/* @var $this yii\web\View */
/* @var $model app\models\Article */

$this->title = 'Artículo';
$description = 'Vista del Artículo';

$asset = \frontend\assets\AppAsset::register($this);
$baseUrl = $asset->baseUrl;

?>

<!-- Report Header -->
<table class="table-header-report">
    <tr>
        <!-- CTT Logo Header-->
        <th rowspan="2" align="center" width="10%">
            <img src="<?=$baseUrl."/img/ctt-logo_2.png"?>" style="height: 12%;"><br/><br/>
        </th>
        <td>
            <!-- Yii2 Title layout -->
            <span class="kv-heading-1"><?= Yii::t('app',Html::encode($this->title)); ?></span><br/>
            <!-- Yii2 complementary description -->
            <span class="kv-heading-2"><?= Yii::t('app',Html::encode($description)); ?></span>
        </td>
    </tr>
    <tr>
        <td style="font-size: 10px; letter-spacing: 2px;"><?= Yii::t('app', 'Emisión') ?> :: <?= date('Y-m-d G:i:s'); ?></td>
    </tr>
</table>

<!-- Yii2 work area -->
<?= DetailView::widget([
    'model' => $model,
    'options' => [
        // 2018-08-11 : Defines the styles for customize the DetailView widget in the mPDF report.
        'class' => 'detail-view-mpdf-style',
    ],
    'attributes' => [
        'id',

        // 2018-05-06 : Modified to display the ID and the Catalog Description instead of the ID only.
        [
            'attribute' => 'catalog_id',
            'value' => implode(",",ArrayHelper::map(Catalog::find()->where(['id' => $model->catalog_id])->all(),'id','displayNameCat')),
        ],

        [
            'attribute' => 'name_art',
        ],

        'sp_desc',
        'en_desc',

        // 2018-08-03 : To displays the image.
        [
            'attribute' => 'photo',
            'format' => 'raw',
            'value' => function ($model) {
                // 2018-07-10 : To get the image path and filename.
                $file_name = Yii::getAlias('@webroot').Yii::getAlias('@uploads_inv').'/'.PREFIX_IMG.$model->id;
                // 2018-07-10 : To get the image url.
                $url_image = Url::to(Yii::getAlias('@uploads_inv').'/').PREFIX_IMG.$model->id;
                // 2018-07-11 : To get the no image url.
                $url_no_image = Url::to(Yii::getAlias('@uploads_inv').'/').'ctt_no_image.jpg';
                // 2018-07-10 : Test for the right file type
                if (file_exists($file_name.'.jpg'))
                   return '<img src="'.$url_image.'.jpg" width="auto" style="max-height:50%; max-width:50%">';
                else if (file_exists($file_name.'.png'))
                   return '<img src="'.$url_image.'.png" width="auto" style="max-height:50%; max-width:50%">';
                else
                   return '<img src="'.$url_no_image.'" width="auto" style="max-height:50%; max-width:50%">';
            },
        ],

        // 2018-05-06 : For type art, the right legend is displayed and colored properly.
        [
            'attribute' => 'type_art',
            'value' => function($model){
                return ($model->type_art=='R'?'RENTA':'VENTA');
            },
            'contentOptions' => function ($model, $key, $index, $column) {
                return ['style' => 'color:'. ($model->type_art=='R'?'grey':'#337ab7')];
            },
        ],

        'price_art',

        // 2018-05-06 : For currency art, the right legend is displayed and colored properly.
        [
            'attribute' => 'currency_art',
            'value' => function($model){
                return ($model->currency_art=='P'?'PESOS':'DÓLARES');
            },
            'contentOptions' => function ($model, $key, $index, $column) {
                return ['style' => 'color:'. ($model->currency_art=='P'?'grey':'#337ab7')];
            },
        ],

        'part_num',

        // 2018-05-06 : Modified to display the ID and the Catalog Description instead of the ID only.
        [
            'attribute' => 'brand_id',
            'value' => implode(",",ArrayHelper::map(Brand::find()->where(['id' => $model->brand_id])->all(),'id','displayBrandDesc')),
        ],

        // 2019-08-14 : Modified to display the ID and the Warehouse Description instead of the ID only.
        [
            'attribute' => 'warehouse_id',
            'value' => implode(",",ArrayHelper::map(Warehouse::find()->where(['id' => $model->warehouse_id])->all(),'id','displayDescWarehouse')),
        ],

        'created_at',
        'updated_at',
        'created_by',
        'updated_by',
    ],
]) ?>
