<?php
/* @var $this yii\web\View */
?>
<h1>menu/index</h1>

<table class="table table-hover table-bordered">
    <tr>
        <th>ID</th>
        <th>名称</th>
        <th>路由</th>
        <th>操作</th>
    </tr>
    <?php foreach($models as $model):?>
    <tr>
        <td><?=$model->id?></td>
        <td><?=$model->name?></td>
        <td><?=$model->url?></td>
        <td>
            <?=\yii\bootstrap\Html::a('编辑',['menu/edit','id'=>$model->id],['class'=>'btn btn-default'])?>
            <?=\yii\bootstrap\Html::a('删除',['menu/del','id'=>$model->id],['class'=>'btn btn-default'])?>
        </td>
    </tr>
    <?php endforeach;?>
</table>