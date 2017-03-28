<?php

namespace backend\controllers;

use backend\models\ArticleCategory;

class ArticlecategoryController extends \yii\web\Controller
{
    public function actionIndex()
    {
        //得到所有数据
        $models=ArticleCategory::find()->all();
        //显示列表页面
        return $this->render('index',['models'=>$models]);
    }

    /**
     * 新增文章分类
     */
    public function actionAdd()
    {
        $model=new ArticleCategory();
        $request = \Yii::$app->request;
        if($request->isPost){//以Post方式提交
            //接收传值
            $model->load($request->post());
            if($model->validate()){
                //验证数据
                $model->save();
                //显示提示信息，跳转到列表页面
                \Yii::$app->session->setFlash('success','添加成功');
                return $this->redirect(['articlecategory/index']);
            }
        }
        //显示添加页面
        return $this->render('add',['model'=>$model]);
    }
}
