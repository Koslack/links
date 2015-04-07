<?php

use Phinx\Migration\AbstractMigration;

class CreateLookupTable extends AbstractMigration
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
        $lookup = $this->table('lookup');
        $lookup->addColumn('type', 'string', ['limit' => 128])
            ->addColumn('code', 'integer')
            ->addColumn('value', 'string', ['length' => 128])
            ->save();

    }

    /**
     * Migrate Down.
     */
    public function down()
    {
        $this->dropTable('lookup');
    }
}