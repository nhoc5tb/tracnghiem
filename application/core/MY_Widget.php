<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');
//http://freetuts.net/tutorial/tu-tao-thu-vien-load-widget-trong-codeigniter-p16.html
/*
echo $this->load->widget('header');
$title = 'Hướng dẫn tạo widget';
$content = 'Tự tạo widget cho riêng mình';
echo $this->load->widget('header', array($title, $content));
*/
class MY_Widget 
{
	function __get($key)
	{
		$CI =& get_instance();
		return $CI->$key;
	}
        
	function __set($key, $val)
        {
                $CI =& get_instance();
                if (isset($CI->$key))
                    $CI->$key = $val;
                else
                    $this->$key = $val;
	}
}
?>
