<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/* 2018-09-30 : Used to display Description Type for the actual client record */

use yii\helpers\ArrayHelper;
use app\models\ClientType;

/* @var $this yii\web\View */
/* @var $model app\models\Client */

$this->title = 'Cliente';
$description = 'Vista del Cliente';

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
        'rfc',
        'curp',

        // 2018-04-23 : For taxpayer type, the right legend is displayed and colored properly.

        [
            'attribute' => 'taxpayer',
            'value' => function($model){
                return ($model->taxpayer=='M'?'PERSONA MORAL':'PERSONA FÍSICA');
            },
            'contentOptions' => function ($model, $key, $index, $column) {
                return ['style' => 'color:'. ($model->taxpayer=='M'?'grey':'#428bca')];
            },
        ],

        // 2018-04-10 : New fields add to client table in refactoring action.

        'business_name',
        'corporate',

        // 2018-04-23 : For provenance type, the right legend is displayed.

        [
            'attribute' => 'provenance',
            'value' => function($model){
                return ($model->provenance=='N'?'NACIONAL':'EXTRANJERO');
            },
        ],

        'contact_name',
        'contact_email',
        'street',
        'outdoor_number',
        'interior_number',
        'suburb',
        'municipality',
        'delegation',
        'state',
        'zip_code',
        'phone_number_1',
        'phone_number_2',
        'web_page',
        'client_email',

        'created_at',
        'updated_at',
        'created_by',
        'updated_by',

        // 2018-03-17 : Modified to display the ID and the Client Type Description instead of the ID only.

        [
            'attribute' => 'client_type_id',
            'value' => implode(",",ArrayHelper::map(ClientType::find()->where(['id' => $model->client_type_id])->all(),'id','displayTypeDesc')),
        ],
    ],
]) ?>
