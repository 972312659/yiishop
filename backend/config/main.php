<?php
$params = array_merge(
    require(__DIR__ . '/../../common/config/params.php'),
    require(__DIR__ . '/../../common/config/params-local.php'),
    require(__DIR__ . '/params.php'),
    require(__DIR__ . '/params-local.php')
);

return [
    'id' => 'app-backend',
    'basePath' => dirname(__DIR__),
    'controllerNamespace' => 'backend\controllers',
    'bootstrap' => ['log'],
    'modules' => [],
    'components' => [
        'request' => [
            'csrfParam' => '_csrf-backend',
        ],
        'user' => [
            'identityClass' => \backend\models\Admin::className(),
            'enableAutoLogin' => true,
            'loginUrl'=>['login/login'],
            'identityCookie' => ['name' => '_identity-backend', 'httpOnly' => true],
        ],
        'session' => [
            // this is the name of the session cookie used for login on the backend
            'name' => 'advanced-backend',
        ],
/*        'cookie'=>[
            'class'=>\yii\web\Cookie::className(),
            'name'=>'my',
        ],*/
        'log' => [
            'traceLevel' => YII_DEBUG ? 3 : 0,
            'targets' => [
                [
                    'class' => 'yii\log\FileTarget',
                    'levels' => ['error', 'warning'],
                ],
            ],
        ],
        'errorHandler' => [
            'errorAction' => 'site/error',
        ],
        'urlManager' => [
            'enablePrettyUrl' => true,
            'showScriptName' => false,
            'rules' => [
            ],
        ],
        'qiniu'=>[
            'class'=>\backend\components\Qiniu::className(),
            'accessKey' => 'pwDAEojIEBtDD53L42WU2IkXdzjz7zBnyuoAOlBj',
            'secretKey' => 'MMMJDHYTeWXR-oV_opY1JPLqHIg9hW_WgPbk_JZn',
            'domain' => 'http://onk89frq2.bkt.clouddn.com/',
            'bucket' => 'yiishop',
            'region'=>\backend\components\Qiniu::HOST_HUANAN,
        ]

    ],
    'params' => $params,
];
