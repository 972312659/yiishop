<?php

namespace backend\controllers;

use backend\filters\AccessFilter;
use backend\models\Article;
use backend\models\ArticleDetail;
use yii\data\Pagination;
use yii\filters\AccessControl;

class ArticleController extends \yii\web\Controller
{
    public function actionIndex()
    {
        //实例化查询对象
        $query=Article::find();
        //实例化分页对象
        $pager=new Pagination([
            'totalCount'=>$query->count(),//总页数
            'pageSize'=>2,
        ]);
        //实例化表单数据
        $models=$query->limit($pager->limit)->offset($pager->offset)->all();
//        var_dump($models);exit;
        //显示品牌列表页面
        return $this->render('index',['pager'=>$pager,'models'=>$models]);
    }
    /**
     * 添加文章
     */
    public function actionAdd()
    {
        //实例化数据表单
        $model=new Article();
        $request = \Yii::$app->request;
        if($request->isPost){
            //post方式接收数据
            $model->load($request->post());
            //给文章内容对象的属性赋值并保存
            $detail=new ArticleDetail();
            $detail->content=$model->content;
            if($model->validate() && $detail->validate()){
                $model->save();
                $detail->article_id=$model->id;
                $detail->save();
                //添加成功提示信息，跳转到列表页面
                \Yii::$app->session->setFlash('success','添加成功');
                return $this->redirect(['article/index']);

            }
        }
        //显示添加页面
        return $this->render('add',['model'=>$model]);
    }
    /**
     * 修改文章
     */
    public function actionEdit($id)
    {
        //找到对象
        $model=Article::findOne(['id'=>$id]);
        //$content=ArticleDetail::findOne(['article_id'=>$id])->content;
        $model->content=$model->articleDetail->content;
        $request = \Yii::$app->request;
        if($request->isPost){
            //post方式接收数据
            $model->load($request->post());
            //给文章内容对象的属性赋值并保存
            $detail=ArticleDetail::findOne(['article_id'=>$id]);
            $detail->content=$model->content;
            if($model->validate() && $detail->validate()){
                $model->save();
                $detail->save();
                //添加成功提示信息，跳转到列表页面
                \Yii::$app->session->setFlash('success','添加成功');
                return $this->redirect(['article/index']);
            }
        }
        //显示添加页面
        return $this->render('add',['model'=>$model]);
    }
    /**
     * 删除文章
     */
    public function actionDel($id){
        //找到对象
        $article=Article::findOne(['id'=>$id]);
        $articleDetail=ArticleDetail::findOne(['article_id'=>$id]);
        //删除对象
        $article->delete();
        $articleDetail->delete();
        //提示信息，跳转到列表页面
        \Yii::$app->session->setFlash('success','添加成功');
        return $this->redirect(['article/index']);
    }
    /**
     * ACF简单过存取滤器
     */
    public function behaviors()
    {
        return [
            'ACF'=>[
                'class'=>AccessFilter::className(),
                'only'=>['index','add','edit','del'],
            ]
        ];
    }
}
