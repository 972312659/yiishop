<?php

namespace backend\models;

use Yii;
use yii\behaviors\TimestampBehavior;

/**
 * This is the model class for table "article".
 *
 * @property integer $id
 * @property string $name
 * @property string $article_category_id
 * @property string $intro
 * @property integer $status
 * @property integer $sort
 * @property string $inputtime
 */
class Article extends \yii\db\ActiveRecord
{
    //状态属性
    public static $status_info=['1'=>'是','0'=>'否'];
    public $content;
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'article';
    }
    /**
     * 建立与ArticleCategory的关系 一对一
     */
    public function getCategory()
    {
        return $this->hasOne(ArticleCategory::className(),['id'=>'article_category_id']);
    }
    /**
     * 建立与ArticleDetail的关系 一对一
     */
    public function getArticleDetail()
    {
        return $this->hasOne(ArticleDetail::className(),['article_id'=>'id']);
    }
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['name', 'article_category_id','content'], 'required'],
            [['article_category_id', 'status', 'sort', 'inputtime'], 'integer'],
            [['intro'], 'string'],
            [['name'], 'string', 'max' => 50],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'name' => '文章名',
            'article_category_id' => '文章分类',
            'intro' => '简介',
            'status' => '状态',
            'sort' => '排序',
            'inputtime' => '录入时间',
            'content'=>'内容'
        ];
    }
    /**
     * 添加时间
     */
    public function behaviors()
    {
        return [
            'time'=>[
                'class'=>TimestampBehavior::className(),
                'attributes'=>[
                    self::EVENT_BEFORE_INSERT => ['inputtime'],
                ]
            ],
        ];
    }
}
