<?php 
require_once __DIR__."/../core/server.php"; 
require_once __DIR__."/../core/request.php"; 
require_once __DIR__."/../core/filemanager.php"; 


function SERVER(): ?SERVER{
    return new SERVER();
}   
function REQUEST(): ?REQUEST{
    return new REQUEST();
}
function filemanager(): ?FILEMANAGER{
    return new FILEMANAGER();
}


?>