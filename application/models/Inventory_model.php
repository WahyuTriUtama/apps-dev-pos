<?php defined('BASEPATH') OR exit('No direct script access allowed');

class Inventory_model extends CI_Model 
{
	public $table = "inventory";

	public function count_qty($params=array())
	{
		return $this->db->select("IF(sum(remaining_qty) > 0, sum(remaining_qty),0) as remaining_qty")
						->where($params)
						->get($this->table);
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