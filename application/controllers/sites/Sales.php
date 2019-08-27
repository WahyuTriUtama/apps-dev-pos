<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Sales extends MY_Controller 
{
	function __construct()
	{
		parent::__construct();
		
		$this->_page = "Penjualan";
		$this->load->model(['Sales_model' => 'model', 'Item_model']);
		$this->load->library('cart');

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

	public function list_item()
	{
		$itemModel = $this->Item_model->all();

		$result = array
        (
          'draw'                => intval($this->input->get('draw')),
          'recordsTotal'        => $itemModel->num_rows(),
          'recordsFiltered'     => $itemModel->num_rows(),
          'data'                => $itemModel->result_array()
        );

        echo json_encode($result);
	}

	public function list_cart()
	{
		$listContent = $this->cart->contents();

		$cartData = [];
		if ($this->cart->total_items() > 0) {
			foreach ($listContent as $items) {
				$cartData[] = [
					'rowid'		=> $items['rowid'],
					'id' 		=> $items['id'],
					'code'		=> $items['options']['code'],
					'name'		=> $items['name'],
					'price'		=> $this->cart->format_number($items['price']),
					'qty'		=> $items['qty'],
					'uom'		=> $items['options']['uom'],
					'subtotal'	=> $this->cart->format_number($items['subtotal'])
				];
			}
		}
		
		$result = array
        (
          'draw'                => intval($this->input->get('draw')),
          'recordsTotal'        => $this->cart->total_items(),
          'recordsFiltered'     => $this->cart->total_items(),
          'data'                => $cartData
        );

        echo json_encode($result);
	}

	public function add_cart()
	{
		//var_dump($this->cart->get_item('584264c852a9a71285c4fdd3f1418a0a'));exit;
		if ($this->input->is_ajax_request()) {
			$code = $this->input->post('code');

			$itemModel = $this->findItemModel($code);
			
			$data = array(
			        'id'      => $itemModel->id,
			        'qty'     => 1,
			        'price'   => $itemModel->price,
			        'name'    => $itemModel->name,
			        'options' => array('code' => $itemModel->code, 'uom' => $itemModel->uom_code)
			);

			if ($this->cart->insert($data)) {
				$msg = array('msg' => ['success', $this->lang->line('save_success')]);
			} else {
				$msg = array('msg' => ['warning', $this->lang->line('save_failed')]);
			}

			echo json_encode($msg);
		}
	}

	public function remove_cart()
	{
		if ($this->input->is_ajax_request()) {
			$rowid = $this->input->post('rowid');

			if ($this->cart->remove($rowid)) {
				$msg = array('msg' => ['success', $this->lang->line('delete_success')]);
			} else {
				$msg = array('msg' => ['warning', $this->lang->line('delete_failed')]);
			}

			echo json_encode($msg);
		}
	}

	public function total_cart()
	{
		$data = [
			'total' => $this->cart->format_number($this->cart->total())
		];
		echo json_encode($data);
	}

	private function findModel($id='')
	{
		if ($id && intval($id)) {
			if ($model = $this->model->find_where(['id' => $id])) {
				return $model->row();
			}
		}

		$msg = array('msg' => ['danger', 'Item Not Found!']);
		echo json_encode($msg);
	}

	private function findItemModel($code='')
	{
		if ($model = $this->Item_model->find_where(['code' => $code])) {
			return $model->row();
		}

		$msg = array('msg' => ['danger', 'Item Not Found!']);
		echo json_encode($msg);
	}
}