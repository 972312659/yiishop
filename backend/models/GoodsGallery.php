<?php

namespace backend\models;

use Yii;

/**
 * This is the model class for table "goods_gallery".
 *
 * @property integer $id
 * @property integer $goods_id
 * @property string $path
 */
class GoodsGallery extends \yii\db\ActiveRecord
{
    /**
     * 接收图片数据
     */
    public $getImgs;
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'goods_gallery';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['goods_id'], 'required'],
            [['goods_id'], 'integer'],
            [['path'], 'string', 'max' => 255],
            [['getImgs'],'safe']
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'goods_id' => '商品ID',
            'path' => '商品图片',
            'getImgs' => '商品图片',
        ];
    }
    /**
     * 建立与goods的关系 一对一
     */
    public function getGoods()
    {
        return $this->hasOne(Goods::className(),['id'=>'goods_id']);
    }
}
