<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class Products_trademark extends Admin_Controller {
	public function __construct(){ 
        parent::__construct(); 
		$this->load->model('Products_trademark_model');
		$this->load->model('Products_model');
		
		$this->config->load('template');		
		$this->data['config_upload'] = $this->config->item('image_'.strtolower(__CLASS__));		
		
		$this->data['controller_title'] = "Thương Hiệu";
    } 
	public function index(){
		$this->data['title'] = "Danh sách";		

		$filter = $this->input->get('filter');	
		if(!empty($filter)){
			$filter = (int)$filter;
		}else{
			$filter = 0;
		}
		$this->data['catalogs_full'] = $this->Products_trademark_model->getselect();
		$this->data['catalogs'] = $this->Products_trademark_model->getselect($filter);
		
		$this->layout->view(strtolower(__CLASS__)."/".__FUNCTION__,$this->data);
	}
	
	public function add(){
		$this->data['title'] = "Thêm Thương Hiệu";	
		$input = $this->input->post();
		
		$this->config->load('template');		
		$this->data['config_upload'] = $this->config->item('image_'.strtolower(__CLASS__));	
		$this->data['config_upload']['name'] = "logo";	
		
		if($input){
			$this->form_validation->set_rules('title', 'Tiêu đề', 'trim|required');	
			$this->form_validation->set_rules('slug', 'Tiêu đề link', 'trim');		
			$this->form_validation->set_rules('keywords', 'Keywords', 'trim');		
			$this->form_validation->set_rules('description', 'Description', 'trim');
			$this->form_validation->set_rules('parent_id', 'Thương hiệu con của', 'trim');	
			$this->form_validation->set_rules('order', 'Thứ tự', 'trim');	
			$this->form_validation->set_rules('logo', 'Logo', 'trim');	
			$this->form_validation->set_rules('origin', 'Xuất xứ', 'trim');

			if($this->form_validation->run()== TRUE){
				$slug = $this->input->post('slug');
				if( empty($slug) ){
					$slug = $this->ruadmin->slug($this->input->post('title'),'Products_trademark_model');
				}else {
					$slug = $this->ruadmin->slug($this->input->post('slug'),'Products_trademark_model');
				}
				if(empty(set_value('order'))){
					$order = $this->Products_trademark_model->get_one_by(array("id > "=> 0),"desc");
					$order = ($order->id+1);
				}else{
					$order = set_value('order');
				}

				$setcsdl = array(
							'title'       => set_value('title'),
							'slug'        => $slug,
							'keywords'    => set_value('keywords'),
							'description' => set_value('description'),
							'parent_id'   => set_value('parent_id'),
							'origin'   => set_value('origin'),
							'created'     => $this->data['date_now'],
							'created_by'  => $this->data['auth']->username,
							'status'      => 1,
							'order'       => $order
							);

				$id = $this->Products_trademark_model->insert($setcsdl);
				
				if($id){
					$fileimg = $this->ruadmin->upFile($this->data['config_upload'],'logo');
					if($fileimg["status"] == 200 or $fileimg["status"] == 300 ){
						$this->Products_trademark_model->update( $id,array('logo'=>$fileimg["src"]) );	
					}
					redirect($this->data['module'].'/'.$this->data['controller']);	
				}
			}
		}				
	}

	public function addAjax(){
		
		$input = $this->input->post();		
		$this->config->load('template');		
		$this->data['config_upload'] = $this->config->item('image_'.strtolower(__CLASS__));	
		$this->data['config_upload']['name'] = "logo";	
		
		if($input){
			$this->form_validation->set_rules('title', 'Tiêu đề', 'trim|required');	
			$this->form_validation->set_rules('slug', 'Tiêu đề link', 'trim');		
			$this->form_validation->set_rules('keywords', 'Keywords', 'trim');		
			$this->form_validation->set_rules('description', 'Description', 'trim');
			$this->form_validation->set_rules('parent_id', 'Thương hiệu con của', 'trim');	
			$this->form_validation->set_rules('order', 'Thứ tự', 'trim');	
			$this->form_validation->set_rules('logo', 'Logo', 'trim');	
			$this->form_validation->set_rules('origin', 'Xuất xứ', 'trim');

			if($this->form_validation->run()== TRUE){
				$slug = $this->input->post('slug');
				if( empty($slug) ){
					$slug = $this->ruadmin->slug($this->input->post('title'),'Products_trademark_model');
				}else {
					$slug = $this->ruadmin->slug($this->input->post('slug'),'Products_trademark_model');
				}
				if(empty(set_value('order'))){
					$order = $this->Products_trademark_model->get_one_by(array("id > "=> 0),"desc");					
					$order = ($order->id+1);					
				}else{
					$order = set_value('order');
				}

				$setcsdl = array(
							'title'       => set_value('title'),
							'slug'        => $slug,
							'keywords'    => set_value('keywords'),
							'description' => set_value('description'),
							'parent_id'   => set_value('parent_id'),
							'origin'   => set_value('origin'),
							'created'     => $this->data['date_now'],
							'created_by'  => $this->data['auth']->username,
							'status'      => 1,
							'order'       => $order
							);

				$id = $this->Products_trademark_model->insert($setcsdl);
				
				if($id){
					$fileimg = $this->ruadmin->upFile($this->data['config_upload'],'logo');
					if($fileimg["status"] == 200 or $fileimg["status"] == 300 ){
						$this->Products_trademark_model->update( $id,array('logo'=>$fileimg["src"]) );	
					}
					$trademark = $this->Products_trademark_model->getselect(0);
					$data = array();
					foreach ($trademark as $key => $value) {
						$data[] = array("id"=>$value->id,"text"=>$value->title);
					}					
					$this->output->set_content_type('application/json')->set_output(json_encode(array("status"=>200,"msg"=>"Tạo thành công","data"=>$data)));
				}
			}
		}				
	}
	

	public function edit(){
		try {
			$id = (int)$this->uri->segment(4);
			$this->data['catalogs'] = $this->Products_trademark_model->getselect();
			$this->data['getcsdl'] = $this->Products_trademark_model->get($id);
			$this->data['title'] = "Sửa Thương Hiệu : ".$this->data['getcsdl']->title;
			if(!$this->data['getcsdl']) show_404();			

			$input = $this->input->post();

			if($input){	
				$this->form_validation->set_rules('title', 'Tiêu đề', 'trim|required');	
				$this->form_validation->set_rules('slug', 'Tiêu đề link', 'trim');		
				$this->form_validation->set_rules('keywords', 'Keywords', 'trim');		
				$this->form_validation->set_rules('description', 'Description', 'trim');
				$this->form_validation->set_rules('parent_id', 'Chuyên mục', 'trim');	
				$this->form_validation->set_rules('body_text', 'Bài viết chuyên mục', 'trim');	
				$this->form_validation->set_rules('order', 'Thứ tự', 'trim');		
				$this->form_validation->set_rules('image-url', 'Image URL', 'trim');	
				$this->form_validation->set_rules('image', 'Hình mình họa', 'trim');
				$this->form_validation->set_rules('origin', 'Xuất xứ', 'trim');

				if($this->form_validation->run()== TRUE){
					$slug = $this->input->post('slug');
					if(empty($slug))  
						$slug = $this->ruadmin->slug(set_value('title'),'Products_trademark_model');	
					else{
						if($slug != $this->data['getcsdl']->slug)
							$slug = $this->ruadmin->slug(set_value('slug'),'Products_trademark_model');		
					}
					
					$setcsdl = array(
							'title'       => set_value('title'),
							'slug'        => $slug,							
							'keywords'    => set_value('keywords'),
							'description' => set_value('description'),
							'parent_id'   => set_value('parent_id'),
							'origin'   => set_value('origin'),
							'body_text'   => set_value('body_text'),
							'modified '   => $this->data['date_now'],
							'modified_by' => $this->data['auth']->username,
							'status'      => 1,
							'order'       => set_value('order')
							);	
					if($this->Products_trademark_model->update($id,$setcsdl)){
						// xóa cache
						$this->cachefile->delete($this->data['getcsdl']->slug);
						$this->cachefile->delete_group($this->data['getcsdl']->slug."_");
						//#xóa cache
						$fileimg = $this->ruadmin->upFile($this->data['config_upload'],'logo');
						if($fileimg["status"] == 200 or $fileimg["status"] == 300 ){
							$this->Products_trademark_model->update( $id,array('logo'=>$fileimg["src"]) );	
						}		
						if(empty(set_value('image_lib')) ){	
							if(empty(set_value('image_url')) ){			
								$fileimg = $this->ruadmin->upFile($this->data['config_upload'],'image');

								if($fileimg["status"] == 200 or $fileimg["status"] == 300 ){
									@unlink($this->data['config_upload']["dir"]."/".$this->data['getcsdl']->image);
									@unlink($this->data['config_upload']["dir"]."/thumb/".$this->data['getcsdl']->image);
									@unlink($this->data['config_upload']["dir"]."/min/".$this->data['getcsdl']->image);

									$this->Products_trademark_model->update( $id,array('image'=>$fileimg["src"]) );	
								}
							}else{
								$fileimg = $this->ruadmin->upload_url(set_value('image_url'),$this->data['config_upload']);
								if($fileimg){
									@unlink($this->data['config_upload']["dir"]."/".$this->data['getcsdl']->image);
									@unlink($this->data['config_upload']["dir"]."/thumb/".$this->data['getcsdl']->image);
									@unlink($this->data['config_upload']["dir"]."/min/".$this->data['getcsdl']->image);

									$this->Products_trademark_model->update( $id,array('image'=>$fileimg) );	
								}
							}
						}else{
								@unlink($this->data['config_upload']["dir"]."/".$this->data['getcsdl']->image);
								@unlink($this->data['config_upload']["dir"]."/thumb/".$this->data['getcsdl']->image);
								@unlink($this->data['config_upload']["dir"]."/min/".$this->data['getcsdl']->image);

								$this->Products_trademark_model->update( $id,array('image'=>set_value('image_lib')) );
						}
						redirect($this->data['module'].'/'.$this->data['controller']);
					}
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
			$data = $this->Products_trademark_model->get_one_by(array('id'=>$id));			
			if ($data) {
				$post = $this->Products_model->count_by(array("catalogs"=>$data->id));					
				if(!$post){
					if($this->Products_trademark_model->delete_by( array('id'=>$id) )){
						$this->ruadmin->removeImg($data->image,$this->data['config_upload']["dir"]);						
						$json = array("status"=>200,"msg"=>'Xóa Nhóm "'.$data->title.'" thành công',"callback"=>$data->id);					
					}
				}else{					
					$json = array("status"=>300,"msg"=>'Nhóm "'.$data->title.'" có bài, Xóa/chuyển bài trước',"callback"=>$data->id);
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
			$data = $this->Products_trademark_model->get_one_by(array('id'=>$id));			
			if ($data) {
				if($data->status == 1)
					$setdata = array('status'=> 0);
				else
					$setdata = array('status'=> 1);
				
				if($this->Products_trademark_model->update($id,$setdata)){
					$json = array("status"=>200,"msg"=>"Bạn vừa chuyển trạng thái một mục","callback"=>$data->id);
				}
			}else{
				$json["msg"] = "Mục không tồn tại";
			}
		}	
		$this->output->set_content_type('application/json')->set_output(json_encode($json));
	}
}