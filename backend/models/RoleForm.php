<?php
/**
 * Created by PhpStorm.
 * User: 邓伟
 * Date: 2017/4/5
 * Time: 10:13
 */

namespace backend\models;


use yii\base\Model;
use yii\helpers\ArrayHelper;

class RoleForm extends Model
{
    public $name;//名称
    public $description;//描述
    public $permissions=[];//权限
    //自定义场景
    const SCENARIO_ADD='add';

    /**
     * 自定义规则
     */
    public function rules()
    {
        return [
            [['name','description'],'required'],
//            [['name'],'validateUnique'],
            [['name'],'validateUnique','on'=>'add'],
            [['permissions'],'safe']
        ];
    }
    /**
     * 自定义场景
     */
    public function scenarios()
    {
        $scenarios=parent::scenarios();
        return ArrayHelper::merge($scenarios,[
            self::SCENARIO_ADD=>['name','description','permission'],
        ]);
    }

    /**
     * 属性名称
     */
    public function attributeLabels()
    {
        return [
            'name'=>'角色名称',
            'description'=>'描述',
            'permissions'=>'权限'
        ];
    }
    /**
     * 自定义验证 唯一性方法
     */
    public function validateUnique($attribute,$pramas)
    {
        $authManager=\Yii::$app->authManager;
        if($authManager->getRole($this->$attribute)){
            $this->addError($attribute,'角色已存在');
        }
    }
    /**
     * 权限选择的数组['name'=>'description']
     */
    public static function permissionOption()
    {
        $authManager=\Yii::$app->authManager;
        //得到所有的权限对象
        $permissions=$authManager->getPermissions();
        return ArrayHelper::map($permissions,'name','description');
    }
    /**
     *显示角色所对应的所有权限
     */
    public static function getPermissions($name)
    {
        $authManager=\Yii::$app->authManager;
        $permissions=[];
        foreach($authManager->getPermissionsByRole($name) as $permission){
            $permissions[]=$permission->description;
        }
        foreach($permissions as $per){
            echo $per.'&ensp;&ensp;';
        }
    }

}