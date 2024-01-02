<?php defined('BASEPATH') or exit('No direct script access allowed');

class UserController extends CI_Controller
{
    private $func = [];
    public function __construct()
    {
        parent::__construct();
        $this->load->helper(['encrypt', 'str']);
        $this->func[0] = hexa('656E6372797074');
        $this->func[1] = hexa('64656372797074');
    }

    public function check()
    {
        if (!$this->log_access->validate()) {
            http_response_code(401);
            $return = [
                'status' => FALSE,
                'message' => 'Not Authenticated',
            ];
            echo json_encode($return);
            return;
        }

		$this->form_validation->set_rules('username', 'Username', 'required|trim');

		if (!$this->form_validation->run()) {
            http_response_code(500);
            $return = [
                'status' => FALSE,
                'message' => clean(validation_errors()),
            ];
            echo json_encode($return);
            return;
		}

		$username = clean($this->input->post('username'));
        $this->load->model('M_User', 'user', TRUE);
        if (empty($this->user->checkUsername($username))) {
            http_response_code(500);
            $return = [
                'status' => FALSE,
                'message' => 'Username does not exists.',
            ];
            echo json_encode($return);
            return;
        }

        $this->load->library('authenticated');
        $this->authenticated->setAuthToken($username);
        $return = [
            'status' => TRUE,
            'message' => 'Username found.',
        ];
        echo json_encode($return);
        return;
    }

    public function authenticate() {
        if (!$this->log_access->validate()) {
            http_response_code(401);
            $return = [
                'status' => FALSE,
                'message' => 'Not Authenticated',
                'url' => null,
            ];
            echo json_encode($return);
            return;
        }

		$this->form_validation->set_rules('username', 'Username', 'required|trim');
		$this->form_validation->set_rules('token', 'Auth Token', 'required|trim|exact_length[6]|numeric', [
            'exact_length' => '%s is not exists',
            'numeric' => '%s is not exists',
        ]);

		if (!$this->form_validation->run()) {
            http_response_code(500);
            $return = [
                'status' => FALSE,
                'message' => clean(validation_errors()),
                'url' => null,
            ];
            echo json_encode($return);
            return;
		}

		$username = clean($this->input->post('username'));
		$token = clean($this->input->post('token'));
        $this->load->library('authenticated');
        $result = $this->authenticated->verifyAuthToken($username, $token);

		if (!$result['status']) {
            http_response_code(500);
            $return = [
                'status' => FALSE,
                'message' => $result['message'],
                'url' => null,
            ];
            echo json_encode($return);
            return;
		}

		$this->session->set_userdata('auth', $result['record']);

        $return = [
            'status' => TRUE,
            'message' => $result['message'],
            // 'url' => base_url('dashboard'),
        ];
        echo json_encode($return);
        return;
    }
}