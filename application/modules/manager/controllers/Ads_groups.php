<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Ads_groups extends Admin_Controller {
	
	public function __construct(){ 
        parent::__construct(); 
		
		$this->load->model('Ads_groups_model');
		$this->load->model('Ads_model');
		$this->data['controller_title'] = "Nhóm quảng cáo";
		
	} 

	public function index(){

		$this->data['title'] = "Nhóm quảng cáo";		
		
		$this->data['catalogs'] = $this->Ads_groups_model->get_by(array(),"asc",0,0,"order");
		
		$this->layout->view(strtolower(__CLASS__)."/".__FUNCTION__,$this->data);
	}
	
	
	public function add(){

		$this->data['title'] = "Thêm Nhóm Quảng Cáo";	
		
		$input = $this->input->post();
		
		if($input){
			$this->form_validation->set_rules('title', 'Tiêu đề', 'trim|required');	
			$this->form_validation->set_rules('order', 'Thứ tự', 'trim');	

			if($this->form_validation->run()== TRUE){
			
				if(empty(set_value('order'))){
					$order = $this->Ads_groups_model->get_one_by(array("id > "=> 0),"desc");
					$order = ($order->id+1);
				}else{
					$order = set_value('order');
				}
				
				$setcsdl = array(
							'title'       => set_value('title'),
							'created'     => $this->data['date_now'],
							'created_by'  => $this->data['auth']->username,
							'status'      => 1,
							'order'       => $order
							);
				$id = $this->Ads_groups_model->insert($setcsdl);
				if($id){					
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
			
			$this->data['catalogs'] = $this->Ads_groups_model->get_by(array("status"=>1));

			$this->data['getcsdl'] = $this->Ads_groups_model->get($id);

			$this->data['title'] = "Sửa Nhóm Quảng Cáo : ".$this->data['getcsdl']->title;

			if(!$this->data['getcsdl']) show_404();
			
			$input = $this->input->post();

			if($input){		

				$this->form_validation->set_rules('title', 'Tiêu đề', 'trim|required');					
				$this->form_validation->set_rules('order', 'Thứ tự', 'trim');		

				if($this->form_validation->run()== TRUE){	
					$setcsdl = array(
							'title'       => set_value('title'),
							'modified '   => $this->data['date_now'],
							'modified_by' => $this->data['auth']->username,
							'status'      => 1,
							'order'       => set_value('order')
							);							

					if($this->Ads_groups_model->update($id,$setcsdl)){
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
			$data = $this->Ads_groups_model->get_one_by(array('id'=>$id));			
			if ($data) {
				$post = $this->Ads_model->count_by(array("id_group"=>$data->id));					
				if(!$post){
					if($this->Ads_groups_model->delete_by( array('id'=>$id) )){						
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
			$data = $this->Ads_groups_model->get_one_by(array('id'=>$id));			
			if ($data) {
				if($data->status == 1)
					$setdata = array('status'=> 0);
				else
					$setdata = array('status'=> 1);
				
				if($this->Ads_groups_model->update($id,$setdata)){
					$json = array("status"=>200,"msg"=>"Bạn vừa chuyển trạng thái một mục","callback"=>$data->id);
				}
			}else{
				$json["msg"] = "Mục không tồn tại";
			}
		}	
		$this->output->set_content_type('application/json')->set_output(json_encode($json));
	}	
	function check_group($id_old,$id_new){
		if($id_old == $id_new){
			$this->form_validation->set_message('check_group', 'Không thể là danh mục con của chính minh');
			return FALSE;
		}
	}

}