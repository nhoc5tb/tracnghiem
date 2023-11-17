<?php if (!defined('BASEPATH')) exit('No direct script access allowed');
/***************************
PHÂN QUYỀN THEO CONTROLLER
NHORU
***************************/
class Rurole
{	
	var $CI;
	var $role_id = 0;
	
	var $url_del_start  = '<a  data-toggle="modal" data-target="#md-footer-danger" class="btn-delete btn btn-primary btn-danger" href="#" data-path="';
	var $url_del_end    = '">Xóa</a>';
	
	var $url_edit_start = '<a class="btn-edit btn btn-primary" href="';
	var $url_edit_end   = '">Cập Nhật</a>';
	
	var $url_add_start  = '<a class="btn-add btn btn-primary" href="';
	var $url_add_end    = '">Thêm</a>';
	
	var $url_status_start  = 'span class="true">';
	var $url_status_end    = '</span>';
	
	var $module         = '';
	var $controller_ci  = "";
	var $function_ci    = "";
	
	var $err  = "Quyền truy cập chưa được 'set'. <br> <a href='javascript:history.go(-1)'> « Back</a>";
	var $err1 = "Bạn không đủ quyền truy cập. <br> <a href='javascript:history.go(-1)'>  « Back</a>";
	
	function __construct()
	{				
		$this->CI =& get_instance();
		$this->CI->load->model('rurole_model');
		$this->module = strtolower($this->CI->uri->segment(1));
		$this->controller_ci = $this->CI->uri->rsegment(1);//trên class của controller
		$this->function_ci   = $this->CI->uri->rsegment(2);//hàm gọi tới của controller	
	}
		
	/*
		@cấu hính biến config cho Class
	*/
	function config($params = array())
	{
		if (count($params) > 0)
		{
			foreach ($params as $key => $val)
			{
				if (isset($this->$key))
				{					
					$this->$key = strtolower($val);
				}
			}
		}
	}	
	
	/*
		@xóa cấu hình config
	*/
	function clear(){
		$this->url_del_start  = '<a class="btn-delete btn btn-primary" href="';
		$this->url_del_end    = '">Xóa</a>';
		
		$this->url_edit_start = '<a class="btn-edit btn btn-primary" href="';
		$this->url_edit_end   = '">Cập Nhật</a>';
		
		$this->url_add_start  = '<a class="btn-add btn btn-primary" href="';
		$this->url_add_end    = '">Thêm</a>';
		
		$this->url_status_start  = 'span class="true">';
		$this->url_status_end    = '</span>';
				
		$this->err  = "Quyền truy cập chưa được 'set'. <br> <a href='javascript:history.go(-1)'> « Back</a>";
		$this->err1 = "Bạn không đủ quyền truy cập. <br> <a href='javascript:history.go(-1)'>  « Back</a>";
		$this->controller_ci = $this->CI->uri->rsegment(1);//trên class của controller
		$this->function_ci   = $this->CI->uri->rsegment(2);//hàm gọi tới của controller
	}	
	/*
		@hàm kiểm tra quyền của role_id
		@Giá trị 1 quyền được thực thi trên function
		@Giá trị 2 quyền được sử dụng phương thức GET
		@Giá trị 3 quyền được sử dụng phương thức POST
	*/
	
