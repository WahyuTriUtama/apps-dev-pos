<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Sales_history extends MY_Controller 
{
	function __construct()
	{
		parent::__construct();
		
		$this->_page = "Penjualan";
		$this->load->model(['Sales_model' => 'model']);
		$this->breadcrumbs->push("Dashboard", $this->cls_path.'/home');
		$this->breadcrumbs->push("Riwayat", $this->controller_id);
		$this->breadcrumbs->push($this->_page, $this->controller_id.'#');
	}

	public function index()
	{
		$model = $this->model->all();
		
		$this->show('index', [
			'model' => $model
		]);
	}
}