<?php

namespace backend\controllers;

use backend\models\Brand;
use yii\data\Pagination;
use yii\web\UploadedFile;
use xj\uploadify\UploadAction;
class BrandController extends \yii\web\Controller
{
    /**
     * 显示品牌列表页面
     * @return string
     */
    public function actionIndex()
    {
        //实例化查询对象
        $query=Brand::find()->where(['status'=>['0','1']]);
        //实例化分页对象
        $pager=new Pagination([
            'totalCount'=>$query->count(),//总页数
            'pageSize'=>2,
        ]);
        //实例化表单数据
        $models=$query->limit($pager->limit)->offset($pager->offset)->all();
        //显示品牌列表页面
        return $this->render('index',['pager'=>$pager,'models'=>$models]);
    }
    /**
     * 添加品牌
     */
    public function actionAdd()
    {
        $model=new Brand();
        $request=\Yii::$app->request;
        if($request->isPost){//以POST方式提交
            //接收传值
            $model->load($request->post());
//            $model->logo_file=UploadedFile::getInstance($model,'logo_file');
            //验证接收数据
            if($model->validate()){
                //验证是否上传图片
                /*if($model->logo_file){
                    //图片地址
                    $fileName='upload/brand/'.uniqid().'.'.$model->logo_file->extension;
                    //保存图片
                    if($model->logo_file->saveAs($fileName,false)){
                        $model->logo=$fileName;
                    }
                }*/
                //保存数据，并提示
                $model->save();
                \Yii::$app->session->setFlash('success','添加成功');
                //跳转到品牌列表页面
                return $this->redirect(['brand/index']);
            }
        }
        //显示添加品牌页面
        return $this->render('add',['model'=>$model]);
    }
    /**
     * 修改品牌
     */
    public function actionEdit($id)
    {
        $model=Brand::findOne(['id'=>$id]);
        $request=\Yii::$app->request;
        if($request->isPost){//以POST方式提交
            //接收传值
            $model->load($request->post());
            $model->logo_file=UploadedFile::getInstance($model,'logo_file');
            //验证接收数据
            if($model->validate()){
                //验证是否上传图片
                if($model->logo_file){
                    //图片地址
                    $fileName='upload/brand/'.uniqid().'.'.$model->logo_file->extension;
                    //保存图片
                    if($model->logo_file->saveAs($fileName,false)){
                        $model->logo=$fileName;
                    }
                }
                //保存数据，并提示
                $model->save();
                \Yii::$app->session->setFlash('success','修改成功');
                //跳转到品牌列表页面
                return $this->redirect(['brand/index']);
            }
        }
        //显示添加品牌页面
        return $this->render('add',['model'=>$model]);
    }
    /**
     * 删除品牌 -> 放入回收站
     */
    public function actionDel($id)
    {
        //找到对象
        $model = Brand::findOne(['id' => $id]);
        //删除对象 改变状态
        $model->status='-1';
        $model->save();
        //跳转到列表页面
        return $this->redirect(['brand/index']);
    }
    /**
     * 回收站
     */
    public function actionRecycle()
    {
        //获取数据
        $models=Brand::find()->where(['status'=>'-1'])->all();
        //显示页面
        return $this->render('recycle',['models'=>$models]);
    }
    /**
     * 删除品牌 -> 删除数据
     */
    public function actionDelete($id)
    {
        //找到对象
        $model = Brand::findOne(['id' => $id]);
        //删除对象 改变状态
        $model->delete();
        //跳转到列表页面
        return $this->redirect(['brand/recycle']);
    }
    /**
     * 清空回收站
     */
    public function actionDeletes()
    {
        //找到对象
        $models = Brand::find()->where(['status'=>'-1'])->all();
        //删除对象 改变状态
        foreach($models as $model){
            $model->delete();
        }
        //跳转到列表页面
        return $this->redirect(['brand/recycle']);
    }
    /**
     * 回收站数据复原
     */
    public function actionRecover($id)
    {
        //找到对象
        $model = Brand::findOne(['id' => $id]);
        //删除对象 改变状态
        $model->status='1';
        $model->save();
        //跳转到列表页面
        return $this->redirect(['brand/recycle']);
    }



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
                    $action->output['fileUrl'] = $action->getWebUrl();
                    $action->getFilename(); // "image/yyyymmddtimerand.jpg"
                    $action->getWebUrl(); //  "baseUrl + filename, /upload/image/yyyymmddtimerand.jpg"
                    $action->getSavePath(); // "/var/www/htdocs/upload/image/yyyymmddtimerand.jpg"
                },
            ],
        ];
    }
}
