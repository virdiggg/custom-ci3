<?php defined('BASEPATH') OR exit('No direct script access allowed');

Class M_User extends CI_model {
    /**
     * Default table name.
     * 
     * @param string
     */
    private $table = 'users';

    /**
     * DB Connection name.
     * 
     * @param string
     */
    private $conn = 'default';

    /**
     * DB Connection.
     * 
     * @param object
     */
    private $db;

    public function __construct() {
        parent::__construct();
        $this->db = $this->load->database($this->conn, TRUE);
    }

    /**
     * Authenticate user.
     * 
     * @param string $username
     * @param string $password
     * 
     * @return object|null
     */
    public function authenticate($username, $password) {
        $res = $this->db->select('id, username, password, created_at, created_by')->from($this->table)->where('username', $username)->get()->row_array();
        if (!$res) {
            return null;
        }

        if (!password_verify($password, $res['password'])) {
            return null;
        }

        unset($res['password']);
        return $res;
    }

    /**
     * Verify if username is exists.
     * 
     * @param string $username
     * @param string $password
     * 
     * @return object|null
     */
    public function checkUsername($username) {
        if (empty($username)) {
            return null;
        }

        // $this->db->cache_off();
        $res = $this->db->select('id, username, token, phone')->from($this->table)->where('username', $username)->get()->row_array();
        return $res ? $res : null;
    }

    /**
     * Set Auth Token User.
     * 
     * @param string $username
     * @param string $token
     * 
     * @return object
     */
    public function setToken($username, $token) {
        return $this->update($username, ['token' => $token, 'updated_by' => $username]);
    }

    /**
     * Delete Old Token
     * 
     * @param string $username
     * 
     * @return object
     */
    public function destroyToken($username) {
        return $this->update($username, ['token' => null, 'updated_by' => $username]);
    }

    /**
     * Update user row by username
     * 
     * @param string $username
     * @param array  $param
     * 
     * @return object
     */
    public function update($username, $param) {
        // $this->db->cache_off();
        $query = 'UPDATE ' . $this->table . ' SET token = ' . (is_null($param['token']) ? 'NULL' : "'" . $param['token'] . "'").", updated_by = '" . $param['updated_by'] . "', updated_at = NOW() WHERE username = '" . $username . "' RETURNING username, phone;";
        return $this->db->query($query)->row();
    }
}