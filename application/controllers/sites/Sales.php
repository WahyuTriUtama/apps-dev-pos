<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Sales extends MY_Controller 
{
	function __construct()
	{
		parent::__construct();
		
		$this->_page = "Penjualan";
		$this->load->model(['Sales_model' => 'model', 'Item_model', 'Customer_model', 'Cash_drawer_model', 'Inventory_model', 'Sales_detail_model', 'User_model']);
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
		foreach ($itemModel->result() as $row) {
			$invModel = $this->Inventory_model->count_qty(['item_id' => $row->id])->row();
			$row->stock = ($invModel->remaining_qty - $this->getCartTmp($row->id));
		}

		$result = array
        (
          'draw'                => intval($this->input->get('draw')),
          'recordsTotal'        => $itemModel->num_rows(),
          'recordsFiltered'     => $itemModel->num_rows(),
          'data'                => $itemModel->result_array()
        );

        echo json_encode($result);
	}

	private function getCartTmp($item_id='')
	{
		$result = 0;
		$listContent = $this->cart->contents();
		if ($this->cart->total_items() > 0) {
			foreach ($listContent as $items) {
				if ($item_id == $items['id']) {
					$result = $items['qty'];
				}
			}
		}

		return $result;
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
		if ($this->input->is_ajax_request()) {
			$code = $this->input->post('code');

			$itemModel = $this->findItemModel($code);

			$invModel = $this->Inventory_model->count_qty(['item_id' => $itemModel->id])->row();
			$stock = ($invModel->remaining_qty - $this->getCartTmp($itemModel->id));
			if ($stock <= 0) {
				$msg = array('msg' => [false, 'Stok tidak tersedia']);
				echo json_encode($msg);
				exit;
			}

			$data = array(
			        'id'      => $itemModel->id,
			        'qty'     => 1,
			        'price'   => $itemModel->price,
			        'name'    => $itemModel->name,
			        'options' => array('code' => $itemModel->code, 'uom' => $itemModel->uom_code)
			);

			if ($this->cart->insert($data)) {
				$msg = array('msg' => [true, $this->lang->line('save_success')]);
			} else {
				$msg = array('msg' => [false, $this->lang->line('save_failed')]);
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

	public function remove_all_cart()
	{
		if ($this->input->is_ajax_request()) {
			if ($this->cart->destroy()) {
				$msg = array('msg' => [true, $this->lang->line('delete_success')]);
			} else {
				$msg = array('msg' => [false, $this->lang->line('delete_failed')]);
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
	//
	public function add_customer()
	{
		if ($this->input->is_ajax_request()) {
			$name = $this->input->post('name');
			$contact = $this->input->post('contact');

			$model = $this->Customer_model->find_where(['contact' => $contact]);
			if ($model->num_rows()) {
				$msg = array('msg' => [false, 'Data pelanggan sudah terdaftar']);
				echo json_encode($msg);
				exit;
			}

			if ($this->Customer_model->save(['name' => $name, 'contact' => $contact])) {
				$msg = array('msg' => [true, $this->lang->line('save_success')]);
			} else {
				$msg = array('msg' => [false, $this->lang->line('save_failed')]);
			}

			echo json_encode($msg);
		}
	}

	//closing
	public function check_closing()
	{
		if ($this->input->is_ajax_request()) {
			$drawer_id = $this->input->post('id_drawer');
			$model = $this->model->total_sales($drawer_id);
			echo json_encode($model->row());
		}
	}

	//save trans
	public function save_trans()
	{
		if ($this->input->is_ajax_request()) {
			$drawer_id = $this->input->post('drawer_id');
			$customer_id = $this->input->post('customer_id');
			//
			$this->db->trans_start();//start commit

			$data = [
				'customer_id' => $customer_id,
				'total_amount' => $this->cart->total(),
				'status'	=> 'posted',
				'user_id'	=> $this->session->userdata('user_id'),
				'drawer_id' => $drawer_id
			];

			$header_id = $this->model->save($data);

			$listContent = $this->cart->contents();

			$lineData = [];
			$invData = [];
			if ($this->cart->total_items() > 0) {
				foreach ($listContent as $items) {
					$lineData[] = [
						'sales_id'	  => $header_id,
						'item_id' 	  => $items['id'],
						'price'		  => $items['price'],
						'qty'		  => $items['qty'],
						'total_price' => $items['subtotal']
					];

					$invData[] = [
						'entry_type' => 'Sales',
						'entry_date' => date('Y-m-d'),
						'item_id'	=> $items['id'],
						'unit_cost'	=> 0,
						'qty'		=> $items['qty']*(-1),
						'remaining_qty'	=> $items['qty']*(-1),
						'description'	=> $items['name'],
						'open'			=> 1,
						'source_doc'	=> $header_id,
						'user_id'		=> $this->session->userdata('user_id'),
					];
				}
			}

			$this->Sales_detail_model->save_batch($lineData); //sales detail
			$this->Inventory_model->save_batch($invData); //inventori

			$this->db->trans_complete(); //push

			if ($this->db->trans_status() === FALSE)
			{
				$msg = array('msg' => [false, $this->lang->line('save_failed')]);
			} else {
				$this->cart->destroy();
				$msg = array('msg' => [true, $this->lang->line('save_success'), $header_id]);
			}

			echo json_encode($msg);
		}
	}

	public function print($id='')
	{
		$model = $this->findModelPrint($id);
		$detailModel = $this->Sales_detail_model->find_where(['sales_id' => $id]);
		$totalQty = $this->Sales_detail_model->total_qty(['sales_id' => $id])->qty;

		$this->load->view($this->cls_path.'/sales/print_nota',[
			'model' => $model,
			'detailModel' => $detailModel, 
			'qty'	=> $totalQty
		]);
	}

	private function findModelPrint($id='')
	{
		if ($id && intval($id)) {
			if ($this->model->find_where(['id' => $id])->num_rows()) {
				$model = $this->model->find_where(['id' => $id]);
				return $model->row();
			}
		}

		show_404();
	}
}