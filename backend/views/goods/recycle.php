<?php
echo \yii\bootstrap\Html::a('添加商品',['goods/add'],['class'=>'btn btn-success']);
?>
<table class="table table-hover">
    <tr>
        <th>ID</th>
        <th>商品名</th>
        <th>货号</th>
        <th>所属分类</th>
        <th>品牌</th>
        <th>市场价格</th>
        <th>本店价格</th>
        <th>库存</th>
        <th>上架</th>
        <th>操作</th>
    </tr>
    <?php foreach($models as $model):?>
    <tr>
        <td><?=$model->id?></td>
        <td><?=$model->name?></td>
        <td><?=$model->sn?></td>
        <td><?=$model->category->name?></td>
        <td><?=$model->brand->name?></td>
        <td><?=$model->market_price?></td>
        <td><?=$model->shop_price?></td>
        <td><?=$model->stock?></td>
        <td><?=\backend\models\Goods::$is_on[$model->is_on_sale]?></td>
        <td>
            <?=\yii\bootstrap\Html::a('编辑',['goods/edit','id'=>$model->id],['class'=>'btn btn-info'])?>
            <?=\yii\bootstrap\Html::a('彻底删除',['goods/delete','id'=>$model->id],['class'=>'btn btn-danger'])?>
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