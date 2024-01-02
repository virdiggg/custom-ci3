<?php defined('BASEPATH') OR exit('No direct script access allowed');

Class Migration_Create_users_Ionj extends CI_Migration {
    /**
     * Array table fields.
     * 
     * @param array $fields
     */
    private $fields;

    /**
     * Primary key.
     * 
     * @param array
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
        $this->name = 'users';
        $this->primary = 'id';
        $this->fields = [
            $this->primary => [
                'type' => 'BIGINT',
                'unsigned' => TRUE,
                'auto_increment' => TRUE,
            ],
            'username' => [
                'type' => 'VARCHAR',
                'constraint' => 50,
                'null' => TRUE,
            ],
            'phone' => [
                'type' => 'VARCHAR',
                'constraint' => 20,
            ],
            'password' => [
                'type' => 'VARCHAR',
                'constraint' => 255,
                'null' => TRUE,
            ],
            'token' => [
                'type' => 'VARCHAR',
                'constraint' => 255,
                'null' => TRUE,
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
