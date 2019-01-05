<?php
/**
 * Created by PhpStorm.
 * User: ricardo
 * Date: 4/01/19
 * Time: 02:33 PM
 */

namespace frontend\components;

class User extends \yii\web\User
{
    // 2019-01-04 : Adds and implements to the User class, the getUsername function to return the current user name.
    // Source : Yii2 - How to get the current username or name from Yii::$app->user? - stackoverflow
    public function getUsername()
    {
        return \Yii::$app->user->identity->username;
    }
}