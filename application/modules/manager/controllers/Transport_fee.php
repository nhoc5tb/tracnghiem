<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Transport_fee extends Admin_Controller {
  
  	public function __construct()
  	{
    	parent::__construct();
		$this->load->model('Transport_fee_model'); 	
		$this->data['active_page'] = "class='active'";	
		$this->data['controller_title'] = "Phí vận chuyển";	
		$this->load->library("pagination");
  	}
  	public function index()
  	{
		$this->data['title'] = "Danh sách vùng hỗ trợ vận chuyển";	

		$w = array();
		
		$config['base_url'] = current_url();
	
		$config['total_rows'] = $this->Transport_fee_model->count_by($w);
		
		$config['per_page'] = 20; 
		
		$config['page_query_string'] = TRUE;
		
		$offset = $this->input->get('per_page');

		$this->pagination->initialize($config);
		
		$this->data['getcsdl'] = $this->Transport_fee_model->get_by($w);
		
		$this->data['pagination'] = $this->pagination->create_links();
		
		$this->layout->view(strtolower(__CLASS__.'/'.__FUNCTION__),$this->data);
  	}

  	public function update()
  	{
		$json = array("status"=>404,"msg"=>"Lỗi thực hiện lệnh","callback"=>"");
		$this->form_validation->set_rules('code', 'ID', 'trim|required');
		$this->form_validation->set_rules('price', 'ID', 'trim|required');
		if($this->form_validation->run() == TRUE){
			$id = set_value('code');
			$data = $this->Transport_fee_model->get_one_by(array('code'=>$id));			
			if ($data) {
				 $this->Transport_fee_model->update_by(array('code'=>$id), array('price'=>set_value('price')));	
				$json = array("status"=>200,"msg"=>"Giá vận chuyển đã được thay đổi","callback"=>$data->id);
			}else{
				$json["msg"] = "Không cập nhật được giá vận chuyển";
			}
		}	
		$this->output->set_content_type('application/json')->set_output(json_encode($json));
  	}
}
