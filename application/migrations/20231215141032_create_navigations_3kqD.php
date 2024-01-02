<?php defined('BASEPATH') OR exit('No direct script access allowed');

Class Migration_Create_navigations_3kqD extends CI_Migration {
    /**
     * Array table fields.
     * 
     * @param array $fields
     */
    private $fields;

    /**
     * Primary key.
     * 
     * @param array $primary
     */
    private $primary;

    /**
     * Table name.
     * 
     * @param string $name
     */
    private $name;

    public function __construct() {
        parent::__construct();
        $this->name = 'navigations';
        $this->primary = 'id';
        $this->fields = [
            $this->primary => [
                'type' => 'BIGINT',
                'unsigned' => TRUE,
                'auto_increment' => TRUE,
            ],
            'parent_id' => [
                'type' => 'BIGINT',
                'unsigned' => TRUE,
                'null' => TRUE,
            ],
            'name' => [
                'type' => 'VARCHAR',
                'constraint' => 50,
            ],
            'endpoint' => [
                'type' => 'VARCHAR',
                'constraint' => 150,
            ],
            'icon' => [
                'type' => 'VARCHAR',
                'constraint' => 30,
                'null' => TRUE,
            ],
            'permission' => [
                'type' => 'VARCHAR',
                'constraint' => 50,
                'null' => TRUE,
            ],
            'order' => [
                'type' => 'INT',
            ],
            'is_top_nav' => [
                'type' => 'VARCHAR',
                'constraint' => 1,
                'default' => 'N',
            ],
            'is_active' => [
                'type' => 'VARCHAR',
                'constraint' => 1,
                'default' => 'Y',
            ],
            'created_by' => [
                'type' => 'VARCHAR',
                'constraint' => 50,
                'null' => TRUE,
            ],
            'created_at' => [
                'type' => 'TIMESTAMP',
                'null' => TRUE,
            ],
            'updated_by' => [
                'type' => 'VARCHAR',
                'constraint' => 50,
                'null' => TRUE,
            ],
            'updated_at' => [
                'type' => 'TIMESTAMP',
                'null' => TRUE,
            ],
        ];
    }

    /**
     * Migration.
     * 
     * @return void
     */
    public function up() {
        $this->dbforge->add_field($this->fields);
        $this->dbforge->add_key($this->primary, TRUE);
        $this->dbforge->create_table($this->name);
    }

    /**
     * Rollback migration.
     * 
     * @return void
     */
    public function down() {
        $this->dbforge->drop_table($this->name, TRUE);
    }
}