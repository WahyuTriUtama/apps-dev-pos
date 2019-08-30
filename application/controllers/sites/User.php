<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class User extends MY_Controller 
{
	function __construct()
	{
		parent::__construct();
		
		$this->_page = "User";
		$this->load->model('User_model', 'model');
		$this->breadcrumbs->push("Dashboard", $this->cls_path.'/home');
		$this->breadcrumbs->push("Master", $this->controller_id);
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
		unset($data['cpassword']);
		if(isset($model->id) && $model->id) {
    		$data['password'] = $data['password'] == '' ? $model->password : password_hash($data['password'], PASSWORD_DEFAULT);
    	}else{
    		$data['password'] = password_hash($data['password'], PASSWORD_DEFAULT);
    	}

		return $data;
	}

	private function _rules($model, $request)
	{
		//print_r($request);exit;
		$this->form_validation->set_rules('name', ' ', 'trim|required');
		$this->form_validation->set_rules('group', ' ', 'trim|required');
		if (isset($model->id) && $model->id) {
			$this->form_validation->set_rules('username', ' ', 'trim|required');
			if (isset($request['password']) && $request['password'] != '') {
				$this->form_validation->set_rules('password', ' ', 'required');
				$this->form_validation->set_rules('cpassword', ' ', 'matches[password]');
			} 
		} else {
			$this->form_validation->set_rules('username', ' ', 'trim|required|is_unique[user.username]');
			$this->form_validation->set_rules('password', ' ', 'required');
			$this->form_validation->set_rules('cpassword', ' ', 'matches[password]');
		}

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