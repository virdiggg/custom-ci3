<?php defined('BASEPATH') OR exit('No direct script access allowed');

Class M_navigations extends CI_model {
    /**
     * Default table name.
     * 
     * @param string $table
     */
    private $table = 'navigations';

    /**
     * DB Connection.
     * 
     * @param object $db
     */
    private $db;

    public function __construct() {
        parent::__construct();
        $this->db = $this->load->database('default', TRUE);
    }

    /**
     * Get all data from database.
     * 
     * @return array
     */
    public function get() {
        $result = $this->db->select('id, parent_id, name, endpoint, icon, permission, order, is_top_nav')
            ->from($this->table)
            ->where('is_active', 'Y')
            ->order_by('order', 'ASC')
            ->get()->result_array();
        return $result ? $result : [];
    }
}