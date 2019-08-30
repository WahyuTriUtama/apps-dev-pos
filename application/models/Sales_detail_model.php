<?php defined('BASEPATH') OR exit('No direct script access allowed');

class Sales_detail_model extends CI_Model 
{
	public $table = "sales_detail";

	public function query($params)
	{
		return $this->db->select("{$this->table}.*, sales.code, sales.document_date, sales.customer_name, user.name")
						->join('sales', "{$this->table}.sales_id=sales.id", 'left')
						->join('user', "sales.user_id=user.id", 'left')
						->where($params)
						->get($this->table);
	}

	public function total_qty($params)
	{
		return $this->db->select("IF(SUM(qty) > 0, SUM(qty), 0) as qty")
						->join('sales', "{$this->table}.sales_id=sales.id", 'left')
						->where($params)
						->get($this->table)
						->row();
	}

	public function all()
	{
		return $this->db->get($this->table);
	}

	public function find_where($params)
	{
		return $this->db->get_where($this->table, $params);
	}

	public function save($data=array(), $id='')
	{
		if (isset($id) && $id) {
			return $this->db->update($this->table, $data, array('id' => $id));
		}
		
		$this->db->insert($this->table, $data);
		return $this->db->insert_id();

	}

	public function save_batch($data='')
	{
		return $this->db->insert_batch($this->table, $data);
	}

	public function delete($id='')
	{
		return $this->db->delete($this->table, array('id' => $id)); 
	}
}