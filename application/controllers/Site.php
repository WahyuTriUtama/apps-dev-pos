<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Site extends CI_Controller {
	
	function __construct()
  	{
  		parent::__construct();
      	$this->load->model(['User_model']);
  	}

	public function index()
	{
		if ($this->session->userdata('is_login')) {
			redirect('sites/home');
		}

		$this->_auth();
		$this->load->view('login');
	}

	private function _auth()
	{
		$username = $this->input->post('username');
		$password = $this->input->post('password');

		$this->form_validation->set_rules('username', ' ', 'trim|required');
		$this->form_validation->set_rules('password', ' ', 'required');
        $this->form_validation->set_error_delimiters('<div class="error text-danger">', '</div>');

        if($this->form_validation->run() == TRUE) {
			if ($this->User_model->validate($username, $password)) {
				$model = $this->User_model->find_where(['username' => $username])->row();
				$data = [
					'is_login' 	=> true,
					'is_admin'	=> true,
					'user_id'	=> $model->id,
					'username'	=> $model->username,
					'name'		=> $model->name,
					'group'		=> $model->group
				];

				$this->session->set_userdata($data);
				$this->session->set_flashdata('message', ['success', 'Hallo '.ucfirst($model->name).' :)']);
				return $this->index();
            }
			$this->session->set_flashdata('failed', 'Wrong username or password!');
        }
	}
}