<?php

use yii\db\Migration;

/**
 * Handles the creation of table `goods`.
 */
class m170401_015712_create_goods_table extends Migration
{
    /**
     * @inheritdoc
     */
    public function up()
    {
        $this->createTable('goods', [
            'id' => $this->primaryKey(),
            'name'=>$this->string(50)->notNull()->comment('名称'),
            'sn'=>$this->string(15)->notNull()->comment('货号'),
            'logo'=>$this->string(150)->notNull()->comment('商品LOGO'),
            'goods_category_id'=>$this->integer()->unsigned()->defaultValue(0)->notNull()->comment('商品分类'),
            'brand_id'=>$this->integer()->unsigned()->notNull()->defaultValue(0)->comment('品牌'),
            'market_price'=>$this->decimal(10,2)->unsigned()->notNull()->defaultValue(0.00)->comment('市场价格'),
            'shop_price'=>$this->decimal(10,2)->unsigned()->notNull()->defaultValue(0.00)->comment('本店售价'),
            'stock'=>$this->integer()->notNull()->defaultValue(0)->comment('库存'),
            'is_on_sale'=>$this->integer(1)->notNull()->defaultValue(1)->comment('是否上架'),
            'status'=>$this->integer(1)->notNull()->defaultValue(1)->comment('状态'),
            'sort'=>$this->integer()->notNull()->defaultValue(20)->comment('排序'),
            'inputtime'=>$this->integer()->notNull()->defaultValue(0)->comment('录入时间')
        ]);
    }

    /**
     * @inheritdoc
     */
    public function down()
    {
        $this->dropTable('goods');
    }
}
