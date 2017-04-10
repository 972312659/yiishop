<?php

namespace backend\controllers;

use backend\filters\AccessFilter;
use backend\models\PermissionForm;
use backend\models\RoleForm;
use yii\filters\AccessControl;

class RbacController extends \yii\web\Controller
{
    public function actionIndex()
    {
        return $this->render('index');
    }
    /**
     * 权限列表
     */
    public function actionPermissionIndex()
    {
        $authManager=\Yii::$app->authManager;
        //得到所有权限
        $models=$authManager->getPermissions();
        //显示列表页面
        return $this->render('permission-index',['models'=>$models]);
    }

    /**
     * 创建权限
     */
    public function actionPermissionAdd()
    {
        //实例化表单模型
        $model=new PermissionForm();
        if($model->load(\Yii::$app->request->post()) && $model->validate()){
            $authManager=\Yii::$app->authManager;
            //创建权限
            $permission=$authManager->createPermission($model->name);
            $permission->description=$model->description;
            //添加权限
            if($authManager->add($permission)){
                //显示提示信息，并跳转到列表页面
                \Yii::$app->session->setFlash('success',$permission->description.' 权限创建成功');
                return $this->redirect(['rbac/permission-index']);
            }
        }
        //显示页面
        return $this->render('permission-add',['model'=>$model]);
    }
    /**
     * 删除权限
     */
    public function actionPermissionDel($name)
    {
        $authManager=\Yii::$app->authManager;
        //找到这个权限对象
        $permission=$authManager->getPermission($name);
        //删除该权限
        $authManager->remove($permission);
        //显示提示信息，并跳转到列表页面
        \Yii::$app->session->setFlash('success',$permission->description.' 权限删除成功');
        return $this->redirect(['rbac/permission-index']);
    }
    /**
     * 显示角色列表页面
     */
    public function actionRoleIndex()
    {
        //得到所有的角色
        $authManager=\Yii::$app->authManager;
        $models=$authManager->getRoles();
        //显示页面
        return $this->render('role-index',['models'=>$models]);
    }
    /**
     * 添加角色
     */
    public function actionRoleAdd()
    {
        //得到表单对象
        $model=new RoleForm();
        //选择场景
        $model->scenario=RoleForm::SCENARIO_ADD;
        if($model->load(\Yii::$app->request->post()) && $model->validate()){
            $authManager=\Yii::$app->authManager;
            //创建角色
            $role=$authManager->createRole($model->name);
            $role->description=$model->description;
            //添加角色
            $authManager->add($role);
            //添加角色权限
            foreach($model->permissions as $permission){
                $authManager->addChild($role,$authManager->getPermission($permission));
            }
            //显示提示信息，并跳转到列表页面
            \Yii::$app->session->setFlash('success',$role->name.' 角色创建成功');
            return $this->redirect(['rbac/role-index']);
        }

        //显示页面
        return $this->render('role-add',['model'=>$model]);
    }
    /**
     * 更新角色
     */
    public function actionRoleEdit($name)
    {
        //得到表单对象
        $model=new RoleForm();
        $authManager=\Yii::$app->authManager;
        //回显数据
        $role=$authManager->getRole($name);
        $model->name=$role->name;
        $model->description=$role->description;
        //array_keys数组的键作为数组输出
        $model->permissions=array_keys($authManager->getPermissionsByRole($role->name));
        if($model->load(\Yii::$app->request->post()) && $model->validate()){
            $role->description=$model->description;
            //修改角色描述
            $authManager->update($role->name,$role);
            //更新角色权限
                //删除角色所有的权限
                $authManager->removeChildren($role);
                //添加角色权限
                foreach($model->permissions as $permission){
                    $authManager->addChild($role,$authManager->getPermission($permission));
                }
            //显示提示信息，并跳转到列表页面
            \Yii::$app->session->setFlash('success',$role->name.' 角色更新成功');
            return $this->redirect(['rbac/role-index']);
        }

        //显示页面
        return $this->render('role-add',['model'=>$model]);
    }
    /**
     * 删除角色
     */
    public function actionRoleDel($name)
    {
        //得到该角色
        $authManager=\Yii::$app->authManager;
        $role=$authManager->getRole($name);
        //废除角色
        $authManager->remove($role);
        //显示提示信息，并跳转到列表页面
        \Yii::$app->session->setFlash('success','角色删除成功');
        return $this->redirect(['rbac/role-index']);
    }

    /**
     * ACF简单过存取滤器
     */
    public function behaviors()
    {
        return [
            'ACF'=>[
                'class'=>AccessFilter::className(),
                'only'=>['permission-index','permission-add','permission-del','role-index','role-add','role-edit','role-del'],
            ]
        ];
    }
}
