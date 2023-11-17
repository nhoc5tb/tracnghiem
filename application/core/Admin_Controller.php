<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Admin_Controller extends CI_Controller {
  
  public $data;
  
  function __construct()
  {
    parent::__construct();
	
	$this->load->database();
	//$this->load->library('CI_Minifier');	
	//$this->load->library('cachefile');	
	
	$lang = $this->input->get('lang');
		
	if(!empty($lang)){			
		switch($lang){
			case 'en':
				$this->session->set_userdata('lang','en');					
				break;
			case 'ru':
				$this->session->set_userdata('lang','ru');					
				break;		
			default:
				$this->session->set_userdata('lang','vi');
				break;				
		}
	}
	
	$this->data['ru_csrf_token_name'] = $this->security->get_csrf_hash();

	//$this->load->helper(array('editor_helper'));
	$this->load->library('form_validation');
	$this->config->set_item('language', 'vietnam'); 					
    $this->layout->setLayout('layout');
	
	//config Library
	$this->load->library('ruadmin');
	$this->load->library('rurole');
	
	//config model
	$this->load->model("Users_admin_model");
	$this->load->model("Rurole_model");
	
	$this->data['date_now'] = date("Y-m-d H:i:s");	
	
	//config đường dẫn
	$this->data['module'] = strtolower(MANAGER);	
    $this->data['controller'] = strtolower($this->router->fetch_class());
    $this->data['action'] = strtolower($this->router->fetch_method());

	$this->data['title'] = 'Hệ Quản Trị Cơ Sở Dữ Liệu Website';
	
	$this->session->userdata('auth');
	 
	if($this->data['controller'] != "auth"){		 
		$auth = $this->Users_admin_model->check_login();
		if(!$auth){
			redirect(base_url().$this->data['module'].'/auth?url='.base64_encode(current_url()));
		}else{
			$this->data['auth'] = $auth;
			$this->session->set_userdata('x_upload_image_file_manager',$_SESSION["auth"]->username);
			$this->session->set_userdata('x_upload_image_verify','Max24asd242');
			/*Phân Quyền*/
			$role_config['role_id'] = $auth->roleid;			
			$this->rurole->config($role_config);
			$this->rurole->check();
			/*#Phần Quyền*/
		}
	}
	
	$this->data["v"] = "0.12";
  }
  
}

/* End of file Admin_Controller.php */
/* Location: ./application/core/Admin_Controller.php */