<?php

  namespace OCA\PeppolNext\Migration;
  
  use OCA\PeppolNext\Db\AS4DirectMapper;

  use Closure;
  use OCP\DB\ISchemaWrapper;
  use OCP\Migration\SimpleMigrationStep;
  use OCP\Migration\IOutput;

  class Version180001Date20221223000000 extends SimpleMigrationStep {

    /**
    * @param IOutput $output
    * @param Closure $schemaClosure The `\Closure` returns a `ISchemaWrapper`
    * @param array $options
    * @return null|ISchemaWrapper
    */
    public function changeSchema(IOutput $output, Closure $schemaClosure, array $options) {
        /** @var ISchemaWrapper $schema */
        $schema = $schemaClosure();

        if (!$schema->hasTable(AS4DirectMapper::DB_NAME)) {
            $table = $schema->createTable(AS4DirectMapper::DB_NAME);
            $table->addColumn('id', 'integer', [
                'autoincrement' => true,
                'notnull' => true,
            ]);
            $table->addColumn('user_id', 'string', [
                'notnull' => true,
                'length' => 200,
            ]);
            $table->addColumn('scheme', 'string', [
                'notnull' => true,
                'length' => 200
            ]);
            $table->addColumn('peppol_id', 'string', [
                'notnull' => true,
                'length' => 200
            ]);
            $table->addColumn('public_key', 'text', [
                'notnull' => true,
                'default' => ''
            ]);

            $table->setPrimaryKey(['id']);
            $table->addIndex(['user_id'], 'user_id_index');
            $table->addIndex(['peppol_id'], 'peppol_id_index');
        }
        return $schema;
    }
}