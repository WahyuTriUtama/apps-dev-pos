<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Purchase extends MY_Controller 
{
	function __construct()
	{
		parent::__construct();
		
		$this->_page = "Pembelian";
		$this->load->model(['Purchase_model' => 'model', 'Item_model', 'Vendor_model']);
		$this->breadcrumbs->push("Dashboard", $this->cls_path.'/home');
		$this->breadcrumbs->push($this->_page, $this->controller_id.'#');
	}

	public function index()
	{
		$model = $this->model->all();
		
		$this->show('index', [
			'model' => $model
		]);
	}

	public function create()
	{
		$this->breadcrumbs->push('Add', $this->controller_id . '/'.$this->method_name);

		$model = $this->model;
		$post = $this->input->post();

		$this->_rules($model, $post);
		if ($this->form_validation->run() == TRUE) {
			$data = $this->beforeSave($model, $post);

			if ($last_id = $this->model->save($data)) {
				$this->session->set_flashdata('message', ['success', $this->lang->line('save_success')]);
			} else {
				$this->session->set_flashdata('message', ['danger', $this->lang->line('save_failed')]);
				redirect(current_url());
			} 

			redirect($this->controller_id.'/update/'.$last_id);
		}

		$this->show('form', [
			'model' => $model
		]);
	}

	public function update($id='')
	{
		$this->breadcrumbs->push('Edit ', $this->controller_id . '/'.$this->method_name.'/'.$id);

		$model = $this->findModel($id);
		$post = $this->input->post();

		$this->_rules($model, $post);
		if ($this->form_validation->run() == TRUE) {
			$data = $this->beforeSave($model, $post);
			if ($this->model->save($data, $id)) {
				$this->session->set_flashdata('message', ['success', $this->lang->line('save_success')]);
			} else {
				$this->session->set_flashdata('message', ['danger', $this->lang->line('save_failed')]);
				redirect(current_url());
			} 

			redirect($this->controller_id);
		}
		
		$this->show('form', [
			'model' => $model
		]);
	}

	public function delete($id='')
	{
		$model = $this->findModel($id);
		if ($model->status == 'posted') {
			$this->session->set_flashdata('message', ['warning', 'Can not deleted!']);
			redirect($this->controller_id);
			exit;
		}

		if ($this->model->delete($id)) {
			$this->session->set_flashdata('message', ['success', $this->lang->line('delete_success')]);
		} else {
			$this->session->set_flashdata('message', ['danger', $this->lang->line('delete_failed')]);
		}

		redirect($this->controller_id);
	}

	private function beforeSave($model, $data)
	{
		$vendorModel = $this->Vendor_model->find_where(['id' => $data['vendor_id']])->row();

		$data['vendor_code'] = $vendorModel->code;
		$data['vendor_name'] = $vendorModel->name;
		$data['user_id']	 = $this->session->userdata('user_id');

		return $data;
	}

	private function _rules($model, $request)
	{
		$this->form_validation->set_rules('vendor_id', ' ', 'trim|required|integer');

		$this->form_validation->set_error_delimiters('<span class="error text-danger">', '</span>');
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