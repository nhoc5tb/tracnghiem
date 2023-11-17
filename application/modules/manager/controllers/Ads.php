<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Ads extends Admin_Controller {
  
  public function __construct()
  {
    parent::__construct();
	$this->load->model('Ads_model'); 
	$this->load->model('Ads_groups_model'); 
	
	$this->data['active_page'] = "class='active'";
	
	$this->data['controller_title'] = "Quảng Cáo";
	
	$this->data['catalogs'] = $this->Ads_groups_model->get_by(array("status"=>1));	
	
	$this->config->load('template');		
	
	$this->data['config_upload'] = $this->config->item('image_'.strtolower(__CLASS__));	
	
	$this->load->library("pagination");
	
  }
  public function index()
  {
		$this->data['title'] = "Danh sách Quảng Cáo";	
		
		$w = array();
		
		$config['base_url'] = current_url();
	
		$config['total_rows'] = $this->Ads_model->count_by($w);
		
		$config['per_page'] = 20; 
		
		$config['page_query_string'] = TRUE;
		
		$offset = $this->input->get('per_page');

		$this->pagination->initialize($config);
		
		$this->data['getcsdl'] = $this->Ads_model->getlist($offset,$config['per_page'],$w);
		
		$this->data['pagination'] = $this->pagination->create_links();
		
		$this->layout->view(strtolower(__CLASS__.'/'.__FUNCTION__),$this->data);
  }
	public function add(){
	  
		$this->data['title'] = "Thêm Ads";		
		$this->data['ads_groups'] = $this->Ads_groups_model->get_by(array("status"=>1));
		$this->data["count"] = $this->Ads_model->count_all();
		$this->form_validation->set_rules('title', 'Tiêu đề', 'trim|required');
		$this->form_validation->set_rules('type', 'Loại', 'trim');
		$this->form_validation->set_rules('link', 'Liên kết', 'trim');
		$this->form_validation->set_rules('id_group', 'Nhóm quảng cáo', 'trim');
		$this->form_validation->set_rules('body_text', 'Nội dung', 'trim');
		$this->form_validation->set_rules('order', 'Thứ Tự', 'trim');		
		$this->form_validation->set_rules('image-url', 'Image URL', 'trim');	
		$this->form_validation->set_rules('image', 'Hình mình họa', 'trim');

		if($this->form_validation->run() == TRUE){  
			if(empty(set_value('order'))){
					$order = $this->Ads_groups_model->get_one_by(array("id > "=> 0,'id_group'=> set_value('id_group') ),"desc");
					$order = ($order->id+1);
				}else{
					$order = set_value('order');
				}
				
			$data = array(
					'title'      => set_value('title'),
					'type'       => set_value('type'),
					'link'       => set_value('link'),
					'id_group'   => set_value('id_group'),
					'body_text'  => set_value('body_text'),
					'order'      => $order,
					'status'     => 1,
					'created'    => $this->data['date_now'],
					'created_by' => $this->data['auth']->username,
					'modified'   => $this->data['date_now'],
					'modified_by' => $this->data['auth']->username,
			);
			
			$id = $this->Ads_model->insert($data);
			if($id){
				if(empty(set_value('image_lib')) ){	
					if(empty(set_value('image_url')) ){			
						$fileimg = $this->ruadmin->upFile($this->data['config_upload'],'image');

						if($fileimg["status"] == 200 or $fileimg["status"] == 300 ){
							$this->Ads_model->update( $id,array('image'=>$fileimg["src"]) );	
						}
					}else{
						$fileimg = $this->ruadmin->upload_url(set_value('image_url'),$this->data['config_upload']);
						if($fileimg){
							$this->Ads_model->update( $id,array('image'=>$fileimg) );	
						}
					}
				}else{
						$this->Ads_model->update( $id,array('image'=>set_value('image_lib')) );
				}
				
				redirect($this->data['module'].'/'.$this->data['controller']);	
			}      
		}
		$this->layout->view(strtolower(__CLASS__.'/edit'),$this->data);  	
	}
	public function edit(){
		$this->data['title'] = "Sửa Quảng Cáo";	
		$id = $this->uri->segment(4);		
    	$this->data['getcsdl'] = $this->Ads_model->get($id);
		$this->data['ads_groups'] = $this->Ads_groups_model->get_by(array("status"=>1));
		
		$this->form_validation->set_rules('title', 'Tiêu đề', 'trim|required');
		$this->form_validation->set_rules('type', 'Loại', 'trim');
		$this->form_validation->set_rules('link', 'Liên kết', 'trim');
		$this->form_validation->set_rules('id_group', 'Nhóm quảng cáo', 'trim');
		$this->form_validation->set_rules('body_text', 'Nội dung', 'trim');
		$this->form_validation->set_rules('order', 'Thứ Tự', 'trim');		
		$this->form_validation->set_rules('image-url', 'Image URL', 'trim');	
		$this->form_validation->set_rules('image', 'Hình mình họa', 'trim');
	
		if($this->form_validation->run() == TRUE){  
			
			if(empty(set_value('order'))){
					$order = $this->Ads_groups_model->get_one_by(array("id > "=> 0,'id_group'=> set_value('id_group') ),"desc");
					$order = ($order->id+1);
				}else{
					$order = set_value('order');
				}
				
			$data = array(
					'title'      => set_value('title'),
					'type'       => set_value('type'),
					'link'       => set_value('link'),
					'id_group'   => set_value('id_group'),
					'body_text'  => set_value('body_text'),
					'order'      => $order,
					'created'    => $this->data['date_now'],
					'created_by' => $this->data['auth']->username,
					'modified'   => $this->data['date_now'],
					'modified_by' => $this->data['auth']->username,
			);
			
			if($this->Ads_model->update($id,$data)){
				if(empty(set_value('image_lib')) ){	
					if(empty(set_value('image_url')) ){			
						$fileimg = $this->ruadmin->upFile($this->data['config_upload'],'image');

						if($fileimg["status"] == 200 or $fileimg["status"] == 300 ){
							$this->ruadmin->removeImg($this->data['getcsdl']->image,$this->data['config_upload']["dir"]);
							$this->Ads_model->update( $id,array('image'=>$fileimg["src"]) );	
						}
					}else{
						$fileimg = $this->ruadmin->upload_url(set_value('image_url'),$this->data['config_upload']);
						if($fileimg){
							$this->ruadmin->removeImg($this->data['getcsdl']->image,$this->data['config_upload']["dir"]);
							$this->Ads_model->update( $id,array('image'=>$fileimg) );	
						}
					}
				}else{
						@unlink($this->data['config_upload']["dir"]."/".$this->data['getcsdl']->image);
						$this->Ads_model->update( $id,array('image'=>set_value('image_lib')) );
				}
				redirect($this->data['module'].'/'.$this->data['controller']);	
			}   		  
		  
		}
		$this->layout->view(strtolower(__CLASS__.'/'.__FUNCTION__),$this->data);  		
  }
  
  public function delete(){	  
		$json = array("status"=>404,"msg"=>"Lỗi thực hiện lệnh","callback"=>"");
		$this->form_validation->set_rules('id', 'ID', 'trim|is_natural_no_zero|required');
		if($this->form_validation->run() == TRUE){
			$id = set_value('id');
			$data = $this->Ads_model->get_one_by(array('id'=>$id));			
			if ($data) {
				if($this->Ads_model->delete_by( array('id'=>$id) )){
					$this->ruadmin->removeImg($data->image,$this->data['config_upload']["dir"]);
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
				$data = $this->Ads_model->get_one_by(array('id'=>$id));			
				if ($data) {
					if($data->status == 1)
						$setdata = array('status'=> 0);
					else
						$setdata = array('status'=> 1);
				
					if($this->Ads_model->update($id,$setdata)){
						$json = array("status"=>200,"msg"=>"Bạn vừa chuyển trạng thái một mục","callback"=>$data->id);
					}
				}else{
					$json["msg"] = "Mục không tồn tại";
				}
			}	
			$this->output->set_content_type('application/json')->set_output(json_encode($json));
	}

}
