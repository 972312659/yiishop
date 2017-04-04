<?php

namespace backend\models;

use Yii;
use yii\behaviors\TimestampBehavior;

/**
 * This is the model class for table "goods".
 *
 * @property integer $id
 * @property string $name
 * @property string $sn
 * @property string $logo
 * @property string $goods_category_id
 * @property string $brand_id
 * @property string $market_price
 * @property string $shop_price
 * @property integer $stock
 * @property integer $is_on_sale
 * @property integer $status
 * @property integer $sort
 * @property integer $inputtime
 */
class Goods extends \yii\db\ActiveRecord
{
    //LOGO图片
    public $logo_file;
    //状态
    public static $is_on=['1'=>'是','0'=>'否'];
    public static $is_normal=['1'=>'正常','0'=>'回收站'];
    //搜索
    public $words;
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'goods';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['name', 'sn', 'logo'], 'required'],
            [['goods_category_id', 'brand_id', 'stock', 'is_on_sale', 'status', 'sort', 'inputtime'], 'integer'],
            [['market_price', 'shop_price'], 'number'],
            [['name'], 'string', 'max' => 50],
            [['sn'], 'string', 'max' => 15],
            [['logo'], 'string', 'max' => 150],
            [['inputtime'],'safe'],
//            [['logo_file'],'file', 'extensions' => ['jpg','gif','png']],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'name' => '名称',
            'sn' => '货号',
            'logo' => '商品LOGO',
            'goods_category_id' => '商品分类',
            'brand_id' => '品牌',
            'market_price' => '市场价格',
            'shop_price' => '本店售价',
            'stock' => '库存',
            'is_on_sale' => '是否上架',
            'status' => '状态',
            'sort' => '排序',
            'inputtime' => '录入时间',
            'logo_file'=>'LOGO',
            'words'=>''
        ];
    }
    /**
     * 自动添加时间
     */
    public function behaviors()
    {
        return [
            'inputtime'=>[
              'class'=>TimestampBehavior::className(),
                'attributes'=>[
                    self::EVENT_BEFORE_INSERT => ['inputtime'],
                ],
            ],
        ];
    }
    /**
     * goods和goods_category关系 一对一
     */
    public function getCategory()
    {
        return $this->hasOne(GoodsCategory::className(),['id'=>'goods_category_id']);
    }
    /**
     * goods和brand关系 一对一
     */
    public function getBrand()
    {
        return $this->hasOne(Brand::className(),['id'=>'brand_id']);
    }
}
