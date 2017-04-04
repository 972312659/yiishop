<?php

namespace backend\controllers;

use backend\models\GoodsCategory;
use yii\db\Exception;

class GoodsCategoryController extends \yii\web\Controller
{
    public function actionIndex()
    {
        //得到所有数据对象
        $models=GoodsCategory::find()->orderBy('tree,lft')->all();
        //显示页面
        return $this->render('index',['models'=>$models]);
    }

    /**
     * 添加分类
     */
    public function actionAdd()
    {
        $model=new GoodsCategory();
        //以POST接收数据并验证通过
        if($model->load(\Yii::$app->request->post()) && $model->validate()){
            if($model->parent_id==0){
                $model->makeRoot();
            }else{
                $model->prependTo(GoodsCategory::findOne(['id'=>$model->parent_id]));
            }
            \Yii::$app->session->setFlash('success','添加成功');
            return $this->redirect(['goods-category/index']);
        }
        $models=GoodsCategory::find()->asArray()->all();
        $models[]=['id'=>0,'name'=>'顶级分类','parent_id'=>0];
        $models=json_encode($models);
        //显示添加页面
        return $this->render('add',['model'=>$model,'models'=>$models]);
    }
    /**
     * 添加分类
     */
    public function actionEdit($id)
    {
        $model=GoodsCategory::findOne(['id'=>$id]);
        //以POST接收数据并验证通过
        if($model->load(\Yii::$app->request->post()) && $model->validate()){
            try{
                if($model->parent_id==0){
                    $model->makeRoot();
                }
                $model->prependTo(GoodsCategory::findOne(['id'=>$model->parent_id]));
                \Yii::$app->session->setFlash('success','添加成功');
                return $this->redirect(['goods-category/index']);
            }catch (Exception $info){
                //提示错误信息
//                \Yii::$app->session->setFlash('danger',$info->getMessage());
                $model->addError('parent_id',$info->getMessage());
//                var_dump($info->getMessage());
            }

        }
        $models=GoodsCategory::find()->asArray()->all();
        $models[]=['id'=>0,'name'=>'顶级分类','parent_id'=>0];
        $models=json_encode($models);
        //显示添加页面
        return $this->render('add',['model'=>$model,'models'=>$models]);
    }
    /**
     * 删除
     */
    public function actionDel($id)
    {
        //找到对象
        $model=GoodsCategory::findOne(['id'=>$id]);
        //如果下有分支，则不能删除
        if(GoodsCategory::find()->where(['parent_id'=>$model->id])->all()){
            \Yii::$app->session->setFlash('danger','下有分支，不能删除');
            return $this->redirect(['goods-category/index']);
        }
        //如果下面没有分支，则能够删除
        $model->delete();
        //跳转到列表页面
        \Yii::$app->session->setFlash('success','删除成功');
        return $this->redirect(['goods-category/index']);
    }
    /**
     *测试
     * @return string
     */
    public function actionTest(){
        $countries = new GoodsCategory(['name' => '家用电器','parent_id'=>0,'tree'=>0]);
        $countries->makeRoot();
//        var_dump($countries->getErrors());exit;
        $russia1 = new GoodsCategory(['name' => '大家电','parent_id'=>1]);
        $russia1->prependTo($countries);
        $russia2 = new GoodsCategory(['name' => '小家电','parent_id'=>1]);
        $russia2->prependTo($countries);
//        return $this->renderPartial('test');
    }
}
