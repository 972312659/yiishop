<?php

use yii\db\Migration;

/**
 * Handles the creation of table `goods_category`.
 */
class m170329_093447_create_goods_category_table extends Migration
{
    /**
     * @inheritdoc
     */
    public function up()
    {
        $this->createTable('goods_category', [
            'id' => $this->primaryKey(),
            'name'=>$this->string(50)->notNull()->comment('名称'),
            'parent_id'=>$this->integer()->unsigned()->notNull()->comment('父分类'),
            'lft'=>$this->integer()->unsigned()->notNull()->comment('左边界'),
            'rght'=>$this->integer()->unsigned()->notNull()->comment('右边界'),
            'level'=>$this->integer(1)->unsigned()->notNull()->comment('级别'),
            'intro'=>$this->text()->comment('简介'),
        ]);
    }

    /**
     * @inheritdoc
     */
    public function down()
    {
        $this->dropTable('goods_category');
    }
}
