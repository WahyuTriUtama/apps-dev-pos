<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Home extends MY_Controller 
{
	function __construct()
	{
		parent::__construct();

		$this->_page = "Dashboard";
		$this->load->model('Dashboard_model');
		$this->breadcrumbs->push($this->_page, $this->controller_id.'#');
	}

	public function index()
	{
		//$this->load->view('sites/layout/main');

		$this->show('index');
	}

	public function logout()
	{
		$sess_array = $this->session->all_userdata();
        foreach($sess_array as $key =>$val){
            $this->session->unset_userdata($key);
        }

        $this->session->sess_destroy();
        return redirect('/site');
	}
}