<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Page extends Admin_Controller {
  
  public function __construct()
  {
    parent::__construct();
	$this->load->model('Page_model'); 
	$this->load->model('Page_group_model'); 
	
	$this->data['active_page'] = "class='active'";
	
	$this->data['controller_title'] = "Trang Đơn";
	
	$this->data['catalogs'] = $this->Page_group_model->getselect();	
	
	$this->config->load('template');		
	$this->data['config_upload'] = $this->config->item('image_'.strtolower(__CLASS__));			
	
	$this->load->library("pagination");
	
  }
  public function index()
  {
		$this->data['title'] = "Danh sách Bài Viết";	
		
		$w = array();
		
		$config['base_url'] = current_url();
	
		$config['total_rows'] = $this->Page_model->count_by($w);
		
		$config['per_page'] = 20; 
		
		$config['page_query_string'] = TRUE;
		
		$offset = $this->input->get('per_page');

		$this->pagination->initialize($config);
		
		$this->data['getcsdl'] = $this->Page_model->getlist($offset,$config['per_page'],$w);
		
		$this->data['pagination'] = $this->pagination->create_links();
		
		$this->layout->view(strtolower(__CLASS__.'/'.__FUNCTION__),$this->data);
  }
	public function add(){
	  
		$this->data['title'] = "Thêm Bài Viết";
		$this->form_validation->set_rules('title', 'Tiêu đề', 'trim|required');
		$this->form_validation->set_rules('slug', 'Slug', 'trim');
		$this->form_validation->set_rules('headingh1', 'Thẻ H1', 'trim');
		$this->form_validation->set_rules('description', 'E-mail', 'trim');
		$this->form_validation->set_rules('keywords', 'E-mail', 'trim');
		$this->form_validation->set_rules('home_text', 'Nội dung ngắn', 'trim');
		$this->form_validation->set_rules('body_text', 'Nội dung', 'trim');
		$this->form_validation->set_rules('group', 'Nhóm', 'trim');
		$this->form_validation->set_rules('image-url', 'Image URL', 'trim');	
		$this->form_validation->set_rules('image', 'Hình mình họa', 'trim');

		if($this->form_validation->run() == TRUE){  

			$slug = set_value('slug');
			if(empty($slug))  	
				$slug = $this->ruadmin->slug(set_value('title'),'Page_model');	
			else{
				if($this->data['getcsdl']->slug != set_value('slug'))
					$slug = $this->ruadmin->slug(set_value('slug'),'Page_model');	
			}		
			$h1 = set_value('headingh1');
			if(empty($h1)){
				$h1 = set_value('title');
			}			
			$data = array(
					'title' => set_value('title'),
					'headingh1' => $h1,
					'slug' => $slug,
					'description' => set_value('description'),
					'keywords' => set_value('keywords'),
					'id_group' => set_value('group'),
					'home_text' => html_entity_decode(set_value('home_text')),
					'body_text' => html_entity_decode(set_value('body_text')),
					'status' => 1,
					'created' => $this->data['date_now'],
					'created_by' => $this->data['auth']->username,
					'modified' => $this->data['date_now'],
					'modified_by' => $this->data['auth']->username,
			);
			$id = $this->Page_model->insert($data);
			if($id){
				if(empty(set_value('image_lib')) ){	
					if(empty(set_value('image_url')) ){			
						$fileimg = $this->ruadmin->upFile($this->data['config_upload'],'image');

						if($fileimg["status"] == 200 or $fileimg["status"] == 300 ){
							$this->Page_model->update( $id,array('image'=>$fileimg["src"]) );	
						}
					}else{
						$fileimg = $this->ruadmin->upload_url(set_value('image_url'),$this->data['config_upload']);
						if($fileimg){
							$this->Page_model->update( $id,array('image'=>$fileimg) );	
						}
					}
				}else{		
					$this->Page_model->update( $id,array('image'=>set_value('image_lib')) );
				}
				
				redirect($this->data['module'].'/'.$this->data['controller']);	
			}      
		}
		$this->layout->view(strtolower(__CLASS__.'/'.__FUNCTION__),$this->data);  	
	}
	public function edit(){
		$this->data['title'] = "Sửa Bài Viết";	
		$id = $this->uri->segment(4);		
    	$this->data['getcsdl'] = $this->Page_model->get($id);
		
		$this->form_validation->set_rules('title', 'Tiêu đề', 'trim|required');
		$this->form_validation->set_rules('headingh1', 'Thẻ H1', 'trim');
		$this->form_validation->set_rules('slug', 'Slug', 'trim');
		$this->form_validation->set_rules('description', 'Description', 'trim');
		$this->form_validation->set_rules('keywords', 'Keywords', 'trim');
		$this->form_validation->set_rules('home_text', 'Nội dung ngắn', 'trim');
		$this->form_validation->set_rules('body_text', 'Nội dung', 'trim');
		$this->form_validation->set_rules('group', 'Nhóm', 'trim');
		$this->form_validation->set_rules('image-url', 'Image URL', 'trim');	
		$this->form_validation->set_rules('image', 'Hình mình họa', 'trim');
	
		if($this->form_validation->run() == TRUE){  
			
			$slug = set_value('slug');
			if(empty($slug))  	
				$slug = $this->ruadmin->slug(set_value('title'),'Page_model');	
			else{
				if($this->data['getcsdl']->slug != set_value('slug'))
					$slug = $this->ruadmin->slug(set_value('slug'),'Page_model');	
			}	
			$h1 = set_value('headingh1');
			if(empty($h1)){
				$h1 = set_value('title');
			}			
			$data = array(
					'title' => set_value('title'),
					'headingh1' => $h1,
					'slug' => $slug,
					'description' => set_value('description'),
					'keywords' => set_value('keywords'),
					'id_group' => set_value('group'),
					'home_text' => html_entity_decode(set_value('home_text')),
					'body_text' => html_entity_decode(set_value('body_text')),					
					'status' => 1,
					'created' => $this->data['date_now'],
					'created_by' => $this->data['auth']->username,
					'modified' => $this->data['date_now'],
					'modified_by' => $this->data['auth']->username,
			);
			
			if($this->Page_model->update($id,$data)){
				
				if(empty(set_value('image_lib')) ){	
					if(empty(set_value('image_url')) ){			
						$fileimg = $this->ruadmin->upFile($this->data['config_upload'],'image');

						if($fileimg["status"] == 200 or $fileimg["status"] == 300 ){
							$this->ruadmin->removeImg($this->data['getcsdl']->image,$this->data['config_upload']["dir"]);
							$this->Page_model->update( $id,array('image'=>$fileimg["src"]) );	
						}
					}else{
						$fileimg = $this->ruadmin->upload_url(set_value('image_url'),$this->data['config_upload']);
						if($fileimg){							
							$this->ruadmin->removeImg($this->data['getcsdl']->image,$this->data['config_upload']["dir"]);
							$this->Page_model->update( $id,array('image'=>$fileimg) );	
						}
					}
				}else{
						$this->ruadmin->removeImg($this->data['getcsdl']->image,$this->data['config_upload']["dir"]);	
						$this->Page_model->update( $id,array('image'=>set_value('image_lib')) );
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

			$data = $this->Page_model->get_one_by(array('id'=>$id));
			
			if ($data) {
				if($this->Page_model->delete_by( array('id'=>$id) )){
					$img = $this->ruadmin->removeImg($data->image,$this->data['config_upload']["dir"]);						
					$imgPost = $this->ruadmin->getImageInContent($data->body_text,true);	
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
			$data = $this->Page_model->get_one_by(array('id'=>$id));			
			if ($data) {
				if($data->status == 1)
					$setdata = array('status'=> 0);
				else
					$setdata = array('status'=> 1);
				
				if($this->Page_model->update($id,$setdata)){
					$json = array("status"=>200,"msg"=>"Bạn vừa chuyển trạng thái một mục","callback"=>$data->id);
				}
			}else{
				$json["msg"] = "Mục không tồn tại";
			}
		}	
		$this->output->set_content_type('application/json')->set_output(json_encode($json));
	}
}
