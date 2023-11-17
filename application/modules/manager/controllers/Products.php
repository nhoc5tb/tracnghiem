<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Products extends Admin_Controller {
  
	public function __construct(){
		
		parent::__construct();
		$this->load->model('Products_model');
		$this->load->model('Products_catalogs_model');
		$this->load->model('Products_trademark_model');
		$this->load->model('Products_combo_model');
		$this->load->model('Products_variant_model');
		
		$this->load->model('Attrib_insert_group_model');		
		$this->load->model('Attrib_insert_model');
		$this->load->model('Attrib_insert_product_model');

		$this->load->model('Attrib_check_model');
		$this->load->model('Attrib_check_group_model');
		$this->load->model('Attrib_check_product_model');				
				
		$this->config->load('template');		
		$this->data['config_upload'] = $this->config->item('image_'.strtolower(__CLASS__));		
																		
		$this->data['catalogs'] = $this->Products_catalogs_model->getselect();
		$this->data['catalogs_full'] = $this->Products_catalogs_model->get_by(array("status"=>1));
		$this->data['trademark'] = $this->Products_trademark_model->getselect();
		
		$this->data['controller_title'] = "Mặt Hàng";
	}
  
	public function index(){	
		$this->data['title'] = "Danh sách Sản Phẩm";
		/*	
		$sanpham = $this->Products_model->get();
		foreach ($sanpham as $key => $value) {
			$this->Products_model->update($value->id,array('code_product' => $this->ruadmin->createCodeProduct()));
		}
		$this->ruadmin->createCodeProduct();
		*/
		if(!empty($this->input->get("catalogs"))){
			$w["catalogs"] = $this->input->get("catalogs");
			$this->data['cur_catalog'] = $this->Products_catalogs_model->get($this->input->get("catalogs"));
			$this->data['cur_catalog'] = $this->data['cur_catalog']->title;
		}else{
			$this->data['cur_catalog'] = "Lọc Bài Theo Danh Mục";
		}
		$w = array();
		$filter = $this->input->get('filter');
		
		if(!empty($filter)){
			$filter = (int)$filter;
			$w = array('catalogs'=>$filter);
			$config['base_url'] = current_url().'?filter='.$filter;
		}else{
			$w = array();
			$config['base_url'] = current_url();
		}
		
		$config['base_url'] = current_url();
	
		$config['total_rows'] = $this->Products_model->count_by($w);
		
		$config['per_page'] = 100; 
		
		$config['page_query_string'] = TRUE;
		
		$offset = $this->input->get('per_page');

		$this->pagination->initialize($config);
		
		$this->data['getcsdl'] = $this->Products_model->getlist($offset,$config['per_page'],$w);
				
		$this->data['pagination'] = $this->pagination->create_links();
		
		$this->layout->view(strtolower(__CLASS__.'/'.__FUNCTION__),$this->data);
	}
	
	public function add(){
		$this->data['title'] = "Thêm Sản Phẩm";		
		
		$this->data['catalogs'] = $this->Products_catalogs_model->getselect();
		$this->form_validation->set_rules('title', 'Tiêu đề', 'trim|required');
		$this->form_validation->set_rules('code', 'Mã SP', 'trim|required');
		$this->form_validation->set_rules('slug', 'Slug', 'trim');
		$this->form_validation->set_rules('description', 'Description', 'trim');
		$this->form_validation->set_rules('keywords', 'Keywords', 'trim');
		$this->form_validation->set_rules('home_text', 'Nội dung ngắn', 'trim');
		$this->form_validation->set_rules('body_text', 'Nội dung', 'trim');
		$this->form_validation->set_rules('catalogs', 'Danh mục', 'trim');
		$this->form_validation->set_rules('sub_categories[]', 'Danh mục phụ', 'trim');
		$this->form_validation->set_rules('product_combo[]', 'Gợi ý SP', 'trim');
		$this->form_validation->set_rules('trademark', 'Thương Hiệu', 'trim');
		$this->form_validation->set_rules('price', 'Giá', 'trim');	
		$this->form_validation->set_rules('code_aen', 'Mã', 'trim');		
		$this->form_validation->set_rules('image_url', 'Link ảnh', 'trim');
		$this->form_validation->set_rules('image_lib', 'Link Thư Viện', 'trim');
		$this->form_validation->set_rules('image', 'Hình mình họa', 'trim');

		if($this->form_validation->run() == TRUE){  
			
			$slug = set_value('slug');
			
			if(empty($slug))  	
				$slug = $this->ruadmin->slug(set_value('title'),'Products_model');	
			else
				$slug = $this->ruadmin->slug(set_value('slug'),'Products_model');
			
			if(!empty(set_value('sub_categories')))
				$sub_categories = json_encode(set_value('sub_categories'));
			else
				$sub_categories = null;
				
			$data = array(
					'code_product' => $this->ruadmin->createCodeProduct(),
					'title' => set_value('title'),
					'code' => set_value('code'),
					'code_aen' => set_value('code_aen'),
					'code_sku' => $this->ruadmin->createSKU(set_value('trademark'),set_value('title')),
					'slug' => $slug,
					'description' => set_value('description'),
					'keywords'  => set_value('keywords'),
					'home_text' => html_entity_decode(set_value('home_text')),
					'body_text' => html_entity_decode(set_value('body_text')),
					'catalogs' => set_value('catalogs'),
					'sub_categories' => $sub_categories,
					'trademark' => set_value('trademark'),
					'price'    => set_value('price'),					
					'status' => 1,
					'created' => $this->data['date_now'],
					'created_by' => $this->data['auth']->username,
					'modified' => $this->data['date_now'],
					'modified_by' => $this->data['auth']->username,
			);
		
			$id = $this->Products_model->insert($data);
			
			if($id){
				//-- ghi nho catalogs đã chọn	
				$this->load->helper('cookie');	
				setcookie('tmp_catalogs',set_value('catalogs'));
				setcookie('tmp_trademark',set_value('catalogs'));
				//-- ghi nho catalogs đã chọn	

				//--- xử lý sản phẩm gợi ý
				if(!empty(set_value('product_combo')))
					$product_combo = json_encode(set_value('product_combo'));
				else
					$product_combo = null;

				if(!empty($product_combo)){
					$this->Products_combo_model->insert(array("id_product"=>$id,'content'=>$product_combo,"type"=>1,"value"=>""));
				}

				if(empty(set_value('image_lib')) ){	
					if(empty(set_value('image_url')) ){			
						$fileimg = $this->ruadmin->upFile($this->data['config_upload'],'image');

						if($fileimg["status"] == 200 or $fileimg["status"] == 300 ){
							$this->Products_model->update( $id,array('image'=>$fileimg["src"]) );	
						}
					}else{
						$fileimg = $this->ruadmin->upload_url(set_value('image_url'),$this->data['config_upload']);
						if($fileimg){
							$this->Products_model->update( $id,array('image'=>$fileimg) );	
						}
					}
				}else{	
					$this->Products_model->update( $id,array('image'=>set_value('image_lib')) );
				}

				if(isset($_POST['attrib']))
					redirect($this->data['module'].'/'.$this->data['controller'].'/edit/'.$id);	
				else
					redirect($this->data['module'].'/'.$this->data['controller']);	
			}	
		}
		$this->layout->view(strtolower(__CLASS__.'/add'),$this->data);  	
	}	
	public function addlist(){				
		
		$this->data['title'] = "Thêm - Up Sản Phẩm";
		
		$this->form_validation->set_rules('content', 'Nội dung', 'trim|required');
		$this->form_validation->set_rules('catalogs', 'Nguồn Cấp', 'trim');
		$this->form_validation->set_rules('trademark', 'Nguồn Cấp', 'trim');
		
		if($this->form_validation->run()== TRUE){	
			
			$content = explode("\n",set_value('content'));
			$format = set_value('format');			
			foreach($content as $row){
				$info_mail = explode("|",$row);

				$product = $this->Products_model->get_one_by(array("code"=>trim($info_mail[0])));
				if($product){
					$data = array(
						'price'  => trim($info_mail[4]),
						'unit'   => trim($info_mail[2]),	
						'style'  => trim($info_mail[3]),
						'status' => 1,
						'modified' => $this->data['date_now'],
						'modified_by' => $this->data['auth']->username,
					);
					$this->Products_model->update_by(array("code"=>trim($info_mail[0])),$data);	
				}else{
					$slug = $this->ruadmin->slug(trim($info_mail[1]),'products_model');
					$data = array(
							'code_product' => $this->ruadmin->createCodeProduct(),
							'title' => trim($info_mail[1]),
							'code'  => trim($info_mail[0]),
							'code_aen' => set_value('code_aen'),
							'code_sku' => $this->ruadmin->createSKU(set_value('trademark'),set_value('title')),
							'slug' => $slug,
							'description' => "",
							'keywords'  => "",
							'image' => '0398f126c223fe451c41bd0a47a24917.png',
							'home_text' => html_entity_decode(""),
							'body_text' => html_entity_decode(""),
							'catalogs' => set_value('catalogs'),
							'sub_categories' => "",
							'trademark' => set_value('trademark'),
							'price'  => trim($info_mail[4]),
							'unit'   => trim($info_mail[2]),	
							'style'  => trim($info_mail[3]),				
							'status' => 1,
							'created' => $this->data['date_now'],
							'created_by' => $this->data['auth']->username,
							'modified' => $this->data['date_now'],
							'modified_by' => $this->data['auth']->username,
					);

					$id = $this->Products_model->insert($data);
				}
			}
			//redirect($this->data['module'].'/'.$this->data['controller']);	
		}		
		
		$this->layout->view(strtolower(__CLASS__)."/".__FUNCTION__,$this->data);
	}
	public function edit(){
		$this->data['title'] = "Sửa Sản Phẩm";	
		$id = $this->uri->segment(4);		
    	$this->data['getcsdl'] = $this->Products_model->getbyid($id);		
		$this->data['catalogs']   = $this->Products_catalogs_model->getselect();
		
		//--- lấy dữ lệu sản phẩm mua cùng
		$this->data['products_combo'] = array();
		$products_combo = $this->Products_combo_model->get_one_by(array("id_product"=>$id,"type"=>"1"));
		if(!empty($products_combo)){
			$products_combo = json_decode($products_combo->content);
			foreach($products_combo as $key=>$row){
				$this->data['products_combo'][$key] = new stdClass();
				$product_combo = $this->Products_model->get($row);				
				$this->data['products_combo'][$key]->name = $product_combo->title;
				$this->data['products_combo'][$key]->id = $product_combo->id;
			}
		}		
		//--- #lấy dữ lệu sản phẩm mua cùng

		//-- lấy dữ liệu biến thể
		$products_variant = $this->Products_variant_model->get_by(array("id_product"=>$this->data['getcsdl']->id));
		
		$this->data["products_variant"] = array();
		
		foreach ($products_variant as $key => $value) {
			$this->data["products_variant"][$key] = new stdClass();
			$attrib = json_decode($value->attrib);//lấy danh sách thuộc tính của 1 biến thể		
			if(is_array($attrib)){
				$this->data["products_variant"][$key]->check = 	$attrib;				
				$name = array();			
				foreach ($attrib as $_key => $_value) {					
					$tmp = $this->Attrib_check_model->get($_value);					
					$name[] = $tmp->title;
				}

				$this->data["products_variant"][$key]->media = json_decode($value->media);
				$this->data["products_variant"][$key]->title = $value->title;
				$this->data["products_variant"][$key]->avatar = $value->avatar;
				$this->data["products_variant"][$key]->price = $value->price;
				$this->data["products_variant"][$key]->sku = $value->sku;
				$this->data["products_variant"][$key]->id = $value->id;
				$this->data["products_variant"][$key]->name = implode(",",$name);
				$this->data["products_variant"][$key]->data_id = implode(",",$attrib);
			}
		}		
		$this->data["dir_variant"] = 'products/variant/'.$this->data['getcsdl']->id."/";
		//-- #lấy dữ liệu biến thể
		
		//--- lấy dữ liệu cho thuộc tính			
		$attrib = json_decode($this->data['getcsdl']->attrib);
		
		if(!empty($attrib))	{
			$index = 0;
			foreach($attrib as $_row){
				$attrib_insert = $this->Attrib_insert_model->getlist(0,0,array('status'=>1,'group'=>$_row));
				
				foreach($attrib_insert as $key=>$row){
					$this->data['tab_attrib'][] = $row;//dữ liệu show cho tab
					$this->data['set_attrib'] = $row;		
					if($index == 0) 	
						$this->data['active'] = TRUE;		
					else
						$this->data['active'] = FALSE;

					$this->data['getcsdl_attrib'] = $this->Attrib_insert_product_model->get_one_by(array( 'product_id'=>$this->data['getcsdl']->id,'attrib_insert_id'=>$row->id));
								
					switch($row->type){
						case 'image':
							$this->data['get_attib_insert'][] = $this->load->view('products/attrib_upload',$this->data,true);
						break;
						case 'text':
							$this->data['get_attib_insert'][] = $this->load->view('products/attrib_text',$this->data,true);
						break;
						case 'post':
							$this->data['get_attib_insert'][] = $this->load->view('products/attrib_post',$this->data,true);
						break;
					}
					
				}
				$index++;
			}
		}		
		//--- lấy dữ liệu cho thuộc tính
		
		//--- lấy dữ liệu thuộc tính chọn						
		$attrib_check = json_decode($this->data['getcsdl']->attrib_check);	
		if(!empty($attrib_check))	{
			foreach($attrib_check as $row){
				$attrib_check = $this->Attrib_check_model->getlist(0,0,array('status'=>1,'group'=>$row));				
				$this->data['set_attrib_check'] = $attrib_check;				
				$this->data['attrib_check_group_show'] = $this->Attrib_check_group_model->get($row);//dat show cho tranh bi trung				
				$this->data['getcsdl_attrib_check'] = $this->Attrib_check_product_model->get_one_by(array( 'product_id'=>$this->data['getcsdl']->id,
																										'attrib_check_group'=>$row));	
				
				switch($this->data['attrib_check_group_show']->type){
					case 'checkbox':
						$this->data['get_attib_check'][] = $this->load->view('products/attrib_checkbox',$this->data,true);					
						break;
					case 'radio':
						$this->data['get_attib_check'][] = $this->load->view('products/attrib_radio',$this->data,true);
						break;
				}
			}//foreach($attrib_check as $row)			
		}//if(!empty($attrib_check))	
		//--- #lấy dữ liệu thuộc tính chọn
		
		$this->form_validation->set_rules('title', 'Tiêu đề', 'trim|required');
		$this->form_validation->set_rules('code', 'Mã SP', 'trim|required');
		$this->form_validation->set_rules('slug', 'Slug', 'trim');
		$this->form_validation->set_rules('description', 'Description', 'trim');
		$this->form_validation->set_rules('keywords', 'Keywords', 'trim');
		$this->form_validation->set_rules('home_text', 'Nội dung ngắn', 'trim');
		$this->form_validation->set_rules('body_text', 'Nội dung', 'trim');
		$this->form_validation->set_rules('catalogs', 'Danh mục', 'trim');
		$this->form_validation->set_rules('sub_categories[]', 'Danh mục phụ', 'trim');
		$this->form_validation->set_rules('product_combo[]', 'Gợi ý SP', 'trim');
		$this->form_validation->set_rules('trademark', 'Thương Hiệu', 'trim');
		$this->form_validation->set_rules('price', 'Giá', 'trim');	
		$this->form_validation->set_rules('code_aen', 'Mã', 'trim');
		$this->form_validation->set_rules('code_sku', 'Mã SUK', 'trim');
		$this->form_validation->set_rules('image_url', 'Link ảnh', 'trim');
		$this->form_validation->set_rules('image_lib', 'Link Thư Viện', 'trim');
		$this->form_validation->set_rules('image', 'Hình mình họa', 'trim');
			
		if($this->form_validation->run() == TRUE){
			if(empty(set_value('code_sku')) && !empty(set_value('trademark'))){
				$codesku = $this->ruadmin->createSKU(set_value('trademark'),set_value('title'));
			}else{
				$codesku = $this->ruadmin->createSKU(set_value('catalogs'),set_value('title'));
			}
			
			$slug = set_value('slug');
			if(empty($slug))  	
				$slug = $this->ruadmin->slug(set_value('title'),'Products_model');	
			else{
				if($this->data['getcsdl']->slug != set_value('slug'))
					$slug = $this->ruadmin->slug(set_value('slug'),'Products_model');	
			}	
			
			if(!empty(set_value('sub_categories')))
				$sub_categories = json_encode(set_value('sub_categories'));
			else
				$sub_categories = null;		
				
			$data = array(
					'title' => set_value('title'),
					'slug' => $slug,
					'code' => set_value('code'),
					'code_aen' => set_value('code_aen'),
					'code_sku' => $codesku,
					'description' => set_value('description'),
					'keywords' => set_value('keywords'),
					'home_text' => html_entity_decode(set_value('home_text')),
					'body_text' => html_entity_decode(set_value('body_text')),					
					'catalogs' => set_value('catalogs'),
					'sub_categories' => $sub_categories,
					'trademark' => set_value('trademark'),
					'price'    => set_value('price'),
					'modified' => $this->data['date_now'],
					'modified_by' => $this->data['auth']->username,
			);
		
			$this->Products_model->update($id,$data);
			
			if(empty(set_value('image_lib')) ){	
				if(empty(set_value('image_url')) ){			
					$fileimg = $this->ruadmin->upFile($this->data['config_upload'],'image');				
					if($fileimg["status"] == 200 or $fileimg["status"] == 300 ){					
						$this->ruadmin->removeImg($this->data['getcsdl']->image,$this->data['config_upload']["dir"]);
						$this->Products_model->update( $id,array('image'=>$fileimg["src"]) );	
					}
				}else{
					$fileimg = $this->ruadmin->upload_url(set_value('image_url'),$this->data['config_upload']);
					if($fileimg){
						$this->ruadmin->removeImg($this->data['getcsdl']->image,$this->data['config_upload']["dir"]);
						$this->Products_model->update( $id,array('image'=>$fileimg) );	
					}
				}
			}else{
				$this->ruadmin->removeImg($this->data['getcsdl']->image,$this->data['config_upload']["dir"]);
				$this->Products_model->update( $id,array('image'=>set_value('image_lib')));
			}
			
			//--- xử lý sản phẩm gợi ý
			if(!empty(set_value('product_combo')))
				$product_combo = json_encode(set_value('product_combo'));
			else
				$product_combo = null;
			
			if(!empty($product_combo)){
				if(!empty($this->data['products_combo'])){
					$this->Products_combo_model->update_by(array("id_product"=>$id),array('content'=>$product_combo));	
				}else{
					$this->Products_combo_model->insert(array("id_product"=>$id,'content'=>$product_combo,"type"=>1,"value"=>""));
				}
			}else{
				if(!empty($this->data['products_combo'])){
					$this->Products_combo_model->delete_by(array("id_product"=>$id,"type"=>1));	
				}
			}			
			//--- dua du lieu attrib vao database
			$attrib = json_decode($this->data['getcsdl']->attrib);
		
			if(!empty($attrib))	{
				foreach($attrib_insert as $row){
					if($row->type == 'text' or $row->type == 'post' ){						
						$getcsdl = $this->Attrib_insert_product_model->get_one_by(array('product_id'=>$id,'attrib_insert_id'=>$row->id));
						$content = $_POST[$id.'_'.$row->id];
						if($content != ""){
							if(empty($getcsdl)){//neu chua co gia tri thi them vao						
								$setcsdl = array('product_id'=>$id,
												 'attrib_insert_id'=>$row->id,
												 'content'=>html_entity_decode($content));												 
								$this->Attrib_insert_product_model->insert($setcsdl);								
							}else{													
								$setcsdl = array('content'=>html_entity_decode($content));								
								$this->Attrib_insert_product_model->update($getcsdl->id,$setcsdl);								
							}
						}						
					}
				}
			}
			//--- dua du lieu attrib vao database
			
			//--- dua du lieu attrib check vao database
			$attrib_check = json_decode($this->data['getcsdl']->attrib_check);
			if(!empty($attrib_check))	{//kiem tra xem có attrib check ko
			
				foreach($attrib_check as $row){
					$attrib_check = $this->Attrib_check_group_model->get($row);
					
					$getcsdl = $this->Attrib_check_product_model->get_one_by(array('product_id'=>$id,'attrib_check_group'=>$attrib_check->id));//kiem tra coi đã có attrib check chua
					if(!empty($_POST['attrib_check_'.$attrib_check->id])){
						switch($attrib_check->type){
									case 'checkbox':
										$attrib_check_group = json_encode($_POST['attrib_check_'.$attrib_check->id]);
										//kiểm tra xem attrib_check đã tồn tài chưa, nếu chưa thì thêm vào
										foreach ($_POST['attrib_check_'.$attrib_check->id] as $key => $value) {	
											if (is_numeric($value) != 1) {										
												$checkAdd = $this->Attrib_check_model->get_by(array("title"=>$value));
												if (empty($checkAdd)) {					
													if (empty($checkAdd)) {
														$id_new_attrib_check = $this->Attrib_check_model->insert(
															array("group"=>$attrib_check->id,"title"=>$value,
																 'created'     => $this->data['date_now'],
																 'created_by'  => $this->data['auth']->username,
																 'status'      => 1)
														);
														$_POST['attrib_check_'.$attrib_check->id] = str_replace(array($value), $id_new_attrib_check, $_POST['attrib_check_'.$attrib_check->id]);											
														$attrib_check_group = json_encode($_POST['attrib_check_'.$attrib_check->id]);												
													}
												}
											}										
										}
										break;
									case 'radio':
										$attrib_check_group = $_POST['attrib_check_'.$attrib_check->id];
										break;
						}
						if(empty($getcsdl)){//neu chua co gia tri thi them vao
								$setcsdl = array('product_id'=>$id,
												 'attrib_check_group'=>$attrib_check->id,
												 'attrib_check_id'=>$attrib_check_group);
								$this->Attrib_check_product_model->insert($setcsdl);
						}else{				
								$setcsdl = array('attrib_check_id'=>$attrib_check_group);
								$this->Attrib_check_product_model->update($getcsdl->id,$setcsdl);
						}#-- if(empty($getcsdl)){
					}
					
				}
			}
			//--- dua du lieu attrib check vao database
			
			
			redirect($this->data['module'].'/'.$this->data['controller']);	
		  
		}
		$this->layout->view(strtolower(__CLASS__.'/edit'),$this->data);  		
	}
		
	public function attrib_upload_file_ajax($product_id,$attrib_insert_id){//ajax dành cho up nhiều file
		$this->config->load('template');		
		$targetDir = $this->config->item('image_products');	
	
		$targetDir["dir"] = ROOT_DIR.'upload/products/attrib/'.$product_id;
		$targetDir["name"] = 'file';
		$fileimg = $this->ruadmin->upFile($targetDir,'file');
		$json = array("status" => 404,"msg"=>"Đăng ảnh thất bại","name"=>"","src"=>"");
		if($fileimg['status'] == 200){			
			//-- dua ten anh vao databas
			$this->load->model('Attrib_insert_product_model');
			$getcsdl = $this->Attrib_insert_product_model->get_one_by(array('product_id'=>$product_id,'attrib_insert_id'=>$attrib_insert_id));
			if(empty($getcsdl)){//neu chua co gia tri thi them vao
				$setcsdl = array('product_id'=>$product_id,
								 'attrib_insert_id'=>$attrib_insert_id,
								 'content'=>json_encode(array($fileimg["src"])));
				$this->Attrib_insert_product_model->insert($setcsdl);
			}else{				
				$content = json_decode($getcsdl->content);
				$content[] = $fileimg["src"];
				$setcsdl = array('content'=>json_encode($content));
				$this->Attrib_insert_product_model->update($getcsdl->id,$setcsdl);
			}
			$json = array("status" => 200,"msg"=>"Đăng ảnh thành công","name"=>$fileimg["src"],"src"=>base_url()."upload/".$this->data['config_upload']["dirweb"]."/".$fileimg["src"]);
			//-------------------------
		}
		$this->output->set_content_type('application/json')->set_output(stripslashes(json_encode($json)));		
	}//attrib_upload_file_ajax
    
    public function attrib_remove_file_ajax(){
        
        $return = array("status" => false);
        
        if($this->input->post("img")){
            $this->load->model("Attrib_insert_product_model");
            $get_csdl = $this->Attrib_insert_product_model->get_one_by(array("product_id"=>$this->input->post("id"), "attrib_insert_id"=>4));
            
            $get = json_decode($get_csdl->content);
            $insert = array();
            if(count($get) >= 1){
                foreach($get as $row){
                    if($this->input->post("img") != $row){
                        $insert[] = $row;
                    }else{
                        @unlink(ROOT_DIR.'upload/products/attrib/'.$this->input->post("id")."/".$row);
                    }
                }
                
                $this->Attrib_insert_product_model->update($get_csdl->id,array("content"=>json_encode($insert)));
                $return = array("status" => true);
            }   
        }
        $this->output->set_content_type('application/json')->set_output(json_encode($return));
    }
    
	public function delete(){	  
		$json = array("status"=>404,"msg"=>"Lỗi thực hiện lệnh","callback"=>"");
		$this->form_validation->set_rules('id', 'ID', 'trim|is_natural_no_zero|required');
		if($this->form_validation->run() == TRUE){
			$id = set_value('id');

			$data = $this->Products_model->get_one_by(array('id'=>$id));
			if ($data) {
				if($this->Products_model->delete_by( array('id'=>$id) )){
					$img = $this->ruadmin->removeImg($data->image,$this->data['config_upload']["dir"]);						
					$imgPost = $this->ruadmin->getImageInContent($data->body_text,true);	

					//Rảnh sử lý lại phần này, cho auto thuộc tính chứ ko phải cố định ID bằng 4
					//xoa anh thuoc tinh nhap
					$get_csdl = $this->Attrib_insert_product_model->get_one_by(array("product_id"=>$id, "attrib_insert_id"=>4));         
					if($get_csdl){
						$get = json_decode($get_csdl->content);
						if(count($get) >= 1){
							foreach($get as $row){
								@unlink(ROOT_DIR.'upload/products/attrib/'.$id."/".$row);
							}
						}
					}   					
					//xoa anh thuoc tinh nhap
					$this->Attrib_insert_product_model->delete_by( array('product_id'=>$id) );				
					$this->Attrib_check_product_model->delete_by( array('product_id'=>$id) );

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
			$data = $this->Products_model->get_one_by(array('id'=>$id));			
			if ($data) {
				if($data->status == 1)
					$setdata = array('status'=> 0);
				else
					$setdata = array('status'=> 1);
				
				if($this->Products_model->update($id,$setdata)){
					$json = array("status"=>200,"msg"=>"Bạn vừa chuyển trạng thái một mục","callback"=>$data->id);
				}
			}else{
				$json["msg"] = "Mục không tồn tại";
			}
		}	
		$this->output->set_content_type('application/json')->set_output(json_encode($json));
	}
	
	public function ajax_up(){
		$id_product = $this->input->post('id_product');
		
		$id_catalogs = $this->input->post('id_catalogs');
		
		$getcsdl = $this->Products_model->get($id_product);
		
		if(!empty($getcsdl)){
			
			$id_catalogs = $this->Products_catalogs_model->get($id_catalogs);
			if(!empty($id_catalogs)){
				if($this->Products_model->update($getcsdl->id,array('catalogs'=>$id_catalogs->id))){
					$return = json_encode(array('msg'=>'Đã chuyển cây thư mục'));
				}else{
					$return = json_encode(array('msg'=>'Không thể thực hiện'));
				}
			}else{
				$return = json_encode(array('msg'=>'Thư mục không tồn tại'));
			}
		}else{
			$return = json_encode(array('msg'=>'ID sản phẩm không tồn tại'));
		}
		echo $return;
	}
	
	public function ajax_price(){
		$array_getcsdl = array('status'=>'false' ,'content'=>'');	
		$this->form_validation->set_rules('id_product', 'Id Sản Phẩm', 'trim|required');
		$this->form_validation->set_rules('price', 'Giá', 'trim|required');
		
		if($this->form_validation->run() == TRUE){
			$getcsdl = $this->Products_model->get(set_value('id_product'));
			if($getcsdl){
				$setcsdl = array(
							'modified' => $this->data['date_now'],
							'modified_by' => $this->data['auth']->username,
							"price"=>set_value('price')
							);
				
				$this->Products_model->update($getcsdl->id,$setcsdl);
				$array_getcsdl = array('status'=>'true' ,'content'=>"Cập nhật giá thành ".number_format(set_value('price'), 0, ',', '.'));	
			}else{
				$array_getcsdl = array('status'=>'false' ,'content'=>"Không tìm thấy sản phẩm");	
			}
			
		}else{
			$array_getcsdl = array('status'=>'false' ,'content'=>validation_errors(' ','<br>'));
		}		
		$this->output->set_content_type('application/json')->set_output(json_encode($array_getcsdl));
	}
	
	public function ajax_getproduct(){
		$array_getcsdl = array('status'=>'200','msg'=>'','content'=>'');	
		$this->form_validation->set_rules('id_catalogs', 'ID Danh Mục', 'trim|required');
		
		if($this->form_validation->run() == TRUE){
			$getcsdl = $this->Products_model->get_by(array("catalogs"=>set_value('id_catalogs')));
			
			if($getcsdl){
				$content = array();
				foreach($getcsdl as $key=>$row){
					 $data = new stdClass();
					 $data->name = $row->title;
					 $data->id = $row->id;
					 $content[$key] = $data;
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

	//Tạo biến thể
	public function attrib_in_product_ajax(){        
        $array_getcsdl = array();	
		$this->form_validation->set_rules('id', 'ID mặt hàng', 'trim|required');

		if($this->form_validation->run() == TRUE){
			$attrib_check = array();
			$attrib_check_product = $this->Attrib_check_product_model->get_by(array("product_id"=>set_value("id")));

			foreach ($attrib_check_product as $key => $value) {
				array_push($attrib_check, $value->attrib_check_group);
			}
			$attrib_check = array_unique($attrib_check);
			
			foreach ($attrib_check as $key => $value) {
				$attrib_check_group = $this->Attrib_check_group_model->get($value);			
				$array_getcsdl[$key] = array("id"=>$attrib_check_group->id,"text"=>$attrib_check_group->title);
			}
		}	
		$this->output->set_content_type('application/json')->set_output(json_encode($array_getcsdl));
    }
    public function variant_attrib_ajax(){
		$array_getcsdl = array('status'=>'200','msg'=>'','content'=>'');	
		$this->form_validation->set_rules('attrib_group[]', 'Nhóm thuộc tính chọn', 'trim|required');
		$this->form_validation->set_rules('id', 'ID mặt hàng', 'trim|required');
		
		$attrib_product = array();
		if($this->form_validation->run() == TRUE){
			foreach (set_value("attrib_group") as $key => $value) {
				$attrib = $this->Attrib_check_product_model->get_one_by(array("product_id"=>set_value("id"),"attrib_check_group"=>$value));
				$attrib_check = array();
			
				foreach (json_decode($attrib->attrib_check_id) as $_key => $_value) {
					$tmp = $this->Attrib_check_model->get($_value);
					$attrib_check[] = array("id"=>$tmp->id,"text"=>$tmp->title);
				}				
				$attrib_product[$key] = $attrib_check;
			}
			$array_getcsdl = array('status'=>'200','msg'=>'','content'=>json_encode($attrib_product));	
		}else{
			$array_getcsdl = array('status'=>'404' ,'msg'=>validation_errors(' ','<br>'),'content'=>'');
		}		
		$this->output->set_content_type('application/json')->set_output(json_encode($array_getcsdl));
	}
	public function variant_ajax(){
		$array_getcsdl = array('status'=>'200','msg'=>'Lỗi','content'=>'');	
		$this->form_validation->set_rules('attrib_id', 'ID Thuộc Tính', 'trim|required');
		$this->form_validation->set_rules('attrib_name', 'Tên Thuộc Tính', 'trim|required');
		$this->form_validation->set_rules('price', 'Giá', 'trim|required');
		$this->form_validation->set_rules('id_product', 'ID mặt hàng', 'trim|required');
		$this->form_validation->set_rules('title', 'Tiêu đề', 'trim');
		
		if($this->form_validation->run() == TRUE){
			$products = $this->Products_model->get(set_value('id_product'));

			$attrib_name = explode(",",set_value('attrib_name'));

			foreach ($attrib_name as $key => $value) {
				$attrib_name[$key] = mb_substr($value,0,5);
			}

			$attrib_name  = implode("",$attrib_name);

			$code_sku = $this->ruadmin->createSKU(null,$products->code_sku,$attrib_name);

			$attrib = explode(",",set_value('attrib_id'));

			$setcsdl = array(
						"id_product"=>set_value('id_product'),
						"sku"       =>$code_sku,
						"attrib"    =>json_encode($attrib),
						"title"     =>set_value('title'),
						"price"     =>set_value('price'),
						);

			$products_variant = $this->Products_variant_model->get_one_by(array("id_product"=>set_value('id_product'),"title"=>set_value('title'),"attrib"=>json_encode($attrib)));

			if(!empty($products_variant)){
				$id_variant = $products_variant->id;
				$this->Products_variant_model->update($id_variant,$setcsdl);

				$this->config->load('template');
				$targetDir = $this->config->item('image_products');
				$targetDir["dir"] = ROOT_DIR.'upload/products/variant/'.set_value('id_product')."/".$id_variant;
				$this->ruadmin->create_foder(ROOT_DIR.'upload/products/variant/'.set_value('id_product'),false);
				$targetDir["name"] = 'avatar';
				$fileimg = $this->ruadmin->upFile($targetDir,'avatar');					
				if($fileimg["status"] == 200 or $fileimg["status"] == 300 ){
					@unlink(ROOT_DIR.'upload/products/variant/'.set_value('id_product')."/".$id_variant."/".$products_variant->avatar);	
					$this->Products_variant_model->update( $id_variant,array('avatar'=>$fileimg["src"]) );	
				}

				$array_getcsdl = array('status'=>'200','msg'=>'Cập nhật biến thể thành công','content'=>$id_variant);	
			}else{
				$id_variant = $this->Products_variant_model->insert($setcsdl);

				if ($id_variant) {
					$this->config->load('template');
					$targetDir = $this->config->item('image_products');
					$targetDir["dir"] = ROOT_DIR.'upload/products/variant/'.set_value('id_product')."/".$id_variant;
					$this->ruadmin->create_foder(ROOT_DIR.'upload/products/variant/'.set_value('id_product'),false);
					$targetDir["name"] = 'avatar';
					$fileimg = $this->ruadmin->upFile($targetDir,'avatar');					
					if($fileimg["status"] == 200 or $fileimg["status"] == 300 ){						 
						$this->Products_variant_model->update( $id_variant,array('avatar'=>$fileimg["src"]) );	
					}
				}
				$array_getcsdl = array('status'=>'200','msg'=>'Đã thêm thêm biến thể cho sản phẩm','content'=>$id_variant);	
			}			
		}else{
			$array_getcsdl = array('status'=>'404' ,'msg'=>validation_errors(' ','<br>'),'content'=>'');
		}		
		$this->output->set_content_type('application/json')->set_output(json_encode($array_getcsdl));
	}
	public function variant_upload_file_ajax(){//ajax dành cho up nhiều file
		$this->form_validation->set_rules('id_product', 'ID mặt hàng', 'trim|required');
		$this->form_validation->set_rules('id_variant', 'ID mặt hàng', 'trim|required');
		$json = array("status" => 404,"msg"=>"Đăng ảnh thất bại","name"=>"","src"=>"");

		if($this->form_validation->run() == TRUE){
			$products_variant = $this->Products_variant_model->get(set_value('id_variant'));		
			if(empty($products_variant)){
				$json = array("status" => 404,"msg"=>"Đăng ảnh thất bại","name"=>"","src"=>"");
				return $json;
				die();
			}

			$this->config->load('template');		
			$targetDir = $this->config->item('image_products');	
		
			$targetDir["dir"] = ROOT_DIR.'upload/products/variant/'.set_value('id_product')."/".set_value('id_variant');
			$this->ruadmin->create_foder(ROOT_DIR.'upload/products/variant/'.set_value('id_product'),false);
			$targetDir["name"] = 'file';
			$fileimg = $this->ruadmin->upFiles($targetDir,'file');
		
			if($fileimg['status'] == 200){	
				$media = json_decode($products_variant->media);
				$src = json_decode($fileimg["src"]);
				if (!is_array($media)) {
					$media = $src;
				}else{
					$media = array_merge($media,$src); 
				}
				//$media[] = $fileimg["src"];
				$setcsdl = array('media'=>json_encode($media));
				
				$this->Products_variant_model->update($products_variant->id,$setcsdl);				
				$json = array("status" => 200,"msg"=>"Đăng ảnh thành công","name"=>"","src"=>"");
				//-------------------------
			}
		}
		$this->output->set_content_type('application/json')->set_output(stripslashes(json_encode($json)));		
	}//attrib_upload_file_ajax
    
    public function variant_remove_file_ajax(){
        
        $return = array("status" => false);
        
        if($this->input->post("img")){
            $get_csdl = $this->Products_variant_model->get($this->input->post("id"));

            if(empty($get_csdl)) 
            	show_404();

            $get = json_decode($get_csdl->media);
            $insert = array();
            if(count($get) >= 1){
                foreach($get as $row){
                    if($this->input->post("img") != $row){
                        $insert[] = $row;
                    }else{
                        @unlink(ROOT_DIR.'upload/products/variant/'.$get_csdl->id_product."/".$this->input->post("id")."/".$row);
                    }
                }                
                $this->Products_variant_model->update($get_csdl->id,array("media"=>json_encode($insert)));
                $return = array("status" => true);
            }   
        }
        $this->output->set_content_type('application/json')->set_output(json_encode($return));
    }
    public function variant_delete_ajax(){
	  	$this->form_validation->set_rules('id', 'ID mặt hàng', 'trim|required');
		$json = array("status" => 404,"msg"=>"Xóa biến thể thất bại","data"=>"");

		if($this->form_validation->run() == TRUE){
			$this->data['getcsdl'] = $this->Products_variant_model->get(set_value("id"));	
		
			if($this->data['getcsdl']){
				$dir_variant = 'products/variant/'.$this->data['getcsdl']->id_product."/".$this->data['getcsdl']->id;				
				if($this->Products_variant_model->delete_by( array('id'=>$this->data['getcsdl']->id) )){
					$this->ruadmin->delFolder($dir_variant);
					$json = array("status" => 200,"msg"=>"Biến thể đã được xóa","data"=>"");
				}
			}else{
				$json = array("status" => 404,"msg"=>"Biến thể không tồn tại","data"=>"");
			}
		}
		$this->output->set_content_type('application/json')->set_output(json_encode($json));
	}	
	//cập nhật thuộc tính
	public function attrib_properties_ajax(){
		$this->form_validation->set_rules('idProduct', 'ID Sản phẩm', 'trim|required');	
		$json = array("status" => 404,"msg"=>"Lỗi","data"=>"");	
		if($this->form_validation->run() == TRUE){
			$this->data['getcsdl'] = $this->Products_model->getbyid(set_value('idProduct'));

			$attrib_check = json_decode($this->data['getcsdl']->attrib_check);
			if(!empty($attrib_check)){//kiem tra xem có attrib check ko			
				foreach($attrib_check as $row){
					$attrib_check = $this->Attrib_check_group_model->get($row);					
					$Attribgetcsdl = $this->Attrib_check_product_model->get_one_by(array('product_id'=>set_value('idProduct'),'attrib_check_group'=>$attrib_check->id));//kiem tra coi đã có attrib check chua
					if(!empty($_POST['attrib_check_'.$attrib_check->id])){
						switch($attrib_check->type){
							case 'checkbox':
								$attrib_check_group = json_encode($_POST['attrib_check_'.$attrib_check->id]);
								//kiểm tra xem attrib_check đã tồn tài chưa, nếu chưa thì thêm vào
								foreach ($_POST['attrib_check_'.$attrib_check->id] as $key => $value) {	
									if (is_numeric($value) != 1) {										
										$checkAdd = $this->Attrib_check_model->get_by(array("title"=>$value));
										if (empty($checkAdd)) {					
											if (empty($checkAdd)) {
												$id_new_attrib_check = $this->Attrib_check_model->insert(
													array("group"=>$attrib_check->id,"title"=>$value,
														 'created'     => $this->data['date_now'],
														 'created_by'  => $this->data['auth']->username,
														 'status'      => 1)
												);
												$_POST['attrib_check_'.$attrib_check->id] = str_replace(array($value), $id_new_attrib_check, $_POST['attrib_check_'.$attrib_check->id]);											
												$attrib_check_group = json_encode($_POST['attrib_check_'.$attrib_check->id]);												
											}
										}
									}										
								}								
								break;
							case 'radio':
								$attrib_check_group = $_POST['attrib_check_'.$attrib_check->id];
								break;
						}						
						if(empty($Attribgetcsdl)){//neu chua co gia tri thi them vao
								$setcsdl = array('product_id'=>set_value('idProduct'),
												 'attrib_check_group'=>$attrib_check->id,
												 'attrib_check_id'=>$attrib_check_group
												 );								
								$this->Attrib_check_product_model->insert($setcsdl);								
						}else{				
								$setcsdl = array('attrib_check_id'=>$attrib_check_group);															
								$this->Attrib_check_product_model->update($Attribgetcsdl->id,$setcsdl);								
						}#-- if(empty($getcsdl)){
					}					
				}
			}
			$array_getcsdl = array();
			$attrib_check = array();
			$attrib_check_product = $this->Attrib_check_product_model->get_by(array("product_id"=>set_value("idProduct")));
			foreach ($attrib_check_product as $key => $value) {
				array_push($attrib_check, $value->attrib_check_group);
			}
			$attrib_check = array_unique($attrib_check);
			
			foreach ($attrib_check as $key => $value) {
				$attrib_check_group = $this->Attrib_check_group_model->get($value);			
				$array_getcsdl[$key] = array("id"=>$attrib_check_group->id,"text"=>$attrib_check_group->title);
			}
			$json = array("status" => 200,"msg"=>"Bạn vừa cập nhật thuộc tính cho sản phẩm","data"=>$array_getcsdl);
		}	

		$this->output->set_content_type('application/json')->set_output(json_encode($json));
	}
}
