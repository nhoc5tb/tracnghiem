<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Role extends Admin_Controller {
  
	public function __construct()
	{
		parent::__construct();
		$this->data["title"] = "Phân quyền cho quản trị";
		$this->data['controller_title'] = "Phân Quyền";
		$this->load->model('Rurole_model');
	}
	
	function Permission($id = NULL)
	{
		try {
			$this->data['getcsdl'] = $this->Rurole_model->role_group_get($id);
			if(empty($this->data['getcsdl'])) show_404();
			$this->data['title'] = "Phân quyền cho nhóm quản trị";
			
			$rp = $this->rurole_model->role_permission_get($id);	//lấy quyền từ bảng role_permission
			if($rp){
				$this->data['select'] = json_decode($rp->permission);
			}else{	
			}
			$this->data['cpid'] = $id;	
			
			$this->data['permission'] = $this->Rurole_model->role_controller_getlist();	
			$this->layout->view(strtolower($this->data['controller']).'/'.strtolower($this->data['action']),$this->data);
		} catch (Exception $e) {
			echo $e->getMessage(); die();
		}
	}
	
	function modify($id){
		try{
			$this->data['getcsdl'] = $this->Rurole_model->role_group_get($id);
			if(empty($this->data['getcsdl'])) show_404();
			
			$json = array('tt'=>'false','msg'=>"Lỗi hệ thống ...");
			$input = $this->input->post();
			if(!empty($input)){			
				$datajson = NULL ;				
				foreach ($input['selNodes'] as $row){
					if($row != '0')
						$datajson .= $row.",";
				}			
				$datajson = "{".substr($datajson,0,-1)."}";
				
				$data = array(
							'role_id'    => $id,	
							'permission' => $datajson
							);
				
				$check_emtry = $this->Rurole_model->role_permission_get($id);
				
				if($check_emtry){
					$insert = $this->Rurole_model->role_permission_uploadRole_id($id,$data);
				}else{
					$insert = $this->Rurole_model->role_permission_insert($data);
				}
				if($insert)
					$json = array('tt'=>'true','msg'=>"Xử lý thành công");
				else
					$json = array('tt'=>'true','msg'=>"Có lỗi từ CSDL");
					
				$this->output->set_content_type('application/json')->set_output(json_encode($json));	
				
			}
		} catch (Exception $e){
			echo $e->getMessage();
			die();
		}
	}
  	
	/*
	| Danh sách nhóm quản trị
	*/
	function ListGroup()
	{
		try {
			$this->data['title'] = "Danh sách nhóm quản trị";
			$this->data['getcsdl'] = $this->Rurole_model->role_group_getmenu();
			$this->layout->view(strtolower($this->data['controller']).'/'.strtolower($this->data['action']),$this->data);

		} catch (Exception $e) {

			echo $e->getMessage(); die();
		}
	}
	
	function ListGroup_ajax_insert()
	{
		$input = $this->input->post();
		$json  = "Không thấy dữ liệu";
		if(!empty($input)){			
			$this->form_validation->set_rules('role_name', 'Tên nhóm', 'trim|required|callback_role_name_check');	
			$this->form_validation->set_rules('parent_id', 'Nhóm cha', 'trim|required');
			
			if($this->form_validation->run() == TRUE){
				
				$setcsdl = array(
								"role_name"	=> set_value('role_name'),
								"role_status"	=> 1,
								"parent_id"		=> set_value('parent_id'),
				);
				
				$id = $this->Rurole_model->role_group_insert($setcsdl);
				
				if($id){
					$json = array('tt'=>'true','msg'=>'Tạo nhóm thành công, Cập nhật lại dữ liệu.');
				}
				else{
					$json = array('tt'=>'false','msg'=>"Lỗi hệ thống ...");
				}
			}else{
				$json = array('tt'=>'false','msg'=>validation_errors());
			}
		}//empty($input)
		$this->output->set_content_type('application/json')->set_output(json_encode($json));
	}
	function ListGroup_ajax_edit()
	{
		$input = $this->input->post();
		$json  = "Không thấy dữ liệu";
		if(!empty($input)){			
		
			$this->form_validation->set_rules('role_name', 'Tên nhóm', 'trim|required|callback_role_nameup_check['.$input["role_id"].']');	
			$this->form_validation->set_rules('parent_id', 'ID Nhóm cha', 'trim|required');
			$this->form_validation->set_rules('role_status', 'Trạng thái', 'trim|required');
			$this->form_validation->set_rules('role_id', 'ID Nhóm', 'trim|required');
			
			if($this->form_validation->run() == TRUE){
				
				$setcsdl = array(
								"role_name"	=> set_value('role_name'),
								"role_status"	=> set_value('role_status'),
								"parent_id"		=> set_value('parent_id'),
				);
				
				$id = $this->Rurole_model->role_group_upload(set_value('role_id'),$setcsdl);
				
				if($id){
					$json = array('tt'=>'true','msg'=>'Cập nhật nhóm thành công, Chờ tải lại dữ liệu.');
				}
				else{
					$json = array('tt'=>'false','msg'=>"Lỗi hệ thống ...");
				}
			}else{
				$json = array('tt'=>'false','msg'=>validation_errors());
			}
		}//empty($input)
		$this->output->set_content_type('application/json')->set_output(json_encode($json));
	}
	function role_name_check($str){

		$recipient = $this->Rurole_model->role_group_getname($str);
		
		if (!empty($recipient)){
			$this->form_validation->set_message('role_name_check', 'Tên nhóm đã tồn tại');
			return FALSE;
		}else{
			return TRUE;
		}
	}
	function role_nameup_check($str, $id){

		$recipient = $this->Rurole_model->role_group_getname($str);
		$id = $this->Rurole_model->role_group_get($id);
	
		if (!empty($recipient)){
			if($id->role_name != $recipient->role_name){
				$this->form_validation->set_message('role_nameup_check', 'Tên nhóm đã tồn tại');
				return FALSE;
			}
		}
		
		return TRUE;
	}
	function ListGroup_ajax_delete()
	{
		$input = $this->input->post();
		$json  = "Không thấy dữ liệu";
		if(!empty($input)){			
			$this->form_validation->set_rules('id', 'ID', 'trim|required|callback_role_name_check');
			
			if($this->form_validation->run() == TRUE){
				
				$setcsdl = array(
								"role_status"	=> -1
				);
				
				$id = $this->Rurole_model->role_group_upload(set_value('id'),$setcsdl);
				
				if($id){
					$json = array('tt'=>'true','msg'=>'Đã xóa nhóm khỏi hệ thống');
				}
				else{
					$json = array('tt'=>'false','msg'=>"Lỗi hệ thống ...");
				}
			}else{
				$json = array('tt'=>'false','msg'=>validation_errors());
			}
		}//empty($input)
		$this->output->set_content_type('application/json')->set_output(json_encode($json));
	}

}
