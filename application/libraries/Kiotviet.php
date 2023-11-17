<?php

if (!defined('BASEPATH')) exit('No direct script access allowed');

class Kiotviet {
	protected $CI;
	protected $url;// URL of the session

	protected $client_id = "87ee56db-6b57-4446-ad74-e4392105cb39";
	protected $client_secret = "CBE475A85A96F3C0B0FBBA1456AECE9FB881B837";

	protected $retailer;//user tài khoản kiotviet
	protected $authToken;
	protected $branchId;//id chi nhánh
	protected $soldById;//id quản trị viên

	public $error_string;

	function __construct(){
		$this->CI =& get_instance();//đưa về root
		$this->retailer = 'tetviet';//user tài khoản kiotviet		
		$this->branchId = 10087;//id chi nhánh -> lấy qua api thông tin đại lý
		$this->soldById = 198183;//id quản trị viên -> lấy trong bảng user
		$this->getToken();
	}
	function getToken(){		
		$postData = array(
			"client_id"=>$this->client_id,
			"client_secret"=>$this->client_secret,
			"grant_type"=>"client_credentials",
			"scopes"=>"PublicApi.Access"
		);
		$ch = curl_init("https://id.kiotviet.vn/connect/token");
		curl_setopt_array($ch, array(
				CURLOPT_POST => TRUE,
				CURLOPT_RETURNTRANSFER => TRUE,
				CURLOPT_HTTPHEADER => array(
				        'Retailer: '.$this->retailer,
				        'Authorization: '.$this->authToken
				),
				CURLOPT_POSTFIELDS => http_build_query($postData)
		));
		curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
		$response = curl_exec($ch);

		if($response === FALSE){
		    $this->error_string = curl_error($ch);
		    $this->authToken = null;
		}else{
			$response = json_decode($response);	
			@$this->authToken = "Bearer ".$response->access_token;
		}
	}
	/*
		$customer obj
		$orderDetails obj (nhiều sản phẩm thì mảng obj)
		$orderDelivery obj
	*/
	function ordersAdd($customer,$orderDetails,$orderDelivery,$description = "",$discount = 0, $discountRatio = 0,$totalPayment = 0){
		$this->url = "https://public.kiotapi.com/orders";
		$postData = new stdClass();
		$postData->branchId = $this->branchId;
		$postData->soldById = $this->soldById;
		$postData->method = "";
		$postData->description = $description;
		$postData->discount = $discount;
   		$postData->discountRatio = $discountRatio;
		$postData->totalPayment = $totalPayment;
		$postData->makeInvoice = false;
		$postData->orderDetails = $orderDetails;
		$postData->orderDelivery = $orderDelivery;
		$postData->customer = $customer;	
		$postData = json_encode($postData);		

		$call = $this->execute($postData);
		
		if(strpos($call,"errorCode") !== false){
			$erro = json_decode($call);
			$this->error_string = $erro->responseStatus->message;
			return false;
		}
		return json_decode($call);
	}
	public function execute($postData){
		$ch = curl_init($this->url);
		if(is_array($postData)){
			curl_setopt_array($ch, array(
				CURLOPT_POST => TRUE,
				CURLOPT_RETURNTRANSFER => TRUE,
				CURLOPT_HTTPHEADER => array(
				        'Retailer: '.$this->retailer,
				        'Authorization: '.$this->authToken
				),
				CURLOPT_POSTFIELDS => $postData
			));
		}else{
			curl_setopt_array($ch, array(
				CURLOPT_POST => TRUE,
				CURLOPT_RETURNTRANSFER => TRUE,
				CURLOPT_HTTPHEADER => array(
				        'Retailer: '.$this->retailer,
				        'Authorization: '.$this->authToken,
				        'Content-Type: application/json'
				),
				CURLOPT_POSTFIELDS => $postData
			));
		}
		
		curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
		$response = curl_exec($ch);

		if($response === FALSE){
		    $this->error_string = curl_error($ch);
		    return FALSE;
		}
		return $response;
	}
}

?>