<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Attrib_insert extends Admin_Controller {
	
	public function __construct(){ 
        parent::__construct(); 
		
		$this->load->model('attrib_insert_group_model');
		
		$this->load->model('attrib_insert_model');
		
		$this->data['controller_title'] = "Thuộc Tính nhập";

    } 
	//các hàm về thuộc tính
	public function index(){

		$this->data['title'] = "Danh sách thuộc tính nhập";	
		
		$w = array();
		
		$config['base_url'] = current_url();
	
		$config['total_rows'] = $this->attrib_insert_model->count_by($w);
		
		$config['per_page'] = 20; 
		
		$config['page_query_string'] = TRUE;
		
		$offset = $this->input->get('per_page');

		$this->pagination->initialize($config);
		
		$this->data['getcsdl'] = $this->attrib_insert_model->getlist($offset,$config['per_page'],$w);
		
		$this->data['pagination'] = $this->pagination->create_links();
		
		$this->data['group'] = $this->attrib_insert_group_model->get();
		
		$input = $this->input->post();
		
		if($input){
			$this->form_validation->set_rules('title', 'Tiêu đề', 'trim|required');		

			$this->form_validation->set_rules('group', 'Nhóm thuộc tính', 'trim');		

			if($this->form_validation->run()== TRUE){

				$setcsdl = array(
							'title'       => $this->input->post('title'),
							'group' 	  => $this->input->post('group'),
							'created'     => $this->data['date_now'],
							'created_by'  => $this->data['auth']->username,
							'status'      => 1
							);
				if($this->attrib_insert_model->insert($setcsdl))						
					redirect($this->data['module'].'/'.$this->data['controller'].'/'.__FUNCTION__);	
			}

		}
		$this->layout->view(strtolower(__CLASS__)."/".__FUNCTION__,$this->data);
	}
	
	public function edit(){
		$id = (int)$this->uri->segment(4);
		
		$this->data['getcsdl'] = $this->attrib_insert_model->get($id);
		
		$this->data['group'] = $this->attrib_insert_group_model->get();

		$this->data['title'] = "Sửa : ".$this->data['getcsdl']->title;
		
		if(!$this->data['getcsdl']) show_404();
			
			$input = $this->input->post();

			if($input){		

				$this->form_validation->set_rules('title', 'Tiêu đề', 'trim|required');		

				$this->form_validation->set_rules('group', 'Nhóm thuộc tính', 'trim');			

				if($this->form_validation->run()== TRUE){	
				
					$setcsdl = array(
								'title'       => $this->input->post('title'),
								'group' 	  => $this->input->post('group'),
								'modified'     => $this->data['date_now'],
								'modified_by'  => $this->data['auth']->username
								);							

					if($this->attrib_insert_model->update($id,$setcsdl))
						redirect($this->data['module'].'/'.$this->data['controller']);

				}
			}
			
		$this->layout->view(strtolower(__CLASS__)."/".__FUNCTION__,$this->data);
	}
	public function delete(){	  
		$json = array("status"=>404,"msg"=>"Lỗi thực hiện lệnh","callback"=>"");
		$this->form_validation->set_rules('id', 'ID', 'trim|is_natural_no_zero|required');
		if($this->form_validation->run() == TRUE){
			$id = set_value('id');
			$data = $this->attrib_insert_model->get_one_by(array('id'=>$id));			
			if ($data) {
				if($this->attrib_insert_model->delete_by( array('id'=>$id) )){
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
			$data = $this->attrib_insert_model->get_one_by(array('id'=>$id));			
			if ($data) {
				if($data->status == 1)
					$setdata = array('status'=> 0);
				else
					$setdata = array('status'=> 1);
			
				if($this->attrib_insert_model->update($id,$setdata)){
					$json = array("status"=>200,"msg"=>"Bạn vừa chuyển trạng thái một mục","callback"=>$data->id);
				}
			}else{
				$json["msg"] = "Mục không tồn tại";
			}
		}	
		$this->output->set_content_type('application/json')->set_output(json_encode($json));
	}
	
	//các hàm về nhóm
	public function group(){

		$this->data['title'] = "Nhóm thuộc tính";	
		
		$this->data['catalogs'] = $this->attrib_insert_group_model->get();
		
		$input = $this->input->post();
		
		if($input){
			$this->form_validation->set_rules('title', 'Tiêu đề', 'trim|required');	
			
			$this->form_validation->set_rules('type', 'Loại thuộc tính', 'trim');	
			
			$this->form_validation->set_rules('description', 'Description', 'trim');		

			if($this->form_validation->run()== TRUE){

				$setcsdl = array(
							'title'       => $this->input->post('title'),
							'description' => $this->input->post('description'),
							'type'        => $this->input->post('type'),
							'created'     => $this->data['date_now'],
							'created_by'  => $this->data['auth']->username,
							'status'      => 1
							);
				if($this->attrib_insert_group_model->insert($setcsdl))						
					redirect($this->data['module'].'/'.$this->data['controller'].'/'.__FUNCTION__);	
			}

		}
		$this->layout->view(strtolower(__CLASS__)."/".__FUNCTION__."/index",$this->data);
	}
	
	public function group_edit(){
		$id = (int)$this->uri->segment(4);
		
		$this->data['getcsdl'] = $this->attrib_insert_group_model->get($id);

		$this->data['title'] = "Sửa : ".$this->data['getcsdl']->title;
		
		if(!$this->data['getcsdl']) show_404();
			
			$input = $this->input->post();

			if($input){		

				$this->form_validation->set_rules('title', 'Tiêu đề', 'trim|required');		

				$this->form_validation->set_rules('type', 'Loại thuộc tính', 'trim');				

				$this->form_validation->set_rules('description', 'Description', 'trim');			

				if($this->form_validation->run()== TRUE){	
				
					$setcsdl = array(
								'title'       => $this->input->post('title'),
								'description' => $this->input->post('description'),
								'type'        => $this->input->post('type'),
								'modified'     => $this->data['date_now'],
								'modified_by'  => $this->data['auth']->username
								);							

					if($this->attrib_insert_group_model->update($id,$setcsdl))
						redirect($this->data['module'].'/'.$this->data['controller'].'/group');

				}
			}
			
		$this->layout->view(strtolower(__CLASS__)."/group/edit",$this->data);
	}
	public function group_del(){
	  
		$json = array("status"=>404,"msg"=>"Lỗi thực hiện lệnh","callback"=>"");
		$this->form_validation->set_rules('id', 'ID', 'trim|is_natural_no_zero|required');
		if($this->form_validation->run() == TRUE){
			$id = set_value('id');
			$data = $this->attrib_insert_group_model->get_one_by(array('id'=>$id));			
			if ($data) {
				$attrib_check = $this->attrib_insert_model->get_one_by(array('group'=>$data->id));
				if ($attrib_check) {
					$json = array("status"=>400,"msg"=>"Nhóm có chứa thuộc tính chọn, Vui lòng xóa thuộc tính trước","callback"=>$data->id);
				}else{
					if($this->attrib_insert_group_model->delete_by( array('id'=>$id) )){
						$json = array("status"=>200,"msg"=>"Bạn vừa xóa một mục","callback"=>$data->id);
					}
				}				
			}else{
				$json["msg"] = "Mục xóa không tồn tại";
			}
		}	
		$this->output->set_content_type('application/json')->set_output(json_encode($json));	
	}
  
	public function group_status(){
	  
		$json = array("status"=>404,"msg"=>"Lỗi thực hiện lệnh","callback"=>"");
		$this->form_validation->set_rules('id', 'ID', 'trim|is_natural_no_zero|required');
		if($this->form_validation->run() == TRUE){
			$id = set_value('id');
			$data = $this->attrib_insert_group_model->get_one_by(array('id'=>$id));			
			if ($data) {
				if($data->status == 1)
					$setdata = array('status'=> 0);
				else
					$setdata = array('status'=> 1);
			
				if($this->attrib_insert_group_model->update($id,$setdata)){
					$json = array("status"=>200,"msg"=>"Bạn vừa chuyển trạng thái một mục","callback"=>$data->id);
				}
			}else{
				$json["msg"] = "Mục không tồn tại";
			}
		}	
		$this->output->set_content_type('application/json')->set_output(json_encode($json));
	}

}