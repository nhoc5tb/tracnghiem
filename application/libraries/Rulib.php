<?php

if (!defined('BASEPATH')) exit('No direct script access allowed');

class Rulib {

	private $CI;

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
	
	function body_text($text){
		$tim = $this->CI->config->item('rcodein');
		$thay = $this->CI->config->item('rcodeout');
		$text = str_replace($tim,$thay, html_entity_decode($text));
		return $text;
	}

	function showPrice($price,$sale){
		$price = $this->locKyTuTrongSDT($price);
		$sale = $this->locKyTuTrongSDT($sale);
		if(empty($sale))
			return $price;
		else{
			if($sale < $price)
				return $sale;
			else
				return $price;
		}	
	}
	
	function locKyTuTrongSDT($str){		

		if(!$str) return false;
			$marTViet=array("."," ",",","-"
			);
			

			$marKoDau=array(			
							'','','',''
			);

			$str = str_replace($marTViet,$marKoDau,$str);
		return $str;

	}

	function send_mail($mail,$attach = null){		
		
		$this->CI->load->library('email');
		$this->CI->load->model('config_model');	
		$data = $this->CI->config_model->getconfig();
		
		$config['protocol']    = 'smtp';
		$config['smtp_host']    = $data->mail_host;
		$config['smtp_port']    = $data->mail_port;
		$config['smtp_timeout'] = '7';
		$config['smtp_user']    = $data->mail_user;
		$config['smtp_pass']    = $data->mail_pass;
		$config['charset']    = 'utf-8';
		$config['newline']    = "\r\n";
		$config['mailtype'] = 'html';
		$config['validation'] = TRUE;    

		$this->CI->email->initialize($config);

    	$this->CI->email->from($data->mail_user, $data->mail_name);
		$this->CI->email->to( $mail['to'] ); //mail nhận thư			
		if($mail['bcc'] != false)
			$this->CI->email->bcc( $mail['bcc'] );
		$this->CI->email->subject( $mail['subject'] );
		$this->CI->email->message( $mail['message'] );		
		if(!empty($attach)){
			if(is_array($attach)){
				foreach($attach as $row)
					$this->CI->email->attach($row);
			}else{
				$this->CI->email->attach($attach);

			}
		}
    	$status = $this->CI->email->send();

    	$debugger = $this->CI->email->print_debugger();
		
		return array($status,$debugger);

	}
	
	function currency($amount = 1,$from = 'VND',$to = 'USD'){

		$url = "http://www.xe.com/currencyconverter/convert/?Amount=".$amount."&From=".$from."&To=".$to;
	
		$ch = curl_init(); // Initialize a CURL session.
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1); // Return Page contents.
		curl_setopt($ch, CURLOPT_URL, $url); // Pass URL as parameter.
	
		$data = curl_exec($ch); // grab URL and pass it to the variable.
		curl_close($ch); // close curl resource, and free up system resources.
	
	
		$dom = new DOMDocument();
		@$dom->loadHTML($data);	
		$xpath = new DOMXPath($dom);	
		$tableRows = $xpath->query('//table//tr');	
		$details = array();
	
		foreach ($tableRows as $row) {
				// fetch all 'tds' inside this 'tr'
				$td = $xpath->query('td', $row);	
				if ($td->length == 3  ):	
					foreach($td as $key => $val){
						if($key==0 Or $key ==2) {
							$details[] = preg_replace('/[^0-9, \'\.:]*/i', '',$val->nodeValue);
						}
					}
				endif;
		}
		
