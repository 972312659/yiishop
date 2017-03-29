<h1>brand</h1>
<?=\yii\bootstrap\Html::a('添加品牌',['brand/add'],['class'=>'btn btn-success'])?>
<?=\yii\bootstrap\Html::a('回收站',['brand/recycle'],['class'=>'btn btn-danger','style'=>'float:right'])?>

<table class="table table-hover">
    <tr>
        <th>ID</th>
        <th>品牌名</th>
        <th>LOGO</th>
        <th>状态</th>
        <th>操作</th>
    </tr>
    <?php foreach($models as $model):?>
    <tr>
        <td><?=$model->id;?></td>
        <td><?=$model->name;?></td>
        <td><?=\yii\bootstrap\Html::img($model->logo(),['style'=>'max-height:30px']);?></td>
        <td><?=\backend\models\Brand::$status_info[$model->status];?></td>
        <td>
            <?=\yii\bootstrap\Html::a('编辑',['brand/edit','id'=>$model->id],['class'=>'btn btn-info'])?>
            <?=\yii\bootstrap\Html::a('删除',['brand/del','id'=>$model->id],['class'=>'btn btn-danger'])?>
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
?>