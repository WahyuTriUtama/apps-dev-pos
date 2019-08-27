<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Cash_drawer extends MY_Controller 
{
	function __construct()
	{
		parent::__construct();
		
		$this->_page = "Kas";
		$this->load->model(['Cash_drawer_model' => 'model']);
		$this->breadcrumbs->push("Dashboard", $this->cls_path.'/home');
		$this->breadcrumbs->push("Riwayar", $this->controller_id);
		$this->breadcrumbs->push($this->_page, $this->controller_id.'#');
	}

	public function index()
	{
		$model = $this->model->query();
		
		$this->show('index', [
			'model' => $model
		]);
	}
}