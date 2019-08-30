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

	public function check_cash()
	{
		if ($this->input->is_ajax_request()) {
			$user_id = $this->session->userdata('user_id');
			$model = $this->model->find_where(['user_id' => $user_id]);
			if ($model->num_rows()) {
				if ($model->last_row()->doc_type == "close") {
					$msg = array('msg' => [true, []]);
					echo json_encode($msg);
				} else {
					$msg = array('msg' => [false, $model->last_row()]);
					echo json_encode($msg);
				}
			} else {
				$msg = array('msg' => [true, []]);
				echo json_encode($msg);
			}
		}
	}

	public function open_kasir()
	{
		if ($this->input->is_ajax_request()) {
			$amount = $this->input->post('amount');

			$user_id = $this->session->userdata('user_id');
			$model = $this->model->find_where(['user_id' => $user_id]);
			if ($model->num_rows() && $model->last_row()->doc_type == "close") {
				$data = [
					'doc_type' 	=> 'open',
					'doc_date'	=> date('Y-m-d'),
					'amount'	=> $amount,
					'user_id'	=> $user_id 
				];

				if ($this->model->save($data)) {
					$msg = array('msg' => [true, 'Berhasil! Kasir sudah bisa transaksi']);
					echo json_encode($msg);
				} else {
					$msg = array('msg' => [false, $this->lang->line('save_failed')]);
					echo json_encode($msg);
				}
				exit;
			}

			$msg = array('msg' => [false, 'Kasir sudah open']);
			echo json_encode($msg);
		}
	}

	public function close_kasir()
	{
		if ($this->input->is_ajax_request()) {
			$amount = $this->input->post('amount');
			$total = $this->input->post('total');

			$user_id = $this->session->userdata('user_id');
			$model = $this->model->find_where(['user_id' => $user_id]);
			if ($model->num_rows() && $model->last_row()->doc_type == "open") {
				$data = [
					'doc_type' 	=> 'close',
					'doc_date'	=> date('Y-m-d'),
					'total_sales' => $total,
					'amount'	=> $amount,
					'user_id'	=> $user_id 
				];

				if ($this->model->save($data)) {
					$msg = array('msg' => [true, $this->lang->line('save_success')]);
					echo json_encode($msg);
				} else {
					$msg = array('msg' => [false, $this->lang->line('save_failed')]);
					echo json_encode($msg);
				}
				exit;
			}

			$msg = array('msg' => [false, 'Kasir sudah close']);
			echo json_encode($msg);
		}
	}
}