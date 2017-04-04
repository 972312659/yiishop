<?php
/**
 * @var $this \yii\web\view
 */
$form=\yii\bootstrap\ActiveForm::begin([
    'method'=>'get',
    'action'=>\yii\helpers\Url::to(['goods/list']),

]);
echo $form->field($search,'name')->textInput(['class'=>'form-control','placeholder'=>'商品名']);
echo $form->field($search,'sn')->textInput(['class'=>'form-control','placeholder'=>'货号']);
echo $form->field($search,'minPrice')->textInput(['class'=>'form-control','placeholder'=>'最低价']);
echo $form->field($search,'maxPrice')->textInput(['class'=>'form-control','placeholder'=>'最高价']);
echo ' <div class="form-group">';
echo \yii\bootstrap\Html::submitButton('搜索',['class'=>'btn btn-default']);
echo '</div>';
\yii\bootstrap\ActiveForm::end();

echo \yii\bootstrap\Html::a('回收站',['goods/recycle'],['class'=>'btn btn-info','style'=>'float:right']);
echo \yii\bootstrap\Html::a('添加商品',['goods/add'],['class'=>'btn btn-success','style'=>'float:right']);
?>
<table class="table table-hover table-bordered">
    <tr>
        <th>ID</th>
        <th>商品名</th>
        <th>货号</th>
        <th>所属分类</th>
        <th>品牌</th>
        <th>市场价格</th>
        <th>本店价格</th>
        <th>库存</th>
        <th>LOGO</th>
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
        <td><?=\yii\bootstrap\Html::img($model->logo,['width'=>50])?></td>
        <td>
            <?=\yii\bootstrap\Html::a('查看图片',['goods-gallery/index','id'=>$model->id],['class'=>'btn btn-default'])?>
            <?=\yii\bootstrap\Html::a('编辑',['goods/edit','id'=>$model->id],['class'=>'btn btn-default'])?>
            <?=\yii\bootstrap\Html::a('删除',['goods/del','id'=>$model->id],['class'=>'btn btn-default'])?>
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
$js=<<<EOD
    $("#w0").addClass('form-inline');
    $("#w0").find('p').remove();
EOD;
$this->registerJs($js);
?>