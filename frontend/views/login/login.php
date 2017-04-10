<div class="login w990 bc mt10">
    <div class="login_hd">
        <h2>用户登录</h2>
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
            $word='<a style="margin-left: 4px">忘记密码?</a>';
            echo $form->field($model,'password',[
                'options'=>['tag'=>'li'],
                'template'=>"{label}\n{input}$word\n{hint}\n{error}",
                'errorOptions'=>['tag'=>'p']
            ])->passwordInput(['class'=>'txt']);
            echo $form->field($model,'captcha',[
                'options'=>['tag'=>'li'],
                'template'=>"{label}\n{input}\n{hint}\n{error}",
                'errorOptions'=>['tag'=>'p']
            ])->widget(\yii\captcha\Captcha::className(),[
                'template'=>'<span>{input}</span><span class="col-lg-1">{image}</span>','class'=>'txt'
            ]);
            echo $form->field($model,'remember',[
                'options'=>['tag'=>'li'],
                'template'=>"{label}\n{input}\n{hint}\n{error}",
                'errorOptions'=>['tag'=>'p']
            ])->checkbox();
            echo '<li><label for="">&nbsp;</label>'.\yii\helpers\Html::submitButton('',['class'=>'login_btn']);
            echo '</li></ul>';
            \yii\widgets\ActiveForm::end();
            ?>

            <div class="coagent mt15">
                <dl>
                    <dt>使用合作网站登录商城：</dt>
                    <dd class="qq"><a href=""><span></span>QQ</a></dd>
                    <dd class="weibo"><a href=""><span></span>新浪微博</a></dd>
                    <dd class="yi"><a href=""><span></span>网易</a></dd>
                    <dd class="renren"><a href=""><span></span>人人</a></dd>
                    <dd class="qihu"><a href=""><span></span>奇虎360</a></dd>
                    <dd class=""><a href=""><span></span>百度</a></dd>
                    <dd class="douban"><a href=""><span></span>豆瓣</a></dd>
                </dl>
            </div>
        </div>

        <div class="guide fl">
            <h3>还不是商城用户</h3>
            <p>现在免费注册成为商城用户，便能立刻享受便宜又放心的购物乐趣，心动不如行动，赶紧加入吧!</p>

            <a href="regist.html" class="reg_btn">免费注册 >></a>
        </div>

    </div>
</div>