<h1>回收站</h1>
<?=\yii\bootstrap\Html::a('全部删除',['brand/deletes'],['class'=>'btn btn-danger','style'=>'float: right'])?>
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
            <td><?=\yii\bootstrap\Html::img('@web/'.$model->logo,['style'=>'max-height:30px']);?></td>
            <td><?=\backend\models\Brand::$status_info[$model->status];?></td>
            <td>
                <?=\yii\bootstrap\Html::a('还原',['brand/recover','id'=>$model->id],['class'=>'btn btn-info'])?>
                <?=\yii\bootstrap\Html::a('删除',['brand/delete','id'=>$model->id],['class'=>'btn btn-danger'])?>
            </td>
        </tr>
    <?php endforeach;?>
</table>