		return $details;
	}
	function geturlimg($img,$folder = NULL,$adn = NULL,$get = "full",$cancel = false){	
		$image = json_decode($img);		
		$fname = $folder["id"];
		if($folder == NULL){
			$folder = "";
		}else{
			$folder = $folder["dirweb"].'/';
		}
		
		if($adn == NULL) $adn = base_url();
		
		if(is_array($image)){			
			foreach($image as $key => $row){
				if (filter_var($row, FILTER_VALIDATE_URL)) { 
					$json[$key] = $row;
				}else{
					if ($cancel) {
						$json[$key] = $adn."upload/".$folder.$row;
					}else{
						$json[$key] = $adn."upload/".$folder.$row."?size=".$get."&fname=".$fname;
					}
					
				}
					
			}
			return $json;
		}else{

			if (empty($img)) {
				return $adn."upload/no-image.png";
			}else{
				if ($cancel) {
					return $adn."upload/".$folder.$img;
				}else{
					return $adn."upload/".$folder.$img."?size=".$get."&fname=".$fname;
				}
				
			}
		}
	}
	
	function coverNameFile($str){	
		if(!$str) return false;
			$marTViet=array(
			"/","\\",".",",","+"
			);
			$marKoDau=array(
			"_","_","_","_","_"		
			);
			$str = str_replace($marTViet,$marKoDau,$str);
			$str = strtolower($str);
		return $str;
	}
		
	function randomPassword($number = 8) {

		$alphabet = "abcdefghijklmnopqrstuwxyzABCDEFGHIJKLMNOPQRSTUWXYZ0123456789";

		$pass = array(); 

		$alphaLength = strlen($alphabet) - 1; 

		for ($i = 0; $i < $number; $i++) {

			$n = rand(0, $alphaLength);

			$pass[] = $alphabet[$n];

		}

		return implode($pass);
	}
	
	function messenger($string,$type = "key") {

		$this->CI->load->model("Messenger_model");
		
		if($type == "key"){
			$check = $this->CI->Messenger_model->get_one_by(array("key"=>$string));	
			if(!empty($check)){
				return $check->value;
			}else{
				$this->CI->Messenger_model->insert(array("key"=>$string,"value"=>$string));
				return $string;
			}
		}			
	}
	/*
	$base_url : đường dẫn
	$tree : tạo đường dẫn kế thừa từ đường dẫn cha
	$table : bảng sử dụng
	$slug : giá trị tìm kiếm
	$post : breadcrumb có phải là bài viết
	$catalogs_post_table : bảng danh mục của bài viết nếu $post = TRUE
	*/
	function breadcrumb($base_url,$tree = TRUE, $table = "",$slug = "",$post = FALSE, $catalogs_post_table = "", $tree_post = TRUE){
		$this->CI->load->model($table);
		$breadcrumb[] = new stdClass();	

		$breadcrumb[0]->title = $this->messenger("Trang Chủ");
		$breadcrumb[0]->url = $base_url;

		if($post == FALSE){
			$breadcrumb_catalogs = $this->breadcrumb_catalogs($base_url, $tree, $table, $slug);			
			$breadcrumb = array_merge($breadcrumb,$breadcrumb_catalogs);
		}else{
			$breadcrumb_post = $this->breadcrumb_post($slug, $table, $catalogs_post_table);		
			$breadcrumb_catalogs = $this->breadcrumb_catalogs($base_url, $tree, $catalogs_post_table, $breadcrumb_post["catalogs"]);	
			$breadcrumb = array_merge($breadcrumb,$breadcrumb_catalogs);
			$post_add[0] = new stdClass();
			if (!$tree_post) {
				$post_add[0]->title = $breadcrumb_post["post"]->title;
				$post_add[0]->url = $base_url.$breadcrumb_post["post"]->url;				
			}else{	
				$post_add[0]->title = $breadcrumb_post["post"]->title;
				$post_add[0]->url = $breadcrumb[count($breadcrumb) - 1]->url."/".$breadcrumb_post["post"]->url;				
			}
			$breadcrumb = array_merge($breadcrumb,$post_add);				
		}
		return $breadcrumb;
	}
	function breadcrumb_catalogs($base_url, $tree = TRUE, $table = "", $slug = ""){
		$index = 0;
		$catalogs = $this->CI->$table->get_one_by(array("slug"=>$slug));				

		if($catalogs->parent_id > 0){
			$parent = array();
			$parent[$index] = new stdClass();	
			$parent[$index]->title = $catalogs->title;
			$parent[$index]->url = $catalogs->slug;
			$index++;
			while ($catalogs->parent_id > 0) {
				$catalogs = $this->CI->$table->get($catalogs->parent_id);	
				$parent[$index] = new stdClass();	
				$parent[$index]->title = $catalogs->title;
				$parent[$index]->url = $catalogs->slug;
				$index++;			
			}
			$parent = array_reverse($parent);
			foreach ($parent as $key => $value) {
				if ($tree) {	
					if($key > 0){						
						$value->url = $base_url.$parent[$key-1]->url."/".$value->url;						
					}else{
						$value->url = $base_url.$breadcrumb[0]->url.$value->url;
					}
				}	
				$breadcrumb[] = $value;
			}
		}else{			
			$breadcrumb[1] = new stdClass();		
			$breadcrumb[1]->title = $catalogs->title;
			$breadcrumb[1]->url = $base_url.$catalogs->slug;
		}
		return $breadcrumb;
	}
	function breadcrumb_post($slug,$table, $catalogs_post_table = ""){
		$post = $this->CI->$table->get($slug);
		$data = array();
		if ($post) {
			$catalogs = $this->CI->$catalogs_post_table->get($post->catalogs);
			$data["catalogs"] = $catalogs->slug;			
			$data["post"] = new stdClass();
			$data["post"]->title = $post->title;
			$data["post"]->url = $post->slug.".html";
		}
		return $data;
	}
	/*#breadcrumb*/

	/*
	| Số file nhúng để sử dung 
	| + application\core\MY_Model.php : dòng số 9 đến 49
	| + application\core\MY_Widget.php nguyên file
	| + application\widgets
	| + application\views\widgets
	*/
	function position($_position){		
		$return = null;		
		$this->CI->load->model('block_model'); 		
		$wget = $this->CI->block_model->get_by(array('status'=>1,'position'=>$_position));
		foreach($wget as $row){				
			$content = $this->CI->load->widget($row->module,array("params"=>$row->params));			
			if(!empty($content)){
				$return .= $content;
			}
		}		
		return $return;
	}
	function createName($sex = "nu"){
		$nu_ho = array("Nguyễn","Nguyễn","Nguyễn","Nguyễn","Trần","Trần","Lê","Phạm","Hoàng","Huỳnh","Phan","Vũ","Võ","Đặng","Bùi","Lý");
		$nu_tendem = array("Thị","Thu","Lan","Ngọc","Bích","Lệ","Huyền");
		$nu_ten = array("Kim","Hoa","Uyên","Hương","Bích","Chi","Ðào","Diễm","Diệp","Dung","Hà","Hạnh","Hiền","Hương","Huệ","Lan","Huyền","Loan","Liên","Nga","Phương","Phượng","Trà","Trang","Thanh","Yến");
		$name = "";
		if (rand(0,1)) {
			if($sex == "nu"){
				$name = $nu_ho[array_rand($nu_ho)]." ".$nu_tendem[array_rand($nu_tendem)]." ".$nu_ten[array_rand($nu_ten)];
			}
		}else{
			if($sex == "nu"){
				$name = $nu_ho[array_rand($nu_ho)]." ".$nu_ten[array_rand($nu_ten)];
			}
		}
		return $name;
	}

	function getPrice($code_product,$price_send = 0){
		$tiente = " $";
		$price = new stdClass();
		$this->CI->load->model('Products_model'); 
		$this->CI->load->model('Products_sale_model'); 		
		$product = $this->CI->Products_model->get_one_by(array("code_product"=>$code_product));
		$product_sale = $this->CI->Products_sale_model->get_one_by(array("id_product"=>$product->id,"status"=>1));
		if($price_send > 0){
			$product->price = $price_send;
		}
		if($product_sale){
			$sale = (int)$product->price - (((int)$product->price/100)*(int)$product_sale->value);
			$price->root_sale = (int)$sale;
			$price->root_cost = (int)$product->price;
			
			$price->sale = number_format($sale, 0, ',', '.') ." ".$tiente;
			$price->cost = number_format((int)$product->price, 0, ',', '.') ." ".$tiente;
		}else{
			$price->root_sale = 0;
			$price->root_cost = $product->price;

			$price->sale = 0;
			$price->cost = number_format((int)$product->price, 0, ',', '.') ." ".$tiente;
		}
		return $price;
	}
	
	public function trim_special_char($text)
    {
        $str = str_replace("(", '_p', $text);
        $str = str_replace(")", 'p_', $str);
        $str = str_replace("/", '_slash', $str);
        $str = str_replace("+", '_plus', $str);
        $str = str_replace("&", '_and', $str);
        $str = str_replace("'", '_ss', $str);
        $str = str_replace("x", '_X', $str);
        $str = str_replace('"', '_cot', $str);
        $str = str_replace('®', '_r', $str);
        $str = str_replace('–', '_a', $str);
        $str = str_replace('-', '_b', $str);
        $str = str_replace('.', '_axb', $str);
        $str = str_replace(',', '_cxb', $str);
        return $str;
    }

    // Set special character from previous text
    public function set_special_char($text)
    {
        $str = str_replace('_p',  "(", $text);
        $str = str_replace('p_', ")", $str);
        $str = str_replace('_slash', "/", $str);
        $str = str_replace('_plus', "+", $str);
        $str = str_replace('_and', "&", $str);
        $str = str_replace('_ss', "'", $str);
        $str = str_replace('_X', "x", $str);
        $str = str_replace('_cot', '"', $str);
        $str = str_replace('_r', '®', $str);
        $str = str_replace('_a', '–', $str);
        $str = str_replace('_b', '-', $str);
        $str = str_replace('_axb', '.', $str);
        $str = str_replace('_cxb', ',', $str);
        return $str;
    }

    function base64url_encode($data) { 
		return rtrim(strtr(base64_encode($data), '+/', '-_'), '='); 
	} 

	function base64url_decode($data) { 
	  return base64_decode(str_pad(strtr($data, '-_', '+/'), strlen($data) % 4, '=', STR_PAD_RIGHT)); 
	} 

	function curl($url){
	    $ch = curl_init ($url);
	    curl_setopt($ch, CURLOPT_HEADER, 0);
	    curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
	    curl_setopt($ch, CURLOPT_BINARYTRANSFER,1);
	    curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, 0);
		curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 0);
		curl_setopt($ch, CURLOPT_USERAGENT,'Mozilla/5.0 (Windows NT 10.0; WOW64; rv:45.0) Gecko/20100101 Firefox/45.0');
		$result = parse_url($url);
	    curl_setopt($ch, CURLOPT_REFERER, $url);
	    $raw=curl_exec($ch);
	    curl_close ($ch);	   
	}
}

?>