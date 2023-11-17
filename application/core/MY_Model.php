<?php (defined('BASEPATH')) OR exit('No direct script access allowed');

class MY_Model extends CI_Model{

  protected $table;
  protected $primary_key = 'id';
  
  public function __construct()
  {
    parent::__construct();
    if ($this->table == NULL)
    {
      $this->table = plural(preg_replace('/(_model)?$/', '', strtolower(get_class($this))));
    }
  }
  
  /*
   * --------------------------------------------------------------
   * CRUD INTERFACE
   * --------------------------------------------------------------
   */
   
  /**
   * Fetch a/many record(s) based on primary_value(s)
   * 
   * @param int $primary_value
   * @return object/array $record
   */
  public function get($primary_value = NULL)
  {
    if (is_null($primary_value)){
      $query = $this->db->get($this->table);
      return $query->result();
    } else {
      if (is_array($primary_value)) {
        $this->db->where_in($this->primary_key, $primary_value);
        $query = $this->db->get($this->table);
        return $query->result();
      } else {
        $this->db->where($this->primary_key, $primary_value);
        $query = $this->db->get($this->table);
        return $query->row();
      }
    }
  }
  
  /**
   * Fetch many record based on conditions
   * 
   * @param array $conditions
   * @return array $records
   */  
  public function get_by($conditions,$sort = "asc",$offset = 0, $limit = 0, $order = "")
  {    
    $this->db->where($conditions);
    if ($order == "") {
      $this->db->order_by($this->primary_key, $sort);
    }else{
      $this->db->order_by($this->table.".order", "asc");
    }    
    if($limit > 0){      
     $this->db->limit($limit, $offset);
    }
    $query = $this->db->get($this->table);
    $query = $query->result();
    
    $this->db->reset_query();
    
    return $query;
  }

  public function get_in($in = null,$w = null){
    // cache certain parts of queries 
    $this->db->select("{$this->table}.*");
    if(!empty($in)){      
      if(is_array($in)){
        $this->db->where_in("{$this->table}.id", $in);
      }else{
        $this->db->where("{$this->table}.id",$in);
      }
    }   
    if(!empty($w)){
      $this->db->where($w);
    }
    $this->db->from($this->table);
    $query = $this->db->get();
    $result = $query->result();
    return $result;
  }
  /**
   * Fetch a records based on conditions
   * 
   * @param array $conditions
   * @return object $record
   */
  public function get_one_by($conditions,$sort = "asc")
  {
	
    $this->db->where($conditions);
    $this->db->order_by($this->primary_key, $sort);
    
	$query = $this->db->get($this->table);
	 
    return $query->row();
  }
  
  /**
   * Insert a new row into the table
   * 
     * @param array $data
     * @return int $insert_id
   */
  public function insert($data)
  {
    $this->db->insert($this->table,$data);
    return $this->db->insert_id();
  }
  
  /**
   * Insert multiple row into the table
   * 
     * @param array $data
     * @return array $insert_id
   */
  public function insert_batch($data)
  {
    $ids = array();
    foreach ($data as $key => $row)
    {
      $ids[] = $this->db->insert($this->table,$row);
    }
    return $ids;
  }
  
  /**
   * Insert into the table, update if DUPLICATE
   * 
     * @param array $data
     * @return array $insert_id
   */
  public function insert_unique_string($data)
  {
    foreach ($data as $key => $val)
    {
      $fields[] = $this->db->_escape_identifiers($key);
      $values[] = $this->db->escape($val);
      $valstr[] = end($fields)." = ".end($values);
    }
    $table = $this->db->_protect_identifiers($this->table, TRUE, NULL, FALSE);
    
    return "INSERT INTO ".$table." (".implode(', ', $fields).") VALUES (".implode(', ', $values).") ON DUPLICATE KEY UPDATE ".implode(', ', $valstr);
    
    $ids = array();
    foreach ($data as $key => $row)
    {
      $ids[] = $this->db->insert($this->table,$row);
    }
    return $ids;
  }
  
  /**
   * Update a/many record, base on primary_value(s)
   * 
     * @param int/array $primary_value
     * @param array $data
   */
  public function update($primary_value, $data)
  {
    if (is_array($primary_value)) {
      $this->db->where_in($this->primary_key, $primary_value);
    } else {
      $this->db->where($this->primary_key, $primary_value);
    }
    return $this->db->update($this->table, $data);
  }
  
  
  /**
   * Update record(s), base on conditions
   * 
     * @param array $conditions
     * @param array $data
   */
  public function update_by($conditions, $data)
  {
    $this->db->where($conditions);
    return $this->db->update($this->table, $data);
  }
  
  /**
   * Delete a/many record by primary_value(s)
   * 
     * @param int/array $primary_value
   */
  public function delete($primary_value)
  {
    if (is_array($primary_value)) {
      $this->db->where_in($this->primary_key, $primary_value);
    } else {
      $this->db->where($this->primary_key, $primary_value);
    }
    return $this->db->delete($this->table);
  }
  
  /**
   * Delete record by conditions
   * 
     * @param array $conditions
     * @param array $data
   */
  public function delete_by($conditions)
  {
    $this->db->where($conditions);
    return $this->db->delete($this->table);
  }
  
  /**
   * Truncates the table
   */
  public function truncate()
  {
    $result = $this->db->truncate($this->table);
    return $result;
  }
  
  /**
   * Fetch a count of rows based on an arbitrary WHERE call.
   */
  public function count_by($conditions)
  {
    $this->db->where($conditions);
    return $this->db->count_all_results($this->table);
  }
    
    public function count_all()
  {
        return $this->db->count_all($this->table);
  }
    
  /**
   * Getter for the table name
   */
  public function get_table()
  {
    return $this->table;
  }
  
  /**
   * Getter for the primary_key name
   */
  public function get_primary_key()
  {
    return $this->primary_key;
  }
}
