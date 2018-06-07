<?php

namespace frontend\assets;

use yii\web\AssetBundle;

/**
 * Main frontend application asset bundle.
 */
class AppAsset extends AssetBundle
{
    // 2018-01-12 : Implements the new CTTwapp image.
    // 2018-02-10 : Adjusts for the right order in library references.
    // 2018-04-09 : Because a typo in protocol for the font Source+Sans+Pro ( http without an s at end ), the production version wasn't displayed as expected.
    // 2018-05-12 : Adds jquery-ui.css, and jquery-ui.js files for enable jQuery Accordion widget. [ 2018-05-12 : Deleted ]
    // 2018-06-02 : Removes nicescroll plugin due to conflict with bootstrap modals.
    // 2018-06-02 : Adds jsscrollpane plugin tp solve the conflict with bootstrap modals.
    // 2018-06-03 : Removes jsscrollpane plugin due to conflict with bootstrap modals.
    // 2018-06-04 : Adds Yii2 default site.css file. Adding this file, the sort glyphicons are showed.

    public $sourcePath = '@bower/cttwapp/';

    public $css = [
        // 2018-06-04 : Yii2 default site.css file.
        'css/site.css',
        // bootstrap styles
        'css/bootstrap.min.css',
        // the styles needed by cttwapp project
        'css/cttwapp-stylish.css',
        // the fonts needs for the cttwapp project
        'font/css/font-awesome.min.css',
        'https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,700,300italic,400italic,700italic',
        'https://fonts.googleapis.com/css?family=Libre+Barcode+39+Extended',
    ];
    public $js = array(
        // the jquery version for parallax effect
        'js/jquery-2.0.2.js',
        // the parallax plugin
        'js/jquery.stellar.js',
        // the js/jquery core for the cttwapp project
        'js/cttwapp-core.js',
        // the bootstrap plugin
        'js/bootstrap-3.3.7.js',
        'https://oss.maxcdn.com/libs/html5shiv/3.7.0/html5shiv.js',
        'https://oss.maxcdn.com/libs/respond.js/1.4.2/respond.min.js',
    );
    public $depends = [
        'yii\web\YiiAsset',
        'yii\bootstrap\BootstrapAsset',
    ];
}