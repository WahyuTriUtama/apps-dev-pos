<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Report extends MY_Controller 
{
	function __construct()
	{
		parent::__construct();
		
		$this->_page = "Laporan";
		$this->load->model(['Purchase_model', 'Sales_model', 'Item_model', 'Inventory_model', 'User_model', 'Customer_model', 'Sales_detail_model', 'Purchase_detail_model']);
		$this->breadcrumbs->push("Dashboard", $this->cls_path.'/home');
		$this->breadcrumbs->push("Laporan", $this->controller_id);
	}

	public function index()
	{
		$this->purchase();
	}

	public function purchase($print='')
	{
		$this->breadcrumbs->push('Pembelian', $this->controller_id.'#');
		$start = $this->input->get('start');
		$end = $this->input->get('end');

		if (! ($start && $end)) {
			$start = date('Y-m-d');
			$end = date('Y-m-d');
		}

		$total = $this->Purchase_model->total(['document_date >=' => $start, 'document_date <=' => $end])->total;

		if ($print == '') {
			$model = $this->Purchase_model->find_where(['document_date >=' => $start, 'document_date <=' => $end]);
			
			$this->show('purchase', [
				'model' => $model, 
				'total' => $total, 
				'start' => $start,
				'end'	=> $end
			]);
		} else {
			$model = $this->Purchase_detail_model->query(['document_date >=' => $start, 'document_date <=' => $end]);
			$totalQty = $this->Purchase_detail_model->total_qty(['document_date >=' => $start, 'document_date <=' => $end])->qty;

			$this->load->view($this->cls_path.'/report/print_purchase',[
				'model' => $model, 
				'total' => $total, 
				'qty'	=> $totalQty,
				'start' => $start,
				'end'	=> $end
			]);
		}
	}

	public function sales($print="")
	{
		$this->breadcrumbs->push('Penjualan', $this->controller_id.'#');
		$start = $this->input->get('start');
		$end = $this->input->get('end');

		if (! ($start && $end)) {
			$start = date('Y-m-d');
			$end = date('Y-m-d');
		}

		$total = $this->Sales_model->total(['document_date >=' => $start, 'document_date <=' => $end])->total;

		if ($print == '') {
			$model = $this->Sales_model->find_where(['document_date >=' => $start, 'document_date <=' => $end]);

			$this->show('sales', [
				'model' => $model, 
				'total' => $total, 
				'start' => $start,
				'end'	=> $end
			]);
		} else {
			$model = $this->Sales_detail_model->query(['document_date >=' => $start, 'document_date <=' => $end]);
			$totalQty = $this->Sales_detail_model->total_qty(['document_date >=' => $start, 'document_date <=' => $end])->qty;

			$this->load->view($this->cls_path.'/report/print_sales',[
				'model' => $model, 
				'total' => $total, 
				'qty'	=> $totalQty,
				'start' => $start,
				'end'	=> $end
			]);
		}
	}

	public function inventory($print='')
	{
		$this->breadcrumbs->push($this->_page, $this->controller_id.'#');
		$end = $this->input->get('end');

		if (! ($end)) {
			$end = date('Y-m-d');
		}

		$model = $this->Item_model->query();
		foreach ($model->result() as $row) {
			$invModel =$this->Inventory_model->count_qty(['item_id' => $row->id, 'entry_date <=' => $end])->row();
			$row->stock = $invModel->remaining_qty;
		}

		if ($print == '') {
			$this->show('inventory', [
				'model' => $model,
				'end' => $end
			]);
		} else {
			$this->load->view($this->cls_path.'/report/print_inventory',[
				'model' => $model,
				'end' => $end
			]);
		}
	}
}