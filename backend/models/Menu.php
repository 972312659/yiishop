<?php

namespace backend\models;

use Yii;

/**
 * This is the model class for table "menu".
 *
 * @property integer $id
 * @property string $parent_id
 * @property string $name
 * @property string $url
 * @property string $intro
 */
class Menu extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'menu';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['parent_id'], 'required'],
            [['parent_id'], 'integer'],
            [['intro'], 'string'],
            [['name', 'url'], 'string', 'max' => 30],
            [['name','url'],'unique']
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'parent_id' => '一级分类',
            'name' => '名称',
            'url' => '路由',
            'intro' => '描述',
        ];
    }
    /**
     *建立MENU一级和二级的关系  一对多
     */
    public function getChildren()
    {
        return $this->hasMany(self::className(),['parent_id'=>'id']);
    }
    /**
     * 显示所有的父ID为0的下拉列表
     */
    public static function menuParentId()
    {
        $parentId=['0'=>'一级分类'];
        foreach(self::find()->where(['parent_id'=>0])->all() as $model){
            $parentId[$model->id]=$model->name;
        }
        return $parentId;
    }
    /**
     * 显示列表
     */
    public static function getList()
    {
        $menus=[];
        $models=self::find()->where(['parent_id'=>0])->all();
        foreach($models as $model){
            $menus[]=$model;
            foreach($model->children as $son){
                $son->name='－－'.$son->name;
                $menus[]=$son;
            }
        }
        return $menus;
    }
}
