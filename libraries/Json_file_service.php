<?php   if (!defined('BASEPATH')) exit('No direct script access allowed');

class Json_file_service
{
    protected $CI;
    
    protected $params;
    protected $path;

    public function __construct($params = [])
    {
        $this->CI =& get_instance();
        $this->params = $params;
        $this->path = $params['path'];
    }

	public function upsert($fileName, $newData){
		$file = $this->path.$fileName.'.json';
		$oldData = array();
		
		if(file_exists($file)){
			$oldData = (array) json_decode(file_get_contents($file));
		}
		
		$freshData = json_encode(array_merge($oldData, $newData));
		
		file_put_contents($file, $freshData);
		
		return json_decode(file_get_contents($file));
	}	
	
	public function retrieve($fileName){
		$file = $this->path.$fileName.'.json';
		if(file_exists ($file)){
			return json_decode(file_get_contents($file));
		}
		else{
			return [];
		}
	}	

}