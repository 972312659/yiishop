<h1>文章列表</h1>
<?=\yii\bootstrap\Html::a('添加文章',['article/add'],['class'=>'btn btn-success'])?>
<table class="table table-hover">
    <tr>
        <th>ID</th>
        <th>文章名</th>
        <th>文章分类</th>
        <th>状态</th>
        <th>添加时间</th>
        <th>操作</th>
    </tr>
    <?php foreach($models as $model):?>
    <tr>
        <td><?=$model->id?></td>
        <td><?=$model->name?></td>
        <td><?=$model->category->name?></td>
        <td><?=\backend\models\Article::$status_info[$model->status]?></td>
        <td><?=date('Y-m-d h:i:s',$model->inputtime)?></td>
        <td>
            <?=\yii\bootstrap\Html::a('查看详情',['articledetail/index','id'=>$model->id],['class'=>'btn btn-info'])?>
            <?=\yii\bootstrap\Html::a('编辑',['article/edit','id'=>$model->id],['class'=>'btn btn-info'])?>
            <?=\yii\bootstrap\Html::a('删除',['article/del','id'=>$model->id],['class'=>'btn btn-danger'])?>
        </td>
    </tr>
    <?php endforeach;?>
</table>
<?php
echo \yii\widgets\LinkPager::widget([
    'pagination'=>$pager,
    'nextPageLabel'=>'下一页',
    'prevPageLabel'=>'上一页',
]);






