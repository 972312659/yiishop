<?php

use yii\db\Migration;

/**
 * Handles the creation of table `menu`.
 */
class m170406_025642_create_menu_table extends Migration
{
    /**
     * @inheritdoc
     */
    public function up()
    {
        $this->createTable('menu', [
            'id' => $this->primaryKey(),
            'parent_id'=>$this->integer()->unsigned()->notNull()->comment('上级id'),
            'name'=>$this->string(30)->comment('名称'),
            'url'=>$this->string(30)->comment('路由'),
            'intro'=>$this->text()->comment('描述')
        ]);
    }

    /**
     * @inheritdoc
     */
    public function down()
    {
        $this->dropTable('menu');
    }
}
