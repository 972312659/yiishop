<?php

namespace frontend\models;

use Yii;

use yii\helpers\ArrayHelper;

/**
 * This is the model class for table "user_address".
 *
 * @property integer $id
 * @property integer $member_id
 * @property integer $provinces_id
 * @property integer $cities_id
 * @property integer $areas_id
 * @property string $details
 */
class UserAddress extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'user_address';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [[ 'name','tel','details'], 'required'],
            [['member_id'], 'integer'],
            [['tel'], 'match', 'pattern' => '/^1[3578]\d{9}/'],
            [['details', 'province', 'city', 'area'], 'string'],
            [['status'],'boolean'],
            [['province', 'city', 'area'],'safe']
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'member_id' => '用户id',
            'province' => '',
            'city' => '',
            'area' => '',
            'details' => '详细地址：',
            'tel'=>'手机号码：',
            'name'=>'收货人：',
            'status'=>'设为默认地址'
        ];
    }

}
