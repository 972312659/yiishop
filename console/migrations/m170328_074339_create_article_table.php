<?php

use yii\db\Migration;

/**
 * Handles the creation of table `article`.
 */
class m170328_074339_create_article_table extends Migration
{
    /**
     * @inheritdoc
     */
    public function up()
    {
        $this->createTable('article', [
            'id' => $this->primaryKey(),
            'name'=>$this->string(50)->notNull()->comment('文章分类名'),
            'article_category_id'=>$this->integer()->unsigned()->notNull()->comment('文章分类'),
            'intro'=>$this->text()->comment('简介'),
            'status'=>$this->integer(1)->notNull()->defaultValue(1)->comment('状态'),
            'sort'=>$this->integer()->notNull()->defaultValue(20)->comment('排序'),
            'inputtime'=>$this->integer(1)->unsigned()->notNull()->defaultValue(0)->comment('录入时间'),
        ]);
    }

    /**
     * @inheritdoc
     */
    public function down()
    {
        $this->dropTable('article');
    }
}
