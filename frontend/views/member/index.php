<?php
/* @var $this yii\web\View */
?>
<h1>member/index</h1>

<p>
    You may change the content of this page by modifying
    the file <code><?= __FILE__; ?></code>.
</p>

<?php foreach($models as $model):?>
<?=$model->username?>
<?php endforeach;?>
