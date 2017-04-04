<?php
/* @var $this yii\web\View */
?>
<h1><?=$goods->name?></h1>
<?=\yii\bootstrap\Html::a('添加新的图片',['goods-gallery/add','id'=>$goods->id],['class'=>'btn btn-success'])?>
<ul class="list-group">
<?php foreach($models as $model):?>
    <li class="list-group-item">
        <img src="<?=$model->path?>" style="width: 500px"/>
            <span style="float: right">
                <?=\yii\bootstrap\Html::a('编辑',['goods-gallery/edit','id'=>$model->id],['class'=>'btn btn-info'])?>
                <?=\yii\bootstrap\Html::a('删除',['goods-gallery/del','id'=>$model->id],['class'=>'btn btn-danger'])?>
            </span>
    </li>
<?php endforeach;?>
</ul>
