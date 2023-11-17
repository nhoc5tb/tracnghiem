<?php

class Answer_model extends MY_Model {
  
	protected $table = "answer";
	protected $primary_key = "id";
  
	public function __construct(){
		parent::__construct();
	}
}