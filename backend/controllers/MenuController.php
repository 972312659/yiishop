<?php

namespace backend\controllers;

use backend\filters\AccessFilter;
use backend\models\Menu;
use yii\filters\AccessControl;

class MenuController extends \yii\web\Controller
{
    /**
     * 显示菜单列表页面
     */
    public function actionIndex()
    {
        $models=Menu::getList();
        return $this->render('index',['models'=>$models]);
    }
    /**
     * 添加菜单
     */
    public function actionAdd()
    {
        //实例化活动记录模型
        $model=new Menu();
        //POST提交数据验证并保存
        if($model->load(\Yii::$app->request->post()) && $model->validate()){
            $model->save();
            //显示提示信息，跳转到列表页面
            \Yii::$app->session->setFlash('success','添加成功');
            return $this->redirect(['menu/index']);
        }
        //显示添加菜单页面
        return $this->render('add',['model'=>$model]);
    }
    /**
     * 修改菜单
     */
    public function actionEdit($id)
    {
        //得到对象
        $model=Menu::findOne(['id'=>$id]);
        //POST提交数据验证并保存
        if($model->load(\Yii::$app->request->post()) && $model->validate()){
            $model->save();
            //显示提示信息，跳转到列表页面
            \Yii::$app->session->setFlash('success','修改成功');
            return $this->redirect(['menu/index']);
        }
        //显示添加菜单页面
        return $this->render('add',['model'=>$model]);
    }
    /**
     * 删除菜单
     */
    public function actionDel($id)
    {
        //如果一级分类下有二级分类，则不能删除
        if(Menu::find()->where(['parent_id'=>$id])->all()){
            \Yii::$app->session->setFlash('danger','只有将下属分类，才能删除');
            return $this->redirect(['menu/index']);
        }
        //得到对象
        $model=Menu::findOne(['id'=>$id]);
        //删除对象
        $model->delete();
        //显示提示信息，跳转到列表页面
        \Yii::$app->session->setFlash('success','删除成功');
         return $this->redirect(['menu/index']);
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
