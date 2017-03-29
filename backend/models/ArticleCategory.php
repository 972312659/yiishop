<?php

namespace backend\models;

use Yii;

/**
 * This is the model class for table "article_category".
 *
 * @property integer $id
 * @property string $name
 * @property string $intro
 * @property integer $status
 * @property integer $sort
 * @property integer $is_help
 */
class ArticleCategory extends \yii\db\ActiveRecord
{
    //状态
    public static $status_info=['1'=>'是','0'=>'否'];
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'article_category';
    }
    /**
     * 建立与Article之间的关系 一对多
     */
    public function getArticles()
    {
        return $this->hasMany(Article::className(),['article_category_id'=>'id']);
    }
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['name'], 'required'],
            [['intro'], 'string'],
            [['status', 'sort', 'is_help'], 'integer'],
            [['name'], 'string', 'max' => 50],
            [['name'],'unique'],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'name' => '文章分类名',
            'intro' => '简介',
            'status' => '状态',
            'sort' => '排序',
            'is_help' => '是否是帮助相关的分类',
        ];
    }
    /**
     * 下拉列表
     */
    public static function select()
    {
        //准备数组
        $arr=[];
        foreach(self::find()->all() as $value){
            $arr[$value->id]=$value->name;
        }
        return $arr;
    }
}
