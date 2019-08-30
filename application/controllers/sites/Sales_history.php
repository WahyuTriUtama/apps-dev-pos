<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Sales_history extends MY_Controller 
{
	function __construct()
	{
		parent::__construct();
		
		$this->_page = "Penjualan";
		$this->load->model(['Sales_model' => 'model', 'Sales_detail_model', 'Customer_model', 'User_model']);
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

	public function view($id='')
	{
		$model = $this->findModel($id);
		$model->contact = $this->Customer_model->find_where(['id' => $model->customer_id])->row()->contact;
		$model->kasir = $this->User_model->find_where(['id' => $model->user_id])->row()->name;
		$detailModel = $this->Sales_detail_model->find_where(['sales_id' => $id]);
		$this->show('form', [
			'model' => $model,
			'detailModel' => $detailModel
		]);
	}

	private function findModel($id='')
	{
		if ($id && intval($id)) {
			if ($model = $this->model->find_where(['id' => $id])) {
				return $model->row();
			}
		}

		show_404();
	}
}