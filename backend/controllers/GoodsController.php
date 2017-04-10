<?php

namespace backend\controllers;

use backend\filters\AccessFilter;
use backend\models\Goods;
use backend\models\GoodsCategory;
use backend\models\GoodsDayCount;
use backend\models\GoodsGallery;
use backend\models\GoodsIntro;
use backend\models\GoodsSearchForm;
use xj\uploadify\UploadAction;
use yii\data\Pagination;
use yii\filters\AccessControl;

class GoodsController extends \yii\web\Controller
{
    public function actionIndex()
    {
        return $this->render('index');
    }
    /**
     * 商品列表页面
     */
    public function actionList()
    {
        //获取表单对象
        $search=new GoodsSearchForm();
        $query=Goods::find()->where(['=','status','1']);
        //添加条件
        $search->search($query);
        //实例化分页对象
        $pager=new Pagination([
            'totalCount'=>$query->count(),//总页数
            'pageSize'=>2,
        ]);
        //实例化表单数据
        $models=$query->limit($pager->limit)->offset($pager->offset)->all();
        //显示列表页面
        return $this->render('list',['models'=>$models,'pager'=>$pager,'search'=>$search]);
    }
    /**
     * 添加商品
     */
    public function actionAdd()
    {
        //创建表单对象
        $model=new Goods();
        $intro=new GoodsIntro();
        //商品分类数据
        $goods_categorys=GoodsCategory::find()->asArray()->all();
        $goods_categorys=json_encode($goods_categorys);
        if($model->load(\Yii::$app->request->post()) && $intro->load(\Yii::$app->request->post())){
//            var_dump($_POST);
            //必须是三级分类的分类名才能作为商品分类
            if(GoodsCategory::findOne(['id'=>$model->goods_category_id])->depth!=2){
                \Yii::$app->session->setFlash('danger','商品分类名不正确');
//                $model->addError('goods_category_id','商品分类名不正确');
                return $this->refresh();
            }
            //如果存在则当天的数据对象，则新建一条数据就加一
            if(GoodsDayCount::findOne(['day'=>date('Y-m-d',time())])){
                $dayCount=GoodsDayCount::findOne(['day'=>date('Y-m-d',time())]);
                $dayCount->count+=1;
                $dayCount->save();
            }else {
                //如果没有，则创建一个当天的数据对象
                $dayCount = new GoodsDayCount();
                $dayCount->day = date('Y-m-d', time());
                $dayCount->count = 1;
                $dayCount->save();
            }
            //给货号赋值
            $model->sn=date('Ymd').sprintf("%04d",$dayCount->count);
            //保存商品对象
            if($model->validate()){
                $model->save();
                //保存商品信息对象
                $intro->goods_id=$model->id;
                if($intro->validate()){
                    $intro->save();
                    //提示信息，保存数据
                    \Yii::$app->session->setFlash('success','添加商品成功，继续添加商品图片');
                    return $this->redirect(['goods-gallery/add?id='.$model->id]);
                }
            }

        }
        //显示页面
        return $this->render('add',['model'=>$model,'intro'=>$intro,'goods_categorys'=>$goods_categorys]);

    }
    /**
     * 修改商品
     */
    public function actionEdit($id)
    {
        //创建表单对象
        $model=Goods::findOne(['id'=>$id]);
        $intro=GoodsIntro::findOne(['goods_id'=>$id]);
        //商品分类数据
        $goods_categorys=GoodsCategory::find()->asArray()->all();
        $goods_categorys=json_encode($goods_categorys);
        if($model->load(\Yii::$app->request->post())
            && $intro->load(\Yii::$app->request->post())
            && $model->validate()
            && $intro->validate()){
            //必须是三级分类的分类名才能作为商品分类
            if(GoodsCategory::findOne(['id'=>$model->goods_category_id])->depth!=2){
                \Yii::$app->session->setFlash('danger','商品分类名不正确');
//                $model->addError('goods_category_id','商品分类名不正确');
                return $this->refresh();
            }
            //保存商品对象
            $model->save();
            //保存商品信息对象
            $intro->save();
            //提示信息，保存数据
            \Yii::$app->session->setFlash('success','修改商品成功');
            return $this->redirect(['goods/list']);

        }
        //显示页面
        return $this->render('add',['model'=>$model,'intro'=>$intro,'goods_categorys'=>$goods_categorys]);

    }
    /**
     * 逻辑删除，放入回收站
     */
    public function actionDel($id)
    {
        //找到对象
        $model=Goods::findOne(['id'=>$id]);
        //将状态改为0
        $model->status=0;
        //保存
        $model->save();
        //提示，并跳转到列表页面
        \Yii::$app->session->setFlash('success','已放入回收站');
        return $this->redirect(['goods/list']);
    }
    /**
     * 回收站
     */
    public function actionRecycle()
    {
        //获取表单对象
        $query=Goods::find()->where(['=','status','0']);
        //实例化分页对象
        $pager=new Pagination([
            'totalCount'=>$query->count(),//总页数
            'pageSize'=>2,
        ]);
        //实例化表单数据
        $models=$query->limit($pager->limit)->offset($pager->offset)->all();
        //显示列表页面
        return $this->render('list',['models'=>$models,'pager'=>$pager]);
    }
    /**
     * 彻底删除
     */
    public function actionDelete($id)
    {
        //找到对象
        $model=Goods::findOne(['id'=>$id]);//商品
        $goods_intro=GoodsIntro::findOne(['goods_id'=>$id]);//商品简介
        $goods_gallerys=GoodsGallery::find()->where(['goods_id'=>$id])->all();//商品对应的图片
        //将对象删除
        $model->delete();
        $goods_intro->delete();
        foreach($goods_gallerys as $goods_gallery){
            $goods_gallery->delete();
            $goods_gallery->save();
        }
        //保存
        $model->save();
        $goods_intro->save();
        //提示，并跳转到列表页面
        \Yii::$app->session->setFlash('success','删除成功');
        return $this->redirect(['goods/recycle']);
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
            //ueditor组件配置
            'upload' => [
                'class' => 'kucha\ueditor\UEditorAction',
                'config' => [
                    "imageUrlPrefix"  => "http://admin.yiishop.com",//图片访问路径前缀
                    "imagePathFormat" => "/upload/image/{yyyy}{mm}{dd}/{time}{rand:6}", //上传保存路径
                "imageRoot" => \Yii::getAlias("@webroot"),
                ]
            ]
        ];
    }

    /**
     * ACF简单过存取滤器
     */
    public function behaviors()
    {
        return [
            'ACF'=>[
                'class'=>AccessFilter::className(),
                'only'=>['index','add','edit','del','list','delete','recycle'],
            ]
        ];
    }
}