	function checkPermission(){//nếu lớn hơn 0 id của role_group sẽ có quyền đặc cách qua mặt bước check	
		if($this->role_id == 1){ return TRUE; }//cho phép group user có id 1 được phép truy cap moi quyen
		$role_controller = $this->CI->rurole_model->role_controller_getName($this->controller_ci);		
		
		if($role_controller){//kiem tra xem co ten cotroller
		
			$role_function = $this->CI->rurole_model->role_function_getId(strtolower($role_controller->controller_id),strtolower($this->function_ci));
		
			if($role_function){//kiem tra co lay duoc function voi controller khong				
				$role_permission = $this->CI->rurole_model->role_permission_get($this->role_id);				
				if($role_permission){					
					$array_role = json_decode($role_permission->permission);	
					$break = FALSE; //biết giữ giá trị False, để rào trường hợp	 $key == $role_function->function_id và không có trường hợp nào bằng nhau cả							
					foreach($array_role as $key => $value){																
						if($key == $role_function->function_id){							
							if( in_array(1,$value) ){//kiểm tra quyền phép thực thi								
								return TRUE;
							}
							else
								return FALSE;	
							$break = TRUE;							
						}else
							$break = FALSE;
					}
					if(!$break){// nếu $role_function->function_id ko tồn tại trong mảng, nói cách khác là chưa sét quyền
						$this->post(in_array(2,$value));//Gọi function khoa POST
						$this->get(in_array(3,$value));//Gọi function khoa GET	
						return FALSE;
						//show_error($this->err1,500,"Lỗi 103:"); 
					}
				}else
					return FALSE;
					//show_error($this->err1,500,"Lỗi 102:");	
			}else//#kiem tra quyen han cua user tren function
				return FALSE;
				//show_error($this->err1,500,"Lỗi 101:");				
		}else//#kiem tra xem co ten cotroller		
			return FALSE;
			//show_error($this->err1,500,"Lỗi 100:");
		
	}
	/*
	| kiểm tra quyên theo controler và function
	| Trả về : TRUE/FALSE
	*/
	
	function checkControler($controler, $function = "*"){
		
		if($this->role_id == 1){ return TRUE; }
		
		$role_permission = $this->CI->rurole_model->role_permission_get($this->role_id);	
		
		if(!$role_permission) return FALSE;
	
		$array_role = json_decode($role_permission->permission);
		$role_controller = $this->CI->rurole_model->role_controller_getName(strtolower($controler));		
	
		if(!$role_controller) return FALSE;
		
		if($function == "*"){
			$role_function = $this->CI->rurole_model->role_function_pid($role_controller->controller_id);
			
			if(count($array_role) > 0){
				foreach($array_role as $key => $value){	
				
					foreach($role_function as $_value){	
						if($key == $_value->function_id){
							return TRUE;
						}
					}
				}
			}
			return FALSE;
		}
		
		if($role_controller){//kiem tra xem co ten cotroller
			
			$role_function   = $this->CI->rurole_model->role_function_getId(strtolower($role_controller->controller_id),strtolower($function));
							
			if(count($array_role) > 0){
				foreach($array_role as $key => $value){																
					if($key == $role_function->function_id){
						return TRUE;
					}
				}
			}else{
				return FALSE;
			}
			
		}
		return FALSE;
		
	}
	
	/*
		@kiểm tra quyền thực thi, nếu ko được phép đẩy về trang Error
	*/
	function check($true = TRUE){//biến cho phép chuyển sang trang lỗi
		if($true){			
			if(!$this->checkPermission())
				show_error($this->err1,500,"Lỗi Truy Cập:");
			else{
				/* log truy cap trang ko lien quan den phan quyen */
				$date = date("Y-m-d H:i:s");
				if($this->controller_ci != 'feeds' && $this->function_ci != 'push'){					
					$this->CI->load->model('log_login_model');
					$auth = $this->CI->session->userdata('auth');
					$data_log = array("user" => $auth->username,
									  "ip_address" => $this->CI->input->ip_address(),
									  "user_agent" => $this->CI->input->user_agent(),
									  "created" => $date,									 
									  "action" => 'Truy cập',
									  "page" => $this->controller_ci.'/'.$this->function_ci,
									  "status" => '');
					//ru bỏ ghi log $this->CI->log_login_model->insert($data_log);	
				}
				/* log truy cap trang ko lien quan den phan quyen */
			}
		}else{
			if(!$this->checkPermission())
				return FALSE;
			else
				return TRUE;
			$this->clear();//f5 lai file config
		}
	}
	
