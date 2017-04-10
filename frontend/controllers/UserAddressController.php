<?php

namespace frontend\controllers;

use frontend\models\Cities;
use frontend\models\UserAddress;


class UserAddressController extends \yii\web\Controller
{
    public $layout='nomal';

    /**
     * 显示收货地址列表页面
     * @return string|\yii\web\Response
     */
    public function actionIndex()
    {
        //实例化活动记录模型
        $model=new UserAddress();
        //处理数据
        if($model->load(\Yii::$app->request->post()) && $model->validate()){
            //得到用户id
            $model->member_id=\Yii::$app->user->identity->getId();
            //保存数据
            $model->save();
            //如果设置默认地址，则跳转到修改默认地址
            if($model->status){
                return $this->redirect(['user-address/set-default?id='.$model->id]);
            }
            return $this->refresh();
        }
        $models=UserAddress::find()->all();
        //显示地址页面
        return $this->render('index',['model'=>$model,'models'=>$models]);
    }
    /**
     * 修改信息
     */
    public function actionEdit($id)
    {
        //实例化活动记录模型
        $model=UserAddress::findOne(['id'=>$id]);
        //处理数据
        if($model->load(\Yii::$app->request->post()) && $model->validate()){
            $model->save();
            //如果设置默认地址，则跳转到修改默认地址
            if($model->status){
                return $this->redirect(['user-address/set-default?id='.$model->id]);
            }
            return $this->redirect(['user-address/index']);
        }
        //显示地址页面
        return $this->render('edit',['model'=>$model]);
    }
    /**
     * 修改默认地址
     */
    public function actionSetDefault($id)
    {
        //将其他默认地址设置为非默认地址
        if($old=UserAddress::findOne(['status'=>1])){
            $old->status=0;
            $old->save();
        }
        //设置默认地址
        $model=UserAddress::findOne(['id'=>$id]);
        $model->status=1;
        $model->save();
        return $this->redirect(['user-address/index']);
    }
    /**
     * 取消默认地址
     */
    public function actionClearDefault($id)
    {
        $model=UserAddress::findOne(['id'=>$id]);
        $model->status=0;
        $model->save();
        return $this->redirect(['user-address/index']);
    }

    /**
     * 删除一条地址数据
     */
    public function actionDel($id)
    {
        $model=UserAddress::findOne(['id'=>$id]);
        $model->delete();
        return $this->redirect(['user-address/index']);
    }
}
