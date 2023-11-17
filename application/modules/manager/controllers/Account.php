<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Account extends Admin_Controller {
  
	public function __construct()
	{
		parent::__construct();
		$this->data['controller_title'] = "Quản Trị viên";
		$this->load->model('users_admin_model');
	}
	
	public function index()
	{
		$this->data['title'] = "Danh sách tài khoản quản trị";
		
		$this->data['getcsdl'] = $this->Users_admin_model->get_by(array("roleid > "=>"1","status >= "=>"0"));
		$getcsdl = $this->data['getcsdl'];
		foreach($getcsdl as $key=>$row){
			$group_role = $this->Rurole_model->role_group_getfull($this->data['getcsdl'][$key]->roleid);
			if($group_role)
				$this->data['getcsdl'][$key]->roleid = $group_role->role_name;
			else
				$this->data['getcsdl'][$key]->roleid = NULL;
		}
		$this->layout->view(strtolower($this->data['controller']).'/'.strtolower($this->data['action']),$this->data);
	}
	
	public function add()
	{
		$this->data['title'] = "Thêm Quản Trị Viên";
		
		$this->data['role_group'] = $this->Rurole_model->role_group_getmenu();
		$this->form_validation->set_rules('username', 'Tên đăng nhập', 'trim|required|callback_username_check');		
		$this->form_validation->set_rules('name', 'Tên hiển thị', 'trim|required|callback_name_check');
		$this->form_validation->set_rules('password', 'Mật khẩu', 'required|min_length[6]|max_length[100]|matches[password_c]');
		$this->form_validation->set_rules('password_c', 'Mật khẩu', 'required');
		$this->form_validation->set_rules('email', 'E mail', 'trim|valid_email|required|callback_email_check');
		$this->form_validation->set_rules('phone', 'Điện thoại', 'trim');
		$this->form_validation->set_rules('roleid', 'Nhóm quản lý', 'trim|required|callback_roleid_check');
		
		if($this->form_validation->run()== TRUE){			
			
			$setcsdl = array(
							'username'    => set_value('username'),
							'name'        => set_value('name'),
							'avatar'      => "avatar5.png",
							'password'    => md5(sha1( set_value('password') )),
							'email'       => set_value('email'),
							'phone'       => set_value('phone'),
							'roleid'      => set_value('roleid'),
							'user_agent'  => $this->input->user_agent(),	
							'ip_address'  => $this->input->ip_address(),
							'created'     => $this->data['date_now'],
							'status'      => 1,
							'created_by'  => $this->data['auth']->username							
						);
						
			if( $this->users_admin_model->insert($setcsdl) ){
				$this->ruadmin->create_foder("upload/dataimg/".$setcsdl["username"]);			
				redirect($this->data['module'].'/'.$this->data['controller']);				
			}
		}
		
		$this->layout->view(strtolower($this->data['controller']).'/'.strtolower($this->data['action']),$this->data);
	}
	
	public function edit($id)
	{
		$this->data["getcsdl"] = $this->Users_admin_model->get($id);
		
		if(!$this->data["getcsdl"]) show_404();
		
		if($this->data["getcsdl"]->roleid == 1) show_404();
		
		$this->data['title'] = "Cập Nhật Thông Tin Quản Trị Viên : ".$this->data["getcsdl"]->name;
		
		$this->data['role_group'] = $this->Rurole_model->role_group_getmenu();
		
		$this->form_validation->set_rules('username', 'Tên đăng nhập', 'trim');		
		$this->form_validation->set_rules('status', 'Trạng thái', 'trim');	
		$this->form_validation->set_rules('name', 'Tên hiển thị', 'trim|required|callback_name_check');
		
		$pw = $this->input->post('password');
		if(!empty($pw)){
			$this->form_validation->set_rules('password', 'Mật khẩu', 'required|min_length[6]|max_length[100]|matches[password_c]');
			$this->form_validation->set_rules('password_c', 'Xác Nhận Mật khẩu', 'required');
		}
		
		if($this->input->post('email') != $this->data['getcsdl']->email)
			$this->form_validation->set_rules('email', 'E mail', 'trim|valid_email|required|callback_email_check');
		else
			$this->form_validation->set_rules('email', 'E mail', 'trim');
		
		$this->form_validation->set_rules('phone', 'Điện thoại', 'trim');
		$this->form_validation->set_rules('roleid', 'Nhóm quản lý', 'trim|required|callback_roleid_check');
		
		if($this->form_validation->run()== TRUE){			
			
			$setcsdl = array(
							'name'        => set_value('name'),
							'avatar'      => "avatar5.png",
							'email'       => set_value('email'),
							'phone'       => set_value('phone'),
							'roleid'      => set_value('roleid'),
							'user_agent'  => $this->input->user_agent(),	
							'ip_address'  => $this->input->ip_address(),
							'modified'    => $this->data['date_now'],
							'status'      => set_value('status'),
							'modified_by'  => $this->data['auth']->username							
						);
			
			if(!empty( $pw )){
				$setcsdl['password'] = md5(sha1( set_value('password') ));
			}
						
			if( $this->Users_admin_model->update($id,$setcsdl) ){	
				$this->ruadmin->create_foder("upload/dataimg/".$this->data["getcsdl"]->username);			
				redirect($this->data['module'].'/'.$this->data['controller']);				
			}
		}
		
		$this->layout->view(strtolower($this->data['controller']).'/'.strtolower($this->data['action']),$this->data);
	}
  
	public function profile()
	{
		$this->data['title'] = "Cấu hình tài khoản ".$this->data['auth']->username;
		
		$this->data['getcsdl'] = $this->Users_admin_model->get($this->data['auth']->id);
		
		$input = $this->input->post();
		
		if($input){
		
			$this->form_validation->set_rules('password_old', 'Mật khẩu xác nhận', 'required|callback_password_check');
			$this->form_validation->set_rules('name', 'Tên hiển thị', 'trim|required|min_length[3]|max_length[100]|callback_name_check');
			
			$pw = $this->input->post('password');
			if(!empty($pw)){
				$this->form_validation->set_rules('password', 'Password', 'required|min_length[6]|max_length[100]|matches[password_c]');
				$this->form_validation->set_rules('password_c', 'Confirm Password', 'required');
			}
			
			if($this->input->post('email') != $this->data['getcsdl']->email)
				$this->form_validation->set_rules('email', 'E mail', 'trim|valid_email|required|callback_email_check');
			else
				$this->form_validation->set_rules('email', 'E mail', 'trim');
				
			$this->form_validation->set_rules('phone', 'Điện thoại', 'trim');
			
			if($this->form_validation->run()== TRUE){
				$setcsdl = array(
							'name' => set_value('name'),
							'email' => set_value('email'),
							'phone' => set_value('phone'),
							'modified'     => $this->data['date_now'],
							'modified_by'  => $this->data['auth']->username	
				);
				
				if(!empty( $pw )){
					$setcsdl['password'] = md5(sha1( $pw ));
				}
				
				if($this->Users_admin_model->update($this->data['auth']->id,$setcsdl)){				
					redirect($this->data['module'].'/'.$this->data['controller']."/profile?r=".rand());				
				}
			}	
		}
		$this->layout->view(strtolower(__CLASS__.'/'.__FUNCTION__),$this->data);
	}
	
	function password_check($str){

		$getbyid = $this->Users_admin_model->get($this->data['auth']->id);
		
		if ($getbyid->password != md5(sha1($str))){
			$this->form_validation->set_message('password_check', 'Mật khẩu không đúng.');
			return FALSE;
		}else{
			return TRUE;
		}

	}
	
	public function delete(){	  
		$json = array("status"=>404,"msg"=>"Lỗi thực hiện lệnh","callback"=>"");
		$this->form_validation->set_rules('id', 'ID', 'trim|is_natural_no_zero|required');
		if($this->form_validation->run() == TRUE){
			$id = set_value('id');
			$data = $this->Users_admin_model->get_one_by(array('id'=>$id));			
			if ($data) {
				if($this->Users_admin_model->delete_by( array('id'=>$id) )){
					$json = array("status"=>200,"msg"=>"Bạn vừa xóa một mục","callback"=>$data->id);
				}
			}else{
				$json["msg"] = "Mục xóa không tồn tại";
			}
		}	
		$this->output->set_content_type('application/json')->set_output(json_encode($json));
	}
		
	public function status(){
			$json = array("status"=>404,"msg"=>"Lỗi thực hiện lệnh","callback"=>"");
			$this->form_validation->set_rules('id', 'ID', 'trim|is_natural_no_zero|required');
			if($this->form_validation->run() == TRUE){
				$id = set_value('id');
				$data = $this->Users_admin_model->get_one_by(array('id'=>$id));			
				if ($data) {
					if($data->status == 1)
						$setdata = array('status'=> 0);
					else
						$setdata = array('status'=> 1);
				
					if($this->Users_admin_model->update($id,$setdata)){
						$json = array("status"=>200,"msg"=>"Bạn vừa chuyển trạng thái một mục","callback"=>$data->id);
					}
				}else{
					$json["msg"] = "Mục không tồn tại";
				}
			}	
			$this->output->set_content_type('application/json')->set_output(json_encode($json));
	}
	
	function username_check($str){

		$recipient = $this->Users_admin_model->get(array("username"=>$str));		
		if (!empty($recipient)){
			$this->form_validation->set_message('username_check', 'Tên đăng nhập bị trùng.');
			return FALSE;
		}else{
			return TRUE;
		}
	}
	
	function name_check($str){

		$recipient = $this->Users_admin_model->get(array("name"=>$str));		
		if (!empty($recipient)){
			$this->form_validation->set_message('name_check', 'Tên hiện thị bị trùng');
			return FALSE;
		}else{
			return TRUE;
		}

	}

	function email_check($str){

		$recipient = $this->Users_admin_model->get_by(array("email"=>$str));		
		if (!empty($recipient)){
			$this->form_validation->set_message('email_check', 'E mail bị trùng.');
			return FALSE;
		}else{
			return TRUE;
		}
	}
	
	function roleid_check($str){
			
		if ($str == 1){
			$this->form_validation->set_message('roleid_check', 'Id không tồn tại');
			return FALSE;
		}else{
			return TRUE;
		}

	}

}
