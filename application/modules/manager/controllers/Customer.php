<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Customer extends Admin_Controller {
  
	public function __construct()
	{
		parent::__construct();
		$this->data["title"] = "Dashboard";
		$this->load->model('products_model');
		$this->load->model('Customer_model');		
		$this->load->model('Order_detail_model');
		$this->load->model('Order_model');
	}
	
	public function index()	{
		$action = $this->input->get("ac");
		if(!$this->input->get("ac") || $action == "all"){
			$this->getall();
		}else{
			$this->getloc($action);			
		}
	}
	
	function getloc($action){
		
		$w = array();
		
		
		
		if(!empty($this->input->get("start")) && !empty($this->input->get("end"))){
			$date = $this->input->get("start");
			$start = strtotime($date);
			if ($start === FALSE) {
			  $start = strtotime(str_replace('/', '-', $date));
			}
			
			$date = $this->input->get("end");
			$end = strtotime($date);
			if ($end === FALSE) {
			  $end = strtotime(str_replace('/', '-', $date));
			}
			
			if($start != $end){
				$w["created >="] = date('Y-d-dm H:i:s',$start);
				$w["created <"] = date('Y-d-m H:i:s',$end);
			}else{
				$w["created >="] = date('Y-d-m',$start);
			}
		}
		
		$per_page = 50;
		
		$offset = $this->input->get('per_page');
		
		$sale = $this->Customer_model->getlist(0,0,$w);
		$getcsdl = array();
		
		$k = 0;
		$title = "";
		foreach($sale as $key=>$row){			
			switch($action){
				case "thieuthongtin":
					$title = "Thiếu Thông Tin";
					if(empty($row->email) || empty($row->phone) || empty($row->address)){
						$getcsdl[$k] = $row;
						$k++;
					}
					break;
				case "chuagiaodich":	
					$title = "Chưa Giao Dịch";
					$sale = $this->Sale_model->get_by(array("id_customer"=>$row->id));
					if(empty($sale)){
						$getcsdl[$k] = $row;
						$k++;
					}					
					break;	
				case "dagiaodich":
					$title = "Đã Giao Dịch";
					$sale = $this->Sale_model->get_by(array("id_customer"=>$row->id));
					if(!empty($sale)){
						$getcsdl[$k] = $row;
						$k++;
					}	
					break;
				case "dangnotien":
					$title = "Đang Nợ Tiền";
					$flag = false;
					$sale = $this->Sale_model->get_by(array("id_customer"=>$row->id));
					foreach($sale as $__row){
						$pay = 0;
						$sale_pay = $this->Sale_pay_model->get_by(array("id_sale"=>$__row->id));
						foreach($sale_pay as $_sale_pay){
							$pay = $_sale_pay->payments + $pay;
						}
						if($__row->total_payment > $pay){
							$flag = true;
						}
					}
					if($flag){
						$getcsdl[$k] = $row;
						$k++;
					}
					
					break;	
				case "dahuydon":
					$title = "Đã Hủy Đơn";
					$sale = $this->Sale_model->get_by(array("id_customer"=>$row->id,"status"=>"cancel"));
					if(!empty($sale)){
						$getcsdl[$k] = $row;
						$k++;
					}	
					break;
			}			
		}
		$this->data['title'] = "Danh sách khách hàng <strong>".$title."</strong>";
		$i = (int)$offset;
		
		if($per_page > count($getcsdl)){
			$per_page = count($getcsdl);
		}
		
		$per_page = $per_page + $i;	
		
		$this->data["getcsdl"] = array();
		for($i; $i < $per_page; $i++){	
			$this->data["getcsdl"][] = $getcsdl[$i];
		}
	
		if(!empty($this->input->get("start")) && !empty($this->input->get("end"))){
			$config['base_url'] = current_url()."?ac=".$this->input->get("ac")."&start=".$this->input->get("start")."&end=".$this->input->get("end");
		}else{
			$config['base_url'] = current_url();
		}
		
		$config['total_rows'] = count($getcsdl);		
		$config['per_page'] = $per_page; 		
		$config['page_query_string'] = TRUE;		
		$this->pagination->initialize($config);				
		$this->data['pagination'] = $this->pagination->create_links();	
	
		$this->layout->view(strtolower(__CLASS__.'/index'),$this->data);
	}
	
	function getall(){
		$this->data['title'] = "Danh sách khách hàng";
		
		$w = array();
		$q = $this->input->get("q");
		
		if(!empty($q)){
			$like = array(
						"vi_customer.code"=>$q,
						"vi_customer.name"=>$q,
						"vi_customer.email"=>$q,
						"vi_customer.phone"=>$q,
						"vi_customer.address"=>$q,
						"vi_customer.cty_mst"=>$q
						 );
		}else{
			$like = null;
		}
		
		if(!empty($this->input->get("start")) && !empty($this->input->get("end"))){
			$date = $this->input->get("start");
			$start = strtotime($date);
			if ($start === FALSE) {
			  $start = strtotime(str_replace('/', '-', $date));
			}
			
			$date = $this->input->get("end");
			$end = strtotime($date);
			if ($end === FALSE) {
			  $end = strtotime(str_replace('/', '-', $date));
			}
			
			if($start != $end){
				$w["created >="] = date('Y-d-dm H:i:s',$start);
				$w["created <"] = date('Y-d-m H:i:s',$end);
			}else{
				$w["created >="] = date('Y-d-m',$start);
			}
		}
		
		if(!empty($this->input->get("start")) && !empty($this->input->get("end"))){
			$config['base_url'] = current_url()."?ac=".$this->input->get("ac")."&start=".$this->input->get("start")."&end=".$this->input->get("end");
		}else{
			$config['base_url'] = current_url();
		}
		
		$config['per_page'] = 500; 
		
		$config['page_query_string'] = TRUE;
		
		$offset = $this->input->get('per_page');
		
		$this->data["getcsdl"] = $this->Customer_model->getlist($offset,$config['per_page'],$w,null,$like);
		
		$config['total_rows'] = count($this->data["getcsdl"]);
		
		$this->pagination->initialize($config);
		
		$this->data['pagination'] = $this->pagination->create_links();	
	
		$this->layout->view(strtolower(__CLASS__.'/index'),$this->data);
	}
  
}
