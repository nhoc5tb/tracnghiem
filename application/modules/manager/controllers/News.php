<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class News extends Admin_Controller {
  
	public function __construct(){
		parent::__construct();
		$this->load->model('News_model'); 
		$this->load->model('News_catalogs_model'); 

		$this->data['active_news'] = "class='active'";

		$this->config->load('template');		
		$this->data['config_upload'] = $this->config->item('image_'.strtolower(__CLASS__));									

		$this->data['catalogs'] = $this->News_catalogs_model->getselect();
		$this->data['controller_title'] = "Trang Tin";	
		$this->load->library("pagination"); 
	}

	public function index()
	{		
		$this->data['title'] = "Danh sách Trang Tin";	
		$w = array();
		
		if($this->data['auth']->roleid == "1" || $this->rurole->checkControler("news_catalogs","index")){
			
		}else{
			$w["created_by"] = $this->data['auth']->username;
		}
		
		if(!empty($this->input->get("catalogs"))){
			$w["catalog"] = $this->input->get("catalogs");
			$this->data['cur_catalog'] = $this->News_catalogs_model->get($this->input->get("catalogs"));
			$this->data['cur_catalog'] = $this->data['cur_catalog']->title;
		}else{
			$this->data['cur_catalog'] = "Lọc Bài Theo Danh Mục";
		}
		
		$config['base_url'] = current_url();
	
		$config['total_rows'] = $this->News_model->count_by($w);
		
		$config['per_page'] = 20; 
		
		$config['page_query_string'] = TRUE;
		
		$offset = $this->input->get('per_page');

		$this->pagination->initialize($config);
		
		$this->data['getcsdl'] = $this->News_model->getlist($offset,$config['per_page'],$w);
		
		foreach($this->data['getcsdl'] as $key=>$row){
			$catalog = $this->News_catalogs_model->get($row->catalog);
			if($catalog)
				$this->data['getcsdl'][$key]->catalog = $catalog->title;
			else
				$this->data['getcsdl'][$key]->catalog = NULL;
			
		}
		
		$this->data['pagination'] = $this->pagination->create_links();
		
		$this->layout->view(strtolower(__CLASS__.'/'.__FUNCTION__),$this->data);
	}
	public function add(){
	 
		$this->data['title'] = "Thêm Trang Tin";
		$this->form_validation->set_rules('title', 'Tiêu đề', 'trim|required');		
		$this->form_validation->set_rules('slug', 'Slug', 'trim');
		$this->form_validation->set_rules('headingh1', 'Thẻ H1', 'trim');
		$this->form_validation->set_rules('catalog', 'Danh mục', 'trim');
		$this->form_validation->set_rules('themes', 'Chủ đề', 'trim');
		$this->form_validation->set_rules('description', 'E-mail', 'trim');
		$this->form_validation->set_rules('keywords', 'E-mail', 'trim');
		$this->form_validation->set_rules('home_text', 'Nội dung ngắn', 'trim');
		$this->form_validation->set_rules('body_text', 'Nội dung', 'trim');
		$this->form_validation->set_rules('tags', 'Tags', 'trim');
		$this->form_validation->set_rules('article_attached', 'Bài viết kèm theo', 'trim');
		$this->form_validation->set_rules('quick_video', 'Video xem nhanh', 'trim');
		$this->form_validation->set_rules('image-url', 'Image URL', 'trim');	
		$this->form_validation->set_rules('image', 'Hình mình họa', 'trim');

		//Lấy danh sách bài viết liên quan
		$this->data["article_attached"] = array();
		$catalogs = $this->News_catalogs_model->get_by(array("status"=>1));	
		foreach($catalogs as $key=>$row){
			$this->data["article_attached"][$key]["catalog"] = $row;
			$this->data["article_attached"][$key]["post"] = $this->News_model->get_by(array("status"=>1,"catalog"=>$row->id));
		}	
		//#Lấy danh sách bài viết liên quan

		if($this->form_validation->run() == TRUE){

			$cookie = array(
				'name' => 'tmp_catalog',
				'value' => set_value('catalog'),
				'expire' => time()+86500,
				'path'   => '/',
			);
			$this->input->set_cookie($cookie);

			$slug = set_value('slug');
			if(empty($slug))  	
				$slug = $this->ruadmin->slug(set_value('title'),'News_model');	
			else
				$slug = $this->ruadmin->slug(set_value('slug'),'News_model');		

			$h1 = set_value('headingh1');
			if(empty($h1)){
				$h1 = set_value('title');
			}	
			$data = array(
					'title' => trim(set_value('title')),
					'headingh1' => $h1,
					'slug'  => trim($slug),
					'description' => set_value('description'),
					'keywords'  => set_value('keywords'),
					'tags'      => "",
					'quick_video' => "",
					'home_text' => set_value('home_text'),
					'themes'      => "",
					'catalog'   => set_value('catalog'),
					'body_text' => html_entity_decode(set_value('body_text')),
					'tags'      => "",
					'article_attached' => "",
					'status' => 1,
					'created' => $this->data['date_now'],
					'created_by' => $this->data['auth']->username,
					'modified' => $this->data['date_now'],
					'modified_by' => $this->data['auth']->username,
			);

			$id = $this->News_model->insert($data);

			if($id){
				if(empty(set_value('image_lib')) ){	
					if(empty(set_value('image_url')) ){			
						$fileimg = $this->ruadmin->upFile($this->data['config_upload'],'image');

						if($fileimg["status"] == 200 or $fileimg["status"] == 300 ){
							$this->News_model->update( $id,array('image'=>$fileimg["src"]) );	
						}
					}else{
						$fileimg = $this->ruadmin->upload_url(set_value('image_url'),$this->data['config_upload']);
						if($fileimg){
							$this->News_model->update( $id,array('image'=>$fileimg) );	
						}
					}
				}else{		
					$this->News_model->update( $id,array('image'=>set_value('image_lib')) );
				}
			}
			redirect($this->data['module'].'/'.$this->data['controller']);	

		}
		$this->layout->view(strtolower(__CLASS__.'/'.__FUNCTION__),$this->data);  	
	}
	
	public function edit(){
		$this->data['title'] = "Sửa Trang Tin";	
		$id = $this->uri->segment(4);		
    	$this->data['getcsdl'] = $this->News_model->get($id);
	
		$this->form_validation->set_rules('title', 'Tiêu đề', 'trim|required');
		$this->form_validation->set_rules('headingh1', 'Thẻ H1', 'trim|required');
		$this->form_validation->set_rules('slug', 'Slug', 'trim');
		$this->form_validation->set_rules('catalog', 'Danh mục', 'trim');
		$this->form_validation->set_rules('themes', 'Chủ đề', 'trim');
		$this->form_validation->set_rules('description', 'Description', 'trim');
		$this->form_validation->set_rules('keywords', 'Keywords', 'trim');
		$this->form_validation->set_rules('home_text', 'Nội dung ngắn', 'trim');
		$this->form_validation->set_rules('body_text', 'Nội dung', 'trim');
		$this->form_validation->set_rules('tags', 'Tags', 'trim');
		$this->form_validation->set_rules('article_attached', 'Bài viết kèm theo', 'trim');
		$this->form_validation->set_rules('quick_video', 'Video xem nhanh', 'trim');
		
		//Lấy danh sách bài viết liên quan
		$this->data["article_attached"] = array();
		$catalogs = $this->News_catalogs_model->get_by(array("status"=>1));	
		foreach($catalogs as $key=>$row){
			$this->data["article_attached"][$key]["catalog"] = $row;
			$this->data["article_attached"][$key]["post"] = $this->News_model->get_by(array("status"=>1,"catalog"=>$row->id));
		}	
		//#Lấy danh sách bài viết liên quan
		if($this->form_validation->run() == TRUE){  			
			$slug = set_value('slug');
			if(empty($slug))  	
				$slug = $this->ruadmin->slug(set_value('title'),'News_model');	
			else{
				if($slug != $this->data['getcsdl']->slug)
					$slug = $this->ruadmin->slug(set_value('slug'),'News_model');		
			}
			$h1 = set_value('headingh1');
			if(empty($h1)){
				$h1 = set_value('title');
			}	
			$data = array(
					'title' => trim(set_value('title')),
					'headingh1' => $h1,
					'slug'  => trim($slug),
					'description' => set_value('description'),
					'keywords'  => set_value('keywords'),
					'tags'      => "",
					'quick_video' => "",
					'home_text' => set_value('home_text'),
					'themes'      => "",
					'catalog'   => set_value('catalog'),
					'body_text' => html_entity_decode(set_value('body_text')),
					'tags'      => "",
					'article_attached' => "",					
					'modified' => $this->data['date_now'],
					'modified_by' => $this->data['auth']->username,
			);
			
			$this->News_model->update($id,$data);
								
			if(empty(set_value('image_lib')) ){	
				if(empty(set_value('image_url')) ){			
					$fileimg = $this->ruadmin->upFile($this->data['config_upload'],'image');
					$image 	 = $this->data['getcsdl']->image;
					if($fileimg["status"] == 200 or $fileimg["status"] == 300 ){
						$img = $this->ruadmin->removeImg($image,$this->data['config_upload']["dir"]);
						$this->News_model->update( $id,array('image'=>$fileimg["src"]) );	
					}
				}else{
					$fileimg = $this->ruadmin->upload_url(set_value('image_url'),$this->data['config_upload']);
					if($fileimg){
						$img = $this->ruadmin->removeImg($image,$this->data['config_upload']["dir"]);
						$this->News_model->update( $id,array('image'=>$fileimg) );	
					}
				}
			}else{
				$img = $this->ruadmin->removeImg($image,$this->data['config_upload']["dir"]);
				$this->News_model->update( $id,array('image'=>set_value('image_lib')) );
			}			
		  	redirect($this->data['module'].'/'.$this->data['controller']);			  
		}
		$this->layout->view(strtolower(__CLASS__.'/'.__FUNCTION__),$this->data);  		
  }
  public function delete(){	  
		$json = array("status"=>404,"msg"=>"Lỗi thực hiện lệnh","callback"=>"");
		$this->form_validation->set_rules('id', 'ID', 'trim|is_natural_no_zero|required');
		if($this->form_validation->run() == TRUE){
			$id = set_value('id');

			$data = $this->News_model->get_one_by(array('id'=>$id));
			if ($data) {
				if($this->News_model->delete_by( array('id'=>$id) )){
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
			$data = $this->News_model->get_one_by(array('id'=>$id));			
			if ($data) {
				if($data->status == 1)
					$setdata = array('status'=> 0);
				else
					$setdata = array('status'=> 1);
				
				if($this->News_model->update($id,$setdata)){
					$json = array("status"=>200,"msg"=>"Bạn vừa chuyển trạng thái một mục","callback"=>$data->id);
				}
			}else{
				$json["msg"] = "Mục không tồn tại";
			}
		}	
		$this->output->set_content_type('application/json')->set_output(json_encode($json));
	}
}
