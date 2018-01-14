<?php

namespace frontend\assets;

use yii\web\AssetBundle;

/**
 * Main frontend application asset bundle.
 */
class AppAsset extends AssetBundle
{
    // 2018-01-12 : This commented code, is the AppAsset.php original version for Yii2 Advanced template

    // public $basePath = '@webroot';
    // public $baseUrl = '@web';
    // public $css = [
    //     'css/site.css',
    // ];
    // public $js = [
    // ];
    // public $depends = [
    //     'yii\web\YiiAsset',
    //     'yii\bootstrap\BootstrapAsset',
    // ];

    // 2018-01-12 : Adding to implement the new CTTwapp image

    public $sourcePath = '@bower/cttwapp/';
    public $css = [
        'css/bootstrap.min.css',
        'css/cttwapp-stylish.css',
        'font/css/font-awesome.min.css',
        'http://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,700,300italic,400italic,700italic',
        'https://fonts.googleapis.com/css?family=Libre+Barcode+39+Extended',
    ];
    public $js = [
        'js/jquery-3.2.1.js',
        'js/bootstrap-3.3.7.js',
        'js/jquery-2.0.2.js',
        'js/jquery.stellar.js',
        'js/jquery.nicescroll-3.7.6.js',
        'js/cttwapp-core.js',
        'https://oss.maxcdn.com/libs/html5shiv/3.7.0/html5shiv.js',
        'https://oss.maxcdn.com/libs/respond.js/1.4.2/respond.min.js',
    ];
    public $depends = [
        'yii\web\YiiAsset',
        'yii\bootstrap\BootstrapAsset',
    ];
}