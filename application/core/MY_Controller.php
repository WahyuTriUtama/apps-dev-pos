<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class MY_Controller extends CI_Controller 
{
    protected $cls_path = 'sites';
	protected $is_login = null;
    protected $_view = null;
    public $_page = null;
    protected $cls_name = null;
    protected $controller_id = null;
    protected $method_name = null;
    protected $limit = 20;
    protected $data = array();
    //
    protected $_insert_id;

	function __construct()
	{
		parent::__construct();
        if (!$this->session->userdata('is_login')) {
            redirect('site');
        }

		$this->data['cls_path']         = $this->cls_path;
        $this->cls_name                 = strtolower($this->router->class);
        $this->data['cls_name']         = $this->cls_name;

        $this->method_name              = strtolower($this->router->method);
        $this->data['method_name']      = $this->method_name;
        
        $this->controller_id            = $this->cls_path.'/'.$this->cls_name;
        $this->data['controller_id']    = $this->controller_id;

        $this->data['page_limit']       = $this->limit;

	}

	protected function show($view, $data = array(), $return=false)
    {
    	$this->data['_page'] = $this->_page;
        $this->data = array_merge($this->data, $data);
        $this->_content($view);
        return $this->load->view('sites/layout/main', $this->data, $return);
    }

    private function _content($views)
    {
        $arr = explode('/', $views);
        if(count($arr) > 1) {
            if($arr[0] == '') {
                $this->data['content'] = $views;
            }else{
                $this->data['content'] = $this->cls_path . '/' . $views;
            }
        }else{
            $this->data['content'] = $this->controller_id . '/' . $views;
        }

        return $this->data;
    }
}