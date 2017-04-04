<?php

namespace backend\controllers;

use backend\models\Admin;

class AdminController extends \yii\web\Controller
{
    /**
     * 显示管理员列表页面
     * @return string
     */
    public function actionIndex()
    {

        return $this->render('index');
    }
    /**
     * 添加用户
     */
    public function actionAdd()
    {
        //得到表单
        $model=new Admin();
        //接收数据，处理数据
        if($model->load(\Yii::$app->request->post())){
            //将密码加密
            $model->password_hash=$model->password_hash_repeat=\Yii::$app->security->generatePasswordHash($model->password_hash);
            //最后登录时间
            $model->last_login_time=time();
            //最后登录IP$_SERVER["REMOTE_ADDR"]
            $model->last_login_ip=\Yii::$app->request->getUserIP();
            //更新时间
            $model->updated_at=time();
            //得到auth_key值
            $model->auth_key=\Yii::$app->security->generateRandomString();
            $model->created_at=time();
            $model->status=1;
            if($model->validate()){
                //验证数据，保存数据
                $model->save();
                \Yii::$app->user->login($model);
                \Yii::$app->session->setFlash('success','恭喜，注册成功！');
                return $this->redirect(['goods/list']);
            }
        }
        //显示添加管理员页面
        return $this->render('add',['model'=>$model]);
    }

}
