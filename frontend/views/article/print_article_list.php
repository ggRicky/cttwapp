<?php

use yii\helpers\Html;
use yii\grid\GridView;

/* 2018-06-05 : Used to display Catalog, Brand and Warehouse Names for the actual article record */

use yii\helpers\ArrayHelper;
use app\models\Catalog;
use app\models\Brand;
use app\models\Warehouse;
use app\models\ArticleType;

/* @var $this yii\web\View */
/* @var $dataProvider yii\data\ActiveDataProvider */
/* @var $searchModel app\models\ArticleSearch */

$this->title = 'Lista de Artículos';
$description = 'Selección';

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

<?php
// 2018-09-30 : If there isn't the article_columns_config cookie, then by default shows all the columns.
$c = $m = '1111111111111111111111111';  // 2019-08-14 : $m - This variable is the mask for fills the undefined columns.

// 2018-09-30 : Gets the visibility status for all columns from the cookies and put it into the $c variable.
if (Yii::$app->getRequest()->getCookies()->has('article_columns_config')) {
    $c = Yii::$app->getRequest()->getCookies()->getValue('article_columns_config');

    // 2019-08-14 : Fills the string variable $c up to 25 characters
    $c = ($m & $c).str_repeat('0',abs(strlen($m)-strlen($c)));
}
?>

