<?php

use think\migration\Migrator;
use think\migration\db\Column;

class Articles extends Migrator
{
    /**
     * Change Method.
     *
     * Write your reversible migrations using this method.
     *
     * More information on writing migrations is available here:
     * http://docs.phinx.org/en/latest/migrations.html#the-abstractmigration-class
     *
     * The following commands can be used in this method and Phinx will
     * automatically reverse them when rolling back:
     *
     *    createTable
     *    renameTable
     *    addColumn
     *    renameColumn
     *    addIndex
     *    addForeignKey
     *
     * Remember to call "create()" or "update()" and NOT "save()" when working
     * with the Table class.
     */
    public function change()
    {
        // create the table
        $table = $this->table('articles', ['engine' => 'Innodb', 'signed' => false]);

        $table->addColumn('title', 'string', ['limit' => 255, 'null' => false, 'comment' => '文章标题'])
            ->addColumn('description', 'string', ['limit' => 255, 'null' => false, 'comment' => '文章描述'])
            ->addColumn('keywords', 'string', ['limit' => 255, 'null' => false, 'comment' => '文章关键字'])
            ->addColumn('thumbnail', 'string', ['limit' => 255, 'null' => false, 'comment' => '文章缩略图'])
            ->addColumn('content', 'text', ['null' => false, 'comment' => '文章内容'])
            ->addColumn('add_time', 'datetime', ['null' => false, 'comment' => '发布时间'])
            ->addIndex(['title'], ['unique' => false])
            ->addIndex(['keywords'], ['unique' => false])
            ->save();
    }
}
