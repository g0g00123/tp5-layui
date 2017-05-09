<?php
namespace app\user\controller;
use think\Controller;

class Base extends Controller
{
	protected function _initialize()
    {
    	$origin = isset($_SERVER['HTTP_ORIGIN'])? $_SERVER['HTTP_ORIGIN'] : '';  
  
		$allow_origin = array(  
		    'http://localhost:8080',  
		    'http://www.client2.com'  
		);  
		  
		if(in_array($origin, $allow_origin)){  
		    header('Access-Control-Allow-Origin:'.$origin);  
		    header('Access-Control-Allow-Methods:*');  
		    header('Access-Control-Allow-Headers:accept,content-type');  
		}  
    }
}