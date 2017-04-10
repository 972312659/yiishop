<?php

namespace backend\controllers;

use backend\filters\AccessFilter;
use backend\models\ArticleDetail;
use yii\filters\AccessControl;

class ArticledetailController extends \yii\web\Controller
{
    /**
     * 显示文章具体详情
     * @return string
     */
    public function actionIndex($id)
    {
        //找到对象
        $model=ArticleDetail::findOne(['article_id'=>$id]);
        return $this->render('index',['model'=>$model]);
    }
    /**
     * ACF简单过存取滤器
     */
    public function behaviors()
    {
        return [
            'ACF'=>[
                'class'=>AccessFilter::className(),
                'only'=>['index'],
            ]
        ];
    }

}
