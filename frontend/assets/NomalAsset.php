<?php
/**
 * Created by PhpStorm.
 * User: 邓伟
 * Date: 2017/4/9
 * Time: 16:50
 */

namespace frontend\assets;


use yii\web\AssetBundle;

class NomalAsset extends AssetBundle
{
    public $basePath = '@webroot';
    public $baseUrl = '@web';
    public $css = [
        'style/base.css',
        'style/global.css',
        'style/header.css',
        'style/home.css',
        'style/address.css',
        'style/bottomnav.css',
        'style/footer.css',
        'style/jqzoom.css',

    ];
    public $js = [
        'js/header.js',
        'js/home.js',
    ];
    public $depends = [
        'yii\web\JqueryAsset',
//        'yii\web\YiiAsset',
//        'yii\bootstrap\BootstrapAsset',
    ];

}