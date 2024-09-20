<?php
 class REQUEST{
    public array $request;

    public function __construct()
        
    {
        $this->request = $_REQUEST;
    
    }
    public function has($key):bool{
        return !empty($this->request[$key]);
    }
    public function get($key){
        return $this->has($key)? $this->request[$key]: null;
    }
    public function equal($key,$value){
        return $this->get($key)===$value;
    }
    public function hasfile( $key) : bool {
        return ! empty($_FILES[$key]);
    }

    public function getfile( $key){
        return $this->hasfile($key)? $_FILES[$key]: null;
    }

 }

?>