<?= GridView::widget([
    'id' => 'GridView-Print',
    'dataProvider' => $dataProvider,
    'options' => [
        'class' => 'grid-view-mpdf-style',
    ],

    'rowOptions' => function($model){
        // 2018-04-23 : The next conditional statement enable colored rows based on specific database value
        // 2018-05-14 : Improvement. The color on/off status is stored in a cookie.
        if (Yii::$app->getRequest()->getCookies()->has('article-color') &&
            Yii::$app->getRequest()->getCookies()->getValue('article-color') == '1'){
            // 2018-05-06 : Change the row background color based on the article_type_id value.

            if ($model->article_type_id == '2')          // '2' - Venta  ( '1' - Renta )
            {
                return ['class' => 'yellow-light'];
            }else if ($model->article_type_id == '3')    // '3' - Freelance
            {
                return ['class' => 'blue-light'];
            }else if ($model->article_type_id == '4')    // '4' - Movil
            {
                return ['class' => 'red-light'];
            }else if ($model->article_type_id == '5')    // '5' - Planta
            {
                return ['class' => 'teal-light'];
            }else if ($model->article_type_id == '6')    // '6' - Daños
            {
                return ['class' => 'lime-light'];
            }else if ($model->article_type_id == '7')    // '7' - Viatcos
            {
                return ['class' => 'orange-light'];
            };

            return [];
        }
        return [];
    },

    'columns' => [

        [
            'class' => 'yii\grid\SerialColumn',
            'contentOptions' => ['class' => 'text-center', 'style' => 'height:10px;'],  // 2019-07-21 : Determines the rows height ( 30px ) in the GridView control
        ],

        [
            'attribute' => 'id',
        ],

        // 2018-05-06 : Modified to display the ID and the Catalog Description instead of the ID only.

        [
            'attribute' => 'catalog_id',
            'visible' => ($c[0] == '1' ? true : false),     // 2018-08-20 : Set the column visibility status
            // 2018-08-21 : Modified to display a DropDownList with the available catalogs, using the filter option.
            'filter' => Html::activeDropDownList($searchModel, 'catalog_id', ArrayHelper::map(Catalog::find()->select(['id','name_cat'])->orderBy(['id' => SORT_ASC])->all(),'id','displayNameCat'), ['prompt' => Yii::t('app','Ver Todos...'), 'data-toggle' => 'tooltip', 'title' => Yii::t('app', 'Catálogos Disponibles')]),
            'value' => function($model){
                return implode(",",ArrayHelper::map(Catalog::find()->where(['id' =>  $model->catalog_id])->all(),'id','displayNameCat'));
            }
        ],

        // 2019-08-14 : Added to display the ID and the Warehouse Description instead of the ID only.

        [
            'attribute' => 'warehouse_id',
            'visible' => ($c[13] == '1' ? true : false),    // 2019-08-14 : Set the column visibility status
            // 2019-08-14 : Modified to display a DropDownList with the available warehouses, using the filter option.
            'filter' => Html::activeDropDownList($searchModel, 'warehouse_id', ArrayHelper::map(Warehouse::find()->select(['id','desc_warehouse'])->orderBy(['id' => SORT_ASC])->all(),'id','displayDescWarehouse'), ['prompt' => Yii::t('app','Ver Todos...'), 'data-toggle' => 'tooltip', 'title' => Yii::t('app', 'Almacenes Disponibles')]),
            'value' => function($model){
                return implode(",",ArrayHelper::map(Warehouse::find()->where(['id' =>  $model->warehouse_id])->all(),'id','displayDescWarehouse'));
            }
        ],

        // 2018-05-06 : Displays the name_art field in red text color.

        [
            'attribute' => 'name_art',
            'visible' => ($c[1] == '1' ? true : false),     // 2018-08-20 : Set the column visibility status
            'contentOptions' => ['style' => 'color:red;text-transform:uppercase;'],  // 2019-07-29 : Transforms all characters to uppercase
        ],

        [
            'attribute' => 'sp_desc',
            'visible' => ($c[2] == '1' ? true : false),     // 2018-08-20 : Set the column visibility status
            'contentOptions' => ['style' => 'text-transform:uppercase;'],  // 2019-07-29 : Transforms all characters to uppercase
        ],

        [
            'attribute' => 'en_desc',
            'visible' => ($c[3] == '1' ? true : false),     // 2018-08-20 : Set the column visibility status
            'contentOptions' => ['style' => 'text-transform:uppercase;'],  // 2019-07-29 : Transforms all characters to uppercase
        ],

        // 2018-05-06 : For article_type_id field, the right legend is displayed and colored properly.

        [
            'attribute' => 'article_type_id',
            'filter' => Html::activeDropDownList($searchModel, 'article_type_id', ArrayHelper::map(ArticleType::find()->select(['id','type_desc'])->orderBy(['id' => SORT_ASC])->all(),'id','displayTypeDesc'), ['prompt' => Yii::t('app','Ver Todos...'), 'data-toggle' => 'tooltip', 'title' => Yii::t('app', 'Tipos Disponibles')]),
            'value' =>
                function($model){
                    return (implode(",",ArrayHelper::map(ArticleType::find()->where(['id' => $model->article_type_id])->all(),'id','displayTypeDesc')));
                },
            'visible' => ($c[4] == '1' ? true : false),  // 2018-08-20 : Set the column visibility status
        ],

        [
            'attribute' => 'price_art',
            'visible' => ($c[5] == '1' ? true : false),  // 2018-08-20 : Set the column visibility status
        ],

        // 2018-04-23 : To the provenance type, the right legend is displayed.

        [
            'attribute' => 'currency_art',
            'value' => function($model){
                return ($model->currency_art=='P'?'PESOS':'DÓLARES');
            },
            'visible' => ($c[6] == '1' ? true : false),  // 2018-08-20 : Set the column visibility status
        ],

        // 2018-05-06 : Modified to display the ID and the Catalog Description instead of the ID only.

        [
            'attribute' => 'brand_id',
            // 2018-08-21 : Modified to display a DropDownList with the available catalogs, using the filter option.
            'filter' => Html::activeDropDownList($searchModel, 'brand_id', ArrayHelper::map(Brand::find()->select(['id','brand_desc'])->orderBy(['id' => SORT_ASC])->all(),'id','displayBrandDesc'), ['prompt' => Yii::t('app','Ver Todos...'), 'data-toggle' => 'tooltip', 'title' => Yii::t('app', 'Marcas Disponibles')]),
            'value' =>
                function($model){
                    return (implode(",",ArrayHelper::map(Brand::find()->where(['id' => $model->brand_id])->all(),'id','displayBrandDesc')));
                },
            'visible' => ($c[7]== '1' ? true : false),  // 2018-08-20 : Set the column visibility status
        ],

        [
            'attribute' => 'part_num',
            'visible' => ($c[8] == '1' ? true : false),  // 2018-08-20 : Set the column visibility status
        ],

        [
            'attribute' => 'created_at',
            'visible' => ($c[9] == '1' ? true : false),  // 2018-08-20 : Set the column visibility status
        ],

        [
            'attribute' => 'updated_at',
            'visible' => ($c[10] == '1' ? true : false),  // 2018-08-20 : Set the column visibility status
        ],

        [
            'attribute' => 'created_by',
            'visible' => ($c[11] == '1' ? true : false),  // 2018-08-20 : Set the column visibility status
        ],

        [
            'attribute' => 'updated_by',
            'visible' => ($c[12] == '1' ? true : false),  // 2018-08-20 : Set the column visibility status
        ],

    ],

    'layout' => '{items}',  // 2019-09-08 : Removes the {summary} and {pager} sections

]);?>
