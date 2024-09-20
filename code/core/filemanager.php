<?php
 class FILEMANAGER{
   public function __construct()
    {
        
    }
    public function store($file): string|bool {
        $from = $file["tmp_name"];
        $new_name=time().".".$this->getfileextension($file);
        $to = __DIR__."/../uploads/" .$new_name;

       return(move_uploaded_file($from,$to))? $new_name: false;
      
       
       
    }
    public function getfileextension($file) : string {
        return $extension=explode(".",$file["name"])[1];
    }
   

    
 }

?>