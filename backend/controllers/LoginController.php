<?php
/**
 * Created by PhpStorm.
 * User: 邓伟
 * Date: 2017/4/2
 * Time: 8:46
 */

namespace backend\controllers;


use backend\models\Admin;
use backend\models\LoginForm;
use yii\filters\AccessControl;
use yii\web\Controller;

class LoginController extends Controller
{
    /**
     * 显示登录页面
     */
    public function actionLogin()
    {
        //得到表单对象
        $loginForm=new LoginForm();
        if($loginForm->load(\Yii::$app->request->post())){
            if($loginForm->login()){
                //登录成功
                \Yii::$app->session->setFlash('success','登录成功');
                return $this->redirect(['login/index']);
            }
        }
        //显示登录页面
        return $this->render('login',['loginForm'=>$loginForm]);
    }

    /**
     * 验证登录
     */
    public function actionLogout()
    {

        //注销登录
        \Yii::$app->user->logout();
        return $this->redirect(['login/login']);
/*        var_dump($user);exit;
        $id=$_SESSION['__id'];
        //找到对象
        $model=Admin::findOne(['id'=>$id]);
        //token设置为0
        $model->auth_key=0;
        $model->password_hash=$model->password_hash_repeat=$model->password_hash;
        if($model->save()){
            //注销登录
            $user->logout();
            //提示信息
            $user->setFlash('success','注销成功');
            //跳转到登陆页面
            return $this->redirect(['login/login']);
        }*/
    }
    /**
     * 权限
     */
/*    public function behaviors()
    {
        return [
            'login'=>[
                'class'=>AccessControl::className(),
                'only'=>['login','logout'],//指定那些操作需要使用该过滤器. 缺省only,表示所有操作
                'rules'=>[
                    [
                        'allow'=>true,//是否允许
                        'actions'=>['logout'],//操作
                        'roles'=>['@'],//角色 @已认证(登录)用户
                    ],
                    [
                        'allow'=>true,
                        'actions'=>['login'],
                        'roles'=>['?'],//? 未认证(未登录)用户
                    ],
                ],
            ],
        ];
    }*/
    /**
     * 显示后台首页
     */
    public function actionIndex()
    {
        return $this->render('index');
    }

    /**
     * 测试
     */
    public function actionTest()
    {

        var_dump(\Yii::$app->request->cookies);
//        var_dump(\Yii::$app->user->autoRenewCookie);
        echo '<br>';
//        var_dump(\Yii::$app->user->identity->username);
    }
}