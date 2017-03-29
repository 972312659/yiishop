<?php

namespace backend\controllers;

use backend\models\ArticleDetail;

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

}
