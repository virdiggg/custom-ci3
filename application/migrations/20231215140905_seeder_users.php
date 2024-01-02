<?php defined('BASEPATH') OR exit('No direct script access allowed');

Class Migration_Seeder_users extends CI_Migration {
    /**
     * Table name.
     * 
     * @param string
     */
    private $name;

    public function __construct() {
        parent::__construct();
        $this->name = 'users';
    }

    /**
     * Migration.
     * 
     * @return void
     */
    public function up() {
        $this->load->helper('encrypt');
        $date = date('Y-m-d H:i:s');
        $param[] = [
            'username' => 'virdi_it',
            'password' => '$2y$10$vbNR0yfj9zuxaLTwJ2J4euC4NLD2/NDToaUu06UBVmjeHlKpLS30C',
            'created_by' => 'TuhanYME',
            'created_at' => $date,
            'updated_by' => 'virdi_it',
            'updated_at' => $date,
            'phone' => '082122504953',
        ];
        $param[] = [
            'username' => 'Nathan',
            'password' => '$2y$10$LL/2ByHibxdpWd6lJm2FSuhwZHSzei28hLPe8.lJDdOSsyWwi24ri',
            'created_by' => 'TuhanYME',
            'created_at' => $date,
            'updated_by' => 'Nathan',
            'updated_at' => $date,
            'phone' => '087883571661',
        ];
        $param[] = [
            'username' => 'jokoyuana',
            'password' => '$2y$10$QChq0BT.S9.UXh8sLT341usq4VrO3.yMBl9rNBOcxPXrpRMia/rNa',
            'created_by' => 'TuhanYME',
            'created_at' => $date,
            'updated_by' => 'jokoyuana',
            'updated_at' => $date,
            'phone' => '08111205234',
        ];
        $this->db->insert_batch($this->name, $param);
    }

    /**
     * Rollback migration.
     * 
     * @return void
     */
    public function down() {
        //
    }
}
