<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Attrib_check extends Admin_Controller {
	
	public function __construct(){ 
        parent::__construct(); 
		
		$this->load->model('attrib_check_group_model');
		
		$this->load->model('attrib_check_model');
		
		$this->config->load('template');		
	
		$this->data['config_upload'] = $this->config->item('image_'.strtolower(__CLASS__));	

		$this->data['controller_title'] = "Thuộc Tính Chọn";

    } 
	//các hàm về thuộc tính
	public function index(){

		$this->data['title'] = "Danh sách";	
		
		$w = array();
		
		$config['base_url'] = current_url();
	
		$config['total_rows'] = $this->attrib_check_model->count_by($w);
		
		$config['per_page'] = 20; 
		
		$config['page_query_string'] = TRUE;
		
		$offset = $this->input->get('per_page');

		$this->pagination->initialize($config);
		
		$this->data['getcsdl'] = $this->attrib_check_model->getlist($offset,$config['per_page'],$w);
		
		$this->data['pagination'] = $this->pagination->create_links();
		
		$this->data['group'] = $this->attrib_check_group_model->get_by(array("status"=>1));
		
		$input = $this->input->post();
		
		if($input){
			$this->form_validation->set_rules('title', 'Tiêu đề', 'trim|required');	
			$this->form_validation->set_rules('group', 'Nhóm thuộc tính', 'trim');		
			$this->form_validation->set_rules('rate', 'Tỉ giá', 'trim');
			$this->form_validation->set_rules('image-url', 'Image URL', 'trim');	
			$this->form_validation->set_rules('image', 'Hình ảnh', 'trim');
	
			if($this->form_validation->run()== TRUE){

				$setcsdl = array(
							'title'       => set_value('title'),
							'group' 	  => set_value('group'),
							'rate' 	  => set_value('rate'),
							'created'     => $this->data['date_now'],
							'created_by'  => $this->data['auth']->username,
							'status'      => 1
							);
				$id = $this->attrib_check_model->insert($setcsdl);
				if($id){
					if(empty(set_value('image_lib')) ){	
						if(empty(set_value('image_url')) ){			
							$fileimg = $this->ruadmin->upFile($this->data['config_upload'],'image');

							if($fileimg["status"] == 200 or $fileimg["status"] == 300 ){
								$this->attrib_check_model->update( $id,array('image'=>$fileimg["src"]) );	
							}
						}else{
							$fileimg = $this->ruadmin->upload_url(set_value('image_url'),$this->data['config_upload']);
							if($fileimg){
								$this->attrib_check_model->update( $id,array('image'=>$fileimg) );	
							}
						}
					}else{							
						$this->attrib_check_model->update( $id,array('image'=>set_value('image_lib')) );
					}
					redirect($this->data['module'].'/'.$this->data['controller'].'/'.__FUNCTION__);	
				}
			}

		}
		$this->layout->view(strtolower(__CLASS__)."/".__FUNCTION__,$this->data);
	}
	
	public function quick(){

		$this->data['title'] = "Danh sách";	
		$this->data['group'] = $this->attrib_check_group_model->get();
		
		$input = $this->input->post();
		
		if($input){
			$this->form_validation->set_rules('list_attrib', 'Tiêu đề', 'trim|required|callback_check_array');	
			$this->form_validation->set_rules('group', 'Nhóm thuộc tính', 'trim');		
			$this->form_validation->set_rules('rate', 'Tỉ giá', 'trim');
	
			if($this->form_validation->run()== TRUE){
				$list_attrib = explode("\n",set_value('list_attrib'));
				if(count($list_attrib) > 0){
					$setcsdl = array();
					foreach($list_attrib as $key=>$row){
						if(!empty($row)){
							$setcsdl[$key] = array(
								'title'       => $row,
								'group' 	  => set_value('group'),
								'rate' 	  	  => set_value('rate'),
								'created'     => $this->data['date_now'],
								'created_by'  => $this->data['auth']->username,
								'status'      => 1
							);
						}						
					}					
					$id = $this->attrib_check_model->insert_batch($setcsdl);
					if($id){					
						redirect($this->data['module'].'/'.$this->data['controller'].'/'.__FUNCTION__);	
					}
				}
				
			}

		}
		$this->layout->view(strtolower(__CLASS__)."/".__FUNCTION__,$this->data);
	}
	function check_array($list_attrib){
		$list_attrib = explode("\n",$list_attrib);		
		if(count($list_attrib) > 0){
			return TRUE;
		} else {
			$this->form_validation->set_message('check_array', 'Danh sách mảng không đúng định dạng');
			return FALSE;
		}

	}
	
	public function edit(){
		$id = (int)$this->uri->segment(4);
		
		$this->data['getcsdl'] = $this->attrib_check_model->get($id);
		
		$this->data['group'] = $this->attrib_check_group_model->get();

		$this->data['title'] = "Sửa : ".$this->data['getcsdl']->title;
		
		if(!$this->data['getcsdl']) show_404();
			
			$input = $this->input->post();

			if($input){		

				$this->form_validation->set_rules('title', 'Tiêu đề', 'trim|required');		
				$this->form_validation->set_rules('group', 'Nhóm thuộc tính', 'trim');		
				$this->form_validation->set_rules('rate', 'Tỉ giá', 'trim');		
				$this->form_validation->set_rules('image-url', 'Image URL', 'trim');	
				$this->form_validation->set_rules('image', 'Hình ảnh', 'trim');
			
				if($this->form_validation->run()== TRUE){	
				
					$setcsdl = array(
								'title'       => set_value('title'),
								'group' 	  => set_value('group'),
								'rate' 	      => set_value('rate'),
								'modified'    => $this->data['date_now'],
								'modified_by' => $this->data['auth']->username							
								);							

					if($this->attrib_check_model->update($id,$setcsdl)){
						if(empty(set_value('image_lib')) ){	
							if(empty(set_value('image_url')) ){			
								$fileimg = $this->ruadmin->upFile($this->data['config_upload'],'image');

								if($fileimg["status"] == 200 or $fileimg["status"] == 300 ){
									@unlink($this->data['config_upload']["dir"]."/".$this->data['getcsdl']->image);
									$this->attrib_check_model->update( $id,array('image'=>$fileimg["src"]) );	
								}
							}else{
								$fileimg = $this->ruadmin->upload_url(set_value('image_url'),$this->data['config_upload']);
								if($fileimg){
									@unlink($this->data['config_upload']["dir"]."/".$this->data['getcsdl']->image);
									$this->attrib_check_model->update( $id,array('image'=>$fileimg) );	
								}
							}
						}else{
							@unlink($this->data['config_upload']["dir"]."/".$this->data['getcsdl']->image);
							$this->attrib_check_model->update( $id,array('image'=>set_value('image_lib')) );
						}
						redirect($this->data['module'].'/'.$this->data['controller']);
					}

				}
			}
			
		$this->layout->view(strtolower(__CLASS__)."/".__FUNCTION__,$this->data);
	}
	public function delete(){	  
		$json = array("status"=>404,"msg"=>"Lỗi thực hiện lệnh","callback"=>"");
		$this->form_validation->set_rules('id', 'ID', 'trim|is_natural_no_zero|required');
		if($this->form_validation->run() == TRUE){
			$id = set_value('id');
			$data = $this->attrib_check_model->get_one_by(array('id'=>$id));			
			if ($data) {
				if($this->attrib_check_model->delete_by( array('id'=>$id) )){
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
			$data = $this->attrib_check_model->get_one_by(array('id'=>$id));			
			if ($data) {
				if($data->status == 1)
					$setdata = array('status'=> 0);
				else
					$setdata = array('status'=> 1);
			
				if($this->attrib_check_model->update($id,$setdata)){
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
		
		$this->data['catalogs'] = $this->attrib_check_group_model->get();
		
		$input = $this->input->post();
		
		if($input){
			$this->form_validation->set_rules('title', 'Tiêu đề', 'trim|required');	
			
			$this->form_validation->set_rules('type', 'Loại thuộc tính', 'trim');	
			
			$this->form_validation->set_rules('description', 'Mô tả', 'trim');	
			
			$this->form_validation->set_rules('type_action', 'Loại hành động', 'trim');	
			
			$this->form_validation->set_rules('rate', 'Tỉ giá', 'trim');		

			if($this->form_validation->run()== TRUE){

				$setcsdl = array(
							'title'       => $this->input->post('title'),
							'description' => $this->input->post('description'),
							'type'        => $this->input->post('type'),
							'type_action' => $this->input->post('type_action'),
							'rate'        => $this->input->post('rate'),
							'created'     => $this->data['date_now'],
							'created_by'  => $this->data['auth']->username,
							'status'      => 1
							);
				if($this->attrib_check_group_model->insert($setcsdl))						
					redirect($this->data['module'].'/'.$this->data['controller'].'/'.__FUNCTION__);	
			}

		}
		$this->layout->view(strtolower(__CLASS__)."/".__FUNCTION__."/index",$this->data);
	}
	
	public function group_edit(){
		$id = (int)$this->uri->segment(4);
		
		$this->data['getcsdl'] = $this->attrib_check_group_model->get($id);

		$this->data['title'] = "Sửa : ".$this->data['getcsdl']->title;
		
		if(!$this->data['getcsdl']) show_404();
			
			$input = $this->input->post();

			if($input){		

				$this->form_validation->set_rules('title', 'Tiêu đề', 'trim|required');	
			
				$this->form_validation->set_rules('type', 'Loại thuộc tính', 'trim');	
				
				$this->form_validation->set_rules('description', 'Mô tả', 'trim');	
				
				$this->form_validation->set_rules('type_action', 'Loại hành động', 'trim');	
				
				$this->form_validation->set_rules('rate', 'Tỉ giá', 'trim');			

				if($this->form_validation->run()== TRUE){	
				
					$setcsdl = array(
								'title'       => $this->input->post('title'),
								'description' => $this->input->post('description'),
								'type'        => $this->input->post('type'),
								'type_action' => $this->input->post('type_action'),
								'rate'        => $this->input->post('rate'),
								'created'     => $this->data['date_now'],
								'created_by'  => $this->data['auth']->username
								);							

					if($this->attrib_check_group_model->update($id,$setcsdl))
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
			$data = $this->attrib_check_group_model->get_one_by(array('id'=>$id));			
			if ($data) {
				$attrib_check = $this->attrib_check_model->get_one_by(array('group'=>$data->id));
				if ($attrib_check) {
					$json = array("status"=>400,"msg"=>"Nhóm có chứa thuộc tính chọn, Vui lòng xóa thuộc tính trước","callback"=>$data->id);
				}else{
					if($this->attrib_check_group_model->delete_by( array('id'=>$id) )){
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
			$data = $this->attrib_check_group_model->get_one_by(array('id'=>$id));			
			if ($data) {
				if($data->status == 1)
					$setdata = array('status'=> 0);
				else
					$setdata = array('status'=> 1);
			
				if($this->attrib_check_group_model->update($id,$setdata)){
					$json = array("status"=>200,"msg"=>"Bạn vừa chuyển trạng thái một mục","callback"=>$data->id);
				}
			}else{
				$json["msg"] = "Mục không tồn tại";
			}
		}	
		$this->output->set_content_type('application/json')->set_output(json_encode($json));
	}
}