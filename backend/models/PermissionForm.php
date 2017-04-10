<?php
/**
 * Created by PhpStorm.
 * User: 邓伟
 * Date: 2017/4/5
 * Time: 10:13
 */

namespace backend\models;


use yii\base\Model;

class PermissionForm extends Model
{
    public $name;//名称
    public $description;//描述

    /**
     * 自定义规则
     */
    public function rules()
    {
        return [
            [['name','description'],'required'],
            [['name'],'validateUnique']
        ];
    }

    /**
     * 属性名称
     */
    public function attributeLabels()
    {
        return [
            'name'=>'名称(路由)',
            'description'=>'描述'
        ];
    }
    /**
     * 自定义验证 唯一性方法
     */
    public function validateUnique($attribute,$pramas)
    {
        $authManager=\Yii::$app->authManager;
        if($authManager->getPermission($this->$attribute)){
            $this->addError($attribute,'权限已存在');
        }
    }
}