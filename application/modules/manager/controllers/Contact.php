<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Contact extends Admin_Controller {
  
  public function __construct()
  {
    parent::__construct();
	$this->load->model('Contact_model'); 
	
	$this->data['active_page'] = "class='active'";
	
	$this->data['controller_title'] = "Liên Hệ";
	
	$this->load->library("pagination");
	
  }
  public function index()
  {
		$this->data['title'] = "Danh sách Liên Hệ";	
		
		$w = array();
		
		$config['base_url'] = current_url();
	
		$config['total_rows'] = $this->Contact_model->count_by($w);
		
		$config['per_page'] = 20; 
		
		$config['page_query_string'] = TRUE;
		
		$offset = $this->input->get('per_page');

		$this->pagination->initialize($config);
		
		$this->data['getcsdl'] = $this->Contact_model->get_by($w,"asc",$offset,$config['per_page']);
		
		$this->data['pagination'] = $this->pagination->create_links();
		
		$this->layout->view(strtolower(__CLASS__.'/'.__FUNCTION__),$this->data);
  }
  
  public function view()
  {
  	$this->data['title'] = "Chi tiết liên hệ";	
  	$id = $this->uri->segment(4);	
	$this->data['getcsdl'] = $this->Contact_model->get($id);
		
	$this->layout->view(strtolower(__CLASS__.'/'.__FUNCTION__),$this->data);
  }
	
  
  public function delete(){	  
		$json = array("status"=>404,"msg"=>"Lỗi thực hiện lệnh","callback"=>"");
		$this->form_validation->set_rules('id', 'ID', 'trim|is_natural_no_zero|required');
		if($this->form_validation->run() == TRUE){
			$id = set_value('id');
			$data = $this->Contact_model->get_one_by(array('id'=>$id));			
			if ($data) {
				if($this->Contact_model->delete_by( array('id'=>$id) )){						
					$json = array("status"=>200,"msg"=>'Xóa thành công',"callback"=>$data->id);					
				}
			}
		}	
		$this->output->set_content_type('application/json')->set_output(json_encode($json));
	}
  

}
