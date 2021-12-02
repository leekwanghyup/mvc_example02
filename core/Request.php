<?php 
namespace app\core;

class Request
{
    
    public function getPath()
    {
        $path = $_SERVER['REQUEST_URI']; //리퀘스트
        $position = strpos($path, '?');
        if($position === false){
            return $path;    
        }
        return substr($path,0, $position);
    }
    
    public function method()
    {
        return strtolower($_SERVER['REQUEST_METHOD']); //리퀘스트
    }
    
    public function isPost()
    {
        return $this->method() === 'post';
    }
    
    public function isGet()
    {
        return $this->method() === 'get';
    }

    public function getBody()
    {
        $body = [];
        if($this->isPost()){
            foreach ($_POST as $key => $value ){
                $body[$key] = filter_input(INPUT_POST, $key,FILTER_SANITIZE_SPECIAL_CHARS);
            }
        }
        if($this->isGet()){
            foreach ($_GET as $key => $value ){
                $body[$key] = filter_input(INPUT_GET, $key,FILTER_SANITIZE_SPECIAL_CHARS);
            }
        }
        return $body; 
    }

}