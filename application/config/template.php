<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');

$config['template_name']  = "nhocru";

$config['image_default'] = array(
							 'id'         => 'image_default',	
							 'name'         => 'image',
							 'dir'          => ROOT_DIR.'upload/',
							 'dirweb'       => 'news/catalogs',
							 'watermark'    => FALSE,
							 'thumb' 		=> FALSE,
							 'width' 	    => 1024,
							 'height'	    => 768,
							 'width_thumb'  => 800,
							 'height_thumb' => 600,
							 'width_min'    => 260,
							 'height_min'   => 195							 
							 );												
$config['image_page'] = array(
							 'id'           => 'image_page',
							 'name'         => 'image',
							 'dir'          => ROOT_DIR.'upload/page/post',
							 'dirweb'       => 'page/post',
							 'watermark'    => FALSE,
							 'thumb' 		=> FALSE,
							 'width' 	    => 960,
							 'height'	    => 640,
							 'width_thumb'  => 450,
							 'height_thumb' => 300,
							 'width_min'    => 200,
							 'height_min'   => 133							 
							 );								 
$config['image_page_catalogs'] = array(
							 'id'           => 'image_page_catalogs',
							 'name'         => 'image',
							 'dir'          => ROOT_DIR.'upload/page/catalogs',
							 'dirweb'       => 'page/catalogs',
							 'watermark'    => FALSE,
							 'thumb' 		=> FALSE,
							 'width' 	    => 960,
							 'height'	    => 640,
							 'width_thumb'  => 450,
							 'height_thumb' => 300,
							 'width_min'    => 200,
							 'height_min'   => 133							 
							 );		
$config['image_wysiwyg'] = array(
							 'id'           => 'image_wysiwyg',	
							 'name'         => 'file',
							 'dir'          => ROOT_DIR.'upload/dataimg',
							 'dirweb'       => 'dataimg',
							 'watermark'    => FALSE,
							 'thumb' 		=> TRUE,
							 'width' 	    => 960,
							 'height'	    => 640,
							 'width_thumb'  => 450,
							 'height_thumb' => 300,
							 'width_min'    => 200,
							 'height_min'   => 133							 
							 );								 
$config['image_ads'] = array(
							 'id'           => 'image_ads',	
							 'name'         => 'image',
							 'dir'          => ROOT_DIR.'upload/ads',
							 'dirweb'       => 'ads',
							 'watermark'    => FALSE,
							 'thumb' 		=> FALSE,
							 'width' 	    => 1920,
							 'height'	    => 780,
							 'width_thumb'  => 450,
							 'height_thumb' => 300,
							 'width_min'    => 200,
							 'height_min'   => 133							 
							 );
$config['image_products_catalogs'] = array(
							 'id'         => 'image_products_catalogs',	
							 'name'         => 'image',
							 'dir'          => ROOT_DIR.'upload/products/catalogs',
							 'dirweb'       => 'products/catalogs',
							 'watermark'    => FALSE,
							 'thumb' 		=> FALSE,
							 'width' 	    => 1024,
							 'height'	    => 640,
							 'width_thumb'  => 450,
							 'height_thumb' => 300,
							 'width_min'    => 200,
							 'height_min'   => 133							 
							 );
$config['image_products_trademark'] = array(
							 'id'           => 'image_products_trademark',	
							 'name'         => 'image',
							 'dir'          => ROOT_DIR.'upload/products/trademark',
							 'dirweb'       => 'products/trademark',
							 'watermark'    => FALSE,
							 'thumb' 		=> FALSE,
							 'width' 	    => 1024,
							 'height'	    => 640,
							 'width_thumb'  => 450,
							 'height_thumb' => 300,
							 'width_min'    => 200,
							 'height_min'   => 133							 
							 );		
