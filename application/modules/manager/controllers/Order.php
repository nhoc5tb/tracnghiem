<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Order extends Admin_Controller {
  
	public function __construct(){
		
		parent::__construct();
		
		$this->load->model('Products_model'); 		
		$this->load->model('Order_model'); 	
		$this->load->model('Order_detail_model'); 
		$this->load->model('Order_log_model');		
		$this->load->model('Users_model'); 	
		$this->load->model('Config_model');	
		$this->load->model('Coupon_group_model');
		$this->load->model('Coupon_model');
		$this->data['config'] = $this->Config_model->getconfig();
		$this->data['controller_title'] = "Đơn Hàng";		
		$this->data['active_order'] = "class='active'";
	}
  
	public function index(){
		
		$this->data['title'] = "Danh Sách Đơn hàng";	
		
		$w = array('status >='=> 0);
		
		$config['base_url'] = current_url();
	
		$config['per_page'] = 80; 
		
		$config['page_query_string'] = TRUE;
		
		$offset = $this->input->get('per_page');
		
		$this->data['getcsdl'] = $this->Order_model->get_by($w,"desc",$offset,$config['per_page']);
		
		$config['total_rows'] = $this->Order_model->count_by($w);		
		
		$this->pagination->initialize($config);
		
		$this->data['pagination'] = $this->pagination->create_links();
		
		$this->layout->view(strtolower(__CLASS__.'/'.__FUNCTION__),$this->data);
	}
	
	
	public function detail(){
		
		$id = $this->uri->segment(4);	
		
    	$this->data['order'] = $this->Order_model->get_one_by(array('code_view'=>$id));
    	if(empty($this->data['order'])) show_404();

    	$this->data['title'] = "Chi Tiết Đơn Hàng : #".$this->data['order']->code_view;	
		$this->data['order_detail'] = $this->Order_detail_model->get_by(array("id_order"=>$this->data['order']->id));
		$this->data["thuctra"] = $this->data['order']->total_order;
		$name_province = $this->getCodeProvince($this->data['order']->province);
		if($name_province){	
			if($name_province == "79"){
				$this->data["phiship"] = "0";
				$phiship_themvaoorder = "0";
			}
			else{				
				$this->data["phiship"] = "30000";
				$phiship_themvaoorder = "30000";
			}
			$this->data["thuctra"] = (int)$this->data["thuctra"] + (int)$this->data["phiship"];
		}		
		else{
			$this->data["phiship"] = "-1";
			$phiship_themvaoorder = 0;
		}

		if(!empty($this->data['order']->coupon)){//tính giá trị mã khuyến mãi
			$this->data["coupon"] = $this->Coupon_Value($this->data['order']->coupon);
			if($this->data["coupon"]->free_ship == true){
				$this->data["thuctra"] = (int)$this->data["thuctra"] - (int)$this->data["phiship"];
				$phiship_themvaoorder = 0;
			}
			switch ($this->data["coupon"]->type) {
				case '1'://tính theo %\				
					$this->data["coupon"]->value = ((int)$this->data["thuctra"]/100) * (int)$this->data["coupon"]->discount;
					if($this->data["coupon"]->max_amount > 0){
						if ((int)$this->data["coupon"]->value > (int)$this->data["coupon"]->max_amount) {//giảm không quá giá trị max_amount
							$this->data["coupon"]->value = $this->data["coupon"]->max_amount;
						}
					}				
					$this->data["thuctra"] = (int)$this->data["thuctra"] - (int)$this->data["coupon"]->value;
					break;
				case '2'://tính theo số tiền
					$couponValue->discount = (int)$coupon_group->discount;
					break;
				default:
					# code...
					break;
			}
		}
		if($this->data['order']->status == "0"){
			$this->Order_model->update($this->data['order']->id,array('status' => 3));
		}		
		$this->data["log"] = $this->Order_log_model->get_by(array("id_order"=>$this->data["order"]->id),"desc");
		$this->log_order($this->data["order"]->id, "Được xem bởi : ".$this->data['auth']->username);

		$this->form_validation->set_rules('status', 'Tinh trang', 'trim|required');
    	if($this->form_validation->run() == TRUE){ 
			$data = array( 
				'status' => set_value('status'),
				'ship' => $phiship_themvaoorder,				
        		'modified' => $this->data['date_now'],
        		'modified_by' => $this->data['auth']->username,
      		);
		
      		if($this->Order_model->update($this->data['order']->id,$data)){
				redirect($this->data['module'].'/'.$this->data['controller']);
			}
		}
		
		
		$this->layout->view(strtolower(__CLASS__.'/'.__FUNCTION__),$this->data);
	}

	function order_print(){
		$id = $this->uri->segment(4);	
		
    	$this->data['order'] = $this->Order_model->get_one_by(array('code_view'=>$id));
    	$this->data['title'] = "Chi Tiết Đơn Hàng : #".$this->data['order']->code_view;	
		$this->data['order_detail'] = $this->Order_detail_model->get_by(array("id_order"=>$this->data['order']->id));
		
		$this->Order_model->update($id,array('status' => 3,
		                                     'modified'=>$this->data['date_now'],
											 'modified_by'=>$this->data['auth']->username));
		
		if(empty($this->data['order'])) show_404();
		$this->data["log"] = $this->Order_log_model->get_by(array("id_order"=>$this->data["order"]->id),"desc");
		$this->log_order($this->data["order"]->id, "Tạo 1 bản in bởi : ".$this->data['auth']->username);
	}
	
  	public function delete(){	  
		$json = array("status"=>404,"msg"=>"Lỗi thực hiện lệnh","callback"=>"");
		$this->form_validation->set_rules('id', 'ID', 'trim|is_natural_no_zero|required');
		if($this->form_validation->run() == TRUE){
			$id = set_value('id');
			$data = $this->Order_model->get_one_by(array('id'=>$id));			
			if ($data) {
				if($this->Order_model->update($id,array('status'=> -1))){
					$json = array("status"=>200,"msg"=>"Bạn vừa xóa một mục","callback"=>$data->id);
				}
			}else{
				$json["msg"] = "Mục xóa không tồn tại";
			}
		}	
		$this->output->set_content_type('application/json')->set_output(json_encode($json));
	}
	function log_order($id_order, $content){
		$flag = true;
		if($content == "Được xem bởi : ".$this->data['auth']->username){
			$c = $this->Order_log_model->get_by(array("id_order"=>$id_order,"content"=>"Được xem bởi : ".$this->data['auth']->username));
			if(!empty($c)) $flag = false;
		}
		
		$log_customer = array(
						"id_order"=>$id_order,
						"content"=>$content,
						"created"=>$this->data['date_now'],
						"created_by"=>$this->data['auth']->username,
		);
		if($flag)
			$this->Order_log_model->insert($log_customer);
	}

	public function getCodeProvince($name){
		$filename = ROOT_DIR."assets/data_location_vn/tinh_tp.json";
		if(file_exists($filename)){
			$fp = fopen($filename, "r");
			$content = fread($fp, filesize($filename));
			$content = json_decode($content);
			fclose($fp);

			if (count((array)$content) > 0) {
				foreach($content as $row){
			        if($row->name == $name)
			            return $row->code;
				}
			}else{
			    return "";
			}
		}
		return "";
	}
	public function Coupon_Value($code){
		$couponValue = new stdClass();
		$flag = false;
		$coupon = $this->Coupon_model->get_one_by(array("code"=>$code,"status"=>1,"publish"=>1));	
		if ($coupon) {
			$coupon_group = $this->Coupon_group_model->get($coupon->id_group);			
		}else{
			$flag = false;
		}	
		
		if($coupon_group->free_ship == 0){
			$couponValue->free_ship = false;
		}else{
			$couponValue->free_ship = true;
		}
		$couponValue->code = $coupon->code;
		$couponValue->max_amount = $coupon_group->max_amount;
		$couponValue->type = $coupon_group->type;
		$couponValue->discount = $coupon_group->discount;
		return $couponValue;
	}
}
