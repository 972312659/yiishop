<?php
/**
 * Created by PhpStorm.
 * User: 邓伟
 * Date: 2017/4/3
 * Time: 10:25
 */

namespace backend\models;


use yii\base\Model;
use yii\db\ActiveQuery;

class GoodsSearchForm extends Model
{
    public $name;
    public $sn;
    public $minPrice;
    public $maxPrice;

    public function rules()
    {
        return [
            [['name','sn'],'string'],
            [['minPrice','maxPrice'],'double'],
        ];
    }
    public function attributeLabels()
    {
        return [
            'name'=>'',
            'sn'=>'',
            'minPrice'=>'',
            'maxPrice'=>'',
        ];
    }
    /**
     * 搜索
     */
    public function search(ActiveQuery $query)
    {
        $this->load(\Yii::$app->request->get());
        if($this->name){
            $query->andWhere(['like','name',$this->name]);
        }
        if($this->sn){
            $query->andWhere(['like','sn',$this->sn]);
        }
        if($this->minPrice){
            $query->andWhere(['>=','shop_price',$this->minPrice]);
        }
        if($this->maxPrice){
            $query->andWhere(['<=','shop_price',$this->maxPrice]);
        }
    }
}