<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class Ruadmin

{

	function __construct(){
		$this->CI =& get_instance();//đưa về root
	}
	
	function cutString($str,$muber,$style=" ..."){

		if(strlen($str)>$muber) { //Đếm kí tự chuỗi $str, 100 ở đây là chiều dài bạn cần quy định

			$strCut = substr($str, 0, $muber); //Cắt 100 kí tự đầu

			$str = substr($strCut, 0, strrpos($strCut, ' ')); //Tránh trường hợp cắt dang dở như "nội d... Read More"

			$str .= $style;

		}

		return $str;

	}
	
	function vn_date($time) {

		$today = strtotime(date('d-m-Y'));	
		$time = strtotime($time);
		$reldays = ($time - $today)/86400;	
		$h = date("H:i",$time);
		
		if ($reldays >= 0 && $reldays < 1) {	
			return 'Hôm nay, lúc '.$h;	
		} else if ($reldays >= 1 && $reldays < 2) {	
			return 'Ngày mai, lúc '.$h;	
		} else if ($reldays >= -1 && $reldays < 0) {
			return 'Hôm qua, lúc '.$h;	
		}	

		if (abs($reldays) < 7) {	
			if ($reldays > 0) {		
				$reldays = floor($reldays);		
				return $reldays.' Ngày tới, lúc '.$h;	
			} else {	
				if(date('N',$time) < date('N',$today)){
					if(date('N',$time) == 7) 
						$thu = 'Chủ nhật,';
					else
						$thu = 'Thứ '.(date('N',$time)+1);
					return $thu.', lúc '.$h;	
				}else{
					$reldays = abs(floor($reldays));	
					return $reldays.' Ngày trước, lúc '.$h;
				}
			}	
		}

		if (abs($reldays) < 182) {
			if(date('N',$time) == 7) 
				$thu = 'Chủ nhật';
			else
				$thu = 'Thứ '.(date('N',$time)+1);

			return $thu.", lúc ".date("H:i",$time)." ".date("d-m",$time);	
		} else {	
			return date("H:i, d-m-Y",$time);	
		}
	}
	
	function status($s){
		switch($s){
			case '-1':
				return "Đã xóa";
			case '1':
				return "Hoạt Động";
			case '0':
				return "Tạm Ngưng";	
		}
	}
	
	function slug($str,$table = NULL,$lowercase = TRUE){		

		if(!$str) return false;
			$marTViet=array("à","á","ạ","ả","ã","â","ầ","ấ","ậ","ẩ","ẫ","ă",
			"ằ","ắ","ặ","ẳ","ẵ","è","é","ẹ","ẻ","ẽ","ê","ề"
			,"ế","ệ","ể","ễ",
			"ì","í","ị","ỉ","ĩ",
			"ò","ó","ọ","ỏ","õ","ô","ồ","ố","ộ","ổ","ỗ","ơ"
			,"ờ","ớ","ợ","ở","ỡ",
			"ù","ú","ụ","ủ","ũ","ư","ừ","ứ","ự","ử","ữ",
			"ỳ","ý","ỵ","ỷ","ỹ",
			"đ",
			"À","Á","Ạ","Ả","Ã","Â","Ầ","Ấ","Ậ","Ẩ","Ẫ","Ă"
			,"Ằ","Ắ","Ặ","Ẳ","Ẵ",
			"È","É","Ẹ","Ẻ","Ẽ","Ê","Ề","Ế","Ệ","Ể","Ễ",
			"Ì","Í","Ị","Ỉ","Ĩ",
			"Ò","Ó","Ọ","Ỏ","Õ","Ô","Ồ","Ố","Ộ","Ổ","Ỗ","Ơ"
			,"Ờ","Ớ","Ợ","Ở","Ỡ",
			"Ù","Ú","Ụ","Ủ","Ũ","Ư","Ừ","Ứ","Ự","Ử","Ữ",
			"Ỳ","Ý","Ỵ","Ỷ","Ỹ",
			"Đ",
			' ','?','!','/','~',')','(','@','#','$','%','^','&','|','\'','"','.',',','`',';',':',
			'&nbsp;','&lt;','&gt;','&amp;','&quot;','&apos;','_','+','<br>','<','>',
			'®','™',"’",
			' - ','  ',' – ','-–-','--','---'
			);
			

			$marKoDau=array("a","a","a","a","a","a","a","a","a","a","a"
			,"a","a","a","a","a","a",
			"e","e","e","e","e","e","e","e","e","e","e",
			"i","i","i","i","i",
			"o","o","o","o","o","o","o","o","o","o","o","o"
			,"o","o","o","o","o",
			"u","u","u","u","u","u","u","u","u","u","u",
			"y","y","y","y","y",
			"d",
			"A","A","A","A","A","A","A","A","A","A","A","A"
			,"A","A","A","A","A",
			"E","E","E","E","E","E","E","E","E","E","E",
			"I","I","I","I","I",
			"O","O","O","O","O","O","O","O","O","O","O","O"
			,"O","O","O","O","O",
			"U","U","U","U","U","U","U","U","U","U","U",
			"Y","Y","Y","Y","Y",
			"D",
			'-','','','','','','','','','','','','','','','','','','','','',
			'-','','','-','','','-','-','','','',
			'','','-',
			'','','','-','-','-'
			);

			$str = str_replace($marTViet,$marKoDau,$str);
			$str = str_replace($marTViet,$marKoDau,$str);
			$str = str_replace($marTViet,$marKoDau,$str);
			if ($lowercase === TRUE)
			{
				$str = strtolower($str);
			}			

			if ($table != NULL){
				$this->CI->load->model($table);
				$check = $this->CI->$table->get_one_by(array("slug"=>$str));	
				
				if ($check)
				{
					$count_by = $this->CI->$table->get_one_by(array("id > "=> 0),"desc");
					$str = $str.'-'.$count_by->id;
				}
			}

		return $str;

	}
	//# UPLOAD HÌNH ẢNH
	function upFiles($_config,$file_name){
		$upload_data = NULL;   
		$images = array();
		$return = array();	
		
		if(!empty($_FILES[$_config['name']])){
			if(count($_FILES[$_config['name']]['name']) > 0){
				for( $i=0; $i < count($_FILES[$file_name]['name']); $i++ ){
					$_FILES['userfile']['name']     = $_FILES[$file_name]['name'][$i];
					$_FILES['userfile']['type']     = $_FILES[$file_name]['type'][$i];
					$_FILES['userfile']['tmp_name'] = $_FILES[$file_name]['tmp_name'][$i];
					$_FILES['userfile']['error']    = $_FILES[$file_name]['error'][$i];
					$_FILES['userfile']['size']     = $_FILES[$file_name]['size'][$i];	
					
					$return = $this->upFile($_config,"userfile");
					
					if($return["status"] == 200 or $return["status"] == 300){
						if($return['src'] != "")
							array_push($images,$return['src']);
					}
				}//vòng lập file
				if(count($images) > 0){					
					$return = array(
							'status' => 200,//ko co hinh
							'msg'    => "Up danh sách ảnh thành công",
							'src'	 => json_encode($images)
							);
					return $return;
				}else{
					$return = array(
							'status' => 404,//ko co hinh
							'msg'    => "Không có list hình",
							'src'	 => ""
							);
					return $return;
				}
			}else{
				$return = $this->upFile($_config,$file_name);
				return $return;
			}
		}else{
			$return = array(
							'status' => 404,//ko co hinh
							'msg'    => "Chưa chọn hình",
							'src'	 => ""
							);
			return $return;
		}
	}	
	function upFile($_config,$file_name = null){	
		if(empty($file_name)){
			$file_name = $_config["name"];
		}
		if(!empty($_FILES[$file_name])){
			$upload_data = NULL;   
			$images = array();
			$return = array();		
				
			$create_foder = $this->create_foder($_config['dir']);
			$upload_thumb_path = $create_foder['upload_thumb_path'];
			$upload_min_path   = $create_foder['upload_min_path'];	
			
            $config['upload_path']          = $_config['dir'];
			$config['allowed_types']        = 'gif|jpg|jpeg|webp|png|jpeg|mp4|mp3';//thêm webp ở dòng 903 system\libraries\Upload.php và thêm trong file mimes.php
			//$config['allowed_types']        = '*';
			$config['max_size']             = 50 * 1024;
								
			$this->CI->load->library('upload', $config);
				
			$config['file_name'] = $this->check_file_exists($_FILES[$file_name]['name'],$_config['dir']);
		
			$this->CI->upload->initialize($config);
		
			if (!$this->CI->upload->do_upload($file_name)){						
				$return = array(
										'status' => 404,
										'msg'    => $this->CI->upload->display_errors(),
										'src'	 => ""
									 );					
				return $return;
			} else {	
				$upload_data =  $this->CI->upload->data();
				$this->CI->load->library('image_lib');
				$thumb_config['image_library'] = 'GD2'; //i also wrote GD/gd2
				$thumb_config['source_image']= $upload_data['full_path'];
				//$config['maintain_ratio'] = TRUE;
				//  Up ảnh thumb/min				
				if($_config['thumb']){
					
					$size = $this->calcImageSize($_config["width_thumb"],$_config["height_thumb"],$_config["width"],$_config["height"]);
					
					$thumb_config['width']  = $size['newWidth'];
					$thumb_config['height'] = $size['newHeight'];						
					$thumb_config['new_image']= $upload_thumb_path;
				
					$this->CI->image_lib->initialize($thumb_config);

					if (!$this->CI->image_lib->resize()){
						
						$return = array(
												'status' => 300,//loi o anh thumb
												'msg'    => $this->CI->upload->display_errors(),
												'src'    => $upload_data['file_name']
												);
					}
					
					$this->CI->image_lib->clear();	
					
				}//kiểm tra coi có tạo thumb hay ko
				if($_config['thumb']){
					$size = $this->calcImageSize($_config["width_min"],$_config["height_min"],$_config["width"],$_config["height"]);
					
					$thumb_config['width']  = $size['newWidth'];
					$thumb_config['height'] = $size['newHeight'];						
					$thumb_config['new_image']= $upload_min_path;
				
					$this->CI->image_lib->initialize($thumb_config);
					if (!$this->CI->image_lib->resize()){
						
						$return = array(
												'status' => 300,//loi o anh thumb
												'msg'    => $this->CI->upload->display_errors(),
												'src'    => $upload_data['file_name']
												);
					}
					$this->CI->image_lib->clear();
				}//kiểm tra coi có tạo min hay ko
				//# Up ảnh thumb/min
				
				
				//Giảm kích thước ảnh gốc
				if($upload_data['image_width'] > $_config['width']){
					$size = $this->calcImageSize($_config["width"],$_config["height"],$upload_data['image_width'],$upload_data['image_height']);					
					$thumb_config['width']  = $size['newWidth'];
					$thumb_config['height'] = $size['newHeight'];					
					$thumb_config['new_image'] = $config['upload_path'];
					$thumb_config['overwrite'] = TRUE;
					$this->CI->image_lib->initialize($thumb_config);		
													
					if (!$this->CI->image_lib->resize()){
						$return = array(
							'status' => 300,//loi o anh thumb
							'msg'    => $this->CI->upload->display_errors(),
							'src'    => $upload_data['file_name']
						);
					}
				}
				//# Giảm kích thước ảnh gốc
				
			}//if cua lenh up
			$return = array(
									'status' => 200,
									'msg'    => "Up ảnh hoàn thành",
									'src'    => $upload_data['file_name']
									);
			return $return;
		}else{
			$return = array(
									'status' => 404,//ko co hinh
									'msg'    => "Chưa chọn hình",
									'src'	 => ""
									);
			return $return;
		}
	}	
	function create_htaccess($path){
		$this->CI->load->helper('file');
		$htaccess = '<Files ~ "^.*\.(php|cgi|pl|php3|php4|php5|php6|phtml|shtml|tpl|txt)"> 
						order allow,deny 
						deny from all 
					 </Files>';
		$index    = '';
		write_file($path.'/.htaccess', $htaccess);
		write_file($path.'/index.html', $index);
	}	
	function create_foder($path,$thumb = true){
		$r = array();
		if($thumb){
			$r['upload_thumb_path'] = $path."/thumb";
			$r['upload_min_path']   = $path."/min";
		}
		if (!file_exists($path) && !empty($path)) {			
			mkdir($path);	
			if($thumb){
				mkdir($r['upload_thumb_path']);
				mkdir($r['upload_min_path']);	
			}
			chmod($path, 0777); 
			if($thumb){
				chmod($r['upload_thumb_path'], 0777); 
				chmod($r['upload_min_path'], 0777); 
			}	
			$this->create_htaccess($path);	
			if($thumb){
				$this->create_htaccess($r['upload_thumb_path']);
				$this->create_htaccess($r['upload_min_path']);
			}
		}
		return $r;
	}	
	function check_file_exists($file_name,$file_path){
		$_file_name = @pathinfo($file_name);
		$_file_name	 = $this->slug($_file_name["filename"]);
		$url = @getimagesize($file_path."/".$_file_name);
		
		while (is_array($url)){
			$_file_name	= time()."_".$file_name;
			$url = getimagesize($file_path."/".$_file_name);
		}
		return $_file_name;
	}	
	//# UPLOAD HÌNH ẢNH	
	//UPlOAD HÌNH ẢNH QUA URL
	function upload_url($url,$config){
		
		$this->CI->load->library('image_lib');
		$info = @pathinfo($url);
		
		if(is_array($info)){
			$dir  = $config['dir']."/".$info["basename"];
			$create_foder = $this->create_foder($config['dir']);			
			$size = file_put_contents($config['dir']."/".$info["basename"], file_get_contents($url));
			if(!$size) return FALSE;
		
			$imagesize = getimagesize($url); 
			
			$config['image_library'] = 'gd2';
			$config['source_image'] = $dir;
			$config['create_thumb'] = FALSE;
			$config['maintain_ratio'] = TRUE;
			$config['master_dim'] = "width";
			
			if($imagesize[0] > $config['width']){			
				$config['new_image'] = $config['dir'];
				$config['width']     = $config["width"];
				$config['height']    = $config["height"];
				$this->CI->image_lib->clear();
				$this->CI->image_lib->initialize($config);
				$this->CI->image_lib->resize();
			}
			if($config['thumb']){
				$config['new_image'] = $config['dir']."/thumb";
				$config['width']     = $config["width_thumb"];
				$config['height']    = $config["height_thumb"];
				$this->CI->image_lib->clear();
				$this->CI->image_lib->initialize($config);
				$this->CI->image_lib->resize();

				if($config['width_min'] > 0){
					$config['new_image'] = $config['dir']."/min";
					$config['width']     = $config["width_min"];
					$config['height']    = $config["height_min"];
					$this->CI->image_lib->clear();
					$this->CI->image_lib->initialize($config);
					$this->CI->image_lib->resize();
				}
			}			
			return $info["basename"];
		}else{
			return FALSE;
		}
	}	
	function get_extension($imagetype)
	{
       if(empty($imagetype)) return false;
       switch($imagetype)
       {
           case 'image/bmp': return '.bmp';
           case 'image/cis-cod': return '.cod';
           case 'image/gif': return '.gif';
           case 'image/ief': return '.ief';
           case 'image/jpeg': return '.jpg';
           case 'image/pipeg': return '.jfif';
           case 'image/tiff': return '.tif';
           case 'image/x-cmu-raster': return '.ras';
           case 'image/x-cmx': return '.cmx';
           case 'image/x-icon': return '.ico';
           case 'image/x-portable-anymap': return '.pnm';
           case 'image/x-portable-bitmap': return '.pbm';
           case 'image/x-portable-graymap': return '.pgm';
           case 'image/x-portable-pixmap': return '.ppm';
           case 'image/x-rgb': return '.rgb';
           case 'image/x-xbitmap': return '.xbm';
           case 'image/x-xpixmap': return '.xpm';
           case 'image/x-xwindowdump': return '.xwd';
           case 'image/png': return '.png';
           case 'image/x-jps': return '.jps';
           case 'image/x-freehand': return '.fh';
           default: return false;
       }
	}
	//UPlOAD HÌNH ẢNH QUA URL
	
	function geturlimg($img,$folder = NULL,$adn = NULL,$one = false){
		$image = json_decode($img);
		if($folder == NULL){
			$folder = "";
		}else{
			$folder = $folder.'/';
		}
		
		if($adn == NULL) $adn = base_url();
		
		if(is_array($image)){			
			foreach($image as $key => $row){
				if (filter_var($row, FILTER_VALIDATE_URL)) { 
					$json[$key] = $row;
				}else{
					$json[$key] = $adn."upload/".$folder.$row;
				}
				if($one){
					return $json[0];
				}	
			}
			return $json;
		}else{
			return $adn."upload/".$folder.$img;
		}
	}
	
	function removeImg($img,$folder = NULL){//xóa hình từ server
		$image = json_decode($img);
		if($folder == NULL){
			$folder = "";
		}else{
			$folder = $folder.'/';
		}		
		if(is_array($image)){			
			foreach($image as $key => $row){
				if (!filter_var($row, FILTER_VALIDATE_URL)) { //kiểm tra là url hay là file					
					@unlink($folder.$row);
				}					
			}
			return true;
		}else{
			@unlink($folder.$img);
			return true;
		}
		return false;
	}

	function delFolder($str) {
	    if (is_file($str)) {
	        return unlink($str);
	    }
	    elseif (is_dir($str)) {
	        $scan = glob(rtrim($str,'/').'/*');
	        foreach($scan as $index=>$path) {
	            deleteAll($path);
	        }
	        return @rmdir($str);
	    }
	}
	
	function getImageInContent($post_content, $delete = false) {	
		$src_sv = array();
		$src = array();
		preg_match('/(src=["\'](.*?)["\'])/', $post_content, $match);  //find src="X" or src='X'
		foreach ($match as $key => $value) {			
			$split = preg_split('/["\']/', $value);	
			if(count($split) == 3)
				$src[] = $split[1];
			else
				$src[] = $value;
		}
		if(count($src) > 0){
			//lọc những link lưu chữ trên sv
			foreach ($src as $key => $value) {
				if(strpos($value,base_url()) != false){
					$src_sv[] = $value;
				}
			}
			if($delete == true && count($src_sv) > 0){
				foreach ($src_sv as $key => $value) {
					$supported_format = array('gif','jpg','jpeg','png');
					$ext = strtolower(pathinfo($value, PATHINFO_EXTENSION));
					if (in_array($ext, $supported_format)){
						$url_del = str_replace(base_url(), "",$value);
						@unlink($url_del);
					}
				}
			}
		}
		
		return $src_sv;
	}

	function removeLink($str){
		$regex = '/<a (.*)<\/a>/isU';
		preg_match_all($regex,$str,$result);
		foreach($result[0] as $rs)
		{
			$regex = '/<a (.*)>(.*)<\/a>/isU';
			$text = preg_replace($regex,'$2',$rs);
			$str = str_replace($rs,$text,$str);
		}
		return $str;
	}
	
	//tính tỉ lệ crop ảnh
	function calcWidth($width,$height,$maxWidth,$maxHeight) {
        $newWp = (100 * $maxWidth) / $width;
        $newHeight = ($height * $newWp) / 100;
		if($width > $maxWidth)
			return array('newWidth'=>intval($maxWidth),'newHeight'=>intval($newHeight));
		else
        	return array('newWidth'=>intval($width),'newHeight'=>intval($newHeight));
    }
    //@return array
    function calcHeight($width,$height,$maxWidth,$maxHeight) {
        $newHp = (100 * $maxHeight) / $height;
        $newWidth = ($width * $newHp) / 100;
		if($height > $maxHeight)
			return array('newWidth'=>intval($newWidth),'newHeight'=>intval($maxHeight));
		else
        	return array('newWidth'=>intval($newWidth),'newHeight'=>intval($height));
    }
	
	function calcImageSize($width,$height,$maxWidth,$maxHeight){
		$return = array('newWidth'=>$width,'newHeight'=>$height,'status'=>false); 
		$newSize = array('newWidth'=>$width,'newHeight'=>$height);
		if($maxWidth > 0 && $newSize['newWidth'] > $maxWidth) {
            $newSize = $this->calcWidth($width,$height,$maxWidth,$maxHeight);
            if($maxHeight > 0 && $newSize['newHeight'] < $maxHeight) {
                $newSize = $this->calcHeight($width,$height,$maxWidth,$maxHeight);
            }
			$return = array('newWidth'=>$newSize['newWidth'],'newHeight'=>$newSize['newHeight'],'status'=>true); 
        }
		return $return;
	}
	//#tính tỉ lệ crop ảnh
	function createSKU($name_traking = null,$name_product = null,$attrib = ""){		
		$chars = array(
			'a'=>array('ấ','ầ','ẩ','ẫ','ậ','Ấ','Ầ','Ẩ','Ẫ','Ậ','ắ','ằ','ẳ','ẵ','ặ','Ắ','Ằ','Ẳ','Ẵ','Ặ','á','à','ả','ã','ạ','â','ă','Á','À','Ả','Ã','Ạ','Â','Ă'),
			'e' =>array('ế','ề','ể','ễ','ệ','Ế','Ề','Ể','Ễ','Ệ','é','è','ẻ','ẽ','ẹ','ê','É','È','Ẻ','Ẽ','Ẹ','Ê'),
			'i'=>array('í','ì','ỉ','ĩ','ị','Í','Ì','Ỉ','Ĩ','Ị'),
			'o'=>array('ố','ồ','ổ','ỗ','ộ','Ố','Ồ','Ổ','Ô','Ộ','ớ','ờ','ở','ỡ','ợ','Ớ','Ờ','Ở','Ỡ','Ợ','ó','ò','ỏ','õ','ọ','ô','ơ','Ó','Ò','Ỏ','Õ','Ọ','Ô','Ơ'),
			'u'=>array('ứ','ừ','ử','ữ','ự','Ứ','Ừ','Ử','Ữ','Ự','ú','ù','ủ','ũ','ụ','ư','Ú','Ù','Ủ','Ũ','Ụ','Ư'),
			'y'=>array('ý','ỳ','ỷ','ỹ','ỵ','Ý','Ỳ','Ỷ','Ỹ','Ỵ'),
			'd'=>array('đ','Đ'),
		);

		if($name_traking != null && $name_traking != "0"){
			$this->CI->load->model("Products_trademark_model");	
		
			$trademark = $this->CI->Products_trademark_model->get($name_traking);	
			if(empty($trademark)){
				$trademark = $this->CI->Products_catalogs_model->get($name_traking);	
			}
			foreach ($chars as $key => $arr) 
				foreach ($arr as $val)
					$trademark->title = str_replace($val,$key,$trademark->title);
		}
		
		
		foreach ($chars as $key => $arr) 
			foreach ($arr as $val)
				$name_product = str_replace($val,$key,$name_product);

		if($attrib != null){
			foreach ($chars as $key => $arr) 
				foreach ($arr as $val)
					$attrib = str_replace($val,$key,$attrib);
		}

		
		if($name_traking != null){		
			if(empty($attrib))
				$suk = mb_substr($trademark->title,0,4).date("y").date("s").mb_substr($name_product,0,8);
			else
				$suk = mb_substr($trademark->title,0,4).date("y").date("s").mb_substr($name_product,0,8)."-".$attrib;
		}else{
			$suk = $name_product."-".$attrib;
		}
		
		return strtoupper(preg_replace('/\s+/', '', $suk));
		
	}
	function createCodeProduct(){
		return md5("ru".time().rand());
	}	
}