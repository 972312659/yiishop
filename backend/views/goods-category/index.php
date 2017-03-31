<?php
/* @var $this yii\web\View */
?>
<h1>goods-category/index</h1>
<table class="table table-hover">
    <tr>
        <th>ID</th>
        <th>分类名</th>
        <th>操作</th>
    </tr>
    <tbody id="tdy">
    <?php foreach ($models as $model):?>
    <tr data-tree="<?=$model->tree?>" data-lft="<?=$model->lft?>" data-rgt="<?=$model->rgt?>">
        <td><?=$model->id?></td>
        <td>
            <?=str_repeat('－',$model->depth).$model->name?>
            <span class="glyphicon glyphicon-menu-up expand" style="float: right"></span>
        </td>
        <td>
            <?=\yii\bootstrap\Html::a('编辑',['goods-category/edit','id'=>$model->id],['class'=>'btn btn-info'])?>
            <?=\yii\bootstrap\Html::a('删除',['goods-category/del','id'=>$model->id],['class'=>'btn btn-danger'])?>
        </td>
    </tr>
    <?php endforeach;?>
    </tbody>
</table>
<?php
$js=<<<EOD
    $(".expand").click(function(){
        $(this).toggleClass('glyphicon glyphicon-menu-down');
        $(this).toggleClass('glyphicon glyphicon-menu-up');
        var current_lft=$(this).closest("tr").attr("data-lft");//当前左值
        var current_rgt=$(this).closest("tr").attr("data-rgt");//当前右值
        var current_tree=$(this).closest("tr").attr("data-tree");//当前数
        $("#tdy tr").each(function(){
               var lft=$(this).attr("data-lft");
               var rgt=$(this).attr("data-rgt");
               var tree=$(this).attr("data-tree");
               if(lft>current_lft && rgt<current_rgt && tree==current_tree){
                    $(this).slideToggle();
               }
        });
//        console.debug(current_lft);
    });
EOD;
$this->registerJs($js);
