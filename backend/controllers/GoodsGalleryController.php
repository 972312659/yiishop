<?php

namespace backend\controllers;

use backend\models\Goods;
use backend\models\GoodsGallery;
use xj\uploadify\UploadAction;
use yii\helpers\ArrayHelper;

class GoodsGalleryController extends \yii\web\Controller
{
    public function actionIndex($id)
    {
        //得到所有goods_id对象
        $models=GoodsGallery::find()->where(['goods_id'=>$id])->all();
        $goods=Goods::findOne(['id'=>$id]);
        //显示页面
        return $this->render('index',['models'=>$models,'goods'=>$goods]);
    }
    public function actionAdd($id)
    {
        //得到表单对象
        $model=new GoodsGallery();
        if($model->load(\Yii::$app->request->post())){
            //得到拼接的字符串
            $imgs=$model->getImgs;
            //将字符串转换成数组
            $imgs=explode(',',$imgs);
            //循环保存数据到数据库
            foreach($imgs as $img){
                $_model=clone $model;
                $_model->goods_id=$id;
                $_model->path=$img;
                if($_model->validate()){
                    $_model->save();
                }
            }
            //提示信息，跳转到商品列表页面
            \Yii::$app->session->setFlash('success','添加成功');
            return $this->redirect(['goods/list']);
        }
        //显示添加商品图片页面
        return $this->render('add',['model'=>$model]);
    }
    /**
     * 修改
     */
    public function actionEdit($id)
    {
        //找到对象
        $model=GoodsGallery::findOne(['id'=>$id]);
        if($model->load(\Yii::$app->request->post()) && $model->validate()){//post接收并更新数据
            $model->save();
            \Yii::$app->session->setFlash('success','更新成功');
            return $this->redirect(['goods-gallery/index?id='.$model->goods_id]);
        }
        //显示页面
        return $this->render('edit',['model'=>$model]);
    }
    /**
     * 删除图片
     */
    public function actionDel($id)
    {
        //找到对象
        $model=GoodsGallery::findOne(['id'=>$id]);
        //删除对象
        $model->delete();
        //提示并跳转到当前列表页面
        \Yii::$app->session->setFlash('success','删除成功');
        return $this->redirect(['goods-gallery/index?id='.$model->goods_id]);
    }
    /**
     * 上传图片
     */
    public function actions() {
        return [
            's-upload' => [
                'class' => UploadAction::className(),
                'basePath' => '@webroot/upload/brand',
                'baseUrl' => '@web/upload/brand',
                'enableCsrf' => true, // default
                'postFieldName' => 'Filedata', // default
                //BEGIN METHOD
                /*'format' => [$this, 'methodName'],*/
                //END METHOD
                //BEGIN CLOSURE BY-HASH
                'overwriteIfExist' => true,
                /* 'format' => function (UploadAction $action) {
                     $fileext = $action->uploadfile->getExtension();
                     $filename = sha1_file($action->uploadfile->tempName);
                     return "{$filename}.{$fileext}";
                 },*/
                //END CLOSURE BY-HASH
                //BEGIN CLOSURE BY TIME
                'format' => function (UploadAction $action) {
                    $fileext = $action->uploadfile->getExtension();
                    $filehash = sha1(uniqid() . time());
                    $p1 = substr($filehash, 0, 2);
                    $p2 = substr($filehash, 2, 2);
                    return "{$p1}/{$p2}/{$filehash}.{$fileext}";
                },
                //END CLOSURE BY TIME
                'validateOptions' => [
                    'extensions' => ['jpg', 'png','gif'],
                    'maxSize' => 1 * 1024 * 1024, //file size
                ],
                'beforeValidate' => function (UploadAction $action) {
                    //throw new Exception('test error');
                },
                'afterValidate' => function (UploadAction $action) {},
                'beforeSave' => function (UploadAction $action) {},
                'afterSave' => function (UploadAction $action) {
                    $action->output['fileUrl']=$action->getWebUrl();
//                    $action->getFilename(); // "image/yyyymmddtimerand.jpg"
//                    $action->getWebUrl(); //  "baseUrl + filename, /upload/image/yyyymmddtimerand.jpg"
//                    $action->getSavePath(); // "/var/www/htdocs/upload/image/yyyymmddtimerand.jpg"
                    //使用七牛云来保存图片
                    /*$qiniu=\Yii::$app->qiniu;//实例化七牛组件
                    $qiniu->uploadFile($action->getSavePath(),$action->getFilename());
                    $url = $qiniu->getLink($action->getFilename());
                    //将图片的地址得到，用来保存到数据库
                    $action->output['fileUrl'] = $url;*/
                },
            ],
        ];
    }
}