$config['image_products_collection'] = array(
							 'id'           => 'image_products_collection',	
							 'name'         => 'image',
							 'dir'          => ROOT_DIR.'upload/products/collection',
							 'dirweb'       => 'products/collection',
							 'watermark'    => FALSE,
							 'thumb' 		=> FALSE,
							 'width' 	    => 1024,
							 'height'	    => 640,
							 'width_thumb'  => 450,
							 'height_thumb' => 300,
							 'width_min'    => 200,
							 'height_min'   => 133							 
							 );									 					 
$config['image_products'] = array(
							 'id'           => 'image_products',	
							 'name'         => 'image',
							 'dir'          => ROOT_DIR.'upload/products/post',
							 'dirweb'       => 'products/post',
							 'watermark'    => FALSE,
							 'thumb' 		=> TRUE,
							 'width' 	    => 1024,
							 'height'	    => 1024,
							 'width_thumb'  => 660,
							 'height_thumb' => 660,
							 'width_min'    => 255,
							 'height_min'   => 255							 
							 );		
$config['products_attrib'] = array(
							 'id'           => 'products_attrib',	
							 'name'         => 'image',
							 'dir'          => ROOT_DIR.'upload/products/attrib',
							 'dirweb'       => 'products/attrib',
							 'watermark'    => FALSE,
							 'thumb' 		=> TRUE,
							 'width' 	    => 1024,
							 'height'	    => 1024,
							 'width_thumb'  => 660,
							 'height_thumb' => 660,
							 'width_min'    => 255,
							 'height_min'   => 255							 
							 );	
$config['image_news'] = array(
							 'id'         => 'image_news',	
							 'name'         => 'image',
							 'dir'          => ROOT_DIR.'upload/news/post',
							 'dirweb'       => 'news/post',
							 'watermark'    => FALSE,
							 'thumb' 		=> FALSE,
							 'width' 	    => 1024,
							 'height'	    => 768,
							 'width_thumb'  => 800,
							 'height_thumb' => 600,
							 'width_min'    => 260,
							 'height_min'   => 195							 
							 );							 
$config['image_news_catalogs'] = array(
							 'id'         => 'image_news_catalogs',	
							 'name'         => 'image',
							 'dir'          => ROOT_DIR.'upload/news/catalogs',
							 'dirweb'       => 'news/catalogs',
							 'watermark'    => FALSE,
							 'thumb' 		=> FALSE,
							 'width' 	    => 1024,
							 'height'	    => 768,
							 'width_thumb'  => 800,
							 'height_thumb' => 600,
							 'width_min'    => 260,
							 'height_min'   => 195							 
							 );		         
$config['image_attrib_check'] = array(
							 'id'         => 'image_attrib_check',	
							 'name'         => 'image',
							 'dir'          => ROOT_DIR.'upload/attib_check',
							 'dirweb'       => 'attib_check',
							 'watermark'    => FALSE,
							 'thumb' 		=> FALSE,
							 'width' 	    => 1024,
							 'height'	    => 640,
							 'width_thumb'  => 450,
							 'height_thumb' => 300,
							 'width_min'    => 200,
							 'height_min'   => 133							 
							 );							 
							 
/* Lưu vị trí hiện thị block trên template */
$config["block"]["Home_Slider"] = array(
							"note"     => "Hiển Thị Banner Trình Chiếu",
							"stacking" => FALSE,
							"title" => "",
							);
$config["block"]["Catalog_Product"] = array(
							"note"     => "Danh Mục Sản Phẩm",
							"stacking" => FALSE,
							"title" => "",
							);
$config["block"]["Home_Ads1"] = array(
							"note"     => "Home Ads 1",
							"stacking" => FALSE,
							"title" => "",
							);
$config["block"]["Home_Ads2"] = array(
							"note"     => "Home Ads 2",
							"stacking" => FALSE,
							"title" => "",
							);							
/* 
khai báo Module của Block của soure 
module block trong application\widgets, key trung với tên file 
*/
$config["block_module"] = array(
							'module_ads' => 'Hiển Thị Ads',
							'module_slider' => 'Hiển Thị Banner Trình Chiếu',
							'module_bttkd' => 'Show Danh Mục Bánh',
							);

/* End of file template.php */
/* Location: ./application/config/template.php */
