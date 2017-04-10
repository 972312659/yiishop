<?php

namespace backend\controllers;

use backend\filters\AccessFilter;
use backend\models\ArticleCategory;
use yii\filters\AccessControl;

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
    /**
     * 修改文章分类
     */
    public function actionEdit($id)
    {
        $model=ArticleCategory::findOne(['id'=>$id]);
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
    /**
     * 删除文章分类
     */
    public function actionDel($id)
    {
        //找到对象
        $model = ArticleCategory::findOne(['id' => $id]);
        //删除
        if($model->articles){
            //如果文章分类下有文章，则不能删除
            \Yii::$app->session->setFlash('danger','该分类下有文章，不能删除');
            return $this->redirect(['articlecategory/index']);
        }
        //如果该分类下没有文章则可以删除
        $model->delete();
        //提示跳转
        \Yii::$app->session->setFlash('success','删除成功');
        return $this->redirect(['articlecategory/index']);
    }
    /**
     * ACF简单过存取滤器
     */
    public function behaviors()
    {
        return [
            'ACF'=>[
                'class'=>AccessFilter::className(),
                'only'=>['index','add','edit','del'],
            ]
        ];
    }
}
