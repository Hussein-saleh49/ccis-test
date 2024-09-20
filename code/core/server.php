<?php

class SERVER{
    public array $server ;

    public function __construct()
    {
        $this->server = $_SERVER;
    
    }
    public function ispostrequest(): bool{
        return $this->server["REQUEST_METHOD"]==="POST";

    }

    public function isgetrequest(): bool{
        return $this->server["REQUEST_METHOD"]==="GET";

    }
}


?>