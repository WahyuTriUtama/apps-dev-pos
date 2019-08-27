<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Item extends MY_Controller 
{
	function __construct()
	{
		parent::__construct();
		
		$this->_page = "Barang";
		$this->load->model(['Item_model' => 'model', 'Item_category_model', 'Uom_model']);
		$this->breadcrumbs->push("Dashboard", $this->cls_path.'/home');
		$this->breadcrumbs->push("Master", $this->controller_id);
		$this->breadcrumbs->push($this->_page, $this->controller_id.'#');
	}

	public function index()
	{
		$model = $this->model->query();

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

			if ($this->model->save($data)) {
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
		if ($this->model->delete($id)) {
			$this->session->set_flashdata('message', ['success', $this->lang->line('delete_success')]);
		} else {
			$this->session->set_flashdata('message', ['danger', $this->lang->line('delete_failed')]);
		}

		redirect($this->controller_id);
	}

	private function beforeSave($model, $data)
	{
		$uomModel = $this->Uom_model->find_where(['id' => $data['uom_id']])->row();

		$data['uom_code'] = $uomModel->code;

		return $data;
	}

	private function _rules($model, $request)
	{
		if (isset($model->id) && $model->id) {
			if (isset($request['code']) && $model->code != $request['code']) {
				$this->form_validation->set_rules('code', ' ', 'trim|required|max_length[16]|is_unique[item.code]');
			} else {
				$this->form_validation->set_rules('code', ' ', 'trim|required|max_length[16]');
			}
		} else {
			$this->form_validation->set_rules('code', ' ', 'trim|required|max_length[16]|is_unique[item.code]');
		}
		$this->form_validation->set_rules('name', ' ', 'trim|required');
		$this->form_validation->set_rules('uom_id', ' ', 'trim|required|integer');
		$this->form_validation->set_rules('category_id', ' ', 'trim|required|integer');
		$this->form_validation->set_rules('price', ' ', 'trim|required|numeric');

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