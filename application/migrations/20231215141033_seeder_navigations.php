<?php defined('BASEPATH') or exit('No direct script access allowed');

class Migration_Seeder_navigations extends CI_Migration
{
    /**
     * Table name.
     * 
     * @param string
     */
    private $name;

    public function __construct()
    {
        parent::__construct();
        $this->name = 'navigations';
    }

    /**
     * Migration.
     * 
     * @return void
     */
    public function up()
    {
        $date = date('Y-m-d H:i:s');

        $param = [];
        $param[] = [
            'parent_id' => null,
            'name' => 'Dashboard',
            'endpoint' => 'dashboard',
            'icon' => 'fas fa-tachometer-alt',
            'order' => 1,
            'is_active' => 'Y',
            'is_top_nav' => 'N',
            'created_by' => 'TuhanYME',
            'updated_by' => 'TuhanYME',
            'created_at' => $date,
            'updated_at' => $date,
        ];
        $param[] = [
            'parent_id' => null,
            'name' => 'Sign Out',
            'endpoint' => 'logout',
            'icon' => 'fas fa-sign-out-alt',
            'order' => 2,
            'is_active' => 'Y',
            'is_top_nav' => 'N',
            'created_by' => 'TuhanYME',
            'updated_by' => 'TuhanYME',
            'created_at' => $date,
            'updated_at' => $date,
        ];
        $param[] = [
            'parent_id' => null,
            'name' => 'Home',
            'endpoint' => 'dashboard',
            'icon' => 'fas fa-tachometer-alt',
            'order' => 3,
            'is_active' => 'Y',
            'is_top_nav' => 'Y',
            'created_by' => 'TuhanYME',
            'updated_by' => 'TuhanYME',
            'created_at' => $date,
            'updated_at' => $date,
        ];
        $this->db->insert_batch($this->name, $param);
    }

    /**
     * Rollback migration.
     * 
     * @return void
     */
    public function down()
    {
        $this->db->truncate($this->name);
    }
}
