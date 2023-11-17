<?php

class Question_model extends MY_Model {
  
	protected $table = "question";
	protected $answer = "answer_model";
	protected $primary_key = "id";

	public function __construct(){
		parent::__construct();
	}
	public function getRandom(){
		$sql = "SELECT * FROM question WHERE check1 != 1 AND check2 != 1 ORDER BY RAND() LIMIT 100;";		
		$query = $this->db->query($sql);;
		$result = $query->result();
		return $result;
	}
}