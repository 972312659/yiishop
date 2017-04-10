<?php

namespace backend\controllers;

use backend\filters\AccessFilter;
use backend\models\Admin;
use backend\models\AdminSearchForm;
use yii\data\Pagination;
use yii\filters\AccessControl;
use yii\helpers\ArrayHelper;

class AdminController extends \yii\web\Controller
{
    /**
     * 显示管理员列表页面
     * @return string
     */
    public function actionIndex()
    {
        //获取表单对象
        $search=new AdminSearchForm();
        $query=Admin::find();
        //搜索
        $search->search($query);
        //实例化分页对象
        $pager=new Pagination([
            'totalCount'=>$query->count(),//总页数
            'pageSize'=>2,
        ]);
        //实例化表单数据
        $models=$query->limit($pager->limit)->offset($pager->offset)->all();
        //显示列表页面
        return $this->render('index',['search'=>$search,'pager'=>$pager,'models'=>$models]);
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
                //给用户设置角色
                $authManager=\Yii::$app->authManager;
                foreach($model->roles as $role){
                    $authManager->assign($authManager->getRole($role),$model->id);
                }
                \Yii::$app->user->login($model);
                \Yii::$app->session->setFlash('success','恭喜，注册成功！');
                return $this->redirect(['admin/index']);
            }
        }
        //显示添加管理员页面
        return $this->render('add',['model'=>$model]);
    }
    /**
     * 修改用户
     */
    public function actionEdit($id)
    {
        //得到对象
        $model=Admin::findOne(['id'=>$id]);
        $model->password_hash='';
        $model->password_hash_repeat='';
        //回显用户角色
        $authManager=\Yii::$app->authManager;
        $oldRoles=$model->roles=array_keys($authManager->getAssignments($model->id));
        //接收数据，处理数据
        if($model->load(\Yii::$app->request->post())){
            //将密码加密
            $model->password_hash=$model->password_hash_repeat=\Yii::$app->security->generatePasswordHash($model->password_hash);
            //更新时间
            $model->updated_at=time();
            //得到auth_key值
            $model->auth_key=\Yii::$app->security->generateRandomString();
            $model->status=1;
            if($model->validate()){
                //验证数据，保存数据
                $model->save();
                //给用户设置角色
                    //删除用户所有的角色
                    /*foreach($oldRoles as $oldRole){
                        $authManager->revoke($authManager->getRole($oldRole),$model->id);
                    }*/
                    $authManager->revokeAll($model->id);
                    //添加
                    foreach($model->roles as $role){
                        $authManager->assign($authManager->getRole($role),$model->id);
                    }
                \Yii::$app->session->setFlash('success','修改成功！');
                return $this->redirect(['admin/index']);
            }
        }
        //显示添加管理员页面
        return $this->render('add',['model'=>$model]);
    }
    /**
     * 删除用户
     */
    public function actionDel($id)
    {
        //得到对象
        $model=Admin::findOne(['id'=>$id]);
        //删除对象所有的角色
        $authManager=\Yii::$app->authManager;
        /*$roles=array_keys($authManager->getAssignments($model->id));
        foreach($roles as $role){
            $authManager->revoke($authManager->getRole($role),$model->id);
        }*/
        $authManager->revokeAll($model->id);
        //删除对象
        $model->delete();
        \Yii::$app->session->setFlash('success','删除成功！');
        return $this->redirect(['admin/index']);
    }
    /**
     * ACF简单过存取滤器--权限控制
     */
    public function behaviors()
    {
        return [
            'accessFilter'=>[
                'class'=>AccessFilter::className(),
                //指定权限控制的操作
                'only'=>['index','add','edit','del']
            ]

        ];
    }
}
