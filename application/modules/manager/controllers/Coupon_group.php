<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Coupon_group extends Admin_Controller {
	public function __construct(){ 
        parent::__construct(); 
		$this->load->model('Coupon_group_model');
		$this->load->model('Coupon_model');
		$this->load->model('Products_catalogs_model');
		$this->load->model('Products_model');
		$this->data['catalogs']   = $this->Products_catalogs_model->getselect();
		$this->data['controller_title'] = "Nhóm mã khuyến mãi";
    } 
	public function index(){
		$this->data['title'] = "Danh sách nhóm";	

		$w = array();

		$config['base_url'] = current_url();
	
		$config['total_rows'] = $this->Coupon_group_model->count_by($w);
		
		$config['per_page'] = 20; 
		
		$config['page_query_string'] = TRUE;
		
		$offset = $this->input->get('per_page');

		$this->pagination->initialize($config);
		
		$this->data['getcsdl'] = $this->Coupon_group_model->get_by($w,"desc",$offset,$config['per_page']);
				
		$this->data['pagination'] = $this->pagination->create_links();

		$input = $this->input->post();
		if($input){
			$this->form_validation->set_rules('name', 'Tên nhóm', 'trim|required');	
			$this->form_validation->set_rules('code', 'Tiền tố', 'trim|required|callback_check_code_group');	
			$this->form_validation->set_rules('discount', 'Giảm', 'trim|required');		
			$this->form_validation->set_rules('type', 'Loại giảm', 'trim|required');		
			$this->form_validation->set_rules('max_amount', 'Chi tiêu tối thiểu', 'trim|is_natural');
			$this->form_validation->set_rules('min_payments', 'Giảm tố đa', 'trim|is_natural');	
			$this->form_validation->set_rules('free_ship', 'Miễn phí Ship', 'trim');	
			$this->form_validation->set_rules('share_code', 'Dùng chung', 'trim');	
			$this->form_validation->set_rules('limit_user', 'Giới hạn user sử dụng', 'trim|is_natural');
			$this->form_validation->set_rules('limit_coupon', 'Số lần mã được dùng', 'trim|is_natural');
			$this->form_validation->set_rules('expiry_date', 'Ngày hết hạn', 'trim|required');
			$this->form_validation->set_rules('number_codes', 'Số mã cần tạo', 'trim|is_natural_no_zero|required');	

			if($this->form_validation->run()== TRUE){
				$setcsdl = array(
							'name'       => set_value('name'),
							'code'       => set_value('code'),
							'discount'   => set_value('discount'),
							'type'       => set_value('type'),
							'max_amount' => set_value('max_amount'),
							'min_payments'  => set_value('min_payments'),
							'free_ship'     => set_value('free_ship'),
							'share_code'    => set_value('share_code'),
							'limit_user'    => set_value('limit_user'),
							'limit_coupon'  => set_value('limit_coupon'),
							'expiry_date' => set_value('expiry_date'),
							'created'     => $this->data['date_now'],
							'created_by'  => $this->data['auth']->username,
							'status'      => 1
							);

				$id = $this->Coupon_group_model->insert($setcsdl);

				if ($id) {
					$number_codes = set_value('number_codes');
					$coupons = $this->generate_coupons($number_codes, array("prefix"=>set_value('code'),"length"=>5));					
					foreach ($coupons as $key => $value) {
						$coupon = array(
							'id_group' => $id,
							'code'     => $value,
							'created_by'  => $this->data['auth']->username,
							'created'     => $this->data['date_now'],
							'status'   => 0
							);
						$this->Coupon_model->insert($coupon);
					}
				}
				redirect($this->data['module'].'/'.$this->data['controller']."/edit/".$id."?token=".$this->data['ad_csrf_token_name']);	
			}
		}
		$this->layout->view(strtolower(__CLASS__)."/".__FUNCTION__,$this->data);
	}

	public function edit(){
		
		$id = (int)$this->uri->segment(4);

		$this->data['getcsdl'] = $this->Coupon_group_model->get($id);	

		$this->data['title'] = "Sửa Nhóm : ".$this->data['getcsdl']->name;

		if (!$this->data['getcsdl']) {
			show_404();
		}				
		$app_products = json_decode($this->data['getcsdl']->app_products);
		if (empty($app_products)) {
			$this->data["app_products"] = array();
		}else{
			$this->data["app_products"] = $this->Products_model->get_in($app_products);
		}

		$this->form_validation->set_rules('name', 'Tên nhóm', 'trim|required');		
		$this->form_validation->set_rules('discount', 'Giảm', 'trim|required');		
		$this->form_validation->set_rules('type', 'Loại giảm', 'trim|required');		
		$this->form_validation->set_rules('max_amount', 'Chi tiêu tối thiểu', 'trim|is_natural');
		$this->form_validation->set_rules('min_payments', 'Giảm tố đa', 'trim|is_natural');	
		$this->form_validation->set_rules('free_ship', 'Miễn phí Ship', 'trim');	
		$this->form_validation->set_rules('share_code', 'Dùng chung', 'trim');	
		$this->form_validation->set_rules('limit_user', 'Số lần dùng', 'trim|is_natural');
		$this->form_validation->set_rules('limit_coupon', 'Số lần mã được dùng', 'trim|is_natural');
		$this->form_validation->set_rules('expiry_date', 'Ngày hết hạn', 'trim|required');
		$this->form_validation->set_rules('number_codes', 'Số mã cần tạo', 'trim|is_natural_no_zero|required');	
		$this->form_validation->set_rules('app_products[]', 'Áp dụng với sản phẩm', 'trim');
		$this->form_validation->set_rules('app_catalogs[]', 'Áp dụng với danh mục', 'trim');

		if($this->form_validation->run()== TRUE){
			if(!empty(set_value('app_catalogs')))
				$app_catalogs = json_encode(set_value('app_catalogs'));
			else
				$app_catalogs = null;

			if(!empty(set_value('app_products')))
				$app_products = json_encode(set_value('app_products'));
			else
				$app_products = null;
						
			$setcsdl = array(
							'name'       => set_value('name'),							
							'discount'   => set_value('discount'),
							'type'       => set_value('type'),
							'max_amount' => set_value('max_amount'),
							'min_payments'  => set_value('min_payments'),
							'free_ship'     => set_value('free_ship'),
							'share_code'    => set_value('share_code'),
							'limit_user'    => set_value('limit_user'),
							'limit_coupon'    => set_value('limit_coupon'),
							'expiry_date' 	=> set_value('expiry_date'),
							'app_catalogs' => $app_catalogs,
							'app_products' => $app_products,
							'status'      => 1
			);

			$id = $this->Coupon_group_model->update($id,$setcsdl);
			redirect($this->data['module'].'/'.$this->data['controller']."?token=".$this->data['ad_csrf_token_name']);	
		}

		$this->layout->view(strtolower(__CLASS__)."/".__FUNCTION__,$this->data);
	}

	public function view(){
		$id = $this->uri->segment(4);

		$this->data['coupon_group'] = $this->Coupon_group_model->get($id);

		if (!$this->data['coupon_group']) {
			show_404();
		}	

		$this->data['controller_title'] = "Danh sách mã của : ".$this->data['coupon_group']->name;	

		$w = array("id_group"=>$id);

		$config['base_url'] = current_url();
	
		$config['total_rows'] = $this->Coupon_model->count_by($w);
		
		$config['per_page'] = 50; 
		
		$config['page_query_string'] = TRUE;
		
		$offset = $this->input->get('per_page');

		$this->pagination->initialize($config);
		
		$this->data['getcsdl'] = $this->Coupon_model->get_by($w,"desc",$offset,$config['per_page']);
				
		$this->data['pagination'] = $this->pagination->create_links();

		$this->layout->view(strtolower(__CLASS__)."/".__FUNCTION__,$this->data);
	}

	public function delete(){	  
		$json = array("status"=>404,"msg"=>"Lỗi thực hiện lệnh","callback"=>"");
		$this->form_validation->set_rules('id', 'ID', 'trim|is_natural_no_zero|required');
		if($this->form_validation->run() == TRUE){
			$id = set_value('id');
			$data = $this->Coupon_group_model->get_one_by(array('id'=>$id));			
			if ($data) {
				$coupon = $this->Coupon_model->getCodeActive($id);
				if(empty($coupon)){
					if($this->Coupon_group_model->delete_by( array('id'=>$id) )){
						$this->Coupon_model->delete_by( array("id_group"=>$id) );
						$json = array("status"=>200,"msg"=>"Bạn vừa xóa một mục","callback"=>$data->id);
					}
				}else{
					$json["msg"] = "Mục có mã đã sử dụng hoặc đang hoạt động, đã xuất bản";
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
				$data = $this->Coupon_group_model->get_one_by(array('id'=>$id));			
				if ($data) {
					if($data->status == 1)
						$setdata = array('status'=> 0);
					else
						$setdata = array('status'=> 1);
				
					if($this->Coupon_group_model->update($id,$setdata)){
						$json = array("status"=>200,"msg"=>"Bạn vừa chuyển trạng thái một mục","callback"=>$data->id);
					}
				}else{
					$json["msg"] = "Mục không tồn tại";
				}
			}	
			$this->output->set_content_type('application/json')->set_output(json_encode($json));
	}

	//--- hàm thư viện
	public function generate($options){
		$uppercase    = ['Q', 'E', 'R', 'T', 'Y', 'U', 'I', 'P', 'A', 'S', 'D', 'F', 'G', 'H', 'J', 'K', 'L', 'Z', 'X', 'C', 'V', 'B', 'N', 'M'];
		$numbers      = [1, 2, 3, 4, 5, 6, 7, 8, 9];
		$characters   = [];
		$coupon = null;
		$characters   = array_merge($characters, $numbers,$uppercase);

		while (true) {
			for ($i = 0; $i < $options['length']; $i++) {
				$coupon .= $characters[mt_rand(0, count($characters) - 1)];			
			}
			$check_coupon = $this->Coupon_model->get_one_by(array("code"=>$coupon));
			if(!empty($check_coupon)) {
				$coupon = null;
			}else{
				break;
			}
		}
		return $options['prefix'] . $coupon;
	}

	public function generate_coupons($maxNumberOfCoupons, $options) {
        $coupons = [];
        for ($i = 0; $i < $maxNumberOfCoupons; $i++) {
            $temp = $this->generate($options);
            $coupons[] = $temp;
        }
        return $coupons;
    }
    function check_code_group($code){

		$user = $this->Coupon_group_model->get_one_by(array("code"=>$code));

		if(!empty($user)){
			$this->form_validation->set_message('check_code_group', 'Tiền tố đã được sử dụng');
			return FALSE;
		} else {
			return TRUE;
		}
	}
	//hàm tương tác mã coupon
	public function code_active(){
		$json = array("status"=>404,"msg"=>"Lỗi thực hiện lệnh","callback"=>"");
		$this->form_validation->set_rules('idcode[]', 'ID', 'trim|required');
		if($this->form_validation->run() == TRUE){
			$listId = set_value("idcode");
			foreach ($listId as $key => $value) {
				$this->Coupon_model->update_by(array("code"=>$value),array("status"=>1));
			}
			$json = array("status"=>200,"msg"=>"Bạn vừa kích hoạt mã","callback"=>"");
		}	
		$this->output->set_content_type('application/json')->set_output(json_encode($json));
	}
	public function code_unactive(){
		$json = array("status"=>404,"msg"=>"Lỗi thực hiện lệnh","callback"=>"");
		$this->form_validation->set_rules('idcode[]', 'ID', 'trim|required');
		if($this->form_validation->run() == TRUE){
			$listId = set_value("idcode");
			foreach ($listId as $key => $value) {
				$this->Coupon_model->update_by(array("code"=>$value),array("status"=>2));
			}
			$json = array("status"=>200,"msg"=>"Bạn vừa hủy kích hoạt mã","callback"=>"");
		}	
		$this->output->set_content_type('application/json')->set_output(json_encode($json));
	}
	public function code_publish(){
		$json = array("status"=>404,"msg"=>"Lỗi thực hiện lệnh","callback"=>"");
		$this->form_validation->set_rules('idcode[]', 'ID', 'trim|required');
		if($this->form_validation->run() == TRUE){
			$listId = set_value("idcode");
			foreach ($listId as $key => $value) {
				$this->Coupon_model->update_by(array("code"=>$value),array("publish"=>1));
			}
			$json = array("status"=>200,"msg"=>"Bạn vừa xuất bản mã","callback"=>"");
		}	
		$this->output->set_content_type('application/json')->set_output(json_encode($json));
	}
	public function code_unpublish(){
		$json = array("status"=>404,"msg"=>"Lỗi thực hiện lệnh","callback"=>"");
		$this->form_validation->set_rules('idcode[]', 'ID', 'trim|required');
		if($this->form_validation->run() == TRUE){
			$listId = set_value("idcode");
			foreach ($listId as $key => $value) {
				$this->Coupon_model->update_by(array("code"=>$value),array("publish"=>2));
			}
			$json = array("status"=>200,"msg"=>"Bạn vừa thu hồi mã đã xuất bản, Liên hệ với khách để báo mã không đc sử dụng","callback"=>"");
		}	
		$this->output->set_content_type('application/json')->set_output(json_encode($json));
	}
	public function code_delete(){
		$json = array("status"=>404,"msg"=>"Lỗi thực hiện lệnh","callback"=>"");
		$this->form_validation->set_rules('idcode[]', 'ID', 'trim|required');
		if($this->form_validation->run() == TRUE){
			$listId = set_value("idcode");
			foreach ($listId as $key => $value) {
				$this->Coupon_model->update_by(array("code"=>$value),array("publish"=>2));
			}
			$json = array("status"=>200,"msg"=>"Bạn vừa thu hồi mã đã xuất bản, Liên hệ với khách để báo mã không đc sử dụng","callback"=>"");
		}	
		$this->output->set_content_type('application/json')->set_output(json_encode($json));
	}
	public function code_create(){
		$json = array("status"=>404,"msg"=>"Lỗi thực hiện lệnh","callback"=>"");
		$this->form_validation->set_rules('id_group', 'Nhóm', 'trim|is_natural_no_zero|required');
		$this->form_validation->set_rules('code_add', 'Mã', 'trim|is_natural_no_zero|required');
		if($this->form_validation->run() == TRUE){
			$coupon_group = $this->Coupon_group_model->get(set_value('id_group'));
			if($coupon_group){
				$number_codes = set_value('code_add');
				$coupons = $this->generate_coupons($number_codes, array("prefix"=>$coupon_group->code,"length"=>5));					
				foreach ($coupons as $key => $value) {
					$coupon = array(
							'id_group' => $coupon_group->id,
							'code'     => $value,
							'created_by'  => $this->data['auth']->username,
							'created'     => $this->data['date_now'],
							'status'   => 0
							);
					$this->Coupon_model->insert($coupon);
				}
				$json = array("status"=>200,"msg"=>"Tạo mã thành công","callback"=>"");
			}			
		}	
		$this->output->set_content_type('application/json')->set_output(json_encode($json));
	}

	public function code_clear(){	  
		$json = array("status"=>404,"msg"=>"Lỗi thực hiện lệnh","callback"=>"");
		$this->form_validation->set_rules('id', 'ID', 'trim|is_natural_no_zero|required');
		if($this->form_validation->run() == TRUE){
			$id = set_value('id');
			$data = $this->Coupon_model->get_one_by(array('id'=>$id));			
			if ($data) {
				if(!empty($data->id_order)){
					$json = array("status"=>200,"msg"=>"Mã khuyến mãi đã được sử dụng","callback"=>$data->id);
				}else{
					if(!empty($data->publish > 0)){
						$json = array("status"=>200,"msg"=>"Mã khuyến mãi đã chuyển giao","callback"=>$data->id);
					}else{
						if(!empty($data->status > 0)){
							$json = array("status"=>200,"msg"=>"Mã khuyến mãi đã được active","callback"=>$data->id);
						}else{
							if($this->Coupon_model->delete_by( array('id'=>$id) )){
								$json = array("status"=>200,"msg"=>"Bạn vừa xóa một mã khuyến mãi","callback"=>$data->id);
							}
						}
					}
				}
			}else{
				$json["msg"] = "Mã khuyến mãi không tồn tại";
			}
		}	
		$this->output->set_content_type('application/json')->set_output(json_encode($json));
	}
}