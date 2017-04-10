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

class AdminSearchForm extends Model
{
    public $name;

    public function rules()
    {
        return [
            [['name'],'string'],
        ];
    }
    public function attributeLabels()
    {
        return [
            'name'=>'',
        ];
    }
    /**
     * 搜索
     */
    public function search(ActiveQuery $query)
    {
        $this->load(\Yii::$app->request->get());
        if($this->name){
            $query->andWhere(['like','username',$this->name]);
        }
    }
}