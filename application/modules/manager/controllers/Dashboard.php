<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Dashboard extends Admin_Controller {
  
	public function __construct()
	{
		parent::__construct();
		$this->data["title"] = "Dashboard";
		$this->data['controller_title'] = "Dashboard";
	}
  
	public function index()  {	
		$this->layout->view(strtolower(__CLASS__.'/'.__FUNCTION__),$this->data);
	}

}
