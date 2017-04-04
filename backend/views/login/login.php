<h3>用户登录</h3><br><br>
<?php
$form=\yii\bootstrap\ActiveForm::begin();
echo $form->field($loginForm,'username')->textInput([
    'style'=>'width:300px','placeholder'=>'用户名/邮箱'
]);
echo $form->field($loginForm,'password')->textInput([
    'style'=>'width:300px','placeholder'=>'密码'
]);
echo $form->field($loginForm,'rememberMe')->checkbox();

/*echo $form->field($loginForm,'captchaCode')->widget(\yii\captcha\Captcha::className(),[
    'template'=>'<div class="row"><div class="col-lg-2">{input}</div><div class="col-lg-2">{image}</div></div>']);//验证码*/
echo \yii\bootstrap\Html::submitButton('登录',['class'=>'btn btn-info']);
\yii\bootstrap\ActiveForm::end();