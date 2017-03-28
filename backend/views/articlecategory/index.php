<h1>文章分类</h1>
<table class="table table-hover">
    <tr>
        <th>ID</th>
        <th>分类名</th>
        <th>状态</th>
        <th>帮助相关的分类</th>
        <th>操作</th>
    </tr>
    <?php foreach ($models as $model):?>
    <tr>
        <td><?=$model->id?></td>
        <td><?=$model->name?></td>
        <td><?=\backend\models\ArticleCategory::$status_info[$model->status]?></td>
        <td><?=\backend\models\ArticleCategory::$status_info[$model->is_help]?></td>
        <td>
            <?=\yii\bootstrap\Html::a('编辑',['articlecategory/edit','id'=>$model->id],['class'=>'btn btn-info'])?>
            <?=\yii\bootstrap\Html::a('编辑',['articlecategory/del','id'=>$model->id],['class'=>'btn btn-danger'])?>
        </td>
    </tr>
    <?php endforeach;?>
</table>