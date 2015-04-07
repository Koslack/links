<?php

use Phinx\Migration\AbstractMigration;

class UpdateLinksTable extends AbstractMigration
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
        $links = $this->table('links');
        $links->renameColumn('link_id', 'id');
    }

    /**
     * Migrate Down.
     */
    public function down()
    {
        $links = $this->table('links');
        $links->renameColumn('id', 'link_id');
    }
}