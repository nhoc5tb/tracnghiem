<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Block_template extends Admin_Controller {
  
	public function __construct()
	{
		parent::__construct();
		$this->load->library("pagination"); 
		$this->load->model('Ads_model'); 
		$this->load->model('Ads_groups_model'); 
		$this->load->model('Block_model'); 
		$this->data['active_ads'] = "class='active'";
		$this->data['controller_title'] = "Block Template";	
		
		$this->config->load('template');
		$this->data['block']  =  $this->config->item('block');		

		$this->data['block_module'] = $this->config->item('block_module');
	}
  
	public function index()
	{
		$this->data['title'] = "Danh sách Block";	
		
		$this->data['getcsdl'] = $this->Block_model->get();
		
		$this->layout->view(strtolower(__CLASS__.'/'.__FUNCTION__),$this->data);
	}
	
	public function add(){
	  
		$this->data['title'] = "Tạo Giá Trị Cho Block Template";
		
		//những vị trí đã add rồi ko cho add lại nữa
		$block_model = $this->Block_model->get();
		foreach($this->data['block'] as $key=>$row){
			foreach($block_model as $_row){
				if($_row->position == $key){
					unset($this->data['block'][$key]);
				}
			}
		}
		
		$this->form_validation->set_rules('title', 'Tiêu đề', 'trim|required');
		$this->form_validation->set_rules('position', 'Vị Trí', 'trim|required');
		$this->form_validation->set_rules('module', 'Chức năng Block', 'trim|required');
		$this->form_validation->set_rules('content', 'Block Text', 'trim');
		$this->form_validation->set_rules('params', 'Thông Số Phụ', 'trim');
		$this->form_validation->set_rules('show_title', 'Tiêu đề Block', 'trim');
		
		if($this->form_validation->run() == TRUE){		
			$params = set_value('params');
			if(!empty($params)){				
				$params =  json_encode(array($params));
			}else{			
				$params =  null;
			}	
		
			$content = set_value('content');
			
			switch(set_value('module')){
				case 'module_ads':
					$content = null;
					break;
				case 'module_content':
					$params = null;
					break;
				default:
					$content = null;
					$params = null;
					break;
			}	
				
			$data = array(
					'title' =>set_value('title'),
					'position' =>set_value('position'),
					'module'   => set_value('module'),
					'content'  => html_entity_decode($content),
					'params'   => $params,
					'show_title'   => set_value('show_title'),
					'status'       => 1,
					'created'      => $this->data['date_now'],
					'created_by'   => $this->data['auth']->username,
					'modified'     => $this->data['date_now'],
					'modified_by'  => $this->data['auth']->username
			);
			if($this->Block_model->insert($data)){
				redirect($this->data['module'].'/'.$this->data['controller']);
			}
		}		
		$this->layout->view(strtolower(__CLASS__.'/'.strtolower(__FUNCTION__)),$this->data);  	
	}
	
	public function edit(){
	  
		$this->data['title'] = "Sửa Block Template";
		$id = $this->uri->segment(4);	
		$this->data['getcsdl'] = $this->Block_model->get($id);
		$this->data['ads'] = $this->Ads_groups_model->get_by(array("status"=>1));
		if(!$this->data['getcsdl']) show_404();
		
		$this->form_validation->set_rules('title', 'Tiêu đề', 'trim|required');
		$this->form_validation->set_rules('module', 'Chức năng Block', 'trim|required');
		$this->form_validation->set_rules('content', 'Block Text', 'trim');
		$this->form_validation->set_rules('params', 'Thông Số Phụ', 'trim');
		$this->form_validation->set_rules('show_title', 'Tiêu đề Block', 'trim');
		
		if($this->form_validation->run() == TRUE){
			$params = set_value('params');
			if(!empty($params)){				
				$params =  json_encode(array($params));
			}else{			
				$params =  null;
			}	
		
			$content = set_value('content');
			
			switch(set_value('module')){
				case 'module_ads':
					$content = null;
					break;
				case 'module_content':
					$params = null;
					break;
				default:
					$content = null;
					$params = null;
					break;
			}	
				
			$data = array(
					'title'    =>set_value('title'),
					'module'   => set_value('module'),
					'content'  => html_entity_decode($content),
					'params'       => $params,
					'show_title'   => set_value('show_title'),
					'modified'     => $this->data['date_now'],
					'modified_by'  => $this->data['auth']->username
			);
			
			if($this->Block_model->update($id,$data)){
				redirect($this->data['module'].'/'.$this->data['controller']);
			}
		}
		
		$this->layout->view(strtolower(__CLASS__.'/'.strtolower(__FUNCTION__)),$this->data);  	
	}
	
	public function ParamsAds(){	
		$getcsdl = $this->Ads_groups_model->get_by(array("status"=>1));
		
		foreach($getcsdl as $row){
			$data[] = array("id"=>$row->id,"text"=>$row->title);
		}
		$this->output->set_content_type('application/json')->set_output(json_encode($data));	
	}

	public function delete(){	  
		$json = array("status"=>404,"msg"=>"Lỗi thực hiện lệnh","callback"=>"");
		$this->form_validation->set_rules('id', 'ID', 'trim|is_natural_no_zero|required');
		if($this->form_validation->run() == TRUE){
			$id = set_value('id');
			$data = $this->Block_model->get_one_by(array('id'=>$id));			
			if ($data) {
				if($this->Block_model->delete_by( array('id'=>$id) )){
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
			$data = $this->Block_model->get_one_by(array('id'=>$id));			
			if ($data) {
				if($data->status == 1)
					$setdata = array('status'=> 0);
				else
					$setdata = array('status'=> 1);
				
				if($this->Block_model->update($id,$setdata)){
					$json = array("status"=>200,"msg"=>"Bạn vừa chuyển trạng thái một mục","callback"=>$data->id);
				}
			}else{
				$json["msg"] = "Mục không tồn tại";
			}
		}	
		$this->output->set_content_type('application/json')->set_output(json_encode($json));
	}	
}
