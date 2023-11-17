<?php (defined('BASEPATH')) OR exit('No direct script access allowed');

class MY_Pagination extends CI_Pagination{
  protected $CI;
  protected $params = array();
  public function __construct()
  {
    parent::__construct();    
    $this->CI =& get_instance();     
    
    $this->params['page_query_string'] = FALSE;    
    $this->params['use_page_numbers'] = TRUE;
    $this->params['reuse_query_string'] = TRUE;

    $this->params['uri_segment'] = 2;
    $this->params['base_url'] = current_url();
  }
  public function bootstrap()
  {
      $this->params['full_tag_open'] = '<ul class="pagination">';
      $this->params['full_tag_close'] = '</ul>';
      $this->params['attributes'] = ['class' => 'page-link'];
      $this->params['first_link'] = false;
      $this->params['last_link'] = false;
      $this->params['first_tag_open'] = '<li class="page-item">';
      $this->params['first_tag_close'] = '</li>';
      $this->params['prev_link'] = '&laquo';
      $this->params['prev_tag_open'] = '<li class="page-item">';
      $this->params['prev_tag_close'] = '</li>';
      $this->params['next_link'] = '&raquo';
      $this->params['next_tag_open'] = '<li class="page-item">';
      $this->params['next_tag_close'] = '</li>';
      $this->params['last_tag_open'] = '<li class="page-item">';
      $this->params['last_tag_close'] = '</li>';
      $this->params['cur_tag_open'] = '<li class="page-item active"><a href="#" class="page-link">';
      $this->params['cur_tag_close'] = '<span class="sr-only"></span></a></li>';
      $this->params['num_tag_open'] = '<li class="page-item">';
      $this->params['num_tag_close'] = '</li>';
      $this->params['attributes'] = array('class' => 'page-link');
  }
  public function offset($config){
    foreach ($config as $key => $value) {
      $this->params[$key] = $value;
    }  
    if(isset($this->params['base_url'])){
      $this->params['base_url'] = base_url().$this->CI->uri->segment(1); 
    }
    $offset = 1;
    if($this->params['page_query_string']){
      if($this->CI->input->get("per_page"))
        $offset = $this->CI->input->get("per_page");  
      else
        $offset = 0;

      $this->params['base_url'] = current_url();  
    }else{
      $this->params['prefix'] = 'page-';
      $this->params['suffix'] = '.html';
      try {      
        $this->params['base_url'] = base_url().$this->CI->uri->segment($this->params['uri_segment'] - 1); 
        if ($this->CI->uri->segment($this->params['uri_segment'])) {                       
          $per_page = $this->CI->uri->segment($this->params['uri_segment']);

          $per_page = explode('.', $per_page);
          $per_page = $per_page[0];

          $per_page = explode('-', $per_page);
          
          $offset = ((int)$per_page[1] - 1) * $this->params['per_page'];   
        }else{
          $offset = 0;
        }            
      } catch (Exception $e) {
        $offset = 0;
      }
    }
    return $offset;
  }
  public function create(){   
    $this->initialize($this->params);
    return $this->create_links();

  }
}