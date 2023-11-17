<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Products_sale extends Admin_Controller {
  
	public function __construct(){
		
		parent::__construct();
		$this->load->model('Products_model');
		$this->load->model('Products_catalogs_model');
		$this->load->model('Products_sale_model');

		$this->config->load('template');		
		$this->data['config_upload'] = $this->config->item('image_products');	
																		
		$this->data['catalogs'] = $this->Products_catalogs_model->getselect();		
		$this->data['controller_title'] = "Mặt Hàng Sale";	
	}
  
	public function index(){	
	
		$this->data['title'] = "Danh sách Mặt Hàng Khuyến Mãi";	
		
		$w = array();
		
		$config['base_url'] = current_url();
	
		$config['total_rows'] = $this->Products_sale_model->count_by($w);
		
		$config['per_page'] = 50; 
		
		$config['page_query_string'] = TRUE;
		
		$offset = $this->input->get('per_page');

		$this->pagination->initialize($config);
		
		$this->data['getcsdl'] = $this->Products_sale_model->get_by($w,"asc",$offset,$config['per_page']);
		foreach ($this->data['getcsdl'] as $key => $value) {
			$this->data['getcsdl'][$key]->product = $this->Products_model->get($value->id_product);
		}
				
		$this->data['pagination'] = $this->pagination->create_links();
		
		$this->layout->view(strtolower(__CLASS__.'/'.__FUNCTION__),$this->data);
	}
	public function add(){
		$this->data['title'] = "Thêm Sản Phẩm Khuyến Mãi";		
				
		$this->form_validation->set_rules('id_product', 'Tiêu đề', 'trim|required');
		$this->form_validation->set_rules('value', 'Khuyến mãi', 'trim|required');
		$this->form_validation->set_rules('endsale', 'Ngày kết thúc', 'trim');

		if($this->form_validation->run() == TRUE){  
			$data = array(
					'id_product' => set_value('id_product'),
					'value' => set_value('value'),	
					'endsale' => set_value('endsale'),							
					'status' => 1,
			);
		
			$id = $this->Products_sale_model->insert($data);
			if($id){
				redirect($this->data['module'].'/'.$this->data['controller']);	
			}	
		}
		$this->layout->view(strtolower(__CLASS__.'/add'),$this->data);  	
	}
	public function ajax_getproduct(){
		$array_getcsdl = array('status'=>'200','msg'=>'','content'=>'');	
		$this->form_validation->set_rules('id_catalogs', 'ID Danh Mục', 'trim|required');
		
		if($this->form_validation->run() == TRUE){
			$getcsdl = $this->Products_model->get_by(array("catalogs"=>set_value('id_catalogs')));
			
			if($getcsdl){
				$content = array();
				foreach($getcsdl as $key=>$row){
					$products_sale = $this->Products_sale_model->get_by(array("id_product"=>$row->id));
					if (empty($products_sale)) {
						$content[] = array("id"=>$row->id,"text"=>$row->title);;
					}					 
				}
				$array_getcsdl = array('status'=>'200','msg'=>"Lấy sản phẩm thành công",'content'=>json_encode($content));	
			}else{
				$array_getcsdl = array('status'=>'300','msg'=>"Không tìm thấy sản phẩm" ,'content'=>"");	
			}
			
		}else{
			$array_getcsdl = array('status'=>'404' ,'msg'=>validation_errors(' ','<br>'),'content'=>'');
		}		
		$this->output->set_content_type('application/json')->set_output(json_encode($array_getcsdl));
	}	

	public function ajax_price(){
		$array_getcsdl = array('status'=>'false' ,'content'=>'');	
		$this->form_validation->set_rules('id_product', 'Id Sản Phẩm', 'trim|required');
		$this->form_validation->set_rules('price', 'Giá', 'trim|required');
		
		if($this->form_validation->run() == TRUE){
			$getcsdl = $this->Products_sale_model->get(set_value('id_product'));
			if($getcsdl){
				$setcsdl = array(
							"value"=>trim(str_replace(".","",set_value('price')))
							);
				
				$this->Products_sale_model->update($getcsdl->id,$setcsdl);
				$array_getcsdl = array('status'=>'true' ,'content'=>"Cập nhật giá thành ".number_format(set_value('price'), 0, ',', '.'));	
			}else{
				$array_getcsdl = array('status'=>'false' ,'content'=>"Không tìm thấy sản phẩm");	
			}
			
		}else{
			$array_getcsdl = array('status'=>'false' ,'content'=>validation_errors(' ','<br>'));
		}		
		$this->output->set_content_type('application/json')->set_output(json_encode($array_getcsdl));
	}
	
	public function delete(){
	  
		$json = array("status"=>404,"msg"=>"Lỗi thực hiện lệnh","callback"=>"");
		$this->form_validation->set_rules('id', 'ID', 'trim|is_natural_no_zero|required');
		if($this->form_validation->run() == TRUE){
			$id = set_value('id');
			$data = $this->Products_sale_model->get_one_by(array('id'=>$id));			
			if ($data) {
				if($this->Products_sale_model->delete_by( array('id'=>$id) )){						
					$json = array("status"=>200,"msg"=>'Đã bỏ giảm giá một sản phẩm',"callback"=>$data->id);					
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
			$data = $this->Products_sale_model->get_one_by(array('id'=>$id));			
			if ($data) {
				if($data->status == 1)
					$setdata = array('status'=> 0);
				else
					$setdata = array('status'=> 1);
				
				if($this->Products_sale_model->update($id,$setdata)){
					$json = array("status"=>200,"msg"=>"Bạn vừa chuyển trạng thái một mục","callback"=>$data->id);
				}
			}else{
				$json["msg"] = "Mục không tồn tại";
			}
		}	
		$this->output->set_content_type('application/json')->set_output(json_encode($json));
	}
}