	/*
		@hàm kiểm tra quyền hiển thị của menu điều kiển
		@nặc định nó sẽ kiểm tra trên chính controller đang hiện hành
		@hàm nặc định sẽ là : delete, edit, add
		@nếu không được quyền hiển thị sẽ trả về FALSE
	*/
	function showPermission($action = NULL,$id = NULL,$value = NULL){
		$showpermission = "Lỗi : chưa set quyền này";
		switch($action){
			case 'delete':
				$this->function_ci = 'delete';
				if($this->checkPermission()){
					$showpermission = $this->url_del_start.base_url()."/".$this->module."/".$this->controller_ci. "/" .$action."/"."\" data-id=\"". $id .$this->url_del_end;
					return $showpermission;
				}else
					return FALSE;
			break;
			case 'edit':
				$this->function_ci = 'edit';
				if($this->checkPermission()){
					$showpermission = $this->url_edit_start.base_url()."/".$this->module."/".$this->controller_ci."/".$action."/".$id.$this->url_edit_end;
					return $showpermission;
				}else
					return FALSE;
			break;
			case 'add':
				$this->function_ci = 'add';
				if($this->checkPermission()){
					$showpermission = $this->url_add_start.base_url()."/".$this->module."/".$this->controller_ci."/".$action.$this->url_add_end;
					return $showpermission;
				}else
					return FALSE;
			break;
			case 'group_edit':
				$this->function_ci = 'group_edit';
				if($this->checkPermission()){
					$showpermission = $this->url_edit_start.base_url()."/".$this->module."/".$this->controller_ci."/".$action."/".$id.$this->url_edit_end;
					return $showpermission;
				}else
					return FALSE;
			break;
			case 'group_del':
				$this->function_ci = 'group_del';
				if($this->checkPermission()){
					$showpermission = $this->url_del_start.base_url()."/".$this->module."/".$this->controller_ci. "/" .$action."/"."\" data-id=\"". $id .$this->url_del_end;
					return $showpermission;
				}else
					return FALSE;
			break;
			default:
				return $showpermission;
			break;
		}
	}
	
	/*
	| Lấy data quyền được sử dụng để làm menu
	*/
	function getDataPermission(){
		$dataMenu = array();
		 
		if($this->role_id != 1){
			$permission = $this->CI->rurole_model->role_permission_get($this->role_id);
			$permission = json_decode($permission->permission);
			
			$idF = array();			
			foreach ($permission as $key=>$id){
				$idF[] = $key;
			}
			
			$controler = $this->CI->rurole_model->role_function_getin($idF);
			$idC = array();			
			foreach ($controler as $row){
				$idC[] = $row->controller_id;
			}
			
			$controler = $this->CI->rurole_model->role_controller_getin($idC);
			
			foreach($controler as $key=>$row){
				$dataMenu[$key]["controler"] = $row;
				$dataMenu[$key]["function"]  = $this->CI->rurole_model->role_function_pid($row->controller_id);
			}
		}else{
			$controler = $this->CI->rurole_model->role_controller_getlist();
			$idC = array();			
			foreach ($controler as $row){
				$idC[] = $row->controller_id;
			}
			
			foreach($controler as $key=>$row){
				$dataMenu[$key]["controler"] = $row;
				$dataMenu[$key]["function"]  = $this->CI->rurole_model->role_function_pid($row->controller_id);
			}
		}
		
		return $dataMenu;
	}
	
	
	/*
		@hàm kiểm tra quyền sử dụng metho post trong class
	*/
	function post($if = false){
		if(!$if){
			$input = $this->CI->input->post();
			if($input)	
				unset($_POST);
				//$_POST = NULL;
		}
	}	
	
	
	/*
		@hàm kiểm tra quyền sử dụng metho GET của role_id
	*/
	function get($if = false){
		if(!$if){
			$input = $this->CI->input->get();
			if($input)	
				unset($_GET);
				//$_GET = NULL;
		}
	}
}