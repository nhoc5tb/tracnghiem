<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class Products_collection extends Admin_Controller {
	public function __construct(){ 
        parent::__construct(); 
		$this->load->model('Products_trademark_model');
		$this->load->model('Products_collection_model');
		$this->load->model('Products_catalogs_model');
		$this->load->model('Products_model');
		
		$this->config->load('template');		
		$this->data['config_upload'] = $this->config->item('image_'.strtolower(__CLASS__));	

		$this->data['controller_title'] = "Bộ sưu tập - Dòng sản phẩm";
    } 
	public function index(){
		$this->data['title'] = "Danh sách Bộ sưu tập & Dòng sản phẩm";
		$this->data['getcsdl'] = $this->Products_collection_model->getlist();		
		$this->data['trademark'] = $this->Products_trademark_model->get_by(array("status"=>1));
	
		$this->layout->view(strtolower(__CLASS__)."/".__FUNCTION__,$this->data);
	}
	
	public function add(){
		$this->data['title'] = "Thêm Bộ sưu tập - Dòng sản phẩm";	
		$input = $this->input->post();
		
		$this->config->load('template');		
		$this->data['config_upload'] = $this->config->item('image_'.strtolower(__CLASS__));	
		$this->data['config_upload']['name'] = "logo";	
		
		if($input){
			$this->form_validation->set_rules('title', 'Tiêu đề', 'trim|required');	
			$this->form_validation->set_rules('slug', 'Tiêu đề link', 'trim');		
			$this->form_validation->set_rules('keywords', 'Keywords', 'trim');		
			$this->form_validation->set_rules('description', 'Description', 'trim');
			$this->form_validation->set_rules('trademark', 'Thương hiệu', 'trim');	
			$this->form_validation->set_rules('order', 'Thứ tự', 'trim');	
			$this->form_validation->set_rules('image-url', 'Image URL', 'trim');	
			$this->form_validation->set_rules('image', 'Hình mình họa', 'trim');

			if($this->form_validation->run()== TRUE){
				$slug = $this->input->post('slug');
				if( empty($slug) ){
					$slug = $this->ruadmin->slug($this->input->post('title'),'Products_collection_model');
				}else {
					$slug = $this->ruadmin->slug($this->input->post('slug'),'Products_collection_model');
				}
				if(empty(set_value('order'))){
					$order = $this->Products_collection_model->get_one_by(array("id > "=> 0),"desc");
					$order = ($order->id+1);
				}else{
					$order = set_value('order');
				}

				$setcsdl = array(
							'name'       => set_value('title'),
							'slug'        => $slug,
							'keywords'    => set_value('keywords'),
							'description' => set_value('description'),
							'id_trademark'   => set_value('trademark'),
							'status'      => 1,
							'order'       => $order
							);

				$id = $this->Products_collection_model->insert($setcsdl);
				
				if($id){
					$fileimg = $this->ruadmin->upFile($this->data['config_upload'],'image');
					if($fileimg["status"] == 200 or $fileimg["status"] == 300 ){
						$this->Products_collection_model->update( $id,array('image'=>$fileimg["src"]) );	
					}
					redirect($this->data['module'].'/'.$this->data['controller']);	
				}
			}
		}
		$this->layout->view(strtolower(__CLASS__)."/".__FUNCTION__,$this->data);
	}
	

	public function edit(){
		try {
			$id = (int)$this->uri->segment(4);
			$this->data['folder'] = $this->config->item('image_products');	

			$this->data['trademark'] = $this->Products_trademark_model->getselect();
			$this->data['catalogs'] = $this->Products_catalogs_model->getselect();
			$this->data['getcsdl'] = $this->Products_collection_model->get($id);
			$this->data["products"] = array();
			if(!empty($this->data['getcsdl']->products)){
				$id_product = json_decode($this->data['getcsdl']->products);
				if (count($id_product) > 0) {
					$this->data["products"] = $this->Products_model->getlist(0, 0,null, "id", array("id"=>$id_product));
				}		
			}
			

			$this->data['title'] = "Sửa : ".$this->data['getcsdl']->name;
			if(!$this->data['getcsdl']) show_404();			

			$this->form_validation->set_rules('title', 'Tiêu đề', 'trim|required');	
			$this->form_validation->set_rules('slug', 'Tiêu đề link', 'trim');		
			$this->form_validation->set_rules('keywords', 'Keywords', 'trim');		
			$this->form_validation->set_rules('description', 'Description', 'trim');
			$this->form_validation->set_rules('trademark', 'Thương hiệu', 'trim');
			$this->form_validation->set_rules('body_text', 'Giới thiệu', 'trim');	
			$this->form_validation->set_rules('product_combo[]', 'Sản phẩm', 'trim');
			$this->form_validation->set_rules('order', 'Thứ tự', 'trim');	
			$this->form_validation->set_rules('image_url', 'Image URL', 'trim');	
			$this->form_validation->set_rules('image', 'Hình mình họa', 'trim');
			$this->form_validation->set_rules('image_lib', 'Hình mình họa', 'trim');

			if($this->form_validation->run()== TRUE){
				$slug = $this->input->post('slug');
				if(empty($slug))  
					$slug = $this->ruadmin->slug(set_value('title'),'Products_collection_model');	
				else{
						if($slug != $this->data['getcsdl']->slug)
							$slug = $this->ruadmin->slug(set_value('slug'),'Products_collection_model');		
				}
				//--- xử lý sản phẩm gợi ý				
				$setcsdl = array(
							'name'        => set_value('title'),
							'slug'        => $slug,							
							'keywords'    => set_value('keywords'),
							'description' => set_value('description'),
							'id_trademark'   => set_value('trademark'),
							'body_text'   => set_value('body_text'),
							'order'       => set_value('order'),
							'order'       => set_value('order')
							);
				if(!empty(set_value('product_combo')))
					$setcsdl["products"] = json_encode(set_value('product_combo'));
				else{
					//$product_combo = null;
				}
				if($this->Products_collection_model->update($id,$setcsdl)){
					if(empty(set_value('image_lib')) ){	
						if(empty(set_value('image_url')) ){			
								$fileimg = $this->ruadmin->upFile($this->data['config_upload'],'image');

								if($fileimg["status"] == 200 or $fileimg["status"] == 300 ){
									$this->ruadmin->removeImg($this->data['getcsdl']->image,$this->data['config_upload']["dir"]);
									$this->Products_collection_model->update( $id,array('image'=>$fileimg["src"]) );	
								}
						}else{
								$fileimg = $this->ruadmin->upload_url(set_value('image_url'),$this->data['config_upload']);
								if($fileimg){
									$this->ruadmin->removeImg($this->data['getcsdl']->image,$this->data['config_upload']["dir"]);
									$this->Products_collection_model->update( $id,array('image'=>$fileimg) );	
								}
						}
					}else{
						$this->ruadmin->removeImg($this->data['getcsdl']->image,$this->data['config_upload']["dir"]);
						$this->Products_collection_model->update( $id,array('image'=>set_value('image_lib')) );
					}
					redirect($this->data['module'].'/'.$this->data['controller']);
				}
			}

			$this->layout->view(strtolower(__CLASS__)."/".__FUNCTION__,$this->data);	

		}catch (Exception $e) {
			echo $e->getMessage(); die();
		}
	}

	public function delete(){
	  
		$json = array("status"=>404,"msg"=>"Lỗi thực hiện lệnh","callback"=>"");
		$this->form_validation->set_rules('id', 'ID', 'trim|is_natural_no_zero|required');
		if($this->form_validation->run() == TRUE){
			$id = set_value('id');
			$data = $this->Products_collection_model->get_one_by(array('id'=>$id));			
			if ($data) {
				$post = json_decode($data->products);					
				if(!$post){
					if($this->Products_collection_model->delete_by( array('id'=>$id) )){
						$this->ruadmin->removeImg($data->image,$this->data['config_upload']["dir"]);						
						$json = array("status"=>200,"msg"=>'Xóa Nhóm "'.$data->name.'" thành công',"callback"=>$data->id);					
					}
				}else{					
					$json = array("status"=>300,"msg"=>'Nhóm "'.$data->name.'" có bài, Xóa/chuyển bài trước',"callback"=>$data->id);
				}
			}
		}	
		$this->output->set_content_type('application/json')->set_output(json_encode($json));
	}
  
	public function status(){
	  
		$json = array("status"=>404,"msg"=>"Lỗi thực hiện lệnh","callback"=>"");
		$this->form_validation->set_rules('id', 'ID', 'trim|is_natural_no_zero|required');
		if($this->form_validation->run() == TRUE){
			$id = set_value('id');
			$data = $this->Products_collection_model->get_one_by(array('id'=>$id));			
			if ($data) {
				if($data->status == 1)
					$setdata = array('status'=> 0);
				else
					$setdata = array('status'=> 1);
				
				if($this->Products_collection_model->update($id,$setdata)){
					$json = array("status"=>200,"msg"=>"Bạn vừa chuyển trạng thái một mục","callback"=>$data->id);
				}
			}else{
				$json["msg"] = "Mục không tồn tại";
			}
		}	
		$this->output->set_content_type('application/json')->set_output(json_encode($json));
	}

	public function ajax_get(){	  
		$json = array("status"=>404,"msg"=>"Lỗi thực hiện lệnh","data"=>"");
		$this->form_validation->set_rules('id', 'ID', 'trim|is_natural_no_zero|required');
		if($this->form_validation->run() == TRUE){
			$id = set_value('id');
			$collection = $this->Products_collection_model->get_by(array('id_trademark'=>$id));	
			$data[0] = array("id"=>0,"text"=>"Chọn dòng sp");
			if ($collection) {
				foreach ($collection as $key => $value) {
					$data[] = array("id"=>$value->id,"text"=>html_entity_decode($value->name));
				}						
				$json = array("status"=>200,"msg"=>"Đã lấy được dữ liệu dòng sản phẩm","data"=>$data);
			}else{			
				$json = array("status"=>200,"msg"=>"Chưa có dòng sản phẩm cho thương hiệu này","data"=>$data);
			}
		}	
		$this->output->set_content_type('application/json')->set_output(json_encode($json));
	}

}