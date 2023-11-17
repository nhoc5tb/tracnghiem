<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class Home_Controller extends CI_Controller {
	public $data;
  
	function __construct(){
		parent::__construct();
		$this->config->load('template');
		$template = $this->config->item('template_name');
		$this->data['interface'] = $template.'/desktop';		
		$this->layout->setLayout($this->data['interface'].'/layout');			
		$this->data['date_now'] = date('Y-m-d H:i:s');	
	}
}
/* End of file Admin_Controller.php */
/* Location: ./application/core/Admin_Controller.php */