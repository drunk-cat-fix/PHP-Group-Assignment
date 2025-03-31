<?php
include_once "../Utilities/Connection.php";

$conn = getConnection();
try{
    var_dump($conn);
}catch(Exception $e){
    echo $e->getMessage();
}