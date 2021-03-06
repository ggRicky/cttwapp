<?php

namespace backend\assets;

use yii\web\AssetBundle;

/**
 * Main backend application asset bundle.
 */
class AppAsset extends AssetBundle
{
    // 2018-01-12 : Implement the new CTTwapp image.
    // 2018-02-10 : Adjust for the right order in library references.
    // 2018-04-09 : Because a typo in protocol for the font Source+Sans+Pro ( http without an s at end ), the production version wasn't displayed as expected.
    // 2018-05-12 : Add jquery-ui.css, and jquery-ui.js files for enable jQuery Accordion widget.
    // 2018-05-25 : Integration to main backend application

    public $sourcePath = '@bower/cttwapp/';
    public $css = [
        'css/bootstrap.min.css',
        'css/cttwapp-stylish.css',
        'font/css/font-awesome.min.css',
        'https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,700,300italic,400italic,700italic',
        'https://fonts.googleapis.com/css?family=Libre+Barcode+39+Extended',
    ];
    public $js = [
        'js/jquery-2.0.2.js',
        'js/jquery.stellar.js',
        'js/jquery.nicescroll-3.7.6.js',
        'js/cttwapp-core.js',
        'js/bootstrap-3.3.7.js',
        'https://oss.maxcdn.com/libs/html5shiv/3.7.0/html5shiv.js',
        'https://oss.maxcdn.com/libs/respond.js/1.4.2/respond.min.js',
    ];
    public $depends = [
        'yii\web\YiiAsset',
        'yii\bootstrap\BootstrapAsset',
    ];
}