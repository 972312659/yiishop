<?php
/**
 * @var $this \yii\web\view
 */
use yii\web\JsExpression;
echo '商品名：'.$model->goods->name;
$form=\yii\bootstrap\ActiveForm::begin();
echo $form->field($model,'path')->hiddenInput();
echo \yii\bootstrap\Html::img($model->path,['width'=>'500px','id'=>'img']);

//Remove Events Auto Convert
//外部TAG
echo \yii\bootstrap\Html::fileInput('test', NULL, ['id' => 'test']);
echo \xj\uploadify\Uploadify::widget([
    'url' => yii\helpers\Url::to(['s-upload']),
    'id' => 'test',
    'csrf' => true,
    'renderTag' => false,
    'jsOptions' => [
        'width' => 120,
        'height' => 40,
        'onUploadError' => new JsExpression(<<<EOF
function(file, errorCode, errorMsg, errorString) {
    console.log('The file ' + file.name + ' could not be uploaded: ' + errorString + errorCode + errorMsg);
}
EOF
        ),
        'onUploadSuccess' => new JsExpression(<<<EOF
function(file, data, response) {
    data = JSON.parse(data);
    if (data.error) {
        console.log(data.msg);
    } else {
//        console.log(data.fileUrl);
        //添加的图片显示出来
        $("#img").attr('src',data.fileUrl);
       $("#goodsgallery-path").val(data.fileUrl);      
    }
    
}
EOF
        ),
    ]
]);
echo \yii\bootstrap\Html::submitButton('提交',['class'=>'btn btn-info','id'=>'sMB']);
\yii\bootstrap\ActiveForm::end();
