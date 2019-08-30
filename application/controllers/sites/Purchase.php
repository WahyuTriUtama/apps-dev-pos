<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Purchase extends MY_Controller 
{
	function __construct()
	{
		parent::__construct();
		
		$this->_page = "Pembelian";
		$this->load->model(['Purchase_model' => 'model', 'Item_model', 'Vendor_model', 'Purchase_detail_model', 'Inventory_model']);
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

		$detailModel = $this->Purchase_detail_model;
		$this->show('form', [
			'model' => $model,
			'detailModel' => $detailModel
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

			redirect(current_url());
		}
		$detailModel = $this->Purchase_detail_model->find_where(['purchase_id' => $model->id]);
		$this->show('form', [
			'model' => $model,
			'detailModel' => $detailModel
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
		$this->Purchase_detail_model->delete_by_header($id);
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

	public function add_detail($po_id = '')
	{
		if ($this->input->is_ajax_request()) {
			$model = $this->findModel($po_id);

			$req = $this->input->post();
			//var_dump($req);exit;
			$data = [
				'purchase_id' => $po_id,
				'item_id' => $req['item_id'],
				'qty' => $req['qty'],
				'price' => $req['price'],
				'total_price' => $req['total']
			];

			if ($this->Purchase_detail_model->save($data)) {
				$total = $model->total_amount + (int) $data['total_price'];
				$this->model->save(['total_amount' => $total], $po_id);
				echo json_encode(['status' => true, 'eror' => '']);
				exit;
			}

			echo json_encode(['status' => false, 'eror' => 'Gagal menyimpan.']);
		}
	}

	public function item($po_id='')
	{
		if ($this->input->is_ajax_request()) {
			$id = $this->input->post('id');
			//cek
			$detailModel = $this->Purchase_detail_model->find_where(['purchase_id' => $po_id, 'item_id' => $id]);
			if ($detailModel->num_rows() > 0) {
				echo json_encode(['status' => false, 'data' => [], 'eror' => 'Item sudah ada dalam list pembelian ini.']);
				exit;
			}

			if ($model = $this->Item_model->find_where(['id' => $id])) {
				$data = [
					'status' => true,
					'data' => $model->row(),
					'eror' => ''
				];
				echo json_encode($data);
				exit;
			}
			echo json_encode(['status' => false, 'data' => [], 'eror' => 'Item tidak terdaftar']);
		}
	}

	public function item_delete($id='')
	{
		$modelDetail = $this->findModelDetail($id);
		$model = $this->findModel($modelDetail->purchase_id);
		if ($model->status == 'posted') {
			$this->session->set_flashdata('message', ['warning', 'Tidak bisa di delete.']);
			redirect($this->controller_id.'/update/'.$model->id);
			exit;
		}

		$total_price = $modelDetail->total_price;
		if ($this->Purchase_detail_model->delete($id)) {
			$total = $model->total_amount - $total_price;
			$this->model->save(['total_amount' => $total], $model->id);
			$this->session->set_flashdata('message', ['success', $this->lang->line('delete_success')]);
		} else {
			$this->session->set_flashdata('message', ['danger', $this->lang->line('delete_failed')]);
		}

		redirect($this->controller_id.'/update/'.$model->id);
	}

	private function findModelDetail($id='')
	{	
		if ($id && intval($id)) {
			if ($model = $this->Purchase_detail_model->find_where(['id' => $id])) {
				return $model->row();
			}
		}

		show_404();
	}

	public function posting($po_id = '')
	{
		if ($this->input->is_ajax_request()) {
			$model = $this->findModel($po_id);
			$detailModel = $this->Purchase_detail_model->find_where(['purchase_id' => $po_id]);
			if ($detailModel->num_rows() == 0) {
				echo json_encode(['status' => false, 'data' => [], 'eror' => 'Tidak ada item dalam dokumen ini.']);
				exit;
			}

			$data = array();
			foreach ($detailModel->result() as $row) {
				$data[] = [
					'entry_type' => 'Purchase',
					'entry_date' => date('Y-m-d'),
					'item_id'	=> $row->item_id,
					'unit_cost'	=> $row->price,
					'qty'		=> $row->qty,
					'remaining_qty'	=> $row->qty,
					'description'	=> $row->item_name,
					'open'			=> 1,
					'source_doc'	=> $model->id,
					'user_id'		=> $this->session->userdata('user_id'),
				];
			}

			if ($this->Inventory_model->save_batch($data)) {
				$this->model->save(['status' => 'posted'], $po_id);
				echo json_encode(['status' => true, 'eror' => '']);
				exit;
			}

			echo json_encode(['status' => false, 'eror' => 'Gagal menyimpan.']);
		}
	}
}