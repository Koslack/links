<?php

use Phinx\Migration\AbstractMigration;

class CreateLinksTable extends AbstractMigration
{
    /**
     * Change Method.
     *
     * More information on this method is available here:
     * http://docs.phinx.org/en/latest/migrations.html#the-change-method
     *
     * Uncomment this method if you would like to use it.
     *
    public function change()
    {
    }
    */
    
    /**
     * Migrate Up.
     */
    public function up()
    {
        $links = $this->table('links', ['id' => false, 'primary_key' => ['link_id']]);
        $links->addColumn('link_id', 'integer')
            ->addColumn('name', 'string', ['limit' => 128])
            ->addColumn('uri', 'string', ['limit' => 128])
            ->addColumn('status_code', 'integer')
            ->save();
    }

    /**
     * Migrate Down.
     */
    public function down()
    {
        $this->dropTable('links');
    }
}