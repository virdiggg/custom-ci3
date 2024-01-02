<?php defined('BASEPATH') or exit('No direct script access allowed');

class Authenticated
{
    /**
     * Instance CI
     * 
     * @return object
     */
	private $CI;

	/**
	 * Hexaed
	 * 
	 * @param array
	 */
    private $func = [];

	public function __construct()
	{
		$this->CI = &get_instance();

        $this->CI->load->helper(['encrypt', 'str']);
        $this->func[0] = hexa('656E6372797074');
        $this->func[1] = hexa('64656372797074');
        $this->func[2] = hexa('636F6E66');
        $this->func[3] = hexa('73657373');
	}

    /**
     * Verify if user has session
     * 
     * @return bool
     */
    public function authenticated() {
        if (empty($this->func[3]('auth')) || $this->func[3]('auth') === false) {
            return false;
        }

        return true;
    }

    /**
     * Verify if user has token session
     * 
     * @param string $input
     * 
     * @return bool
     */
    public function authenticateToken($input) {
        if (empty($this->func[3]('token')) || $this->func[3]('token') === false) {
            return false;
        }

        if (empty($this->func[3]('expired_at')) || $this->func[3]('expired_at') === false) {
            return false;
        }

        if (date('Y-m-d H:i') > $this->func[3]('expired_at')) {
            return false;
        }

        return $input === $this->func[3]('token');
    }

    /**
     * Generate Access Token
     * 
     * @return string
     */
    public function generateToken() {
        $this->CI->load->helper('string');
        return random_string('numeric', 6);
    }

    /**
     * Template Token Auth
     * 
     * @param string $token
     * 
     * @return void
     */
    private function templateAuthToken($token) {
        return "AUTH TOKEN LOGIN ANDA \n\n*" . $token . "*\n\nBERLAKU UNTUK *2* MENIT. JANGAN BERIKAN KE SIAPA-SIAPA.";
    }

    /**
     * Setup Auth Token
     * 
     * @param string $username
     * 
     * @return void
     */
    public function setAuthToken($username) {
        $token = $this->generateToken();
		$this->CI->session->set_userdata('token', $token);
        $this->CI->load->model('M_User', 'user', TRUE);

        $param = $this->func[0](['token' => $token, 'expired_at' => date('Y-m-d H:i', strtotime('+2 minutes'))]);
        $user = $this->CI->user->setToken($username, $param);

        $this->CI->load->library('Wablas');
        $this->CI->wablas->sendWA($this->templateAuthToken($token), $user->phone);
    }

    /**
     * Setup Auth Token
     * 
     * @param string $username
     * 
     * @return array
     */
    public function verifyAuthToken($username, $token) {
        $this->CI->load->model('M_User', 'user', TRUE);
        $user = $this->CI->user->checkUsername($username);
        if (empty($user)) {
            return [
                'status' => false,
                'message' => 'User not found.',
                'record' => null,
            ];
        }

        $this->CI->user->destroyToken($username);

        $result = $this->func[1]($user['token']);
        if (date('Y-m-d H:i') > $result['expired_at']) {
            return [
                'status' => false,
                'message' => 'Token is expired.',
                'record' => null,
            ];
        }

        if ($token !== $result['token']) {
            return [
                'status' => false,
                'message' => 'Token does not exists.',
                'record' => null,
            ];
        }

        unset($result['token']);
        return [
            'status' => true,
            'message' => 'Token is exists.',
            'record' => $user,
        ];
    }

    /**
     * Verify if user has session
     * 
     * @return void|redirect
     */
    public function checkAuth() {
        if (!$this->authenticated()) {
            return redirect(base_url());
        }

        return;
    }

    /**
     * Destroy all session
     * 
     * @return void
     */
    public function signOut() {
		$this->CI->session->unset_userdata('canLogin');
        $this->CI->session->unset_userdata('canOpenLogs');
        $this->CI->session->unset_userdata('auth');
        $this->CI->session->unset_userdata('version');
        $this->destroyToken();
    }

    /**
     * Destroy session token
     * 
     * @return void
     */
    public function destroyToken() {
        $this->CI->session->unset_userdata('token');
        $this->CI->session->unset_userdata('expired_at');
    }
}