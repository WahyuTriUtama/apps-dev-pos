<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Income extends MY_Controller 
{
	function __construct()
	{
		parent::__construct();
		
		$this->_page = "Penjualan";
		//$this->load->model([]);
		$this->breadcrumbs->push("Dashboard", $this->cls_path.'/home');
		$this->breadcrumbs->push("Laporan", $this->controller_id);
		$this->breadcrumbs->push($this->_page, $this->controller_id.'#');
	}

	public function index()
	{
		$this->show('index');
	}
}