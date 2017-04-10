<h2>角色列表</h2>
<table class="table table-hover">
    <tr>
        <th>名称</th>
        <th>描述</th>
        <th>权限</th>
        <th>操作</th>
    </tr>
    <?php foreach($models as $model):?>
    <tr>
        <td><?=$model->name?></td>
        <td><?=$model->description?></td>
        <td><?=\backend\models\RoleForm::getPermissions($model->name)?></td>
        <td>
            <?=\yii\bootstrap\Html::a('编辑',['rbac/role-edit','name'=>$model->name],['class'=>'btn btn-default'])?>
            <?=\yii\bootstrap\Html::a('删除',['rbac/role-del','name'=>$model->name],['class'=>'btn btn-danger'])?>
        </td>
    </tr>
    <?php endforeach;?>
</table>