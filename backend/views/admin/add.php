<?php
$form=\yii\bootstrap\ActiveForm::begin();
echo $form->field($model,'username');
echo $form->field($model,'password_hash_repeat')->passwordInput();
echo $form->field($model,'password_hash')->passwordInput();
echo $form->field($model,'email');
echo $form->field($model,'roles')->checkboxList(\backend\models\Admin::rolesOption());
echo \yii\bootstrap\Html::submitButton('提交',['class'=>'btn btn-info']);
\yii\bootstrap\ActiveForm::end();