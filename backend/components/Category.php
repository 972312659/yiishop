<?php
/**
 * Created by PhpStorm.
 * User: 邓伟
 * Date: 2017/3/30
 * Time: 15:01
 */

namespace backend\components;


use yii\db\ActiveQuery;
use creocoder\nestedsets\NestedSetsQueryBehavior;
class Category extends ActiveQuery
{
    public function behaviors() {
        return [
            NestedSetsQueryBehavior::className(),
        ];
    }
}