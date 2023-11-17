<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Auth extends Admin_Controller {
  
	public function __construct(){
	  
		parent::__construct();
	}
  
	public function index(){
		try {
			
			$input = $this->input->post();	
	
			$this->data['url'] = $this->input->get('url');	
	
			$this->data['ru_csrf_token_name'] = $this->security->get_csrf_hash();	
			
			if(empty($input)){												
				$this->load->view(strtolower(__CLASS__).'/'.__FUNCTION__,$this->data);
				
			} else {					
	
				$this->form_validation->set_rules('username', 'Tên tài khoản', 'required|trim');
				$this->form_validation->set_rules('password', 'Mật khẩu','required|callback_check_pass['.$input['username'].']');
				if($this->form_validation->run()== FALSE){		
					$this->load->view(strtolower(__CLASS__).'/'.__FUNCTION__,$this->data);
	
				} else {
	
					$user = $this->Users_admin_model->get_one_by(array("username"=>$input['username']));	
					
					$data = array(
									'lastvisited' => $this->data['date_now'],	
									'user_agent'  =>  $this->input->user_agent(),	
									'ip_address'  =>  $this->input->ip_address()	
							);		 
					$this->load->library('ruadmin');
					$user->lastvisited	= $this->ruadmin->vn_date($user->lastvisited);	
					$user->user_agent	= $data['user_agent'];	
					$user->ip_address	= $data['ip_address'];		
					$this->session->set_userdata('auth',$user);						
					$this->Users_admin_model->update($user->id,$data );	
					
					if($this->data['url']) {	
						redirect(base64_decode($this->data['url']));						
					} else {	
						redirect(base_url().$this->data['module'].'/dashboard');						
					}
	
				}
	
			}			
	
		}catch (Exception $e) {
	
			echo $e->getMessage(); die();
	
		}

	}
	/*

	0: đã xoá

	1: bình thường

	-1: đã khoá

	*/

	function check_pass($pwd,$uid){

		$user = $this->Users_admin_model->get_one_by(array("username"=>$uid));

		if(!empty($user)){
			if($user->password == md5(sha1($pwd))){

				switch($user->status){
					case '0':
						$this->form_validation->set_message('check_pass', 'Tài khoản đang bị khóa');
						return FALSE;

					break;

					case '1':	
						return TRUE;
					break;

					case '-1':
						$this->form_validation->set_message('check_pass', 'Tài khoản đã bị xóa');
						return FALSE;
					break;
				}

			}else{
				$this->form_validation->set_message('check_pass', 'Mật khẩu không hợp lệ');
				return FALSE;
			}

		} else {
			$this->form_validation->set_message('check_pass', 'Tên đăng nhập hoặc mật khẩu sai');
			return FALSE;
		}

	}
	
	function logout()
	{
		if($this->session->userdata('auth'))
		{
			unset($_SESSION['cfxmixx']);
			$this->session->unset_userdata('auth');
			redirect(base_url());
		} else {
			redirect(base_url());
		}
	}

}
