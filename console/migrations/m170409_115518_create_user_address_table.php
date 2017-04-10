<?php

use yii\db\Migration;

/**
 * Handles the creation of table `user_address`.
 */
class m170409_115518_create_user_address_table extends Migration
{
    /**
     * @inheritdoc
     */
    public function up()
    {
        $this->createTable('user_address', [
            'id' => $this->primaryKey(),
            'member_id'=>$this->integer()->notNull()->comment('用户id'),
            'name'=>$this->string(30)->comment('收货人'),
            'provinces_id'=>$this->integer()->notNull()->comment('省id'),
            'cities_id'=>$this->integer()->notNull()->comment('市id'),
            'areas_id'=>$this->integer()->notNull()->comment('区域id'),
            'details'=>$this->text()->comment('详情'),
            'tel'=>$this->char(11)->comment('手机号码'),
        ]);
    }

    /**
     * @inheritdoc
     */
    public function down()
    {
        $this->dropTable('user_address');
    }
}
