<?php

/**
 * Created by PhpStorm.
 * User: ricardo
 * Date: 4/02/18
 * Time: 04:24 PM
 *
 * This component runs a function 'changeLanguage' at the incoming EVENT_BEFORE_REQUEST
 *
 * The function 'changeLanguage' dynamically changes the $app->language property to the value stored in a cookie.
 *
 */

namespace frontend\components;

class ChgeDynLangApp extends \yii\base\Behavior
{
    public function events(){
        return[
            \yii\web\Application::EVENT_BEFORE_REQUEST => 'changeLanguage',
        ];
    }

    public function changeLanguage(){
        if (\Yii::$app->getRequest()->getCookies()->has('lang')){
            \Yii::$app->language = \Yii::$app->getRequest()->getCookies()->getValue('lang');
        }
    }

}