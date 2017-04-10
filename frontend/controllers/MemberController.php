<?php

namespace frontend\controllers;

use frontend\models\Member;


class MemberController extends \yii\web\Controller
{
    //指定加载布局文件
    public $layout='register';
    public function actionIndex()
    {
        $models=Member::find()->all();
        return $this->render('index',['models'=>$models]);
    }

    /**
     * 用户注册
     */
    public function actionRegister()
    {
        //实例化活动记录模型
        $model=new Member();
        if($model->load(\Yii::$app->request->post()) && $model->validate()){
            //添加用户附加信息
            if($model->newAdd()){
                \Yii::$app->session->setFlash('success','注册成功');
                return $this->redirect(['login/login']);
            }
        }

        //显示用户注册页面
        return $this->render('register',['model'=>$model]);

    }
}
