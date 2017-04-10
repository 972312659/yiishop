<?php
/**
 * Created by PhpStorm.
 * User: 邓伟
 * Date: 2017/4/9
 * Time: 15:08
 */

namespace frontend\controllers;


use frontend\models\LoginForm;
use yii\web\Controller;

class LoginController extends Controller
{
    public $layout='register';
    /**
     * 登录
     */
    public function actionLogin()
    {
        //实例化登录表单模型
        $model=new LoginForm();
        if($model->load(\Yii::$app->request->post()) && $model->validate()){
            //验证登录信息
            if($model->login()){
                return '登录成功';
            }
        }
        //显示登录页面
        return $this->render('login',['model'=>$model]);
    }
    /**
     * 注销登录
     */
    public function actionLogout()
    {
        \Yii::$app->user->logout();
        return $this->redirect(['login/login']);
    }
    public function actionTest()
    {
        var_dump(\Yii::$app->user->isGuest);
    }
}