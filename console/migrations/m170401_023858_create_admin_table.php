<?php

use yii\db\Migration;

/**
 * Handles the creation of table `admin`.
 */
class m170401_023858_create_admin_table extends Migration
{
    /**
     * @inheritdoc
     */
    public function up()
    {
        $this->createTable('admin', [
            'id' => $this->primaryKey(),
            'username' => $this->string()->notNull()->unique()->comment('用户名'),
            'auth_key' => $this->string(100)->notNull()->comment('自动登录令牌'),
            'password_hash' => $this->string()->notNull()->comment('密码'),
            'password_reset_token' => $this->string()->unique()->comment('密码重置'),
            'email' => $this->string()->notNull()->unique()->comment('Email'),
            'status' => $this->smallInteger()->notNull()->defaultValue(10)->comment('状态'),
            'created_at' => $this->integer()->notNull()->comment('创建时间'),
            'updated_at' => $this->integer()->notNull()->comment('修改时间'),
            'last_login_time'=>$this->integer()->notNull()->comment('最后登录时间'),
            'last_login_ip'=>$this->string(15)->notNull()->comment('最后登陆IP')
        ]);
    }

    /**
     * @inheritdoc
     */
    public function down()
    {
        $this->dropTable('admin');
    }
}
