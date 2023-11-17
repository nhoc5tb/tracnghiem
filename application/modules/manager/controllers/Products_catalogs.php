<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Products_catalogs extends Admin_Controller {
	public function __construct(){ 
        parent::__construct(); 
		$this->load->model('products_catalogs_model');
		$this->load->model('products_model');
		$this->load->model('attrib_insert_group_model');
		$this->load->model('attrib_check_group_model');
		
		$this->config->load('template');		
		$this->data['config_upload'] = $this->config->item('image_'.strtolower(__CLASS__));		
		
		$this->data['controller_title'] = "Danh mục sản phẩm";
    } 
	public function index(){
		$this->data['title'] = "Danh sách";		

		$filter = $this->input->get('filter');	
		if(!empty($filter)){
			$filter = (int)$filter;
		}else{
			$filter = 0;
		}
		$this->data['catalogs_full'] = $this->products_catalogs_model->getselect();
		$this->data['catalogs'] = $this->products_catalogs_model->getselect($filter);
		$input = $this->input->post();
		
		if($input){

			$this->form_validation->set_rules('title', 'Tiêu đề', 'trim|required');	
			$this->form_validation->set_rules('slug', 'Tiêu đề link', 'trim');	
			$this->form_validation->set_rules('keywords', 'Keywords', 'trim');	
			$this->form_validation->set_rules('description', 'Description', 'trim');
			$this->form_validation->set_rules('parent_id', 'Chuyên mục', 'trim');	
			$this->form_validation->set_rules('order', 'Thứ tự', 'trim');	
			$this->form_validation->set_rules('image-url', 'Image URL', 'trim');
			$this->form_validation->set_rules('image', 'Hình mình họa', 'trim');

			if($this->form_validation->run()== TRUE){
				$slug = $this->input->post('slug');
				if( empty($slug) ){
					$slug = $this->ruadmin->slug($this->input->post('title'),'products_catalogs_model');
				}else {
					$slug = $this->ruadmin->slug($this->input->post('slug'),'products_catalogs_model');
				}
				if(empty(set_value('order'))){
					$order = $this->products_catalogs_model->get_one_by(array("id > "=> 0),"desc");
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
							'created'     => $this->data['date_now'],
							'created_by'  => $this->data['auth']->username,
							'status'      => 1,
							'order'       => $order
							);

				$id = $this->products_catalogs_model->insert($setcsdl);

				if($id){
					if(empty(set_value('image_lib')) ){	
						if(empty(set_value('image_url')) ){			
							$fileimg = $this->ruadmin->upFile($this->data['config_upload'],'image');

							if($fileimg["status"] == 200 or $fileimg["status"] == 300 ){
								$this->products_catalogs_model->update( $id,array('image'=>$fileimg["src"]) );	
							}
						}else{
							$fileimg = $this->ruadmin->upload_url(set_value('image_url'),$this->data['config_upload']);
							if($fileimg){
								$this->products_catalogs_model->update( $id,array('image'=>$fileimg) );	
							}
						}
					}else{		
						$this->products_catalogs_model->update( $id,array('image'=>set_value('image_lib')) );
					}
					redirect($this->data['module'].'/'.$this->data['controller']);
				}
			}
		}
		$this->layout->view(strtolower(__CLASS__)."/".__FUNCTION__,$this->data);
	}
	
	public function add(){
		$this->data['title'] = "Thêm Danh Mục";	
		$input = $this->input->post();
		if($input){
			$this->form_validation->set_rules('title', 'Tiêu đề', 'trim|required');	
			$this->form_validation->set_rules('slug', 'Tiêu đề link', 'trim');		
			$this->form_validation->set_rules('keywords', 'Keywords', 'trim');		
			$this->form_validation->set_rules('description', 'Description', 'trim');
			$this->form_validation->set_rules('parent_id', 'Chuyên mục', 'trim');	
			$this->form_validation->set_rules('order', 'Thứ tự', 'trim');	
			$this->form_validation->set_rules('image-url', 'Image URL', 'trim');	
			$this->form_validation->set_rules('image', 'Hình mình họa', 'trim');	

			if($this->form_validation->run()== TRUE){
				$slug = $this->input->post('slug');
				if( empty($slug) ){
					$slug = $this->ruadmin->slug($this->input->post('title'),'products_catalogs_model');
				}else {
					$slug = $this->ruadmin->slug($this->input->post('slug'),'products_catalogs_model');
				}
				if(empty(set_value('order'))){
					$order = $this->products_catalogs_model->get_one_by(array("id > "=> 0),"desc");
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
							'created'     => $this->data['date_now'],
							'created_by'  => $this->data['auth']->username,
							'status'      => 1,
							'order'       => $order
							);

				$id = $this->products_catalogs_model->insert($setcsdl);
				if($id){
					if(empty(set_value('image_lib')) ){	
						if(empty(set_value('image_url')) ){			
							$fileimg = $this->ruadmin->upFile($this->data['config_upload'],'image');

							if($fileimg["status"] == 200 or $fileimg["status"] == 300 ){
								$this->products_catalogs_model->update( $id,array('image'=>$fileimg["src"]) );	
							}
						}else{
							$fileimg = $this->ruadmin->upload_url(set_value('image_url'),$this->data['config_upload']);
							if($fileimg){	
								$this->products_catalogs_model->update( $id,array('image'=>$fileimg) );	
							}
						}
					}else{
							$this->products_catalogs_model->update( $id,array('image'=>set_value('image_lib')) );
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
			//--- thuoc tinh nhập
			$this->data['attrib'] = $this->attrib_insert_group_model->get();

			//--- thuoc tinh chọn
			$this->data['attrib_check'] = $this->attrib_check_group_model->get();

			//--- #thuoc tinh chon
			$this->data['catalogs'] = $this->products_catalogs_model->getselect();

			$this->data['getcsdl'] = $this->products_catalogs_model->get($id);

			$this->data['title'] = "Sửa Danh Mục : ".$this->data['getcsdl']->title;

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

				if($this->form_validation->run()== TRUE){
					$slug = $this->input->post('slug');
					if(empty($slug))  
						$slug = $this->ruadmin->slug(set_value('title'),'products_catalogs_model');	
					else{
						if($slug != $this->data['getcsdl']->slug)
							$slug = $this->ruadmin->slug(set_value('slug'),'products_catalogs_model');		
					}
					
					$setcsdl = array(
							'title'       => set_value('title'),
							'slug'        => $slug,
							'attrib'      => (isset($input['attrib']))?json_encode($input['attrib']):"",
							'attrib_check'=> (isset($input['attrib_check']))?json_encode($input['attrib_check']):"",
							'keywords'    => set_value('keywords'),
							'description' => set_value('description'),
							'parent_id'   => set_value('parent_id'),
							'body_text'   => set_value('body_text'),
							'modified '   => $this->data['date_now'],
							'modified_by' => $this->data['auth']->username,
							'status'      => 1,
							'order'       => set_value('order')
							);	
					if($this->products_catalogs_model->update($id,$setcsdl)){
						if(empty(set_value('image_lib')) ){	
							if(empty(set_value('image_url')) ){			
								$fileimg = $this->ruadmin->upFile($this->data['config_upload'],'image');

								if($fileimg["status"] == 200 or $fileimg["status"] == 300 ){
									$this->ruadmin->removeImg($this->data['getcsdl']->image,$this->data['config_upload']["dir"]);
									$this->products_catalogs_model->update( $id,array('image'=>$fileimg["src"]) );	
								}
							}else{
								$fileimg = $this->ruadmin->upload_url(set_value('image_url'),$this->data['config_upload']);
								if($fileimg){
									$this->ruadmin->removeImg($this->data['getcsdl']->image,$this->data['config_upload']["dir"]);
									$this->products_catalogs_model->update( $id,array('image'=>$fileimg) );	
								}
							}
						}else{
								$this->ruadmin->removeImg($this->data['getcsdl']->image,$this->data['config_upload']["dir"]);
								$this->products_catalogs_model->update( $id,array('image'=>set_value('image_lib')) );
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
			$data = $this->products_catalogs_model->get_one_by(array('id'=>$id));			
			if ($data) {
				$post = $this->products_model->count_by(array("catalogs"=>$data->id));					
				if(!$post){
					if($this->products_catalogs_model->delete_by( array('id'=>$id) )){	
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
			$data = $this->products_catalogs_model->get_one_by(array('id'=>$id));			
			if ($data) {
				if($data->status == 1)
					$setdata = array('status'=> 0);
				else
					$setdata = array('status'=> 1);
				
				if($this->products_catalogs_model->update($id,$setdata)){
					$json = array("status"=>200,"msg"=>"Bạn vừa chuyển trạng thái một mục","callback"=>$data->id);
				}
			}else{
				$json["msg"] = "Mục không tồn tại";
			}
		}	
		$this->output->set_content_type('application/json')->set_output(json_encode($json));
	}
}