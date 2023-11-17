<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Home extends Home_Controller {
  
	var $data = array();
  
	public function __construct(){
		parent::__construct();	
		$this->data["class"] = __CLASS__;
		$this->load->model('Answer_model');
		$this->load->model('Question_model');
		$this->load->library('form_validation');
	}
	public function index(){ 
		$question = $this->Question_model->get();
		
		$this->data["getcsdl"] = array();
		foreach ($question as $key => $value) {
			$temp = $question[$key];
			$answer = $this->Answer_model->get_by(array("id_question"=>$value->id));
			$temp->answer = $answer;
			$this->data["getcsdl"][] = $temp;
		}
		$this->layout->view(strtolower($this->data['interface'].'/'.__CLASS__.'/'.__FUNCTION__),$this->data);
	}
	public function tracnghiem(){ 
		$question = $this->Question_model->getRandom();
		$this->data["getcsdl"] = array();
		foreach ($question as $key => $value) {
			$temp = $question[$key];
			$answer = $this->Answer_model->get_by(array("id_question"=>$value->id));
			$temp->answer = $answer;
			$this->data["getcsdl"][] = $temp;
		}
		$this->layout->view(strtolower($this->data['interface'].'/'.__CLASS__.'/'.__FUNCTION__),$this->data);
	}
	
	public function napdiem(){
		$json = array("message"=>"Lỗi..","status"=>500,"error"=>1);

		$this->form_validation->set_rules('point', 'Điểm','trim|required');
		if($this->form_validation->run() == TRUE){		
			$idAnswer = explode(',', set_value("point"));
			foreach ($idAnswer as $key => $value) {
				$question = $this->Question_model->get($value);
				if($question->check1 == 0){
					$this->Question_model->update($value,array("check1"=>1));
				}else{
					$this->Question_model->update($value,array("check2"=>1));
				}
			}
			$json = array("message"=>"Hoàn Thành ..","status"=>200,"error"=>0);
		}

		$this->output->set_content_type('application/json')->set_output(json_encode($json));
	}
	public function clear(){
		$json = array("message"=>"Lỗi..","status"=>500,"error"=>1);

		$this->form_validation->set_rules('clear', 'Làm sạch','trim|required');
		if($this->form_validation->run() == TRUE){		
			$this->Question_model->update_by(array("id >"=>0),array("check1"=>0,"check2"=>0));
			$json = array("message"=>"Hoàn Thành ..","status"=>200,"error"=>0);
		}

		$this->output->set_content_type('application/json')->set_output(json_encode($json));
	}
	public function napcauhoi(){ 	
		/*
		$filePath = 'cauvs.txt';
		$fileContentArray = file($filePath, FILE_IGNORE_NEW_LINES);
		if ($fileContentArray !== false) {		
			$chunkedArrays = array_chunk($fileContentArray, 5);	
			foreach ($chunkedArrays as $line) {
				$question_text = array_shift($line);
				$question = array(
							"question"=>$question_text,
							"check1"=>0,
							"check2"=>0,
				);
				$id = $this->Question_model->insert($question);
				foreach ($line as $_key => $_value) {
					$answer = array(
						"id_question"=>$id,
						"answer"=>$_value,
						"correct"=>0
					);
					$this->Answer_model->insert($answer);
				}
			}
		} else {
			echo "Không thể đọc tệp tin!";
		}
		
		$this->layout->view(strtolower($this->data['interface'].'/'.__CLASS__.'/'.__FUNCTION__),$this->data);
		*/
	}	
	public function napcautraloi(){ 	
	/*
		$filePath = 'cauvs-traloi.txt';
		$fileContentArray = file($filePath, FILE_IGNORE_NEW_LINES);
		if ($fileContentArray !== false) {	
			foreach ($fileContentArray as $line) {				
				$tach = explode('-', $line);
				$answer_data = $this->Answer_model->get_by(array("id_question"=>$tach[0]));
				foreach ($answer_data as $key => $value) {
					if($value->answer[0] == $tach[1]){
						$this->Answer_model->update($value->id,array("correct"=>1));
						break;
					}
				}
				
			}
		} else {
			echo "Không thể đọc tệp tin!";
		}
	
		$this->layout->view(strtolower($this->data['interface'].'/'.__CLASS__.'/'.__FUNCTION__),$this->data);
		*/
	}	
	public function error_404(){       			
		$this->layout->view(strtolower($this->data['interface'].'/'.__CLASS__.'/'.__FUNCTION__),$this->data);
	}
	
}
