
<div class="login w990 bc mt10 regist">
    <div class="login_hd">
        <h2>用户注册</h2>
        <b></b>
    </div>
    <div class="login_bd">
        <div class="login_form fl">
            <?php
            $form=\yii\widgets\ActiveForm::begin();
            echo '<ul>';
            echo $form->field($model,'username',[
                'options'=>['tag'=>'li'],
                'template'=>"{label}\n{input}\n{hint}\n{error}",
                'errorOptions'=>['tag'=>'p']
            ])->textInput(['class'=>'txt']);
            echo $form->field($model,'password',[
                'options'=>['tag'=>'li'],
                'template'=>"{label}\n{input}\n{hint}\n{error}",
                'errorOptions'=>['tag'=>'p']
            ])->passwordInput(['class'=>'txt']);
            echo $form->field($model,'repassword',[
                'options'=>['tag'=>'li'],
                'template'=>"{label}\n{input}\n{hint}\n{error}",
                'errorOptions'=>['tag'=>'p']
            ])->passwordInput(['class'=>'txt']);
            echo $form->field($model,'email',[
                'options'=>['tag'=>'li'],
                'template'=>"{label}\n{input}\n{hint}\n{error}",
                'errorOptions'=>['tag'=>'p']
            ])->textInput(['class'=>'txt']);
            echo $form->field($model,'tel',[
                'options'=>['tag'=>'li'],
                'template'=>"{label}\n{input}\n{hint}\n{error}",
                'errorOptions'=>['tag'=>'p']
            ])->textInput(['class'=>'txt']);
            $sendMsg='<input type="button" onclick="bindPhoneNum(this)" id="get_captcha" value="获取验证码" style="height: 25px;padding:3px 8px;margin-left: 4px">';
            echo $form->field($model,'msg',[
                'options'=>['tag'=>'li'],
                'template'=>"{label}\n{input}$sendMsg\n{hint}\n{error}",
                'errorOptions'=>['tag'=>'p']
            ])->textInput(['class'=>'txt']);
            echo $form->field($model,'captcha',[
                'options'=>['tag'=>'li'],
                'template'=>"{label}\n{input}\n{hint}\n{error}",
                'errorOptions'=>['tag'=>'p']
            ])->textInput(['class'=>'txt']);
            echo '<label for="">&nbsp;</label>'.\yii\helpers\Html::submitButton('',['class'=>'login_btn']);
            echo '</ul>';
            \yii\widgets\ActiveForm::end();
            ?>



        </div>

        <div class="mobile fl">
            <h3>手机快速注册</h3>
            <p>中国大陆手机用户，编辑短信 “<strong>XX</strong>”发送到：</p>
            <p><strong>1069099988</strong></p>
        </div>

    </div>
</div>
<!--<script type="text/javascript">
    function bindPhoneNum(){
        //启用输入框
        $('#get_captcha').prop('disabled',false);

        var time=30;
        var interval = setInterval(function(){
            time--;
            if(time<=0){
                clearInterval(interval);
                var html = '获取验证码';
                $('#get_captcha').prop('disabled',false);
            } else{
                var html = time + ' 秒后再次获取';
                $('#get_captcha').prop('disabled',true);
            }

            $('#get_captcha').val(html);
        },1000);
    }
</script>-->