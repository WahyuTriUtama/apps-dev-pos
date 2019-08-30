<?php defined('BASEPATH') OR exit('No direct script access allowed');

class Dashboard_model extends CI_Model 
{
	public function count_purchase()
	{
		return $this->db->where(['status' => 'open'])
						->count_all_results('purchase');
	}

	public function count_sales()
	{
		return $this->db->where(['document_date' => date('Y-m-d')])
						->count_all_results('sales');
	}

	public function count_customer()
	{
		return $this->db->count_all_results('customer');
	}

	public function count_items()
	{
		return $this->db->count_all_results('item');
	}
}