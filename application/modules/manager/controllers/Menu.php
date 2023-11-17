<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Menu extends Admin_Controller {
	
	public function __construct(){ 
        parent::__construct(); 
		
		$this->load->model('Menu_model');
		$this->data['controller_title'] = "Menu Website";
		
		$this->config->load('template');		
		$this->data['config_upload'] = $this->config->item('image_'.strtolower(__CLASS__));	
		
	} 

	public function index(){

		$this->data['title'] = "Danh Mục";				
		$this->data['catalogs'] = $this->Menu_model->getselect();
		
		$this->layout->view(strtolower(__CLASS__)."/".__FUNCTION__,$this->data);
	}
	
	
	public function add(){

		$this->data['title'] = "Danh Mục";	
		
		$input = $this->input->post();
		
		if($input){
			$this->form_validation->set_rules('title', 'Tiêu đề', 'trim|required');	
			$this->form_validation->set_rules('slug', 'Tiêu đề link', 'trim');					
			$this->form_validation->set_rules('parent_id', 'Chuyên mục', 'trim');	
			$this->form_validation->set_rules('order', 'Thứ tự', 'trim');	
			$this->form_validation->set_rules('image-url', 'Image URL', 'trim');	
			$this->form_validation->set_rules('image', 'Hình mình họa', 'trim');		

			if($this->form_validation->run()== TRUE){
					
				if(empty(set_value('order'))){
					$order = $this->Menu_model->get_one_by(array("id > "=> 0),"desc");
					$order = ($order->id+1);
				}else{
					$order = set_value('order');
				}
				
				$setcsdl = array(
							'title'       => set_value('title'),
							'slug'        => set_value('slug'),
							'parent_id'   => set_value('parent_id'),
							'created'     => $this->data['date_now'],
							'created_by'  => $this->data['auth']->username,
							'status'      => 1,
							'order'       => $order
							);
				$id = $this->Menu_model->insert($setcsdl);
				if($id){
					if(empty(set_value('image_lib')) ){	
						if(empty(set_value('image_url')) ){			
							$fileimg = $this->ruadmin->upFile($this->data['config_upload'],'image');

							if($fileimg["status"] == 200 or $fileimg["status"] == 300 ){
								$this->Menu_model->update( $id,array('image'=>$fileimg["src"]) );	
							}
						}else{
							$fileimg = $this->ruadmin->upload_url(set_value('image_url'),$this->data['config_upload']);
							if($fileimg){
								$this->Menu_model->update( $id,array('image'=>$fileimg) );	
							}
						}
					}else{		
						$this->Menu_model->update( $id,array('image'=>set_value('image_lib')) );
					}
					redirect($this->data['module'].'/'.$this->data['controller']);	
				}
			}else{
				redirect($this->data['module'].'/'.$this->data['controller']);	
			}
		}
		$this->layout->view(strtolower(__CLASS__)."/".__FUNCTION__,$this->data);
	}

	

	public function edit(){

		try {

			$id = (int)$this->uri->segment(4);
			
			$this->data['catalogs'] = $this->Menu_model->getselect();

			$this->data['getcsdl'] = $this->Menu_model->get($id);

			$this->data['title'] = "Sửa Menu : ".$this->data['getcsdl']->title;

			if(!$this->data['getcsdl']) show_404();
			
			$input = $this->input->post();

			if($input){		

				$this->form_validation->set_rules('title', 'Tiêu đề', 'trim|required');	
				$this->form_validation->set_rules('slug', 'Tiêu đề link', 'trim');			
				$this->form_validation->set_rules('parent_id', 'Chuyên mục', 'trim');	
				$this->form_validation->set_rules('order', 'Thứ tự', 'trim');		
				$this->form_validation->set_rules('image-url', 'Image URL', 'trim');	
				$this->form_validation->set_rules('image', 'Hình mình họa', 'trim');		

				if($this->form_validation->run()== TRUE){	


					$setcsdl = array(
							'title'       => set_value('title'),
							'slug'        => set_value('slug'),
							'parent_id'   => set_value('parent_id'),
							'modified '   => $this->data['date_now'],
							'modified_by' => $this->data['auth']->username,
							'status'      => 1,
							'order'       => set_value('order')
							);							

					if($this->Menu_model->update($id,$setcsdl)){
						if(empty(set_value('image_lib')) ){	
							if(empty(set_value('image_url')) ){			
								$fileimg = $this->ruadmin->upFile($this->data['config_upload'],'image');

								if($fileimg["status"] == 200 or $fileimg["status"] == 300 ){
									@unlink($this->data['config_upload']["dir"]."/".$this->data['getcsdl']->image);
									@unlink($this->data['config_upload']["dir"]."/thumb/".$this->data['getcsdl']->image);
									@unlink($this->data['config_upload']["dir"]."/min/".$this->data['getcsdl']->image);

									$this->Menu_model->update( $id,array('image'=>$fileimg["src"]) );	
								}
							}else{
								$fileimg = $this->ruadmin->upload_url(set_value('image_url'),$this->data['config_upload']);
								if($fileimg){
									@unlink($this->data['config_upload']["dir"]."/".$this->data['getcsdl']->image);
									@unlink($this->data['config_upload']["dir"]."/thumb/".$this->data['getcsdl']->image);
									@unlink($this->data['config_upload']["dir"]."/min/".$this->data['getcsdl']->image);

									$this->Menu_model->update( $id,array('image'=>$fileimg) );	
								}
							}
						}else{
								@unlink($this->data['config_upload']["dir"]."/".$this->data['getcsdl']->image);
								@unlink($this->data['config_upload']["dir"]."/thumb/".$this->data['getcsdl']->image);
								@unlink($this->data['config_upload']["dir"]."/min/".$this->data['getcsdl']->image);

								$this->Menu_model->update( $id,array('image'=>set_value('image_lib')) );
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
			$data = $this->Menu_model->get_one_by(array('id'=>$id));			
			if ($data) {
				$post = $this->Menu_model->count_by(array("parent_id"=>$data->id));					
				if($post){			
					$this->Menu_model->delete_by( array('parent_id'=>$data->id ));
				}
				if( $this->Menu_model->delete_by( array('id'=>$id) )){	
					$this->ruadmin->removeImg($data->image,$this->data['config_upload']["dir"]);					
					$json = array("status"=>200,"msg"=>'Xóa Nhóm "'.$data->title.'" thành công',"callback"=>$data->id);					
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
			$data = $this->Menu_model->get_one_by(array('id'=>$id));			
			if ($data) {
				if($data->status == 1)
					$setdata = array('status'=> 0);
				else
					$setdata = array('status'=> 1);
				
				if($this->Menu_model->update($id,$setdata)){
					$json = array("status"=>200,"msg"=>"Bạn vừa chuyển trạng thái một mục","callback"=>$data->id);
				}
			}else{
				$json["msg"] = "Mục không tồn tại";
			}
		}	
		$this->output->set_content_type('application/json')->set_output(json_encode($json));
	}

}