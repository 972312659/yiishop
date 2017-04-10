<?php
/* @var $this yii\web\View */
?>

<div class="main w1210 bc mt10">
    <div class="crumb w1210">
        <h2><strong>我的XX </strong><span>> 我的订单</span></h2>
    </div>

    <!-- 左侧导航菜单 start -->
    <div class="menu fl">
        <h3>我的XX</h3>
        <div class="menu_wrap">
            <dl>
                <dt>订单中心 <b></b></dt>
                <dd><b>.</b><a href="">我的订单</a></dd>
                <dd><b>.</b><a href="">我的关注</a></dd>
                <dd><b>.</b><a href="">浏览历史</a></dd>
                <dd><b>.</b><a href="">我的团购</a></dd>
            </dl>

            <dl>
                <dt>账户中心 <b></b></dt>
                <dd class="cur"><b>.</b><a href="">账户信息</a></dd>
                <dd><b>.</b><a href="">账户余额</a></dd>
                <dd><b>.</b><a href="">消费记录</a></dd>
                <dd><b>.</b><a href="">我的积分</a></dd>
                <dd><b>.</b><a href="">收货地址</a></dd>
            </dl>

            <dl>
                <dt>订单中心 <b></b></dt>
                <dd><b>.</b><a href="">返修/退换货</a></dd>
                <dd><b>.</b><a href="">取消订单记录</a></dd>
                <dd><b>.</b><a href="">我的投诉</a></dd>
            </dl>
        </div>
    </div>
    <!-- 左侧导航菜单 end -->

    <!-- 右侧内容区域 start -->
    <div class="content fl ml10">
        <div class="address_hd">
            <h3>收货地址薄</h3>
            <?php foreach($models as $v):?>
                <dl>
                    <dt>
                        <?php
                        echo $v->id.'.'.$v->name.'&emsp;'.$v->province.'&emsp;'.$v->city.'&emsp;'.$v->area.'&emsp;'.$v->details.'&emsp;'.$v->tel
                        ?>
                    </dt>
                    <dd>
                        <?=\yii\helpers\Html::a('修改',['user-address/edit','id'=>$v->id])?>
                        <?=\yii\helpers\Html::a('删除',['user-address/del','id'=>$v->id])?>
                        <?php if($v->status){
                            echo \yii\helpers\Html::a('取消默认地址',['user-address/clear-default','id'=>$v->id]);
                        }else{
                            echo \yii\helpers\Html::a('设为默认地址',['user-address/set-default','id'=>$v->id]);
                        }?>
                    </dd>
                </dl>
            <?php endforeach;?>
        </div>

        <div class="address_bd mt10">
            <h4>新增收货地址</h4>

            <?php $form=\yii\widgets\ActiveForm::begin();
//            $span='<span>*</span>';
            ?>
                <ul>
                    <?php
                    echo $form->field($model,'name',[
                        'options'=>['tag'=>'li'],
                        'template'=>"{label}\n{input}\n{hint}\n{error}",
                        'errorOptions'=>['tag'=>'span']
                    ])->textInput(['class'=>'txt']);

                    echo $form->field($model,'province')->hiddenInput(['id'=>'province']);
                    echo $form->field($model,'city')->hiddenInput(['id'=>'city']);
                    echo $form->field($model,'area')->hiddenInput(['id'=>'area']);
                    ?>
                    <li id="select">
                        <label for=""><span>*</span>所在地区：</label>
                        <select id="Select1"></select>
                        <select id="Select2"></select>
                        <select id="Select3"></select>
                    </li>
                    <?php
                    echo $form->field($model,'details',[
                        'options'=>['tag'=>'li'],
                        'template'=>"{label}\n{input}\n{hint}\n{error}",
                        'errorOptions'=>['tag'=>'span']
                    ])->textInput(['class'=>'txt address']);

                    echo $form->field($model,'tel',[
                        'options'=>['tag'=>'li'],
                        'template'=>"{label}\n{input}\n{hint}\n{error}",
                        'errorOptions'=>['tag'=>'span']
                    ])->textInput(['class'=>'txt']);
                    echo $form->field($model,'status',[
                        'options'=>['tag'=>'li'],
                        'template'=>"{label}\n{input}\n{hint}\n{error}",
                        'errorOptions'=>['tag'=>'span']
                    ])->checkbox(['class'=>'check']);
                    echo '<li>'.\yii\helpers\Html::submitButton('保存',['class'=>'btn btn-default']).'</li> ';
                    ?>
                </ul>
            <?php \yii\widgets\ActiveForm::end();?>
        </div>

    </div>
    <!-- 右侧内容区域 end -->
</div>
<?php
$this->registerJsFile('@web/js/jsAddress.js');
$js=<<<ADRRESS
	addressInit('Select1', 'Select2', 'Select3');

    $('#select').on('change','#Select1',function(){
        $('#province').val($(this).val());
        $('#city').val($('#Select2').find('option:selected').text());
        $('#area').val($('#Select3').find('option:selected').text());
    })
    $('#select').on('change','#Select2',function(){
            $('#city').val($(this).val());
            $('#area').val($('#Select3').find('option:selected').text());
        })
    $('#select').on('change','#Select3',function(){
            $('#area').val($(this).val());
        })
ADRRESS;
$this->registerJs($js);

