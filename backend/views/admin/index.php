<?php
/* @var $this yii\web\View */
?>
<h1>admin/index</h1>
<?php
$form=\yii\bootstrap\ActiveForm::begin([
    'method'=>'get',
]);
echo $form->field($search,'name')->textInput(['class'=>'form-control','placeholder'=>'员工名字']);
echo ' <div class="form-group">';
echo \yii\bootstrap\Html::submitButton('搜索',['class'=>'btn btn-default']);
echo '</div>';
\yii\bootstrap\ActiveForm::end();
?>
<table class="table table-hover">
    <tr>
        <th>ID</th>
        <th>员工</th>
        <th>权限</th>
        <th>操作</th>
    </tr>
    <?php foreach($models as $model):?>
    <tr>
        <td><?=$model->id?></td>
        <td><?=$model->username?></td>
        <td><?=$model->username?></td>
        <td>
            <?=\yii\bootstrap\Html::a('编辑',['admin/edit','id'=>$model->id],['class'=>'btn btn-default'])?>
            <?=\yii\bootstrap\Html::a('删除',['admin/del','id'=>$model->id],['class'=>'btn btn-default'])?>
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