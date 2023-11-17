<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class OrderFlash extends Admin_Controller {
  
	public function __construct(){
		parent::__construct();
		
		$this->load->model('Products_model'); 		
		$this->load->model('Users_model'); 			
		$this->load->model('Order_flash_model');
		
		$this->data['active_sale'] = "class='active'";
	}
  
	public function index(){
		
		$this->data['title'] = "Khách đặt qua báo giá";	
		
		$w = array('status >='=> 0);
		
		$config['base_url'] = current_url();
	
		$config['per_page'] = 80; 
		
		$config['page_query_string'] = TRUE;
		
		$offset = $this->input->get('per_page');
		
		$this->data['getcsdl'] = $this->Order_flash_model->getlist($offset,$config['per_page'],$w);
		
		$config['total_rows'] = $this->data['getcsdl']['total_row'];		
		
		$this->pagination->initialize($config);
		
		$this->data['pagination'] = $this->pagination->create_links();
		
		$this->layout->view(strtolower(__CLASS__.'/'.__FUNCTION__),$this->data);
	}
	
	
	public function detail(){
		
		$id = $this->uri->segment(4);	
		$this->data['title'] = "Chi Tiết Đơn Hàng";			
		$this->form_validation->set_rules('status', 'Tinh trang', 'trim');
		$this->form_validation->set_rules('note', 'Ghi chú', 'trim');
    	$this->data['getcsdl'] = $this->Order_flash_model->get($id);
		
		
		$this->Order_flash_model->update($id,array('status' => 5));
		
		if(empty($this->data['getcsdl'])) show_404();
		
    	if($this->form_validation->run() == TRUE){ 
			$data = array(        		
				'status' => set_value('status'),
				'note_admin' => set_value('note_admin'),				
        		'modified' => $this->data['date_now'],
        		'modified_by' => $this->data['auth']->username,
      		);
		
      		if($this->order_model->update($id,$data)){
				
				redirect($this->data['module'].'/'.$this->data['controller']);
			}
		}
		
		
		$this->layout->view(strtolower(__CLASS__.'/'.__FUNCTION__),$this->data);
	}
	
	public function del(){
	  
		$id = $this->uri->segment(4);
			
    	$this->data['getcsdl'] =  $this->order_model->getbyid($id);
		$data = array('status'=> -1);
			
		if($this->order_model->update($id,$data)){
			redirect($this->data['module'].'/'.$this->data['controller']);
		}
  }
  
}
