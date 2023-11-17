<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Email extends Admin_Controller {
  
	public function __construct()
	{
		parent::__construct();
		$this->load->model('Mail_model'); 	
		$this->data['active_page'] = "class='active'";	
		$this->data['controller_title'] = "Mail";	
		$this->load->library("pagination");	
		$this->data['controller_title'] = "Mail";
	}
	
	public function index()
	{
		$this->data['title'] = "Danh sách Mail";	
		
		$w = array();
		
		$config['base_url'] = current_url();
	
		$config['total_rows'] = $this->Mail_model->count_by($w);
		
		$config['per_page'] = 20; 
		
		$config['page_query_string'] = TRUE;
		
		$offset = $this->input->get('per_page');

		$this->pagination->initialize($config);
		
		$this->data['getcsdl'] = $this->Mail_model->get_by($w,"asc",$offset,$config['per_page']);
		
		$this->data['pagination'] = $this->pagination->create_links();
		
		$this->layout->view(strtolower(__CLASS__.'/'.__FUNCTION__),$this->data);
	}
	
	public function edit(){
		$this->data['title'] = "Sửa Bài Viết";	
		$id = $this->uri->segment(4);		
    	$this->data['getcsdl'] = $this->Mail_model->get($id);
		
		$this->form_validation->set_rules('name', 'Tên Mail', 'trim|required');
		$this->form_validation->set_rules('subject', 'Tiên đề', 'trim|required');
		$this->form_validation->set_rules('content', 'Nội dụng', 'trim|required');
	
		if($this->form_validation->run() == TRUE){  
		
			$data = array(
					'name' => set_value('name'),
					'subject' => set_value('subject'),
					'content' => html_entity_decode(set_value('content')),					
					'status' => 1,
					'modified' => $this->data['date_now'],
					'modified_by' => $this->data['auth']->username,
			);
			
			if($this->Mail_model->update($id,$data)){				
				redirect($this->data['module'].'/'.$this->data['controller']);	
			}   		  
		  
		}
		$this->layout->view(strtolower(__CLASS__.'/'.__FUNCTION__),$this->data);  		
	}
  	public function status(){
		$json = array("status"=>404,"msg"=>"Lỗi thực hiện lệnh","callback"=>"");
		$this->form_validation->set_rules('id', 'ID', 'trim|is_natural_no_zero|required');
		if($this->form_validation->run() == TRUE){
			$id = set_value('id');
			$data = $this->Mail_model->get_one_by(array('id'=>$id));			
			if ($data) {
				if($data->status == 1)
					$setdata = array('status'=> 0);
				else
					$setdata = array('status'=> 1);
				
				if($this->Mail_model->update($id,$setdata)){
					$json = array("status"=>200,"msg"=>"Bạn vừa chuyển trạng thái một mục","callback"=>$data->id);
				}
			}else{
				$json["msg"] = "Mục không tồn tại";
			}
		}	
		$this->output->set_content_type('application/json')->set_output(json_encode($json));
	}
}
